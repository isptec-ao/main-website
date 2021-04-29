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
                <h1 class="text-white text-xl-center text-uppercase">@lang('translation.communication_submit_content')</h1>
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
        <form class="m-2" method="POST" action="/submeter-conteudo" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">@lang('translation.aci_submit_content_name')</label>
                        <input name="name" type="text" class="form-control" id="name">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('translation.aci_submit_content_category')</label>
                        <div>
                            <div class="custom-control custom-control-inline custom-radio mb-3">
                                <input value="N" type="radio" id="category_n" name="category" class="custom-control-input" checked>
                                <label class="custom-control-label" for="category_n">@lang('translation.aci_submit_content_category_n')</label>
                            </div>
                            <div class="custom-control custom-control-inline custom-radio">
                                <input value="E" type="radio" id="category_e" name="category" class="custom-control-input">
                                <label class="custom-control-label" for="category_e">@lang('translation.aci_submit_content_category_e')</label>
                            </div>
                            <div class="custom-control custom-control-inline custom-radio">
                                <input value="O" type="radio" id="category_o" name="category" class="custom-control-input">
                                <label class="custom-control-label" for="category_o">@lang('translation.aci_submit_content_category_o')</label>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">@lang('translation.aci_submit_content_email')</label>
                        <input name="email" type="email" class="form-control" id="email">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="contact">@lang('translation.aci_submit_content_contact')</label>
                        <input name="contact" type="text" class="form-control" id="contact">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="title">@lang('translation.aci_submit_content_title')</label>
                        <input name="title" type="text" class="form-control" id="title">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description_pt">@lang('translation.aci_submit_content_description_pt')</label>
                        <textarea wrap="soft" name="description_pt" style="height: 74px" class="form-control" id="description_pt"></textarea>
                    </div>
                </div>   
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description_en">@lang('translation.aci_submit_content_description_en')</label>
                        <textarea wrap="soft" name="description_en" style="height: 74px" class="form-control" id="description_en"></textarea>
                    </div>
                </div>   
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="obs">@lang('translation.aci_submit_content_obs')</label>
                        <textarea wrap="soft" name="obs" style="height: 74px" class="form-control" id="obs"></textarea>
                    </div>
                </div>   
            </div>
            <div>
                <button type="submit" class="btn btn-brand w-md btn-block btn-rounded">@lang('translation.aci_submit_content_submit_label')</button>
            </div>
        <!-- </form> -->
        </div>
        <!-- end card -->

    </div>         
    
    <div class="col-xl-4">

        <!-- <div class="row">
            <div class="col-md-12">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">@lang('translation.rec_table_title')</p>
                                <h4 class="mb-0">BLEH!</h4>
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
                                <h4 class="mb-0">BLEH2!</h4>
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
        </div> -->
        <div class="card">
            <div class="card-body">
                <div id="revenue-chart" class="apex-charts">
                    <div class="form-group">
                        <label for="documents">@lang('translation.aci_submit_content_featured_image')</label>
                        <div class="custom-file mb-3">
                            <input name="featured_image" type="file" class="custom-file-input" id="featured_image">
                            <label class="custom-file-label" for="featured_image"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="documents">@lang('translation.aci_submit_content_documents')</label>
                        <div class="custom-file mb-3">
                            <input name="documents[]" multiple type="file" class="custom-file-input" id="documents">
                            <label class="custom-file-label" for="documents"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>


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