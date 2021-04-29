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
                    {!! $post->name !!}
                </h1>
            </div>
        </div>
        </div>
    </div>
</div> 
</div>
<hr>
<div class="container">
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="media">

                    <div class="media-body overflow-hidden">
                        <h5 class="text-truncate font-size-15">{!! $post->name !!}</h5>
                    </div>
                </div>

                <h5 class="font-size-15 mt-4">@lang('translation.ccd_description')</h5>

                <p class="text-muted">
                    {!! $post->description !!}
                </p>
            </div>
        </div>
    </div>
    <!-- end col -->

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">@lang('translation.ccd_lecturers')</h4>

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap">
                        <tbody>
                            @if($post->employee)
                            <tr>
                                <td style="width: 50px;"><img src="{!! $post->employee->getFirstMediaUrl('avatar') !!}" class="rounded-circle avatar-xs" alt=""></td>
                                <td><h5 class="font-size-14 m-0"><a href="" class="text-dark">{!! $post->employee->full_name !!}</a></h5></td>
                            </tr>
                            @endif

                            @if($post->external_employee)
                            <tr>
                                <td style="width: 50px;"><img src="#" class="rounded-circle avatar-xs" alt=""></td>
                                <td><h5 class="font-size-14 m-0"><a href="" class="text-dark">{!! $post->external_employee !!}</a></h5></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- end col -->
</div>
<!-- end row -->
@if($post->classes->count() > 0)
    <h4>
        <span class="badge badge-pill badge-brand">
        @lang('translation.ccd_classes_label')
        </span>
    </h4>
    @foreach($post->classes as $class)
    <div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="media">

                    <div class="media-body overflow-hidden">
                        <h5 class="text-truncate font-size-15">
                        {!! $class->name !!}
                        </h5>
                    </div>
                </div>

                <h5 class="font-size-15 mt-4">@lang('translation.ccd_description')</h5>

                <p class="text-muted">
                    {!! $class->description !!}
                </p>
                <dl class="row mb-0">
                    <dt class="col-sm-4">@lang('translation.ccd_classes_total_hours')</dt>
                            <dd class="col-sm-8">
                                <i class= "bx bx-time-five mr-1"></i> {!! $class->start_time !!}
                            </dd>
                    <dt class="col-sm-4">@lang('translation.ccd_classes_start_date')</dt>
                            <dd class="col-sm-8">
                                <i class= "bx bx-calendar mr-1"></i> {!! $class->start_date !!}
                            </dd>
                    <dt class="col-sm-4">@lang('translation.ccd_classes_end_date')</dt>
                            <dd class="col-sm-8">
                                <i class= "bx bx-calendar mr-1"></i> {!! $class->end_date !!}
                            </dd>
                    <dt class="col-sm-4">@lang('translation.ccd_classes_start_time')</dt>
                            <dd class="col-sm-8">
                                <i class= "bx bx-time-five mr-1"></i> {!! $class->start_time !!}
                            </dd>
                    <dt class="col-sm-4">@lang('translation.ccd_classes_end_time')</dt>
                            <dd class="col-sm-8">
                                <i class= "bx bx-time-five mr-1"></i> {!! $class->end_time !!}
                            </dd>
                    <dt class="col-sm-4">@lang('translation.ccd_classes_price')</dt>
                        <dd class="col-sm-8">
                            <i class= "bx bx-money mr-1"></i> {!! $class->price !!}
                        </dd>

                    <dt class="col-sm-4">@lang('translation.ccd_classes_registration_fee')</dt>
                        <dd class="col-sm-8">
                            <i class= "bx bx-money mr-1"></i> {!! $class->registration_fee !!}
                        </dd>
                </dl> 
                <a href="{!! route('ccd.registration', ['lang=' . (session()->get('locale') ?? 'pt') . '&class_id=' . $class->id]) !!}" class="btn btn-sm btn-block btn-primary btn-rounded text-light">
                <i class="bx bx-pencil"></i> @lang('translation.ccd_register')
            </a>   
            </div>
        </div>
    </div>
    <!-- end col -->

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">@lang('translation.ccd_documents')</h4>

                @if($class->getMedia('documents')->count() > 0)

                <ol>
                @foreach($class->getMedia('documents') as $document)
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
    </div>
    <!-- end col -->
</div>
    @endforeach
@endif
</div>
<hr class="my-4">

                        

@endsection

@section('script')
@endsection