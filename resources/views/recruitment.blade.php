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
                    <h1 class="text-white text-xl-center">RECRUTAMENTO</h1>
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
<div class="row">
    <div class="col-8 text-center my-4">
        <h3> <b> RECRUTAMENTO </b> </h1>
           
    </div>

    <div class="row">
        <div class="col-3 fixed ">
            <nav id="navbarvertical" class="navbar navbar-light bg-transparent">
              

                    <ul class="nav nav-tabs flex-column">
<li class="nav-item">
   <a class="nav-link bg-brand my-2 text-dark" href="#1">  Dados do Candidato </a>
  </li>
  <li class="nav-item">
   <a class="nav-link bg-brand my-2 text-dark" href="#2"> Habilitações Literárias e/ou Profissionais </a>
  </li>
  <li class="nav-item">
    <a class="nav-link bg-brand my-2  text-dark" href="#3"> Experiência Laboral  </a>
  </li>
  <li class="nav-item">
     <a class="nav-link bg-brand my-2 Stext-dark" href="#4"> Experiência Docente no Ensino Superior </a>
  </li>
</ul>    
        </div>
    </nav>
        <div class="col-9">
            <div data-spy="scroll" data-target ="navbarvertical" data-offset="0">
                <h4 id="1"> <b> Dados Pessoais </b> </h4>
 
  <div class="form-group">
    <label for="inputAddress">Nome Completo</label>
    <input type="text" class="form-control"  >
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputPassword4">Data de nascimento</label>
      <input type="date" class="form-control" id="inputPassword4" >
    </div>
    <div class="form-group col-md-6">
      <label for="inputEmail4">Bilhete de identidade</label>
      <input type="text" class="form-control" id="inputEmail4" >
    </div>
</div>
  <div class="form-group">
    <label for="inputAddress2">Nacionalidade</label>
    <input type="text" class="form-control" id="inputAddress2" >
  </div>
   <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputPassword4">Telefone</label>
      <input type="text" class="form-control" id="inputPassword4" >
    </div>
    <div class="form-group col-md-6">
      <label for="inputEmail4">Email</label>
      <input type="email" class="form-control" id="inputEmail4" value="email@gmail.com" >
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">Residência</label>
      <input type="text" class="form-control" id="inputCity">
    </div>
    <div class="form-group col-md-2">
      <label for="inputState">Província</label>
      <select id="inputState" class="form-control">
        <option selected>Escolha...</option>
        <option>...</option>
      </select>
    </div>
   <div class="form-group col-md-2">
      <label for="inputState">Municípios</label>
      <select id="inputState" class="form-control">
        <option selected>Escolha...</option>
        <option>...</option>
      </select>
    </div>

</div>
  </div>



  <h4 id="2" class="my-4"> <b> Habilitações Literárias e/ou Profissionais </b> </h4>
 
    <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputState">Nível acadêmico</label>
      <select id="inputState" class="form-control">
        <option selected>Escolha...</option>
        <option>Licenciatura</option>
        <option>Mestrado</option>
        <option>Doutoramento</option>
      </select>
    </div>

    <div class="form-group col-md-4">
      <label for="inputState">Média Final</label>
     <input type="text" class="form-control" >
    </div>
   </div>


<h4 id="3" class="my-4"> <b> Experiência Laboral </b> </h4>


<div class="form-row">
    <div class="form-group col-md-5">
      <label for="inputPassword4">Entidade Empregadora</label>
      <input type="text" class="form-control" >
    </div>
    <div class="form-group col-md-3">
      <label for="inputEmail4">Tempo de serviço</label>
      <input type="text" class="form-control"s >
    </div>
    <div class="form-group col-md-3">
    <label class="form-label " for="customFile">Ficheiro</label>
<input type="file" class="form-control"  id="customFile">
    </div>
    <div class="form-group col-md-1" >
    <button type="submit" class="btn  btn-outline-secondary" >Mais</button>
    </div>
  </div>




<h4 id="4" class="my-4"> <b> Experiência Docente no Ensino Superior </b> </h4>


<div class="form-row">
    <div class="form-group col-md-3">
      <label for="inputPassword4">Instituição</label>
      <input type="text" class="form-control" >
    </div>
    <div class="form-group col-md-3">
      <label for="inputEmail4">Tempo de serviço</label>
      <input type="text" class="form-control"s >
    </div>
    <div class="form-group col-md-2">
      <label for="inputEmail4">Disciplina</label>
      <input type="text" class="form-control"s >
    </div>
    <div class="form-group col-md-3">
    <label class="form-label " for="customFile">Ficheiro</label>
<input type="file" class="form-control"  id="customFile">
    </div>
    <div class="form-group col-md-1" >
    <button type="button" class="btn btn-outline-secondary">Mais</button>
</div>
  </div>







  <div class="form-group my-5">
    <p class="text-justified">
        Declaro, para os devidos fins, que tenho conhecimento e aceito as normas relativas ao Processo de Recrutamento para contratação de Docentes do Instituto Superior Politécnico de Tecnologias e Ciências – ISPTEC, de acordo com os princípios regidos por esta instituição. Declaro, ainda, estar ciente que a contratação para exercer o magistério está relacionada a existência de vagas nas unidades curriculares dos cursos oferecidos pelo instituto. 
    </p>





    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
     <p> Declaro </p>
       </label>
    </div>
  
  <button type="submit" class="btn btn-success text-justified"  >Aceito</button>
</form>
 
            </div>
        
        </div>
    </div>

</div>


    


      
    

      <div class="album py-5 bg-white">
        <h1 class="jumbotron-heading text-center">VAGAS</h1>
        <div class="container">

          <div class="row">
            <div class="col-md-4">
              <div class="card mb-4 shadow">
            
                 <img src="assets/images/12.jpg">
             
                <div class="card-body">
                  <p class="card-text text-center"> <b>PROFESSORES</b> </p>
                 <p class="text-justified">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, </p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">

                      <button type="button" class="btn btn-sm btn-outline-warning " data-toggle="modal" data-target="#ex1">Mais</button>
                        
    
                    </div>
                  
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
              
                 <img src="assets/images/12.jpg">
             
                <div class="card-body">
                  <p class="card-text text-center"> <b> TECNICOS DE LABORATORIOS </b> </p>
                  <p class="text-justified">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, </p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">

                      <button type="button" class="btn btn-sm btn-outline-warning " data-toggle="modal" data-target="#ex2">Mais</button>
                      
                    </div>
                   
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
               
                 <img src="assets/images/12.jpg">
             
                <div class="card-body">
                  <p class="card-text text-center"> <b> TECNICOS DE REDES </b> </p>
                   <p class="text-justified">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, </p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">

                    <button type="button" class="btn btn-sm btn-outline-warning " data-toggle="modal" data-target="#ex3">Mais</button>
                      
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>




           




<!-- Modal -->
<div class="modal fade" id="ex1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">PROFESSORES</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ex2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">TECNICOS DE LABORATORIO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="ex3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">TECNICOS DE REDE</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div>



    <p>
        Declaro, para os devidos fins, que tenho conhecimento e aceito as normas relativas ao Processo de Recrutamento para contratação de Docentes do Instituto Superior Politécnico de Tecnologias e Ciências – ISPTEC, de acordo com os princípios regidos por esta instituição. Declaro, ainda, estar ciente que a contratação para exercer o magistério está relacionada a existência de vagas nas unidades curriculares dos cursos oferecidos pelo instituto. 
    </p>
</div>
</div>


@endsection

@section('script')
@endsection