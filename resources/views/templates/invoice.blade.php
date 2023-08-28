<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" />

    <title>Invoice</title>


</head>
<body class="font-sans antialiased">
    <div class="container mx-auto w-9/12 p-14 border bg-blue-100">
        <header class="flex justify-between">
            <div class="w-1/4 flex-center">
                <img src="{{URL::asset('/img/logos/lorem-logo.png')}}" alt="company logo">
                <p class="font-semibold">Lorem Airlines - Fly With Us</p>
                <p class="text-sm font-normal pt-2">13 Dolore St</p>
                <p class="text-sm font-normal">New York, NY 10131</p>
                <p class="text-sm font-normal">United States</p>
                <p class="text-sm font-normal">lorem_airlines@loremairlines.com</p>
                <p class="text-sm font-normal">+1 1323456789</p>
            </div>
            <div class="w-1/4 flex-center float-right py-10">
                <h1 class="text-5xl uppercase font-medium" style="text-align: end">invoice</h1>
                <p class="text-sm font-medium py-3 pl-1" style="text-align: end">Invoice No. 2023/000123</p>
                <h1 class="mt-5 font-medium  pl-1" style="text-align: end">Reservation No.</h1>
                <p class="text-sm pl-1" style="text-align: end">AXN0013LMAF6981</p>
                <h1 class="mt-5 font-medium pl-1" style="text-align: end">Ticket No.</h1>
                <p class="text-sm pl-1" style="text-align: end">TIC-007-LA9999</p>
            </div>
        </header>
        <div class="flex justify-between items-center">
            <div class="mt-10">
                <h1 class="text-md font-medium">Bill To:</h1>
                <p class="text-sm font-normal pt-2">Demo User</p>
                <p class="text-sm font-normal">13 Dolore St</p>
                <p class="text-sm font-normal">New York, NY 10131</p>
                <p class="text-sm font-normal">United States</p>
                <p class="text-sm font-normal">demo_user@demo.com</p>
                <p class="text-sm font-normal">+1 1323456789</p>
            </div>
            <div>
                <p class="w-full text-end">Invoice Date:<span class="text-md pl-3">2023-08-20</span></p>
                <p class="w-full ml-5">Terms:<span class="text-md pl-3">Due on Receipt</span></p>
                <p class="w-full ml-5">Due Date:<span class="text-md pl-3">2023-08-20</span></p>
            </div>
        </div>


        <table class="w-full mt-10">
            <thead>
            <tr class="flex justify-between bg-blue-900 text-white p-1">
                <td class="text-start">#</td>
                <td class="w-96 text-start">Item & description</td>
                <td class="w-16 text-end">Qty</td>
                <td class="w-16 text-end">Rate</td>
                <td class="text-end">Amount</td>
            </tr>
            </thead>
            <tbody>
            <tr class="flex justify-between p-1 border-b border-black">
                <td class="text-start flex items-center">1</td>
                <td class="w-96 text-start">Right to find fault with a man who chooses to enjoy a pleasure</td>
                <td class="w-16 text-end flex items-center">1.00</td>
                <td class="w-16 text-end flex items-center">100.00</td>
                <td class="text-end flex items-center">1234.00</td>
            </tr>
            </tbody>
            <tfoot>
            <tr class="flex justify-end p-1">
                <td class="pr-3">Taxable amount:</td>
                <td>1234.00</td>
            </tr>
            <tr class="w-60 flex justify-end p-1 float-right">
                <td class="pr-3">Discount 0.0%:</td>
                <td>$0.00</td>
            </tr>
            <tr class="w-full flex justify-end p-1">
                <td class="pr-3">Total cost:</td>
                <td class="font-bold">$1234.00</td>
            </tr>
            </tfoot>
        </table>

        <hr class="my-5 border-black">

        <footer class="">
            <div class="flex justify-between">
                <div>
                    <h2 class="text-md font-medium relative top-2 z-10">Pay using UPI:</h2>
                    <img class="w-40 h-40 relative -left-3" src="{{URL::asset('/img/payment/qr-code.png')}}" alt="QR code">
                    <h2 class="text-md font-medium">Notes:</h2>
                    <p class="text-sm font-normal">Thank you for your reservation</p>
                </div>
                <div>
                    <h1 class="text-md font-medium relative top-2 pb-3">Bank Details:</h1>
                    <p>Bank:<span class="text-md font-bold pl-3">Royal Bank of England</span></p>
                    <p>Account:<span class="text-md font-bold pl-3">999999</span></p>
                    <p>IPSC:<span class="text-md font-bold pl-3">YES9999</span></p>
                    <p>Branch:<span class="text-md font-bold pl-3">Personal</span></p>
                </div>
                <div>
                    <h1 class="text-md font-medium">Verification:</h1>
                    <img class="w-40 h-40" src="{{URL::asset('/img/payment/verified.png')}}" alt="verification">
                    <h2 class="text-md">Authenticated by
                        <span class="font-bold italic" style="color: #093773">Pay</span>
                        <span class="font-bold italic relative -left-1" style="color: #11cdef">Pal</span>
                    </h2>
                </div>
            </div>

            <h2 class="text-md font-medium pt-3">Terms and Conditions:</h2>
            <p class="text-xs font-normal pt-2">1. Denouncing of a pleasure and praising pain was born and I will give you a complete account</p>
            <p class="text-xs font-normal">2. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but occasionally</p>
            <p class="text-xs font-normal">3. On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized</p>
            <p class="text-xs font-normal">4. These cases are perfectly simple and easy to distinguish</p>
            <p class="text-xs font-normal">5. Claims of duty or the obligations of business it will frequently occur that pleasures</p>
        </footer>


    </div>
</body>
</html>
