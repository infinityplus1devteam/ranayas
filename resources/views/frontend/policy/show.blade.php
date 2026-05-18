@extends('layouts.master')
@section('title', $policy->title)
@section('content')

    <!-- breadcrumb start -->
    <section class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-start">
                        <ul class="breadcrumb-url">
                            <li class="breadcrumb-url-li">
                                <a href="{{ route('index') }}">Home</a>
                            </li>
                            <li class="breadcrumb-url-li">
                                <span>{{ $policy->title }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb end -->

    <!-- Main Content Wrapper Start -->
    <div id="content" class="main-content-wrapper py-5 bg-light">
        <div class="page-content-inner">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="about-text px-4 px-md-5 py-5 shadow-sm bg-white rounded border">
                            <h2 class="heading-secondary mb-5 pb-3 border-bottom text-primary"><strong>{{ $policy->title }}</strong></h2>
                            <div class="policy-body-content text-secondary lh-lg">
                                {!! $policy->content !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
