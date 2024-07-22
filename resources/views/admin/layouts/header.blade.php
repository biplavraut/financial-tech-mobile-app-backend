<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width" />
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" type="text/css"
  href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" />




{{--
<link rel="stylesheet" href="{{ adminAssetsUrl('iconfont/material-icons.css') }}"> --}}

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!-- Favicon-->

<!-- Favicon-->
<link rel="icon" href="">
<title>@yield('title') - bibaabo - Admin</title>

<!-- My css -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<style>
  .my-sub-heading {
    margin-top: 0;
    color: #ffffff;
    background: #555555;
    display: inline-block;
    padding: 0 15px;
    font-weight: bold;
    border-bottom: 3px solid #43a047;
    text-transform: capitalize;
  }

  .my-divider {
    border-bottom: 1px solid #cccccc;
    margin: 40px -20px;
  }

  .cursor {
    cursor: pointer;
  }
</style>

