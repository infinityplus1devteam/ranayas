@extends('layouts.admin-master')
@section('title', 'Update Slider')
@section('content')

<section class="section">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-dark text-white-all">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-list"></i>Edit Slider</li>
            <li class="breadcrumb-item"><a href="{{ route('admin.sliders.all') }}"> All Sliders</a></li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header bg-dark text-white-all">
            <h4>Update Slider</h4>
        </div>
        <div class="card-body">
            <form method="post" class="needs-validation" enctype="multipart/form-data" id="formEditSlider">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" id="title" class="form-control"
                                        placeholder="Enter Title" value="{{ $slider->title }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subtitle">Sub Title</label>
                                    <input type="text" name="subtitle" id="subtitle" class="form-control"
                                        placeholder="Enter Sub Title" value="{{ $slider->subtitle }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="url">Url (Optional)</label>
                                    <input type="text" name="url" id="url" class="form-control" placeholder="Enter Url"
                                        value="{{ $slider->url }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="button_text">Button Text (Optional)</label>
                                    <input type="text" name="button_text" id="button_text" class="form-control" placeholder="e.g. Shop Now"
                                        value="{{ $slider->button_text }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="content_position">Content Position</label>
                                    <select name="content_position" id="content_position" class="form-control">
                                        <option value="center-left" {{ $slider->content_position == 'center-left' ? 'selected' : '' }}>Center Left (Default)</option>
                                        <option value="center" {{ $slider->content_position == 'center' ? 'selected' : '' }}>Center</option>
                                        <option value="center-right" {{ $slider->content_position == 'center-right' ? 'selected' : '' }}>Center Right</option>
                                        <option value="top-left" {{ $slider->content_position == 'top-left' ? 'selected' : '' }}>Top Left</option>
                                        <option value="top-center" {{ $slider->content_position == 'top-center' ? 'selected' : '' }}>Top Center</option>
                                        <option value="top-right" {{ $slider->content_position == 'top-right' ? 'selected' : '' }}>Top Right</option>
                                        <option value="bottom-left" {{ $slider->content_position == 'bottom-left' ? 'selected' : '' }}>Bottom Left</option>
                                        <option value="bottom-center" {{ $slider->content_position == 'bottom-center' ? 'selected' : '' }}>Bottom Center</option>
                                        <option value="bottom-right" {{ $slider->content_position == 'bottom-right' ? 'selected' : '' }}>Bottom Right</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="text_align">Text Alignment</label>
                                    <select name="text_align" id="text_align" class="form-control">
                                        <option value="left" {{ $slider->text_align == 'left' ? 'selected' : '' }}>Left</option>
                                        <option value="center" {{ $slider->text_align == 'center' ? 'selected' : '' }}>Center</option>
                                        <option value="right" {{ $slider->text_align == 'right' ? 'selected' : '' }}>Right</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sort_index">Sort Index <span class="text-danger">*</span></label>
                                    <input type="number" name="sort_index" class="form-control" id="sort_index"
                                        value="{{ $slider->sort_index }}" placeholder="Enter Sort Index" min="0"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="">--Select--</option>
                                        <option value="1" {{ $slider->status == true ? 'selected': '' }}>Activate
                                        </option>
                                        <option value="0" {{ $slider->status == false ? 'selected': '' }}>Deactivate
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image_url">Change Desktop Image</label>
                                    <input type="file" name="image_url" id="image_url" class="form-control">
                                    <small class="form-text text-muted">Please maintain image ratio of 16:9 and upload image below 2 MB.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile_image">Change Mobile Image</label>
                                    <input type="file" name="mobile_image" id="mobile_image" class="form-control">
                                    <small class="form-text text-muted">Please maintain image ratio of 2:3 and upload image below 2 MB.</small>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control"
                                        placeholder="Write Something here..."
                                        rows="4">{{ $slider->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-4">
                            <div>
                                <label class="font-weight-bold">Existing Desktop Image</label>
                            </div>
                            @if($slider->desktop_image_url)
                            <a href="{{ $slider->desktop_image_url }}" target="_blank">
                                <img src="{{ $slider->desktop_image_url }}" alt="Desktop Image"
                                    class="img img-responsive img-thumbnail" width="350px">
                            </a>
                            @else
                            <p class="text-muted">No Desktop Image</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <div>
                                <label class="font-weight-bold">Existing Mobile Image</label>
                            </div>
                            @if($slider->mobile_image)
                            <a href="{{ $slider->mobile_image_url }}" target="_blank">
                                <img src="{{ $slider->mobile_image_url }}" alt="Mobile Image"
                                    class="img img-responsive img-thumbnail" width="200px">
                            </a>
                            @else
                            <p class="text-muted"><small>No specific mobile image uploaded.<br>(Desktop image will be used as fallback)</small></p>
                            @endif
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

@section('extrajs')
<script>
    $("#formEditSlider").validate({
        rules: {

            status: {
                required: true
            },

        },

        messages: {
            status: {
                required: "Please Select Status"
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
