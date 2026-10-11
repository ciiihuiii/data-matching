<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Data Siap Dibandingkan | Data Matching
    </title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f7fa;
            color: #1e293b;
            min-height: 100vh;
        }

        .header {
            background: #123b5d;
            color: white;
            border-bottom: 4px solid #d6a84f;
        }

        .header-inner {
            width: 92%;
            max-width: 1000px;
            margin: auto;
            min-height: 75px;

            display: flex;
            align-items: center;
        }

        .identity h1 {
            font-size: 15px;
            margin-bottom: 4px;
        }

        .identity p {
            font-size: 12px;
            color: #dbe7ef;
        }

        .container {
            width: 92%;
            max-width: 850px;
            margin: 40px auto;
        }

        .title {
            text-align: center;
            margin-bottom: 25px;
        }

        .title h2 {
            color: #123b5d;
            font-size: 25px;
            margin-bottom: 8px;
        }

        .title p {
            font-size: 13px;
            color: #64748b;
        }

        .success {
            background: #e8f7f3;
            border-left: 4px solid #16817a;
            border-radius: 7px;

            padding: 13px 15px;

            margin-bottom: 20px;

            font-size: 12px;
            color: #116b65;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .card {
            background: white;

            border: 1px solid #d9e2ec;
            border-radius: 11px;

            padding: 22px;

            box-shadow:
                0 5px 18px rgba(18, 59, 93, 0.07);
        }

        .badge {
            display: inline-block;

            padding: 5px 9px;

            border-radius: 5px;

            background: #e7f5f3;
            color: #116b65;

            font-size: 10px;
            font-weight: bold;

            margin-bottom: 10px;
        }

        .card h3 {
            color: #123b5d;

            font-size: 17px;

            margin-bottom: 5px;
        }

        .filename {
            color: #64748b;

            font-size: 11px;

            margin-bottom: 18px;

            word-break: break-word;
        }

        .label {
            display: block;

            font-size: 12px;
            font-weight: bold;

            color: #334155;

            margin-bottom: 7px;
        }

        .all {
            background: #fffaf0;

            border: 1px solid #ead9ad;

            border-radius: 7px;

            padding: 11px 12px;

            color: #6b5b32;

            font-size: 12px;

            margin-bottom: 12px;
        }

        .sheet-list {
            max-height: 180px;

            overflow-y: auto;

            border: 1px solid #e2e8f0;

            border-radius: 7px;

            background: #f8fafc;
        }

        .sheet-item {
            padding: 8px 10px;

            border-bottom: 1px solid #e2e8f0;

            font-size: 11px;

            color: #475569;
        }

        .sheet-item:last-child {
            border-bottom: none;
        }

        .info {
            margin-top: 18px;

            background: #eef5fa;

            border-left: 4px solid #123b5d;

            border-radius: 6px;

            padding: 12px 14px;

            font-size: 11px;

            line-height: 1.6;

            color: #475569;
        }

        .action {
            text-align: center;

            margin-top: 22px;
        }

        .btn {
            border: none;

            background: #16817a;

            color: white;

            padding: 11px 28px;

            border-radius: 7px;

            font-size: 12px;

            font-weight: bold;

            cursor: pointer;
        }

        .btn:hover {
            background: #116b65;
        }

        @media(max-width: 700px) {

            .grid {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>


<body>


<header class="header">

    <div class="header-inner">

        <div class="identity">

            <h1>
                KEMENTERIAN PERHUBUNGAN
                REPUBLIK INDONESIA
            </h1>

            <p>
                DISTRIK NAVIGASI TIPE A KELAS I AMBON
            </p>

        </div>

    </div>

</header>


<main class="container">


    <div class="title">

        <h2>
            Data Siap Dibandingkan
        </h2>

        <p>
            Konfigurasi sumber data telah berhasil disimpan.
        </p>

    </div>


    <div class="success">

        ✓ Data berhasil disiapkan untuk proses matching.

    </div>


    <div class="grid">


        {{-- SUMBER 1 --}}

        <div class="card">

            <span class="badge">
                SUMBER 1
            </span>

            <h3>
                {{ $source1['name'] }}
            </h3>


            <div class="filename">

                File sumber pertama

            </div>


            @if ($allSheets1)

                <div class="all">

                    <strong>Semua Sheet</strong>

                    <br>

                    Seluruh sheet akan digunakan.

                </div>

            @else

                <span class="label">
                    Sheet yang dipilih
                </span>

                <div class="all">

                    {{ $source1Sheets[0] }}

                </div>

            @endif


            <span class="label">
                Sheet yang akan diproses
            </span>


            <div class="sheet-list">

                @foreach ($source1Sheets as $sheet)

                    <div class="sheet-item">

                        {{ $sheet }}

                    </div>

                @endforeach

            </div>

        </div>



        {{-- SUMBER 2 --}}

        <div class="card">

            <span class="badge">
                SUMBER 2
            </span>

            <h3>
                {{ $source2['name'] }}
            </h3>


            <div class="filename">

                File sumber kedua

            </div>


            @if ($allSheets2)

                <div class="all">

                    <strong>Semua Sheet</strong>

                    <br>

                    Seluruh sheet akan digunakan.

                </div>

            @else

                <span class="label">
                    Sheet yang dipilih
                </span>

                <div class="all">

                    {{ $source2Sheets[0] }}

                </div>

            @endif


            <span class="label">
                Sheet yang akan diproses
            </span>


            <div class="sheet-list">

                @foreach ($source2Sheets as $sheet)

                    <div class="sheet-item">

                        {{ $sheet }}

                    </div>

                @endforeach

            </div>

        </div>


    </div>


    <div class="info">

        <strong>Tahap berikutnya:</strong>

        Setelah ini kita akan menentukan kolom yang digunakan
        untuk proses matching. Sistem nantinya juga akan menyediakan
        pilihan <strong>Semua Kolom</strong>.

    </div>


    <div class="action">

        {{-- Untuk sementara belum menjalankan matching --}}

        <button
            type="button"
            class="btn"
            onclick="alert('Tahap pemilihan kolom akan kita buat berikutnya.')"
        >

            Lanjut ke Pemilihan Kolom

        </button>

    </div>


</main>


</body>

</html>