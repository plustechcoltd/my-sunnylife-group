<script>
    @if(isset($room))
    window.activeRoomId = @json($room->id);
    @endif
</script>
<!-- Global stylesheets -->
<link href="{{URL::asset('assets/user/fonts/inter/inter.css')}}" rel="stylesheet" type="text/css">
<link href="{{URL::asset('assets/user/icons/phosphor/styles.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{URL::asset('assets/user/css/ltr/all.min.css')}}" id="stylesheet" rel="stylesheet" type="text/css">
<!-- /global stylesheets -->
@yield('css')

<!-- Core JS files -->
<script src="{{URL::asset('assets/user/demo/demo_configurator.js')}}"></script>
<script src="{{URL::asset('assets/user/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
<script src="{{URL::asset('assets/user/js/jquery/jquery.min.js')}}"></script>
<script src="{{URL::asset('assets/user/js/vendor/notifications/sweet_alert.min.js')}}"></script>
<script src="{{URL::asset('assets/user/js/vendor/notifications/noty.min.js')}}"></script>
<!-- /core JS files -->
@yield('center-scripts')
<!-- Theme JS files -->
<script src="{{URL::asset('assets/user/js/app.js')}}"></script>
<!-- /theme JS files -->

<!-- Custom Styles and Scripts -->
@vite(['resources/web/css/app.css', 'resources/web/js/index.js'])
@vite(['resources/components/chat/css/app.css'])
@yield('scripts')
