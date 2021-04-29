<!-- <div class="topnav"> -->
<!-- container-fluid -->
    <!-- <div class="container-fluid"> -->
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu" style="padding-top: 80px; background-color: #fdc500; color: #000000">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav mx-auto">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @lang('translation.about_isptec') <div
                                class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-dashboard">

                        <a href="/mensagem-direcao" class="dropdown-item">@lang('translation.msg_from_dg')</a>
                        <a href="/apresentacao-institucional" class="dropdown-item">@lang('translation.institutional_presentation')</a>
                        <a href="/organigrama" class="dropdown-item">@lang('translation.org_chart')</a>
                        <a href="/missao" class="dropdown-item">@lang('translation.mission_vision_values')</a>
                        <a href="/historico" class="dropdown-item">@lang('translation.history')</a>
                        <a href="/infraestruturas" class="dropdown-item">@lang('translation.infrastructure')</a>
                        <a href="/legislacao" class="dropdown-item">@lang('translation.legislation')</a>
                        <a href="/convenios" class="dropdown-item">@lang('translation.aggr_protocols')</a>
                        <a href="/accao-social" class="dropdown-item">@lang('translation.social_wellfare')</a>
                        </div>
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @lang('translation.acad_services') <div class="arrow-down">
                            </div>
                        </a>

                        <div class="dropdown-menu"
                            aria-labelledby="topnav-uielement">
                            <a href="/calendario-academico" class="dropdown-item">@lang('translation.acad_calendar')</a>
                            <a href="/regulamentos" class="dropdown-item">@lang('translation.regulations')</a>
                            <a href="/editais" class="dropdown-item">@lang('translation.edicts')</a>
                            <!-- <a href="#" class="dropdown-item">@lang('translation.online_portal')</a> -->
                            <a href="/mobilidadeestudantil" class="dropdown-item">@lang('translation.student_mobility')</a>
                            

                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @lang('translation.education') <div class="arrow-down">
                            </div>
                        </a>

                        <div class="dropdown-menu"
                            aria-labelledby="topnav-uielement">
                            <a href="/departamento-de-engenharias-e-tecnologias" class="dropdown-item">@lang('translation.education_det')</a>
                            <a href="/departamento-de-geociencias" class="dropdown-item">@lang('translation.education_dgc')</a>
                            <a href="/departamento-de-ciencias-sociais-aplicadas" class="dropdown-item">@lang('translation.education_dcsa')</a>        
                            <a href="/docentes" class="dropdown-item">@lang('translation.education_teachers')</a>
                            <a href="/biblioteca" class="dropdown-item">@lang('translation.education_library_presentation')</a>
                            <a href="/regulamentoestudantil" class="dropdown-item">@lang('translation.education_library_rules')</a>

                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @lang('translation.scientific_research') <div class="arrow-down">
                            </div>
                        </a>

                        <div class="dropdown-menu"
                            aria-labelledby="topnav-uielement">
                            <a href="/politicai" class="dropdown-item">@lang('translation.scientific_research_policy')</a>
                            <a href="/guiaelaboracao" class="dropdown-item">@lang('translation.scientific_research_project_guide')</a>
                            <a href="/jornadas" class="dropdown-item">@lang('translation.scientific_research_events')</a>        
                            <a href="/premio-inovacao" class="dropdown-item">@lang('translation.scientific_research_innovation_award')</a>        
                            <a href="/ciclo-de-palestras" class="dropdown-item">@lang('translation.scientific_research_lec_cycles')</a>        
                            <a href="/publicacao-com-impacto?cat=1" class="dropdown-item">@lang('translation.scientific_research_pub_impact_journals')</a>        
                            <a href="/publicacao-sem-impacto?cat=2" class="dropdown-item">@lang('translation.scientific_research_pub_journals')</a>   
                            <a href="/centro-investigacoes-dsa" class="dropdown-item">@lang('translation.scientific_research_aasr_center')</a>

                        </div>
                    </li>



                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @lang('translation.communication') <div class="arrow-down">
                            </div>
                        </a>

                        <div class="dropdown-menu"
                            aria-labelledby="topnav-uielement">
                            <a href="/submeter-conteudo" class="dropdown-item">@lang('translation.communication_submit_content')</a>
                            <a href="/isptec-na-midia" class="dropdown-item">@lang('translation.communication_press')</a>
                            <a href="#" class="dropdown-item">@lang('translation.communication_branding')</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @lang('translation.extension_services') <div class="arrow-down">
                            </div>
                        </a>

                        <div class="dropdown-menu"
                            aria-labelledby="topnav-uielement">
                            <a href="/politica-de-extensao" class="dropdown-item">@lang('translation.extension_services_policy')</a>
                            <a href="/projecto-transferencia-de-conhecimento" class="dropdown-item">@lang('translation.extension_services_trans_knowledge')</a>
                            <a href="/estagio-nao-supervisionado" class="dropdown-item">@lang('translation.extension_services_non_curricular_internships')</a>        
                            <a href="/promocao-ao-empreendedorismo" class="dropdown-item">@lang('translation.extension_services_entrepreneurship_program')</a>        
                            <a href="/olimpiadas-cientificas" class="dropdown-item">@lang('translation.extension_services_olympiads')</a>   
                            <a href="/servico-carreira-empregabilidade" class="dropdown-item">@lang('translation.extension_services_employment_careers')</a>
                            <a href="/ccd" class="dropdown-item">@lang('translation.extension_services_short_duration_courses')</a>
                            <a href="/cel" class="dropdown-item">@lang('translation.extension_services_ltc')</a>
                            <a href="/program-empresa" class="dropdown-item">@lang('translation.extension_services_cu_program')</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @lang('translation.blog') <div class="arrow-down">
                            </div>
                        </a>

                        <div class="dropdown-menu"
                            aria-labelledby="topnav-uielement">
                            <a href="/noticias" class="dropdown-item">@lang('translation.news')</a>
                            <a href="/eventos" class="dropdown-item">@lang('translation.events')</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">@lang('translation.labpro')</a>
                    </li>

                    <li class="nav-item">
                        <a href="/alumni" class="nav-link">@lang('translation.alumni')</a>
                    </li>

                    <!-- <li class="nav-item">
                        <a href="#" class="nav-link">@lang('translation.news')</a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">@lang('translation.events')</a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">@lang('translation.online_registrations')</a>
                    </li> -->

                </ul>
            </div>
        </nav>
    <!-- </div> -->
<!-- </div> -->
