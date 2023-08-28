<!DOCTYPE html>
<html lang="">
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
    </style>

</head>
<body style="-webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;">
    <div style="width: 75%; margin-left: auto; margin-right: auto; padding: 56px;">
        <div style="display: flex; flex-direction: column;">
            <header style="background-color: #11cdef; height: 64px; display: flex; justify-content: space-around; align-items: center; border-top-left-radius: 25px; border-top-right-radius: 25px;">

                <img style="height: 56px" src="{{url('/img/logos/lorem-logo-white.png')}}" alt="company logo">
                <h3 style="color: white; text-transform: uppercase; font-weight: 500">boarding pass</h3>
                <h3 style="color: white; text-transform: uppercase; font-weight: 500">boarding pass</h3>
            </header>
            <main style="display: flex; height: 288px">
                <img style="height: 280px; position: relative; bottom: 0; left: 0"
                     src="{{url('/img/logos/bar-code.png')}}" alt="barcode">
                <img style="height: 384px; position: relative; bottom: 48px; left: 128px" src="{{url('/img/logos/airplane-lightgray-right.png')}}" alt="airplane">
            </main>
            <footer style="height: 40px; background-color: #11cdef; border-bottom-left-radius: 25px; border-bottom-right-radius: 25px;"></footer>
        </div>

        <!-- Right side of Ticket -->

        <div style="position: relative; bottom: 388px; left: 780px; border-left: 2px; border-left-style: dashed;
                    border-left-color: darkgray; width: 25%; height: 384px; padding: 64px 0 64px 12px;"
        >
            <p style="font-weight: 500; color: #111827; margin-top: 20px;">Name of Passenger:</p>
            <p style="font-size: 14px; line-height: 20px; font-weight: 600; text-transform: uppercase; color: #111827">Demo User</p>
            <p style="font-weight: 500; margin-top: 8px;">From:<span style="font-size: 14px; line-height: 20px; padding-left: 8px;">Budapest (BUD)</span></p>
            <p style="font-weight: 500;">To:<span style="font-size: 14px; line-height: 20px; padding-left: 8px;">Paris (CDG)</span></p>
            <p style="font-weight: 500; margin-top: 8px;">Ticket No.:</p>
            <p style="font-size: 12px; line-height: 16px;">TIC-007-LA9999</p>
            <div style="display: flex; margin-top: 8px;">
                <div style="display: flex; flex-direction: column">
                    <span style="font-weight: 500; border-top: solid lightgray 2px; border-right: solid lightgray 2px; padding-right: 4px;">Seat:</span>
                    <p style="font-weight: 500">5A</p>
                </div>
                <div style="display: flex; flex-direction: column; margin-left: 20px;">
                    <span style="font-weight: 500; border-top: solid lightgray 2px; border-right: solid lightgray 2px; padding-right: 4px; width: 44px;">Date:</span>
                    <p style="font-weight: 500;">2023/08/20</p>
                </div>
            </div>
            <div style="display: flex; margin-top: 12px;">
                <div style="display: flex; flex-direction: column">
                    <span style="color: #11cdef; text-transform: uppercase; font-weight: 500; border-top: solid lightgray 2px; border-right: solid lightgray 2px; padding-right: 4px;"
                    >gate</span>
                    <p style="color: #11cdef; font-weight: 500; font-size: 30px; line-height: 36px">A1</p>
                </div>
                <div style="display: flex; flex-direction: column; margin-left: 20px;">
                    <span style="color: #11cdef; text-transform: uppercase; font-weight: 500; border-top: solid lightgray 2px; border-right: solid lightgray 2px; padding-right: 4px;"
                    >boarding time</span>
                    <p style="color: #11cdef; font-weight: 500; font-size: 30px; line-height: 36px">07:30</p>
                </div>
            </div>
        </div>

        <!-- Left side of Ticket -->

        <div style="display: flex; flex-direction: column; position: relative; bottom: 700px; left: 140px; width: 600px;"
        >
            <!-- Top section -->

            <div style="width: 100%; display: flex; justify-content: center; align-items: center; margin-top: 30px;">
                <div style="width: 300px;">
                    <h3 style="font-weight: 500;">Name of Passenger:</h3>
                    <p style="text-transform: uppercase; font-weight: 600;">Demo User</p>
                </div>
                <div style="width: 100px;">
                    <h3 style="font-weight: 500;">Carrier:</h3>
                    <p style="text-transform: uppercase; font-weight: 600;">LA</p>
                </div>
                <div style="width: 100px;">
                    <h3 style="font-weight: 500;">Flight No.:</h3>
                    <p style="text-transform: uppercase; font-weight: 600;">LA1100</p>
                </div>
                <div style="width: 100px;">
                    <h3 style="font-weight: 500;">Class:</h3>
                    <p style="text-transform: uppercase; font-weight: 600;">Economy</p>
                </div>
            </div>

            <!-- Center section -->

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 30px;">
                <div style="width: 300px;">
                    <p style="font-weight: 500; margin-top: 6px;">From:<span style="padding-left: 4px;">Budapest (BUD)</span></p>
                    <p style="font-weight: 500;">To:<span style="padding-left: 4px;">Paris (CDG)</span></p>
                </div>
                <div style="width: 100px; display: flex; flex-direction: column;">
                    <span style="font-weight: 500;">Date:</span>
                    <p style="font-weight: 500;">2023/08/20</p>
                </div>
                <div style="width: 100px; display: flex; flex-direction: column;">
                    <span style="font-weight: 500;">Luggage:</span>
                    <p style="font-weight: 500;">Y</p>
                </div>
                <div style="width: 100px; display: flex; flex-direction: column;">
                    <span style="font-weight: 500;">Seat:</span>
                    <p style="font-weight: 500;">5A</p>
                </div>
            </div>

            <!-- Bottom section -->

            <div style="display: flex; justify-content: space-around; align-items: center; margin-top: 30px;">
                <div style="display: flex; flex-direction: column;">
                    <span style="color: #11cdef; text-transform: uppercase; font-weight: 500; padding-right: 4px;"
                    >gate</span>
                    <p style="color: #11cdef; font-weight: 500; font-size: 30px; line-height: 36px;">A1</p>
                </div>
                <div style="display: flex; flex-direction: column;">
                    <span style="color: #11cdef; text-transform: uppercase; font-weight: 500; padding-right: 4px;"
                    >boarding time</span>
                    <p style="color: #11cdef; font-weight: 500; font-size: 30px; line-height: 36px;">07:30</p>
                </div>
                <div>
                    <h3 style="font-weight: 500; margin-top: 8px;">Ticket No.:</h3>
                    <p style="font-size: 12px; line-height: 16px;">TIC-007-LA9999</p>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
