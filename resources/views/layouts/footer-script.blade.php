        <!-- JAVASCRIPT -->
        <script src="{{ URL::asset('assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/bootstrap/bootstrap.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/metismenu/metismenu.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/node-waves/node-waves.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/lightbox/lightbox.init.js')}}"></script>

        @yield('script')

        <!-- App js -->
        <script src="{{ URL::asset('assets/js/front-end/app.min.js')}}"></script>
        
        @yield('script-bottom')