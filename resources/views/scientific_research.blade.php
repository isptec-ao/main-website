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
                <h1 class="text-white text-xl-center">INVESTIGAÇÃO CIENTÍFICA</h1>
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

<div class="container">
  {{-- <div style="width:50%"> --}}
    

    {{-- <div class="sidnave">
    <a href="#about">About</a>
    <a href="#services">Services</a>
    <a href="#clients">Clients</a>
    </div> --}}
    <div class="principal"> 
      <div class="texto">
        <h3><span style="color: rgb(255, 193, 23)" class="ml-4 mb-5"> Investigação Científica</span></h3>
        <div class="list-group">
          <a href="#" class="list-group-item list-group-item-action" aria-current="true">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">Politica para a Investigação e Desenvolvimento (I&D)</h5>
             
            </div>
            
          </a>
          <a href="#" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">Centro de Investigação das Ciências Sociais Aplicadas ( CICSA)</h5>
              
            </div>
           
          </a>
          <a href="#" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">Guia para a Elaboração de Projectos de Investigação Científica</h5>
              
            </div>
           
          </a>
          <a href="#" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">JORNADAS CIENTÍFICAS E TECNOLÓGICAS</h5>
              
            </div>
           
          </a>
          <a href="#" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">Prémio Inovação do ISPTEC</h5>
              
            </div>
            
          </a>
          <a href="#" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">Ciclo de palestras</h5>
              
            </div>
           
          </a>
          <a href="#" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">Publicações em Revistas com Factor de Impacto</h5>
              
            </div>
           
          </a>
          <a href="#" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">Publicações em Revistas sem Factor de Impacto</h5>
              
            </div>
           
          </a>
        </div>
   
  </div>
  
  
  <div class="cartao">
    <img src={{asset('images/android-chrome-512x512.png') }} class="d-block w-100" alt="...">
    <img src={{asset('images/android-chrome-512x512.png') }} class="d-block w-100" alt="...">
    <img src={{asset('images/android-chrome-512x512.png') }} class="d-block w-100" alt="...">
    <img src={{asset('images/android-chrome-512x512.png') }} class="d-block w-100" alt="...">
  </div>
</div>
</div> 
</div>


</div>



@endsection

@section('script')
@endsection