@extends('layouts.master-layouts')

@section('title') @lang('translation.Dashboard') @endsection

@section('content')

<div class="container">
<div class="row">

                            

<div class="col-xl-8"> <!--xl-8-->
    <br>
    <br>
    <br>
    <div>
        <div class="text-left">
            
            <h2 style="font-weight: bold;">{!! mb_strtoupper($post->title) !!}</h2>
                

            <p class="text-muted mb-4"><i class="mdi mdi-calendar mr-1"></i> {!! $post->published_at->format('d/m/Y') !!}</p>
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
                <p class="text-muted mb-1">@lang('translation.news_topics')</p>

                <ul class="list-inline widget-tag">
                @foreach($post->topic as $t)
                    <li class="list-inline-item"><a href="#" class="badge badge-light font-size-12 mt-2">{!! $t->name !!}</a></li>
                @endforeach
                </ul>
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
                    {!! $post->body !!}
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
                    <h5><a href="{!! route('news.show', [$related->slug . '?lang=' . (session()->get('locale') ?? 'pt') . '&id=' . $related->id]) !!}" class="text-dark">{!! $related->title !!}</a></h5>
                    
                </div>
                
                <div class="position-relative">
                    <img src="{!! $related->getFirstMediaUrl('featured_image') !!}" alt="" class="img-thumbnail">
                </div>

                <div class="p-3">
                    
                    <p>{!! $post->summary !!}</p>

                    <div>
                        <a href="{!! route('news.show', [$related->slug . '?lang=' . (session()->get('locale') ?? 'pt') . '&id=' . $related->id]) !!}" class="text-primary btn btn-sm btn-primary btn-rounded text-light">
                        @lang('translation.news_read_more') <i class="mdi mdi-arrow-right"></i>
                            <i class="mdi mdi-calendar"></i> {!! $related->published_at->format('d/m/Y') !!}
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