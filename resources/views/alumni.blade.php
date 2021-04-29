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
                <h1 class="text-white text-xl-center">ALUMNI</h1>
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
    <form class="app-search d-none d-lg-block" method="GET" action="/alumni">
        <div class="position-relative ml-4">
            <input name="search" id="alumni-search" type="text" class="form-control" placeholder="">
            <span class="bx bx-search-alt"></span>
        </div>
    </form>
</div>
    @if($posts->count() > 0)
    @foreach($posts->chunk(4) as $students)
    <div class="row">

    @foreach($students as $student)
        <div class="col-xl-3 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="avatar-sm mx-auto mb-4">
                            <img src="{!! $student->getFirstMediaUrl('featured_image') !!}" class="avatar-title rounded-circle bg-soft-primary text-primary font-size-16" />
                        </div>
                        <h5 class="font-size-15"><a href="#" class="text-dark">{!! $student->student_full_name !!}</a></h5>
                        <p class="text-muted">{!! $student->course->name !!}</p>

                        <div>
                            <a href="#" class="badge badge-primary font-size-11 m-1">{!! $student->year !!}</a>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top">
                        <div class="contact-links d-flex font-size-20">
                            <div class="flex-fill">
                                <a href="{!! route('alumni.show', [$student->slug . '?lang=' . (session()->get('locale') ?? 'pt') . '&id=' . $student->id]) !!}" data-toggle="tooltip" data-placement="top" title="{!! $student->student_full_name !!}"><i class="bx bx-user-circle"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    @endforeach
    </div>
    @endforeach
    {!! $posts->links() !!}
    @endif

</div> <!-- container-fluid -->

</div>



@endsection

@section('script')
@endsection