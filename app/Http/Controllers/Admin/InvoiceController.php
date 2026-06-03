<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\TxnOrder;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = TxnOrder::whereNotIn('status', ['nc'])->orderBy('id', 'DESC');

        if ($request->filled('order_id')) {
            $orders = $orders->where('id', $request->order_id);
        }

        if ($request->filled('city')) {
            $orders = $orders->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('pincode')) {
            $orders = $orders->where('pincode', 'like', '%' . $request->pincode . '%');
        }

        if ($request->filled('order_date')) {
            $orders = $orders->where('created_at', 'like', '%' . date('Y-m-d', strtotime($request->order_date)) . '%');
        }

        $orders = $orders->paginate(50);
        return view('backend.admin.invoices.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $invoice = TxnOrder::where('id', $id)->with('details', 'user', 'transaction')->firstOrFail();
            return view('backend.admin.invoices.show', compact('invoice'));

        } catch (\Exception $ex) {
            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {

                connectify('error', 'Error', 'Whoops, Order Not Found !');

                return redirect(route('admin.invoices.all'));
            }

            connectify('error', 'Error', 'Whoops, Something went wrong from our end !');

            return redirect(route('admin.invoices.all'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function downloadInvoice($id)
    {
        try {

            $invoice = TxnOrder::where('id', $id)->with('details', 'user', 'transaction')->firstOrFail();

            //  return view('backend.admin.invoices.download', compact('invoice'));

            $pdf = PDF::loadView('backend.admin.invoices.download', ['invoice' => $invoice]);

            // Storage::put('public/pdf/order_no_' . $id . '.pdf', $pdf->output());

            return $pdf->download('order_no_' . $id . '.pdf');

        } catch (\Exception $ex) {
            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {

                connectify('error', 'Error', 'Whoops, Order Not Found !');

                return redirect(route('admin.invoices.all'));
            }

            \Log::error(['invoice download' => $ex->getMessage()]);
            connectify('error', 'Error', 'Whoops, Something Went Wrong from our end !');

            return redirect(route('admin.invoices.all'));
        }
    }

    public function resendInvoice(Request $request)
    {
        try {

            $invoice = TxnOrder::where('id', $request->order_id)->with('details', 'user', 'transaction')->firstOrFail();
            $pdf = PDF::loadView('backend.admin.invoices.download', ['invoice' => $invoice]);
            Mail::send(['html' => 'backend.admin.invoices.empty'], ['invoice' => $invoice], function ($message) use ($invoice, $pdf) {
                $message->from(env('MAIL_FROM_ADDRESS', 'info@ranayas.com'), env('MAIL_FROM_NAME', 'Ranayas'));
                $message->to($invoice->user->email, $invoice->user->name);
                $message->subject('Invoice copy of Order No ' . $invoice->id . ' From Ranayas');
                $message->attachData($pdf->output(), 'order_no_' . $invoice->id . '.pdf');
            });

            connectify('success', 'invoice Sent', 'Invoice Sent Successfully !');

            return redirect(route('admin.invoices.all'));

        } catch (\Exception $ex) {
            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {

                connectify('error', 'Error', 'Whoops, Order Not Found !');

                return redirect(route('admin.invoices.all'));
            }

            \Log::error(['invoice resend' => $ex->getMessage()]);
            // temporary debug output:
            // return $ex->getMessage();
            connectify('error', 'Error', 'Whoops, Something Went Wrong from our end !');

            return redirect(route('admin.invoices.all'));
        }
    }
}
