<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>

        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"> 

        <link rel="stylesheet" href="{{ asset('css/wpanel/library/bootstrap/css/jquery.sidr.light.css') }}">
        <link rel="stylesheet" href="{{ asset('css/wpanel/library/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/wpanel/library/bootstrap/css/fontawesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/wpanel/library/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('css/wpanel/library/bootstrap/css/custom-icon-set.css') }}">
        <link rel="stylesheet" href="{{ asset('css/wpanel/library/notifications.css') }}">
        <link rel="stylesheet" href="{{ asset('css/wpanel/library/datepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('css/wpanel/style.css') }}">

        <script src="{{ asset('js/wpanel/library/jquery-3.3.1.min.js') }}"></script>
        <script src="{{ asset('js/wpanel/library/jquery-ui-1.12.1.min.js') }}"></script>
        
        @yield('css')
    </head>

    <body>
        <div class="header navbar navbar-inverse ">
            <div class="navbar-inner">
                <div class="header-seperation">
                    <ul class="nav pull-left notifcation-center" id="main-menu-toggle-wrapper" style="display:none">
                        <li class="dropdown">
                            <a id="main-menu-toggle" href="#main-menu" class="">
                                <div class="iconset top-menu-toggle-white"></div>
                            </a>
                        </li>
                    </ul>
                    <a href="">
                        <img style="width: 100px; height: auto; margin-left: 25%;" src="">
                    </a>
                    <ul class="nav pull-right notifcation-center">
                        <li class="dropdown visible-xs" id="header_task_bar">
                            <a href="{{ route('wp.logout') }}">
                                <img src="{{ asset('img/wpanel/exit.png') }}">
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="header-quick-nav" >
                    <div class="pull-left">
                        <ul class="nav quick-section" style="display: none;">
                            <li class="quicklinks">
                                <a href="#" class="" id="layout-condensed-toggle">
                                    <div class="iconset top-menu-toggle-dark"></div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="pull-right">
                        <div class="chat-toggler">
                            <div class="user-details">
                                <div class="username">
                                    <span class="bold">{{ Auth::guard('admin')->user()->name }}&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                </div>
                            </div>
                            <div class="profile-pic">
                                @php $photo = Auth::guard('admin')->user()->photo; @endphp
                                <img src="{{ ($photo != '') ? asset('files/user/image/' . $photo) : asset('img/wpanel/user.png') }}"  alt="" data-src="{{ ($photo != '') ? asset('files/user/image/' . $photo) : asset('img/wpanel/user.png') }}" data-src-retina="{{ ($photo != '') ? asset('files/user/image/' . $photo) : asset('img/wpanel/user.png') }}" width="35" height="35" />
                            </div>
                        </div>
                        <ul class="nav quick-section ">
                            <li class="quicklinks">
                                <a data-toggle="dropdown" class="dropdown-toggle pull-right" href="#" id="user-options">
                                    <div class="iconset top-settings-dark"></div>
                                </a>
                                <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="user-options">
                                    <li><a href="{{ route('wp.home.profile') }}"><i class="fa fa-user"></i>&nbsp;&nbsp;Mi perfil</a></li>
                                    <li class="divider"></li>
                                    <li><a href="{{ route('wp.logout') }}"><i class="fa fa-power-off"></i>&nbsp;&nbsp;Salir</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-container row">
            @include('elements/wpanel_menu')
            <div class="page-content">
                <div id="portlet-config" class="modal hide">
                    <div class="modal-header">
                        <button data-dismiss="modal" class="close" type="button"></button>
                        <h3>Settings</h3>
                    </div>
                    <div class="modal-body">Settings</div>
                </div>
                <div class="clearfix"></div>
                <div class="content">
        
                    @yield('content')

                    <div class="loadingTmp">
                        <img src="{{ asset('img/wpanel/loading.svg') }}">
                    </div>
                </div>
            </div>
        </div>
    </body>

    <script src="{{ asset('js/wpanel/library/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/wpanel/library/breakpoints.js') }}"></script>
    <script src="{{ asset('js/wpanel/library/jquery.sidr.min.js') }}"></script>
    <script src="{{ asset('js/wpanel/library/notifications/jquery.gritter.min.js') }}"></script>
    <script src="{{ asset('js/wpanel/library/notifications/jsNotifications.js') }}"></script>
    <script src="{{ asset('js/wpanel/library/notifications/bootbox.min.js') }}"></script>
    <script src="{{ asset('js/wpanel/library/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('js/wpanel/validate.js') }}"></script>

    @if((isset($activeImage))and($activeImage))
        <link rel="stylesheet" href="{{ asset('css/wpanel/library/shadowbox.css') }}">
        <script src="{{ asset('js/wpanel/library/shadowbox.js') }}"></script>
        <script type='text/javascript'>
        Shadowbox.init({
            overlayColor: "#000",
            overlayOpacity: "0.9"
        });
        </script>
    @endif

    @if(session('success'))
        <script>objInstanceName.show('ok','{{ session('success') }}');</script>
    @endif  
    
    @if(session('error'))
        <script>objInstanceName.show('error','Vuelva a intentarlo',false,'{{ session('error') }}');</script>
    @endif  
    
    @yield('js')

</html>