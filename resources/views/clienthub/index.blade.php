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
    
    <!-- <link href="{{url('public/css/workcustom.css')}}" rel="stylesheet"> -->
    <link href="{{url('public/css/clienthub.css')}}" rel="stylesheet">

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

</head>

<body>
    <div id="wrapper white-bg" class="body-content">
        <!-- Header -->
        <div id="page-wrapper margin-remove">
            <div class="">
                <div class="col-md-12 white-bg border-bottom">
                    <nav class="navbar navbar-static-top margin-remove" role="navigation">
                        <div class="navbar-header">
                            <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed pull-right" type="button">
                                <i class="fa fa-reorder"></i>
                            </button>
                            <a href="#" class="navbar-brand company-name">Company</a>
                        </div>
                        <div class="navbar-collapse collapse" id="navbar">
                            <ul class="nav navbar-top-links navbar-right" style="display: flex;">
                                <li>
                                    <div class="clientinfo">
                                        <h3 style="margin-top: 10px;">{{$clientinfo->first_name}} {{$clientinfo->last_name}}</h3>
                                        <p class="margin-remove">{{$clientinfo->value}}</p>
                                    </div>
                                </li>
                                <li>
                                    <a href="{{url('clienthub/logout')}}">
                                        <i class="fa fa-sign-out"></i> Log out
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div> 
        </div><!-- End of Header -->
        <!-- Body -->
        <div class="flexBlock large-flexHorizontal white-bg" style="height: 100%;">
            <div class="tab-content" style="display: flex;height: 100%;">
                <div style="width: 100%; display: flex;">
                    <div class="card card-body">
                        <h3>Check your email</h3>
                        <p class="font-p14">We have sent an email to {{$clientinfo->value}} with a link that will securely log you in.</p>
                    </div>
                </div>
            </div>
        </div><!-- End of Body -->
        <!-- Footer -->
        <div class="footer">

        </div><!-- End of Footer -->
    </div>
</body>
</html>
