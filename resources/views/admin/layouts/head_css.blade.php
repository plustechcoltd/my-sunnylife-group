<script>
    @if(isset($room))
    window.activeRoomId = @json($room->id);
    @endif
</script>
<!-- Global stylesheets -->
<link href="{{URL::asset('assets/admin/fonts/inter/inter.css')}}" rel="stylesheet" type="text/css">
<link href="{{URL::asset('assets/admin/icons/phosphor/styles.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{URL::asset('assets/admin/css/ltr/all.min.css')}}" id="stylesheet" rel="stylesheet" type="text/css">
<link href="{{URL::asset('assets/admin/css/bootstrap-tokenfield.min.css')}}" rel="stylesheet" type="text/css">
<!-- /global stylesheets -->
@yield('css')

<!-- Core JS files -->
<script src="{{URL::asset('assets/admin/demo/demo_configurator.js')}}"></script>
<script src="{{URL::asset('assets/admin/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
<script src="{{URL::asset('assets/admin/js/jquery/jquery.min.js')}}"></script>
<script src="{{URL::asset('assets/admin/js/vendor/notifications/noty.min.js')}}"></script>
<script src="{{URL::asset('assets/admin/js/vendor/notifications/sweet_alert.min.js')}}"></script>
<script src="{{URL::asset('assets/admin/js/vendor/forms/tags/bootstrap-tokenfield.js')}}"></script>
<script src="{{URL::asset('assets/admin/js/vendor/tables/datatables/datatables.min.js')}}"></script>
<script src="{{URL::asset('assets/admin/js/custom.js')}}"></script>
<!-- /core JS files -->
@yield('center-scripts')
<!-- Theme JS files -->
<script src="{{URL::asset('assets/admin/js/app.js')}}"></script>
<!-- /theme JS files -->

<!-- Custom Styles and Scripts -->
@vite(['resources/admin/css/app.css', 'resources/admin/js/index.js'])
@vite(['resources/components/chat/css/app.css'])
@yield('scripts')
