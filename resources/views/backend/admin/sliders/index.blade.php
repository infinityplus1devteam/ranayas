@extends('layouts.admin-master')
@section('title', 'All Slider')
@section('content')

    {{-- Model --}}

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white-all">
                    <h5 class="modal-title" id="formModal">Add Slider</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" role="form" class="needs-validation" enctype="multipart/form-data"
                        id="formAddSlider">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">Title (Optional)</label>
                                        <input type="text" name="title" id="title" class="form-control"
                                            placeholder="Enter Title" value="{{ old('title') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="subtitle">Sub Title (Optional)</label>
                                        <input type="text" name="subtitle" id="subtitle" class="form-control"
                                            placeholder="Enter Sub Title" value="{{ old('subtitle') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="url">Url (Optional)</label>
                                        <input type="text" name="url" id="url" class="form-control"
                                            placeholder="Enter Url (e.g. https://...)" value="{{ old('url') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="button_text">Button Text (Optional)</label>
                                        <input type="text" name="button_text" id="button_text" class="form-control"
                                            placeholder="e.g. Shop Now" value="{{ old('button_text') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="content_position">Content Position</label>
                                        <select name="content_position" id="content_position" class="form-control">
                                            <option value="center-left" {{ old('content_position') == 'center-left' ? 'selected' : '' }}>Center Left (Default)</option>
                                            <option value="center" {{ old('content_position') == 'center' ? 'selected' : '' }}>Center</option>
                                            <option value="center-right" {{ old('content_position') == 'center-right' ? 'selected' : '' }}>Center Right</option>
                                            <option value="top-left" {{ old('content_position') == 'top-left' ? 'selected' : '' }}>Top Left</option>
                                            <option value="top-center" {{ old('content_position') == 'top-center' ? 'selected' : '' }}>Top Center</option>
                                            <option value="top-right" {{ old('content_position') == 'top-right' ? 'selected' : '' }}>Top Right</option>
                                            <option value="bottom-left" {{ old('content_position') == 'bottom-left' ? 'selected' : '' }}>Bottom Left</option>
                                            <option value="bottom-center" {{ old('content_position') == 'bottom-center' ? 'selected' : '' }}>Bottom Center</option>
                                            <option value="bottom-right" {{ old('content_position') == 'bottom-right' ? 'selected' : '' }}>Bottom Right</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="text_align">Text Alignment</label>
                                        <select name="text_align" id="text_align" class="form-control">
                                            <option value="left" {{ old('text_align') == 'left' ? 'selected' : '' }}>Left
                                            </option>
                                            <option value="center" {{ old('text_align') == 'center' ? 'selected' : '' }}>
                                                Center</option>
                                            <option value="right" {{ old('text_align') == 'right' ? 'selected' : '' }}>Right
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="sort_index">Sort Index <span class="text-danger">*</span></label>
                                        <input type="number" name="sort_index" class="form-control" id="sort_index"
                                            value="{{ old('sort_index', 1) }}" placeholder="Enter Sort Index" min="0"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image_url">Desktop Image <span class="text-danger">*</span></label>
                                        <input type="file" name="image_url" id="image_url" class="form-control" required>
                                        <small class="form-text text-muted">Please maintain image ratio of 2:1 and upload
                                            image below 500 KB.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile_image">Mobile Image (Optional)</label>
                                        <input type="file" name="mobile_image" id="mobile_image" class="form-control">
                                        <small class="form-text text-muted">Please maintain image ratio of 2:3 and upload
                                            image below 500 KB.</small>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description (Optional)</label>
                                        <textarea name="description" id="description" class="form-control"
                                            placeholder="Write description here..."
                                            rows="3">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h6 class="text-warning"> <i class="fa fa-info-circle"></i> Note * mark is compulsory
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btnSubmit"> <i class="fa fa-plus"></i>
                                Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Model End --}}
    <section class="section">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-dark text-white-all">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i>
                        Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-list"></i> Slider</li>
                <li class="breadcrumb-item"><a href="#addModal" data-toggle="modal" data-target="#addModal"><i
                            class="fas fa-plus"></i> Add Slider</a></li>
            </ol>
        </nav>
        <div class="card">
            <div class="card-header bg-dark text-white-all">
                <h4>Manage Slider</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover datatable" style="width:100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Sorting</th>
                                <th>Status</th>
                                <th>Added On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sliders as $slider)
                                <tr>
                                    <td>{{ $slider->id }}</td>
                                    <td>
                                        @if($slider->desktop_image_url)
                                            <a href="{{ $slider->desktop_image_url }}" target="_blank" title="Slider Image">
                                                <img src="{{ $slider->desktop_image_url }}" alt="Slider Image" width="60px"
                                                    class="rounded border">
                                            </a>
                                        @else
                                            <span class="badge badge-secondary">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $slider->title ? Str::limit($slider->title, 20) : 'N/A' }}</strong>
                                        @if($slider->subtitle)
                                            <br><small class="text-muted">{{ Str::limit($slider->subtitle, 25) }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $slider->sort_index }}</td>
                                    <td>
                                        {{ $slider->status == true ? 'Activated' : 'Deactivated' }}
                                    </td>
                                    <td>{{ date('d-M-Y h:i A', strtotime($slider->created_at)) }}</td>
                                    <td>

                                        <div class="dropdown d-inline">
                                            <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                                id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="{{ route('admin.sliders.edit', $slider->id) }}"
                                                    class="dropdown-item has-icon" title="Edit Detail">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <a href="javascript:void(0)" data-role="delete-obj"
                                                    data-obj-id="{{ $slider->id }}" class="dropdown-item has-icon delete-object"
                                                    title="Delete Slider">
                                                    <i class="fa fa-trash text-danger"></i> Delete
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td class="text-danger" colspan="7">
                                        <h4>No Record Found..</h4>
                                    </td>
                                </tr>
                            @endforelse
                            @if($sliders->total() > 50)
                                <tr class="text-center">
                                    <td colspan="7">
                                        {{ $sliders->links() }}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Sorting</th>
                                <th>Status</th>
                                <th>Added On</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <form id="formDelete" method="POST" action="{{ route('admin.sliders.delete') }}">
        @csrf
        <input type="hidden" name="slider_id" id="txtSliderID">
    </form>

@endsection

@section('extrajs')
    <script>
        $(document).ready(function () {
            $(".delete-object").click(function () {
                if (window.confirm("Are you sure, You want to Delete ? ")) {
                    $("#txtSliderID").val($(this).attr("data-obj-id"));
                    $(this).attr('disabled', 'disabled');
                    $(this).html('<span class="fa fa-spinner fa-spin"></span> Loading...');
                    $("#formDelete").submit();
                }
            });

            $("#formAddSlider").validate({
                rules: {

                    sort_index: {
                        required: true
                    },

                    image_url: {
                        required: true
                    },

                },

                messages: {
                    sort_index: {
                        required: "Please Enter Sort Index"
                    },
                    image_url: {
                        required: "Please Choose Desktop Image"
                    },

                },
                submitHandler: function (form) {
                    $('.btnSubmit').attr('disabled', 'disabled');
                    $(".btnSubmit").html('<span class="fa fa-spinner fa-spin"></span> Loading...');
                    form.submit();
                }
            });
        });

    </script>
@endsection