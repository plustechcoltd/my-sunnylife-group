 <!-- Global stylesheets -->
 <link href="{{URL::asset('assets/demo/layout_2/fonts/inter/inter.css')}}" rel="stylesheet" type="text/css">
 <link href="{{URL::asset('assets/demo/layout_2/icons/phosphor/styles.min.css')}}" rel="stylesheet" type="text/css">
 <link href="{{URL::asset('assets/demo/layout_2/css/ltr/all.min.css')}}" id="stylesheet" rel="stylesheet" type="text/css">
 <!-- /global stylesheets -->
 @yield('css')

 <!-- Core JS files -->
 <script src="{{URL::asset('assets/demo/layout_2/demo/demo_configurator.js')}}"></script>
 <script src="{{URL::asset('assets/demo/layout_2/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
 <!-- /core JS files -->
@yield('center-scripts')
 <!-- Theme JS files -->
 <script src="{{URL::asset('assets/demo/layout_2/js/app.js')}}"></script>
 <!-- /theme JS files -->
@yield('scripts')