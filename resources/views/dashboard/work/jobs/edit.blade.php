@extends('layout.menu')
@section('content')
<!-- <link rel="stylesheet" type="text/css" href="{{url('public/css/getjobber.css')}}"> -->
<link rel="stylesheet" type="text/css" href="{{url('public/css/plugins/chosen/chosen.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/plugins/combobox/bootstrap-combobox.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/plugins/kendo/kendo.common-material.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/plugins/kendo/kendo.rtl.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/plugins/kendo/kendo.material.min.css')}}">

<link rel="stylesheet" type="text/css" href="{{url('public/css/custom.css')}}">
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBU7pWnRr82liR_QNTkZbjtXf14VfK_vRg"></script>
        
<div class="col-md-12">
<form class="work_order" action="{{ url('dashboard/work/jobs/update')}}" id="new_work_order" method="post">
    {{ csrf_field() }}
    <div class="ibox u-border">
        <div class="ibox-title header-content heading-borderTop">
            <div class="row">
                <div class="col-md-12">
                    @if(isset($data['success'])) 
                      <br>
                      <div class="alert alert-success alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        {{$data['success']}}
                      </div>
                    @elseif(isset($data['error']))
                      <br>
                      <div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        {{$data['error']}}
                      </div>
                    @endif
                </div>      
                <div class="col-md-7">
                    <div class="job-client">
                        <h1 class="headingOne u-marginTopBiggest">Job for 
                            <span id="client_name">{{$data['job'][0]->first_name}} {{$data['job'][0]->last_name}}</span>
                        </h1>
                        <div class="">
                            <h3 class="headingFive">Job description</h5>
                            <!-- <input type="text" name="jobDescription" placeholder="Description" value="{{$data['job'][0]->job_description}}" 
                            class="description action-border u-marginTopSmall" /> -->
                            <label class="fa select-label label-lg">
                                <select class="input-lg form-control action-border description jobDescription" name="jobDescription">
                                    <option>Description</option>
                                @foreach($data['descriptions'] as $description)
                                    @if($data['job'][0]->description == $description)
                                        <option value="{{$description}}" selected="">{{$description}}</option>
                                    @else
                                        <option value="{{$description}}">{{$description}}</option>
                                    @endif
                                @endforeach
                                </select>
                            </label>
                        </div>
                        <div class="row">
                            <div class="col-md-6 propertyField">
                                <h3 class="headingFive u-marginTopBig">Property Address</h5>
                                <p class="paragraph u-marginTopSmall" id="propertyStreet1">{{$data['job'][0]->street1}}</p>
                                <p class="paragraph" id="propertyStreet2">{{$data['job'][0]->street2}}</p>
                                <p class="paragraph u-marginBottom" id="propertyMain">{{$data['job'][0]->city}} {{$data['job'][0]->state}}, {{$data['job'][0]->zip_code}}</p>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <input type="hidden" name="job_Id" id="job_Id" value="{{$data['job'][0]->job_id}}" required/>
                        <input type="hidden" name="client_Id" id="client_Id" required value="{{$data['job'][0]->client_id}}" />
                        <input type="hidden" name="property_Id" id="property_Id" required value="{{$data['job'][0]->property_id}}" />
                        <input type="hidden" name="job_type" id="job_type" required value="{{$data['job'][0]->job_type}}" />
                        <input type="hidden" name="property_address" id="property_address" required value="{{$data['job'][0]->street1}},{{$data['job'][0]->street2}},{{$data['job'][0]->city}},{{$data['job'][0]->state}},{{$data['job'][0]->zip_code}},{{$data['job'][0]->country}}" />
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="job-detail">
                        <h3 class="headingFive u-marginBottomBig">Job details</h3>
                        <div class="row u-marginBottomSmall">
                            <div class="col-md-5">
                                <span>Job number</span>
                            </div>
                            <div class="col-md-7">
                                <div class="staticNumber">
                                    <span class="work_order_number list-text">#{{$data['job'][0]->job_id}}</span>
                                    <!-- <span class="textAction">Change</span> -->
                                </div>
                                <!-- <div class="numberInputWrapper">
                                    <input type="number" class="numberInput action-border" value="3"/>
                                    <button type="button" class="btn-job cancelInput">Cancel</button>
                                </div>
                                <div class="fieldHelper">
                                    Future jobs will be assigned the next highest job number
                                </div> -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <span>Job type</span>
                            </div>
                            <div class="col-md-7">
                                <div class="staticNumber">
                                    <span class="work_order_number list-text">
                                    @if($data['job'][0]->job_type == '1')
                                        One-off Job
                                    @else
                                        Recurring Job
                                    @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row customField">
                            <div class="col-md-2 iconField">
                                <span class="blueIcon">@</span>
                            </div>
                            <div class="col-sm-10">
                                <h3 class="headingTwo">
                                    Need to track more details on jobs?
                                </h3>
                                <a href="" class="btn-add">Add Custom Field</a>
                            </div>
                        </div> -->
                    </div>
                </div>
                
            </div>
        </div>
        <div class="ibox-content no-border">
            <div class="row">

                <div class="col-md-12">
                    <div class="panel blank-panel jobTypePanel">

                       <!--  <div class="panel-heading">
                            <div class="panel-title m-b-md"><h4></h4></div>
                            <div class="panel-options">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#tab-1" class="selectTab" onclick="selectJobtype('0')">
                                        <h3 class="headingTwo">One-Off Job</h3>
                                        <p class="paragraph" style="text-transform: none;">
                                            A one time job with one or more visits
                                        </p>
                                    </a></li>
                                    <li class="">
                                        <a data-toggle="tab" href="#tab-2" class="selectTab" onclick="selectJobtype('1')">
                                        <h3 class="headingTwo">Recurring Job</h3>
                                        <p class="paragraph" style="text-transform: none;">
                                            A contract job with repeating visits
                                        </p>
                                    </a></li>
                                </ul>
                                <input type="hidden" name="jobType" id="jobType" value="0" required/>
                            </div>
                        </div> -->

                        <div class="panel-body">
                            <div class="tab-content">
                            @if($data['job'][0]->job_type == '1')
                                <div id="tab-1" class="tab-pane active">
                                    <div class="row">
                                        <div class="col-md-12"  id="schedule">
                                            <div class="ibox">
                                                <div class="ibox-title">
                                                    <h3 class="headingTwo">Schedule</h3>
                                                </div>
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <h3 class="headingFive daterange-label">Startdate</h3>
                                                                <h3 class="headingFive daterange-label">Enddate</h3>
                                                            </div>
                                                            <div class="input-daterange input-group u-grid10" id="dateRange">
                                                                <input type="text" class="action-border input-lg form-control" name="startDate" value="{{$data['job'][0]->date_started}}" required/>
                                                                <span class="input-group-addon">to</span>
                                                                <input type="text" class="action-border input-lg form-control" name="endDate" value="{{$data['job'][0]->date_ended}}" required/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h3 class="headingFive">Times</h3>
                                                            <div class="input-group date u-grid5 u-floatLeft" id="time_start1">
                                                                <input type="text" class="action-border input-lg form-control" name="startTime1" value="{{$data['job'][0]->time_started}}" placeholder="Start time"/>
                                                                <!-- data-mask="99:99" -->
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                </span>
                                                            </div>
                                                            <div class="input-group date u-grid5 u-floatLeft" id="time_end1">
                                                                <input type="text" class="action-border input-lg form-control" name="endTime1" value="{{$data['job'][0]->time_ended}}" placeholder="End time"/>
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6" id="Frequence1" style="display: block;">
                                                            <h3 class="headingFive u-marginTop">Visit frequency</h3>
                                                            <div class="input-group">
                                                                <label class="fa select-label label-lg">
                                                                    <select class="input-lg form-control action-border" name="visitFrequence1">
                                                                        <option value="0">As need - we won't prompt you</option>
                                                                        <option value="1" {{$data['job'][0]->visit_frequence == '1'? 'selected' : ''}}>Daily</option>
                                                                        <option value="2" {{$data['job'][0]->visit_frequence == '2'? 'selected' : ''}}>Weekly</option>
                                                                        <option value="3" {{$data['job'][0]->visit_frequence == '3'? 'selected' : ''}}>Monthly</option>
                                                                        <!-- <option disabled="disabled" value="or">or</option>
                                                                        <option value="4">Custom schedule...</option> -->
                                                                    </select>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12"  id="invoicing">
                                            <div class="ibox">
                                                <div class="ibox-title">
                                                    <h3 class="headingTwo">Invoicing</h3>
                                                    <!-- <a href="#" class="assign-btn">Assign</a> -->
                                                </div>
                                                <div class="ibox-content">
                                                    <label class="check-element">
                                                        <input type="checkbox" class="check-button" 
                                                        name="checkInvoice" value="1" checked>
                                                        <i class="checkbox fa"></i>
                                                        <span>
                                                            Remind me to invoice when I close the job
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div id="tab-2" class="tab-pane active">
                                    <div class="row">
                                        <div class="col-md-12"  id="schedule">
                                            <div class="ibox">
                                                <div class="ibox-title">
                                                    <h3 class="headingTwo">Schedule</h3>
                                                </div>
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h3 class="headingFive">Start date</h3>
                                                                    <div class="input-group date" id="dateStart">
                                                                        <input type="text" class="action-border input-lg form-control input-group-addon text-center u-grid10" name="startDate1" value="{{$data['job'][0]->date_started}}" onchange="calculateDates();"/>
                                                                        <input type="hidden" name="endDate1" value="{{$data['job'][0]->date_ended}}" id="endDate1">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h3 class="headingFive">Duration</h3>
                                                                    <div class="input-group" id="duration">
                                                                        <input type="text" class="action-border input-lg form-control text-center" name="duration" value="{{$data['job'][0]->duration}}" onchange="calculateDates();">
                                                                        <label class="fa select-label label-lg">
                                                                            <select class="input-lg form-control action-border" name="duration_unit" onchange="calculateDates();">
                                                                                <option value="1"{{$data['job'][0]->duration_unit == '1'? 'selected' : ''}}>day(s)</option>
                                                                                <option value="2" {{$data['job'][0]->duration_unit == '2'? 'selected' : ''}}>week(s)</option>
                                                                                <option value="3" {{$data['job'][0]->duration_unit == '3'? 'selected' : ''}}>month(s)</option>
                                                                                <option value="4" {{$data['job'][0]->duration_unit == '4'? 'selected' : ''}}>year(s)</option>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <h3 class="headingFive">Visit frequency</h3>
                                                                    <div class="input-group">
                                                                        <label class="fa select-label label-lg">
                                                                            <select class="input-lg form-control action-border" name="visitFrequence2" onchange="calculateDates();">
                                                                                <option value="0">As need - we won't prompt you</option>
                                                                                <option value="1" {{$data['job'][0]->visit_frequence == '1'? 'selected' : ''}}>Weekly on {{date('l', strtotime($data['job'][0]->date_started))}}</option>
                                                                                <option value="2"{{$data['job'][0]->visit_frequence == '2'? 'selected' : ''}}>Every 2 weeks on {{date('l', strtotime($data['job'][0]->date_started))}}</option>
                                                                                <option value="3"{{$data['job'][0]->visit_frequence == '3'? 'selected' : ''}}>Monthly on the {{date('jS', strtotime($data['job'][0]->date_started))}} day of the month</option>
                                                                                <!-- <option disabled="disabled" value="or">or</option>
                                                                                <option value="custom">Custom schedule...</option> -->
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <!-- <div class="col-md-12">
                                                                    <h3 class="headingFive">Visit frequency</h3>
                                                                    <div class="input-group" id="visitFrequence">
                                                                        <label class="fa select-label label-lg">
                                                                            <select class="input-lg form-control action-border">
                                                                                <option>As need - we won't prompt you</option>
                                                                                <option>Weekly on Wednesdays</option>
                                                                                <option>Every 2 weeks on Wednesdays</option>
                                                                                <option>Monthly on the 24th day of the month</option>
                                                                                <option disabled="disabled" value="or">or</option>
                                                                                <option value="custom">Custom schedule...</option>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </div> -->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h3 class="headingFive">Times</h3>
                                                            <div class="input-group date u-grid5 u-floatLeft" id="time_start1">
                                                                <input type="text" class="action-border input-lg form-control" name="startTime1" value="{{$data['job'][0]->time_started}}" placeholder="Start time" />
                                                                <!-- data-mask="99:99" -->
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                </span>
                                                            </div>
                                                            <div class="input-group date u-grid5 u-floatLeft" id="time_end1">
                                                                <input type="text" class="action-border input-lg form-control" name="endTime1" value="{{$data['job'][0]->time_ended}}" placeholder="End time" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12"  id="invoicing">
                                            <div class="ibox">
                                                <div class="ibox-title">
                                                    <h3 class="headingTwo">Invoicing</h3>
                                                    <!-- <a href="#" class="assign-btn">Assign</a> -->
                                                </div>
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-md-6 u-medium-borderRight" id="howInvoice">
                                                            <h4 class="headingTwo">How do you want to invoice?</h4>
                                                            <!-- <form> -->
                                                                <label class="radio-element">
                                                                    <input type="radio" class="check-button" name="invoice" value="0" <?php echo $data['job'][0]->invoicing == '0' ? 'checked' : ''; ?> >
                                                                    <i class="checkbox fa"></i>
                                                                    <span>
                                                                       Visit based billing
                                                                    </span>
                                                                </label>
                                                                <p class="paragraph u-textSmaller" style="padding-left: 25px;">Invoices include all the billable work on completed visits (e.g. $40 a Visit)</p>
                                                                <label class="radio-element">
                                                                    <input type="radio" class="check-button" name="invoice" value="1" 
                                                                    <?php echo($data['job'][0]->invoicing == '1' ? 'checked' : ''); ?> >
                                                                    <i class="checkbox fa"></i>
                                                                    <span>
                                                                       Fixed price billing
                                                                    </span>
                                                                </label>
                                                                <p class="paragraph u-textSmaller" style="padding-left: 25px;">Each invoice is for a set amount (e.g. $300 a month)</p>

                                                            <!-- </form> -->
                                                        </div>
                                                        <div class="col-md-6" id="whenInvoice">
                                                            <h4 class="headingTwo">When do you want to invoice?</h4>
                                                            <label class="fa select-label label-lg">
                                                                <select class="input-lg form-control action-border" name="billingFrequence" onchange="">
                                                                    <option value="0" {{$data['job'][0]->billing_frequency == '0' ? 'selected' : ''}}>As needed - we won't prompt you</option>
                                                                    <option value="1" class="per_visit" {{$data['job'][0]->billing_frequency == '1' ? 'selected' : ''}}>After each visit</option>
                                                                    <option value="2" {{$data['job'][0]->billing_frequency == '2' ? 'selected' : ''}}>Once when job is completed</option>
                                                                    <option value="3" {{$data['job'][0]->billing_frequency == '3' ? 'selected' : ''}}>Monthly on the last day of the month</option>
                                                                    <!-- <option disabled="disabled" value="or">or</option>
                                                                    <option value="custom">Custom schedule...</option> -->
                                                                </select>
                                                            </label>
                                                            <div class="invoiceDetails" style="display: none;">
                                                                <p class="paragraph u-colorBlue"><span class="u-textBold">7</span> invoices total</p><p class="paragraph u-colorBlue">First invoice on <span class="u-textBold">31/01/2018</span><br>Last invoice on <span class="u-textBold">31/07/2018</span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            </div>
                            <div class="row">
                                <div class="col-md-12" id="lineItem">
                                    <div class="ibox">
                                        <div class="ibox-title">
                                            <h3 class="headingTwo">Line items</h3>
                                            <!-- <a href="#" class="assign-btn">Assign</a> -->
                                        </div>
                                        <div class="ibox-content table-content">
                                            <table class="table lineitemTable text-right">
                                                <thead>
                                                @if(!$data['job'][0]->quote_id)
                                                    <tr>
                                                        <th></th>
                                                        <th width="50%" align="left">
                                                            <h4 class="headingTwo">SERVICE / PRODUCT</h4>
                                                        </th>
                                                        <th width="15%" class="text-right">
                                                            <h4 class="headingTwo">QTY.</h4>
                                                        </th>
                                                        <th width="15%" class="text-right">
                                                            <h4 class="headingTwo">UNIT COST ($)</h4>
                                                        </th>
                                                        <th width="15%" class="text-right">
                                                            <h4 class="headingTwo">TOTAL ($)</h4>
                                                        </th>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <th></th>
                                                        <th width="50%" align="left">
                                                            <h4 class="headingTwo">SERVICE / PRODUCT</h4>
                                                        </th>
                                                        <th width="10%" class="text-right">
                                                            <h4 class="headingTwo">QUOTED</h4>
                                                        </th>
                                                        <th width="10%" class="text-right">
                                                            <h4 class="headingTwo">QTY.</h4>
                                                        </th>
                                                        <th width="15%" class="text-right">
                                                            <h4 class="headingTwo">UNIT COST ($)</h4>
                                                        </th>
                                                        <th width="10%" class="text-right">
                                                            <h4 class="headingTwo">TOTAL ($)</h4>
                                                        </th>
                                                    </tr>
                                                @endif
                                                </thead>
                                                <tbody id="lineItemBox">
                                                <?php $i = 0; $total = 0; $quotedTotal = 0;?>
                                                @if(!$data['job'][0]->quote_id)
                                                    @foreach ($data['job_services'] as $service)
                                                        <tr class="Editable">
                                                            <td>
                                                                <i class="jobber-icon jobber-sort jobber-2x dragable-icon"></i>
                                                                <input type="hidden" name="jobs[service][{{$i}}][job_service_id]" class="job-service-id" value="{{$service->job_service_id}}" required />
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="jobs[service][{{$i}}][service_id]" class="service-id" value="{{$service->service_id}}" required />
                                                                <input type="text" name="jobs[service][{{$i}}][name]" id="serviceRow{{$i}}" value="{{$service->service_name}}" style="width:100%" 
                                                                onchange="selectService(this)" />
                                                                <textarea class="action-border input-lg form-control" name="jobs[service][{{$i}}][description]" rows="2" >{{$service->service_description}}</textarea required>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="action-border input-lg form-control text-right service-quantity" name="jobs[service][{{$i}}][quantity]" value="{{$service->quantity}}" onkeyup="countCost(this)" required/>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="action-border input-lg form-control text-right service-unit" name="jobs[service][{{$i}}][unit]" value="{{$service->job_cost}}" onkeyup="countCost(this)" required/>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="action-border input-lg form-control text-right service-total" name="jobs[service][{{$i}}][total]" value="{{$service->quantity*$service->job_cost}}" required/>
                                                                <div class="serviceAction">
                                                                    <button type="button" class="btn btn-outline btn-sm btn-danger deleteLineitem" onclick="deleteLineitem(this)" data-id="{{$service->job_service_id}}">Delete</button>
                                                                    <!-- <button type="button" class="btn btn-outline btn-sm btn-job btn-submit" 
                                                                    onclick="saveLineitem(this)">Save</button> -->
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php $i++; $total += $service->quantity*$service->job_cost?>
                                                    @endforeach
                                                @else
                                                    @foreach ($data['job_services'] as $service)
                                                        <tr class="Editable">
                                                            <td>
                                                                <i class="jobber-icon jobber-sort jobber-2x dragable-icon"></i>
                                                                <input type="hidden" name="jobs[service][{{$i}}][job_service_id]" class="job-service-id" value="{{$service->job_service_id}}" required />
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="jobs[service][{{$i}}][service_id]" class="service-id" value="{{$service->service_id}}" required />
                                                                <input type="text" name="jobs[service][{{$i}}][name]" id="serviceRow{{$i}}" value="{{$service->service_name}}" style="width:100%" 
                                                                onchange="selectService(this)" />
                                                                <textarea class="action-border input-lg form-control" name="jobs[service][{{$i}}][description]" rows="2" >{{$service->service_description}}</textarea required>
                                                            </td>
                                                            <td>
                                                            @if($service->quoted == 0)
                                                                <p class="paragraph">_</p>
                                                            @else
                                                                <p class="paragraph">${{$service->quoted}}</p>
                                                            @endif
                                                            </td>
                                                            <td>
                                                                <input type="text" class="action-border input-lg form-control text-right service-quantity" name="jobs[service][{{$i}}][quantity]" value="{{$service->quantity}}" onkeyup="countCost(this)" required/>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="action-border input-lg form-control text-right service-unit" name="jobs[service][{{$i}}][unit]" value="{{$service->job_cost}}" onkeyup="countCost(this)" required/>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="action-border input-lg form-control text-right service-total" name="jobs[service][{{$i}}][total]" value="{{$service->quantity*$service->job_cost}}" required/>
                                                                <div class="serviceAction">
                                                                    <button type="button" class="btn btn-outline btn-sm btn-danger deleteLineitem" onclick="deleteLineitem(this)" data-id="{{$service->job_service_id}}">Delete</button>
                                                                    <!-- <button type="button" class="btn btn-outline btn-sm btn-job btn-submit" 
                                                                    onclick="saveLineitem(this)">Save</button> -->
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php $i++; $total += $service->quantity*$service->job_cost; $quotedTotal += $service->quoted?>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                            <a href="#" class="btn-job addItem-btn">Add Line item</a>
                                            @if($data['job'][0]->quote_id)
                                                <div class="row no-margin" style="padding-bottom: 10px;">
                                                    <div class="col-xs-3 text-right u-floatRight u-borderBottom">
                                                        <p class="paragraph" style="margin-right: 20px;">$ {{$quotedTotal}}</p>
                                                    </div>
                                                    <div class="col-xs-3 text-left u-floatRight u-borderBottom">
                                                        <p class="paragraph">Quoted subtotal</p>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row  no-margin">
                                                <div class="col-xs-3 text-right u-floatRight">
                                                    <h4 class="headingTwo" style="margin-right: 20px;" id="subtotal_val">$ {{$total}}</h4>
                                                </div>
                                                <div class="col-xs-3 text-left u-floatRight">
                                                    <h4 class="headingTwo">SubTotal</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12"  id="teamMember">
                                    <div class="ibox">
                                        <div class="ibox-title">
                                            <h3 class="headingTwo">Team</h3>
                                        @if(Session::get('permission') != '5' && Session::get('permission') != '6')
                                            <button type="button" class="assign-btn assign-btn-sm right-btn u-block text-center" data-toggle="modal" data-target="#newUser" id="add_user">+ Add user</button>
                                        @endif
                                            <!-- <a href="" class="assign-btn assign-btn-sm right-btn u-block text-center" data-toggle="modal" data-target="#newUser">+ Add user</a> -->
                                        </div>
                                        <div class="ibox-content">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <input type="hidden" name="job_team_id" id="job_team_id" value="{{$data['job'][0]->job_team_id}}" />
                                                    <h3 class="headingTwo u-marginTopSmall">Selected Team Member</h3>
                                                    <div class="row no-margin" id="selectedTeam">
                                                    <?php $i=0;?>
                                                    @foreach($data['teams'] as $one)
                                                        @if(isset($data['job'][0]->member_id) && in_array($one['team_member_id'], explode(',', $data['job'][0]->member_id)))
                                                        <div class="col-md-12">
                                                            <div class="alert alert-warning alert-dismissable alert-team">
                                                                <input type="hidden" class="teamMemberIds{{$i}}" name="teamMemberIds[{{$i}}]" value="{{$one['team_member_id']}}">
                                                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                                                <h4 class="headingTwo no-padding no-margin">{{$one['fullname']}}</h4>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    <?php $i++;?>
                                                    @endforeach
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="check-element">
                                                            <input type="checkbox" class="check-button" name="notify" value="1">
                                                            <i class="checkbox fa"></i>
                                                            <span class="paragraph">
                                                               Notify team by email
                                                            </span>
                                                        </label>
                                                        
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-9" id="job-map" style="border: 1px solid black"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-md-12" id="noteAttach">
                                    <div class="ibox">
                                        <div class="ibox-title">
                                            <h3 class="headingTwo">Internal notes & attachments</h3>
                                        </div>
                                        <div class="ibox-content">
                                            <textarea class="action-border input-lg form-control" name="internalNotes" value="" rows="5" placeholder="Note details">{{$data['job'][0]->internal_notes}}</textarea>
                                            <div id="files_list" class=" u-marginTop"></div>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                                            </div>
                                            <div class="text-right u-marginTop u-marginBottom">
                                                <label class="check-element btn btn-sm button--greyBlue button--ghost u-textBold ">
                                                    <input type="file" id="fileupload" name="photos[]" data-url="{{url('/dashboard/work/jobs/attache')}}" multiple class="" />
                                                    Add Attachment
                                                </label>
                                            </div>
                                            <input type="hidden" name="file_ids" id="file_ids" value="" />
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12 text-right">
                @if(Session::get('permission') != '5')
                    <a class="btn btn-lg btn-danger btn-outline button--ghost u-floatLeft" tabindex="-1" href="{{url('/dashboard/work/jobs/delete')}}/{{$data['job'][0]->job_id}}" onclick="confirm_delete()">Delete</a>
                @endif
                    <a class="cancelAdd-btn button--greyBlue button--ghost" tabindex="-1" href="{{url('/dashboard/work/jobs')}}">Cancel</a>
                    <button name="button" type="submit" class="btn-job form-submit">Update Job</button>
                </div>
            </div>
        </div>
    </div>
</form>
   
    <!-- Modal5 -->
    <div class="modal inmodal" id="newUser" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title headingTwo text-left">Add New User</h4>
                </div>
                <div class="modal-body">
                    <form action="{{url('/dashboard/work/jobs/add-team')}}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="job_id" value="{{$data['job'][0]->job_id}}" />
                    <div class="input-group u-grid10 u-marginBottomSmall" id="">
                        <input type="text" class="action-border input-lg form-control " name="member_name" value="" required placeholder="Full name"/>
                    </div>
                    <div class="input-group u-grid10 u-marginBottomSmall" id="">
                        <input type="email" class="action-border input-lg form-control " name="member_email" value="" required placeholder="Email address"/>
                        <p class="paragraph u-textItalic">An email is required to log in to Jobber</p>
                    </div>
                    <div class="input-group u-grid10 u-marginBottomSmall" id="">
                        <input type="text" class="action-border input-lg form-control " name="mobile_phone" value="" required placeholder="Mobile phone number"/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-job">Save User</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
    var infoWindow;
    var property_id;
    var init_address;
    var team_locations = new Array();
    var markers = new Array();
    var contentStrings = new Array();
    var memberStrings = new Array();
    $(document).ready(function(){
        var i = {{count($data['job_services'])}} - 1;
        var unit = {{$data['job'][0]->duration_unit}} - 1;
        property_id = $('#property_Id').val();
        init_address = $('#property_address').val();
        google.maps.event.addDomListener(window, 'load', getLatitudeLongitude(initialize,init_address));
        // console.log(unit);
        //Init Datepicker
        $('#dateRange').datepicker({
            format: 'yyyy-mm-dd',
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
                                                
        $('#dateStart').datepicker({
            format: 'yyyy-mm-dd',
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        $('#time_start1').datetimepicker({
            format: 'HH:mm',   
        });
        $('#time_end1').datetimepicker({
            format: 'HH:mm',   
        });

        var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"95%"}
            }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
        //Init Combobox
        var combobox = $('.combo-select').combobox().data('combobox');

        for (var num = 0; num <= i; num++) {
            var id = 'serviceRow' + num;
            createCombo(id);
        }


        $('[name=duration_unit]').children('option').eq(unit).attr('selected', true);

        $('#fileupload').change(function(){
            if ($(this).val == '') {
                return false;
            }
            $('.myprogress').css('width', '0%');
            $('.msg').text('');
            var formData = new FormData();
            formData.append('_token', $('input[name=_token]').val());
            // formData.append('myfile', $('#fileupload')[0].files[0]);
            for (var i = 0, len = $('#fileupload').get(0).files.length; i < len; i++) {
                formData.append("photos["+i+"]", $('#fileupload').get(0).files[i]);
            }
            $('#btn').attr('disabled', 'disabled');
             $('.msg').text('Uploading in progress...');
            $.ajax({
                url: "{{url('/dashboard/work/jobs/attache')}}",
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                // this part is progress bar
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            $('.myprogress').text(percentComplete + '%');
                            $('.myprogress').css('width', percentComplete + '%');
                            if (evt.loaded == evt.total) {
                                setTimeout(function(){$('.myprogress').css('width', '0%');}, 2000);
                            }
                        }
                    }, false);
                    return xhr;
                },
                success: function (data) {
                         console.log(data);
                    $.each(data.files, function (index, file) {
                        $('<p/>').html(file.name + ' (' + file.size + ' KB)').addClass('fa').appendTo($('#files_list'));
                        if ($('#file_ids').val() != '') {
                            $('#file_ids').val($('#file_ids').val() + ',');
                        }
                        $('#file_ids').val($('#file_ids').val() + file.fileID);
                    });
                    $('#loading').text('');
                }
            });
        });
        
        $('.addItem-btn').click(function(){
            i++;
            var addHtml = $('#editlineItemRow').tmpl({
                i: i,
            }).html();
            $('#lineItemBox').append(addHtml);
            createCombo('serviceRow' + i);
            return false;
        });

        $('.textAction').click(function(){
            $(this).parent().hide();
            $('.numberInputWrapper').show();
             return false;
        });
        $('.cancelInput').click(function(){
            var number = $(this).parent().children('input[type=number]').val();
            if (number < 10) {
                $('.fieldHelper').show();
            }else{
                $(this).parent().hide();
                $('.fieldHelper').hide();
                $('.staticNumber').show();
                $('.staticNumber').children('.work_order_number').text('#' + number);

            }
        });
        $('input[name=check-schedule').change(function(){
            if ($(this).prop('checked') == false) {
                $('input[name=check-unschedule').parent().show();
                $('#schedule .input-group input').each(function(){
                    $(this).prop('disabled', true);
                });
            }else{
                $('input[name=check-unschedule').parent().hide();
                $('#schedule .input-group input').each(function(){
                    $(this).prop('disabled', false);
                });
            }
        })
        $('input[name=check-unschedule').change(function(){
            if ($(this).prop('checked') == true) {
                // $('#team a').removeClass('assign-btn');
            }
        });
        $('input[name=billing-check]').change(function(){
            if ($(this).prop('checked') == true) {
                $('#billing').addClass('display-none');
            }else{
                $('#billing').removeClass('display-none');
            }
        });

        @if($data['job'][0]->invoicing == '0')
            $('.per_visit').show();
        @else
            $('.per_visit').hide();
        @endif
        $('input[name=invoice]').click(function(){
            console.log($(this).val());
            if ($(this).val() == '0') {
                $('.per_visit').show();
            }else{
                $('.per_visit').hide();
            }
        });
        $('#add_phone').click(function(){
            var htmlcode = $('.phoneField').html();
            // console.log(htmlcode);
        });
        $('#add_email').click(function(){

        });
        $('.delete-row').click(function(){
            $(this).parent().remove();
        });

    });

    var clientname = '';

    function initialize(result) {
        team_locations = new Array();
        markers = new Array();
        var lat = result.geometry.location.lat();
        var lng = result.geometry.location.lng();
        var latlng = new google.maps.LatLng(lat, lng);
        var mapOptions = {
            zoom: 9,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var mapCanvas = document.getElementById('job-map');
        mapCanvas.style.height = "750px";
        var map = new google.maps.Map(mapCanvas, mapOptions);
        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
        });
        var cityCircle = new google.maps.Circle({
          strokeColor: '#FF2222',
          strokeOpacity: 0.45,
          strokeWeight: 2,
          fillColor: '#FF0000',
          fillOpacity: 0.5,
          map: map,
          center: {lat: lat, lng: lng},
          radius: 50000,
        });
        var icon = {
            url: "http://www.clker.com/cliparts/o/t/F/J/B/k/google-maps-md.png",
            scaledSize: new google.maps.Size(20, 30), // scaled size
            origin: new google.maps.Point(0,0), // origin
            anchor: new google.maps.Point(10, 30) // anchor
        };


        var data = new Array();
        @foreach($data['teams'] as $one)
            data.push(<?php echo json_encode($one)?>);
        @endforeach
        console.log(data);



        for (var i = 0 ; i < data.length; i++) {
            // var member_id = data[i]['team_member_id'];
            if(typeof team_locations[i] == "undefined") {
                team_locations[i] = new Array();
            }
            var team_location = { lat: data[i]['lat'], lng: data[i]['long'], member_name: data[i]['fullname'], member_id: data[i]['team_member_id']};
            team_locations[i].push(team_location);                    
        }
        for (var i = 0; i < team_locations.length; i++) {
            
            var contentString = '<div id="content">'+
                  '<div id="siteNotice">'+
                  '</div>'+
                  '<h1 id="firstHeading" class="firstHeading">'+team_locations[i][0]['member_name']+'</h1>'+
                  '<div id="bodyContent">'+
                  '</div>'+
                  '</div>';
            var contentTeam = '<div class="col-md-12"><div class="alert alert-warning alert-dismissable alert-team">'+
                  '<input type="hidden" class="teamMemberIds'+i+
                  '" name="teamMemberIds['+i+']" value="'+team_locations[i][0]['member_id']+
                  '"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                  '<p class="headingTwo paragraph no-margin no-padding">'+team_locations[i][0]['member_name']+'</p>'+
                  '</div>'+
                  '</div>';
            contentStrings.push(contentString);
            memberStrings.push(contentTeam);
            var start_marker1 = new google.maps.Marker({
                position: new google.maps.LatLng(team_locations[i][0]['lat'], team_locations[i][0]['lng']),
                map: map,
                icon: icon, 
                title: team_locations[i][0]['member_name']
            });
            var infowindow = new google.maps.InfoWindow(), start_marker1, i;
            google.maps.event.addListener(start_marker1, 'click', (function(start_marker1, i) {
                return function() {
                    infowindow.setContent(contentStrings[i]);
                    if (!$(".teamMemberIds"+i).length) {
                        $('#selectedTeam').append(memberStrings[i]);
                    }
                    infowindow.open(map, start_marker1);
                }
            })(start_marker1, i));
            
        }
    }

    function isInfoWindowOpen(infoWindow){
        var map = infoWindow.getMap();
        return (map !== null && typeof map !== "undefined");
    }

    function getLatitudeLongitude(callback, address) {
        // If adress is not supplied, use default value 'Ferrol, Galicia, Spain'
        address = address || 'United kingdom';
        // Initialize the Geocoder
        geocoder = new google.maps.Geocoder();
        if (geocoder) {
            geocoder.geocode({
                'address': address
            }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    callback(results[0]);
                }else{
                    geocoder.geocode({
                        'address': 'United kingdom'
                    }, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            callback(results[0]);
                        }
                    });

                }
            });
        }
    }
    $('#assignButton').popover({
        html: true,
        content: function(){
            return $('#assignMenu').html();
        }
    });
    function confirm_delete(){
        alert('Are you sure?', ok);
        // return true;
    }

    function selectTeam(obj){
        var team_ids = '';
        $(obj).children('option').each(function(){
            if ($(this).prop('selected') == true) {
                team_ids += team_ids == '' ? $(this).attr('value') : ',' + $(this).attr('value');
            }
        });
        $('#team_ids').val(team_ids);
        console.log(team_ids);
    }

    function countCost(obj){
        var total = 0;
        var unit = $(obj).parent().parent().children().children('.service-unit').val();
        var quantity = $(obj).parent().parent().children().children('.service-quantity').val();
        with (Math){
            var cost = (parseFloat(unit) * parseFloat(quantity)).toFixed(2);
            $(obj).parent().parent().children().children('.service-total').val(cost);

            $(obj).parent().parent().parent().children().children().children('.service-total').each(function(){
                total = (parseFloat(total) + parseFloat($(this).val())).toFixed(2);
            });
        }
        // .toFixed(2)
        console.log(total);
        $('#subtotal_val').text('$' + total);
    }
    function deleteLineitem(obj){
        $('body').waitMe({
            effect : 'ios',
            text : '',
            bg : 'rgba(255,255,255,0.7)',
            color : '#000',
            maxSize : '',
            waitTime : -1,
            textPos : 'vertical',
            fontSize : '',
            source : '',
            onClose : function() {}
        });
        $.ajax({
            type: 'POST',
            url: "{{url('/dashboard/work/jobs/service/delete')}}",
            data:{
                '_token': $('input[name=_token]').val(),
                'job_service_id': $(obj).attr('data-id'),
            },
            success: function(data){
                $('body').waitMe("hide");
            },
        });
        $('tr').has(obj).remove();
       
    }

    function selectService(obj){
        var row_id = $(obj).parent().find('.k-input').attr('aria-activedescendant');
        var selectedRow = $('li[id='+ row_id +']').children('div');
        var description = selectedRow.attr('data-description');
        var service_id = selectedRow.attr('data-id');
        var service_unit = selectedRow.attr('data-unit');
        // console.log(service_id);
        var sss = $(obj).parent().parent().children('textarea').text(description);
        $(obj).parent().parent().parent().find('.service-id').val(service_id);
        $(obj).parent().parent().parent().find('.service-unit').val(service_unit);
        countCost($(obj).parent());
    }

    function calculateDates(){
        $('.visitDetails').show();
        var duration = parseInt($('input[name=duration]').val());
        var unit = $('[name=duration_unit]').val();
        // console.log(unit);
        if(isNaN(duration)){
            alert('Invalid duration');
            return false;
        }
        
        var startDt=$('input[name=startDate1]').val().split("-");
        var date = startDt[2];                    
        var month = startDt[1];
        var year = startDt[0];

        if(parseInt(month) == 2){//feb month
            var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));

            if (parseInt(date)>29 || (parseInt(date)==29 && !isleap)) {
                alert("February " + year + " doesn't have " + date + " days!");
                return false;   
            }
        }
        /*****Get EndDate*****/
        var myDate=new Date(year,month - 1,date);
        if (unit == '1') {
            myDate.setDate(myDate.getDate()+ duration);
            var dd = new Date(myDate.getYear(),myDate.getMonth(), myDate.getDate());
        }else if(unit == '2'){
            with(Math){
                endDate = parseInt(duration)*7;
            }
            myDate.setDate(myDate.getDate()+ endDate);
            var dd = new Date(myDate.getYear(),myDate.getMonth(), myDate.getDate());

        }else if (unit == '3') {
            myDate.setMonth(myDate.getMonth()+ duration);
            var dd = new Date(myDate.getYear(),myDate.getMonth(), myDate.getDate());
        }else if (unit == '4') {
            myDate.setYear(myDate.getYear()+ duration);
            var dd = new Date(myDate.getFullYear(),myDate.getMonth(), myDate.getDate());
        }
        
        var endyear = 0
        with(Math){
            endyear = parseInt(dd.getFullYear()) + 1900;
        }
        newDate = endyear + "-" + append((dd.getMonth()+1)) + "-" + append(dd.getDate());
        $('#endDate1').val(newDate);
        // return newDate;


        /*****Get Visits*****/
        var visits_num = 0;
        var first_visit = $('input[name=startDate1]').val();
        var last_visit = new Date();
        var formatDate = new Date(year,month - 1,date);
        var frequency =$('[name=visitFrequence2]').children('option:selected').val();
        var lastDate = new Date(newDate);

        if (frequency == '0') {
            $('.visitDetails').hide();
        }else if(frequency == '1'){
            while (formatDate <= lastDate){
                last_visit = new Date(formatDate);
                formatDate.setDate(last_visit.getDate() + 7);
                visits_num++;
            }
        }else if(frequency == '2'){
            while (formatDate <= lastDate){
                last_visit = new Date(formatDate);
                formatDate.setDate(last_visit.getDate() + 14);
                visits_num++;
            }
        }else if(frequency == '3'){
            while (formatDate <= lastDate){
                last_visit = new Date(formatDate);
                formatDate.setMonth(last_visit.getMonth() + 1);
                visits_num++;
            }
        }
        var last_visitDate = last_visit.getFullYear() + "-" + append((last_visit.getMonth()+1)) + "-" + append(last_visit.getDate());
        $('#visits_num').text(visits_num);
        $('#first_visit').text(first_visit);
        $('#last_visit').text(last_visitDate);
    }

    function append(x) {return(x<0||x>9?"":"0")+x}
</script>

<script type="text/x-jquery-tmpl" id="editlineItemRow">
<tbody>
    <tr class="Editable">
        <td>
            <i class="jobber-icon jobber-2x jobber-sort dragable-icon"></i>
            <input type="hidden" name="jobs[service][${i}][job_service_id]"/>
        </td>
        <td>
            <input type="hidden" name="jobs[service][${i}][service_id]" class="service-id"/>
            <input type="text" name="jobs[service][${i}][name]" id="serviceRow${i}" value="" style="width:100%" onchange="selectService(this)" />
            <textarea class="action-border input-lg form-control" name="jobs[service][${i}][description]" rows="2"required ></textarea>
            <i class="hiddenIcon"></i>
        </td>
        <td>
            <input type="text" class="action-border input-lg form-control text-right service-quantity" name="jobs[service][${i}][quantity]" value="1" onkeyup="countCost(this)" required/>
        </td>
        <td>
            <input type="text" class="action-border input-lg form-control text-right service-unit" name="jobs[service][${i}][unit]"  onkeyup="countCost(this)" value="0.00" required />
        </td>
        <td>
            <input type="text" class="action-border input-lg form-control text-right service-total" name="jobs[service][${i}][total]" value="0.0" required/>
            <div class="serviceAction">
                <button type="button" class="btn btn-outline btn-sm btn-danger deleteLineitem" onclick="deleteLineitem(this)">Delete</button>
                <!-- <button type="button" class="btn btn-outline btn-sm btn-job btn-submit" 
                onclick="saveLineitem(this)">Save</button> -->
            </div>
        </td>
    </tr>
</tbody>
</script>

<script type="text/x-jquery-tmpl" id="lineItemRow">
<tbody>
    <tr class="noEditable" onclick="editRow(this)">
        <td>
            <i class="glyphicon glyphicon-transfer dragable-icon"></i>
        </td>
        <td>
            <h3 class="headingTwo u-colorGreen service-val text-left">${service_val}</h3>
            <p class="paragraph descript-val text-left">${descript_val}</p>
        </td>
        <td>
            <p class="paragraph qty-val">${qty_val}</p>
        </td>
        <td>
            <p class="paragraph cost-val">${cost_val}</p>
        </td>
        <td>
            <p class="paragraph total-val">${total_val}</p>
        </td>
    </tr>
</tbody>
</script>

<script type="text/x-jquery-tmpl" id="client_properties">
<div>
    <div class="thicklist row_holder ">  
        <a class="thicklist-row property-row js-spinOnClick" href="#" onclick="getProperty(this)">
            <input type="hidden" name="propertyId" id="propertyId" value="${property_id}" />
            <p class="paragraph">
                <span id="property_street1">${property_street1}</span>&nbsp;
                <span id="property_street2">${property_street2}</span>&nbsp;
                <span id="property_city">${property_city}</span>,&nbsp;
                <span id="property_state">${property_state}</span>&nbsp;
                <span id="property_zipcode">${property_zipcode}</span>
                <i class="fa fa-angle-right u-floatRight u-colorGreen u-a-i-fontsize"></i>
            </p>
        </a>  
    </div>
</div>
</script>
<script src="{{url('public/js/plugins/kendo/kendo.all.min.js')}}"></script>
<script type="text/javascript">
    function createCombo(id){
        $("#" + id ).kendoComboBox({
            filter:"startswith",
            dataTextField: "name",
            dataValueField: "name",
            headerTemplate: '<div class="dropdown-header k-widget k-header">' +
                    '<h3 class="paragraph u-headingTwo">Service / Product</h3>',
            // footerTemplate: 'Total #: instance.dataSource.total() # items found',
            template: '<div class="row" data-id="#: data.service_id #" data-unit="#: data.cost #" data-description="#: data.description #">' +
                            '<div class="col-md-6">' + 
                                '<h4 class="paragraph u-headingTwo">#: data.name #</h4>'+
                                '<p class="paragraph">#: data.description #</p>'+
                            '</div>' +
                            '<div class="col-md-2  u-floatRight">'+
                                '<p class="paragraph u-floatRight u-marginTop">$#: data.cost #</p>'+
                            '</div>'
                        +'</div>',
            dataSource: [
                @foreach ($data['services'] as $service)
                    { service_id: "{{$service->service_id}}", name: "{{$service->name}}", description: "{{$service->description}}", cost: "{{$service->cost}}"},
                @endforeach
            ],
            height: 400
        });

    }
</script>
@stop