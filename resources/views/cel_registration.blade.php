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
                <h1 class="text-white text-xl-center">CEL - CADASTRAMENTO AO CLUBE</h1>
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

<div class="container">

   

    <div class="fullscreen d-flex"> 
  
      <div class="mt-4 form col-8">
        <h4 class="text-dark"> <b> DADOS PESSOAIS </b> </h4>
                  <div class="form-group">
              <label for="inputAddress">Nome Completo</label>
              <input type="text" class="form-control">
            </div>  

              <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputEmail4">Numero </label>
                <input type="text" class="form-control" id="inputEmail4" >
              </div>
              <div class="form-group col-md-6">
                <label for="inputPassword4">Data de nascimento</label>
                <input type="date" class="form-control" id="inputPassword4" >
              </div>
</div>
         <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputPassword4">Curso</label>
      <input type="text" class="form-control" id="inputPassword4" >
    </div>
    <div class="form-group col-md-6">
      <label for="inputEmail4">Ano</label>
      <input type="text" class="form-control" id="inputEmail4" >
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputPassword4">Turno</label>
      <input type="time" class="form-control" id="inputPassword4" >
    </div>
    <div class="form-group col-md-6">
      <label for="inputEmail4">Email </label>
      <input type="text" class="form-control" id="inputEmail4" >
    </div>
</div>

<div class="input-group">
  <div class="input-group-prepend">
    <span class="input-group-text" id="">Contactos</span>
  </div>
  <input type="text" class="form-control">
  <input type="text" class="form-control">
</div>


<div class="form-group my-3">
      <label for="inputEstado"> Tipo </label>
      <select id="inputEstado" class="form-control">
        <option selected>Escolher...</option>
        <option> Docente </option>
        <option> Estudantes </option>
        <option> Funcionario </option>
        <option> Estudante </option>
      </select>
    </div>

 <p style="text-align: justify; " class="my-3">
  <b>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
Donec vitae orci tortor. Sed sed maximus ligula, id dapibus metus. 
Aliquam volutpat nulla in imperdiet volutpat. 
Integer eu lacus nuncMaecenas tincidunt, tortor a placera
Proin malesuada sodales erat eget hendrerit. 
Etiam pellentesque tortor nec erat fermentum tempor. </b>
</p>

 <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
     <p> Declaro </p>
       </label>
    </div>


<button type="button" class="btn btn-outline-warning"> Cadastro </button>



  </div>
  
  
  <div class="reg col-5 my-5">
   


  <div class="list-group">
  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between ">
      <h5 class="mb-1">Preâmbulo</h5>
    </div>
   
  </a>
  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">I. Objectivos</h5>
    </div>
    
  </a>
  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">II. Funcionamento</h5>
     
    </div>
    
  </a>
</div>

<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">III. Atribuições da Coordenação do Clube de Inglês </h5>
     
    </div>
    
  </a>
  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start " >
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">IV. Adesão ao Clube de Inglês </h5>
     
    </div>
    
  </a>
  

         <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1"> V. Direitos e Deveres dos Membros  </h5>
     
    </div>
    
  </a>      

  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1" class="btn btn-primary"> VI. Actividades e sua divulgação  </h5>
     
    </div>
    
  </a>   

    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1"> VII. Atribuição de certificados e títulos </h5>
     
    </div>
    
  </a>   

  </a>   

    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1"> VIII. Sanções </h5>
     
    </div>
    
  </a>   
  </a>   

    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1"> IX. Disposições gerais </h5>
     
    </div>
    
  </a>   


  </div>
</div>

</div>



@endsection

@section('script')
@endsection