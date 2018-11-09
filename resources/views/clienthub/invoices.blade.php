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
                            <a href="#" class="navbar-brand company-name">{{$user->name}}</a>
                        </div>
                        <div class="navbar-collapse collapse" id="navbar">
                            <ul class="nav navbar-top-links navbar-right div-flex">
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
        <div class="flexBlock large-flexHorizontal white-bg full-height">
            <div class="tab-content full-height div-flex">
                <div class="navbar-collapse collapse vertical-left left-navbar">
                    <nav class="">
                        <a href="{{url('clienthub')}}/{{$user_id}}/quotes/{{$quote_id}}" class="navbar-item">
                            <i class="jobber-icon jobber-2x jobber-quote"></i>
                            <span class="navbar-label">Quotes</span>
                        </a>
                        @if($invoiceinfo)
                        <a href="{{url('clienthub')}}/{{$user_id}}/invoices/{{$invoiceinfo->invoice_id}}" class="navbar-item active">
                            <i class="jobber-icon jobber-2x jobber-invoice"></i>
                            <span class="navbar-label">Invoices</span>
                        </a>
                        @else
                        <a href="{{url('clienthub')}}/{{$user_id}}/invoices/0" class="navbar-item active">
                            <i class="jobber-icon jobber-2x jobber-invoice"></i>
                            <span class="navbar-label">Invoices</span>
                        </a>
                        @endif
                    </nav>
                </div>
                <div class="" style="width: 100%;">
                    <div class="col-md-3 vertical-left">
                        @if($invoiceinfo)
                        <div class="row">
                            <div class="col-md-12 square-padding border-bottom grey-bg">
                                <h3>Your Invoices</h3>
                            </div>
                            <div class="col-md-12 uppercase textbold border-bottom square-padding">
                                <div class="row">
                                    <div class="col-md-3">Due</div>
                                    <div class="col-md-3">Number</div>
                                    <div class="col-md-6 text-right">Total</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <ul class="quotes-list">
                                @if(count($awaiting_invoices))
                                    <h3 class="thicklist-sectionHeader orange-tag font-p12">AWAITING RESPONSE</h3>
                                    @foreach($awaiting_invoices as $invoice)
                                    <li>
                                        <a class="thicklist-row <?php echo $invoice->invoice_id == $invoice_id? 'active': ''; ?>" href="{{url('clienthub')}}/{{$user_id}}/invoices/{{$invoice->invoice_id}}">
                                            <div class="row">
                                                <div class="col-md-3">{{date('M d',strtotime($invoice->payment_date))}}</div>
                                                <div class="col-md-3"># {{$invoice->invoice_id}}</div>
                                                <div class="col-md-6 text-right">${{$invoice->total}}</div>
                                            </div><!--row-->
                                        </a>
                                    </li>
                                    @endforeach
                                @endif
                                @if(count($approved_invoices))
                                    <h3 class="thicklist-sectionHeader green-tag font-p12">PAID</h3>
                                    @foreach($approved_invoices as $invoice)
                                    <li>
                                        <a class="thicklist-row <?php echo $invoice->invoice_id == $invoice_id? 'active': ''; ?>" href="{{url('clienthub')}}/{{$user_id}}/invoices/{{$invoice->invoice_id}}">
                                            <div class="row">
                                                <div class="col-md-3">{{date('M d',strtotime($invoice->payment_date))}}</div>
                                                <div class="col-md-3"># {{$invoice->invoice_id}}</div>
                                                <div class="col-md-6 text-right">${{$invoice->total}}</div>
                                            </div><!--row-->
                                        </a>
                                    </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        @else
                        <div class="row full-height">
                            <div class="col-md-12 square-padding border-bottom grey-bg">
                                <h3>Your Invoices</h3>
                            </div>
                            <div class="col-md-12 full-height div-flex">
                                <div class="no-invoice">
                                    <h3>You haven't received any invoices yet</h3>
                                    <p>All invoices we've sent to you will appear here.</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @if($invoiceinfo)
                    <div class="col-md-9" style="overflow-y: auto;height: 100%;">
                        <div class="col-md-12">
                            <div class="btn-group square-padding">
                                <a href="{{url('clienthub/generate-pdf')}}/{{$user_id}}/{{$invoiceinfo->invoice_id}}?type=invoice" type="button" class="btn btn-white"><i class="fa fa-print fa-2x"></i></a>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="invoice-main-body">
                                <div class="invoice-main-headdetail">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="col-md-12">
                                                <p class="client-name font-p14">Invoice # {{$invoiceinfo->invoice_id}}</p>
                                                <p class="client-address-title grey-title font-p18"><strong>{{$clientinfo->first_name}} {{$clientinfo->last_name}}</strong></p>
                                                <p class="client-address-info font-p14">{{$invoiceinfo->street1}} {{$invoiceinfo->street2}} {{$invoiceinfo->city}} {{$invoiceinfo->state}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-5 white-bg" style="padding: 18px;">
                                            <div class="col-md-12">
                                                @if($invoiceinfo->status == 2)
                                                <span class="inlineLabel inlineLabel--orange pull-right font-p12">
                                                    awaiting response
                                                </span>
                                                @elseif($invoiceinfo->status == 3)
                                                <span class="inlineLabel inlineLabel--green pull-right font-p12">
                                                    paid
                                                </span>
                                                @endif
                                            </div>
                                            <div class="col-md-12">
                                                <ul class="header-list">
                                                    <li class="list-item font-p14">
                                                        <div class="col-md-5">
                                                            <span>Issue</span>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <span>{{date('Y-m-d',strtotime($invoiceinfo->issue_date))}}</span>
                                                        </div>
                                                    </li>
                                                    @if($invoiceinfo->received_date)
                                                    <li class="list-item font-p14">
                                                        <div class="col-md-5">
                                                            <span>Due</span>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <span>{{date('Y-m-d',strtotime($invoiceinfo->payment_date))}}</span>
                                                        </div>
                                                    </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="invoice-main-headtable">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table lineitemTable text-right">
                                                <thead>
                                                    <tr>
                                                        <th width="40%" align="left">
                                                            <h4 class="headingTwo">SERVICE / PRODUCT</h4>
                                                        </th>
                                                        <th width="15%" class="text-right">
                                                            <h4 class="headingTwo">QTY.</h4>
                                                        </th>
                                                        <th width="25%" class="text-right">
                                                            <h4 class="headingTwo">UNIT COST ($)</h4>
                                                        </th>
                                                        <th width="15%" class="text-right">
                                                            <h4 class="headingTwo">TOTAL ($)</h4>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($services as $service)
                                                    <tr>
                                                        <td>
                                                            <div class="col-md-12 text-left grey-title"><h4>{{$service->service_name}}</h4></div>
                                                            <div class="col-md-12 text-left">
                                                                <small>{{$service->service_description}}</small>
                                                            </div>
                                                        </td>
                                                        <td>{{$service->quantity}}</td>
                                                        <td>${{$service->cost}}</td>
                                                        <td>${{$service->quantity*$service->cost}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <div class="col-md-12 subinfo-body">
                                                <div class="row">
                                                    <div class="col-md-7 top-padding-small">
                                                        <div class="invoice-main-footer-first font-p14">
                                                            <span>This invoice is valid for the next 30 days, after which values may be subject to change.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5 top-padding-small vertical-divider">
                                                        <ul class="subinfo-list">
                                                            <li class="list-item font-p14">
                                                                <div class="col-md-12">
                                                                    <span class="pull-left">Subtotal</span>
                                                                    <span class="pull-right">${{$invoiceinfo->subtotal}}</span>
                                                                </div>
                                                            </li>
                                                            @if($invoiceinfo->discount_val)
                                                            <li class="list-item font-p14">
                                                                <div class="col-md-12">
                                                                    <span class="pull-left">Discount</span>
                                                                    <span class="pull-right">${{$invoiceinfo->discount_val}}</span>
                                                                </div>
                                                            </li>
                                                            @endif
                                                            @if($invoiceinfo->tax_val)
                                                            <li class="list-item font-p14">
                                                                <div class="col-md-12">
                                                                    <span class="pull-left">Tax({{$invoiceinfo->tax}}%)</span>
                                                                    <span class="pull-right">${{$invoiceinfo->tax_val}}</span>
                                                                </div>
                                                            </li>
                                                            @endif
                                                            <li class="list-item font-p14 bottom-border-fat grey-title">
                                                                <div class="col-md-12">
                                                                    <strong><span class="pull-left">Total</span></strong>
                                                                    <strong><span class="pull-right">${{$invoiceinfo->total}}</span></strong>
                                                                </div>
                                                            </li>
                                                            @if($invoiceinfo->deposit_val)
                                                            <li class="list-item font-p14">
                                                                <div class="col-md-12">
                                                                    <span class="pull-left">Required Deposit</span>
                                                                    <span class="pull-right">${{$invoiceinfo->deposit_val}}</span>
                                                                </div>
                                                            </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(count($receipts))
                        <div class="col-md-6" style="margin-top: 30px;">
                            <div class="receipt-header div-flex align-middle">
                                <h3 style="margin-bottom: 1rem;font-size: 18px;line-height: 1.5rem;"><i class="jobber-icon jobber-2x jobber-invoice"></i>
                                Receipts</h3>
                            </div>
                            @foreach($receipts as $receipt)
                            <div class="receipt-item">
                                <div class="row align-middle">
                                    <div class="col-md-12">
                                    <span class="font-p14 text-left">${{$receipt->amount}} Payment on {{$receipt->created_at}}</span>
                                    <!-- <button type="button" class="btn btn-xs btn-white pull-right viewreceipt">View</button> -->
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="col-md-9 full-height" style="background-color: #f3f3f3;"></div>
                    @endif
                </div>
            </div>
        </div><!-- End of Body -->
        <!-- Footer -->
        <div class="footer">
            <div class="row">
                <div class="col-md-12">
                    
                </div>
            </div>
        </div><!-- End of Footer -->
    </div>
</body>
</html>
