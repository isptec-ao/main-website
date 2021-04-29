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
                    @lang('translation.extension_services_short_duration_courses')
                </h1>
            </div>
        </div>
        </div>
    </div>
</div> 
</div>

<div class="container">
<div class="row">
    <form class="app-search d-none d-lg-block" method="GET" action="/ccd">
        <div class="position-relative ml-4">
            <input name="search" id="ccd-search" type="text" class="form-control" placeholder="">
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
                                <th scope="col">Name</th>
                                <th scope="col">Area</th>
                                <th scope="col">Lecturer</th>
                                <th scope="col">External</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $course)
                            <tr>
                                <td>
                                    <h5 class="font-size-14 mb-1"><a href="#" class="text-dark">{!! $course->name !!}</a></h5>
                                    <p class="text-muted mb-0"> {!! Str::limit($course->description, 20) !!}</p>
                                </td>
                                <td>{!! $course->department->name !!}</td>
                                <td>
                                    <div>
                                        <a href="#" class="badge badge-soft-primary font-size-11 m-1">{!! ($course->employee ? $course->employee->full_name : '') !!}</a>
                                    </div>
                                </td>
                                <td>
                                    {!! $course->external_employee !!}
                                </td>
                                <td>
                                    <ul class="list-inline font-size-20 contact-links mb-0">
                                        <li class="list-inline-item px-2">
                                            <a href="{!! route('ccd.show', [$course->slug . '?lang=' . (session()->get('locale') ?? 'pt') . '&id=' . $course->id]) !!}">
                                                <i class="bx bx-message-square-dots"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
                @if($posts->count() > 0)
                    {!! $posts->links() !!}
                @endif
            </div>
        </div>
    </div>
</div>
</div>
<hr class="my-4">

                        

@endsection

@section('script')
@endsection