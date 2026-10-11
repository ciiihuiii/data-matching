<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use App\Exports\MatchingExport;
use Maatwebsite\Excel\Facades\Excel;

class MatchingSessionController extends Controller
{
    /**
     * ==========================================
     * HALAMAN UTAMA
     * ==========================================
     */
    public function create()
    {
        return view('matching.create');
    }


    /**
     * ==========================================
     * UPLOAD SUMBER 1 DAN SUMBER 2
     * ==========================================
     */
    public function upload(Request $request)
    {
        $request->validate([
            'source_1' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:10240'
            ],

            'source_2' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:10240'
            ],
        ], [
            'source_1.required' =>
                'Silakan pilih file untuk Sumber 1.',

            'source_2.required' =>
                'Silakan pilih file untuk Sumber 2.',

            'source_1.mimes' =>
                'Sumber 1 harus berupa file Excel atau CSV.',

            'source_2.mimes' =>
                'Sumber 2 harus berupa file Excel atau CSV.',

            'source_1.max' =>
                'Ukuran file Sumber 1 maksimal 10 MB.',

            'source_2.max' =>
                'Ukuran file Sumber 2 maksimal 10 MB.',
        ]);


        $source1 = $request->file('source_1');
        $source2 = $request->file('source_2');


        try {

            /*
             * ==========================================
             * BACA SUMBER 1
             * ==========================================
             */
            $spreadsheet1 = IOFactory::load(
                $source1->getRealPath()
            );


            /*
             * ==========================================
             * BACA SUMBER 2
             * ==========================================
             */
            $spreadsheet2 = IOFactory::load(
                $source2->getRealPath()
            );


            /*
             * ==========================================
             * SIMPAN FILE KE STORAGE
             * ==========================================
             */
            $source1Path =
                $source1->store('matching');

            $source2Path =
                $source2->store('matching');


            /*
             * ==========================================
             * AMBIL NAMA SHEET
             * ==========================================
             */
            $source1Sheets =
                $spreadsheet1->getSheetNames();

            $source2Sheets =
                $spreadsheet2->getSheetNames();


            /*
             * ==========================================
             * SIMPAN INFORMASI SUMBER KE SESSION
             * ==========================================
             */
            session([
                'matching.source_1' => [
                    'name' =>
                        $source1->getClientOriginalName(),

                    'path' =>
                        $source1Path,

                    'sheets' =>
                        $source1Sheets,
                ],

                'matching.source_2' => [
                    'name' =>
                        $source2->getClientOriginalName(),

                    'path' =>
                        $source2Path,

                    'sheets' =>
                        $source2Sheets,
                ],
            ]);


            /*
             * ==========================================
             * HAPUS DATA PROSES SEBELUMNYA
             * ==========================================
             */
            session()->forget([
                'matching.selected',
                'matching.keys',
                'matching.columns',
                'matching.result',
            ]);


            /*
             * ==========================================
             * TAMPILKAN PEMILIHAN SHEET
             * ==========================================
             */
            return view(
                'matching.select-sheets',
                [
                    'source1' => [
                        'name' =>
                            $source1->getClientOriginalName(),

                        'sheets' =>
                            $source1Sheets,
                    ],

                    'source2' => [
                        'name' =>
                            $source2->getClientOriginalName(),

                        'sheets' =>
                            $source2Sheets,
                    ],
                ]
            );

        } catch (\Throwable $e) {

            return back()->withErrors([
                'upload' =>
                    'File tidak dapat dibaca. ' .
                    'Pastikan file Excel/CSV tidak rusak.'
            ]);
        }
    }


    /**
     * ==========================================
     * PEMILIHAN SHEET
     * ==========================================
     */
    public function selectSheets(Request $request)
    {
        $request->validate([
            'source_1_sheet' =>
                'required|string',

            'source_2_sheet' =>
                'required|string',
        ], [
            'source_1_sheet.required' =>
                'Silakan pilih sheet Sumber 1.',

            'source_2_sheet.required' =>
                'Silakan pilih sheet Sumber 2.',
        ]);


        /*
         * ==========================================
         * AMBIL DATA SUMBER DARI SESSION
         * ==========================================
         */
        $source1 =
            session('matching.source_1');

        $source2 =
            session('matching.source_2');


        if (!$source1 || !$source2) {

            return redirect()
                ->route('matching.create')
                ->withErrors([
                    'upload' =>
                        'Data upload sudah tidak tersedia. Silakan upload kembali.'
                ]);
        }


        $source1Sheets =
            $source1['sheets'];

        $source2Sheets =
            $source2['sheets'];


        /*
         * ==========================================
         * SUMBER 1
         * ==========================================
         */
        if ($request->source_1_sheet === '__ALL__') {

            $selectedSheets1 =
                $source1Sheets;

            $allSheets1 = true;

        } else {

            if (
                !in_array(
                    $request->source_1_sheet,
                    $source1Sheets,
                    true
                )
            ) {

                return back()->withErrors([
                    'source_1_sheet' =>
                        'Sheet Sumber 1 tidak ditemukan.'
                ]);
            }


            $selectedSheets1 = [
                $request->source_1_sheet
            ];

            $allSheets1 = false;
        }


        /*
         * ==========================================
         * SUMBER 2
         * ==========================================
         */
        if ($request->source_2_sheet === '__ALL__') {

            $selectedSheets2 =
                $source2Sheets;

            $allSheets2 = true;

        } else {

            if (
                !in_array(
                    $request->source_2_sheet,
                    $source2Sheets,
                    true
                )
            ) {

                return back()->withErrors([
                    'source_2_sheet' =>
                        'Sheet Sumber 2 tidak ditemukan.'
                ]);
            }


            $selectedSheets2 = [
                $request->source_2_sheet
            ];

            $allSheets2 = false;
        }


        /*
         * ==========================================
         * SIMPAN PILIHAN SHEET
         * ==========================================
         */
        session([
            'matching.selected' => [

                'source_1' => [

                    'all_sheets' =>
                        $allSheets1,

                    'sheets' =>
                        $selectedSheets1,
                ],

                'source_2' => [

                    'all_sheets' =>
                        $allSheets2,

                    'sheets' =>
                        $selectedSheets2,
                ],

            ],
        ]);


        /*
         * ==========================================
         * HAPUS HASIL PROSES LAMA
         * ==========================================
         */
        session()->forget([
            'matching.keys',
            'matching.columns',
            'matching.result',
        ]);


        /*
         * ==========================================
         * LANJUT KE PEMILIHAN KUNCI
         * ==========================================
         */
        return redirect()
            ->route('matching.select-keys')
            ->with(
                'success',
                'Data berhasil disimpan'
            );
    }


    /**
     * ==========================================
     * HALAMAN PEMILIHAN KUNCI PATOKAN
     * ==========================================
     */
    public function selectKeys()
    {
        $source1 =
            session('matching.source_1');

        $source2 =
            session('matching.source_2');

        $selected =
            session('matching.selected');


        if (
            !$source1 ||
            !$source2 ||
            !$selected
        ) {

            return redirect()
                ->route('matching.create')
                ->withErrors([
                    'upload' =>
                        'Data matching sudah tidak tersedia. Silakan upload kembali.'
                ]);
        }


        /*
         * ==========================================
         * SHEET YANG DIPILIH
         * ==========================================
         */
        $source1Sheets =
            $selected['source_1']['sheets'] ?? [];

        $source2Sheets =
            $selected['source_2']['sheets'] ?? [];


        if (
            empty($source1Sheets) ||
            empty($source2Sheets)
        ) {

            return redirect()
                ->route('matching.create')
                ->withErrors([
                    'upload' =>
                        'Sheet belum dipilih. Silakan upload dan pilih sheet kembali.'
                ]);
        }


        try {

            /*
             * ==========================================
             * KOLOM SUMBER 1
             * ==========================================
             */
            $source1Columns =
                $this->getColumnsFromSheets(
                    $source1['path'],
                    $source1Sheets
                );


            /*
             * ==========================================
             * KOLOM SUMBER 2
             * ==========================================
             */
            $source2Columns =
                $this->getColumnsFromSheets(
                    $source2['path'],
                    $source2Sheets
                );

        } catch (\Throwable $e) {

            return redirect()
                ->route('matching.create')
                ->withErrors([
                    'upload' =>
                        'Kolom file tidak dapat dibaca. ' .
                        $e->getMessage()
                ]);
        }


        return view(
            'matching.select-keys',
            [

                'source1' =>
                    $source1,

                'source2' =>
                    $source2,

                'source1Sheets' =>
                    $source1Sheets,

                'source2Sheets' =>
                    $source2Sheets,

                'source1Columns' =>
                    $source1Columns,

                'source2Columns' =>
                    $source2Columns,

                'allSheets1' =>
                    $selected['source_1']['all_sheets'] ?? false,

                'allSheets2' =>
                    $selected['source_2']['all_sheets'] ?? false,
            ]
        );
    }


    /**
     * ==========================================
     * MENYIMPAN KUNCI PATOKAN
     * ==========================================
     */
    public function saveKeys(Request $request)
    {
        $source1 =
            session('matching.source_1');

        $source2 =
            session('matching.source_2');

        $selected =
            session('matching.selected');


        if (
            !$source1 ||
            !$source2 ||
            !$selected
        ) {

            return redirect()
                ->route('matching.create')
                ->withErrors([
                    'upload' =>
                        'Data matching sudah tidak tersedia. Silakan upload kembali.'
                ]);
        }


        /*
        * ==========================================
        * VALIDASI INPUT
        * ==========================================
        */

        $request->validate([
            'source_1_key' =>
                'required|string',

            'source_2_key' =>
                'required|string',

        ], [

            'source_1_key.required' =>
                'Silakan pilih kunci patokan Sumber 1.',

            'source_2_key.required' =>
                'Silakan pilih kunci patokan Sumber 2.',
        ]);


        $source1Sheets =
            $selected['source_1']['sheets'] ?? [];

        $source2Sheets =
            $selected['source_2']['sheets'] ?? [];


        $source1Key =
            trim(
                (string) $request->source_1_key
            );

        $source2Key =
            trim(
                (string) $request->source_2_key
            );

        $skippedSource1Sheets = [];
        $skippedSource2Sheets = [];

        /*
        * ==========================================
        * AMBIL KOLOM YANG TERSEDIA
        * ==========================================
        */

        try {

            $source1Columns =
                $this->getColumnsFromSheets(
                    $source1['path'],
                    $source1Sheets
                );

            $source2Columns =
                $this->getColumnsFromSheets(
                    $source2['path'],
                    $source2Sheets
                );

        } catch (\Throwable $e) {

            return back()
                ->withInput()
                ->with(
                    'key_error',
                    'Kolom tidak dapat dibaca.'
                );
        }

        /*
        * ==========================================
        * RESOLVE KUNCI SUMBER 1 PER SHEET
        * ==========================================
        */

        $skippedSource1Sheets = [];
        $source1KeyHeaders = [];

        foreach (
            $source1Columns
            as $sheetName => $columns
        ) {

            $resolvedKey =
                $this->resolveKeyHeader(
                    $source1Key,
                    $columns
                );

            /*
            * Jika tidak ditemukan,
            * sheet dilewati.
            */
            if ($resolvedKey === null) {

                if (
                    $selected['source_1']['all_sheets'] ?? false
                ) {

                    $skippedSource1Sheets[] =
                        $sheetName;

                    continue;
                }

                return back()
                    ->withInput()
                    ->with(
                        'key_error',
                        'Kunci patokan Sumber 1 tidak ditemukan.'
                    );
            }

            /*
            * Simpan nama header sebenarnya
            * untuk sheet tersebut.
            */
            $source1KeyHeaders[$sheetName] =
                $resolvedKey;
        }

        /*
        * ==========================================
        * RESOLVE KUNCI SUMBER 2 PER SHEET
        * ==========================================
        */

        $skippedSource2Sheets = [];
        $source2KeyHeaders = [];

        foreach (
            $source2Columns
            as $sheetName => $columns
        ) {

            $resolvedKey =
                $this->resolveKeyHeader(
                    $source2Key,
                    $columns
                );

            /*
            * Jika tidak ditemukan,
            * sheet dilewati.
            */
            if ($resolvedKey === null) {

                if (
                    $selected['source_2']['all_sheets'] ?? false
                ) {

                    $skippedSource2Sheets[] =
                        $sheetName;

                    continue;
                }

                return back()
                    ->withInput()
                    ->with(
                        'key_error',
                        'Kunci patokan Sumber 2 tidak ditemukan.'
                    );
            }

            /*
            * Simpan nama header sebenarnya
            * untuk sheet tersebut.
            */
            $source2KeyHeaders[$sheetName] =
                $resolvedKey;
        }

                /*
        * ==========================================
        * HAPUS SHEET YANG TIDAK MEMILIKI KUNCI
        * ==========================================
        */

        if (
            $selected['source_1']['all_sheets'] ?? false
        ) {

            foreach ($skippedSource1Sheets as $sheetName) {

                unset($source1Columns[$sheetName]);
            }

            $source1Sheets =
                array_values(
                    array_diff(
                        $source1Sheets,
                        $skippedSource1Sheets
                    )
                );
        }


        if (
            $selected['source_2']['all_sheets'] ?? false
        ) {

            foreach ($skippedSource2Sheets as $sheetName) {

                unset($source2Columns[$sheetName]);
            }

            $source2Sheets =
                array_values(
                    array_diff(
                        $source2Sheets,
                        $skippedSource2Sheets
                    )
                );
        }

        /*
        * ==========================================
        * CEK DUPLIKAT KUNCI REFERENSI PER SHEET
        * ==========================================
        *
        * Aturan:
        *
        * 1 kali dalam satu sheet  = BOLEH
        * 2 kali dalam satu sheet  = BOLEH
        * 3 kali atau lebih        = TOLAK
        *
        * Kunci yang sama pada sheet
        * yang berbeda tetap diperbolehkan.
        * ==========================================
        */

        try {

            /*
            * ==========================================
            * LOAD SUMBER 1
            * ==========================================
            */

            $fullPath1 =
                Storage::path(
                    $source1['path']
                );

            if (!file_exists($fullPath1)) {

                throw new \Exception(
                    'File Sumber 1 tidak ditemukan.'
                );
            }

            $spreadsheet1 =
                IOFactory::load(
                    $fullPath1
                );


            /*
            * ==========================================
            * LOAD SUMBER 2
            * ==========================================
            */

            $fullPath2 =
                Storage::path(
                    $source2['path']
                );

            if (!file_exists($fullPath2)) {

                throw new \Exception(
                    'File Sumber 2 tidak ditemukan.'
                );
            }

            $spreadsheet2 =
                IOFactory::load(
                    $fullPath2
                );


            /*
            * ==========================================
            * BACA DATA SUMBER 1
            * ==========================================
            */

            $dataSource1 =
                $this->readDataFromSheets(
                    $spreadsheet1,
                    $source1Sheets
                );


            /*
            * ==========================================
            * BACA DATA SUMBER 2
            * ==========================================
            */

            $dataSource2 =
                $this->readDataFromSheets(
                    $spreadsheet2,
                    $source2Sheets
                );


            /*
            * ==========================================
            * BATAS DUPLIKAT PER SHEET
            * ==========================================
            */

            $maximumOccurrencesPerSheet = 2;


            /*
            * ==========================================
            * CEK SUMBER 1
            * ==========================================
            */

            $countSource1PerSheet = [];


            foreach (
                $dataSource1
                as $item
            ) {

                $sheetName =
                    $item['_sheet'] ?? '';

                $actualKeyHeader =
                    $source1KeyHeaders[$sheetName]
                    ?? null;

                $value =
                    $actualKeyHeader !== null
                        ? ($item[$actualKeyHeader] ?? null)
                        : null;

                /*
                * Kunci kosong tidak dihitung.
                */

                if (
                    $value === null ||
                    trim((string) $value) === ''
                ) {
                    continue;
                }


                $normalizedKey =
                    $this->normalizeMatchValue(
                        $value
                    );


                if (
                    $normalizedKey === ''
                ) {
                    continue;
                }


                /*
                * Buat penghitung berdasarkan:
                *
                * Sheet
                *   └── Kunci
                */

                if (
                    !isset(
                        $countSource1PerSheet[$sheetName]
                    )
                ) {

                    $countSource1PerSheet[$sheetName] = [];
                }


                $countSource1PerSheet[$sheetName][$normalizedKey] =
                    (
                        $countSource1PerSheet[$sheetName][$normalizedKey]
                        ?? 0
                    ) + 1;


                /*
                * Jika kunci yang sama muncul
                * lebih dari 2 kali dalam SATU sheet,
                * hentikan proses.
                */

                if (
                    $countSource1PerSheet[$sheetName][$normalizedKey]
                    > $maximumOccurrencesPerSheet
                ) {

                    return back()
                        ->withInput()
                        ->with(
                            'key_error',
                            'pilihlah kunci yang unik'
                        );
                }
            }


            /*
            * ==========================================
            * CEK SUMBER 2
            * ==========================================
            */

            $countSource2PerSheet = [];


            foreach (
                $dataSource2
                as $item
            ) {

                $sheetName =
                    $item['_sheet'] ?? '';

                $actualKeyHeader =
                    $source2KeyHeaders[$sheetName]
                    ?? null;

                $value =
                    $actualKeyHeader !== null
                        ? ($item[$actualKeyHeader] ?? null)
                        : null;

                /*
                * Kunci kosong tidak dihitung.
                */

                if (
                    $value === null ||
                    trim((string) $value) === ''
                ) {
                    continue;
                }


                $normalizedKey =
                    $this->normalizeMatchValue(
                        $value
                    );


                if (
                    $normalizedKey === ''
                ) {
                    continue;
                }


                /*
                * Buat penghitung berdasarkan:
                *
                * Sheet
                *   └── Kunci
                */

                if (
                    !isset(
                        $countSource2PerSheet[$sheetName]
                    )
                ) {

                    $countSource2PerSheet[$sheetName] = [];
                }


                $countSource2PerSheet[$sheetName][$normalizedKey] =
                    (
                        $countSource2PerSheet[$sheetName][$normalizedKey]
                        ?? 0
                    ) + 1;


                /*
                * Jika kunci yang sama muncul
                * lebih dari 2 kali dalam SATU sheet,
                * hentikan proses.
                */

                if (
                    $countSource2PerSheet[$sheetName][$normalizedKey]
                    > $maximumOccurrencesPerSheet
                ) {

                    return back()
                        ->withInput()
                        ->with(
                            'key_error',
                            'pilihlah kunci yang unik'
                        );
                }
            }


        } catch (\Throwable $e) {

            return back()
                ->withInput()
                ->with(
                    'key_error',
                    'Data tidak dapat diperiksa. Silakan periksa kembali file yang dipilih.'
                );
        }


        /*
        * ==========================================
        * SIMPAN KUNCI REFERENSI
        * ==========================================
        */

        session([
            'matching.keys' => [

                'source_1' =>
                    $source1Key,

                'source_2' =>
                    $source2Key,
            ],
        ]);

        session([
            'matching.key_headers' => [

                'source_1' =>
                    $source1KeyHeaders,

                'source_2' =>
                    $source2KeyHeaders,
            ],
        ]);

        $selected['source_1']['sheets'] =
            $source1Sheets;

        $selected['source_2']['sheets'] =
            $source2Sheets;

        session([
            'matching.selected' =>
                $selected,
        ]);


        /*
        * ==========================================
        * HAPUS HASIL MATCHING LAMA
        * ==========================================
        */

        session()->forget(
            'matching.result'
        );


        /*
        * ==========================================
        * LANGSUNG KE PEMILIHAN KOLOM
        * ==========================================
        */

        $skippedMessages = [];

        if (count($skippedSource1Sheets) > 0) {
            $skippedMessages[] =
                'Sumber 1: ' .
                count($skippedSource1Sheets) .
                ' sheet dilewati karena tidak memiliki kolom kunci referensi "' .
                $source1Key .
                '".';
        }

        if (count($skippedSource2Sheets) > 0) {
            $skippedMessages[] =
                'Sumber 2: ' .
                count($skippedSource2Sheets) .
                ' sheet dilewati karena tidak memiliki kolom kunci referensi "' .
                $source2Key .
                '".';
        }

        return redirect()
            ->route('matching.select-columns')
            ->with(
                'success',
                'kunci referensi tersimpan'
            )
            ->with(
                'skipped_sheets',
                $skippedMessages
            );
    }
    /**
     * ==========================================
     * HALAMAN PEMILIHAN KOLOM
     * ==========================================
     */
    public function selectColumns()
    {
        $source1 =
            session('matching.source_1');

        $source2 =
            session('matching.source_2');

        $selected =
            session('matching.selected');

        $keys =
            session('matching.keys');


        if (
            !$source1 ||
            !$source2 ||
            !$selected ||
            !$keys
        ) {

            return redirect()
                ->route('matching.create')
                ->withErrors([
                    'upload' =>
                        'Data matching belum lengkap. Silakan ulangi proses.'
                ]);
        }


        $source1Sheets =
            $selected['source_1']['sheets'] ?? [];

        $source2Sheets =
            $selected['source_2']['sheets'] ?? [];


        try {

            $source1Columns =
                $this->getColumnsFromSheets(
                    $source1['path'],
                    $source1Sheets
                );

            $source2Columns =
                $this->getColumnsFromSheets(
                    $source2['path'],
                    $source2Sheets
                );

        } catch (\Throwable $e) {

            return redirect()
                ->route('matching.create')
                ->withErrors([
                    'upload' =>
                        'Kolom file tidak dapat dibaca.'
                ]);
        }


        return view(
            'matching.select-columns',
            [

                'source1' =>
                    $source1,

                'source2' =>
                    $source2,

                'source1Sheets' =>
                    $source1Sheets,

                'source2Sheets' =>
                    $source2Sheets,

                'source1Columns' =>
                    $source1Columns,

                'source2Columns' =>
                    $source2Columns,

                'source1Key' =>
                    $keys['source_1'] ?? null,

                'source2Key' =>
                    $keys['source_2'] ?? null,

                'allSheets1' =>
                    $selected['source_1']['all_sheets'] ?? false,

                'allSheets2' =>
                    $selected['source_2']['all_sheets'] ?? false,
            ]
        );
    }


    /**
     * ==========================================
     * MENYIMPAN KOLOM YANG AKAN DIBANDINGKAN
     * ==========================================
     */
    public function saveColumns(Request $request)
    {
        $source1 =
            session('matching.source_1');

        $source2 =
            session('matching.source_2');

        $selected =
            session('matching.selected');

        $keys =
            session('matching.keys');


        if (
            !$source1 ||
            !$source2 ||
            !$selected ||
            !$keys
        ) {

            return redirect()
                ->route('matching.create')
                ->withErrors([
                    'upload' =>
                        'Data matching belum lengkap. Silakan ulangi proses.'
                ]);
        }


        /*
         * ==========================================
         * VALIDASI INPUT
         * ==========================================
         */
        $request->validate([
            'source_1_columns' =>
                'required|array|min:1',

            'source_2_columns' =>
                'required|array|min:1',

        ], [

            'source_1_columns.required' =>
                'Silakan pilih minimal satu kolom dari Sumber 1.',

            'source_2_columns.required' =>
                'Silakan pilih minimal satu kolom dari Sumber 2.',
        ]);


        $source1Columns =
            $request->input(
                'source_1_columns',
                []
            );

        $source2Columns =
            $request->input(
                'source_2_columns',
                []
            );


        /*
         * ==========================================
         * AMBIL KOLOM YANG TERSEDIA
         * ==========================================
         */
        try {

            $availableColumns1 =
                $this->getColumnsFromSheets(
                    $source1['path'],
                    $selected['source_1']['sheets']
                );

            $availableColumns2 =
                $this->getColumnsFromSheets(
                    $source2['path'],
                    $selected['source_2']['sheets']
                );

        } catch (\Throwable $e) {

            return redirect()
                ->route('matching.create')
                ->withErrors([
                    'upload' =>
                        'Kolom file tidak dapat dibaca.'
                ]);
        }


        /*
         * ==========================================
         * VALIDASI FORMAT DAN NAMA KOLOM
         *
         * Format checkbox:
         *
         * Sheet|Kolom
         * ==========================================
         */
        $validateSelectedColumn =
            function (
                $selectedColumn,
                $availableColumns,
                $sourceLabel
            ) {

                $parts =
                    explode(
                        '|',
                        $selectedColumn,
                        2
                    );


                /*
                 * Jika format Sheet|Kolom
                 */
                if (count($parts) === 2) {

                    $sheetName =
                        $parts[0];

                    $columnName =
                        $parts[1];


                    if (
                        !isset(
                            $availableColumns[$sheetName]
                        )
                    ) {

                        return "Sheet '{$sheetName}' tidak ditemukan pada {$sourceLabel}.";
                    }


                    if (
                        !in_array(
                            $columnName,
                            $availableColumns[$sheetName],
                            true
                        )
                    ) {

                        return "Kolom '{$columnName}' tidak ditemukan pada sheet '{$sheetName}' {$sourceLabel}.";
                    }


                    return true;
                }


                /*
                 * Dukungan untuk format lama:
                 *
                 * hanya nama kolom
                 */
                $columnName =
                    $parts[0];

                $found = false;

                foreach (
                    $availableColumns
                    as $columns
                ) {

                    if (
                        in_array(
                            $columnName,
                            $columns,
                            true
                        )
                    ) {

                        $found = true;

                        break;
                    }
                }


                if (!$found) {

                    return "Kolom '{$columnName}' tidak ditemukan pada {$sourceLabel}.";
                }


                return true;
            };


        /*
         * ==========================================
         * VALIDASI SUMBER 1
         * ==========================================
         */
        foreach (
            $source1Columns
            as $selectedColumn
        ) {

            $validation =
                $validateSelectedColumn(
                    $selectedColumn,
                    $availableColumns1,
                    'Sumber 1'
                );


            if ($validation !== true) {

                return back()
                    ->withErrors([
                        'source_1_columns' =>
                            $validation
                    ])
                    ->withInput();
            }
        }


        /*
         * ==========================================
         * VALIDASI SUMBER 2
         * ==========================================
         */
        foreach (
            $source2Columns
            as $selectedColumn
        ) {

            $validation =
                $validateSelectedColumn(
                    $selectedColumn,
                    $availableColumns2,
                    'Sumber 2'
                );


            if ($validation !== true) {

                return back()
                    ->withErrors([
                        'source_2_columns' =>
                            $validation
                    ])
                    ->withInput();
            }
        }


        /*
         * ==========================================
         * SIMPAN PILIHAN KOLOM
         * ==========================================
         */
        session([
            'matching.columns' => [

                'source_1' =>
                    array_values(
                        array_unique(
                            $source1Columns
                        )
                    ),

                'source_2' =>
                    array_values(
                        array_unique(
                            $source2Columns
                        )
                    ),

            ],
        ]);


        /*
         * HAPUS HASIL LAMA
         */
        session()->forget(
            'matching.result'
        );


        /*
         * ==========================================
         * LANJUT KE PROSES MATCHING
         * ==========================================
         */
        return redirect()
            ->route('matching.process')
            ->with(
                'success',
                'Kolom berhasil disimpan. Memproses data...'
            );
    }


    /**
     * ==========================================
     * PROSES MATCHING DATA
     * ==========================================
     *
     * ATURAN UTAMA:
     *
     * 1. Kunci patokan digunakan untuk
     *    menemukan pasangan data.
     *
     * 2. Kolom "No" hanya informasi.
     *    Kolom tersebut TIDAK digunakan
     *    untuk menentukan SAMA/BERBEDA.
     *
     * 3. Matching dilakukan dua arah.
     *
     * 4. Data yang hanya terdapat pada
     *    salah satu sumber masuk
     *    ke Tidak Ditemukan.
     */
    public function process()
    {
        /*
        * ==========================================
        * AMBIL DATA DARI SESSION
        * ==========================================
        */

        $source1 =
            session('matching.source_1');

        $source2 =
            session('matching.source_2');

        $selected =
            session('matching.selected');

        $keys =
            session('matching.keys');

        $columns =
            session('matching.columns');


        /*
        * ==========================================
        * CEK SESSION
        * ==========================================
        */

        if (
            !$source1 ||
            !$source2 ||
            !$selected ||
            !$keys ||
            !$columns
        ) {
            return redirect()
                ->route('matching.create')
                ->withErrors([
                    'upload' =>
                        'Data matching belum lengkap. Silakan ulangi proses.'
                ]);
        }


        /*
        * ==========================================
        * SHEET
        * ==========================================
        */

        $source1Sheets =
            $selected['source_1']['sheets'] ?? [];

        $source2Sheets =
            $selected['source_2']['sheets'] ?? [];


        /*
        * ==========================================
        * KUNCI REFERENSI
        * ==========================================
        */

        $source1Key =
            $keys['source_1'] ?? null;

        $source2Key =
            $keys['source_2'] ?? null;
        
        $keyHeaders =
            session('matching.key_headers', []);

        $source1KeyHeaders =
            $keyHeaders['source_1'] ?? [];

        $source2KeyHeaders =
            $keyHeaders['source_2'] ?? [];

        /*
        * ==========================================
        * KOLOM PEMBANDING
        * ==========================================
        */

        $source1SelectedColumns =
            $columns['source_1'] ?? [];

        $source2SelectedColumns =
            $columns['source_2'] ?? [];


        /*
        * ==========================================
        * VALIDASI DATA
        * ==========================================
        */

        if (
            !$source1Key ||
            !$source2Key ||
            empty($source1SelectedColumns) ||
            empty($source2SelectedColumns)
        ) {
            return redirect()
                ->route('matching.select-columns')
                ->withErrors([
                    'columns' =>
                        'Kunci referensi atau kolom pembanding belum lengkap.'
                ]);
        }


        try {

            /*
            * ==========================================
            * LOAD FILE SUMBER 1
            * ==========================================
            */

            $fullPath1 =
                Storage::path(
                    $source1['path']
                );

            if (!file_exists($fullPath1)) {

                throw new \Exception(
                    'File Sumber 1 tidak ditemukan.'
                );
            }

            $spreadsheet1 =
                IOFactory::load(
                    $fullPath1
                );


            /*
            * ==========================================
            * LOAD FILE SUMBER 2
            * ==========================================
            */

            $fullPath2 =
                Storage::path(
                    $source2['path']
                );

            if (!file_exists($fullPath2)) {

                throw new \Exception(
                    'File Sumber 2 tidak ditemukan.'
                );
            }

            $spreadsheet2 =
                IOFactory::load(
                    $fullPath2
                );


            /*
            * ==========================================
            * BACA DATA DARI SHEET
            * ==========================================
            */

            $dataSource1 =
                $this->readDataFromSheets(
                    $spreadsheet1,
                    $source1Sheets
                );

            $dataSource2 =
                $this->readDataFromSheets(
                    $spreadsheet2,
                    $source2Sheets
                );


            /*
            * ==========================================
            * TOTAL DATA SUMBER
            * ==========================================
            */

            $totalSource1 =
                count($dataSource1);

            $totalSource2 =
                count($dataSource2);


            /*
            * ==========================================
            * HASIL MATCHING
            * ==========================================
            */

            $sameData = [];

            $differentData = [];

            $notFoundData = [];


            /*
            * ==========================================
            * INDEX SUMBER 2 BERDASARKAN KUNCI
            *
            * Satu kunci boleh muncul berkali-kali.
            * ==========================================
            */

            $indexSource2 = [];

            foreach (
                $dataSource2
                as $index2 => $item2
            ) {

                $sheetName =
                    $item2['_sheet'] ?? '';

                $actualKeyHeader =
                    $source2KeyHeaders[$sheetName]
                    ?? null;
                
                if ($actualKeyHeader === null) {
                    continue;
                }

                $keyValue =
                    $item2[$actualKeyHeader] ?? null;

                if (
                    $keyValue === null ||
                    trim((string) $keyValue) === ''
                ) {
                    continue;
                }

                $normalizedKey =
                    $this->normalizeMatchValue(
                        $keyValue
                    );

                if ($normalizedKey === '') {
                    continue;
                }

                if (
                    !isset(
                        $indexSource2[$normalizedKey]
                    )
                ) {
                    $indexSource2[$normalizedKey] = [];
                }

                $indexSource2[$normalizedKey][] =
                    $index2;
            }
            
            /*
            * ==========================================
            * MATCHING SUMBER 1 KE SUMBER 2
            * ==========================================
            */

            foreach (
                $dataSource1
                as $index1 => $item1
            ) {

                $sheetName =
                    $item1['_sheet'] ?? '';

                $actualKeyHeader =
                    $source1KeyHeaders[$sheetName]
                    ?? $source1Key;

                $keyValue =
                    $item1[$actualKeyHeader] ?? null;

                /*
                * Jika Sumber 1 tidak mempunyai
                * kunci referensi.
                */

                if (
                    $keyValue === null ||
                    trim((string) $keyValue) === ''
                ) {

                    $notFoundData[] = [
                        'source' =>
                            'source_1',

                        'key' =>
                            $keyValue,

                        'source_1' =>
                            $item1,

                        'source_2' =>
                            null,

                        'reason' =>
                            'Kunci referensi Sumber 1 kosong.'
                    ];

                    continue;
                }


                $normalizedKey =
                    $this->normalizeMatchValue(
                        $keyValue
                    );


                /*
                * Cari pasangan berdasarkan
                * Kunci Referensi.
                */

                $matchingIndexes =
                    $indexSource2[$normalizedKey] ?? [];


                /*
                * Tidak ditemukan di Sumber 2.
                */

                if (
                    empty($matchingIndexes)
                ) {

                    $notFoundData[] = [
                        'source' =>
                            'source_1',

                        'key' =>
                            $keyValue,

                        'source_1' =>
                            $item1,

                        'source_2' =>
                            null,

                        'reason' =>
                            'Kunci referensi tidak ditemukan di Sumber 2.'
                    ];

                    continue;
                }


                /*
                * ==========================================
                * BANDINGKAN SEMUA DATA DENGAN
                * KUNCI YANG SAMA
                *
                * Duplikat diperbolehkan.
                * ==========================================
                */

                foreach (
                    $matchingIndexes
                    as $index2
                ) {

                    $item2 =
                        $dataSource2[$index2];


                    /*
                    * Bandingkan kolom yang dipilih.
                    */

                    $differences =
                        $this->compareSelectedColumns(
                            $item1,
                            $item2,
                            $source1SelectedColumns,
                            $source2SelectedColumns
                        );

                    
                    /*
                    * ==========================================
                    * DATA SAMA
                    * ==========================================
                    */

                    if (
                        empty($differences)
                    ) {

                        $sameData[] = [

                            'key' =>
                                $keyValue,

                            'source_1' =>
                                $item1,

                            'source_2' =>
                                $item2,

                            'differences' =>
                                []
                        ];

                    }


                    /*
                    * ==========================================
                    * DATA BERBEDA
                    * ==========================================
                    */

                    else {

                        $differentData[] = [

                            'key' =>
                                $keyValue,

                            'source_1' =>
                                $item1,

                            'source_2' =>
                                $item2,

                            'differences' =>
                                $differences
                        ];
                    }
                }
            }


            /*
            * ==========================================
            * CEK DATA SUMBER 2 YANG TIDAK MEMPUNYAI
            * KUNCI DI SUMBER 1
            * ==========================================
            *
            * Ini membuat proses matching menjadi
            * dua arah.
            */

            $keysSource1 = [];


            foreach (
                $dataSource1
                as $item1
            ) {

                $sheetName =
                    $item1['_sheet'] ?? '';

                $actualKeyHeader =
                    $source1KeyHeaders[$sheetName]
                    ?? null;

                if ($actualKeyHeader === null) {
                    continue;
                }

                $keyValue =
                    $item1[$actualKeyHeader] ?? null;

                if (
                    $keyValue === null ||
                    trim((string) $keyValue) === ''
                ) {
                    continue;
                }

                $normalizedKey =
                    $this->normalizeMatchValue(
                        $keyValue
                    );

                if ($normalizedKey === '') {
                    continue;
                }

                $keysSource1[$normalizedKey] =
                    true;
            }


            /*
            * ==========================================
            * SUMBER 2 YANG TIDAK DITEMUKAN
            * DI SUMBER 1
            * ==========================================
            */

            foreach (
                $dataSource2
                as $item2
            ) {

                $sheetName =
                    $item2['_sheet'] ?? '';

                $actualKeyHeader =
                    $source2KeyHeaders[$sheetName]
                    ?? $source2Key;

                $keyValue =
                    $item2[$actualKeyHeader] ?? null;

                /*
                * Kunci kosong.
                */

                if (
                    $keyValue === null ||
                    trim((string) $keyValue) === ''
                ) {

                    $notFoundData[] = [

                        'source' =>
                            'source_2',

                        'key' =>
                            $keyValue,

                        'source_1' =>
                            null,

                        'source_2' =>
                            $item2,

                        'reason' =>
                            'Kunci referensi Sumber 2 kosong.'
                    ];

                    continue;
                }


                $normalizedKey =
                    $this->normalizeMatchValue(
                        $keyValue
                    );


                /*
                * Jika kunci Sumber 2 tidak ada
                * sama sekali di Sumber 1,
                * maka data tersebut tidak ditemukan.
                */

                if (
                    !isset(
                        $keysSource1[$normalizedKey]
                    )
                ) {

                    $notFoundData[] = [

                        'source' =>
                            'source_2',

                        'key' =>
                            $keyValue,

                        'source_1' =>
                            null,

                        'source_2' =>
                            $item2,

                        'reason' =>
                            'Kunci referensi tidak ditemukan di Sumber 1.'
                    ];
                }
            }


            /*
            * ==========================================
            * TOTAL HASIL
            * ==========================================
            */

            $totalSame =
                count($sameData);

            $totalDifferent =
                count($differentData);

            $totalNotFound =
                count($notFoundData);
            
            /*
            * ==========================================
            * VALIDASI KONSISTENSI HASIL
            * ==========================================
            */

            $notFoundSource1 = 0;
            $notFoundSource2 = 0;

            foreach ($notFoundData as $item) {

                if (($item['source'] ?? null) === 'source_1') {
                    $notFoundSource1++;
                }

                if (($item['source'] ?? null) === 'source_2') {
                    $notFoundSource2++;
                }
            }


            /*
            * Validasi Sumber 1
            */

            $validationSource1 =
                $totalSame
                + $totalDifferent
                + $notFoundSource1;


            /*
            * Validasi Sumber 2
            */

            $validationSource2 =
                $totalSame
                + $totalDifferent
                + $notFoundSource2;


            $matchingIsConsistent =
                $validationSource1 === $totalSource1
                && $validationSource2 === $totalSource2;

            /*
            * ==========================================
            * SIMPAN HASIL KE SESSION
            * ==========================================
            */

            $result = [

                'same' =>
                    $sameData,

                'different' =>
                    $differentData,

                'not_found' =>
                    $notFoundData,

                'total_source_1' =>
                    $totalSource1,

                'total_source_2' =>
                    $totalSource2,

                'total_same' =>
                    $totalSame,

                'total_different' =>
                    $totalDifferent,

                'total_not_found' =>
                    $totalNotFound,

                'validation' => [
                'consistent' => $matchingIsConsistent,
                'source_1' => [
                    'total' => $totalSource1,
                    'calculated' => $validationSource1,
                ],
                'source_2' => [
                    'total' => $totalSource2,
                    'calculated' => $validationSource2,
                ],
            ],
                /*
                * Informasi sumber
                */

                'source_1' => [

                    'name' =>
                        $source1['name'] ?? '',

                ],

                'source_2' => [

                    'name' =>
                        $source2['name'] ?? '',

                ],


                /*
                * Informasi kunci
                */

                'keys' => [

                    'source_1' =>
                        $source1Key,

                    'source_2' =>
                        $source2Key,

                ],


                /*
                * Informasi kolom
                */

                'columns' => [

                    'source_1' =>
                        $source1SelectedColumns,

                    'source_2' =>
                        $source2SelectedColumns,

                ],
            ];


            session([
                'matching.result' =>
                    $result
            ]);


            /*
            * ==========================================
            * TAMPILKAN HASIL
            * ==========================================
            */

            return view(
                'matching.result',
                [
                    'result' =>
                        $result,

                    'sameData' =>
                        $sameData,

                    'differentData' =>
                        $differentData,

                    'notFoundData' =>
                        $notFoundData,

                    'totalSource1' =>
                        $totalSource1,

                    'totalSource2' =>
                        $totalSource2,

                    'totalSame' =>
                        $totalSame,

                    'totalDifferent' =>
                        $totalDifferent,

                    'totalNotFound' =>
                        $totalNotFound,

                    'source1' =>
                        $source1,

                    'source2' =>
                        $source2,

                    'source1Key' =>
                        $source1Key,

                    'source2Key' =>
                        $source2Key,

                    'source1Columns' =>
                        $source1SelectedColumns,

                    'source2Columns' =>
                        $source2SelectedColumns,

                ]
            );


        } catch (\Throwable $e) {

            /*
            * ==========================================
            * JIKA TERJADI ERROR
            * ==========================================
            */

            return redirect()
                ->route('matching.select-columns')
                ->withErrors([
                    'process' =>
                        'Terjadi kesalahan saat memproses data: '
                        . $e->getMessage()
                ]);
        }
    }


    /**
     * ==========================================
     * MEMBACA DATA DARI SHEET
     * ==========================================
     *
     * Baris pertama dianggap sebagai header.
     */
    private function readDataFromSheets(
        $spreadsheet,
        array $sheetNames
    ): array {

        $data = [];


        foreach (
            $sheetNames
            as $sheetName
        ) {

            $worksheet =
                $spreadsheet->getSheetByName(
                    $sheetName
                );


            if (!$worksheet) {
                continue;
            }


            /*
            * ==========================================
            * AMBIL BATAS DATA
            * ==========================================
            */
            $highestColumn =
                $worksheet->getHighestDataColumn();

            $highestRow =
                $worksheet->getHighestDataRow();


            $highestColumnIndex =
                Coordinate::columnIndexFromString(
                    $highestColumn
                );


            /*
            * ==========================================
            * BANGUN HEADER KOLOM
            * ==========================================
            *
            * Aturan:
            *
            * 1. Header ada
            *    -> gunakan nama header.
            *
            * 2. Header kosong + ada data
            *    -> gunakan "Kolom X".
            *
            * 3. Header kosong + tidak ada data
            *    -> jangan dibaca.
            */
            $headers = [];


            for (
                $column = 1;
                $column <= $highestColumnIndex;
                $column++
            ) {

                $columnLetter =
                    Coordinate::stringFromColumnIndex(
                        $column
                    );


                /*
                * Ambil header dari baris pertama.
                */
                $headerCell =
                    $worksheet->getCellByColumnAndRow(
                        $column,
                        1
                    );


                $header =
                    trim(
                        (string) $headerCell->getValue()
                    );


                /*
                * ==========================================
                * CEK APAKAH KOLOM MEMILIKI DATA
                * ==========================================
                */
                $hasData = false;


                for (
                    $row = 2;
                    $row <= $highestRow;
                    $row++
                ) {

                    $cell =
                        $worksheet->getCellByColumnAndRow(
                            $column,
                            $row
                        );


                    $value =
                        $cell->getValue();


                    if (
                        $value !== null &&
                        trim((string) $value) !== ''
                    ) {

                        $hasData = true;

                        break;
                    }
                }


                /*
                * ==========================================
                * HEADER KOSONG + TIDAK ADA DATA
                * ==========================================
                */
                if (
                    $header === '' &&
                    !$hasData
                ) {

                    continue;
                }


                /*
                * ==========================================
                * HEADER KOSONG + ADA DATA
                * ==========================================
                */
                if ($header === '') {

                    $header =
                        'Kolom ' .
                        $columnLetter;
                }


                /*
                * ==========================================
                * SIMPAN HEADER
                * ==========================================
                */
                $headers[$columnLetter] =
                    $header;
            }


            /*
            * ==========================================
            * BACA SEMUA BARIS DATA
            * ==========================================
            */
            for (
                $rowNumber = 2;
                $rowNumber <= $highestRow;
                $rowNumber++
            ) {

                $item = [];


                /*
                * Simpan nama sheet.
                */
                $item['_sheet'] =
                    $sheetName;


                /*
                * ==========================================
                * BACA KOLOM
                * ==========================================
                */
                foreach (
                    $headers
                    as $columnLetter => $header
                ) {

                    $item[$header] =
                        $worksheet
                            ->getCell(
                                $columnLetter . $rowNumber
                            )
                            ->getValue();
                }


                /*
                * ==========================================
                * CEK BARIS KOSONG
                * ==========================================
                */
                $hasValue = false;


                foreach (
                    $item
                    as $key => $value
                ) {

                    if ($key === '_sheet') {
                        continue;
                    }


                    if (
                        $value !== null &&
                        trim((string) $value) !== ''
                    ) {

                        $hasValue = true;

                        break;
                    }
                }


                /*
                * Jika seluruh isi baris kosong,
                * jangan masukkan ke data.
                */
                if (!$hasValue) {
                    continue;
                }


                /*
                * ==========================================
                * SIMPAN DATA
                * ==========================================
                */
                $data[] =
                    $item;
            }
        }


        return $data;
    }


    /**
     * ==========================================
     * MEMBANDINGKAN KOLOM TERPILIH
     * ==========================================
     *
     * Kolom "No" tidak dibandingkan.
     *
     * Contoh:
     *
     * Sumber 1:
     * No = 1
     *
     * Sumber 2:
     * No = 10
     *
     * Jika Kunci Patokan sama dan kolom
     * pembanding lainnya sama, maka
     * hasil tetap SAMA.
     */
    private function compareSelectedColumns(
        array $item1,
        array $item2,
        array $selectedColumns1,
        array $selectedColumns2
    ): array {

        $differences = [];

        /*
        |--------------------------------------------------------------------------
        | Ambil nama kolom Sumber 2
        |--------------------------------------------------------------------------
        */
        $columns2 = [];

        foreach ($selectedColumns2 as $selectedColumn2) {

            $parts = explode('|', $selectedColumn2, 2);

            $column2 = count($parts) === 2
                ? $parts[1]
                : $parts[0];

            $column2 = trim((string) $column2);

            if ($column2 === '') {
                continue;
            }

            if ($this->isInformationalColumn($column2)) {
                continue;
            }

            $columns2[] = $column2;
        }

        /*
        |--------------------------------------------------------------------------
        | Bandingkan kolom Sumber 1 dengan Sumber 2
        |--------------------------------------------------------------------------
        */
        foreach ($selectedColumns1 as $selectedColumn1) {

            $parts = explode('|', $selectedColumn1, 2);

            $column1 = count($parts) === 2
                ? $parts[1]
                : $parts[0];

            $column1 = trim((string) $column1);

            if ($column1 === '') {
                continue;
            }

            if ($this->isInformationalColumn($column1)) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | 1. Cari kolom dengan nama yang sama
            |--------------------------------------------------------------------------
            */
            $matchedColumn2 = null;

            foreach ($columns2 as $column2) {

                if ($column1 === $column2) {
                    $matchedColumn2 = $column2;
                    break;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 2. Jika nama berbeda, cari berdasarkan isi/nilai
            |--------------------------------------------------------------------------
            */
            if ($matchedColumn2 === null) {

                $candidateColumns = [];

                $value1 = $this->normalizeCompareValue(
                    $item1[$column1] ?? ''
                );

                if ($value1 !== '') {

                    foreach ($columns2 as $column2) {

                        $value2 = $this->normalizeCompareValue(
                            $item2[$column2] ?? ''
                        );

                        if ($value2 === '') {
                            continue;
                        }

                        if ($value1 === $value2) {
                            $candidateColumns[] = $column2;
                        }
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | Jika hanya ada satu kandidat, gunakan kolom tersebut
                |--------------------------------------------------------------------------
                */
                if (count($candidateColumns) === 1) {
                    $matchedColumn2 = $candidateColumns[0];
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 3. Jika pasangan kolom belum ditemukan, lewati
            |--------------------------------------------------------------------------
            */
            if ($matchedColumn2 === null) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | 4. Bandingkan nilai kedua kolom
            |--------------------------------------------------------------------------
            */
            $value1 = $this->normalizeCompareValue(
                $item1[$column1] ?? ''
            );

            $value2 = $this->normalizeCompareValue(
                $item2[$matchedColumn2] ?? ''
            );

            if ($value1 !== $value2) {

                $differences[] = [
                    'column' => $column1 . ' / ' . $matchedColumn2,
                    'source_1' => $item1[$column1] ?? '',
                    'source_2' => $item2[$matchedColumn2] ?? '',
                ];
            }
        }

        return $differences;
    }

    /**
     * ==========================================
     * MENENTUKAN KOLOM INFORMASI
     * ==========================================
     *
     * Kolom "No" hanya digunakan sebagai
     * informasi keberadaan/urutan data.
     *
     * Tidak digunakan sebagai pembanding.
     */
    private function isInformationalColumn(
        string $column
    ): bool {

        $normalized =
            strtolower(
                trim($column)
            );


        return in_array(
            $normalized,
            [
                'no',
                'no.',
                'nomor',
                'nomor urut',
                'no urut',
            ],
            true
        );
    }


    /**
     * ==========================================
     * NORMALISASI NILAI KUNCI
     * ==========================================
     *
     * Digunakan untuk mencari pasangan.
     */
    private function normalizeMatchValue(
        $value
    ): string {

        return trim(
            (string) $value
        );
    }

        /**
     * ==========================================
     * NORMALISASI NAMA KUNCI REFERENSI
     * ==========================================
     *
     * Contoh:
     *
     * NO PKK       -> PKK
     * NO. PKK      -> PKK
     * NOMOR PKK    -> PKK
     * PKK          -> PKK
     *
     * NO GT        -> GT
     * NO. GT       -> GT
     * NOMOR GT     -> GT
     *
     * ID KAPAL     -> ID KAPAL
     * NO ID KAPAL  -> ID KAPAL
     *
     * Nama asli header tidak diubah.
     * Fungsi ini hanya digunakan untuk
     * mencari kesamaan jenis kunci.
     */
    private function normalizeKeyHeader(
        string $header
    ): string {

        $header =
            mb_strtoupper(
                trim($header)
            );

        /*
        * Ganti tanda baca menjadi spasi.
        */
        $header =
            preg_replace(
                '/[^A-Z0-9]+/u',
                ' ',
                $header
            );

        /*
        * Rapikan spasi.
        */
        $header =
            preg_replace(
                '/\s+/',
                ' ',
                $header
            );

        $header =
            trim($header);

        /*
        * Hapus awalan NO / NOMOR
        * jika masih ada nama kunci setelahnya.
        *
        * NO PKK     -> PKK
        * NOMOR PKK  -> PKK
        *
        * Tetapi:
        *
        * NO -> tetap NO
        */
        $withoutPrefix =
            preg_replace(
                '/^(NO|NOMOR)\s+/i',
                '',
                $header
            );

        if (
            $withoutPrefix !== null &&
            $withoutPrefix !== ''
        ) {
            $header =
                trim($withoutPrefix);
        }

        return $header;
    }
    
    private function normalizeComparisonHeader(string $header): string
    {
        $header = mb_strtoupper(trim($header));

        // Hilangkan tanda baca
        $header = preg_replace('/[^A-Z0-9]+/u', ' ', $header);

        // Rapikan spasi
        $header = preg_replace('/\s+/', ' ', $header);

        $header = trim($header);

        /*
        |--------------------------------------------------------------------------
        | Normalisasi istilah umum
        |--------------------------------------------------------------------------
        */

        $replacements = [
            'GROSS TONNAGE' => 'GT',
            'GROSS TON' => 'GT',
            'GRT' => 'GT',

            'NET TONNAGE' => 'NT',
            'NET TON' => 'NT',
            'NRT' => 'NT',

            'PORT OF REGISTRY' => 'PORT',
            'PORT REGISTRY' => 'PORT',

            'VESSEL NAME' => 'NAME',
            'SHIP NAME' => 'NAME',

            'CALL SIGN' => 'CALLSIGN',
            'CALLSIGN' => 'CALLSIGN',

            'IMO NUMBER' => 'IMO',
            'IMO NO' => 'IMO',
            'IMO NUM' => 'IMO',

            'MMSI NUMBER' => 'MMSI',
            'MMSI NO' => 'MMSI',
            'MMSI NUM' => 'MMSI',

            'NO PKK' => 'PKK',
            'NOMOR PKK' => 'PKK',

            'NO IMO' => 'IMO',
            'NOMOR IMO' => 'IMO',

            'NO MMSI' => 'MMSI',
            'NOMOR MMSI' => 'MMSI',
        ];

        if (isset($replacements[$header])) {
            return $replacements[$header];
        }

        return $header;
    }

    /** 
     * ==========================================
     * CARI KOLOM KUNCI PADA SATU SHEET
     * ==========================================
     *
     * Exact match diprioritaskan.
     *
     * Jika tidak ditemukan:
     * cari header lain yang mempunyai
     * jenis kunci yang sama.
     */
    private function resolveKeyHeader(
        string $selectedKey,
        array $columns
    ): ?string {

        /*
        * 1. Prioritas pertama:
        * nama header persis sama.
        */
        if (
            in_array(
                $selectedKey,
                $columns,
                true
            )
        ) {
            return $selectedKey;
        }

        /*
        * 2. Jika tidak ada,
        * cari berdasarkan normalisasi.
        */
        $normalizedSelected =
            $this->normalizeKeyHeader(
                $selectedKey
            );

        foreach (
            $columns
            as $column
        ) {

            if (
                $this->normalizeKeyHeader(
                    (string) $column
                ) === $normalizedSelected
            ) {

                return $column;
            }
        }

        /*
        * Tidak ditemukan.
        */
        return null;
    }
    /**
     * ==========================================
     * NORMALISASI NILAI PEMBANDING
     * ==========================================
     *
     * Untuk perbandingan isi data.
     */
    private function normalizeCompareValue(
        $value
    ): string {

        $value = (string) $value;

        // Rapikan whitespace berlebih tanpa mengubah isi data.
        // Contoh:
        // "MV.  HELENA RISING" -> "MV. HELENA RISING"
        // " MV. HELENA RISING " -> "MV. HELENA RISING"
        $value = preg_replace(
            '/\s+/u',
            ' ',
            $value
        );

        return trim($value);
    }

    
    /**
     * ==========================================
     * MEMBACA NAMA KOLOM DARI SHEET
     * ==========================================
     *
     * Baris pertama dianggap sebagai
     * nama/header kolom.
     */
    private function getColumnsFromSheets(
        string $path,
        array $sheetNames
    ): array {

        $fullPath =
            Storage::path(
                $path
            );


        if (!file_exists($fullPath)) {

            throw new \Exception(
                'File tidak ditemukan di storage.'
            );
        }


        $spreadsheet =
            IOFactory::load(
                $fullPath
            );


        $result = [];


        foreach (
            $sheetNames
            as $sheetName
        ) {

            $worksheet =
                $spreadsheet->getSheetByName(
                    $sheetName
                );


            if (!$worksheet) {
                continue;
            }


            /*
            * ==========================================
            * AMBIL BATAS DATA SEBENARNYA
            * ==========================================
            */
            $highestColumn =
                $worksheet->getHighestDataColumn();

            $highestRow =
                $worksheet->getHighestDataRow();


            $highestColumnIndex =
                Coordinate::columnIndexFromString(
                    $highestColumn
                );


            $columns = [];


            /*
            * ==========================================
            * PERIKSA SETIAP KOLOM
            * ==========================================
            */
            for (
                $column = 1;
                $column <= $highestColumnIndex;
                $column++
            ) {

                $columnLetter =
                    Coordinate::stringFromColumnIndex(
                        $column
                    );


                /*
                * ==========================================
                * AMBIL HEADER
                * ==========================================
                */
                $headerCell =
                    $worksheet->getCellByColumnAndRow(
                        $column,
                        1
                    );


                $header =
                    trim(
                        (string) $headerCell->getValue()
                    );


                /*
                * ==========================================
                * PERIKSA APAKAH KOLOM MEMILIKI DATA
                * ==========================================
                */
                $hasData = false;


                for (
                    $row = 2;
                    $row <= $highestRow;
                    $row++
                ) {

                    $cell =
                        $worksheet->getCellByColumnAndRow(
                            $column,
                            $row
                        );


                    $value =
                        $cell->getValue();


                    if (
                        $value !== null &&
                        trim((string) $value) !== ''
                    ) {

                        $hasData = true;

                        break;
                    }
                }


                /*
                * ==========================================
                * HEADER KOSONG + TIDAK ADA DATA
                * ==========================================
                *
                * Kolom benar-benar kosong.
                * Tidak perlu ditampilkan.
                */
                if (
                    $header === '' &&
                    !$hasData
                ) {

                    continue;
                }


                /*
                * ==========================================
                * HEADER KOSONG + ADA DATA
                * ==========================================
                *
                * Tetap dibaca.
                * Berikan nama sementara berdasarkan
                * posisi kolom Excel.
                */
                if ($header === '') {

                    $header =
                        'Kolom ' .
                        $columnLetter;
                }


                /*
                * ==========================================
                * SIMPAN NAMA KOLOM
                * ==========================================
                */
                $columns[] =
                    $header;
            }


            $result[$sheetName] =
                $columns;
        }


        return $result;
    }
    public function exportExcel()
    {
        $result = session('matching.result');

        if (!$result) {
            return redirect()
                ->route('matching.create')
                ->with('error', 'Data hasil matching tidak ditemukan.');
        }

        $source1Name = $result['source_1']['name'] ?? 'Sumber1';
        $source2Name = $result['source_2']['name'] ?? 'Sumber2';

        $source1Name = pathinfo($source1Name, PATHINFO_FILENAME);
        $source2Name = pathinfo($source2Name, PATHINFO_FILENAME);

        $source1Name = preg_replace('/[^A-Za-z0-9_-]/', '_', $source1Name);
        $source2Name = preg_replace('/[^A-Za-z0-9_-]/', '_', $source2Name);

        $fileName = 'Hasil_Matching_' .
            $source1Name .
            '_vs_' .
            $source2Name .
            '.xlsx';

        return Excel::download(
            new MatchingExport($result),
            $fileName
        );
    }

}