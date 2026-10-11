<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Pilih Sheet | Data Matching
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
            margin: 38px auto;
        }

        .title {
            text-align: center;
            margin-bottom: 25px;
        }

        .title h2 {
            color: #123b5d;
            font-size: 25px;
            margin-bottom: 6px;
        }

        .title p {
            font-size: 13px;
            color: #64748b;
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

        label {
            display: block;

            font-size: 12px;
            font-weight: bold;

            color: #334155;

            margin-bottom: 7px;
        }

        select {
            width: 100%;

            padding: 11px 12px;

            border: 1px solid #cbd5e1;
            border-radius: 7px;

            background: white;

            font-size: 13px;
            color: #334155;

            cursor: pointer;
        }

        select:focus {
            outline: none;
            border-color: #16817a;
        }

        .hint {
            margin-top: 10px;

            font-size: 11px;
            line-height: 1.5;

            color: #64748b;
        }

        .info {
            margin-top: 18px;

            background: #fffaf0;

            border-left: 4px solid #d6a84f;

            border-radius: 6px;

            padding: 12px 14px;

            font-size: 11px;
            line-height: 1.6;

            color: #5f6670;
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

        .errors {
            width: 92%;
            max-width: 850px;

            margin: 20px auto;

            background: #fff1f2;

            border-left: 4px solid #be123c;

            border-radius: 6px;

            padding: 12px 15px;

            color: #9f1239;

            font-size: 12px;
        }

        @media(max-width: 700px) {

            .grid {
                grid-template-columns: 1fr;
            }

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

    </style>

</head>


<body>


<header class="header">

    <div class="header-inner">
        <!-- LOGO + HEADER -->
        <div class="header-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">

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



@if ($errors->any())

    <div class="errors">

        @foreach ($errors->all() as $error)

            {{ $error }}

        @endforeach

    </div>

@endif



<main class="container">


    <div class="title">

        <h2>
            Pilih Sheet Data
        </h2>

        <p>
            Pilih sheet yang ingin dibandingkan
            atau gunakan seluruh sheet.
        </p>

    </div>



    <form
        action="{{ route('matching.select-sheets') }}"
        method="POST"
    >

        @csrf


        <div class="grid">


            {{-- SUMBER 1 --}}

            <div class="card">

                <span class="badge">
                    SUMBER 1
                </span>

                <h3>
                    File Pertama
                </h3>

                <div class="filename">

                    {{ $source1['name'] }}

                </div>


                <label for="source_1_sheet">

                    Sheet yang dibandingkan

                </label>


                <select
                    name="source_1_sheet"
                    id="source_1_sheet"
                    required
                >

                    <option value="__ALL__">

                        Semua Sheet

                    </option>


                    @foreach ($source1['sheets'] as $sheet)

                        <option value="{{ $sheet }}">

                            {{ $sheet }}

                        </option>

                    @endforeach

                </select>


                <div class="hint">

                    Pilih <strong>Semua Sheet</strong>
                    jika seluruh isi workbook ingin
                    diproses.

                </div>

            </div>



            {{-- SUMBER 2 --}}

            <div class="card">

                <span class="badge">
                    SUMBER 2
                </span>

                <h3>
                    File Kedua
                </h3>

                <div class="filename">

                    {{ $source2['name'] }}

                </div>


                <label for="source_2_sheet">

                    Sheet yang dibandingkan

                </label>


                <select
                    name="source_2_sheet"
                    id="source_2_sheet"
                    required
                >

                    <option value="__ALL__">

                        Semua Sheet

                    </option>


                    @foreach ($source2['sheets'] as $sheet)

                        <option value="{{ $sheet }}">

                            {{ $sheet }}

                        </option>

                    @endforeach

                </select>


                <div class="hint">

                    Pilih <strong>Semua Sheet</strong>
                    jika seluruh isi workbook ingin
                    diproses.

                </div>

            </div>


        </div>



        <div class="info">

            <strong>Catatan:</strong>

            Jika memilih <strong>Semua Sheet</strong>,
            sistem akan menyimpan seluruh daftar sheet
            untuk diproses pada tahap matching berikutnya.

        </div>



        <div class="action">

            <button
                type="submit"
                class="btn"
            >

                Lanjutkan

            </button>

        </div>


    </form>


</main>


</body>

</html>