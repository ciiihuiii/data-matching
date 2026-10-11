<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kunci Referensi - Data Matching</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        body {
            margin: 0;
            background: #f1f5f9;
            font-family: Arial, Helvetica, sans-serif;
            color: #1e293b;
        }

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

        .container-main {
            width: 92%;
            max-width: 1050px;
            margin: 28px auto;
        }

        .page-title h2 {
            margin: 0 0 5px;
            font-size: 22px;
        }

        .page-title p {
            margin: 0 0 22px;
            color: #64748b;
            font-size: 13px;
        }

        .info-box {
            background: #e8f1f7;
            border: 1px solid #c7dce9;
            border-radius: 8px;
            padding: 13px 15px;
            margin-bottom: 40px;
            font-size: 13px;
        }

        .source-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .card-box {
            background: white;
            border: 1px solid #dbe3ea;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,.04);
        }

        .source-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .file-name {
            color: #64748b;
            font-size: 12px;
            margin-bottom: 18px;
            word-break: break-word;
        }

        .form-label {
            font-size: 13px;
            font-weight: bold;
        }

        select.form-select {
            font-size: 13px;
            padding: 10px;
        }

        .sheet-info {
            margin-top: 12px;
            padding: 10px;
            background: #f8fafc;
            border-radius: 6px;
            font-size: 12px;
            color: #64748b;
        }

        .button-area {
            margin-top: 22px;
            display: flex;
            justify-content: space-between;
        }

        .btn-back {
            text-decoration: none;
            background: white;
            border: 1px solid #cbd5e1;
            color: #475569;
            padding: 9px 18px;
            border-radius: 7px;
            font-size: 13px;
        }

        .btn-next {
            border: none;
            background: #0f3d5e;
            color: white;
            padding: 10px 22px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-next:hover {
            background: #0b304a;
        }

        .alert {
            font-size: 13px;
        }

        @media (max-width: 800px) {

            .source-grid {
                grid-template-columns: 1fr;
            }

        }

        .toast-error {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);

            background: #dc3545;
            color: white;

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

    </style>

</head>


<body>


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



<div class="container-main">

    <div class="info-box">

        <div class="page-title">

            <div class="page-title">

                <h2>
                    Pilih Kunci Referensi
                </h2>

                <p>
                    Tentukan kolom yang digunakan sistem untuk menemukan
                    pasangan data antara Sumber 1 dan Sumber 2.
                </p>

            </div>
        </div>  
    </div>

    @if(session('key_error'))
        <div class="toast-error">
            {{ session('key_error') }}
        </div>
    @endif

    @if(session('success'))

    <div
        id="successNotification"
        class="alert alert-success"
        style="
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            min-width: 280px;
            max-width: 90%;
            margin: 0;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,.15);
        "
    >
        {{ session('success') }}
    </div>

    <script>

        setTimeout(function () {

            const notification =
                document.getElementById('successNotification');

            if (notification) {

                notification.style.transition =
                    'opacity 0.5s ease, transform 0.5s ease';

                notification.style.opacity = '0';

                notification.style.transform =
                    'translate(-50%, -10px)';

                setTimeout(function () {

                    notification.remove();

                }, 500);

            }

        }, 2500);

    </script>

@endif



    @if($errors->any())

        <div class="alert alert-danger">

            {{ $errors->first() }}

        </div>

    @endif


    <form
        method="POST"
        action="{{ route('matching.save-keys') }}"
    >

        @csrf


        <div class="source-grid">


            {{-- =========================
                 SUMBER 1
            ========================== --}}

            <div class="card-box">

                <div class="source-title">
                    Sumber 1
                </div>

                <div class="file-name">

                    {{ $source1['name'] ?? '-' }}

                </div>


                <label
                    for="source_1_key"
                    class="form-label"
                >
                    Kunci Referensi Sumber 1
                </label>


                <select
                    name="source_1_key"
                    id="source_1_key"
                    class="form-select"
                    required
                >

                    <option value="">
                        -- Pilih kolom --
                    </option>


                    @php

                        $allColumns1 = collect(
                            $source1Columns ?? []
                        )
                        ->flatten()
                        ->unique()
                        ->values();

                    @endphp


                    @foreach($allColumns1 as $column)

                        <option value="{{ $column }}">

                            {{ $column }}

                        </option>

                    @endforeach

                </select>


                <div class="sheet-info">

                    @if($allSheets1)

                        <strong>
                            Mode: Semua Sheet
                        </strong>

                        <br>

                        Kunci yang dipilih harus tersedia
                        pada seluruh sheet Sumber 1.

                    @else

                        Sheet yang dipilih:

                        <strong>
                            {{ $source1Sheets[0] ?? '-' }}
                        </strong>

                    @endif

                </div>

            </div>



            {{-- =========================
                 SUMBER 2
            ========================== --}}

            <div class="card-box">

                <div class="source-title">
                    Sumber 2
                </div>

                <div class="file-name">

                    {{ $source2['name'] ?? '-' }}

                </div>


                <label
                    for="source_2_key"
                    class="form-label"
                >
                    Kunci Referensi Sumber 2
                </label>


                <select
                    name="source_2_key"
                    id="source_2_key"
                    class="form-select"
                    required
                >

                    <option value="">
                        -- Pilih kolom --
                    </option>


                    @php

                        $allColumns2 = collect(
                            $source2Columns ?? []
                        )
                        ->flatten()
                        ->unique()
                        ->values();

                    @endphp


                    @foreach($allColumns2 as $column)

                        <option value="{{ $column }}">

                            {{ $column }}

                        </option>

                    @endforeach

                </select>


                <div class="sheet-info">

                    @if($allSheets2)

                        <strong>
                            Mode: Semua Sheet
                        </strong>

                        <br>

                        Kunci yang dipilih harus tersedia
                        pada seluruh sheet Sumber 2.

                    @else

                        Sheet yang dipilih:

                        <strong>
                            {{ $source2Sheets[0] ?? '-' }}
                        </strong>

                    @endif

                </div>

            </div>


        </div>



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
                Simpan Kunci & Lanjutkan →
            </button>

        </div>


    </form>


</div>


</body>

</html>