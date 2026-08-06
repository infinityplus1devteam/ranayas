<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\MailLog;
use Illuminate\Http\Request;

class MailLogController extends Controller
{
    public function index(Request $request)
    {
        $query = MailLog::query();

        // Filter by status
        if ($request->filled('status') && in_array($request->status, ['success', 'failed'])) {
            $query->where('status', $request->status);
        }

        // Filter by form source
        if ($request->filled('form_source')) {
            $query->where('form_source', $request->form_source);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('from_name', 'like', "%{$search}%")
                  ->orWhere('from_email', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        $logs = $query->orderBy('id', 'DESC')->paginate(25)->withQueryString();

        // Summary counts
        $totalCount   = MailLog::count();
        $successCount = MailLog::where('status', 'success')->count();
        $failedCount  = MailLog::where('status', 'failed')->count();
        $todayCount   = MailLog::whereDate('created_at', today())->count();

        return view('backend.admin.mail_logs.index', compact(
            'logs', 'totalCount', 'successCount', 'failedCount', 'todayCount'
        ));
    }

    public function show($id)
    {
        $log = MailLog::findOrFail($id);
        return view('backend.admin.mail_logs.show', compact('log'));
    }
}
