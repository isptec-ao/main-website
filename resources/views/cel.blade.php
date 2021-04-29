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
                <h1 class="text-white text-xl-center">CENTRO DE LÍNGUAS</h1>
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
    <div class="principal mt-2"> 
      <div class="texto">
        <h3><span style="color: rgb(255, 193, 23)" class="mb-5"> SERVIÇOS PRESTADOS PELO CEL</span></h3>
        <div class="list-group">
          <a href="#" class="list-group-item list-group-item-action" aria-current="true">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">Curso de Inglês Geral para Empresas</h5>
             
            </div>
            
          </a>
          <a href="#" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">Curso de Inglês para Fins Específicos para Empresas</h5>
              
            </div>
           
          </a>
          <a href="#" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">Curso de Inglês Geral para Particulares (Público Externo)</h5>
              
            </div>
           
          </a>
          <a href="#" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">Curso de Inglês Geral para Particulares (Estudantes do ISPTEC)</h5>
              
            </div>
           
          </a>
          <a href="#" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">Curso de Inglês Geral para Particulares (Funcionários do ISPTEC)</h5>
              
            </div>
            
          </a>
          <a href="#" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">Curso de Preparação para o Exame Internacional de TOEFL</h5>
              
            </div>
           
          </a>
          <a href="#" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">Curso de Preparação para o Exames Internacional de IELTS</h5>
              
            </div>
           
          </a>
          <a href="#" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">Curso de Inglês para Investigadores </h5>
              
            </div>
           
          </a>
          <a href="#" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">Curso de Inglês para a Comunidade Académica </h5>
              
            </div>
           
          </a>
        </div>
   
  </div>
  
  
  <div class="cartao">
    <p> <b>HORÁRIOS:</b><br> 
      Segunda-feira a sexta-feira: 8:00-10:00; 12:00-14:00; 16:00-18:00; 18:00-20:00 
    </p>
    angola
    <p><b>DOCUMENTOS NECESSÁRIOS:</b> <br>
      ❏ Ficha de inscrição (disponível no Dext/CEL) <br>
      ❏ Fotocópia do Bilhete de Identidade <br>
      ❏ Uma fotografia do tipo passe recente. <br>
      ❏ Akz 4.000,00 (taxa de teste) <br>
      </p>
      <p><b><h3>NÍVEIS</h3> </b> <br>
        1.  Beginner  <br> 
        2.  Elementary <br>
        3.  Pre-Intermediate <br> 
        4.  Intermediate <br>
        5.  Upper-Intermediate <br>
        6.  Advanced
        </p>
        <a href="/cel-registration" class="btn btn-brand btn-rounded btn-lg">
            <i class="bx bx-pencil"></i> Inscrição
        </a>
  </div>
</div>
</div> 
<hr>
</div>



@endsection

@section('script')
@endsection