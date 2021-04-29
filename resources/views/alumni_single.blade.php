@extends('layouts.master-layouts')

@section('title') @lang('translation.Dashboard') @endsection

@section('content')

<div id="home-page-carousel" class="carousel slide" data-ride="carousel" data-interval="3000">
    <!-- <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      </ol> -->
    <div class="carousel-inner" role="listbox" style="height: 150px">
        <div class="carousel-item active">
            <div class="d-block img-fluid" style="width:100%;height:150px;background:#563d7c"></div>
            <div class="color-box bg-overlay py-4 rounded">
            <div class="carousel-caption d-none d-md-block text-white-50  mt-5 " style="">
                <h1 class="text-white text-xl-center">{!! $post->student_full_name !!}</h1>
                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <p><small class="text-muted"> <i class="far fa-calendar"></i> dd/mm/aaa</small></p>
                <a href="" class="btn btn-outline-brand btn-rounded">Ver mais</a> -->
            </div>
        </div>
        </div>
    </div>
    <!-- <a class="carousel-control-prev" href="#home-page-carousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#home-page-carousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a> -->
</div> 
</div>
<hr>

<div class="container">
<div class="row">
    <div class="col-xl-4">
        <div class="card overflow-hidden">
            <div class="bg-soft-brand">
                <div class="row">
                    <div class="col-12 align-self-end">
                        <img src="{!! $post->getFirstMediaUrl('featured_image') !!}" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-sm-4">
                        <!-- <div class="avatar-md profile-user-wid mb-4">
                            <img src="{!! $post->getFirstMediaUrl('featured_image') !!}" alt="" class="avatar-title img-thumbnail rounded-circle">
                        </div>
                        <h5 class="font-size-15 text-truncate">Cynthia Price</h5>
                        <p class="text-muted mb-0 text-truncate">UI/UX Designer</p> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end card -->

    </div>         
    
    <div class="col-xl-8">

        <div class="row">
            <div class="col-md-8">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">@lang('translation.alumni_course')</p>
                                <h4 class="mb-0">{!! $post->course->name !!}</h4>
                            </div>

                            <div class="mini-stat-icon avatar-sm align-self-center rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="bx bxs-graduation font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">@lang('translation.alumni_year')</p>
                                <h4 class="mb-0">{!! $post->year !!}</h4>
                            </div>

                            <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="bx bx-hourglass font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">@lang('translation.alumni_profile')</h4>
                <div id="revenue-chart" class="apex-charts">
                {!! $post->summary !!}
                </div>
            </div>
        </div>

    </div>
</div>
<!-- end row -->
</div>
@endsection

@section('script')
@endsection