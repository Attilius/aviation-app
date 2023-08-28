<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ticket</title>

    <style>
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
            font-family: sans-serif;
        }

        .frame {
            width: 90%;
            margin-left: auto;
            margin-right: auto;
            padding: 56px;
        }

        header {
            background-color: #11cdef;
            height: 64px;
            border-top-left-radius: 50px;
            border-top-right-radius: 50px;
        }

        main {
            height: 288px
        }

        footer {
            height: 40px;
            background-color: #11cdef;
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
        }

        .airplane {
            height: 120%;
            margin-top: -30px;
            float: right;
            margin-right: 350px;
        }

        .barcode {
            position: relative;
            left: -40px;
            height: 280px;
            margin-top: 5px;
            float: left;
        }

        .company-logo {
            height: 56px;
            float: left;
            width: 8%;
            margin-left: 50px;
        }

        .name-title {
            position: relative;
            top: 0;
            padding: 25px 0 2px 20px;
        }

        .name-value {
            position: relative;
            top: -4px;
            padding: 0 0 5px 20px;
            font-size: 18px;
        }

        .from {
            position: relative;
            top: 0;
            padding: 0 0 0 20px;
        }

        .to {
            position: relative;
            top: 0;
            padding: 0 0 10px 20px;
        }

        .right-side {
            border-left: darkgray dashed 2px;
            height: 288px;
            width: 340px;
            display: inline-block;
            position: absolute;
            right: 56px;
        }

        .text-white {
            color: white;
        }

        .text-right {
            float: right;
            width: 25%;
            margin-top: 24px;
        }

        .text-center {
            float: right;
            width: 30%;
            margin-top: 24px;
        }

        .ticket-number-title {
            position: relative;
            top: 0;
            padding: 0 0 0 20px;
        }

        .ticket-number-value {
            position: relative;
            top: 0;
            padding: 0 0 10px 20px;
            font-size: 12px;
        }

        .font-medium {
            font-weight: 600;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .seat-date-title {
            position: relative;
            top: 0;
            padding: 0 0 0 20px;
        }

        .seat-date-border {
            border-top: solid darkgray 2px;
            border-right: solid darkgray 2px;
        }

        .seat-date-value {
            position: relative;
            top: 0;
            padding: 0 0 10px 20px;
        }

        .mr-20 {
            margin-right: 20px
        }

        .mr-30 {
            margin-right: 30px;
        }

        .mr-40 {
            margin-right: 40px;
        }

        .seat-date-padding {
            padding-top: 2px;
            padding-right: 2px;
        }

        .gate-bording-time-title {
            position: relative;
            top: 0;
            padding: 0 0 0 20px;
            color: #11cdef;
        }

        .gate-bording-time-value {
            position: relative;
            top: 0;
            padding: 0 0 0 20px;
            color: #11cdef;
            font-size: 32px;
        }

        .dashed-footer {
            border-left: darkgray dashed 2px;
            height: 100%;
            width: 340px;
            display: inline-block;
            margin-left: 668px;
        }

        .dashed-header {
            border-left: darkgray dashed 2px;
            height: 100%;
            width: 340px;
            display: inline-block;
            margin-left: 537px;
        }

        .left-side {
            position: absolute;
            width: 250%;
            left: 0;
            top: 0;
            margin-left: 20px;
        }

        .left-titles {
            font-size: 18px;
            font-weight: 400;
        }

        .name-from-to-block {
            position: absolute;
            left: -50px;
            top: 160px;
            width: inherit;
            display: inline-block;
        }

        .carrier-date-block {
            width: 20px;
            position: relative;
            left: 280px;
            top: 160px;
            display: inline-block;
        }

        .flightNumber-luggage-block {
            width: inherit;
            position: relative;
            left: 520px;
            top: 58px;
            display: inline-block;
        }

        .class-seat-block {
            width: inherit;
            position: relative;
            left: 620px;
            top: -44px;
            display: inline-block;
        }

        .text-sm {
            font-size: 16px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .gate-boardingTime-ticketNumber-block{
            position: relative;
            left: 150px;
        }

        .ticket-number-block {
            position: relative;
            top: -110px;
            left: 360px;
        }

        .bording-time-block {
            position: relative;
            top: -59px;
            left: 160px;
        }
    </style>

</head>
<body>
    <div class="frame">
        <div class="flex-col">
            <header>
                <img class="company-logo" src="{{ public_path('img/logos/lorem-logo-white.png') }}" alt="company logo">
                <span class="text-white font-medium uppercase text-right">boarding pass</span>
                <span class="text-white font-medium uppercase text-center">boarding pass</span>
                <div class="dashed-header"></div>
            </header>
            <main>
                <img class="barcode" src="{{ public_path('img/logos/bar-code.png') }}" alt="barcode">
                <img class="airplane" src="{{ public_path('img/logos/airplane-lightgray-right.png') }}" alt="airplane">

                <!-- Left side of ticket -->

                <div class="left-side">
                    <div class="name-from-to-block">
                        <p class="left-titles">Name of Passenger:</p>
                        <p class="font-medium text-sm">Demo User</p>
                        <p class="left-titles mt-20">From: <span class="font-medium text-sm">Budapest (BUD)</span></p>
                        <p class="left-titles">To: <span class="font-medium text-sm">Paris (CDG</span></p>
                    </div>
                    <div class="carrier-date-block">
                        <p class="left-titles">Carrier:</p>
                        <p class="font-medium text-sm">LA</p>
                        <p class="left-titles mt-20">Date:</p>
                        <p class="font-medium text-sm">2023/08/20</p>
                    </div>
                    <div class="flightNumber-luggage-block">
                        <p class="left-titles">Flight No.:</p>
                        <p class="font-medium text-sm">LA1100</p>
                        <p class="left-titles mt-20">Luggage:</p>
                        <p class="font-medium text-sm">Y</p>
                    </div>
                    <div class="class-seat-block">
                        <p class="left-titles">Class:</p>
                        <p class="font-medium text-sm">Economy</p>
                        <p class="left-titles mt-20">Seat:</p>
                        <p class="font-medium text-sm">5A</p>
                    </div>
                    <div class="gate-boardingTime-ticketNumber-block">
                        <div class="gate-block">
                            <p class="gate-bording-time-title">
                                <span class="mr-20 seat-date-padding uppercase">Gate:</span>
                            </p>
                            <p class="gate-bording-time-value">
                                <span class="mr-30 font-medium">A1</span>
                            </p>
                        </div>
                        <div class="bording-time-block">
                            <p class="gate-bording-time-title">
                                <span class="seat-date-padding uppercase">Boarding Time:</span>
                            </p>
                            <p class="gate-bording-time-value">
                                <span class="font-medium">07:30</span>
                            </p>
                        </div>
                        <div class="ticket-number-block">
                            <p class="ticket-number-title">Ticket No.:</p>
                            <p class="ticket-number-value">TIC-007-LA9999</p>
                        </div>
                    </div>
                </div>

                <!-- Right side of ticket -->

                <div class="right-side">
                    <p class="name-title">Name of Passenger:</p>
                    <p class="name-value font-medium">Demo User</p>
                    <p class="from">From: <span class="font-medium">Budapest (BUD)</span></p>
                    <p class="to">To: <span class="font-medium">Paris (CDG)</span></p>
                    <p class="ticket-number-title">Ticket No.:</p>
                    <p class="ticket-number-value">TIC-007-LA9999</p>
                    <p class="seat-date-title">
                        <span class="mr-20 seat-date-border seat-date-padding">Seat:</span>
                        <span class="seat-date-border seat-date-padding">Date:</span>
                    </p>
                    <p class="seat-date-value">
                        <span class="mr-40 font-medium ">5A</span>
                        <span class="font-medium">2023/08/20</span>
                    </p>
                    <p class="gate-bording-time-title">
                        <span class="mr-20 seat-date-border seat-date-padding uppercase">Gate:</span>
                        <span class="seat-date-border seat-date-padding uppercase">Boarding Time:</span>
                    </p>
                    <p class="gate-bording-time-value">
                        <span class="mr-30 font-medium ">A1</span>
                        <span class="font-medium">07:30</span>
                    </p>
                </div>
            </main>
            <footer>
                <div class="dashed-footer"></div>
            </footer>
        </div>
    </div>
</body>
</html>
