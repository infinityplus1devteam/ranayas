<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrderExport;
use App\Http\Controllers\Controller;
use App\Model\TxnOrder;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = TxnOrder::orderBy('id', 'DESC')->whereNotIn('status', ['nc']);
        
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $from = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $to = date('Y-m-d 23:59:59', strtotime($request->to_date));
            $orders = $orders->whereBetween('created_at', [$from, $to]);
        } elseif ($request->filled('from_date')) {
            $from = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $orders = $orders->where('created_at', '>=', $from);
        } elseif ($request->filled('to_date')) {
            $to = date('Y-m-d 23:59:59', strtotime($request->to_date));
            $orders = $orders->where('created_at', '<=', $to);
        }

        if ($request->filled('status')) {
            $orders = $orders->where('status', 'like', '%' . $request->status . '%');
        }

        if ($request->filled('filter')) {
            switch ($request->filter) {
                case 'day':
                    $orders = $orders->whereDate('created_at', Carbon::today());
                    break;

                case 'week':
                    $orders = $orders->whereBetween('created_at', [Carbon::today()->subDays(7), Carbon::now()]);
                    break;

                case 'month':
                    $orders = $orders->whereBetween('created_at', [Carbon::today()->subDays(30), Carbon::now()]);
                    break;

                case 'year':
                    $orders = $orders->whereBetween('created_at', [Carbon::today()->subDays(365), Carbon::now()]);
                    break;
            }
        }

        $orders = $orders->paginate(50);

        return view('backend.admin.reports.index', compact('orders'))->with('dates', ['from_date' => $request->from_date, 'to_date' => $request->to_date, 'status' => $request->status, 'filter' => $request->filter]);
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
        //
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

    public function generateReport(Request $request)
    {
        $request->validate([
            'from_date' => 'nullable|date_format:Y-m-d',
            'to_date' => 'nullable|date_format:Y-m-d',
            'status' => 'nullable|string|max:191',
            'filter' => 'nullable|string|max:10',
        ],
            [
                'from_date.date_format' => 'Please Enter From Date in dd-mm-yyyy format',
                'to_date.date_format' => 'Please Enter To Date in dd-mm-yyyy format',
                'to_date.required_with' => 'Please Enter From Date',
            ]);

        $orders = TxnOrder::with('details')->orderBy('id', 'ASC')->whereNotIn('status', ['nc']);

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $from = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $to = date('Y-m-d 23:59:59', strtotime($request->to_date));
            $orders = $orders->whereBetween('created_at', [$from, $to]);
        } elseif ($request->filled('from_date')) {
            $from = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $orders = $orders->where('created_at', '>=', $from);
        } elseif ($request->filled('to_date')) {
            $to = date('Y-m-d 23:59:59', strtotime($request->to_date));
            $orders = $orders->where('created_at', '<=', $to);
        }

        if ($request->filled('status')) {
            $orders = $orders->where('status', 'like', '%' . $request->status . '%');
        }

        if ($request->filled('filter')) {
            switch ($request->filter) {
                case 'day':
                    $orders = $orders->whereDate('created_at', Carbon::today());
                    break;

                case 'week':
                    $orders = $orders->whereBetween('created_at', [Carbon::today()->subDays(7), Carbon::now()]);
                    break;

                case 'month':
                    $orders = $orders->whereBetween('created_at', [Carbon::today()->subDays(30), Carbon::now()]);
                    break;

                case 'year':
                    $orders = $orders->whereBetween('created_at', [Carbon::today()->subDays(365), Carbon::now()]);
                    break;
            }
        }

        $orders = $orders->get();
        // return view('backend.admin.reports.report', compact('orders'))->with('dates', ['from_date' => $request->from_date, 'to_date' => $request->to_date]);
        $pdf = PDF::loadView('backend.admin.reports.report', ['orders' => $orders, 'dates' => ['from_date' => $request->from_date, 'to_date' => $request->to_date], 'filter' => $request->filter]);

        return $pdf->download('Report_on_' . \Carbon\Carbon::parse(now())->format('d_m_Y_h_i_s') . '.pdf');

    }

    public function exportGeneratedReport(Request $request)
    {
        return Excel::download(new OrderExport, 'Report_on_' . \Carbon\Carbon::parse(now())->format('d_m_Y_h_i_s') . '.xlsx');
    }
}
