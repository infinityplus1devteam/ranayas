@extends('layouts.admin-master')
@section('title', 'Update Ticket')
@section('content')

    <section class="section">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-dark text-white-all">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.return-tickets.all') }}"> Manage Tickets</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-pencil-alt"></i> Update Ticket</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-header bg-dark text-white-all">
                <h4>Update Ticket</h4>
            </div>
            <div class="card-body">
        <form method="post" class="needs-validation">
            @csrf
            <div class="row">
                @if($ticket->status == false)
                <div class="col-md-12">
                    <h2 class="text-danger">
                        Ticket has been Closed on {{ date('d-m-Y h:i A', strtotime($ticket->closed_at)) }}
                    </h2>
                </div>
                @endif
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" value="{{ $ticket->email }}" readonly>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Subject</label>
                        <input class="form-control" value="{{ $ticket->subject }}" readonly>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Raised By</label>
                        <input class="form-control" value="{{ $ticket->open_by }}" readonly>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Raised Date</label>
                        <input class="form-control" value="{{ date('d-m-Y h:i A', strtotime($ticket->created_at)) }}"
                            readonly>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Closed Date</label>
                        <input class="form-control"
                            value="{{ $ticket->closed_at ? date('d-m-Y h:i A', strtotime($ticket->closed_at)) : 'Not closed yet' }}"
                            readonly>
                    </div>
                </div>
                @if($ticket->status == true)

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control">
                            <option value="">--Select--</option>
                            <option value="1" {{ $ticket->status == true ? 'selected': '' }}>Open</option>
                            <option value="0" {{ $ticket->status == false ? 'selected': '' }}>Closed</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description">Write Description <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" rows="5" class="form-control"
                            placeholder="Please Write description here..."
                            required>{{ $ticket->description }}</textarea>
                    </div>
                </div>


                <div class="col-md-6 text-danger">
                    Note : All * Mark Fields are Compulsory !
                </div>

                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary btnSubmit"> <i class="fas fa-pencil-alt"></i>
                        Update</button>
                </div>

                @else

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status</label>
                        <input class="form-control" value="Closed" readonly>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" readonly rows="5">{{ $ticket->description }}</textarea>
                    </div>
                </div>

                @endif

            </div>
        </form>
    </div>
</div>
</section>

@endsection