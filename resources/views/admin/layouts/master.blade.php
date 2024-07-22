<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
  @include('admin.layouts.header')
  <!-- plugin css -->
  <link rel="stylesheet" href="{{ adminAssetsUrl('plugins/@mdi/font/css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{ adminAssetsUrl('plugins/ti-icons/css/themify-icons.css')}}">
  <link rel="stylesheet" href="{{ adminAssetsUrl('plugins/perfect-scrollbar/perfect-scrollbar.css')}}">
  <link rel="stylesheet" href="{{asset('css/nestable.css')}}">
  <link rel="stylesheet" href="{{asset('css/multiselect.css')}}">
  <!-- end plugin css -->
  
  @stack('plugin-styles')
  
  <!-- common css -->
  <link rel="stylesheet" href="{{ adminAssetsUrl('css/app.css')}}">
  <!-- end common css -->
  
  @stack('style')

  @vite('resources/js/app.js')
  
</head>


<body class="sidebar-fixed" data-base-url="{{url('/')}}">
  {{-- @include('common.flash_message_ajax') --}}
  {{-- <div class="container-scroller">
    
    @include('admin.layouts.header')
    <div class="container-fluid page-body-wrapper">
      @include('admin.layouts.settings-panel')
      @include('admin.layouts.sidebar')
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>
        @include('admin.layouts.footer')
        
      </div>
    </div>
  </div> --}}
   @yield('content')

  @include('admin.layouts.footer')
  
</body>

</html>