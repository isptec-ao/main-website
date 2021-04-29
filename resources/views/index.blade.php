@extends('layouts.master-layouts')

@section('title') @lang('translation.Dashboard') @endsection

@section('content')
@if($post->sliders->count() > 0)
<div id="home-page-carousel" class="carousel slide" data-ride="carousel" data-interval="3000">
    <ol class="carousel-indicators">
        @foreach($post->sliders->first()->images as $lpost)
        <li data-target="#carouselExampleIndicators" data-slide-to="{!! $loop->index !!}" class="{!! $loop->first ? 'active' : '' !!}"></li>
        @endforeach
    </ol>
    <div class="carousel-inner" role="listbox" style="height: {!! $post->sliders->first()->height !!}">
        @foreach($post->sliders->first()->images as $content)
        <div class="carousel-item @if($loop->first)active @endif">
            <img src="{!! $content->getFirstMediaUrl('image') !!}" alt="..." class="d-block img-fluid">
            <div class="color-box bg-overlay py-4">
                <div class="carousel-caption d-none d-md-block text-white-50 mb-5 mt-0" style="padding-bottom: 380px;">
                    <h1 class="text-white">{!! $content->title !!}</h1>
                    <p>{!! $content->description !!}</p>
                    <a href="{!! $content->link !!}" class="btn btn-outline-brand btn-rounded">{!! $content->title !!}</a>
                </div>
            </div>
        </div>
        @endforeach
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
<hr>
<div class="container justify-content-center mt-4">
<h1><span style="color: black " class="ml-4"> @lang('translation.news')</span></h1>
</div>
<div class="container">
@if($news->count() > 0)
    <div class="row">
        @foreach($news as $new)
                                                                
        <div class="col-md-4">
            <div class="card shadow-none">
            
                <div class="position-relative">
                    <img src="{!! $new->getFirstMediaUrl('featured_image') !!}" alt="" class="img-thumbnail" width="50%">
                    <br>
                    <br>
                    <h5><a href="{!! route('news.show', [$new->slug . '?lang=' . (session()->get('locale') ?? 'pt') . '&id=' . $new->id]) !!}" class="text-dark">{!! $new->title !!}</a></h5>

                </div>
                
                <div class="">
                    
                    <p>{!! $new->summary !!}</p>

                    <div>
                        <a href="{!! route('news.show', [$new->slug . '?lang=' . (session()->get('locale') ?? 'pt') . '&id=' . $new->id]) !!}" class="text-primary btn btn-sm btn-primary btn-rounded text-light">
                        @lang('translation.news_read_more') <i class="mdi mdi-arrow-right"></i>
                            <i class="mdi mdi-calendar"></i> {!! $new->published_at->format('d/m/Y') !!}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @endforeach
    </div>        
@endif

@if($events->count() > 0)
<hr>
<div class="container justify-content-center mt-4">
<h1><span style="color: black " class="ml-4"> @lang('translation.events')</span></h1>
</div>
<div class="row">
@foreach($events as $event)
                                                                
        <div class="col-md-4">
            <div class="card shadow-none">
            
                <div class="position-relative">
                    <img src="{!! $event->getFirstMediaUrl('featured_image') !!}" alt="" class="img-thumbnail" width="50%">
                    <br>
                    <br>
                    <h5><a href="{!! route('events.show', [$event->slug . '?lang=' . (session()->get('locale') ?? 'pt') . '&id=' . $event->id]) !!}" class="text-dark">{!! $event->title !!}</a></h5>

                </div>
                
                <div class="">
                    
                    <p>{!! $event->venue !!} | {!! $event->start_time !!}</p>

                    <div>
                        <a href="{!! route('events.show', [$event->slug . '?lang=' . (session()->get('locale') ?? 'pt') . '&id=' . $event->id]) !!}" class="text-primary btn btn-sm btn-primary btn-rounded text-light">
                        @lang('translation.news_read_more') <i class="mdi mdi-arrow-right"></i>
                            <i class="mdi mdi-calendar"></i> {!! $event->start_date->format('d/m/Y') !!}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @endforeach
</div>
@endif
</div>


@endsection

@section('script')
@endsection
