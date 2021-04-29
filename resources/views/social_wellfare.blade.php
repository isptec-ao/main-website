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
        <div class="d-block img-fluid" style="width:100%;height:150px;background:#563d7c">
                @if($post->getFirstMediaUrl('featured_image'))
                <img class="d-block img-fluid" src="{!! $post->getFirstMediaUrl('featured_image') !!}" alt="">
                @endif
            </div>
            <div class="color-box bg-overlay py-4">
                <div class="carousel-caption d-none d-md-block text-white-50  mt-5 " style="">
                    <h1 class="text-white text-xl-center text-uppercase">@lang('translation.social_wellfare')</h1>
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
<hr>
<div class="container">
    {!! $post->description !!}

    <div class="row d-flex justify-content-center">
        <div class="col-xl-3 col-sm-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="avatar-sm mx-auto mb-4">
                        <i class="bx bx-hotel text-brand fa-4x"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top">
                    <div class="contact-links d-flex font-size-20">
                        <div class="flex-fill">
                            <a class="btn btn-block btn-rounded btn-brand" href="/apoio-social">
                            @lang('translation.social_support')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="avatar-sm mx-auto mb-4">
                        <i class="bx bx-football text-brand fa-4x"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top">
                    <div class="contact-links d-flex font-size-20">
                        <div class="flex-fill">
                            <a class="btn btn-block btn-rounded btn-brand" href="/actividade-extracurriculares">
                            @lang('translation.extracurricular_activities')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="avatar-sm mx-auto mb-4">
                        <i class="bx bx-clinic text-brand fa-4x"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top">
                    <div class="contact-links d-flex font-size-20">
                        <div class="flex-fill">
                            <a class="btn btn-block btn-rounded btn-brand" href="/saude">
                            @lang('translation.health')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('script')
@endsection