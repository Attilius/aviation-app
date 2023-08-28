<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Invoice</title>

    <style>
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
            font-family: sans-serif;
        }

        .frame {
            width: 90%;
            height: auto;
            margin-left: auto;
            margin-right: auto;
            padding: 40px;
        }

        main {
            margin-top: 30px;
        }

        .bg-blue-100 {
            background-color: #dbeafe;
        }

        .bg-blue-900 {
            background-color: #1e3a8a;
        }

        .invoice-title {
            font-size: 50px;
            margin-top: 50px;
        }

        .verified {
            height: 150px;
            margin-left: 20px;
        }

        .qr-code {
            height: 150px;
            margin-left: -12px;
        }

        .company-logo {
            height: 150px;
            margin-left: 20px;
        }

        .inline-block {
            display: inline-block;
        }

        .text-white {
            color: white;
        }

        .font-medium {
            font-weight: 600;
        }

        .float-right {
           float: right;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .p-5 {
            padding: 5px;
        }

        .pl-10 {
            padding-left: 10px;
        }

        .pl-35 {
            padding-left: 35px;
        }

        .pt-5{
            padding-top: 5px;
        }

        .py-2 {
            padding: 2px 0 2px 0;
        }

        .text-sm {
            font-size: 16px;
        }

        .text-end {
            text-align: right;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mt-100 {
            margin-top: 100px;
        }

        .my-10 {
            margin: 10px 0 10px 0;
        }

        .border-b {
            border-bottom: 1px solid darkgray;
        }

        .border-collapse {
            border-collapse: collapse;
        }

        .border-none {
            border-spacing: 0;
        }

        .w-full {
            width: 100%;
        }

        .w-8 {
            width:8%;
        }

        .w-20 {
            width: 20%;
        }

        .w-52 {
            width: 52%
        }

        .pl-5 {
            padding-left: 5px;
        }

        .mt-60 {
            margin-top: 60px;
        }

        .ml-50 {
            margin-left: 50px;
        }

        .text-xs {
            font-size: 12px;
        }

    </style>

</head>
<body class="bg-blue-100">
<div class="frame">
    <header>
        <div class="inline-block float-left">
            <img class="company-logo" src="{{ public_path('img/logos/lorem-logo.png') }}" alt="company logo">
            <h3 class="font-medium">Lorem Airlines - Fly With Us</h3>
            <p class="text-sm pt-5">13 Dolore St</p>
            <p class="text-sm ">New York, NY 10131</p>
            <p class="text-sm ">United States</p>
            <p class="text-sm ">lorem_airlines@loremairlines.com</p>
            <p class="text-sm ">+1 1323456789</p>

            <h3 class="font-medium mt-20">Bill To:</h3>
            <p class="text-sm pt-5">Demo User</p>
            <p class="text-sm ">13 Dolore St</p>
            <p class="text-sm ">New York, NY 10131</p>
            <p class="text-sm ">United States</p>
            <p class="text-sm ">demo_user@demo.com</p>
            <p class="text-sm ">+1 1323456789</p>
        </div>
        <div class="inline-block float-right">
            <h3 class="uppercase invoice-title">Invoice</h3>
            <p class="font-medium pl-35">Invoice No.: 2023/000123</p>

            <h3 class="mt-20 font-medium text-end">Reservation No.</h3>
            <p class="text-sm text-end">AXN0013LMAF6981</p>
            <h3 class="mt-20 font-medium text-end">Ticket No.</h3>
            <p class="text-sm text-end">TIC-007-LA9999</p>

            <p class="text-end mt-100">Invoice Date:<span class="pl-10">2023-08-20</span></p>
            <p class="text-end">Terms:<span class="pl-10">Due on Receipt</span></p>
            <p class="text-end">Due Date:<span class="pl-10">2023-08-20</span></p>
        </div>
    </header>

    <main>
        <table class="w-full mt-10 border-collapse border-none">
            <thead>
            <tr class="bg-blue-900 text-white">
                <td class="w-8 p-5">#</td>
                <td class="w-52 w-96 p-5">Item & description</td>
                <td class="w-8 w-16 p-5 text-end">Qty</td>
                <td class="w-20 w-16 p-5 text-end">Rate</td>
                <td class="w-20 p-5 text-end">Amount</td>
            </tr>
            </thead>
            <tbody>
            <tr class="border-b">
                <td class="w-8 p-5">1</td>
                <td class="w-52 p-5 text-start">Right to find fault with a man who chooses to enjoy a pleasure</td>
                <td class="w-8 p-5 text-end">1.00</td>
                <td class="w-20 p-5 text-end">100.00</td>
                <td class="w-20 p-5 text-end">1234.00</td>
            </tr>
            </tbody>
            <tfoot>
            <tr class="">
                <td class="py-2 text-end" colspan="4">Taxable amount:</td>
                <td class="text-end">1234.00</td>
            </tr>
            <tr class="">
                <td class="py-2 text-end" colspan="4">Discount 0.0%:</td>
                <td class="text-end">$0.00</td>
            </tr>
            <tr class="w-full">
                <td class="py-2 text-end" colspan="4">Total cost:</td>
                <td class="font-medium text-end">$1234.00</td>
            </tr>
            </tfoot>
        </table>

        <hr class="my-10">
    </main>

    <footer>
        <div class="inline-block mt-60">
            <h4 class="font-medium">Pay using UPI:</h4>
            <img class="qr-code" src="{{ public_path('img/payment/qr-code.png') }}" alt="QR code">
            <h3 class="font-medium">Notes:</h3>
            <p class="text-sm">Thank you for your reservation</p>
        </div>
        <div class="inline-block ml-50" style="position: relative; top: -110px;">
            <h4 class="font-medium" style="margin-bottom: 5px;">Bank Details:</h4>
            <p>Bank:<span class="font-medium pl-5">Royal Bank of England</span></p>
            <p>Account:<span class="font-medium pl-5">999999</span></p>
            <p>IPSC:<span class="font-medium pl-5">YES9999</span></p>
            <p>Branch:<span class="font-medium pl-5">Personal</span></p>
        </div>
        <div class="inline-block ml-50" style="position: relative; top: -25px;">
            <h4 class="font-medium">Verification:</h4>
            <img class="verified" src="{{ public_path('img/payment/verified.png') }}" alt="verification">
            <p class="">Authenticated by
                <i>
                    <span class="font-medium" style="color: #093773; margin-left: -2px; font-weight: 700">Pay</span>
                    <span class="font-medium" style="color: #11cdef; margin-left: -5px; font-weight: 700">Pal</span>
                </i>
            </p>
        </div>

        <h4 class="font-medium">Terms and Conditions:</h4>
        <p class="text-xs font-normal pt-2">1. Denouncing of a pleasure and praising pain was born and I will give you a complete account</p>
        <p class="text-xs font-normal">2. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but occasionally</p>
        <p class="text-xs font-normal">3. On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized</p>
        <p class="text-xs font-normal">4. These cases are perfectly simple and easy to distinguish</p>
        <p class="text-xs font-normal">5. Claims of duty or the obligations of business it will frequently occur that pleasures</p>
    </footer>

</div>
</body>
</html>
<script>
    import Banner from "../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Components/Banner";
    export default {
        components: {Banner}
    }
</script>
