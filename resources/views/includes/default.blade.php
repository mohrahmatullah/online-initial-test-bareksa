<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    @include('includes.estentialcss')

</head>
<body>    
    @include('includes.sidebar')

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Navbar Header -->
        @include('includes.header')
        {{-- @include('includes.breadcrumbs')  --}}
        <input type="hidden" name="hf_base_url" id="hf_base_url" value="{{ route('/') }}">     

        <!-- Main Content -->
        @yield('content')
        <!-- /Main Content -->

        @include('includes.footer')        

    </div><!-- /#right-panel -->

    <!-- Right Panel -->

    <!-- Scripts -->
    @include('includes.estentialjs')


</body>
</html>
