@extends('layout.menu')
@section('content')
<!-- <link rel="stylesheet" type="text/css" href="{{url('css/getjobber.css')}}"> -->
<link rel="stylesheet" type="text/css" href="{{url('public/css/workcustom.css')}}">
        <div class="page-heading">
            <div class="col-sm-4 page-header-title">
                <h1>Invoices</h1>
            </div>
            @if($permission == 1 || $permission == 2 || $permission == 6)
            <a data-toggle="modal" href="#modal-newinvoices" class="btn btn-new">+ New Invoices</a>
            @endif
            <div class="modal inmodal" id="modal-newinvoices" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title headingTwo text-left">Select or create a client</h4>
                    </div>
                    <div class="modal-body">
                        <p class="paragraph u-marginBottomSmall">
                            Which client would you like to create this invoice for?
                        </p>
                        <div class="ibox clientbox">
                            <div class="ibox-title">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <!-- <label class="fa search-label"> -->
                                            <form>
                                                <input type="search" placeholder="Search Clients..." 
                                                class="search-input action-border" id="searchclients"  required />
                                                <!-- <button class="close-icon" type="reset">
                                                    ×
                                                </button> -->
                                            </form>
                                            <!-- </label> -->
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a href="{{url('dashboard/clients/add')}}" type="button" class="btn btn-newclient creteNew u-textBold" remote="true">+ Create New Client</a>
                                        <span class="middle-text">Or</span>
                                    </div>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <ul id="clientlist">
                                    @foreach ($clients as $client)
                                    <li filter-client="{{$client->first_name}} {{$client->last_name}}">
                                        <div class="thicklist row_holder "> 
                                            @if($client->job_exist == null)
                                                <a href="{{url('dashboard/work/invoices/add/')}}/{{$client->client_id}}">
                                            @elseif($client->job_exist != null)
                                                <a href="{{url('dashboard/work/invoices/newinvoice/')}}/{{$client->client_id}}">
                                            @endif
                                                <div class="thicklist-row client js-spinOnClick">
                                                    <input type="hidden" name="clientId" id="clientId" value="1" />
                                                    
                                                    <div class="row">
                                                        <div class="columns col-sm-1 text-center">
                                                            <i class="fa fa-2x fa-user green-tag"></i>
                                                        </div>
                                                        <div class="columns col-sm-6">
                                                            <h3 class="headingFive u-marginTopSmallest clientname">{{$client->first_name}} {{$client->last_name}}</h3>
                                                            <small>
                                                                {{$client->counts}} Properties 
                                                                @if($client->phone)
                                                                | {{$client->phone}}
                                                                @endif
                                                            </small>
                                                        </div>

                                                        <div class="columns col-sm-5 text-right">
                                                                @if($client->diffday)   
                                                                <small>Activity about {{$client->diffday}} days ago</small>
                                                                @elseif($client->diffhour)
                                                                <small>Activity about {{$client->diffhour}} hours ago</small>
                                                                @elseif($client->diffmin)
                                                                <small>Activity about {{$client->diffmin}} mins ago</small>
                                                                @endif
                                                        </div>
                                                    </div>
                                                </div>  
                                            </a> 
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="ibox">
                    <div class="ibox-title invoices-toolbar">
                        <div class="row">
                            <div data-count="1" class="count type_filter"></div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <!-- <label class="fa search-label"> -->
                                    <form>
                                        <input type="search" placeholder="Search invoices..." 
                                        class="search-input action-border" id="searchinvoices" />
                                    </form>
                                    <!-- </label> -->
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="card-headerFieldLabel" for="status_filter">
                                            Due
                                         </label>
                                        <label class="fa select-label">
                                            <select class="show-option action-border status-select">
                                                <option value="1" <?php echo $filter_status == 1? "selected" : "" ;?>>All</option>
                                                <option value="2" <?php echo $filter_status == 2? "selected" : "" ;?>>This Month</option>
                                                <option value="3" <?php echo $filter_status == 3? "selected" : "" ;?>>Last Month</option>
                                                <option value="4" <?php echo $filter_status == 4? "selected" : "" ;?>>This Year</option>
                                                <option value="5" <?php echo $filter_status == 5? "selected" : "" ;?>>Custom</option>
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="card-headerFieldLabel" for="order_by">
                                            Sort
                                         </label>
                                        <label class="fa select-label">
                                            <select class="show-option action-border sort-select"onchange="sort_invoices(this)">
                                                <option value="status">Status</option>
                                                <option value="duedate">Due Date</option>
                                                <option value="invoicenum">Invoices number</option>
                                                <option value="firstname">First name</option>
                                                <option value="lastname">Last name</option>
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="card-headerFieldLabel" for="type_filer">
                                            Type
                                         </label>
                                        <label class="fa select-label">
                                            <select class="show-option action-border type-select">
                                                <option value="1" <?php echo $filter_type == 1 ? "selected" : "" ;?>>All</option>
                                                <option value="2" <?php echo $filter_type == 2 ? "selected" : "" ;?>>Draft</option>
                                                <option value="3" <?php echo $filter_type == 3 ? "selected" : "" ;?>>Awaiting Payment-All</option>
                                                <option value="4" <?php echo $filter_type == 4 ? "selected" : "" ;?>>Awaiting Payment-Not yet Due</option>
                                                <option value="5" <?php echo $filter_type == 5 ? "selected" : "" ;?>>Awaiting Payment-Past Due</option>
                                                <option value="6" <?php echo $filter_type == 6 ? "selected" : "" ;?>>Paid Only</option>
                                                <option value="7" <?php echo $filter_type == 7 ? "selected" : "" ;?>>Bad Debt</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="row custom-daterange" style="<?php echo $filter_status != 5  ? "display: none;" : "" ;?>">
                                    <div class="col-md-12">
                                        <div class="input-daterange input-group" id="daterange">
                                            <label class="card-headerFieldLabel" for="">
                                                From
                                            </label>
                                            <div class="input-group date" id="start_date">
                                                <input type="text" class="action-border form-control input-group-addon text-center" name="start_date" value="<?php echo $start_date == 0 ? date('Y-m-01'): $start_date;?>" />
                                            </div>
                                            <span class="input-group-addon daterangemiddle"></span>
                                            <label class="card-headerFieldLabel" for="">
                                                To
                                            </label>
                                            <div class="input-group date" id="end_date">
                                                <input type="text" class="action-border form-control input-group-addon text-center" name="end_date"  value="<?php echo $end_date == 0 ? date('Y-m-t'): $end_date;?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content invoices-content">
                        <div class="thicklist row_holder " style="min-height: 445px;">  
                            <ul id="invoicelist">
                                @if(count($pastdues))
                                <h3 class="thicklist-sectionHeader red-tag">Past Due</h3>
                                @foreach($pastdues as $invoice)
                                    <li filter-value="{{$invoice->first_name}} {{$invoice->last_name}} " duedate="{{$invoice->payment_date}}" invoicenum="{{$invoice->invoice_id}}" firstname="{{$invoice->first_name}}" lastname="{{$invoice->last_name}}" class="awaiting-total-value">
                                        <a class="thicklist-row" href="{{url('dashboard/work/invoices/info')}}/{{$invoice->invoice_id}}">
                                        <div class="row">
                                            <div class="large-expand columns col-sm-3">
                                                <h3 class="invoicename headingFive u-marginBottomSmallest">#{{$invoice->invoice_id}} : {{$invoice->first_name}} {{$invoice->last_name}}</h3>
                                              <div class="inlineLabel inlineLabel--red font-p11"><span>Past Due</span></div>
                                            </div>

                                            <div class="columns col-sm-3">
                                                <small>
                                                    <strong>DUE</strong>
                                                    <br>{{$invoice->payment_date}}
                                                </small>
                                            </div>

                                            <div class="columns col-sm-3">
                                              <div class="row">
                                                    <span class="thicklist-text">{{$invoice->description}}</span>
                                              </div>
                                            </div>

                                            <div class="columns col-sm-3 text-right">
                                                <span class="thicklist-price">
                                                <p class="total-value pull-right">$<span>{{$invoice->total}}</span></p>
                                                </span>
                                            </div>
                                        </div><!--row-->
                                        </a>
                                    </li>
                                @endforeach
                                @endif
                                @if(count($awaitings))
                                <h3 class="thicklist-sectionHeader orange-tag">Awaiting Payment</h3>
                                @foreach($awaitings as $invoice)
                                    <li filter-value="{{$invoice->first_name}} {{$invoice->last_name}} " duedate="{{$invoice->payment_date}}" invoicenum="{{$invoice->invoice_id}}" firstname="{{$invoice->first_name}}" lastname="{{$invoice->last_name}}" class="awaiting-total-value">
                                        <a class="thicklist-row" href="{{url('dashboard/work/invoices/info')}}/{{$invoice->invoice_id}}">
                                        <div class="row">
                                            <div class="large-expand columns col-sm-3">
                                                <h3 class="invoicename headingFive u-marginBottomSmallest">#{{$invoice->invoice_id}} : {{$invoice->first_name}} {{$invoice->last_name}}</h3>
                                              <div class="inlineLabel inlineLabel--orange font-p11"><span>AWAITING PAYMENT</span></div>
                                            </div>

                                            <div class="columns col-sm-3">
                                                <small>
                                                    <strong>DUE</strong>
                                                    <br>{{$invoice->payment_date}}
                                                </small>
                                            </div>

                                            <div class="columns col-sm-3">
                                              <div class="row">
                                                    <span class="thicklist-text">{{$invoice->description}}</span>
                                              </div>
                                            </div>

                                            <div class="columns col-sm-3 text-right">
                                                <span class="thicklist-price">
                                                <p class="total-value pull-right">$<span>{{$invoice->total}}</span></p>
                                                </span>
                                            </div>
                                        </div><!--row-->
                                        </a>
                                    </li>
                                @endforeach
                                @endif
                                @if(count($drafts))
                                <h3 class="thicklist-sectionHeader grey-tag">Draft</h3>
                                @foreach($drafts as $invoice)
                                    <li filter-value="{{$invoice->first_name}} {{$invoice->last_name}} " duedate="{{$invoice->payment_date}}" invoicenum="{{$invoice->invoice_id}}" firstname="{{$invoice->first_name}}" lastname="{{$invoice->last_name}}">
                                        <a class="thicklist-row" href="{{url('dashboard/work/invoices/info')}}/{{$invoice->invoice_id}}">
                                        <div class="row">
                                            <div class="large-expand columns col-sm-3">
                                                <h3 class="invoicename headingFive u-marginBottomSmallest">#{{$invoice->invoice_id}} : {{$invoice->first_name}} {{$invoice->last_name}}</h3>
                                              <div class="inlineLabel inlineLabel--grey font-p11"><span>DRAFT</span></div>
                                            </div>
                                            @if($invoice->pay_due_type == 1)
                                            <div class="columns col-sm-3">
                                                <small>
                                                    <strong>DUE</strong>
                                                    <br>Upon receipt
                                                </small>
                                            </div>
                                            @elseif($invoice->pay_due_type == 2)
                                            <div class="columns col-sm-3">
                                                <small>
                                                    <strong>DUE</strong>
                                                    <br>Net 15 days
                                                </small>
                                            </div>
                                            @elseif($invoice->pay_due_type == 3)
                                            <div class="columns col-sm-3">
                                                <small>
                                                    <strong>DUE</strong>
                                                    <br>Net 30 days
                                                </small>
                                            </div>
                                            @elseif($invoice->pay_due_type == 4)
                                            <div class="columns col-sm-3">
                                                <small>
                                                    <strong>DUE</strong>
                                                    <br>Net 45 days
                                                </small>
                                            </div>
                                            @elseif($invoice->pay_due_type == 5)
                                            <div class="columns col-sm-3">
                                                <small>
                                                    <strong>DUE</strong>
                                                    <br>{{$invoice->payment_date}}
                                                </small>
                                            </div>
                                            @endif
                                            <div class="columns col-sm-3">
                                              <div class="row">
                                                    <span class="thicklist-text">{{$invoice->description}}</span>
                                              </div>
                                            </div>

                                            <div class="columns col-sm-3 text-right">
                                                <span class="thicklist-price">
                                                <p class="total-value pull-right">${{$invoice->total}}</p>
                                                </span>
                                            </div>
                                        </div><!--row-->
                                        </a>
                                    </li>
                                @endforeach
                                @endif
                                @if(count($paids))
                                <h3 class="thicklist-sectionHeader green-tag">Paid</h3>
                                @foreach($paids as $invoice)
                                    <li filter-value="{{$invoice->first_name}} {{$invoice->last_name}} " duedate="{{$invoice->payment_date}}" invoicenum="{{$invoice->invoice_id}}" firstname="{{$invoice->first_name}}" lastname="{{$invoice->last_name}}">
                                        <a class="thicklist-row" href="{{url('dashboard/work/invoices/info')}}/{{$invoice->invoice_id}}">
                                        <div class="row">
                                            <div class="large-expand columns col-sm-3">
                                                <h3 class="invoicename headingFive u-marginBottomSmallest">#{{$invoice->invoice_id}} : {{$invoice->first_name}} {{$invoice->last_name}}</h3>
                                              <div class="inlineLabel inlineLabel--green font-p11"><span>PAID</span></div>
                                            </div>

                                            <div class="columns col-sm-3">
                                                <small>
                                                    <strong>RECEIVED</strong>
                                                    <br>{{$invoice->payment_date}}
                                                </small>
                                            </div>

                                            <div class="columns col-sm-3">
                                              <div class="row">
                                                    <span class="thicklist-text">{{$invoice->description}}</span>
                                              </div>
                                            </div>

                                            <div class="columns col-sm-3 text-right">
                                                <span class="thicklist-price">
                                                <p class="total-value pull-right">${{$invoice->total}}</p>
                                                </span>
                                            </div>
                                        </div><!--row-->
                                        </a>
                                    </li>
                                @endforeach
                                @endif
                                @if(count($bads))
                                <h3 class="thicklist-sectionHeader red-tag">Archived</h3>
                                @foreach($bads as $invoice)
                                    <li filter-value="{{$invoice->first_name}} {{$invoice->last_name}} " duedate="{{$invoice->payment_date}}" invoicenum="{{$invoice->invoice_id}}" firstname="{{$invoice->first_name}}" lastname="{{$invoice->last_name}}">
                                        <a class="thicklist-row" href="{{url('dashboard/work/invoices/info')}}/{{$invoice->invoice_id}}">
                                        <div class="row">
                                            <div class="large-expand columns col-sm-3">
                                                <h3 class="invoicename headingFive u-marginBottomSmallest">#{{$invoice->invoice_id}} : {{$invoice->first_name}} {{$invoice->last_name}}</h3>
                                              <div class="inlineLabel inlineLabel--red font-p11"><span>BAD DEBT</span></div>
                                            </div>

                                            <div class="columns col-sm-3">
                                                <small>
                                                    <strong>DUE</strong>
                                                    <br>{{$invoice->payment_date}}
                                                </small>
                                            </div>

                                            <div class="columns col-sm-3">
                                              <div class="row">
                                                    <span class="thicklist-text">{{$invoice->description}}</span>
                                              </div>
                                            </div>

                                            <div class="columns col-sm-3 text-right">
                                                <span class="thicklist-price">
                                                <p class="total-value pull-right">${{$invoice->total}}</p>
                                                </span>
                                            </div>
                                        </div><!--row-->
                                        </a>
                                    </li>
                                @endforeach
                                @endif
                            </ul>
                        </div>  
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="ibox">
                    <div class="ibox-title jbox-title headingFour">
                        <span>Invoices overview</span>
                    </div>
                    <div class="ibox-content jbox-content">
                        @if($counts[0]->pastnum)
                        <div class="row">
                            <div class=" col-md-3">
                                <a href="{{url('dashboard/work/invoices')}}?status=1&type=5" class="btn-lg upcoming-num inlineLabel--red"><strong>{{$counts[0]->pastnum}}</strong></a>
                            </div>
                            <div class=" col-md-9">
                                <a href=""><h4 class="headingFive">Past due</h4></a>
                                <p class="awaiting-value">${{$pastduetotal}}</p>
                            </div>                          
                        </div>
                        @endif
                        @if($counts[0]->awaitingnum)
                        <div class="row">
                            <div class=" col-md-3">
                                <a href="{{url('dashboard/work/invoices')}}?status=1&type=4" class="btn-lg upcoming-num inlineLabel--orange"><strong>{{$counts[0]->awaitingnum}}</strong></a>
                            </div>
                            <div class=" col-md-9">
                                <a href=""><h4 class="headingFive">Sent but not due</h4></a>
                                <p class="awaiting-value">${{$awaitingtotal}}</p>
                            </div>                          
                        </div>
                        @endif
                        @if($counts[0]->draftnum)
                        <div class="row">
                            <div class=" col-md-3">
                                <a href="{{url('dashboard/work/invoices')}}?status=1&type=2" class="btn-lg upcoming-num inlineLabel--grey"><strong>{{$counts[0]->draftnum}}</strong></a>
                            </div>
                            <div class=" col-md-9">
                                <a href=""><h4 class="headingFive">Draft</h4></a>
                                <p>Not yet sent.</p>
                            </div>                          
                        </div>
                        @endif
                    </div>
                </div>
                <!-- <div class="ibox">
                    <div class="ibox-title jbox-title headingFour">
                        <span>Invoices for offline use</span>
                    </div>
                    <div class="ibox-content jbox-content">
                        <a target="_blank" class="printinvoice-btn m-b" href="#">Batch create invoices</a>
                        <a target="_blank" class="downloadinvoice-btn" href="#">Batch deliver invoices</a>
                    </div>
                </div>
                <div class="ibox">
                    <div class="ibox-title jbox-title headingFour">
                        <span>Help and documentation</span>
                    </div>
                    <div class="ibox-content jbox-content">
                        <a target="_blank" class="learnmore-btn" href="#">Learn More About invoices</a>
                    </div>
                </div> -->
            </div>
        </div>
<script>
    var inputId     = 'searchinvoices';
    var itemsData   = 'filter-value';
    var displaySet = false;
    var displayArr = [];

    function getDisplayType(element) {
        var elementStyle = element.currentStyle || window.getComputedStyle(element, "");
        return elementStyle.display;
    }

    document.getElementById(inputId).onkeyup = function() {
        $('#invoicelist > h3').hide();
        var searchVal = this.value.toLowerCase();
        var filterItems = document.querySelectorAll('[' + itemsData + ']');
        for(var i = 0; i < filterItems.length; i++) {
            if (!displaySet) {
                displayArr.push(getDisplayType(filterItems[i]));
            }

            filterItems[i].style.display = 'none';

            if(filterItems[i].getAttribute('filter-value').toLowerCase().indexOf(searchVal) >= 0) {
                filterItems[i].style.display = displayArr[i];       
            }
        }
        
        displaySet = true;
    }

    var inputclientId     = 'searchclients';
    var itemsclientData   = 'filter-client';
    var displayclient = false;
    var displayclientArr = [];

    function getDisplayclientType(element) {
        var elementStyle = element.currentStyle || window.getComputedStyle(element, "");
        return elementStyle.display;
    }

    document.getElementById(inputclientId).onkeyup = function() {
        var searchvalclient = this.value.toLowerCase();
        var filterclientItems = document.querySelectorAll('[' + itemsclientData + ']');
        for(var i = 0; i < filterclientItems.length; i++) {
            if (!displayclient) {
                displayclientArr.push(getDisplayclientType(filterclientItems[i]));
            }

            filterclientItems[i].style.display = 'none';

            if(filterclientItems[i].getAttribute('filter-client').toLowerCase().indexOf(searchvalclient) >= 0) {
                filterclientItems[i].style.display = displayclientArr[i];       
            }
        }
        
        displayclient = true;
    }
    
    function sort_invoices(ele) {
        $('#invoicelist > h3').hide();
        var container = document.getElementById("invoicelist");
        var selectBox = ele.value;
        var elements = container.childNodes;
        var sortMe = [];
        
        var sortItems = document.querySelectorAll('['+ selectBox +']'); 
        for(var i=0; i<sortItems.length; i++){
                sortMe.push([sortItems[i].getAttribute(selectBox).toUpperCase(), sortItems[i] ]);
        }
        
        sortMe.sort();
        for (var i=0; i<sortMe.length; i++) {
            container.appendChild(sortMe[i][1]);
        }
       
    }
    $(document).ready(function(){
        // var totalall = 0;
        // $('.awaiting-total-value').each(function(){
        //     var total = $(this).find('.total-value span').html();
        //     // console.log(total)
        //     totalall += Number(total);
        // });
        // $('.awaiting-value').html("$"+(totalall.toFixed(2)));
        $('#daterange').datepicker({
            format: 'yyyy-mm-dd',
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        
        $('.status-select').on('change',function(){
            // $('#quotelist > h3').show();
            var start_date = $('#start_date input').val();
            var end_date = $('#end_date input').val();
            var status = $(this).val();
            var type = $('.type-select').val();
            if (status == 5) {
                $('.custom-daterange').css('display','block');
                location.href = "{{url('dashboard/work/invoices')}}?status="+status+"&type="+type+"&start_date="+start_date+"&end_date="+end_date;
            }else{
                location.href = "{{url('dashboard/work/invoices')}}?status="+status+"&type="+type;
            }
        });
        $('.type-select').on('change',function(){
            // $('#quotelist > h3').show();
            var type = $(this).val();
            var start_date = $('#start_date input').val();
            var end_date = $('#end_date input').val();
            var status = $('.status-select').val();
            if (status == 5) {
                $('.custom-daterange').css('display','block');
                location.href = "{{url('dashboard/work/invoices')}}?status="+status+"&type="+type+"&start_date="+start_date+"&end_date="+end_date;
            }else{
                location.href = "{{url('dashboard/work/invoices')}}?status="+status+"&type="+type;
            }
        });
    });
</script>
<script type="text/javascript">
    $('.type_filter').html($('.invoices-content .thicklist #invoicelist > li').length+' invoices');
</script>
@stop