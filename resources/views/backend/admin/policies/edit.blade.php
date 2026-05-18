@extends('layouts.admin-master')
@section('title', 'Edit ' . $policy->title)
@section('content')

<section class="section">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-dark text-white-all">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-file-alt"></i> Edit Policy</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header bg-dark text-white-all">
            <h4>Edit Policy: {{ $policy->title }}</h4>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('admin.policies.update', $policy->slug) }}" class="needs-validation" novalidate>
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="title">Policy Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $policy->title) }}" placeholder="Enter Policy Title" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="content">Policy Content <span class="text-danger">*</span></label>
                            <textarea name="content" id="content" class="form-control summernote" placeholder="Write Policy Content here..." required>{{ old('content', $policy->content) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12 text-center mt-3">
                        <button type="submit" class="btn btn-primary btnSubmit">
                            <i class="fas fa-pencil-alt"></i> Update Policy
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
