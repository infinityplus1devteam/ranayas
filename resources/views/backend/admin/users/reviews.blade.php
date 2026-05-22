@extends('layouts.admin-master')
@section('title', 'Customer Reviews')
@section('content')

<section class="section">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-dark text-white-all">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-list"></i>User Detail</li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.all') }}"> All Users</a></li>
        </ol>
    </nav>


    <div class="card">
        <div class="card-header bg-dark text-white-all">
            <h4>Customer Information</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 bg-white pt-20">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Customer Name</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email ID</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Mobile Number</th>
                                <td>{{ $user->mobile }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $user->address }}</td>
                            </tr>
                            <tr>
                                <th>Landmark</th>
                                <td>{{ $user->landmark }}</td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>{{ $user->city }}</td>
                            </tr>
                            <tr>
                                <th>Territory</th>
                                <td>{{ $user->territory }}</td>
                            </tr>
                            <tr>
                                <th>Pincode</th>
                                <td>{{ $user->pincode }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-dark text-white-all">
            <h4>Reviews Information</h4>
        </div>
        <div class="card-body">

            <div class="col-md-12 bg-white pt-20">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Product Name</th>
                            <th>Rating</th>
                            <th>Verified</th>
                            <th>Status</th>
                            <th>Reviewed On</th>
                            <th>Action</th>
                        </tr>

                    </thead>

                    <tbody>
                        @forelse ($user->reviews as $review)
                        <tr>
                            <td>{{ $review->id }}</td>
                            <td>
                                @if ($review->image_url)
                                <img src="/storage/images/reviews/{{ $review->image_url }}" alt="{{ $review->name }}"
                                    class="img img-responsive img-circle" width="40px" height="40px" loading="lazy">
                                @else
                                <div class="review-alpha1">
                                    <h3>{{ strtoupper(substr($review->name,0,2)) }}</h3>
                                </div>
                                @endif
                            </td>
                            <td>{{ $review->name }}</td>
                            <td>{{ $review->product->title }}</td>
                            <td>
                                @for($i = 1; $i<= $review->rating; $i++)
                                    <i class="fa fa-star"></i>
                                    @endfor
                                    @for($i = 1; $i<= 5 - $review->rating; $i++)
                                        <i class="fa fa-star-o"></i>
                                        @endfor
                            </td>
                            <td>
                                {{ $review->verified == true ? 'Yes' : 'No' }}
                            </td>
                            <td>
                                @if (is_null($review->status))
                                    <span class="badge badge-warning">Pending</span>
                                @elseif ($review->status == true)
                                    <span class="badge badge-success">Approved</span>
                                @else
                                    <span class="badge badge-danger">Disapproved</span>
                                @endif
                            </td>
                            <td>{{ date('d-M-Y', strtotime($review->created_at)) }}</td>
                            <td>
                                <div class="dropdown d-inline">
                                    <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                        id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('admin.reviews.edit', $review->id) }}"
                                            class="dropdown-item has-icon" title="Edit Detail">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
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

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Product Name</th>
                            <th>Rating</th>
                            <th>Verified</th>
                            <th>Status</th>
                            <th>Reviewed On</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>

                </table>
            </div>
        </div>
    </div>
</section>
@endsection
