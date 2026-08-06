@extends('layouts.admin-master')
@section('title', 'Mail Log Detail #' . $log->id)
@section('content')

<section class="section">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-dark text-white-all">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.mail_logs.index') }}"><i class="fas fa-envelope"></i> Mail Logs</a></li>
            <li class="breadcrumb-item active" aria-current="page">Log #{{ $log->id }}</li>
        </ol>
    </nav>

    <div class="row">
        {{-- Left: Sender Info + Meta --}}
        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-dark text-white-all">
                    <h5 class="mb-0"><i class="fas fa-user mr-2"></i>Sender Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0" style="font-size:0.9rem;">
                        <tr>
                            <td class="font-weight-bold text-muted" style="width:130px;">Log ID</td>
                            <td><span class="badge badge-secondary">#{{ $log->id }}</span></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-muted">Status</td>
                            <td>
                                @if($log->status === 'success')
                                    <span class="badge badge-success px-2 py-1">✅ SUCCESS</span>
                                @else
                                    <span class="badge badge-danger px-2 py-1">❌ FAILED</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-muted">Form Source</td>
                            <td>
                                @if($log->form_source === 'Contact Page')
                                    <span class="badge" style="background:#6c757d;color:#fff;">Contact Page</span>
                                @elseif($log->form_source === 'Sell with Us Popup')
                                    <span class="badge" style="background:#6f42c1;color:#fff;">Sell with Us Popup</span>
                                @else
                                    <span class="badge" style="background:#17a2b8;color:#fff;">Enquiry Popup</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-muted">Date & Time</td>
                            <td>{{ $log->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-muted">Name</td>
                            <td>{{ $log->from_name }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-muted">Email</td>
                            <td><a href="mailto:{{ $log->from_email }}">{{ $log->from_email }}</a></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-muted">Phone</td>
                            <td>{{ $log->phone ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-muted">Subject</td>
                            <td>{{ $log->subject ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-muted">IP Address</td>
                            <td><code>{{ $log->ip_address ?? '—' }}</code></td>
                        </tr>
                        @if($log->error_code)
                        <tr>
                            <td class="font-weight-bold text-muted">Error Code</td>
                            <td><span class="badge badge-warning">{{ $log->error_code }}</span></td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        {{-- Right: Message + Error --}}
        <div class="col-lg-7 mb-4">
            {{-- Message --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-dark text-white-all">
                    <h5 class="mb-0"><i class="fas fa-comment-alt mr-2"></i>Message Submitted</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0" style="white-space: pre-wrap; line-height: 1.7;">{{ $log->message ?? '—' }}</p>
                </div>
            </div>

            {{-- User Agent --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-desktop mr-2"></i>User Agent (Browser / Bot)</h5>
                </div>
                <div class="card-body">
                    <code style="font-size: 0.8rem; word-break: break-all;">{{ $log->user_agent ?? '—' }}</code>
                </div>
            </div>

            {{-- Error Detail (only if failed) --}}
            @if($log->status === 'failed')
            <div class="card shadow-sm border-0 border-left-danger" style="border-left: 4px solid #e74a3b !important;">
                <div class="card-header" style="background: #e74a3b;">
                    <h5 class="mb-0 text-white"><i class="fas fa-exclamation-triangle mr-2"></i>Full Error Detail</h5>
                </div>
                <div class="card-body" style="background: #fff8f8;">
                    @if($log->error_message)
                        <pre style="font-size: 0.78rem; white-space: pre-wrap; word-break: break-all; color: #c0392b; background: transparent; border: none; padding: 0; margin: 0; max-height: 400px; overflow-y: auto;">{{ $log->error_message }}</pre>
                    @else
                        <span class="text-muted">No error detail recorded.</span>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    <a href="{{ route('admin.mail_logs.index') }}" class="btn btn-dark">
        <i class="fas fa-arrow-left mr-1"></i> Back to Mail Logs
    </a>

</section>

@endsection
