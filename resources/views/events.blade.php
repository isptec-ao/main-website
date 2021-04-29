@extends('layouts.master-layouts')

@section('title') @lang('translation.Dashboard') @endsection

@section('content')

@if($latest_posts->count() > 0)
<div id="home-page-carousel" class="carousel slide" data-ride="carousel" data-interval="3000">
    <ol class="carousel-indicators">
        @foreach($latest_posts as $lpost)
        <li data-target="#carouselExampleIndicators" data-slide-to="{!! $loop->index !!}" class="{!! $loop->first ? 'active' : '' !!}"></li>
        @endforeach
      </ol>
    <div class="carousel-inner" role="listbox" style="height: 340px">
        @foreach($latest_posts as $content)
        <div class="carousel-item @if($loop->first)active @endif">
            <div class="d-block img-fluid" style="width:100%;height:340px;background:#563d7c">
            <!-- <img src="{!! $content->getFirstMediaUrl('featured_image') !!}" alt="" class="img-thumbnail"> -->
            </div>
                <div class="color-box bg-overlay py-4 rounded">
                    <div class="carousel-caption d-none d-md-block text-white-50 mt-2 " style="padding-bottom: 100px; min-width: 57px">
                    <img src="{!! $content->getFirstMediaUrl('featured_image') !!}" alt="" class="img-thumbnail" width="20%">
                        <h1 class="text-white">{!! $content->title !!}</h1>
                        <p>{!! $content->venue !!}</p>
                        <p><small class="text-muted"> <i class="far fa-calendar"></i> {!! $content->start_date->locale(session()->get('locale'))->diffForHumans() !!} | {!! $content->start_time !!}</small></p>
                        <a href="{!! route('events.show', [$content->slug . '?lang=' . (session()->get('locale') ?? 'pt') . '&id=' . $content->id]) !!}" class="btn btn-outline-brand btn-rounded">@lang('translation.news_read_more')</a>
                    </div>
                </div>
            </div>
            @endforeach
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
</div>
@endif


<div class="container justify-content-center mt-4"> 
    <h1><span style="color: black " class="ml-4"> @lang('translation.events')</span></h1> 

    
        {{-- Zona reservada para Barra de pesquisa  --}}
        
        <!-- <nav class="navbar justify-content-center d-flex">
        <nav class="navbar navbar-expand-lg  mt-1 mb-1 justify-content-center">
            <form class="d-flex ">
                <input class="form-control me-4" type="search" placeholder="Pesquisar" aria-label="Search">
                </form>
                
            <div class="container-fluid mt-2 justify-content-center ">
                <input type="date" class=" me-4 ">
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                </div>
            </div>

            </nav>
            
        </nav> -->
        <hr class="mb-1">
        </div>
        <div class="container">
        <div class="row">

                           
        @foreach($posts as $post)
                                                                
        <div class="col-md-4">
            <div class="card shadow-none">
            
                <div class="position-relative">
                    <img src="{!! $post->getFirstMediaUrl('featured_image') !!}" alt="" class="img-thumbnail" width="50%">
                    <br>
                    <br>
                    <h5><a href="{!! route('events.show', [$post->slug . '?lang=' . (session()->get('locale') ?? 'pt') . '&id=' . $post->id]) !!}" class="text-dark">{!! $post->title !!}</a></h5>

                </div>
                
                <div class="">
                    
                    <p>{!! $post->venue !!} | {!! $post->start_time !!}</p>

                    <div>
                        <a href="{!! route('events.show', [$post->slug . '?lang=' . (session()->get('locale') ?? 'pt') . '&id=' . $post->id]) !!}" class="text-primary btn btn-sm btn-primary btn-rounded text-light">
                        @lang('translation.news_read_more') <i class="mdi mdi-arrow-right"></i>
                            <i class="mdi mdi-calendar"></i> {!! $post->start_date->format('d/m/Y') !!}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @endforeach

    </div>
    <hr class="my-4">

    {!! $posts->links() !!}

    </div>
    </div>
</div>

@endsection

@section('script')
@endsection