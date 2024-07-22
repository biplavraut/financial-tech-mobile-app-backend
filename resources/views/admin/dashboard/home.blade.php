@extends('admin.layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="container-scroller" id="app">
    <app-container p-auth-user="{{ json_encode($authUser) }}" p-settings="{{ json_encode($company) }}"
        p-counts="{{ json_encode($counts) }}"></app-container>
    {{-- <example /> --}}
</div>

@endsection

@push('plugin-styles')


<link href="{{ adminAssetsUrl('plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
<link href="{{ adminAssetsUrl('plugins/jquery-bar-rating/dist/themes/fontawesome-stars.css') }}" rel="stylesheet">
<link href="{{ adminAssetsUrl('plugins/jquery-bar-rating/dist/themes/bars-1to10.css') }}" rel="stylesheet">
<link href="{{ adminAssetsUrl('plugins/jquery-bar-rating/dist/themes/bars-horizontal.css') }}" rel="stylesheet">
<link href="{{ adminAssetsUrl('plugins/jquery-bar-rating/dist/themes/bars-movie.css') }}" rel="stylesheet">
<link href="{{ adminAssetsUrl('plugins/jquery-bar-rating/dist/themes/bars-pill.css') }}" rel="stylesheet">
<link href="{{ adminAssetsUrl('plugins/jquery-bar-rating/dist/themes/bars-reversed.css') }}" rel="stylesheet">
<link href="{{ adminAssetsUrl('plugins/jquery-bar-rating/dist/themes/bars-square.css') }}" rel="stylesheet">
<link href="{{ adminAssetsUrl('plugins/jquery-bar-rating/dist/themes/bootstrap-stars.css') }}" rel="stylesheet">
<link href="{{ adminAssetsUrl('plugins/jquery-bar-rating/dist/themes/css-stars.css') }}" rel="stylesheet">
<link href="{{ adminAssetsUrl('plugins/jquery-bar-rating/dist/themes/fontawesome-stars-o.css') }}" rel="stylesheet">
<link href="{{ adminAssetsUrl('plugins/jquery-bar-rating/examples/css/examples.css') }}" rel="stylesheet">

<link href="{{ adminAssetsUrl('plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet">
<link href="{{ adminAssetsUrl('plugins/x-editable/css/bootstrap-editable.css') }}" rel="stylesheet">
<link href="{{ adminAssetsUrl('plugins/dropify/css/dropify.min.css') }}" rel="stylesheet">
<link href="{{ adminAssetsUrl('plugins/dropzone/dropzone.min.css') }}" rel="stylesheet">
<link href="{{ adminAssetsUrl('plugins/jquery-file-upload/uploadfile.css') }}" rel="stylesheet">
<link href="{{ adminAssetsUrl('plugins/jquery-asColorPicker/css/asColorPicker.min.css') }}" rel="stylesheet">
<link href="{{ adminAssetsUrl('plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link href="{{ adminAssetsUrl('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}"
    rel="stylesheet">


<link href="{{ adminAssetsUrl('plugins/jquery-toast-plugin/jquery.toast.min.css') }}" rel="stylesheet">

<link href="{{ adminAssetsUrl('plugins/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">

<link media="all" type="text/css" rel="stylesheet"
    href="{{ adminAssetsUrl('plugins/@mdi/font/css/materialdesignicons.min.css') }}">


<!-- Select 2  -->
<link href="{{ adminAssetsUrl('plugins/icheck/skins/all.css') }}" rel="stylesheet">
<link href="{{ adminAssetsUrl('plugins/select2/css/select2.min.css') }}" rel="stylesheet">

@endpush


@push('plugin-scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ adminAssetsUrl('plugins/jquery-sparkline/jquery.sparkline.min.js') }}" type="text/javascript">
</script>
<script src="{{ adminAssetsUrl('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
    type="text/javascript">
</script>
@endpush

@push('custom-scripts')
<script src="{{ adminAssetsUrl('js/dashboard.js') }}" type="text/javascript"></script>
@endpush


@push('plugin-scripts')
<script src="{{ adminAssetsUrl('plugins/jquery-validation/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ adminAssetsUrl('plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}" type="text/javascript">
</script>
@endpush

@push('custom-scripts')
<script src="{{ adminAssetsUrl('js/form-validation.js') }}" type="text/javascript"></script>
<script src="{{ adminAssetsUrl('js/bt-maxlength.js') }}" type="text/javascript"></script>
@endpush


@push('plugin-scripts')
<script src="{{ adminAssetsUrl('plugins/moment/moment.js') }}" type="text/javascript"></script>
<script src="{{ adminAssetsUrl('plugins/jquery-bar-rating/jquery.barrating.js') }}" type="text/javascript"></script>
<script src="{{ adminAssetsUrl('plugins/jquery-tags-input/jquery.tagsinput.min.js') }}" type="text/javascript"></script>


{{-- <script src="{{ adminAssetsUrl('plugins/x-editable/js/bootstrap-editable.min.js') }}" type="text/javascript">
</script> --}}

<script src="{{ adminAssetsUrl('plugins/inputmask/jquery.inputmask.bundle.js') }}" type="text/javascript"></script>
<script src="{{ adminAssetsUrl('plugins/dropify/js/dropify.min.js') }}" type="text/javascript"></script>
<script src="{{ adminAssetsUrl('plugins/dropzone/dropzone.min.js') }}" type="text/javascript"></script>
<script src="{{ adminAssetsUrl('plugins/jquery-file-upload/jquery.uploadfile.min.js') }}" type="text/javascript">
</script>
<script src="{{ adminAssetsUrl('plugins/jquery-asColor/jquery-asColor.min.js') }}" type="text/javascript"></script>
<script src="{{ adminAssetsUrl('plugins/jquery-asGradient/jquery-asGradient.min.js') }}" type="text/javascript">
</script>
<script src="{{ adminAssetsUrl('plugins/jquery-asColorPicker/jquery-asColorPicker.min.js') }}" type="text/javascript">
</script>
<script src="{{ adminAssetsUrl('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
    type="text/javascript"></script>
<script src="{{ adminAssetsUrl('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js') }}"
    type="text/javascript"></script>
<script src="{{ adminAssetsUrl('plugins/jqueryrepeater/jquery.repeater.min.js') }}" type="text/javascript"></script>


@endpush

@push('custom-scripts')
<script src="{{ adminAssetsUrl('js/form-addons.js') }}" type="text/javascript"></script>
<script src="{{ adminAssetsUrl('js/x-editable.js') }}" type="text/javascript"></script>
<script src="{{ adminAssetsUrl('js/inputmask.js') }}" type="text/javascript"></script>
<script src="{{ adminAssetsUrl('js/dropify.js') }}" type="text/javascript"></script>
<script src="{{ adminAssetsUrl('js/dropzone.js') }}" type="text/javascript"></script>
<script src="{{ adminAssetsUrl('js/jquery-file-upload.js') }}" type="text/javascript"></script>
<script src="{{ adminAssetsUrl('js/form-repeater.js') }}" type="text/javascript"></script>
<script src="{{ adminAssetsUrl('js/formpickers.js') }}" type="text/javascript"></script>
@endpush


<!-- Toast -->
@push('plugin-scripts')
<script src="{{ adminAssetsUrl('plugins/jquery-toast-plugin/jquery.toast.min.js') }}" type="text/javascript"></script>
@endpush

@push('custom-scripts')
<script src="{{ adminAssetsUrl('js/toastDemo.js') }}" type="text/javascript"></script>
<script src="{{ adminAssetsUrl('js/desktop-notification.js') }}" type="text/javascript"></script>
@endpush
<!-- Toast End -->


<!-- Data Tables -->
@push('plugin-scripts')
<script src="{{ adminAssetsUrl('plugins/datatables.net/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ adminAssetsUrl('plugins/datatables.net-bs4/js/dataTables.bootstrap4.js') }}" type="text/javascript">
</script>
@endpush

@push('custom-scripts')
<script src="{{ adminAssetsUrl('js/data-table.js') }}" type="text/javascript"></script>
@endpush
<!-- Data Tables End -->

<!--- Select And jQuery File Upload -->
@push('plugin-scripts')
<script src="{{ adminAssetsUrl('plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
<script src="{{ adminAssetsUrl('plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ adminAssetsUrl('plugins/typeaheadjs/typeahead.bundle.min.js') }}" type="text/javascript"></script>
@endpush

@push('custom-scripts')
<script src="{{ adminAssetsUrl('js/file-upload.js') }}" type="text/javascript"></script>
<script src="{{ adminAssetsUrl('js/iCheck.js') }}" type="text/javascript"></script>
<script src="{{ adminAssetsUrl('js/select2.js') }}" type="text/javascript"></script>
<script src="{{ adminAssetsUrl('js/typeahead.js') }}" type="text/javascript"></script>
@endpush
<!-- Select And jQuery File Upload -->
