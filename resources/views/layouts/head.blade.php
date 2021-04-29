
        @yield('css')
        <base href="/">
        
          <!-- Bootstrap Css -->
        <!-- <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" /> -->
        <!-- Icons Css -->
        <!-- <link href="{{ URL::asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" /> -->
        <!-- App Css-->
        <link href="{{ URL::asset('css/app.css')}}" id="app-style" rel="stylesheet" type="text/css" />
        <link href="assets/libs/magnific-popup/magnific-popup.min.css" rel="stylesheet" type="text/css" />
       
        <style>
            body[data-layout="horizontal"][data-topbar="light"] .topnav {
                background-color: #fdc500;
                color: #000000;
            }
            body[data-layout="horizontal"][data-topbar="light"] .topnav .navbar-nav .nav-link {
                color: #393838;
            }
            body {
                background-color: #ffffff;
            }
            .new_footer_top {
  
  padding: 50px 0px 25px;
  position: relative;
  overflow-x: hidden;
  background-color: #1d1d1d;
  /*background-image: url("../images/small/isptec-10.JPG");*/
  /*opacity: 0.6;*/
}
      /* Novo Footer */

  .new_footer_area {
    background-color: #0f0fb1;
    
}

.new_footer_top {
  
    padding: 50px 0px 25px;
    position: relative;
    overflow-x: hidden;
    background-color: #1d1d1d;
    /*background-image: url("../images/small/isptec-10.JPG");*/
    /*opacity: 0.6;*/
}
.new_footer_area .footer_bottom {
    padding-top: 5px;
    padding-bottom: 50px;
}
.footer_bottom {
    font-size: 14px;
    font-weight: 300;
    line-height: 20px;
    color: #7f88a6;
    padding: 27px 0px;
}
.new_footer_top .company_widget p {
    font-size: 16px;
    font-weight: 300;
    line-height: 28px;
    color: #6a7695;
    margin-bottom: 20px;
}
.new_footer_top .company_widget .f_subscribe_two .btn_get {
    border-width: 1px;
    margin-top: 20px;
}
.btn_get_two:hover {
    background: transparent;
    color: #5e2ced;
}
.btn_get:hover {
    color: #fff;
    background: #6754e2;
    border-color: #6754e2;
    -webkit-box-shadow: none;
    box-shadow: none;
}
a:hover, a:focus, .btn:hover, .btn:focus, button:hover, button:focus {
    text-decoration: none;
    outline: none;
}



.new_footer_top .f_widget.about-widget .f_list li a:hover {
    color: #fabb32;
}
.new_footer_top .f_widget.about-widget .f_list li {
    margin-bottom: 11px;
}
.f_widget.about-widget .f_list li:last-child {
    margin-bottom: 0px;
}
.f_widget.about-widget .f_list li {
    margin-bottom: 15px;
}
.f_widget.about-widget .f_list {
    margin-bottom: 0px;
}
.new_footer_top .f_social_icon a {
    width: 44px;
    height: 44px;
    line-height: 43px;
    background: transparent;
    border: 1px solid #e2e2eb;
    font-size: 24px;
}
.f_social_icon a {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    font-size: 14px;
    line-height: 45px;
    color: #ffffff;
    display: inline-block;
    background: #ebeef5;
    text-align: center;
    -webkit-transition: all 0.2s linear;
    -o-transition: all 0.2s linear;
    transition: all 0.2s linear;
}
.ti-facebook:before {
    content: "\e741";
}
.ti-twitter-alt:before {
    content: "\e74b";
}
.ti-vimeo-alt:before {
    content: "\e74a";
}
.ti-pinterest:before {
    content: "\e731";
}

.btn_get_two {
    -webkit-box-shadow: none;
    box-shadow: none;
    background: #5e2ced;
    border-color: #5e2ced;
    color: #fff;
}

.btn_get_two:hover {
    background: transparent;
    color: #fabb32;
}

.new_footer_top .f_social_icon a:hover {
    background: #fabb32;
  color:white;
}
.new_footer_top .f_social_icon a + a {
    margin-left: 4px;
}
.new_footer_top .f-title {
    margin-bottom: 30px;
    color: #ffffff;
}
.f_600 {
    font-weight: 400;
}
.f_size_18 {
    font-size: 15px;
}
h1, h2, h3, h4, h5, h6 {
    color: #4b505e;
}
.new_footer_top .f_widget.about-widget .f_list li a {
    color: #424242;
}

.destaque{
  box-shadow: 0 0 5px rgba(0,0,0,0.4);
  width: 2400px;
  max-height: 450px ;
  transition: 0.5s;

}
.destaque:hover{
  -webkit-box-shadow: -7px 11px 5px -8px rgba(0,0,0,0.75);
  -moz-box-shadow: -7px 11px 5px -8px rgba(0,0,0,0.75);
  box-shadow: -7px 11px 5px -8px rgba(0,0,0,0.75);
  transform: scale(1.05, 1.1);
  z-index: 3;
  transition: 0.5s;

}

.principal{
  display: table;
}
.texto{
  display: table-cell;
  float:left;
  width:35%;
  /*   */
  
}

.cartao{
  display:table-cell;
  float:left;
  width:45%;
  margin-top:70px;
  max-height:100%;
  margin-left:70px;
}
.posicao h1{
  position: absolute;
  background-color: rgba(0, 0, 0, 0);
  color:rgb(255, 255, 255);
  text-align:center;
  top: 200px;
  font-size: 3.5em;
    font-weight: 900;
    color: #FFF;
    line-height: 1.166em;
    text-transform: uppercase;
    text-align: center;
  
  
 
} 

.posicao img {
  position: relative;
  width: 100%; 
  display: block;
  max-height: 300px; 
  filter:blur(2.0px);
}

        </style>
        <script async charset="utf-8" src="//cdn.embedly.com/widgets/platform.js"></script>