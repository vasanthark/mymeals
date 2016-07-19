<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title> Mymeals | @yield('title') </title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        
        @yield('link')
        
        <!-- Theme style -->
        <link href="{{ URL::asset('css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('css/custom.css') }}" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <style>
            @yield('styles')
        </style>
        
          <!-- add new calendar event modal -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="//code.jquery.com/ui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
         <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
        <script src="//ajax.aspnetcdn.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js" type="text/javascript"></script>
       
         <!-- AdminLTE App -->
        <script src="{{ URL::asset('js/AdminLTE/app.js') }}" type="text/javascript"></script>
        @yield('script_files')
        
       

        <!-- AdminLTE for demo purposes -->
        <!--<script src="{{ URL::asset('js/AdminLTE/demo.js') }}" type="text/javascript"></script>-->
        
        @yield('scripts')

    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        @include('admin.partials.header')

        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            @include('admin.partials.leftsidebar')

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                @include('admin.partials.pageheader')

                @yield('content')
            </aside><!-- /.right-side -->
        </div>
        <!-- ./wrapper -->
    </body>
</html>
