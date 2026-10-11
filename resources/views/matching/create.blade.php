<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Matching Data | Distrik Navigasi Tipe A Kelas I Ambon
    </title>


    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }


        body {

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background: #f4f7fa;

            color: #1e293b;

            min-height: 100vh;
        }


        /* HEADER */

        .header {

            background: #123b5d;

            color: white;

            border-bottom:
                4px solid #d6a84f;
        }


        .header-inner {

            max-width: 1100px;

            width: 92%;

            margin: auto;

            min-height: 82px;

            display: flex;

            align-items: center;

            gap: 15px;
        }
        .header-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-logo img {
            width: 65x;
            height: 65px;
            object-fit: contain;
        }

        .logo {

            width: 52px;

            height: 52px;

            background: white;

            border-radius: 7px;

            display: flex;

            align-items: center;

            justify-content: center;

            color: #123b5d;

            font-size: 9px;

            font-weight: bold;

            text-align: center;

            flex-shrink: 0;
        }


        .identity h1 {

            font-size: 16px;

            letter-spacing: .3px;

            margin-bottom: 4px;
        }


        .identity p {

            font-size: 13px;

            color: #dbe7ef;
        }


        /* MAIN */

        .container {

            max-width: 1050px;

            width: 92%;

            margin: 42px auto;
        }


        .heading {

            text-align: center;

            margin-bottom: 28px;
        }


        .heading span {

            display: inline-block;

            background: #dceeea;

            color: #16817a;

            padding: 5px 13px;

            border-radius: 20px;

            font-size: 11px;

            font-weight: bold;

            letter-spacing: .5px;

            margin-bottom: 10px;
        }


        .heading h2 {

            color: #123b5d;

            font-size: 30px;

            margin-bottom: 8px;
        }


        .heading p {

            color: #64748b;

            font-size: 14px;
        }


        /* SOURCE GRID */

        .source-grid {

            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 20px;
        }


        .source-card {

            background: white;

            border-radius: 12px;

            border:
                1px solid #d9e2ec;

            box-shadow:
                0 5px 18px
                rgba(18, 59, 93, .07);

            padding: 24px;
        }


        .source-header {

            display: flex;

            align-items: center;

            gap: 12px;

            margin-bottom: 20px;
        }


        .source-number {

            width: 38px;

            height: 38px;

            border-radius: 8px;

            display: flex;

            align-items: center;

            justify-content: center;

            background: #123b5d;

            color: white;

            font-weight: bold;
        }


        .source-header h3 {

            font-size: 17px;

            color: #123b5d;
        }


        .source-header p {

            color: #64748b;

            font-size: 12px;

            margin-top: 3px;
        }


        /* FILE INPUT */

        .file-box {

            border:
                1.5px dashed #aebdcc;

            background: #f8fafc;

            border-radius: 9px;

            padding: 20px;

            text-align: center;

            transition: .2s;
        }


        .file-box:hover {

            border-color: #16817a;

            background: #f2faf9;
        }


        .file-icon {

            font-size: 25px;

            margin-bottom: 8px;
        }


        .file-box strong {

            display: block;

            font-size: 13px;

            color: #334155;

            margin-bottom: 5px;
        }


        .file-box small {

            display: block;

            color: #64748b;

            font-size: 11px;

            margin-bottom: 12px;
        }


        input[type="file"] {

            width: 100%;

            font-size: 12px;
        }


        /* BUTTON */

        .action {

            text-align: center;

            margin-top: 25px;
        }


        .btn {

            border: none;

            background: #16817a;

            color: white;

            padding: 12px 30px;

            border-radius: 7px;

            font-size: 13px;

            font-weight: bold;

            cursor: pointer;

            transition: .2s;
        }


        .btn:hover {

            background: #116b65;

            transform: translateY(-1px);
        }


        /* INFO */

        .info {

            margin-top: 25px;

            background: #fffaf0;

            border-left:
                4px solid #d6a84f;

            padding: 13px 16px;

            border-radius: 6px;

            color: #5f6670;

            font-size: 12px;

            line-height: 1.6;
        }


        /* ERROR */

        .errors {

            max-width: 1050px;

            margin: 20px auto;

            width: 92%;

            background: #fff1f2;

            border-left:
                4px solid #be123c;

            padding: 12px 15px;

            border-radius: 6px;

            color: #9f1239;

            font-size: 13px;
        }


        /* FOOTER */

        footer {

            text-align: center;

            padding: 25px;

            color: #64748b;

            font-size: 11px;

            margin-top: 35px;
        }


        @media(max-width: 700px) {

            .source-grid {

                grid-template-columns: 1fr;
            }


            .identity h1 {

                font-size: 13px;
            }


            .heading h2 {

                font-size: 25px;
            }

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


    <section class="heading">

        <span>
            SISTEM INFORMASI
        </span>

        <h2>
            Matching Data
        </h2>

        <p>
            Bandingkan dua sumber data secara
            cepat dan terstruktur.
        </p>

    </section>



    <form
        action="{{ route('matching.upload') }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf


        <section class="source-grid">


            <!-- SUMBER 1 -->

            <div class="source-card">


                <div class="source-header">

                    <div class="source-number">
                        1
                    </div>

                    <div>

                        <h3>
                            Sumber 1
                        </h3>

                        <p>
                            Data utama
                        </p>

                    </div>

                </div>


                <div class="file-box">

                    <div class="file-icon">
                        📁
                    </div>

                    <strong>
                        Pilih file data
                    </strong>

                    <small>
                        Excel (.xlsx/.xls) atau CSV
                    </small>


                    <input
                        type="file"
                        name="source_1"
                        accept=".xlsx,.xls,.csv"
                        required
                    >

                </div>


            </div>



            <!-- SUMBER 2 -->

            <div class="source-card">


                <div class="source-header">

                    <div class="source-number">
                        2
                    </div>

                    <div>

                        <h3>
                            Sumber 2
                        </h3>

                        <p>
                            Data pembanding
                        </p>

                    </div>

                </div>


                <div class="file-box">

                    <div class="file-icon">
                        📁
                    </div>

                    <strong>
                        Pilih file data
                    </strong>

                    <small>
                        Excel (.xlsx/.xls) atau CSV
                    </small>


                    <input
                        type="file"
                        name="source_2"
                        accept=".xlsx,.xls,.csv"
                        required
                    >

                </div>


            </div>


        </section>



        <div class="action">

            <button
                type="submit"
                class="btn"
            >

                Lanjutkan

            </button>

        </div>


    </form>



    <div class="info">

        <strong>Catatan:</strong>

        Sumber 1 dan Sumber 2 dapat menggunakan
        dua file berbeda maupun file yang sama.
    </div>


</main>



<footer>

    © {{ date('Y') }}
    Distrik Navigasi Tipe A Kelas I Ambon
    · Sistem Matching Data

</footer>


</body>

</html>