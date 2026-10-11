<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pilih Kolom - Data Matching</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f1f5f9;
            font-family: Arial, Helvetica, sans-serif;
            color: #1e293b;
        }

        /* =========================
           HEADER
        ========================= */

        .header {
            background: #0f3d5e;
            color: white;
            padding: 14px 0;
        }

        .header-inner {
            width: 92%;
            max-width: 1050px;
            margin: auto;

            display: flex;
            align-items: center;

            gap: 14px;
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

        .logo {
            width: 48px;
            height: 48px;

            background: white;

            border-radius: 8px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #0f3d5e;

            font-size: 10px;
            font-weight: bold;

            text-align: center;
        }

        .header-title {
            line-height: 1.3;
        }

        .header-title h1 {
            margin: 0;

            font-size: 17px;
            font-weight: 700;
        }

        .header-title p {
            margin: 3px 0 0;

            font-size: 12px;

            opacity: .85;
        }


        /* =========================
           CONTAINER
        ========================= */

        .container-main {

            width: 92%;

            max-width: 1050px;

            margin: 28px auto;
        }


        /* =========================
           JUDUL
        ========================= */

        .page-title {

            margin-bottom: 20px;
        }

        .page-title h2 {

            font-size: 22px;

            margin: 0 0 5px;

            font-weight: 700;
        }

        .page-title p {

            margin: 0;

            color: #64748b;

            font-size: 13px;
        }


        /* =========================
           FILE CARD
        ========================= */

        .source-grid {

            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 16px;

            margin-bottom: 20px;
        }

        .source-card {

            background: white;

            border: 1px solid #dbe3ea;

            border-radius: 10px;

            padding: 16px;

            box-shadow: 0 2px 7px rgba(0,0,0,.04);
        }

        .source-label {

            font-size: 11px;

            font-weight: bold;

            color: #64748b;

            text-transform: uppercase;

            margin-bottom: 7px;
        }

        .source-name {

            font-size: 14px;

            font-weight: bold;

            margin-bottom: 10px;

            word-break: break-word;
        }

        .sheet-badge {

            display: inline-block;

            padding: 5px 8px;

            margin: 2px;

            background: #e8f1f7;

            color: #0f3d5e;

            border-radius: 5px;

            font-size: 11px;

            font-weight: 600;
        }


        /* =========================
           COLUMN CARD
        ========================= */

        .column-card {

            background: white;

            border: 1px solid #dbe3ea;

            border-radius: 10px;

            padding: 18px;

            margin-bottom: 18px;

            box-shadow: 0 2px 7px rgba(0,0,0,.04);
        }

        .column-title {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 14px;
        }

        .column-title h3 {

            margin: 0;

            font-size: 16px;

            font-weight: 700;
        }

        .column-title span {

            font-size: 11px;

            color: #64748b;
        }


        /* =========================
           SEMUA KOLOM
        ========================= */

        .select-all {

            background: #f8fafc;

            border: 1px solid #e2e8f0;

            border-radius: 7px;

            padding: 10px 12px;

            margin-bottom: 12px;
        }

        .select-all label {

            font-size: 13px;

            font-weight: 700;

            cursor: pointer;
        }

        .select-all input {

            margin-right: 7px;
        }


        /* =========================
           SHEET
        ========================= */

        .sheet-block {

            border-top: 1px solid #e2e8f0;

            padding-top: 13px;

            margin-top: 13px;
        }

        .sheet-name {

            font-size: 12px;

            font-weight: 700;

            color: #0f3d5e;

            margin-bottom: 9px;
        }


        /* =========================
           KOLOM
        ========================= */

        .columns {

            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 7px;
        }

        .column-item {

            border: 1px solid #e2e8f0;

            border-radius: 6px;

            padding: 8px;

            background: white;
        }

        .column-item:hover {

            background: #f8fafc;
        }

        .column-item label {

            font-size: 12px;

            cursor: pointer;

            word-break: break-word;
        }

        .column-item input {

            margin-right: 6px;
        }


        /* =========================
           ALERT
        ========================= */

        .alert {

            font-size: 13px;

            border-radius: 7px;
        }

        /* =========================
        TOAST NOTIFICATION
        ========================= */

        .toast-success {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #55c8e8;
            color: black;
            padding: 12px 22px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 9999;

            animation:
                toastIn 0.3s ease,
                toastOut 0.4s ease 2.8s forwards;
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translate(-50%, -15px);
            }

            to {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }

        @keyframes toastOut {
            from {
                opacity: 1;
                transform: translate(-50%, 0);
            }

            to {
                opacity: 0;
                transform: translate(-50%, -15px);
            }
        }


        /* =========================
           BUTTON
        ========================= */

        .button-area {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-top: 22px;

            padding-bottom: 30px;
        }

        .btn-back {

            text-decoration: none;

            color: #475569;

            background: white;

            border: 1px solid #cbd5e1;

            border-radius: 7px;

            padding: 9px 18px;

            font-size: 13px;
        }

        .btn-back:hover {

            background: #f8fafc;

            color: #334155;
        }

        .btn-next {

            border: none;

            background: #0f3d5e;

            color: white;

            border-radius: 7px;

            padding: 10px 22px;

            font-size: 13px;

            font-weight: 600;

            cursor: pointer;
        }

        .btn-next:hover {

            background: #0b304a;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 800px) {

            .source-grid {

                grid-template-columns: 1fr;
            }

            .columns {

                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 500px) {

            .columns {

                grid-template-columns: 1fr;
            }

            .button-area {

                flex-direction: column;

                gap: 10px;

                align-items: stretch;
            }
        }

    </style>

</head>


<body>


<!-- =========================
     HEADER
========================= -->

<header class="header">

    <div class="header-inner">

        <!-- LOGO + HEADER -->
        <div class="header-logo">
            <img src="{{ asset('images/logooo.png') }}" alt="Logo">
        <div class="header-title">

            <h1>
                DISTRIK NAVIGASI TIPE A KELAS I AMBON
            </h1>

            <p>
                Sistem Data Matching
            </p>

        </div>

    </div>

</header>



<!-- =========================
     MAIN
========================= -->

<div class="container-main">


    <!-- =========================
         JUDUL
    ========================== -->
    <div class="info-box">

        <div class="page-title">
            <h2>
                Pilih Kolom Data
            </h2>

            <p>
                Pilih kolom yang akan digunakan untuk membandingkan
                data Sumber 1 dan Sumber 2.
            </p>

        </div>
    </div>  
    



    <!-- =========================
         VALIDASI ERROR
    ========================== -->

    @if($errors->any())

        <div class="alert alert-danger">

            {{ $errors->first() }}

        </div>

    @endif

    @if(session('success'))

        <div class="toast-success">
            kunci referensi tersimpan
        </div>

    @endif

    @if(session('skipped_sheets') && count(session('skipped_sheets')) > 0)

        <div class="alert alert-warning" style="margin-bottom: 20px;">

            <strong>Informasi Sheet</strong>

            <ul style="margin: 8px 0 0 18px; padding: 0;">

                @foreach(session('skipped_sheets') as $message)

                    <li>
                        {{ $message }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif

    <!-- =========================
         SUMBER DATA
    ========================= -->

    <div class="source-grid">


        <!-- =========================
             SUMBER 1
        ========================== -->

        <div class="source-card">

            <div class="source-label">

                Sumber 1

            </div>

            <div class="source-name">

                {{ $source1['name'] ?? 'File Sumber 1' }}

            </div>

            <div>

                @foreach($source1Sheets ?? [] as $sheet)

                    <span class="sheet-badge">

                        {{ $sheet }}

                    </span>

                @endforeach

            </div>

        </div>



        <!-- =========================
             SUMBER 2
        ========================== -->

        <div class="source-card">

            <div class="source-label">

                Sumber 2

            </div>

            <div class="source-name">

                {{ $source2['name'] ?? 'File Sumber 2' }}

            </div>

            <div>

                @foreach($source2Sheets ?? [] as $sheet)

                    <span class="sheet-badge">

                        {{ $sheet }}

                    </span>

                @endforeach

            </div>

        </div>


    </div>



    <!-- =========================
         FORM PILIH KOLOM
    ========================= -->

    <form
        method="POST"
        action="{{ route('matching.save-columns') }}"
    >

        @csrf



        <!-- =========================
             SUMBER 1
        ========================== -->

        <div class="column-card">

            <div class="column-title">

                <h3>

                    Kolom Sumber 1

                </h3>

                <span>

                    Data pembanding pertama

                </span>

            </div>


            <!-- PILIH SEMUA -->

            <div class="select-all">

                <label>

                    <input
                        type="checkbox"
                        id="allSource1"
                    >

                    Pilih Semua Kolom

                </label>

            </div>



            <!-- DAFTAR SHEET DAN KOLOM -->

            @forelse($source1Columns ?? [] as $sheetName => $columns)

                <div class="sheet-block">

                    <div class="sheet-name">

                        Sheet: {{ $sheetName }}

                    </div>


                    <div class="columns">

                        @foreach($columns as $column)

                            <div class="column-item">

                                <label>

                                    <input
                                        type="checkbox"
                                        class="source1-column"
                                        name="source_1_columns[]"
                                        value="{{ $sheetName }}|{{ $column }}"
                                        {{ in_array(
                                            $sheetName . '|' . $column,
                                            old('source_1_columns', []),
                                            true
                                        ) ? 'checked' : '' }}
                                    >

                                    {{ $column }}

                                </label>

                            </div>

                        @endforeach

                    </div>

                </div>

            @empty

                <div class="alert alert-warning mb-0">

                    Kolom Sumber 1 belum tersedia.

                </div>

            @endforelse

        </div>



        <!-- =========================
             SUMBER 2
        ========================== -->

        <div class="column-card">

            <div class="column-title">

                <h3>

                    Kolom Sumber 2

                </h3>

                <span>

                    Data pembanding kedua

                </span>

            </div>


            <!-- PILIH SEMUA -->

            <div class="select-all">

                <label>

                    <input
                        type="checkbox"
                        id="allSource2"
                    >

                    Pilih Semua Kolom

                </label>

            </div>



            <!-- DAFTAR SHEET DAN KOLOM -->

            @forelse($source2Columns ?? [] as $sheetName => $columns)

                <div class="sheet-block">

                    <div class="sheet-name">

                        Sheet: {{ $sheetName }}

                    </div>


                    <div class="columns">

                        @foreach($columns as $column)

                            <div class="column-item">

                                <label>

                                    <input
                                        type="checkbox"
                                        class="source2-column"
                                        name="source_2_columns[]"
                                        value="{{ $sheetName }}|{{ $column }}"
                                        {{ in_array(
                                            $sheetName . '|' . $column,
                                            old('source_2_columns', []),
                                            true
                                        ) ? 'checked' : '' }}
                                    >

                                    {{ $column }}

                                </label>

                            </div>

                        @endforeach

                    </div>

                </div>

            @empty

                <div class="alert alert-warning mb-0">

                    Kolom Sumber 2 belum tersedia.

                </div>

            @endforelse

        </div>



        <!-- =========================
             BUTTON
        ========================== -->

        <div class="button-area">

            <a
                href="{{ route('matching.create') }}"
                class="btn-back"
            >

                ← Kembali

            </a>


            <button
                type="submit"
                class="btn-next"
            >

                Lanjutkan →

            </button>

        </div>


    </form>


</div>



<!-- =========================
     JAVASCRIPT
========================= -->

<script>


    /* ==========================================
       PILIH SEMUA SUMBER 1
    ========================================== */

    const allSource1 =
        document.getElementById('allSource1');


    if (allSource1) {

        allSource1.addEventListener(
            'change',
            function () {

                document
                    .querySelectorAll('.source1-column')
                    .forEach(function (checkbox) {

                        checkbox.checked =
                            allSource1.checked;

                    });

            }
        );

    }



    /* ==========================================
       PILIH SEMUA SUMBER 2
    ========================================== */

    const allSource2 =
        document.getElementById('allSource2');


    if (allSource2) {

        allSource2.addEventListener(
            'change',
            function () {

                document
                    .querySelectorAll('.source2-column')
                    .forEach(function (checkbox) {

                        checkbox.checked =
                            allSource2.checked;

                    });

            }
        );

    }



    /* ==========================================
       OTOMATIS CEK "PILIH SEMUA"
       JIKA SEMUA KOLOM TERPILIH
    ========================================== */

    function updateSelectAll(
        selector,
        selectAllId
    ) {

        const checkboxes =
            document.querySelectorAll(selector);

        const selectAll =
            document.getElementById(selectAllId);


        if (
            !selectAll ||
            checkboxes.length === 0
        ) {

            return;

        }


        const checkedCount =
            document.querySelectorAll(
                selector + ':checked'
            ).length;


        selectAll.checked =
            checkedCount === checkboxes.length;

    }



    document
        .querySelectorAll('.source1-column')
        .forEach(function (checkbox) {

            checkbox.addEventListener(
                'change',
                function () {

                    updateSelectAll(
                        '.source1-column',
                        'allSource1'
                    );

                }
            );

        });



    document
        .querySelectorAll('.source2-column')
        .forEach(function (checkbox) {

            checkbox.addEventListener(
                'change',
                function () {

                    updateSelectAll(
                        '.source2-column',
                        'allSource2'
                    );

                }
            );

        });



    /* ==========================================
       CEK KONDISI AWAL
    ========================================== */

    updateSelectAll(
        '.source1-column',
        'allSource1'
    );

    updateSelectAll(
        '.source2-column',
        'allSource2'
    );


</script>


</body>

</html>