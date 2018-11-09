<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard</title>

    <link href="{{ url('public/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ url('public/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <!-- Toastr style -->
    <link href="{{ url('public/css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">

    <!-- Gritter -->
    <link href="{{ url('public/js/plugins/gritter/jquery.gritter.css')}}" rel="stylesheet">

    <link href="{{ url('public/css/animate.css')}}" rel="stylesheet">
    <link href="{{ url('public/css/style.css')}}" rel="stylesheet">
    
    <!-- calendar -->
    <link href="{{ url('public/css/plugins/fullcalendar/fullcalendar.css')}}" rel="stylesheet">
    <link href="{{ url('public/css/plugins/fullcalendar/fullcalendar.print.css')}}" rel='stylesheet' media='print'>
    <link href="{{ url('public/css/plugins/fullcalendar/scheduler.min.css')}}" rel="stylesheet">

    <link href="{{url('public/css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('public/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
    <link href="{{url('public/css/plugins/datapicker/bootstrap-datetimepicker.css')}}" rel="stylesheet">

    <link href="{{url('public/css/plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css')}}" rel="stylesheet">

    <link href="{{url('public/css/plugins/cropper/cropper.min.css')}}" rel="stylesheet">

    <link href="{{url('public/css/plugins/jqueryloadmask/waitme.min.css')}}" rel="stylesheet">

    <!-- Mainly scripts -->
    <script src="{{ url('public/js/jquery-2.1.1.js')}}"></script>
    <script src="{{ url('public/js/bootstrap.min.js')}}"></script>
    <script src="{{ url('public/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{ url('public/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

    <!-- Flot -->
    <script src="{{ url('public/js/plugins/flot/jquery.flot.js')}}"></script>
    <script src="{{ url('public/js/plugins/flot/jquery.flot.tooltip.min.js')}}"></script>
    <script src="{{ url('public/js/plugins/flot/jquery.flot.spline.js')}}"></script>
    <script src="{{ url('public/js/plugins/flot/jquery.flot.resize.js')}}"></script>
    <script src="{{ url('public/js/plugins/flot/jquery.flot.pie.js')}}"></script>

    <!-- Peity -->
    <script src="{{ url('public/js/plugins/peity/jquery.peity.min.js')}}"></script>
    <script src="{{ url('public/js/demo/peity-demo.js')}}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ url('public/js/inspinia.js')}}"></script>
    <script src="{{ url('public/js/plugins/pace/pace.min.js')}}"></script>

    <!-- jQuery UI -->
    <script src="{{ url('public/js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <!-- GITTER -->
    <script src="{{ url('public/js/plugins/gritter/jquery.gritter.min.js')}}"></script>

    <!-- Sparkline -->
    <script src="{{ url('public/js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>

    <!-- Sparkline demo data  -->
    <script src="{{ url('public/js/demo/sparkline-demo.js')}}"></script>

    <!-- ChartJS-->
    <script src="{{ url('public/js/plugins/chartJs/Chart.min.js')}}"></script>

    <!-- Toastr -->
    <script src="{{ url('public/js/plugins/toastr/toastr.min.js')}}"></script>

    <script src="{{ url('public/js/plugins/fullcalendar/moment.min.js')}}"></script>

    <script src="{{ url('public/js/plugins/fullcalendar/fullcalendar.min.js')}}"></script>
    
    <script src="{{ url('public/js/plugins/fullcalendar/scheduler.min.js')}}"></script>

    <!-- Input Mask-->
    <script src="{{ url('public/js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>

    <!-- Data picker -->
    <script src="{{ url('public/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>    
    <script src="{{ url('public/js/plugins/datapicker/bootstrap-datetimepicker.js')}}"></script>

    <script src="{{ url('public/js/plugins/combobox/bootstrap-combobox.js')}}"></script>

    <!-- NouSlider -->
    <script src="{{ url('public/js/plugins/nouslider/jquery.nouislider.min.js')}}"></script>

    <!-- IonRangeSlider -->
    <script src="{{ url('public/js/plugins/ionRangeSlider/ion.rangeSlider.min.js')}}"></script>

    <!-- Jquery template -->
    <script src="{{ url('public/js/jquery.tmpl.js')}}"></script>

    <!-- Chosen jquery -->
    <script src="{{ url('public/js/plugins/chosen/chosen.jquery.js')}}"></script>
    
    <!-- Image cropper -->
    <script src="{{url('public/js/plugins/cropper/cropper.min.js')}}"></script>

    <!-- Jquery loadmask -->
    <script src="{{url('public/js/plugins/jqueryloadmask/waitme.js')}}"></script>    
</head>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="">
                        <div class="menu-brand">
                            <div class="logo"><img src="{{url('public/img/logo.png')}}" style="width:100%"></div>
                        </div>
                    </li>
                    <li {!! Request::is('dashboard/getting-started') ? 'class="active"' : '' !!}>
                        <a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label">Getting Started</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li {!! Request::is('dashboard/getting-started') ? 'class="active"' : '' !!}><a href="{{url('/dashboard/getting-started')}}">Getting Started</a></li>
                        </ul>
                    </li>

            @if(Session::has('permission'))
                @if(Session::get('permission') != '3')
                    <li {!! Request::is('dashboard/index') ? 'class="active"' : '' !!}>
                        <a href="layouts.html"><i class="fa fa-diamond"></i> <span class="nav-label">Dashboard</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li {!! Request::is('dashboard/index') ? 'class="active"' : '' !!}><a href="/dashboard/index">Today's Activities</a></li>
                        </ul>
                    </li>
                @endif
                    <li {!! Request::is('dashboard/calendar/*') ? 'class="active"' : '' !!}>
                        <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Calender</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li {!! Request::is('dashboard/calendar/month') ? 'class="active"' : '' !!}><a href="/dashboard/calendar/month">Month</a></li>
                            <li {!! Request::is('dashboard/calendar/week') ? 'class="active"' : '' !!}><a href="/dashboard/calendar/week">Week</a></li>
                            <li {!! Request::is('dashboard/calendar/grid') ? 'class="active"' : '' !!}><a href="/dashboard/calendar/grid">Grid</a></li>
                            <li {!! Request::is('dashboard/calendar/map') ? 'class="active"' : '' !!}><a href="/dashboard/calendar/map">Map</a></li>
                            <li {!! Request::is('dashboard/calendar/list') ? 'class="active"' : '' !!}><a href="/dashboard/calendar/list">List</a></li>
                        </ul>
                    </li>
                @if(Session::get('permission') != '3')
                    <li {!! Request::is('dashboard/clients') || Request::is('dashboard/clients/*') || Request::is('dashboard/properties')  || Request::is('dashboard/properties/*') ? 'class="active"' : '' !!}>
                        <a href="mailbox.html"><i class="fa fa-envelope"></i> <span class="nav-label">Client</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li {!! Request::is('dashboard/clients') || Request::is('dashboard/clients/*') ? 'class="active"' : '' !!}><a href="/dashboard/clients">People</a></li>
                            <li {!! Request::is('dashboard/properties') || Request::is('dashboard/properties/*') ? 'class="active"' : '' !!}><a href="/dashboard/properties">Property</a></li>
                        </ul>
                    </li>
                    <li {!! Request::is('dashboard/work') || Request::is('dashboard/work/*') ? 'class="active"' : '' !!}>
                        <a href="widgets.html"><i class="fa fa-flask"></i> <span class="nav-label">Work</span><span class="fa arrow"></span> </a>
                        <ul class="nav nav-second-level">
                            <li {!! Request::is('dashboard/work') || Request::is('dashboard/work/overview') ? 'class="active"' : '' !!}><a href="/dashboard/work/overview">Overview</a></li>
                            <li {!! Request::is('dashboard/work/quotes') || Request::is('dashboard/work/quotes/*') ? 'class="active"' : '' !!}><a href="/dashboard/work/quotes">Quotes</a></li>
                            <li {!! Request::is('dashboard/work/jobs') || Request::is('dashboard/work/jobs/*') ? 'class="active"' : '' !!}><a href="/dashboard/work/jobs">Jobs</a></li>
                        @if(Session::get('permission') != '3' && Session::get('permission') != '4')
                            <li {!! Request::is('dashboard/work/invoices') || Request::is('dashboard/work/invoices/*') ? 'class="active"' : '' !!}><a href="/dashboard/work/invoices">Invoices</a></li>
                        @endif
                        </ul>
                    </li>
                @endif
                @if(Session::get('permission') == '1' || Session::get('permission') == '2')
                    <li {!! Request::is('dashboard/management') || Request::is('dashboard/management/*') ? 'class="active"' : '' !!}>
                        <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Management</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li {!! Request::is('dashboard/management/report') || Request::is('dashboard/management/report/*') ? 'class="active"' : '' !!}><a href="/dashboard/management/report">Report</a></li>
                            <li {!! Request::is('dashboard/management/approve') || Request::is('dashboard/management/approve/*') ? 'class="active"' : '' !!}><a href="/dashboard/management/approve">Approve Timesheets</a></li>
                            <li {!! Request::is('dashboard/management/payroll') || Request::is('dashboard/management/payroll/*') ? 'class="active"' : '' !!}><a href="/dashboard/management/payroll">Confirm Payroll</a></li>
                            <li {!! Request::is('dashboard/management/team') || Request::is('dashboard/management/team/*') ? 'class="active"' : '' !!}><a href="/dashboard/management/team">Manage Team</a></li>
                            <li {!! Request::is('dashboard/management/services') || Request::is('dashboard/management/services/*')
                                    || Request::is('dashboard/management/products') || Request::is('dashboard/management/products/*') ? 'class="active"' : '' !!}><a href="/dashboard/management/services">Services & Products</a></li>
                            <li {!! Request::is('dashboard/management/taxes') || Request::is('dashboard/management/taxes/*') ? 'class="active"' : '' !!}><a href="/dashboard/management/taxes">Manage Tax</a></li>
                        </ul>
                    </li>
                @endif
                @if(Session::get('permission') != '3')
                    <li {!! Request::is('dashboard/timesheet') || Request::is('dashboard/timesheet/*') ? 'class="active"' : '' !!}>
                        <a href="#"><i class="fa fa-desktop"></i> <span class="nav-label">Time sheet</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li {!! Request::is('dashboard/timesheet/today') || Request::is('dashboard/timesheet/today/*') ? 'class="active"' : '' !!}><a href="/dashboard/timesheet/today">Today</a></li>
                            <li {!! Request::is('dashboard/timesheet/week') || Request::is('dashboard/timesheet/week/*') ? 'class="active"' : '' !!}><a href="/dashboard/timesheet/week">Week</a></li>
                        </ul>
                    </li>
                @endif
                    <ul class="nav" id="logout">
                        <li>
                            <a href="{{ url('logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                        <i class="fa fa-desktop"></i>
                                <span class="nav-label">Logout</span>
                            </a>
                            <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                
            @endif                   
                </ul>
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-default " href="#"><i class="fa fa-bars"></i> </a>
                        <div class="pull-right">
                            <form role="search" class="navbar-form-custom" method="post" action="">
                                <div class="form-group">
                                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                                </div>
                            </form>
                        </div>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <!-- <li class="dropdown">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                            </a>
                            <ul class="dropdown-menu dropdown-messages">
                                <li>
                                    <div class="dropdown-messages-box">
                                        <a href="profile.html" class="pull-left">
                                            <img alt="image" class="img-circle" src="img/a7.jpg">
                                        </a>
                                        <div class="media-body">
                                            <small class="pull-right">46h ago</small>
                                            <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                            <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <div class="dropdown-messages-box">
                                        <a href="profile.html" class="pull-left">
                                            <img alt="image" class="img-circle" src="img/a4.jpg">
                                        </a>
                                        <div class="media-body ">
                                            <small class="pull-right text-navy">5h ago</small>
                                            <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                            <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <div class="dropdown-messages-box">
                                        <a href="profile.html" class="pull-left">
                                            <img alt="image" class="img-circle" src="img/profile.jpg">
                                        </a>
                                        <div class="media-body ">
                                            <small class="pull-right">23h ago</small>
                                            <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                            <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <div class="text-center link-block">
                                        <a href="mailbox.html">
                                            <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li> -->
                        <li class="dropdown">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                <i class="jobber-icon jobber-cog jobber-2x"></i>
                                <!-- <span class="label label-primary">1</span> -->
                            </a>
                            <ul class="dropdown-menu dropdown-alerts dropdown-profile">
                                <li>
                                    <span class="profile">
                                        <?php
                                            $team = DB::table('teams')->where('team_member_id', Auth::user()->team_id)->first();
                                            if (!empty($team) && !is_null($team->photo) && $team->photo != '') {
                                                echo "<img src='".url('/public/profile')."/".$team->photo."' width='35' height='35'/>";
                                            }else{
                                                echo(Auth::user()->fullname[0]);
                                            }
                                         ?>
                                    </span>
                                    <div>
                                        <span class="fullname-text">{{Auth::user()->fullname}}</span>
                                        <span class="email-text">{{Auth::user()->email}}</span>
                                    </div>
                                </li>
                                <li>
                                    <a href="/dashboard/setting/change_password_view">
                                        <span class="link-text">Change Password</span>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="{{ url('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        <span class="link-text">Logout</span>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                    <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                    <!-- <a href="{{ url('logout') }}">
                                        <span class='link-text'>Logout</span>
                                    </a> -->
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="row">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
