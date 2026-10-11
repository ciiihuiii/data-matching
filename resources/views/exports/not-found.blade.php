@php

    $notFoundSource1 = collect($result['not_found'] ?? [])
        ->filter(function ($row) {
            return ($row['source'] ?? '') === 'source_1';
        });

    $notFoundSource2 = collect($result['not_found'] ?? [])
        ->filter(function ($row) {
            return ($row['source'] ?? '') === 'source_2';
        });


    /*
    |--------------------------------------------------------------------------
    | Ambil semua kolom Sumber 1
    |--------------------------------------------------------------------------
    */

    $source1Columns = [];

    foreach ($notFoundSource1 as $row) {

        foreach (($row['source_1'] ?? []) as $column => $value) {

            if ($column === '_sheet' || $column === 'sheet') {
                continue;
            }

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
    | Ambil semua kolom Sumber 2
    |--------------------------------------------------------------------------
    */

    $source2Columns = [];

    foreach ($notFoundSource2 as $row) {

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

@endphp


<!-- ====================================================== -->
<!-- DATA TIDAK DITEMUKAN DARI SUMBER 1 -->
<!-- ====================================================== -->

@if($notFoundSource1->count() > 0)

    @php
        $totalSource1Columns =
            1 + // Kunci Patokan
            1 + // Sheet
            count($source1Columns) +
            1; // Status
    @endphp


    <table>

        <thead>

            <tr>
                <th colspan="{{ $totalSource1Columns }}">
                    DATA TIDAK DITEMUKAN DARI SUMBER 1
                </th>
            </tr>


            <tr>

                <th rowspan="2">
                    Kunci Patokan
                </th>

                <th colspan="{{ 1 + count($source1Columns) }}">
                    SUMBER 1
                </th>

                <th rowspan="2">
                    Status
                </th>

            </tr>


            <tr>

                <th>
                    Sheet
                </th>

                @foreach($source1Columns as $column)

                    <th>
                        {{ $column }}
                    </th>

                @endforeach

            </tr>

        </thead>


        <tbody>

            @foreach($notFoundSource1 as $row)

                <tr>

                    <td>
                        {{ $row['key'] ?? '-' }}
                    </td>


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


                    <td>
                        Tidak Ditemukan
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

    <br>

@endif



<!-- ====================================================== -->
<!-- DATA TIDAK DITEMUKAN DARI SUMBER 2 -->
<!-- ====================================================== -->

@if($notFoundSource2->count() > 0)

    @php
        $totalSource2Columns =
            1 + // Kunci Patokan
            1 + // Sheet
            count($source2Columns) +
            1; // Status
    @endphp


    <table>

        <thead>

            <tr>
                <th colspan="{{ $totalSource2Columns }}">
                    DATA TIDAK DITEMUKAN DARI SUMBER 2
                </th>
            </tr>


            <tr>

                <th rowspan="2">
                    Kunci Patokan
                </th>

                <th colspan="{{ 1 + count($source2Columns) }}">
                    SUMBER 2
                </th>

                <th rowspan="2">
                    Status
                </th>

            </tr>


            <tr>

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

            @foreach($notFoundSource2 as $row)

                <tr>

                    <td>
                        {{ $row['key'] ?? '-' }}
                    </td>


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


                    <td>
                        Tidak Ditemukan
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

@endif



<!-- ====================================================== -->
<!-- SEMUA DATA DITEMUKAN -->
<!-- ====================================================== -->

@if(
    $notFoundSource1->count() === 0 &&
    $notFoundSource2->count() === 0
)

    <table>

        <tr>

            <td>
                Semua data ditemukan pada kedua sumber.
            </td>

        </tr>

    </table>

@endif