<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="/" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/logo.svg" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-dark.png" alt="" height="36">
                    </span>
                </a>

                <a href="/" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="assets/images/logo-light.svg" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-light.png" alt="" height="19">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-toggle="collapse" data-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- App Search-->
            <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="@lang('translation.search')">
                    <span class="bx bx-search-alt"></span>
                </div>
            </form>

            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item waves-effect"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @lang('translation.apps') 
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="#" class="dropdown-item notify-item">@lang('translation.online_portal')</a></a>
                    <a href="#" class="dropdown-item notify-item">@lang('translation.webmail')</a>
                    <a href="/ficheiros" class="dropdown-item notify-item">@lang('translation.file_repo')</a>
                    <a href="/canvas/dashboard" class="dropdown-item notify-item">Canvas</a>
                </div>
            </div>
            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item waves-effect"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @lang('translation.careers') 
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="/recrutamento?cat=1" class="dropdown-item notify-item">@lang('translation.careers_lecturers')</a></a>
                    <a href="/recrutamento?cat=2" class="dropdown-item notify-item">@lang('translation.careers_non_lecturers')</a>
                </div>
            </div>
            <div class="dropdown d-none d-sm-inline-block logo">
                <a href="#" class="btn notify-item">
                    @lang('translation.school_brochure') 
                </a>
            </div>
            <div class="dropdown d-none d-sm-inline-block logo">
                <a href="/contacto" class="btn notify-item">
                    @lang('translation.contacts') 
                </a>
            </div>

            <!-- <div class="dropdown dropdown-mega d-none d-lg-block ml-2">
                <button type="button" class="btn header-item waves-effect" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                    @lang('translation.Mega_Menu')
                    <i class="mdi mdi-chevron-down"></i> 
                </button>
                <div class="dropdown-menu dropdown-megamenu">
                    <div class="row">
                        <div class="col-sm-8">
                
                            <div class="row">
                                <div class="col-md-4">
                                    <h5 class="font-size-14 mt-0">@lang('translation.UI_Components')</h5>
                                    <ul class="list-unstyled megamenu-list">
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Lightbox')</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Range_Slider')</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Sweet_Alert')</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Rating')</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Forms')</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Tables')</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Charts')</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <h5 class="font-size-14 mt-0">@lang('translation.Applications')</h5>
                                    <ul class="list-unstyled megamenu-list">
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Ecommerce')</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Calendar')</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Email')</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Projects')</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Tasks')</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Contacts')</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <h5 class="font-size-14 mt-0">@lang('translation.Extra_Pages')</h5>
                                    <ul class="list-unstyled megamenu-list">
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Light_Sidebar')</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Compact_Sidebar')</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Horizontal_layout')</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Maintenance')</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Coming_Soon')</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Timeline')</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.FAQs')</a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5 class="font-size-14 mt-0">@lang('translation.UI_Components')</h5>
                                    <ul class="list-unstyled megamenu-list">
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Lightbox')</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Range_Slider')</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Sweet_Alert')</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Rating')</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Forms')</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Tables')</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">@lang('translation.Charts')</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-sm-5">
                                    <div>
                                        <img src="assets/images/megamenu-img.png" alt="" class="img-fluid mx-auto d-block">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div> -->
        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ml-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-magnify"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                    aria-labelledby="page-header-search-dropdown">
                    
                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="@lang('translation.search')" aria-label="Recipient's username">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item waves-effect"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @switch(Session::get('locale'))
                        @case('ru')
                        <img src="{{ URL::asset('/assets/images/flags/russia.jpg')}}" alt="Header Language" height="16"> <span class="align-middle">Russian</span>
                        @break
                        @case('it')
                        <img src="{{ URL::asset('/assets/images/flags/italy.jpg')}}" alt="Header Language" height="16"> <span class="align-middle">Italian</span>
                        @break
                        @case('de')
                        <img src="{{ URL::asset('/assets/images/flags/germany.jpg')}}" alt="Header Language" height="16"> <span class="align-middle">German</span>
                        @break
                        @case('pt')
                        <!-- item-->
                        <a href="{{ url('lang/pt') }}" class="dropdown-item notify-item">
                            <img src="{{ URL::asset('/assets/images/flags/pt.png')}}" alt="user-image" class="mr-1" height="20"> <span class="align-middle">Português</span>
                        </a>
                        @break
                        @case('es')
                        <img src="{{ URL::asset('/assets/images/flags/spain.jpg')}}" alt="Header Language" height="16"> <span class="align-middle">Spanish</span>
                        @break
                        @case('en')
                        <img src="{{ URL::asset('/assets/images/flags/us.jpg')}}" alt="Header Language" height="16"> <span class="align-middle">English</span>
                        @break
                        @default
                        <img src="{{ URL::asset('/assets/images/flags/pt.png')}}" alt="Header Language" height="32"> <span class="align-middle">Português</span>
                    @endswitch
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    <a href="{{ url('lang/pt') }}" class="dropdown-item notify-item">
                        <img src="{{ URL::asset('/assets/images/flags/pt.png')}}" alt="user-image" class="mr-1" height="20"> <span class="align-middle">Português</span>
                    </a>
                    <!-- item-->
                    <a href="{{ url('lang/en') }}" class="dropdown-item notify-item">
                        <img src="{{ URL::asset('/assets/images/flags/us.jpg')}}" alt="user-image" class="mr-1" height="12"> <span class="align-middle">English</span>
                    </a>
                </div>
            </div>

            <!-- <div class="dropdown d-none d-lg-inline-block ml-1">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-customize"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <div class="px-lg-2">
                        <div class="row no-gutters">
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/github.png" alt="Github">
                                    <span>GitHub</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/bitbucket.png" alt="bitbucket">
                                    <span>Bitbucket</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/dribbble.png" alt="dribbble">
                                    <span>Dribbble</span>
                                </a>
                            </div>
                        </div>

                        <div class="row no-gutters">
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/dropbox.png" alt="dropbox">
                                    <span>Dropbox</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/mail_chimp.png" alt="mail_chimp">
                                    <span>Mail Chimp</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/slack.png" alt="slack">
                                    <span>Slack</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="dropdown d-none d-lg-inline-block ml-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="bx bx-fullscreen"></i>
                </button>
            </div>

            <!-- <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-bell bx-tada"></i>
                    <span class="badge badge-danger badge-pill">3</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> @lang('translation.Notifications') </h6>
                            </div>
                            <div class="col-auto">
                                <a href="#!" class="small"> @lang('translation.View_All')</a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        <a href="" class="text-reset notification-item">
                            <div class="media">
                                <div class="avatar-xs mr-3">
                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                        <i class="bx bx-cart"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">@lang('translation.Your_order_is_placed')</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">@lang('translation.If_several_languages_coalesce_the_grammar')</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> @lang('translation.min_ago')</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="text-reset notification-item">
                            <div class="media">
                                <img src="assets/images/users/avatar-3.jpg"
                                    class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">James Lemire</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">@lang('translation.It_will_seem_like_simplified_English')</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> @lang('translation.hours_ago')</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="text-reset notification-item">
                            <div class="media">
                                <div class="avatar-xs mr-3">
                                    <span class="avatar-title bg-success rounded-circle font-size-16">
                                        <i class="bx bx-badge-check"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">@lang('translation.Your_item_is_shipped')</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">@lang("translation.If_several_languages_coalesce_the_grammar")</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> @lang('translation.min_ago')</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="" class="text-reset notification-item">
                            <div class="media">
                                <img src="assets/images/users/avatar-4.jpg"
                                    class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">Salena Layfield</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">@lang('translation.As_a_skeptical_Cambridge_friend_of_mine_occidental')</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> @lang('translation.hours_ago')</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 border-top">
                        <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="javascript:void(0)">
                            <i class="mdi mdi-arrow-right-circle mr-1"></i> @lang('translation.View_More')..
                        </a>
                    </div>
                </div>
            </div> -->

            <!-- <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="bx bx-cog bx-spin"></i>
                </button>
            </div> -->
            
        </div>
    </div>
</header>