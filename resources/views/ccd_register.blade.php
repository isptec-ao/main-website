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
        <form class="m-2" method="POST" action="/ccd" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <input type="hidden" name="class_id" value="{!! $post->id !!}">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="full_name">@lang('translation.rec_form_full_name')</label>
                        <input name="full_name" type="text" class="form-control" id="full_name">
                    </div>
                </div>
                <div class="col-md-4">
                        <div class="form-group">
                            <label for="dob">@lang('translation.rec_form_dob')</label>
                            <input name="dob" type="date" value="{!! now()->format('Y-m-d') !!}" class="form-control" id="dob">
                        </div>
                </div>    
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description">@lang('translation.rec_form_other_info')</label>
                        <textarea wrap="soft" name="description" style="height: 74px" class="form-control" id="description"></textarea>
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

            <hr>

            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                    <label for="institution">@lang('translation.ccd_classes_registration_institution')</label>
                        <input name="institution" type="text" class="form-control" id="institution">
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

            <div>
                <button type="submit" class="btn btn-brand w-md btn-block btn-rounded">@lang('translation.rec_table_submit')</button>
            </div>
        </form>
        </div>
        <!-- end card -->

    </div>         
    
    <div class="col-xl-4">

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