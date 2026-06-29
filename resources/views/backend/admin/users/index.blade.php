@extends('layouts.admin-master')
@section('title', 'Manage Customers')
@section('content')
<section class="section">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-dark text-white-all">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i>
                    Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-list"></i> Users</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header bg-dark text-white-all">
            <h4>Manage Users</h4>
            <form action="{{ route('admin.users.exports') }}" method="post" id="formExport">
                @csrf
                <button type="submit" class="btn btn-outline-success btnSubmit">
                    <i class="fa fa-file-excel"></i> Export Excel
                </button>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover datatable" style="width:100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>image</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            @if($user->image_url)
                            <td>
                                <img src="{{ $user->image_url }}" class="img-responsive img-circle"
                                    alt="{{ $user->name }}" width="40">
                            </td>
                            @else
                            <td>
                                <i class="fa fa-user-circle fa-3x" aria-hidden="true"></i>
                            </td>
                            @endif
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->mobile }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at ? $user->created_at->format('d M Y, h:i A') : 'N/A' }}</td>
                            <td>
                                {{ $user->status == true ? 'Active' : 'Blocked' }}
                            </td>
                            <td>
                                <div class="dropdown d-inline">
                                    <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                        id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                            class="dropdown-item has-icon" title="Edit Detail">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>

                                        <a href="{{ route('admin.users.show', $user->id) }}"
                                            class="dropdown-item has-icon" title="View Detail">
                                            <i class="fa fa-eye"></i> View
                                        </a>

                                        <a href="{{ route('admin.users.orders', $user->id) }}"
                                            class="dropdown-item has-icon" title="Order History">
                                            <i class="fa fa-shopping-cart"></i> Order History
                                        </a>

                                        <a href="{{ route('admin.users.reviews', $user->id) }}"
                                            class="dropdown-item has-icon" title="Reviews">
                                            <i class="fa fa-star"></i> Reviews
                                        </a>

                                        <a href="{{ route('admin.users.addresses', $user->id) }}"
                                            class="dropdown-item has-icon" title="Addresses">
                                            <i class="fa fa-address-card"></i> Addresses
                                        </a>

                                        @if($user->status == true)

                                        <a href="javascript:void(0)" class="dropdown-item has-icon block-object"
                                            title="Order History" data-obj-id="{{ $user->id }}">
                                            <i class=" fa fa-times"></i> Block
                                        </a>

                                        @else

                                        <button type="button" data-obj-id="{{ $user->id }}"
                                            class="dropdown-item unblock-object" title="Unblock User">
                                            <i class="fa fa-check text-success"></i> Unblock
                                        </button>

                                        @endif

                                    </div>
                                </div>

                            </td>
                        </tr>
                        @empty
                        <tr class="text-center">
                            <td class="text-danger" colspan="9">
                                <h4>No Record Found..</h4>
                            </td>
                        </tr>
                        @endforelse
                        @if($users->total() > 50)
                        <tr class="text-center">
                            <td colspan="9">
                                {{ $users->links() }}
                            </td>
                        </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>image</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <form id="formBlock" method="POST" action="{{ route('admin.users.block') }}">
        @csrf
        <input type="hidden" name="user_id" id="txtBlockUserID">
    </form>
    <form id="formUnblock" method="POST" action="{{ route('admin.users.unblock') }}">
        @csrf
        <input type="hidden" name="user_id" id="txtUnblockUserID">
    </form>

</section>
@endsection

@section('extrajs')
<script>
    $(document).ready(function () {

            $(".block-object").click(function () {
                if (window.confirm("Are you sure, You want to Block ? ")) {
                    $("#txtBlockUserID").val($(this).attr("data-obj-id"));
                    $("#formBlock").submit();
                    $(this).html('wait...');
                }
            });

            $(".unblock-object").click(function () {
                if (window.confirm("Are you sure, You want to Unblock ? ")) {
                    $("#txtUnblockUserID").val($(this).attr("data-obj-id"));
                    $("#formUnblock").submit();
                    $(this).html('wait...');
                }
            });

            $('.btnSubmit').click(function () {
                $(this).html('<span class="fa fa-spinner fa-spin"></span> Loading...');
                $(this).attr('disabled', 'disabled');
                $('#formExport').submit();

                setTimeout(function () {
                    $('.btnSubmit').html('<i class="fa fa-file-excel"></i> Export Excel');
                    $('.btnSubmit').removeAttr('disabled');
                }, 2000);
            });
        });

</script>
@endsection