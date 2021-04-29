@extends('layouts.master-layouts')

@section('title') @lang('translation.Dashboard') @endsection

@section('content')
<div id="home-page-carousel" class="carousel slide" data-ride="carousel" data-interval="3000">
    
    <div class="carousel-inner" role="listbox" style="height: 150px">
        <div class="carousel-item active">
            <div class="d-block img-fluid" style="width:100%;height:150px;background:#563d7c"></div>
            <div class="color-box bg-overlay py-4 rounded">
            <div class="carousel-caption d-none d-md-block text-white-50  mt-5 " style="">
                <h1 class="text-white text-xl-center text-uppercase">
                    @if(request()->cat == 1)
                        @lang('translation.careers_non_lecturers')
                        @else
                        @lang('translation.scientific_research_pub_journals')
                    @endif
                </h1>
            </div>
        </div>
        </div>
    </div>
</div> 
</div>

<div class="row">
    @if($posts->count() > 0)
    @foreach($posts as $post)
    <div class="col-xl-4 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="avatar-md mr-4">
                        <span class="avatar-title rounded-circle bg-light text-danger font-size-16">
                            <img src="{!! $post->getFirstMediaUrl('featured_image') !!}" alt="" height="30">
                        </span>
                    </div>

                    <div class="media-body overflow-hidden">
                        <h5 class="text-truncate font-size-15"><a href="{!! $post->external_url !!}" class="text-dark">{!! $post->title !!}</a></h5>
                        <p class="text-muted mb-4">{!! $post->summary !!}</p>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 border-top">
                <dl class="row mb-0">
                    <dt class="col-sm-4">@lang('translation.journalpublications_journal')</dt>
                            <dd class="col-sm-8">
                                <i class= "bx bx-news mr-1"></i> {!! $post->journal_name !!}
                            </dd>
                    <dt class="col-sm-4">@lang('translation.journalpublications_pub')</dt>
                            <dd class="col-sm-8">
                                <i class= "bx bx-calendar mr-1"></i> {!! $post->published_at->format('d/m/Y') !!}
                            </dd>
                    <dt class="col-sm-4">@lang('translation.journalpublications_ref')</dt>
                            <dd class="col-sm-8">
                                <i class= "bx bx-space-bar mr-1"></i> {!! $post->reference !!}
                            </dd>
                    <dt class="col-sm-4">@lang('translation.journalpublications_authors')</dt>
                        <dd class="col-sm-8">
                            <i class= "bx bx-edit-alt mr-1"></i> {!! $post->authors !!}
                        </dd>

                    <dt class="col-sm-4">@lang('translation.journalpublications_lecturers')</dt>
                        <dd class="col-sm-8">
                            <i class= "bx bxs-graduation mr-1"></i> {!! $post->lecturers !!}
                        </dd>
                </dl> 
                <a href="{!! $post->external_url !!}" class="btn btn-sm btn-block btn-primary btn-rounded text-light">
                <i class="bx bx-news"></i> @lang('translation.journalpublications_consult')
            </a>   
            </div>
        </div>
    </div>
    @endforeach
    @endif

</div>
<hr class="my-4">

@if($posts->count() > 0)
    {!! $posts->links() !!}
@endif

                        

@endsection

@section('script')
@endsection