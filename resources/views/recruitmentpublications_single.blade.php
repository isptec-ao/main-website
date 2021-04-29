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
                <h1 class="text-white text-xl-center">{!! $post->title !!}</h1>
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
    <div class="col-xl-8">
    <h4 class="card-title mb-4"></h4>
        <div class="card">
        <form class="m-2" method="POST" action="/recrutamento" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <input type="hidden" name="pub_id" value="{!! $post->id !!}">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="full_name">@lang('translation.rec_form_full_name')</label>
                        <input name="full_name" type="text" class="form-control" id="full_name">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>@lang('translation.rec_form_gender')</label>
                        <div>
                            <div class="custom-control custom-control-inline custom-radio mb-3">
                                <input value="M" type="radio" id="gender_m" name="gender" class="custom-control-input" checked>
                                <label class="custom-control-label" for="gender_m">M</label>
                            </div>
                            <div class="custom-control custom-control-inline custom-radio">
                                <input value="F" type="radio" id="gender_f" name="gender" class="custom-control-input">
                                <label class="custom-control-label" for="gender_f">F</label>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="other_info">@lang('translation.rec_form_other_info')</label>
                        <textarea wrap="soft" name="other_info" style="height: 74px" class="form-control" id="other_info"></textarea>
                    </div>
                </div>   
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="email">@lang('translation.rec_form_email')</label>
                        <input name="email" type="email" class="form-control" id="email">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="tel_no">@lang('translation.rec_form_tel_no')</label>
                        <input name="tel_no" type="text" class="form-control" id="tel_no">
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="id_no">@lang('translation.rec_form_id_no')</label>
                        <input name="id_no" type="text" class="form-control" id="id_no">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="dob">@lang('translation.rec_form_dob')</label>
                        <input name="dob" type="date" value="{!! now()->format('Y-m-d') !!}" class="form-control" id="dob">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="naturality">@lang('translation.rec_form_naturality')</label>
                        <input name="naturality" type="text" class="form-control" id="naturality">
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="suburb">@lang('translation.rec_form_suburb')</label>
                        <input name="suburb" type="text" class="form-control" id="suburb">
                    </div>
                </div>
            </div>

            <div class="row">
                
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="address">@lang('translation.rec_form_address')</label>
                        <input type="text" name="address" class="form-control" id="address">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <div class="form-group">
                            <label>@lang('translation.rec_form_marital_status')</label>
                            <div>
                                <div class="custom-control custom-control-inline custom-radio mb-3">
                                    <input value="S" type="radio" id="marital_status_m" name="marital_status" class="custom-control-input" checked>
                                    <label class="custom-control-label" for="marital_status_m">@lang('translation.rec_form_marital_status_single')</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <input value="M" type="radio" id="marital_status_f" name="marital_status" class="custom-control-input">
                                    <label class="custom-control-label" for="marital_status_f">@lang('translation.rec_form_marital_status_married')</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="country">@lang('translation.rec_form_country')</label>
                        <input type="text" name="country" class="form-control" id="country">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="postal_code">@lang('translation.rec_form_postal_code')</label>
                        <input type="text" name="postal_code" class="form-control" id="postal_code">
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="acad_id">@lang('translation.rec_form_academic_level')</label>
                        <select name="acad_id" id="acad_id" class="form-control">
                        <option>Choose...</option>
                            @foreach($academiccategories as $category)
                            <option value="{!! $category->id !!}">{!! $category->name !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="form-group">
                        <label for="documents">@lang('translation.rec_form_documents')</label>
                        <div class="custom-file mb-3">
                            <input name="documents[]" multiple type="file" class="custom-file-input" id="documents">
                            <label class="custom-file-label" for="documents"></label>
                        </div>
                    </div>
                </div>        
            </div>
            
            <hr>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="other_info">@lang('translation.rec_form_work_experience') </label>
                        <textarea wrap="soft" name="work_experience" style="height: 74px" class="form-control" id="work_experience"></textarea>
                    </div>
                </div>   
            </div>

            <div class="form-group">
            <p class="text-justified">
                @lang('translation.rec_form_terms_text') 
            </p>
                <div class="custom-control custom-switch">
                    <input type="checkbox" name="status" class="custom-control-input" id="status">
                    <label class="custom-control-label" for="status">@lang('translation.rec_form_accept_terms')</label>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-brand w-md btn-block btn-rounded">@lang('translation.rec_table_submit')</button>
            </div>
        </form>
        </div>
        <!-- end card -->

    </div>         
    
    <div class="col-xl-4">

        <div class="row">
            <div class="col-md-12">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">@lang('translation.rec_table_title')</p>
                                <h4 class="mb-0">{!! $post->title !!}</h4>
                            </div>

                            <div class="mini-stat-icon avatar-sm align-self-center rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="bx bxs-graduation font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">@lang('translation.rec_table_deadline')</p>
                                <h4 class="mb-0">{!! $post->end_date->format('d/m/Y') !!}</h4>
                            </div>

                            <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="bx bx-hourglass font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">@lang('translation.rec_table_requirements')</h4>
                <div id="revenue-chart" class="apex-charts">
                {!! $post->description !!} <hr>
                {!! $post->requirements !!}
                </div>
            </div>
        </div>

    </div>
</div>
<!-- end row -->
</div>
@endsection

@section('script')
<script src="{{ URL::asset('assets/libs/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>
@endsection