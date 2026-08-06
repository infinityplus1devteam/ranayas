@extends('layouts.admin-master')
@section('title', 'Mail Logs')
@section('content')

<section class="section">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-dark text-white-all">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-envelope"></i> Mail Logs</li>
        </ol>
    </nav>

    {{-- Summary Cards --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="border-left: 4px solid #4e73df !important;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-1" style="color:#4e73df;font-size:0.75rem;letter-spacing:0.05em;">Total Logs</div>
                        <div class="h4 mb-0 font-weight-bold text-dark">{{ number_format($totalCount) }}</div>
                    </div>
                    <i class="fas fa-inbox fa-2x text-muted opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="border-left: 4px solid #1cc88a !important;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-1" style="color:#1cc88a;font-size:0.75rem;letter-spacing:0.05em;">Sent Successfully</div>
                        <div class="h4 mb-0 font-weight-bold text-dark">{{ number_format($successCount) }}</div>
                    </div>
                    <i class="fas fa-check-circle fa-2x text-muted opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="border-left: 4px solid #e74a3b !important;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-1" style="color:#e74a3b;font-size:0.75rem;letter-spacing:0.05em;">Failed</div>
                        <div class="h4 mb-0 font-weight-bold text-dark">{{ number_format($failedCount) }}</div>
                    </div>
                    <i class="fas fa-times-circle fa-2x text-muted opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="border-left: 4px solid #f6c23e !important;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-1" style="color:#f6c23e;font-size:0.75rem;letter-spacing:0.05em;">Today</div>
                        <div class="h4 mb-0 font-weight-bold text-dark">{{ number_format($todayCount) }}</div>
                    </div>
                    <i class="fas fa-calendar-day fa-2x text-muted opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white-all d-flex align-items-center">
            <i class="fas fa-filter mr-2"></i> <h4 class="mb-0">Filter Logs</h4>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.mail_logs.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small font-weight-bold">Status</label>
                        <select name="status" class="form-control">
                            <option value="">All Statuses</option>
                            <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>✅ Success</option>
                            <option value="failed"  {{ request('status') === 'failed'  ? 'selected' : '' }}>❌ Failed</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small font-weight-bold">Form Source</label>
                        <select name="form_source" class="form-control">
                            <option value="">All Forms</option>
                            <option value="Enquiry Popup"      {{ request('form_source') === 'Enquiry Popup'      ? 'selected' : '' }}>Enquiry Popup</option>
                            <option value="Sell with Us Popup" {{ request('form_source') === 'Sell with Us Popup' ? 'selected' : '' }}>Sell with Us Popup</option>
                            <option value="Contact Page"       {{ request('form_source') === 'Contact Page'       ? 'selected' : '' }}>Contact Page</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small font-weight-bold">From Date</label>
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small font-weight-bold">To Date</label>
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small font-weight-bold">Search Name / Email / IP</label>
                        <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-1 d-flex gap-1">
                        <button type="submit" class="btn btn-dark btn-sm" title="Apply Filter"><i class="fas fa-search"></i></button>
                        <a href="{{ route('admin.mail_logs.index') }}" class="btn btn-secondary btn-sm" title="Clear Filter"><i class="fas fa-times"></i></a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Logs Table --}}
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white-all d-flex align-items-center justify-content-between">
            <h4 class="mb-0"><i class="fas fa-list mr-2"></i>Mail Logs</h4>
            <span class="badge badge-light">{{ $logs->total() }} records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0" style="font-size:0.875rem;">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Date & Time</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Subject</th>
                            <th>Form Source</th>
                            <th>Status</th>
                            <th>IP Address</th>
                            <th>Error Summary</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                        <tr>
                            <td>{{ $log->id }}</td>
                            <td style="white-space:nowrap;">{{ $log->created_at->format('d M Y') }}<br><small class="text-muted">{{ $log->created_at->format('h:i A') }}</small></td>
                            <td>{{ $log->from_name }}</td>
                            <td>{{ $log->from_email }}</td>
                            <td>{{ $log->phone ?? '-' }}</td>
                            <td>{{ Str::limit($log->subject, 30) }}</td>
                            <td>
                                @if($log->form_source === 'Contact Page')
                                    <span class="badge" style="background:#6c757d;color:#fff;">Contact Page</span>
                                @elseif($log->form_source === 'Sell with Us Popup')
                                    <span class="badge" style="background:#6f42c1;color:#fff;">Sell Popup</span>
                                @else
                                    <span class="badge" style="background:#17a2b8;color:#fff;">Enquiry Popup</span>
                                @endif
                            </td>
                            <td>
                                @if($log->status === 'success')
                                    <span class="badge badge-success px-2 py-1">✅ SUCCESS</span>
                                @else
                                    <span class="badge badge-danger px-2 py-1">❌ FAILED</span>
                                @endif
                            </td>
                            <td><code style="font-size:0.75rem;">{{ $log->ip_address ?? '-' }}</code></td>
                            <td>
                                @if($log->status === 'failed' && $log->error_message)
                                    <span class="text-danger" style="font-size:0.75rem;" title="{{ $log->error_message }}">
                                        {{ Str::limit($log->error_message, 50) }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.mail_logs.show', $log->id) }}" class="btn btn-sm btn-outline-dark" title="View Full Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                No mail logs found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($logs->hasPages())
        <div class="card-footer">
            {{ $logs->links() }}
        </div>
        @endif
    </div>

</section>

@endsection
