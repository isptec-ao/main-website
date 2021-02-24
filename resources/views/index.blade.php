@extends('layouts.master-layouts')

@section('title') @lang('translation.Dashboard') @endsection

@section('content')

<div id="home-page-carousel" class="carousel slide" data-ride="carousel" data-interval="3000">
    <div class="carousel-inner" role="listbox">
        <div class="carousel-item active">
            <img src="{{ URL::asset('/assets/images/large/1.jpg') }}" alt="..." class="d-block img-fluid">
            <div class="color-box bg-overlay py-4 rounded">
            <div class="carousel-caption d-none d-md-block text-white-50 mb-5 mt-0" style="padding-bottom: 280px;">
                <h1 class="text-white">First slide label</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <a href="" class="btn btn-outline-brand btn-rounded">Test</a>
            </div>
        </div>
        </div>
        <div class="carousel-item">
            <img src="{{ URL::asset('/assets/images/large/2.jpg') }}" alt="..." class="d-block img-fluid">
            <div class="color-box bg-overlay py-4 rounded">
            <div class="carousel-caption d-none d-md-block text-white-50 mb-5 mt-0" style="padding-bottom: 280px;">
                <h1 class="text-white">Second slide label</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <a href="" class="btn btn-outline-brand btn-rounded">Test</a>
            </div>
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{ URL::asset('/assets/images/large/4.jpg') }}" alt="..." class="d-block img-fluid">
            <div class="color-box bg-overlay py-4 rounded">
            <div class="carousel-caption text-white-50 mb-5 mt-0" style="padding-bottom: 280px;">
                <h1 class="text-white">Third slide label</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <a href="" class="btn btn-outline-brand btn-rounded">Test</a>
            </div>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#home-page-carousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#home-page-carousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

@endsection

@section('script')
@endsection
