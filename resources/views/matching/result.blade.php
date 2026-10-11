<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hasil Data Matching</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: #f1f5f9;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #0f2942;
        }

        /* =========================================================
           HEADER
        ========================================================= */

        .header {
            height: 76px;
            background: #123f5f;
            display: flex;
            align-items: center;
            padding: 0 28px;
            gap: 12px;
        }

        .menu-button {
            width: 38px;
            height: 38px;
            border: none;
            background: transparent;
            color: white;
            font-size: 25px;
            line-height: 38px;
            cursor: pointer;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .menu-button:hover {
            background: rgba(255, 255, 255, 0.12);
        }
        .header-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-logo img {
            width: 65px;
            height: 65px;
            object-fit: contain;
        }
    
        .header-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .header-title {
            margin: 0;
            color: white;
            font-size: 17px;
            font-weight: bold;
            line-height: 1.2;
        }

        .header-subtitle {
            margin: 3px 0 0 0;
            color: white;
            font-size: 12px;
            line-height: 1.2;
        }

        /* =========================================================
           MENU POPUP
        ========================================================= */

        .menu-popup {
            position: absolute;
            top: 65px;
            left: 28px;
            width: 205px;
            background: white;
            border: 1px solid #d5dde5;
            border-radius: 7px;
            box-shadow: 0 7px 20px rgba(0, 0, 0, 0.18);
            display: none;
            z-index: 2000;
            overflow: hidden;
        }

        .menu-popup.show {
            display: block;
        }

        .menu-item {
            padding: 12px 15px;
            font-size: 13px;
            color: #173b59;
            cursor: pointer;
            border-bottom: 1px solid #edf0f3;
        }

        .menu-item:last-child {
            border-bottom: none;
        }

        .menu-item:hover {
            background: #f1f6fa;
        }

        .menu-item.active {
            background: #e7f0f7;
            color: #123f5f;
            font-weight: bold;
        }

        /* =========================================================
           MAIN
        ========================================================= */

        .container-main {
            max-width: 1110px;
            margin: 0 auto;
            padding: 24px 0 35px;
        }

        .page-kicker {
            font-size: 11px;
            font-weight: bold;
            color: #315f83;
            letter-spacing: 0.3px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .page-title {
            font-size: 22px;
            font-weight: 700;
            color: #102d47;
            margin: 0 0 5px;
            line-height: 1.3;
        }

        .page-description {
            font-size: 12px;
            color: #53708a;
            margin: 0 0 20px;
        }

        /* =========================================================
           SOURCE CARDS
        ========================================================= */

        .source-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        .source-card {
            background: white;
            border: 1px solid #d7e0e8;
            border-radius: 8px;
            padding: 16px 16px;
            min-height: 74px;
            box-shadow: 0 2px 5px rgba(23, 59, 89, 0.04);
        }

        .source-label {
            font-size: 10px;
            color: #466a83;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .source-name {
            font-size: 15px;
            font-weight: bold;
            color: #102d47;
            word-break: break-word;
        }

        /* =========================================================
           SUMMARY CARDS
        ========================================================= */

        .summary-container {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            margin-bottom: 13px;
        }

        .summary-card {
            background: white;
            border: 1px solid #d7e0e8;
            border-radius: 8px;
            min-height: 80px;
            padding: 13px 10px;
            box-shadow: 0 2px 5px rgba(23, 59, 89, 0.04);

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .summary-title {
            font-size: 11px;
            color: #46677f;
            margin-bottom: 8px;
        }

        .summary-value {
            font-size: 22px;
            line-height: 1;
            font-weight: bold;
            color: #102d47;
        }

        /* =========================================================
           ACTION AREA
           EXPORT BERADA DI BAWAH KARTU DAN DI LUAR TABEL
        ========================================================= */
        .action-area {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .action-button {
            border: none;
            border-radius: 5px;
            padding: 8px 14px;
            font-size: 12px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-export {
            background: #198754;
            color: white;
        }

        .btn-export:hover {
            background: #157347;
            color: white;
        }


        /* =========================================================
           BACK BUTTON
        ========================================================= */

            .back-arrow {
            position: absolute;
            left: 20px;
            top: 98px;

            width: 36px;
            height: 36px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #6c757d;
            background: rgba(255, 255, 255, 0.75);

            border-radius: 50%;

            text-decoration: none;
            font-size: 18px;
            font-weight: 500;
            line-height: 1;

            z-index: 10;

            transition: 0.2s ease;
        }

        .back-arrow:hover {
            background: rgba(255, 255, 255, 0.95);
            color: #495057;
        }

        /* =========================================================
           RESULT CARD
        ========================================================= */

        .result-card {
            background: white;
            border: 1px solid #d7e0e8;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(23, 59, 89, 0.04);
        }

        .result-header {
            height: 48px;
            padding: 0 16px;
            border-bottom: 1px solid #d7e0e8;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .result-title {
            font-size: 12px;
            font-weight: bold;
            color: #102d47;
            margin: 0;
        }

        .result-count {
            font-size: 11px;
            color: #52708a;
        }

        /* =========================================================
           TABLE
        ========================================================= */

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        th {
            background: #f4f7fa;
            color: #173b59;
            font-size: 11px;
            font-weight: bold;
            padding: 10px;
            border: 1px solid #d7e0e8;
            white-space: nowrap;
            text-align: left;
        }

        td {
            background: white;
            color: #173b59;
            font-size: 11px;
            padding: 9px 10px;
            border: 1px solid #d7e0e8;
            vertical-align: top;
        }

        tbody tr:hover td {
            background: #fafcfd;
        }

        .source-box {
            line-height: 1.65;
        }

        .source-box strong {
            color: #173b59;
        }

        .status-sama {
            color: #198754;
            font-weight: bold;
        }

        .status-berbeda {
            color: #dc3545;
            font-weight: bold;
        }

        .status-tidak-ditemukan {
            color: #d97706;
            font-weight: bold;
        }
        .table-tools {
            display: flex;
            align-items: center;
        }

        .table-tools input {
            width: 250px;
            height: 34px;
            padding: 6px 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 12px;
            color: #173b59;
            outline: none;
        }

        .table-tools input:focus {
            border-color: #315f83;
            box-shadow: 0 0 0 2px rgba(49, 95, 131, 0.10);
        }

        .table-tools input::placeholder {
            color: #8a9aaa;
        }
        /* =========================================================
           NOT FOUND
        ========================================================= */

        .not-found-section {
            margin-bottom: 14px;
        }

        .not-found-section:last-child {
            margin-bottom: 0;
        }

        .not-found-section .result-header {
            background: white;
        }

        /* =========================================================
           EMPTY DATA
        ========================================================= */

        .empty-data {
            text-align: center;
            padding: 35px;
            color: #6b7f90;
            font-size: 12px;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1000px) {

            .container-main {
                padding-left: 18px;
                padding-right: 18px;
            }

            .summary-container {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 700px) {

            .header {
                padding: 0 15px;
            }

            .header-title {
                font-size: 14px;
            }

            .header-subtitle {
                font-size: 10px;
            }

            .source-container {
                grid-template-columns: 1fr;
            }

            .summary-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 450px) {

            .summary-container {
                grid-template-columns: 1fr;
            }

            .action-area {
                display: flex;
                align-items: center;
                justify-content: flex-start;
                gap: 8px;
                margin-bottom: 10px;
            }
        }

        /* =========================================================
           PRINT
        ========================================================= */

        @media print {

            .menu-button,
            .menu-popup,
            .back-area,
            .action-area {
                display: none !important;
            }

            body {
                background: white;
            }

            .header {
                background: #123f5f !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .container-main {
                max-width: 100%;
                padding: 15px;
            }

            .result-section {
                display: block !important;
            }

            .result-card {
                box-shadow: none;
                border: 1px solid #999;
                margin-bottom: 15px;
            }

            .summary-card,
            .source-card {
                box-shadow: none;
            }
        }

        .matching-validation-toast {
            position: fixed;
            top: 25px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;

            padding: 12px 20px;
            border-radius: 8px;

            font-size: 14px;
            font-weight: 600;

            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);

            animation:
                toastIn 0.3s ease,
                toastOut 0.5s ease 3.5s forwards;
        }

        .matching-validation-toast.success {
            background: #198754;
            color: white;
        }

        .matching-validation-toast.error {
            background: #dc3545;
            color: white;
        }

        @keyframes toastIn {

            from {
                opacity: 0;
                transform: translateY(-15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }

        }

        @keyframes toastOut {

            from {
                opacity: 1;
                transform: translateY(0);
            }

            to {
                opacity: 0;
                transform: translateY(-15px);
            }

        }
    </style>
</head>

<body>
    @if (isset($result['validation']['consistent']))

        <div
            id="matchingValidationToast"
            class="matching-validation-toast {{ $result['validation']['consistent'] ? 'success' : 'error' }}"
        >
            @if ($result['validation']['consistent'])
                ✓ Hasil matching konsisten
            @else
                ⚠ Hasil matching perlu diperiksa
            @endif
        </div>

    @endif

    <!-- =========================================================
         HEADER
    ========================================================= -->

    <div class="header">

        <!-- MENU DI SEBELAH KIRI LOGO -->
        <button
            class="menu-button"
            id="menuButton"
            onclick="toggleMenu()"
            type="button"
            aria-label="Menu"
        >
            ☰
        </button>

        <!-- LOGO -->
        <div class="header-logo">
            <img src="{{ asset('images/logooo.png') }} " alt="Logo">
        </div>

        <!-- JUDUL HEADER -->
        <div class="header-text">

            <h1 class="header-title">
                DISTRIK NAVIGASI TIPE A KELAS I AMBON
            </h1>

            <div class="header-subtitle">
                Sistem Data Matching
            </div>

        </div>

    </div>


    <!-- =========================================================
         MENU POPUP
    ========================================================= -->

    <div
        id="menuPopup"
        class="menu-popup"
    >

        <div
            class="menu-item active"
            onclick="showResult('same', this)"
        >
            Data Sama
        </div>

        <div
            class="menu-item"
            onclick="showResult('different', this)"
        >
            Data Berbeda
        </div>

        <div
            class="menu-item"
            onclick="showResult('not_found', this)"
        >
            Tidak Ditemukan
        </div>

    </div>


    <!-- =========================================================
         MAIN
    ========================================================= -->

    <div class="container-main">

       <div class="container">

        @php
            $selectedColumns = session('matching.columns', []);

            $source1Columns = $selectedColumns['source_1'] ?? [];
            $source2Columns = $selectedColumns['source_2'] ?? [];
        @endphp

            <a href="{{ route('matching.create') }}" class="back-arrow">
                ←
            </a>

            <h2 class="page-title">Hasil Data Matching</h2>

            <p class="page-description">
                Hasil perbandingan data antara Sumber 1 dan Sumber 2.
            </p>
        <!-- =====================================================
             SUMBER 1 DAN SUMBER 2
        ====================================================== -->

        @php

            $source1Name =
                $source1['name']
                ?? ($result['source_1']['name'] ?? 'Sumber 1');

            $source2Name =
                $source2['name']
                ?? ($result['source_2']['name'] ?? 'Sumber 2');

        @endphp

        <div class="source-container">

            <div class="source-card">

                <div class="source-label">
                    SUMBER 1
                </div>

                <div class="source-name">
                    {{ $source1Name }}
                </div>

            </div>


            <div class="source-card">

                <div class="source-label">
                    SUMBER 2
                </div>

                <div class="source-name">
                    {{ $source2Name }}
                </div>

            </div>

        </div>


        <!-- =====================================================
             SUMMARY 5 KARTU
        ====================================================== -->

        <div class="summary-container">

            <!-- TOTAL SUMBER 1 -->
            <div class="summary-card">

                <div class="summary-title">
                    Total Sumber 1
                </div>

                <div class="summary-value">
                    {{ $totalSource1 ?? 0 }}
                </div>

            </div>


            <!-- TOTAL SUMBER 2 -->
            <div class="summary-card">

                <div class="summary-title">
                    Total Sumber 2
                </div>

                <div class="summary-value">
                    {{ $totalSource2 ?? 0 }}
                </div>

            </div>


            <!-- DATA SAMA -->
            <div class="summary-card">

                <div class="summary-title">
                    Data Sama
                </div>

                <div class="summary-value">
                    {{ $totalSame ?? 0 }}
                </div>

            </div>


            <!-- DATA BERBEDA -->
            <div class="summary-card">

                <div class="summary-title">
                    Data Berbeda
                </div>

                <div class="summary-value">
                    {{ $totalDifferent ?? 0 }}
                </div>

            </div>


            <!-- TIDAK DITEMUKAN -->
            <div class="summary-card">

                <div class="summary-title">
                    Tidak Ditemukan
                </div>

                <div class="summary-value">
                    {{ $totalNotFound ?? 0 }}
                </div>

            </div>

        </div>


        <!-- =====================================================
             EXPORT DI BAWAH KARTU, PALING KANAN
             DAN DI LUAR TABEL
        ====================================================== -->

        <div class="action-area">

            <a
                href="{{ route('matching.export-excel') }}"
                class="action-button btn-export"
            >
                Export Excel
            </a>

            <div class="table-tools">

                <input
                    type="text"
                    id="tableSearch"
                    placeholder="Cari data..."
                    autocomplete="off"
                >

            </div>

        </div>


        <!-- =====================================================
             DATA SAMA
        ====================================================== -->

        <div
            id="result-same"
            class="result-section"
        >

            <div class="result-card">

                <div class="result-header">

                    <h3 class="result-title">
                        Data Sama
                    </h3>

                    <span class="result-count">
                        {{ count($sameData ?? []) }} data
                    </span>

                </div>


                @if(!empty($sameData))

                    <div class="table-container">

                        <table>

                            <thead>

                                <tr>

                                    <th>
                                        No.
                                    </th>

                                    <th>
                                        Kunci
                                    </th>

                                    <th>
                                        Sumber 1
                                    </th>

                                    <th>
                                        Sumber 2
                                    </th>

                                    <th>
                                        Status
                                    </th>

                                </tr>

                            </thead>


                           <tbody>

                            @foreach($sameData as $index => $row)

                                <tr>

                                    <td>
                                        {{ $index + 1 }}
                                    </td>

                                    <td>
                                        {{ $row['key'] ?? '-' }}
                                    </td>

                                    <!-- SUMBER 1 -->
                                    <td>
                                        <div class="source-box">

                                            @if(
                                                isset($row['source_1']) &&
                                                is_array($row['source_1'])
                                            )

                                                <strong>Sheet:</strong>
                                                {{ $row['source_1']['_sheet'] ?? $row['source_1']['sheet'] ?? '-' }}

                                                <br>

                                                @foreach($source1Columns as $selectedColumn)

                                                    @php
                                                        $parts = explode('|', $selectedColumn, 2);

                                                        if (count($parts) === 2) {
                                                            $selectedSheet = $parts[0];
                                                            $column = $parts[1];
                                                        } else {
                                                            $selectedSheet = null;
                                                            $column = $parts[0];
                                                        }

                                                        $currentSheet = $row['source_1']['_sheet']
                                                            ?? $row['source_1']['sheet']
                                                            ?? null;
                                                    @endphp

                                                    @if(
                                                        $column !== '_sheet' &&
                                                        $column !== 'sheet' &&
                                                        (
                                                            $selectedSheet === null ||
                                                            $selectedSheet === $currentSheet
                                                        )
                                                    )

                                                        <strong>{{ $column }}:</strong>
                                                        {{ $row['source_1'][$column] ?? '-' }}

                                                        <br>

                                                    @endif

                                                @endforeach

                                            @else

                                                -

                                            @endif

                                        </div>
                                    </td>

                                    <!-- SUMBER 2 -->
                                    <td>
                                        <div class="source-box">

                                            @if(
                                                isset($row['source_2']) &&
                                                is_array($row['source_2'])
                                            )

                                                <strong>Sheet:</strong>
                                                {{ $row['source_2']['_sheet'] ?? $row['source_2']['sheet'] ?? '-' }}

                                                <br>

                                                @foreach($source2Columns as $selectedColumn)

                                                    @php
                                                        $parts = explode('|', $selectedColumn, 2);

                                                        if (count($parts) === 2) {
                                                            $selectedSheet = $parts[0];
                                                            $column = $parts[1];
                                                        } else {
                                                            $selectedSheet = null;
                                                            $column = $parts[0];
                                                        }

                                                        $currentSheet = $row['source_2']['_sheet']
                                                            ?? $row['source_2']['sheet']
                                                            ?? null;
                                                    @endphp

                                                    @if(
                                                        $column !== '_sheet' &&
                                                        $column !== 'sheet' &&
                                                        (
                                                            $selectedSheet === null ||
                                                            $selectedSheet === $currentSheet
                                                        )
                                                    )

                                                        <strong>{{ $column }}:</strong>
                                                        {{ $row['source_2'][$column] ?? '-' }}

                                                        <br>

                                                    @endif

                                                @endforeach

                                            @else

                                                -

                                            @endif

                                        </div>
                                    </td>

                                    <!-- STATUS -->
                                    <td class="status-sama">
                                        SAMA
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                        </table>

                    </div>

                @else

                    <div class="empty-data">
                        Tidak ada data yang sama.
                    </div>

                @endif

            </div>

        </div>


        <!-- =====================================================
             DATA BERBEDA
        ====================================================== -->

        <div
            id="result-different"
            class="result-section"
            style="display: none;"
        >

            <div class="result-card">

                <div class="result-header">

                    <h3 class="result-title">
                        Data Berbeda
                    </h3>

                    <span class="result-count">
                        {{ count($differentData ?? []) }} data
                    </span>

                </div>


                @if(!empty($differentData))

                    <div class="table-container">

                        <table>

                            <thead>

                                <tr>

                                    <th>
                                        No.
                                    </th>

                                    <th>
                                        Kunci
                                    </th>

                                    <th>
                                        Sumber 1
                                    </th>

                                    <th>
                                        Sumber 2
                                    </th>

                                    <th>
                                        Status
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($differentData as $index => $row)

                                    <tr>

                                        <td>
                                            {{ $index + 1 }}
                                        </td>


                                        <td>
                                            {{ $row['key'] ?? '-' }}
                                        </td>


                                        <td>

                                            <div class="source-box">

                                                @if(
                                                    isset($row['source_1']) &&
                                                    is_array($row['source_1'])
                                                )   
                                                    <strong>Sheet:</strong>
                                                    {{ $row['source_1']['_sheet'] ?? $row['source_1']['sheet'] ?? '-' }}

                                                    <br>

                                                    @foreach($source1Columns as $selectedColumn)

                                                        @php
                                                            $parts = explode('|', $selectedColumn, 2);

                                                            if (count($parts) === 2) {
                                                                $selectedSheet = $parts[0];
                                                                $column = $parts[1];
                                                            } else {
                                                                $selectedSheet = null;
                                                                $column = $parts[0];
                                                            }

                                                            $currentSheet = $row['source_1']['_sheet']
                                                                ?? $row['source_1']['sheet']
                                                                ?? null;
                                                        @endphp

                                                        @if(
                                                            $column !== '_sheet' &&
                                                            $column !== 'sheet' &&
                                                            (
                                                                $selectedSheet === null ||
                                                                $selectedSheet === $currentSheet
                                                            )
                                                        )

                                                            <strong>
                                                                {{ $column }}:
                                                            </strong>

                                                            {{ $row['source_1'][$column] ?? '-' }}

                                                            @if(!$loop->last)
                                                                <br>
                                                            @endif

                                                        @endif

                                                    @endforeach

                                                @else

                                                    -

                                                @endif

                                            </div>

                                        </td>


                                        <td>

                                            <div class="source-box">

                                                @if(
                                                    isset($row['source_2']) &&
                                                    is_array($row['source_2'])
                                                )   
                                                    <strong>Sheet:</strong>
                                                    {{ $row['source_2']['_sheet'] ?? $row['source_2']['sheet'] ?? '-' }}

                                                    <br>

                                                    @foreach($source2Columns as $selectedColumn)

                                                        @php
                                                            $parts = explode('|', $selectedColumn, 2);

                                                            if (count($parts) === 2) {
                                                                $selectedSheet = $parts[0];
                                                                $column = $parts[1];
                                                            } else {
                                                                $selectedSheet = null;
                                                                $column = $parts[0];
                                                            }

                                                            $currentSheet = $row['source_2']['_sheet']
                                                                ?? $row['source_2']['sheet']
                                                                ?? null;
                                                        @endphp

                                                        @if(
                                                            $column !== '_sheet' &&
                                                            $column !== 'sheet' &&
                                                            (
                                                                $selectedSheet === null ||
                                                                $selectedSheet === $currentSheet
                                                            )
                                                        )

                                                            <strong>
                                                                {{ $column }}:
                                                            </strong>

                                                            {{ $row['source_2'][$column] ?? '-' }}

                                                            @if(!$loop->last)
                                                                <br>
                                                            @endif

                                                        @endif

                                                    @endforeach
                                                    
                                                @else

                                                    -

                                                @endif

                                            </div>

                                        </td>


                                        <td class="status-berbeda">
                                            BERBEDA
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="empty-data">
                        Tidak ada data yang berbeda.
                    </div>

                @endif

            </div>

        </div>


        <!-- =====================================================
             TIDAK DITEMUKAN
        ====================================================== -->

        <div
            id="result-not-found"
            class="result-section"
            style="display: none;"
        >

            @php

                $notFoundSource1 = collect($notFoundData ?? [])
                    ->filter(function ($row) {
                        return ($row['source'] ?? '') === 'source_1';
                    });

                $notFoundSource2 = collect($notFoundData ?? [])
                    ->filter(function ($row) {
                        return ($row['source'] ?? '') === 'source_2';
                    });

            @endphp


            <!-- =================================================
                 TIDAK DITEMUKAN - SUMBER 1
            ================================================== -->

            @if($notFoundSource1->count() > 0)

                <div class="result-card not-found-section">

                    <div class="result-header">

                        <h3 class="result-title">
                            Data Tidak Ditemukan dari Sumber 1
                        </h3>

                        <span class="result-count">
                            {{ $notFoundSource1->count() }} data
                        </span>

                    </div>


                    <div class="table-container">

                        <table>

                            <thead>

                                <tr>

                                    <th>
                                        No.
                                    </th>

                                    <th>
                                        Kunci Referensi
                                    </th>

                                    <th>
                                        Sumber 1
                                    </th>

                                    <th>
                                        Status
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($notFoundSource1 as $index => $row)

                                    <tr>

                                        <td>
                                            {{ $index + 1 }}
                                        </td>


                                        <td>
                                            {{ $row['key'] ?? '-' }}
                                        </td>


                                        <td>

                                            <div class="source-box">

                                                @if(
                                                    isset($row['source_1']) &&
                                                    is_array($row['source_1'])
                                                )
                                                    <strong>Sheet:</strong>
                                                    {{ $row['source_1']['_sheet'] ?? $row['source_1']['sheet'] ?? '-' }}

                                                    <br>

                                                    @foreach($source1Columns as $selectedColumn)

                                                        @php
                                                            $parts = explode('|', $selectedColumn, 2);

                                                            if (count($parts) === 2) {
                                                                $selectedSheet = $parts[0];
                                                                $column = $parts[1];
                                                            } else {
                                                                $selectedSheet = null;
                                                                $column = $parts[0];
                                                            }

                                                            $currentSheet = $row['source_1']['_sheet']
                                                                ?? $row['source_1']['sheet']
                                                                ?? null;
                                                        @endphp

                                                        @if(
                                                            $column !== '_sheet' &&
                                                            $column !== 'sheet' &&
                                                            (
                                                                $selectedSheet === null ||
                                                                $selectedSheet === $currentSheet
                                                            )
                                                        )

                                                            <strong>
                                                                {{ $column }}:
                                                            </strong>

                                                            {{ $row['source_1'][$column] ?? '-' }}

                                                            @if(!$loop->last)
                                                                <br>
                                                            @endif

                                                        @endif

                                                    @endforeach

                                                @else

                                                    -

                                                @endif

                                            </div>

                                        </td>


                                        <td class="status-tidak-ditemukan">
                                            Tidak Ditemukan
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            @endif


            <!-- =================================================
                 TIDAK DITEMUKAN - SUMBER 2
            ================================================== -->

            @if($notFoundSource2->count() > 0)

                <div class="result-card not-found-section">

                    <div class="result-header">

                        <h3 class="result-title">
                            Data Tidak Ditemukan dari Sumber 2
                        </h3>

                        <span class="result-count">
                            {{ $notFoundSource2->count() }} data
                        </span>

                    </div>


                    <div class="table-container">

                        <table>

                            <thead>

                                <tr>

                                    <th>
                                        No.
                                    </th>

                                    <th>
                                        Kunci Referensi
                                    </th>

                                    <th>
                                        Sumber 2
                                    </th>

                                    <th>
                                        Status
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($notFoundSource2 as $index => $row)

                                    <tr>

                                        <td>
                                            {{ $index + 1 }}
                                        </td>


                                        <td>
                                            {{ $row['key'] ?? '-' }}
                                        </td>


                                        <td>

                                            <div class="source-box">

                                                @if(
                                                    isset($row['source_2']) &&
                                                    is_array($row['source_2'])
                                                )
                                                    <strong>Sheet:</strong>
                                                    {{ $row['source_2']['_sheet'] ?? $row['source_2']['sheet'] ?? '-' }}

                                                    <br>

                                                    @foreach($source2Columns as $selectedColumn)

                                                        @php
                                                            $parts = explode('|', $selectedColumn, 2);

                                                            if (count($parts) === 2) {
                                                                $selectedSheet = $parts[0];
                                                                $column = $parts[1];
                                                            } else {
                                                                $selectedSheet = null;
                                                                $column = $parts[0];
                                                            }

                                                            $currentSheet = $row['source_2']['_sheet']
                                                                ?? $row['source_2']['sheet']
                                                                ?? null;
                                                        @endphp

                                                        @if(
                                                            $column !== '_sheet' &&
                                                            $column !== 'sheet' &&
                                                            (
                                                                $selectedSheet === null ||
                                                                $selectedSheet === $currentSheet
                                                            )
                                                        )

                                                            <strong>
                                                                {{ $column }}:
                                                            </strong>

                                                            {{ $row['source_2'][$column] ?? '-' }}

                                                            @if(!$loop->last)
                                                                <br>
                                                            @endif

                                                        @endif

                                                    @endforeach
                                                    
                                                @else

                                                    -

                                                @endif

                                            </div>

                                        </td>


                                        <td class="status-tidak-ditemukan">
                                            Tidak Ditemukan
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            @endif


            <!-- =================================================
                 TIDAK ADA DATA
            ================================================== -->

            @if(
                $notFoundSource1->count() === 0 &&
                $notFoundSource2->count() === 0
            )

                <div class="result-card">

                    <div class="empty-data">
                        Semua data ditemukan pada kedua sumber.
                    </div>

                </div>

            @endif

        </div>

    </div>


    <!-- =========================================================
         JAVASCRIPT
    ========================================================= -->

    <script>

        function toggleMenu() {

            const menu = document.getElementById('menuPopup');

            menu.classList.toggle('show');

        }


        function showResult(type, element) {

            /*
             * Sembunyikan seluruh tabel.
             */

            document.getElementById('result-same').style.display = 'none';

            document.getElementById('result-different').style.display = 'none';

            document.getElementById('result-not-found').style.display = 'none';


            /*
             * Tampilkan tabel sesuai menu.
             */

            if (type === 'same') {

                document.getElementById('result-same').style.display = 'block';

            }

            if (type === 'different') {

                document.getElementById('result-different').style.display = 'block';

            }

            if (type === 'not_found') {

                document.getElementById('result-not-found').style.display = 'block';

            }


            /*
             * Hapus active dari semua menu.
             */

            document.querySelectorAll('.menu-item').forEach(function(item) {

                item.classList.remove('active');

            });


            /*
             * Aktifkan menu yang dipilih.
             */

            element.classList.add('active');


            /*
             * Tutup popup menu.
             */

            document.getElementById('menuPopup').classList.remove('show');

        }


        /*
         * Klik di luar popup → tutup menu.
         */

        document.addEventListener('click', function(event) {

            const menu = document.getElementById('menuPopup');

            const button = document.getElementById('menuButton');


            if (
                menu.classList.contains('show') &&
                !menu.contains(event.target) &&
                !button.contains(event.target)
            ) {

                menu.classList.remove('show');

            }

        });

        /*
        * SEARCH DATA
        */

        const tableSearch = document.getElementById('tableSearch');

        if (tableSearch) {

            tableSearch.addEventListener('input', function () {

                const keyword = this.value.toLowerCase().trim();

                const sections = document.querySelectorAll('.result-section');

                sections.forEach(function (section) {

                    const isVisible =
                        window.getComputedStyle(section).display !== 'none';

                    if (!isVisible) {
                        return;
                    }


                    /*
                    * =====================================================
                    * DATA TIDAK DITEMUKAN
                    * =====================================================
                    */
                    if (section.id === 'result-not-found') {

                        const cards =
                            section.querySelectorAll('.not-found-section');


                        /*
                        * =================================================
                        * JIKA MENCARI "SUMBER 1"
                        * =================================================
                        */
                        if (keyword === 'sumber 1') {

                            cards.forEach(function (card) {

                                const title =
                                    card.querySelector('.result-title');

                                const titleText =
                                    title
                                        ? title.textContent.toLowerCase()
                                        : '';

                                const isSource1 =
                                    titleText.includes('sumber 1');


                                if (isSource1) {

                                    /*
                                    * Tampilkan kartu Sumber 1
                                    */
                                    card.style.display = '';

                                    /*
                                    * Tampilkan SEMUA baris
                                    */
                                    const rows =
                                        card.querySelectorAll('tbody tr');

                                    rows.forEach(function (row) {
                                        row.style.display = '';
                                    });

                                } else {

                                    /*
                                    * Sembunyikan kartu Sumber 2
                                    */
                                    card.style.display = 'none';

                                }

                            });

                            return;
                        }


                        /*
                        * =================================================
                        * JIKA MENCARI "SUMBER 2"
                        * =================================================
                        */
                        if (keyword === 'sumber 2') {

                            cards.forEach(function (card) {

                                const title =
                                    card.querySelector('.result-title');

                                const titleText =
                                    title
                                        ? title.textContent.toLowerCase()
                                        : '';

                                const isSource2 =
                                    titleText.includes('sumber 2');


                                if (isSource2) {

                                    /*
                                    * Tampilkan kartu Sumber 2
                                    */
                                    card.style.display = '';

                                    /*
                                    * PENTING:
                                    * Kembalikan SEMUA baris yang
                                    * sebelumnya mungkin sudah tersembunyi.
                                    */
                                    const rows =
                                        card.querySelectorAll('tbody tr');

                                    rows.forEach(function (row) {
                                        row.style.display = '';
                                    });

                                } else {

                                    /*
                                    * Sembunyikan kartu Sumber 1
                                    */
                                    card.style.display = 'none';

                                }

                            });

                            return;
                        }


                        /*
                        * =================================================
                        * PENCARIAN NORMAL
                        * =================================================
                        *
                        * Jika bukan "sumber 1" atau "sumber 2",
                        * kedua tabel tetap ditampilkan dan pencarian
                        * dilakukan berdasarkan isi baris.
                        */
                        cards.forEach(function (card) {

                            card.style.display = '';

                            const rows =
                                card.querySelectorAll('tbody tr');

                            rows.forEach(function (row) {

                                const text =
                                    row.textContent.toLowerCase();

                                if (
                                    keyword === '' ||
                                    text.includes(keyword)
                                ) {

                                    row.style.display = '';

                                } else {

                                    row.style.display = 'none';

                                }

                            });

                        });

                        return;
                    }


                    /*
                    * =====================================================
                    * DATA SAMA & DATA BERBEDA
                    * =====================================================
                    *
                    * Tidak ada perlakuan khusus untuk "sumber 1"
                    * atau "sumber 2".
                    */
                    const rows =
                        section.querySelectorAll('tbody tr');

                    rows.forEach(function (row) {

                        const text =
                            row.textContent.toLowerCase();

                        if (
                            keyword === '' ||
                            text.includes(keyword)
                        ) {

                            row.style.display = '';

                        } else {

                            row.style.display = 'none';

                        }

                    });

                });

            });

        }

    </script>

</body>
</html>