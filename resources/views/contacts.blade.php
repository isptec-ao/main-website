@extends('layouts.master-layouts')

@section('title') @lang('translation.Dashboard') @endsection

@section('content')

<div class="container">

<div class="row">
    <div class="col-lg-6"> <!-- FORMULÁRIO DE CONTACTO-->

        <div class="card-body">
                        <h3 class="card-title mb-4">@lang('translation.contact_form_label')</h3>
                        <hr>
                <form method="POST" action="{!! route('contacts.storecontactrequest') !!}" name="contact_form" id="contact_form">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="first_name">@lang('translation.contact_form_first_name')</label>
                            <input name="first_name" type="text" class="form-control" id="first_name">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="last_name">@lang('translation.contact_form_last_name')</label>
                            <input name="last_name" type="text" class="form-control" id="last_name">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="tel_no">@lang('translation.contact_form_tel_no')</label>
                            <input name="tel_no" type="text" class="form-control" id="tel_no">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">@lang('translation.contact_form_email')</label>
                            <input name="email" type="email" class="form-control" id="email">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="message">@lang('translation.contact_form_msg')</label>
                            <textarea name="message" id="message" class="form-control" rows="8"></textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-rounded waves-effect waves-light">@lang('translation.contact_form_submit_label')</button>

            </form>
    
        </div>

        <hr>

        <div class="card-body">
                        <h3 class="card-title mb-4">@lang('translation.service_form_label')</h3>
                        <hr>
                <form method="POST" action="/servico" name="service_form" id="service_form">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="name">@lang('translation.service_form_name')</label>
                            <input name="name" type="text" class="form-control" id="name">
                        </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="form-group">
                        <label for="category_id">@lang('translation.service_form_category')</label>
                        <select name="category_id" id="category_id" class="form-control">
                        <option>Choose...</option>
                            @foreach($services as $category)
                            <option value="{!! $category->id !!}">{!! $category->name !!}</option>
                            @endforeach
                        </select>
                    </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="contact">@lang('translation.service_form_contact')</label>
                            <input name="contact" type="text" class="form-control" id="contact">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">@lang('translation.service_form_email')</label>
                            <input name="email" type="email" class="form-control" id="email">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="description">@lang('translation.service_form_msg')</label>
                            <textarea name="description" id="description" class="form-control" rows="8"></textarea>
                        </div>
                    </div>
                </div>
                <button name="servicesubmit" type="submit" class="btn btn-primary btn-rounded waves-effect waves-light">@lang('translation.service_form_submit_label')</button>
            </form>
    
        </div>
    </div>


    <!-- ESTA É A DIVISÃO DA DIV DA NOTÍCIA E DA PARTILA E TAGS-->

    
    <div class="col-lg-6 "> <!-- MAPA-->
        
        <div class="card-body p-4">
            
                <h3 class="card-title mb-4">@lang('translation.contact_form_find_us')</h3>

                <iframe src="https://www.google.com/maps/d/embed?mid=15MTy38p4e5unlMrvXwsps9HAOeU&hl=pt-BR" 
                width="500" height="380"></iframe>
            
                <blockquote class="">
                
                        <p class="mb-2" style="text-align: justify;" > 

                            Av. Luanda Sul, Rua Lateral Via S10 Talatona - Angola<br> <br> 
                            </p>   
            </blockquote>
    
        </div>
    </div>
</div>

<hr>
@if($departments->count() > 0)
    @foreach($departments->chunk(4) as $contacts)
    <div class="row">

    @foreach($contacts as $contact)
        <div class="col-xl-3 col-sm-6">
            <div class="text-center">
                <div class="card-body">
                    
                    <h5 class="font-size-15"><a href="#" class="text-dark">{!! $contact->name !!}</a></h5>
                    <p class="text-muted">{!! $contact->email !!} <br>{!! $contact->tel_no !!}</p>
                
                </div>
            
            </div>
        </div>
    @endforeach
    </div>
    @endforeach
    @endif



</div> <!-- container-fluid -->

@endsection

@section('script')
@endsection