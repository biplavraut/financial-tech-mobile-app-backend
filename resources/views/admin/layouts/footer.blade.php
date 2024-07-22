<script src="{{ adminAssetsUrl('js/jquery-3.2.1.min.js') }}" type="text/javascript"></script>


{{-- Google Map --}}
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyByFMucI3xTPpuGscSQr1BcxK5KAhdiUnM"></script> 
{{-- change Api Key --}}



<script src="{{ myAsset('js/common.js') }}"></script>
<script src="{{ myAsset('js/asdh_admin.js') }}"></script>

{{-- Chart js --}}
<script src="{{ adminAssetsUrl('plugins/chartjs/chart.min.js') }}" type="text/javascript"></script>


<script src="{{ adminAssetsUrl('plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<!-- end base js -->

<!-- plugin js -->
@stack('plugin-scripts')
<!-- end plugin js -->

<!-- common js -->
<script src="{{ adminAssetsUrl('js/off-canvas.js') }}"></script>
<script src="{{ adminAssetsUrl('js/hoverable-collapse.js') }}"></script>
<script src="{{ adminAssetsUrl('js/misc.js') }}"></script>
<script src="{{ adminAssetsUrl('js/settings.js') }}"></script>
<script src="{{ adminAssetsUrl('js/todolist.js') }}"></script>
<!-- end common js -->

@stack('custom-scripts')
