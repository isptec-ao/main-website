@extends('layouts.master-layouts')

@section('title') @lang('translation.Dashboard') @endsection

@section('content')
<div id="home-page-carousel" class="carousel slide" data-ride="carousel" data-interval="3000">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2" class="active"></li>
      </ol>
    <div class="carousel-inner" role="listbox" style="height: 140px">
        <div class="carousel-item active">
            <div class="d-block img-fluid" style="width:100%;height:140px;background:#563d7c">
            </div>
                <div class="color-box bg-overlay py-4 rounded">
                    <div class="carousel-caption d-none d-md-block text-white-50 mt-2 " style="min-width: 57px">
                        <h1 class="text-white">
                        <i class="far fa-calendar"></i> {!! $post->start_date->format('d/m/Y') !!}
                        </h1>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
            <div class="d-block img-fluid" style="width:100%;height:140px;background:#563d7c">
            </div>
                <div class="color-box bg-overlay py-4 rounded">
                    <div class="carousel-caption d-none d-md-block text-white-50 mt-2 " style="min-width: 57px">
                        <h1 class="text-white">
                        <i class="bx bx-map"></i> {!! $post->venue !!}
                        </h1>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
            <div class="d-block img-fluid" style="width:100%;height:140px;background:#563d7c">
            </div>
                <div class="color-box bg-overlay py-4 rounded">
                    <div class="carousel-caption d-none d-md-block text-white-50 mt-2 " style="min-width: 57px">
                        <h1 class="text-white">
                        <i class="far fa-clock"></i> {!! $post->start_time . ' - ' . $post->end_time !!}
                        </h1>
                    </div>
                </div>
            </div>


        </div>
        
        <a class="carousel-control-prev" href="#home-page-carousel" role="button" data-slide="prev">
            <span class="mdi mdi-chevron-left fa-3x" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#home-page-carousel" role="button" data-slide="next">
            <span class="mdi mdi-chevron-right fa-3x" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div> 
</div>

<div class="container">
<div class="row">

                            

<div class="col-xl-8"> <!--xl-8-->
    <br>
    <br>
    <br>
    <div>
        <div class="text-left">
            
            <h2 style="font-weight: bold;">{!! mb_strtoupper($post->title) !!}</h2>
                

            <p class="text-muted mb-4"><i class="mdi mdi-calendar mr-1"></i> {!! $post->start_date->format('d/m/Y') . ' | ' . $post->start_date->locale(session()->get('locale'))->diffForHumans() !!}</p>
        </div>
        
        

        <div class="my-5">


            

            <img src="{!! $post->getFirstMediaUrl('featured_image') !!}" alt="" class="img-thumbnail mx-auto d-block" width="">
        </div>

        <hr>

       
        
    </div>
</div>


<!-- ESTA É A DIVISÃO DA DIV DA NOTÍCIA E DA PARTILA E TAGS-->


<div class="col-lg-4 ">
    <br>
           <br>  
    <div class="">
        <div class="card-body p-4">

            <div>
                <p class="text-muted mb-1">
                    <i class="bx bx-info-circle fa-2x"></i>
                </p>
                <p>{!! $post->start_date->format('d/m/Y') . ' - ' . $post->end_date->format('d/m/Y') !!}</p>
                <p>{!! $post->start_time . ' - ' . $post->end_time !!}</p>
                
            </div>

           <!-- <hr class="my-4"> -->
        
           <br>
           <br>
            <div>
                <h4 class="text-muted">@lang('translation.share_post')</h4>
                <br> 

                
                    <div>
                                <span>

                                    <a href="https://">
                                    <i class="fab fa-facebook fa-2x" aria-hidden="true" ></i>
                                    </a>
                                </span>
                                <span style="">
                                    @lang('translation.share_fb')
                                </span>
                        </div>
                        <br>
                        <div>
                                <span>

                                <a href="https://">
                                    <i class="fab fa-twitter fa-2x" aria-hidden="true"></i>
                                  </a>
                                </span>
                                <span style="text-justify: auto;">
                                    @lang('translation.share_tw')
                                </span>
                        </div>
                        <br>
                        <div>
                            <span>

                            <a href="https://">
                                <i class="fab fa-instagram fa-2x" aria-hidden="true"></i>
                              </a>
                            </span>
                            <span style="text-justify: auto;">
                                @lang('translation.share_ig')
                            </span>
                        </div>


            </div>


            <hr class="my-4">

            @if($post->getMedia('documents')->count() > 0)
                <h6>@lang('translation.featured_documents')</h6>

                <ol>
                @foreach($post->getMedia('documents') as $document)
                    <li>
                        <a href="{!! $document->getUrl() !!}">
                            {!! $document->name !!} | {!! $document->human_readable_size !!}
                        </a>
                    </li>
                @endforeach
                </ol>
            @endif

    </div>

    
    </div>
    
    <!-- end card -->
</div>


<!-- Divisão dos Tópicos e a Notícia-->

<div class="col-xl-8">

    <div class="card">
        <div class="mt-4">
            <div class="text-muted font-size-14 m-2">
                <!-- <p style="text-align: justify;"> -->
                    {!! $post->description !!}
                <!-- </p> -->
            </div>

           <br>
           <br>
           <br>

            
        </div>



    </div>
</div>


<!-- <div> -->

@if($post->getMedia('featured_images')->count() > 0)
<div class="col-xl-8">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">@lang('translation.featured_images')</h4>

            <div class="popup-gallery">
            @foreach($post->getMedia('featured_images') as $image)
                <a class="float-left" href="{!! $image->getUrl() !!}" title="{!! $image->name !!}">
                    <div class="img-fluid">
                        <img src="{!! $image->getUrl() !!}" alt="" width="120">
                    </div>
                </a>
            @endforeach

            </div>

        </div>
    </div>
</div>
@endif

<div class="col-12">
<h3>@lang('translation.news_related')</h3>
<hr>
</div>
    @if($related_posts->count() > 0)
        @foreach($related_posts as $related)
        <article class="col-sm-4 ">
            <div class="card p-1  shadow-none">
                <div class="p-3">
                    <h5><a href="{!! route('events.show', [$related->slug . '?lang=' . (session()->get('locale') ?? 'pt') . '&id=' . $related->id]) !!}" class="text-dark">{!! $related->title !!}</a></h5>
                    
                </div>
                
                <div class="position-relative">
                    <img src="{!! $related->getFirstMediaUrl('featured_image') !!}" alt="" class="img-thumbnail">
                </div>

                <div class="p-3">
                    
                    <p>{!! $post->venue !!} | {!! $post->start_time !!}</p>

                    <div>
                        <a href="{!! route('events.show', [$related->slug . '?lang=' . (session()->get('locale') ?? 'pt') . '&id=' . $related->id]) !!}" class="text-primary btn btn-sm btn-primary btn-rounded text-light">
                        @lang('translation.news_read_more') <i class="mdi mdi-arrow-right"></i>
                            <i class="mdi mdi-calendar"></i> {!! $related->start_date->locale(session()->get('locale'))->diffForHumans() !!}
                        </a>
                    </div>
                </div>
            </div>
        </article>
        @endforeach
    @endif
</div>
<!-- end row -->
</div>

@endsection

@section('script')
@endsection