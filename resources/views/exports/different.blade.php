@php
    $differentRows = $result['different'] ?? [];

    $source1Columns = [];
    $source2Columns = [];

    /*
    |--------------------------------------------------------------------------
    | Ambil semua nama kolom dari Sumber 1
    |--------------------------------------------------------------------------
    */
    foreach ($differentRows as $row) {
        foreach (($row['source_1'] ?? []) as $column => $value) {

            // Sheet ditampilkan sebagai kolom khusus
            if ($column === '_sheet' || $column === 'sheet') {
                continue;
            }

            // Abaikan nama kolom kosong
            if (trim((string) $column) === '') {
                continue;
            }

            if (!in_array($column, $source1Columns, true)) {
                $source1Columns[] = $column;
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Ambil semua nama kolom dari Sumber 2
    |--------------------------------------------------------------------------
    */
    foreach ($differentRows as $row) {
        foreach (($row['source_2'] ?? []) as $column => $value) {

            if ($column === '_sheet' || $column === 'sheet') {
                continue;
            }

            if (trim((string) $column) === '') {
                continue;
            }

            if (!in_array($column, $source2Columns, true)) {
                $source2Columns[] = $column;
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Hitung jumlah seluruh kolom
    |--------------------------------------------------------------------------
    */
    $totalColumns =
        1 + // Kunci Patokan
        1 + // Sheet Sumber 1
        count($source1Columns) +
        1 + // Sheet Sumber 2
        count($source2Columns) +
        1;  // Status
@endphp


<table>

    <thead>

        {{-- Judul --}}
        <tr>
            <th colspan="{{ $totalColumns }}">
                DATA BERBEDA
            </th>
        </tr>


        {{-- Kelompok sumber --}}
        <tr>

            <th rowspan="2">
                Kunci Patokan
            </th>

            <th colspan="{{ 1 + count($source1Columns) }}">
                SUMBER 1
            </th>

            <th colspan="{{ 1 + count($source2Columns) }}">
                SUMBER 2
            </th>

            <th rowspan="2">
                Status
            </th>

        </tr>


        {{-- Nama kolom --}}
        <tr>

            {{-- Sumber 1 --}}
            <th>
                Sheet
            </th>

            @foreach($source1Columns as $column)

                <th>
                    {{ $column }}
                </th>

            @endforeach


            {{-- Sumber 2 --}}
            <th>
                Sheet
            </th>

            @foreach($source2Columns as $column)

                <th>
                    {{ $column }}
                </th>

            @endforeach

        </tr>

    </thead>


    <tbody>

        @forelse($differentRows as $row)

            <tr>

                {{-- Kunci Patokan --}}
                <td>
                    {{ $row['key'] ?? '-' }}
                </td>


                {{-- =========================
                     SUMBER 1
                     ========================= --}}

                <td>
                    {{
                        $row['source_1']['_sheet']
                        ?? $row['source_1']['sheet']
                        ?? '-'
                    }}
                </td>


                @foreach($source1Columns as $column)

                    <td>
                        {{ $row['source_1'][$column] ?? '-' }}
                    </td>

                @endforeach


                {{-- =========================
                     SUMBER 2
                     ========================= --}}

                <td>
                    {{
                        $row['source_2']['_sheet']
                        ?? $row['source_2']['sheet']
                        ?? '-'
                    }}
                </td>


                @foreach($source2Columns as $column)

                    <td>
                        {{ $row['source_2'][$column] ?? '-' }}
                    </td>

                @endforeach


                {{-- Status --}}
                <td>
                    Data Berbeda
                </td>

            </tr>

        @empty

            <tr>

                <td colspan="{{ $totalColumns }}">
                    Tidak ada data yang berbeda.
                </td>

            </tr>

        @endforelse

    </tbody>

</table>