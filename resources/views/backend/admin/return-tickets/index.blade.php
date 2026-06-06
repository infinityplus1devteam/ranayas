@extends('layouts.admin-master')
@section('title', 'Manage Return & Refund Tickets')
@section('content')
<section class="section">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-dark text-white-all">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i>
                    Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-list"></i> Manage Return & Refund
                Tickets</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-block">
            <div class="table-responsive dt-responsive">
                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Raise By</th>
                            <th>Status</th>
                            <th>Raise On</th>
                            <th>Closed On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->email }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($ticket->subject, 30) }}</td>
                            <td>{{ $ticket->open_by }}</td>
                            <td>{{ $ticket->status == true ? 'Open' : 'Closed' }}</td>
                            <td>{{ date('d-M-Y h:i A', strtotime($ticket->created_at)) }}</td>
                            <td>{{ $ticket->closed_at ? date('d-m-Y h:i A', strtotime($ticket->closed_at)) : 'Not closed yet' }}
                            </td>
                            <td>
                                <div class="dropdown d-inline">
                                    <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                        id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('admin.return-tickets.edit', $ticket->id) }}"
                                            class="dropdown-item has-icon" title="Edit Detail">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="text-center">
                            <td class="text-danger" colspan="8">
                                <h4>No Record Found..</h4>
                            </td>
                        </tr>
                        @endforelse
                        @if($tickets->total()>50)
                        <tr class="text-center">
                            <td colspan="8">
                                {{ $tickets->links() }}
                            </td>
                        </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Raise By</th>
                            <th>Status</th>
                            <th>Raise On</th>
                            <th>Closed On</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</section>
@endsection
