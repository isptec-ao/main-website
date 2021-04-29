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
                    <h1 class="text-white text-xl-center text-uppercase">@lang('translation.aggr_protocols')</h1>
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
    <div class="row">
    @foreach($partnerships as $key => $partnership)
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">{!! $key !!}</h4>

                    <div id="carouselExampleCaption-{!! $loop->index !!}" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner" role="listbox" style="height: 140px">
                        @foreach($partnership->chunk(4) as $partner)
                            <div class="carousel-item @if($loop->first)active @endif">
                                <div class="row">
                                    @foreach($partner as $p)
                                    <div class="col" style="width:100%;height:140px;">
                                        <img src="{!! $p['img'] !!}" alt="{!! $p['name'] !!}" class="d-block img-fluid">
                                        <div class="color-box bg-overlay d-md-block">
                                            <div class="carousel-caption d-none d-md-block" style="padding-bottom: 0px;">
                                                <p class="text-white"><small>{!! $p['name'] !!}</small></p>
                                                <a target="_blank" href="{!! $p['link'] !!}" class="btn btn-sm btn-rounded btn-brand btn-block">
                                                    <i class="bx bx-world"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleCaption-{!! $loop->index !!}" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleCaption-{!! $loop->index !!}" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
<hr>
    <!-- @foreach($partnerships as $key => $partnership)
    <div class="row">
        <h3>{!! $key !!}</h3>
        <div id="home-page-carousel-{{ $loop->index }}" class="carousel slide" data-ride="carousel" data-interval="3000">
            <div class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($partnership->chunk(4) as $partner)
                    <div class="carousel-item active">
                    
                        <div class="row">
                        @foreach($partner as $p)
                            <div class="col"><img src="{!! $p['img'] !!}" alt="1 slide" class="img-thumbnail" width="20%"></div>
                        @endforeach
                        </div>
                    
                    </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#home-page-carousel-{{ $loop->index }}" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#home-page-carousel-{{ $loop->index }}" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
    <hr>
    @endforeach -->
</div>



@endsection

@section('script')
@endsection