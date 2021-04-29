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
                <h1 class="text-white text-xl-center text-uppercase">@lang('translation.file_repo')</h1>
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


</div>
<hr>

<div class="container">
<div class="row">
    <form class="app-search d-none d-lg-block" method="GET" action="/ficheiros">
        <div class="position-relative ml-4">
            <input name="search" id="alumni-search" type="text" class="form-control" placeholder="">
            <span class="bx bx-search-alt"></span>
        </div>
    </form>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                @if($posts->count() > 0)
                    <table class="table table-centered table-nowrap table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $file)
                            <tr>
                                <td>
                                    <h5 class="font-size-14 mb-1"><a href="#" class="text-dark">{!! $file->name !!}</a></h5>
                                </td>
                                <td>{!! $file->department->name !!}</td>
                                <td>
                                    <div>
                                        <a href="#" class="badge badge-soft-brand font-size-11 m-1">{!! $file->category->name !!}</a>
                                    </div>
                                </td>
                                <td>{!! $file->description !!}</td>
                                <td>
                                    <div>
                                        <a href="#" class="badge badge-soft-brand font-size-11 m-1">{!! $file->getFirstMedia('document') ? $file->getFirstMedia('document')->human_readable_size : '' !!}</a>
                                    </div>
                                </td>
                                <td>
                                    <ul class="list-inline font-size-20 contact-links mb-0">
                                        <li class="list-inline-item px-2">
                                            @if($file->getFirstMedia('document'))
                                            <a href="/ficheiros/downloadsingleattachment?model_id={!! $file->getFirstMedia('document')->id !!}" ><i class="bx bx-download"></i></a>
                                            @endif
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
                {!! $posts->links() !!}
            </div>
        </div>
    </div>
</div>
</div>


@endsection

@section('script')
@endsection