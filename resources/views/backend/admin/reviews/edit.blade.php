@extends('layouts.admin-master')
@section('title', 'Update Review')
@section('content')

<section class="section">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-dark text-white-all">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-list"></i>Edit Review</li>
            <li class="breadcrumb-item"><a href="{{ route('admin.reviews.all') }}"> All Reviews</a></li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header bg-dark text-white-all">
            <h4>Update Review</h4>
        </div>
        <div class="card-body">
            <form method="post" class="needs-validation" enctype="multipart/form-data" id="formUpdateReview">
                @csrf
                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Email <span class="text-danger">*</span></label>
                            <input value="{{ $review->email }}" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="product_id">
                                Product <span class="text-danger">*</span>
                            </label>
                            <select name="product_id" id="product_id" class="form-control">
                                <option value="">--Select Product</option>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}"
                                    {{ $product->id == $review->product_id ? 'selected' : '' }}>
                                    {{ $product->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $review->name }}"
                                placeholder="Enter Customer Name" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="review_date">Review Date <span class="text-danger">*</span></label>
                            <input type="date" name="review_date" id="review_date" class="form-control"
                                placeholder="dd-mm-yyyy" value="{{ date('Y-m-d', strtotime($review->created_at)) }}"
                                required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Rating <span class="text-danger">*</span></label>
                            <div class="starability-grow">
                                <input type="radio" id="growing-rate1" class="star" name="rating" checked value="1"
                                    {{ $review->rating== 1 ? 'checked' : ''}}>
                                <label for="growing-rate1" title="Terrible">1 star</label>

                                <input type="radio" id="growing-rate2" class="star" name="rating" value="2"
                                    {{ $review->rating== 2 ? 'checked' : ''}}>
                                <label for="growing-rate2" title="Not good">2 stars</label>

                                <input type="radio" id="growing-rate3" class="star" name="rating" value="3"
                                    {{ $review->rating== 3 ? 'checked' : ''}}>
                                <label for="growing-rate3" title="Average">3 stars</label>

                                <input type="radio" id="growing-rate4" class="star" name="rating" value="4"
                                    {{ $review->rating== 4 ? 'checked' : ''}}>
                                <label for="growing-rate4" title="Very good">4 stars</label>

                                <input type="radio" id="growing-rate5" class="star" name="rating" value="5"
                                    {{ $review->rating== 5 ? 'checked' : ''}}>
                                <label for="growing-rate5" title="Amazing">5 stars</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control">
                                <option value="pending" {{ is_null($review->status) ? 'selected': '' }}>Pending</option>
                                <option value="1" {{ (!is_null($review->status) && $review->status == true) ? 'selected': '' }}>Approved</option>
                                <option value="0" {{ (!is_null($review->status) && $review->status == false) ? 'selected': '' }}>Disapproved</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="comment">Write your Review <span class="text-danger">*</span></label>
                            <textarea name="comment" id="comment" rows="5" class="form-control"
                                placeholder="Please Write Something..." required>{{ $review->comment }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Profile Photo</label>
                            <div>
                                @if ($review->image_url)
                                <img src="/storage/images/reviews/{{ $review->image_url }}" alt="{{ $review->name }}"
                                    class="img img-responsive img-thumbnail" width="120px">
                                @else
                                <div class="review-alpha">
                                    <h1>{{ strtoupper(substr($review->name,0,2)) }}</h1>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="email" value="{{ $review->email }}">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary btnSubmit"> <i class="fas fa-pencil-alt"></i>
                            Update</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</section>
@endsection

@section('extrajs')
<script>
    $("#formUpdateReview").validate({
         rules: {

            product_id: {
               required: true
            },

            name: {
               required: true
            },

            review_date: {
               required: true
            },

            rating: {
               required: true
            },

            status: {
               required: true
            },

            comment: {
               required: true
            },

         },
         messages: {

            product_id: {
               required: "Please Select Product"
            },

            name: {
               required: "Please Enter Name"
            },

            review_date: {
               required: "Please Select Review Date"
            },

            status: {
               required: "Please Select Status"
            },

            rating: {
               required: "Please Select Rating"
            },

            comment: {
               required: "Please Enter Comment"
            },

         },
         submitHandler: function (form) {
            $('.btnSubmit').attr('disabled', 'disabled');
            $(".btnSubmit").html('<span class="fa fa-spinner fa-spin"></span> Loading...');
            form.submit();
         }
      });
</script>
@endsection
