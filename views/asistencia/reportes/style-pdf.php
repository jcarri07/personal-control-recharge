    <header>
        <style>
            @page {
                margin-left: 2cm;
                margin-right: 2cm;
                margin-top: 100px;
                margin-bottom: 70px;
            }

            body {
                font-family: Arial, Helvetica, sans-serif;
            }

            table {
                border-collapse: collapse;
                width: 100%;
                page-break-inside: avoid;
            }

            .table {
                width: 100%;
                margin-bottom: 0.2rem;

                color: #293240;
            }

            .m-0 {
                margin: 0px;
            }

            .mb-1 {
                margin-bottom: 0.25rem;
            }

            .ml-1 {
                margin-left: 0.25rem;
            }

            .f-italic {
                font-style: italic;
            }

            .card {
                position: relative;
                display: flex;
                flex-direction: column;
                min-width: 0;
                word-wrap: break-word;
                background-color: #fff;
                background-clip: border-box;
                border: 0px solid rgba(0, 0, 0, 0.125);
                border-radius: 4px;
                padding: 30px;
            }

            .card-body {
                flex: 1 1 auto;
                min-height: 1px;
                padding: 25px;
            }

            td {
                text-align: center;
            }

            h2 {
                text-align: center;
            }

            h1 {
                text-align: center;
            }

            .row {
                display: flex;
                flex-wrap: wrap;
                margin-right: -15px;
                margin-left: -15px;
            }

            .col-12 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            td {
                border: 1px solid #1e1e1e;
                text-align: center;
                background-color: #fff;
                padding: 5px;
                font-size: 12px;
            }

            th {
                border: 1px solid #1e1e1e;
                text-align: center;
                padding: 5px;
                font-size: 12px;
                font-weight: 1000;
            }

            h4 {
                font-weight: 100;
            }

            /* .contenedor p {
                flex: 1;
                white-space: nowrap;
                font-size: calc(0.8vw + 0.8vh);
            } */

            #watermark {

                bottom: 0px;
                left: 0px;
                /** El ancho y la altura pueden cambiar
                    según las dimensiones de su membrete
                **/
                width: 21.8cm;
                height: 28cm;
                opacity: 0.3;
                position: fixed;
                top: 25%;
                left: 21%;
                margin: -25px 0 0 -25px;
                /** Tu marca de agua debe estar detrás de cada contenido **/
                z-index: -1000;
            }

            header,
            footer {
                position: fixed;
                left: 0px;
                right: 0px;
            }

            header {
                height: 60px;
                margin-top: -60px;
            }

            footer {
                height: 50px;
                margin-bottom: -50px;
            }

            tr th,
            tr td {
                word-wrap: break-word !important;
                white-space: normal !important;
                max-width: 100px !important;
            }

            li {
                list-style-type: none;
            }

            ul {
                padding-left: 0.6cm;
            }
        </style>
    </header>