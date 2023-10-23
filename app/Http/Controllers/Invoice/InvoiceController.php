<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;

class InvoiceController extends Controller
{
    public function index()
    {
        $this->exportPDF();
        return view('templates/invoice');
    }

    public function exportPDF()
    {
        /*$data = [];
        $mergeData = [];
        $pdf = PDF::loadView('templates.ticket_test');
        return $pdf->download('test.pdf');
        //return view('templates/ticket'); */

        PDF::loadView('templates.invoice_pdf')
            ->setPaper('a4')
            ->save(public_path('invoice-test.pdf'));
    }
}
