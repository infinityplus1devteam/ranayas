@extends('layouts.admin-master')
@section('title', 'Update Home Offer Slider')
@section('content')

<section class="section">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-dark text-white-all">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-list"></i>Update Home Offer Slider Detail</li>
            <li class="breadcrumb-item"><a href="{{ route('admin.home-offer-sliders.all') }}"> All Home Offer Slider</a></li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header bg-dark text-white-all">
            <h4>Update Home Offer Slider</h4>
        </div>
        <div class="card-body">
            <form method="post" class="needs-validation" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" id="title" class="form-control"
                                        placeholder="Enter Title" value="{{ $homeOfferSlider->title }}">
                                </div>
                            </div> --}}
                          
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sort_index">Sort Index <span class="text-danger">*</span></label>
                                    <input type="number" name="sort_index" class="form-control" id="sort_index"
                                        value="{{ $homeOfferSlider->sort_index }}" placeholder="Enter Sort Index" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="url">Url (Optional)</label>
                                    <input type="text" name="url" id="url" class="form-control" placeholder="Enter Url"
                                        value="{{ $homeOfferSlider->url }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="">--Select--</option>
                                        <option value="1" {{ $homeOfferSlider->status == true ? 'selected': '' }}>Activate</option>
                                        <option value="0" {{ $homeOfferSlider->status == false ? 'selected': '' }}>Deactivate
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="image_url">Change Image </label>
                                    <input type="file" name="image_url" id="image_url" class="form-control">
                                    <small class="form-text text-muted">Please maintain image size of 1920x800 px and upload image below 1 MB.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div>
                                <label>Existing Image </label>
                            </div>
                            <img src="{!! asset('storage/images/home-offer-sliders').'/'.$homeOfferSlider->image_url !!}" alt="Slider Title"
                                class="img img-responsive img-thumbnail" width="350px">
                        </div>
                    </div>
    
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