<?php

use Modules\Platform\Core\Helper\SettingsHelper as SettingsHelper;
use Krucas\Settings\Facades\Settings as Settings;

?>


        <!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title> {{ \Modules\Platform\Core\Helper\SettingsHelper::getApplicationTitle() }}</title>
    <!-- Favicon-->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('bap/images/favicon.png') }}" type="image/png">

    <link href="{{ asset('bap/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,latin-ext,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">

    @stack('css-up')



    <script type="text/javascript" src="{{ asset('bap/plugins/jquery/jquery.min.js')}}"></script>

    @if(config('broadcasting.connections.pusher.key') != '')
        <script src="https://js.pusher.com/3.1/pusher.min.js"></script>
        <script>

            window.PUSHER = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
                encrypted: true
            });

        </script>
    @endif

        <!-- Css -->
        {!!  Packer::css([
            '/bap/plugins/bootstrap/css/bootstrap.css',
            '/bap/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css',
            '/bap/plugins/node-waves/waves.css',
            '/bap/plugins/animate-css/animate.css',
            '/bap/plugins/bootstrap-select/css/bootstrap-select.css',
            '/bap/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
            '/bap/plugins/jquery-datatable/extensions/responsive/css/responsive.dataTables.css',
            '/bap/scss/style.css',
            '/bap/plugins/offlinejs/offline-theme-chrome.css',
            '/bap/plugins/offlinejs/offline-language-english.css',
            '/bap/plugins/select2-4.0.3/dist/css/select2.min.css',
            '/bap/plugins/select2-4.0.3/dist/css/select2-bootstrap.css',
            '/bap/plugins/select2-4.0.3/dist/css/pmd-select2.css',
            '/bap/plugins/bootstrap-daterangepicker/daterangepicker.css',
            '/bap/plugins/bootstrap-datetimepicker/dist/css/bootstrap-datetimepicker.min.css',
            '/bap/plugins/jquery-datatable/yadcf/jquery.dataTables.yadcf.css',
            '/bap/plugins/bootstrap-fileinput/css/fileinput.min.css',
            '/bap/plugins/jquery-comments/css/jquery-comments.css',
            '/bap/plugins/jquert-query-builder/css/query-builder.default.css',
            '/bap/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css',
            '/bap/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css',
            '/bap/scss/custom.css',
            ],
            '/storage/cache/css/main.css'
        ) !!}


    @stack('css')


    @include('partial.header_js')

    <!-- here -->


</head>

<body class="{{ Auth::user()->theme() }} @yield('body_class')">

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">

        @if(config('bap.preloader_type') == 'ball')
            <div style="color: #84a5dd; margin: 0 auto" class="la-ball-scale-multiple la-3x">
                <div></div>
                <div></div>
                <div></div>
            </div>
        @endif
            @if(config('bap.preloader_type') == 'circle')
        <div class="preloader">
            <div class="spinner-layer pl-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
            @endif
        <p>@lang('core::core.please_wait')</p>
    </div>
</div>
<!-- #END# Page Loader -->
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->

@include('partial.search-bar')
@include('partial.top-bar')
<section>


    @include('partial.left-sidebar')

    @include('partial.right-sidebar')
</section>

<section class="content">
    <div class="container-fluid">



        @include('flash::message')

        @yield('content')

    </div>
</section>


@include('partial.bottom_js')


@stack('scripts')


<div class="modal fade" id="genericModal" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 10080!important;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel"></h4>
            </div>

            <div class="modal-body ">

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">@lang('core::core.CLOSE')</button>
            </div>
        </div>
    </div>
</div>

@include('announcement::announcement-message')

</body>
</html>
