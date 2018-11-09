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
<div class="col-md-12">
    <div class="ibox">
        <div class="ibox-title heading-borderTop">
            <!-- asdf -->
        </div>
        <div class="ibox-content no-border">
            <div class="row">
            <form class="work_order" action="{{ url('/dashboard/work/jobs/new-job') }}" id="new_work_order" method="post">
                {{ csrf_field() }}
                <div class="col-md-7">
                    <div class="job-client">
                    @if(!$data['quote'])
                        <h1 class="headingOne">Job for 
                            <div class="clientSelector">
                            <span id="client_name">Client Name</span>
                            <span class="btn-job plainClientName">+</span>
                            </div>
                        </h1>
                    @else
                        <h1 class="headingOne">Job for {{$data['quote'][0]->first_name}} {{$data['quote'][0]->last_name}}
                        </h1>
                    @endif
                        <div class="">
                            <h3 class="headingFive">Job description</h3>
                            <label class="fa select-label label-lg">
                                <select class="input-lg form-control action-border description jobDescription" name="jobDescription">
                                    <option>Description</option>
                                @foreach($data['descriptions'] as $description)
                                    <option value="{{$description}}">{{$description}}</option>
                                @endforeach
                                </select>
                            </label>
                        </div>
                        <div class="row">
                            @if(!$data['quote'])
                                <div class="col-md-6 propertyField" style="display: none;">
                                    <h3 class="headingFive u-marginTopBiggest">Property Address</h5>
                                    <p class="paragraph u-marginTopSmall" id="propertyStreet1"></p>
                                    <p class="paragraph" id="propertyStreet2"></p>
                                    <p class="paragraph" id="propertyMain"></p>
                                    <input type="hidden" id="property_address">
                                </div>
                            @else
                                <div class="col-md-6 propertyField">
                                    <h3 class="headingFive u-marginTopBiggest">Property Address</h5>
                                    <p class="paragraph u-marginTopSmall">{{$data['quote'][0]->street1}} {{$data['quote'][0]->street2}}</p>
                                    <p class="paragraph">{{$data['quote'][0]->city}} {{$data['quote'][0]->state}}, {{$data['quote'][0]->zip_code}}</p>
                                    <input type="hidden" id="property_address">
                                </div>
                            @endif
                            @if($data['quote'])
                                <div class="col-md-6">
                                    <h4 class="headingOne u-marginTopBiggest">Contact details</h4>
                                    @foreach($data['quote'] as $one)
                                        @if($one->type == 1)
                                            <p class="paragraph">{{$one->value}}</p>
                                        @else
                                            <a href="" class="add-one no-padding u-textSmaller">{{$one->value}}</a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @if(!$data['quote'])
                        <input type="hidden" name="client_Id" id="client_Id" />
                        <input type="hidden" name="property_Id" id="property_Id" />
                        <input type="hidden" name="quote_id" id="quote_id"/>
                    @else
                        <input type="hidden" name="client_Id" id="client_Id" value="{{$data['quote'][0]->client_id}}"/>
                        <input type="hidden" name="property_Id" id="property_Id" value="{{$data['quote'][0]->property_id}}"/>
                        <input type="hidden" name="quote_id" id="quote_id" value="{{$data['quote'][0]->quote_id}}" />
                    @endif
                    </div>
                </div>
                <div class="col-md-5">
                    <!-- <div class="job-detail">
                        <h3 class="headingFive u-marginBottom">Job details</h3>
                        <div class="row">
                            <div class="col-md-5">
                                <span>Job number</span>
                            </div>
                            <div class="col-md-7">
                                <div class="staticNumber">
                                    <span class="work_order_number list-text">#3</span>
                                    <span class="textAction">Change</span>
                                </div>
                                <div class="numberInputWrapper">
                                    <input type="number" class="numberInput action-border" value="3"/>
                                    <button type="button" class="btn-job cancelInput">Cancel</button>
                                </div>
                                <div class="fieldHelper">
                                    Future jobs will be assigned the next highest job number
                                </div>
                            </div>
                        </div>
                        <div class="row customField">
                            <div class="col-md-2 iconField">
                                <span class="blueIcon">@</span>
                            </div>
                            <div class="col-sm-10">
                                <h3 class="headingTwo">
                                    Need to track more details on jobs?
                                </h3>
                                <a href="" class="btn-add">Add Custom Field</a>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="col-md-12">
                    <div class="panel blank-panel jobTypePanel">

                        <div class="panel-heading">
                            <div class="panel-title m-b-md"><h4></h4></div>
                            <div class="panel-options">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#tab-1" class="selectTab" onclick="selectJobtype('1')">
                                        <h3 class="headingTwo">One-Off Job</h3>
                                        <p class="paragraph" style="text-transform: none;">
                                            A one time job with one or more visits
                                        </p>
                                    </a></li>
                                    <li class="">
                                        <a data-toggle="tab" href="#tab-2" class="selectTab" onclick="selectJobtype('2')">
                                        <h3 class="headingTwo">Recurring Job</h3>
                                        <p class="paragraph" style="text-transform: none;">
                                            A contract job with repeating visits
                                        </p>
                                    </a></li>
                                </ul>
                                <input type="hidden" name="jobType" id="jobType" value="1" />
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="row">
                                        <div class="col-md-12"  id="schedule">
                                            <div class="ibox">
                                                <div class="ibox-title">
                                                    <h3 class="headingTwo">Schedule</h3>
                                                    <label class="scheduleLater">
                                                        <input type="checkbox" class="check-button" name="check-schedule" id="check_schedule">
                                                        <i class="checkbox fa"></i>
                                                        <span class="paragraph">
                                                            Schedule later
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <h3 class="headingFive daterange-label">Startdate</h3>
                                                                <h3 class="headingFive daterange-label">Enddate</h3>
                                                            </div>
                                                            <div class="input-daterange input-group u-grid10" id="dateRange">
                                                                @if(!$date)
                                                                    <input type="text" class="action-border input-lg form-control text-center" name="startDate" value="<?php  echo date('Y-m-d')?>" onchange="calculateDates();"/>
                                                                @else
                                                                    <input type="text" class="action-border input-lg form-control text-center" name="startDate" value="{{$date}}" onchange="calculateDates();"/>
                                                                @endif
                                                                <span class="input-group-addon">to</span>
                                                                <input type="text" class="action-border input-lg form-control" name="endDate" placeholder="Optional"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h3 class="headingFive">Times</h3>
                                                            <div class="input-group date u-grid5 u-floatLeft" id="time_start">
                                                                <input type="text" class="action-border input-lg form-control" name="startTime" value="" placeholder="Start time"/>
                                                                <!-- data-mask="99:99" -->
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                </span>
                                                            </div>
                                                            <div class="input-group date u-grid5 u-floatLeft" id="time_end">
                                                                <input type="text" class="action-border input-lg form-control" name="endTime" value="" placeholder="End time"/>
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6" id="Frequence1">
                                                            <h3 class="headingFive u-marginTop">Visit frequency</h3>
                                                            <div class="input-group">
                                                                <label class="fa select-label label-lg">
                                                                    <select class="input-lg form-control action-border" name="visitFrequence1">
                                                                        <option value="0">As need - we won't prompt you</option>
                                                                        <option value="1" selected>Daily</option>
                                                                        <option value="2">Weekly</option>
                                                                        <option value="3">Monthly</option>
                                                                        <!-- <option disabled="disabled" value="or">or</option> -->
                                                                        <option value="4">One time</option>
                                                                    </select>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 u-marginTopSmall">
                                                            <label class="check-element" id="check_unschedule">
                                                                <input type="checkbox" class="check-button" name="check-unschedule" id="" checked>
                                                                <i class="checkbox fa"></i>
                                                                <span class="paragraph">
                                                                    Add an unscheduled visit to the calendar
                                                                </span>
                                                            </label>
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

                                <div id="tab-2" class="tab-pane">
                                    <div class="row">
                                        <div class="col-md-12">
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
                                                                    <div class="input-group date u-grid10" id="dateStart">
                                                                    @if(!$date)
                                                                        <input type="text" class="action-border input-lg form-control input-group-addon text-center" name="startDate1" value="<?php  echo date('Y-m-d')?>" onchange="calculateDates();"/>
                                                                    @else
                                                                        <input type="text" class="action-border input-lg form-control input-group-addon text-center" name="startDate1" value="{{$date}}" onchange="calculateDates();"/>
                                                                    @endif
                                                                        <input type="hidden" name="endDate1" id="endDate1">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h3 class="headingFive">Duration</h3>
                                                                    <div class="input-group" id="duration">
                                                                        <input type="text" class="action-border input-lg form-control text-center" name="duration" value="6"/ onchange="calculateDates();">
                                                                        <label class="fa select-label label-lg">
                                                                            <select class="input-lg form-control action-border" name="duration_unit" onchange="calculateDates();">
                                                                                <option value="1">day(s)</option>
                                                                                <option value="2">week(s)</option>
                                                                                <option value="3">month(s)</option>
                                                                                <option value="4">year(s)</option>
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
                                                                                <option value="1">Weekly on {{date('l', strtotime(date('Y-m-d')))}}</option>
                                                                                <option value="2">Every 2 weeks on {{date('l', strtotime(date('Y-m-d')))}}</option>
                                                                                <option value="3">Monthly on the {{date('jS', strtotime(date('Y-m-d')))}} day of the month</option>
                                                                                <!-- <option disabled="disabled" value="or">or</option> -->
                                                                                <option value="4">One time</option>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h3 class="headingFive">Times</h3>
                                                            <div class="input-group date u-grid5 u-floatLeft" id="time_start1">
                                                                <input type="text" class="action-border input-lg form-control" name="startTime1" value="" placeholder="Start time" />
                                                                <!-- data-mask="99:99" -->
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                </span>
                                                            </div>
                                                            <div class="input-group date u-grid5 u-floatLeft" id="time_end1">
                                                                <input type="text" class="action-border input-lg form-control" name="endTime1" value="" placeholder="End time" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                </span>
                                                            </div>
                                                            <div class="visitDetails" style="display: none;">
                                                                <p class="paragraph u-colorBlue">
                                                                    <span class="u-textBold" id="visits_num">26</span> visits total
                                                                </p>
                                                                <p class="paragraph u-colorBlue">
                                                                    First visit on 
                                                                    <span class="u-textBold" id="first_visit">24/01/2018</span>
                                                                    <br>Last visit on 
                                                                    <span class="u-textBold" id="last_visit">18/07/2018</span>
                                                                </p>
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
                                                                    <input type="radio" class="check-button" name="invoice" value="0" checked="">
                                                                    <i class="checkbox fa"></i>
                                                                    <span>
                                                                       Visit based billing
                                                                    </span>
                                                                </label>
                                                                <p class="paragraph u-textSmaller" style="padding-left: 25px;">Invoices include all the billable work on completed visits (e.g. $40 a Visit)</p>
                                                                <label class="radio-element">
                                                                    <input type="radio" class="check-button" name="invoice" value="1">
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
                                                                    <option value="0">As needed - we won't prompt you</option>
                                                                    <option value="1">After each visit</option>
                                                                    <option value="2">Once when job is completed</option>
                                                                    <option selected="selected" value="3">Monthly on the last day of the month</option>
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
                                                @if(!$data['quotes_services'])
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
                                                <?php $i = 0; $total = 0;?>
                                                @if(!$data['quotes_services'])
                                                    <tr class="Editable">
                                                        <td>
                                                            <i class="jobber-icon jobber-2x jobber-sort dragable-icon"></i>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="jobs[service][0][service_id]" class="service-id" onchange="countCost(this);" />
                                                            <input type="text" name="jobs[service][0][name]" id="serviceRow0" value="" style="width:100%" 
                                                            onchange="selectService(this)" />
                                                            <textarea class="action-border input-lg form-control" name="jobs[service][0][description]" rows="2" ></textarea >
                                                            <i class="hiddenIcon"></i>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="action-border input-lg form-control text-right service-quantity" name="jobs[service][0][quantity]" value="1" onkeyup="countCost(this)" />
                                                        </td>
                                                        <td>
                                                            <input type="text" class="action-border input-lg form-control text-right service-unit" name="jobs[service][0][unit]" value="0.00"  onkeyup="countCost(this)" />
                                                        </td>
                                                        <td>
                                                            <input type="text" class="action-border input-lg form-control text-right service-total" name="jobs[service][0][total]" value="0.0" />
                                                            <div class="serviceAction">
                                                                <button type="button" class="btn btn-outline btn-sm btn-danger deleteLineitem" onclick="deleteLineitem(this)">Delete</button>
                                                                <!-- <button type="button" class="btn btn-outline btn-sm btn-job btn-submit" 
                                                                onclick="saveLineitem(this)">Save</button> -->
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @else
                                                    @foreach ($data['quotes_services'] as $quote_service)
                                                        <tr class="Editable">
                                                        <td>
                                                            <i class="jobber-icon jobber-2x jobber-sort dragable-icon"></i>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="jobs[service][{{$i}}][service_id]" class="service-id" value="{{$quote_service->service_id}}" onchange="countCost(this);" />
                                                            <input type="text" name="jobs[service][{{$i}}][name]" id="serviceRow{{$i}}" value="{{$quote_service->service_name}}" style="width:100%" 
                                                            onchange="selectService(this)" />
                                                            <textarea class="action-border input-lg form-control" name="jobs[service][{{$i}}][description]" rows="2" >{{$quote_service->service_description}}</textarea >
                                                            <i class="hiddenIcon"></i>
                                                        </td>
                                                        <td>
                                                            <p class="paragraph" style="margin-top: 12px;">${{$quote_service->quantity*$quote_service->cost}}</p>
                                                            <input type="hidden" name="jobs[service][{{$i}}][quoted]" value="{{$quote_service->quantity*$quote_service->cost}}" />
                                                        </td>
                                                        <td>
                                                            <input type="text" class="action-border input-lg form-control text-right service-quantity" name="jobs[service][{{$i}}][quantity]" value="{{$quote_service->quantity}}" onkeyup="countCost(this)" />
                                                        </td>
                                                        <td>
                                                            <input type="text" class="action-border input-lg form-control text-right service-unit" name="jobs[service][{{$i}}][unit]" value="{{$quote_service->cost}}"  onkeyup="countCost(this)" />
                                                        </td>
                                                        <td>
                                                            <input type="text" class="action-border input-lg form-control text-right service-total" name="jobs[service][{{$i}}][total]" value="{{$quote_service->quantity*$quote_service->cost}}" />
                                                            <div class="serviceAction">
                                                                <!-- <button type="button" class="btn btn-outline btn-sm btn-danger deleteLineitem" onclick="deleteLineitem(this)">Delete</button> -->
                                                                <!-- <button type="button" class="btn btn-outline btn-sm btn-job btn-submit" 
                                                                onclick="saveLineitem(this)">Save</button> -->
                                                            </div>
                                                        </td>
                                                        </tr>
                                                    <?php $i++; $total += $quote_service->quantity*$quote_service->cost;?>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                            <a href="#" class="btn-job addItem-btn">Add Line item</a>
                                        @if($data['quotes_services'])
                                            <div class="row no-margin" style="padding-bottom: 10px;">
                                                <div class="col-xs-3 text-right u-floatRight u-borderBottom">
                                                    <p class="paragraph" style="margin-right: 20px;">$ {{$total}}</p>
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
                                                    <input type="hidden" name="team_ids" id="team_ids" />
                                                    <h3 class="headingTwo u-marginTopSmall">Selected Team Member</h3>
                                                    <div class="row no-margin" id="selectedTeam">
                                                        <!-- <div class="col-md-12">
                                                            <div class="alert alert-warning alert-dismissable alert-team">
                                                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                                                <h4 class="headingTwo no-padding no-margin">fullname</h4>
                                                            </div>
                                                        </div> -->
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
                                            <textarea class="action-border input-lg form-control" name="internalNotes" value="" rows="5" placeholder="Note details"></textarea>
                                            <div id="files_list" class="u-marginTopSmall"></div>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                                            </div>
                                            <div class="text-right u-marginTop u-marginBottom">
                                                <label class="check-element btn btn-sm button--greyBlue button--ghost u-textBold ">
                                                        <input type="file" id="fileupload" name="photos[]" multiple class="" />
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
                    <a class="cancelAdd-btn button--greyBlue button--ghost" tabindex="-1" href="/dashboard/work/jobs">Cancel</a>
                @if(!$data['quote'])
                    <button name="button" type="submit" class="btn-job form-submit">Select Client</button>
                @else
                    <button name="button" type="submit" class="btn-job quote-job-submit">Create Job</button>
                @endif
                </div>
            </form>
            </div>
        </div>
    </div>
    <!-- Modal1 -->
    <div class="modal inmodal" id="client" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left">Select or create a client</h4>
            </div>
            <div class="modal-body">
                <p class="paragraph u-marginBottomSmall">
                    Which client would you like to create this job for?
                </p>
                <div class="ibox clientbox">
                    <div class="ibox-title">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <form>
                                        <input type="text" placeholder="Search client..." 
                                        class="search-input action-border"  id="search_client">
                                        <!-- <button class="close-icon" type="reset">
                                            ×
                                        </button> -->
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="/dashboard/clients/add"  class="btn-job createNew u-textBold" remote="true" id="createClient">+ Create New Client</a>
                                <span class="middle-text">Or</span>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="thicklist client-sieve" id="clients">
                        @foreach ($data['clients'] as $client) 
                            <div class="thicklist-row client-row js-spinOnClick">
                                <input type="hidden" name="clientId" id="clientId" value="{{$client->client_id}}" />
                                <div class="row">
                                    <div class="columns col-sm-1">
                                        <i class="icon-user fa fa-2x fa-user"></i>
                                    </div>
                                    <div class="columns col-sm-6">
                                        <h3 class="headingFive u-marginTopSmallest clientname">
                                            {{$client->first_name}}&nbsp;{{$client->last_name}}
                                        </h3>
                                        <p class="paragraph"><small>{{$client->property}} Properties | 13512025465125</small></p>
                                    </div>

                                    <div class="columns col-sm-5 text-right">
                                        <p class="paragraph u-marginTopSmall"><small>Activity about 15 hours ago</small></p>
                                    </div>
                                </div>
                            </div>
                        @endforeach 
                        </div>
                    </div>
                </div>
                <div class="modal-footer no-border">
                </div>
            </div>
        </div>
    </div>
    <!-- Modal2 -->
    <div class="modal inmodal" id="property" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title headingTwo text-left">Select a Property</h4>
                </div>
                <div class="modal-body">
                    <p class="paragraph u-marginBottomSmall">
                        Which Property would you like to use for this Job?
                    </p>
                    <div class="ibox propertybox">
                        <div class="ibox-title">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <!-- <label class="fa search-label"> -->
                                        <form>
                                            <input type="text" placeholder="Search property..." 
                                            class="search-input action-border"  id="search_property">
                                            <!-- <button class="close-icon" type="reset">
                                                ×
                                            </button> -->
                                        </form>
                                        <!-- </label> -->
                                    </div>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button  type="button" class="btn-job createNew u-textBold" remote="true" id="createProp">+ Create New Property</button>
                                    <span class="middle-text">Or</span>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content" id="properties">
                            <div class="thicklist row_holder ">  
                                <a class="thicklist-row property-row js-spinOnClick" href="#">
                                    <input type="hidden" name="propertyId" id="propertyId" value="1" />
                                    <p class="paragraph">123e12e dasdasdasd Changchun, Jilin
                                        <i class="fa fa-angle-right u-floatRight u-colorGreen u-a-i-fontsize"></i>
                                    </p>
                                </a>  
                            </div>
                            <div class="thicklist row_holder ">  
                                <a class="thicklist-row property-row js-spinOnClick" href="#">
                                    <input type="hidden" name="propertyId" id="propertyId" value="1" />
                                    <p class="paragraph">123e12e dasdasdasd Changchun, Jilin
                                        <i class="fa fa-angle-right u-floatRight u-colorGreen u-a-i-fontsize"></i>
                                    </p>
                                </a>  
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer no-border">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal3 -->
    <div class="modal inmodal" id="newClient" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title headingTwo text-left">Create a New Client</h4>
                </div>
                <form action="#" method="post">
                <div class="modal-body">
                    <div class="panel-body">
                        <div class="panel-group newClient" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="fa panel-selector">
                                            <span class="headingTwo">Client Details</span>
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in">
                                    <div class="panel-content">
                                        <!-- <form> -->
                                            <div class="input-group">
                                                <label class="fa select-label label-lg u-grid2" style="float: left">
                                                    <select class="input-lg form-control action-border">
                                                        <option>No title</option>
                                                        <option>Mr.</option>
                                                        <option>Ms.</option>
                                                        <option>Mrs.</option>
                                                        <option>Miss.</option>
                                                        <option>Dr.</option>
                                                    </select>
                                                </label>
                                                <input type="text" class="action-border input-lg form-control u-grid4" name="firstname" placeholder="First name" value=""/>
                                                <input type="text" class="action-border input-lg form-control u-grid4" name="lastname" placeholder="Last name" value=""/>
                                                <input type="text" class="action-border input-lg form-control" name="companyname" placeholder="Company name" value=""/>
                                            </div>
                                            <div class="input-group">
                                                <label class="check-element">
                                                    <input type="checkbox" class="check-button" name="useCname" value="1">
                                                    <i class="checkbox fa"></i>
                                                    <span>
                                                        Use company name as the primary name
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="input-group u-grid10">
                                                <h4 class="headingTwo">Contact details</h4>
                                                <div class="phoneField">
                                                    <div class="phoneFieldRow">
                                                        <label class="fa select-label label-lg u-grid2" style="float: left">
                                                            <select class="input-lg form-control action-border" name="typePhonenum">
                                                                <option>Main</option>
                                                                <option>Work</option>
                                                                <option>Mobile</option>
                                                                <option>Home</option>
                                                                <option>Fax</option>
                                                                <option>Other</option>
                                                            </select>
                                                        </label>
                                                        <input type="text" class="action-border input-lg form-control
                                                         u-grid8" name="phone" placeholder="Phone number" value=""/>
                                                    </div>
                                                    <!-- <div class="phoneFieldRow">
                                                        <label class="fa select-label label-lg u-grid2" style="float: left">
                                                            <select class="input-lg form-control action-border" name="typePhonenum">
                                                                <option>Main</option>
                                                                <option>Work</option>
                                                                <option>Mobile</option>
                                                                <option>Home</option>
                                                                <option>Fax</option>
                                                                <option>Other</option>
                                                            </select>
                                                        </label>
                                                        <input type="text" class="action-border input-lg form-control u-grid7" name="phone" placeholder="Phone number" value=""/>
                                                         <a href="#" class="btn btn-red delete-row text-right"><i class="glyphicon glyphicon-trash"></i></a>
                                                    </div> -->
                                                </div>
                                                <!-- <div class="phoneField">
                                                    <label class="fa select-label label-lg u-grid2" style="float: left">
                                                        <select class="input-lg form-control action-border" name="typePhonenum">
                                                            <option>Main</option>
                                                            <option>Work</option>
                                                            <option>Mobile</option>
                                                            <option>Home</option>
                                                            <option>Fax</option>
                                                            <option>Other</option>
                                                        </select>
                                                    </label>
                                                    <input type="text" class="action-border input-lg form-control
                                                     u-grid8" name="phone" placeholder="Phone number" value=""/>
                                                </div> -->
                                                <a href="#" class="u-grid10 add-one" id="add_phone">Add Another Phone Number</a>
                                            </div>
                                            <div class="input-group u-grid10">
                                                <div class="emailField">
                                                    <label class="fa select-label label-lg u-grid2" style="float: left">
                                                        <select class="input-lg form-control action-border" name="typeEmail">
                                                            <option>Main</option>
                                                            <option>Work</option>
                                                            <option>Personal</option>
                                                            <option>Other</option>
                                                        </select>
                                                    </label>
                                                    <input type="text" class="action-border input-lg form-control
                                                     u-grid8" name="email" placeholder="Email Address" value=""/>
                                                </div>
                                                <a href="#" class="u-grid10 add-one" id="add_email">Add Another Email Address</a>
                                            </div>
                                            <div class="input-group">
                                                <h4 class="headingTwo">Property Details</h4>
                                                <input type="text" class="action-border input-lg form-control
                                                 u-grid10" name="street1" placeholder="Street 1" value=""/>
                                                <input type="text" class="action-border input-lg form-control
                                                 u-grid10" name="street2" placeholder="Street 2" value=""/>
                                                <div class="u-grid5 combobox">
                                                    <select class="input-lg form-control action-border combo-select comboCity" name="city">
                                                        <option value="">City</option>
                                                        <option value="Changchun">Changchun</option>
                                                        <option value="New">New York</option>
                                                        <option value="Beijing">Beijing</option>
                                                    </select>
                                                </div>
                                                <div class="u-grid5 combobox">
                                                    <select class="input-lg form-control action-border combo-select comboCity" name="state">
                                                        <option value="">State</option>
                                                        <option value="Changchun">Changchun</option>
                                                        <option value="New">New York</option>
                                                        <option value="Beijing">Beijing</option>
                                                    </select>
                                                </div>
                                                <input type="text" class="action-border input-lg form-control
                                                 u-grid5" name="zipcode" placeholder="Zip code" value=""/>
                                                <label class="fa select-label label-lg u-grid5" style="float: left">
                                                    <select class="input-lg form-control action-border" name="country" id="country">
                                                    </select>
                                                </label>
                                            </div>
                                            <div class="input-group">
                                                <span class="paragraph" style="margin-right: 20px;float: left;">Taxes</span>
                                                <div class="dropmenuBox">
                                                    
                                                    <a class="dropdown-toggle add-one" id="taxRate" data-toggle="dropdown" href="#">
                                                        tax1 (0.2%) (Default)
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-user tax-dropdown">
                                                        <li>
                                                            <label class="radio-element">
                                                                <input type="radio" class="check-button" name="taxRate" value="1" checked=""  id="" data-id="" data-tax="0.2" data-name="tax1 (0.5%) (Default)">
                                                                <i class="fa"></i>
                                                                <span>
                                                                   tax1 (0.2%) (Default)
                                                                </span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="radio-element">
                                                                <input type="radio" class="check-button" name="taxRate" value="2" id="" data-id="" data-tax="0.2" data-name="tax2 (0.5%)">
                                                                <i class="fa"></i>
                                                                <span>
                                                                   tax2 (0.5%)
                                                                </span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="radio-element">
                                                                <input type="radio" class="check-button" name="taxRate" value="3"  id="" data-id="" data-tax="0.4" data-name="tax3 (0.4%)">
                                                                <i class="fa"></i>
                                                                <span>
                                                                   tax3 (0.4%)
                                                                </span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <label class="check-element">
                                                    <input type="checkbox" class="check-button" name="billing-check" value="1" checked="">
                                                    <i class="checkbox fa"></i>
                                                    <span>
                                                        Billing address is the same as property address
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="input-group display-none" id="billing">
                                                <h4 class="headingTwo">Billing Address</h4>
                                                <input type="text" class="action-border input-lg form-control
                                                 u-grid10" name="billing_street1" placeholder="Street 1" value=""/>
                                                <input type="text" class="action-border input-lg form-control
                                                 u-grid10" name="billing_street2" placeholder="Street 2" value=""/>
                                                <div class="u-grid5 combobox">
                                                    <select class="input-lg form-control action-border combo-select comboCity" name="billing_city">
                                                        <option value="">City</option>
                                                        <option value="Changchun">Changchun</option>
                                                        <option value="New">New York</option>
                                                        <option value="Beijing">Beijing</option>
                                                    </select>
                                                </div>
                                                <div class="u-grid5 combobox">
                                                    <select class="input-lg form-control action-border combo-select comboCity" name="billing_state">
                                                        <option value="">State</option>
                                                        <option value="Changchun">Changchun</option>
                                                        <option value="New">New York</option>
                                                        <option value="Beijing">Beijing</option>
                                                    </select>
                                                </div>
                                                <input type="text" class="action-border input-lg form-control
                                                 u-grid5" name="billing_zipcode" placeholder="Zip code" value=""/>
                                                <label class="fa select-label label-lg u-grid5" style="float: left">
                                                    <select class="input-lg form-control action-border" name="billing_country" id="country1">
                                                    </select>
                                                </label>
                                            </div>
                                        <!-- </form> -->
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="fa panel-selector">
                                            <span class="headingTwo">Automated Notifications</span>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse">
                                    <div class="panel-content">
                                        <div class="input-group">
                                            <label class="check-on-off" style="float: left">
                                                <input type="checkbox" class="check-button" name="notify-check1" value="1">
                                                <span class="off">OFF</span>
                                                <span class="on">ON</span>
                                            </label>
                                            <p class="paragraph" style="float: left"><span class="u-textBold">Client reminders</span> sent for upcoming visits. <a href="#" class="add-one"> Learn More</a> </p>
                                        </div>
                                        <div class="input-group">
                                            <label class="check-on-off" style="float: left">
                                                <input type="checkbox" class="check-button" name="notify-check2" value="1">
                                                <span class="off">OFF</span>
                                                <span class="on">ON</span>
                                            </label>
                                            <p class="paragraph" style="float: left"><span class="u-textBold">Client follow-up emails</span> when you close a job. <a href="#" class="add-one"> Learn More</a> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="fa panel-selector">
                                            <span class="headingTwo">Additional Client Details</span>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse">
                                    <div class="panel-content">
                                        <div class="input-group u-grid10">
                                            <input type="text" class="action-border input-lg form-control
                                            " name="refer2" placeholder="Refered By" value=""/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-job">Create Client</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal4 -->
    <div class="modal inmodal" id="newProperty" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title headingTwo text-left">New Property for Mr. HuangJin Cui</h4>
                </div>
                <form>
                <div class="modal-body">
                    <div class="input-group">
                        <h4 class="headingTwo">Property Details</h4>
                        <input type="text" class="action-border input-lg form-control
                         u-grid10" name="street1" placeholder="Street 1" value=""/>
                        <input type="text" class="action-border input-lg form-control
                         u-grid10" name="street2" placeholder="Street 2" value=""/>
                        <div class="u-grid5 combobox">
                            <select class="input-lg form-control action-border combo-select comboCity" name="city">
                                <option value="">City</option>
                                <option value="Changchun">Changchun</option>
                                <option value="New">New York</option>
                                <option value="Beijing">Beijing</option>
                            </select>
                        </div>
                        <div class="u-grid5 combobox">
                            <select class="input-lg form-control action-border combo-select comboCity" name="state">
                                <option value="">State</option>
                                <option value="Changchun">Changchun</option>
                                <option value="New">New York</option>
                                <option value="Beijing">Beijing</option>
                            </select>
                        </div>
                        <input type="text" class="action-border input-lg form-control
                         u-grid5" name="zipcode" placeholder="Zip code" value=""/>
                         <label class="fa select-label label-lg u-grid5" style="float: left">
                            <select class="input-lg form-control action-border" name="country" id="country2">
                            </select>
                        </label>
                    </div>
                    <div class="input-group">
                        <span class="paragraph" style="margin-right: 20px;float: left;">Taxes</span>
                        <div class="dropmenuBox">
                            
                            <a class="dropdown-toggle add-one" id="" data-toggle="dropdown" href="#">
                                tax1 (0.2%) (Default)
                            </a>
                            <ul class="dropdown-menu dropdown-user tax-dropdown">
                                <li>
                                    <label class="radio-element">
                                        <input type="radio" class="check-button" name="taxRate" value="1" checked=""  id="" data-id="" data-tax="0.2" data-name="tax1 (0.5%) (Default)">
                                        <i class="fa"></i>
                                        <span>
                                           tax1 (0.2%) (Default)
                                        </span>
                                    </label>
                                </li>
                                <li>
                                    <label class="radio-element">
                                        <input type="radio" class="check-button" name="taxRate" value="2" id="" data-id="" data-tax="0.2" data-name="tax2 (0.5%)">
                                        <i class="fa"></i>
                                        <span>
                                           tax2 (0.5%)
                                        </span>
                                    </label>
                                </li>
                                <li>
                                    <label class="radio-element">
                                        <input type="radio" class="check-button" name="taxRate" value="3"  id="" data-id="" data-tax="0.4" data-name="tax3 (0.4%)">
                                        <i class="fa"></i>
                                        <span>
                                           tax3 (0.4%)
                                        </span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-job">Create Property</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
                    <input type="hidden" name="job_id" value="" />
                    <div class="input-group u-grid10 u-marginBottomSmall" id="">
                        <input type="text" class="action-border input-lg form-control " name="member_name" value=""  placeholder="Full name"/>
                    </div>
                    <div class="input-group u-grid10 u-marginBottomSmall" id="">
                        <input type="email" class="action-border input-lg form-control " name="member_email" value=""  placeholder="Email address"/>
                        <p class="paragraph u-textItalic">An email is  to log in to Jobber</p>
                    </div>
                    <div class="input-group u-grid10 u-marginBottomSmall" id="">
                        <input type="text" class="action-border input-lg form-control " name="mobile_phone" value=""  placeholder="Mobile phone number"/>
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

<script src="{{ url('public/js/jquery.sieve.js')}}"></script>
<script src="{{ url('public/js/country.js')}}"></script>
<script type="text/javascript">
    var infoWindow;
    var property_id;
    var init_address;
    var team_locations = new Array();
    var markers = new Array();
    var contentStrings = new Array();
    var memberStrings = new Array();
    $(document).ready(function(){
        var i = {{count($data['quotes_services'])}} - 1;
        property_id = $('#property_Id').val();
        init_address = $('#property_address').val();
        google.maps.event.addDomListener(window, 'load', getLatitudeLongitude(initialize,init_address));
        //Init Datepicker
        $('#dateRange').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
                                                
        $('#dateStart').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });

        $('#time_start').datetimepicker({
            format: 'HH:mm',   
        });
        $('#time_end').datetimepicker({
            format: 'HH:mm',   
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
        $('.chosen-select1').chosen();

        //Init Combobox
        var combobox = $('.combo-select').combobox().data('combobox');
        for (var num = 0; num <= i; num++) {
            var id = 'serviceRow' + num;
            createCombo(id);
        }
        // createCombo('serviceRow' + i);

        // Init Country
        populateCountries('country');
        populateCountries('country1');
        populateCountries('country2');

        //Ajax File Upload

        $('#fileupload').change(function(){
            if ($(this).val == '') {
                return false;
            }
            $('.myprogress').css('width', '0%');
            $('.msg').text('');
            var formData = new FormData();
            // console.log(formData);
            formData.append('_token', $('input[name=_token]').val());
            for (var i = 0, len = $('#fileupload').get(0).files.length; i < len; i++) {
                formData.append("photos["+i+"]", $('#fileupload').get(0).files[i]);
            }
            // formData.append('photos', $('#fileupload').get(0).files[]);
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

        //Action
        $('.form-submit').click(function(){
            var clientId = $('#client_Id').val();
            var propertyId = $('#property_Id').val();
            if (clientId == '' || propertyId == '') {
                $('#client').modal('show');
                return false;
            }
        });

        $('input[name=endDate]').change(function(){
            if ($(this).val() == '') {
                $('#Frequence1').hide();
            }else{
                $('#Frequence1').show();
            }
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

        // $('.textAction').click(function(){
        //     $(this).parent().hide();
        //     $('.numberInputWrapper').show();
        // });
        // $('.cancelInput').click(function(){
        //     var number = $(this).parent().children('input[type=number]').val();
        //     if (number < 10) {
        //         $('.fieldHelper').show();
        //     }else{
        //         $(this).parent().hide();
        //         $('.fieldHelper').hide();
        //         $('.staticNumber').show();
        //         $('.staticNumber').children('.work_order_number').text('#' + number);

        //     }
        // });
        $('input[name=check-schedule').change(function(){
            if ($(this).prop('checked') == true) {
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
            if ($(this).prop('checked') == false) {
                $('#add_user').attr('disabled', true);
            }else{
                $('#add_user').attr('disabled', false);
            }
        });

        // $('input[name=taxRate]').change(function(){
        //         console.log($(this).attr('data-name'));
        //     if ($(this).prop('checked') == true) {
        //         var rateText = $(this).attr('data-name');
        //         // $('#taxRate').text(rateText);
        //         $(this).parent().parent().parent().parent().children('a').text(rateText);
        //     }
        // });
        $('input[name=billing-check]').change(function(){
            if ($(this).prop('checked') == true) {
                $('#billing').addClass('display-none');
            }else{
                $('#billing').removeClass('display-none');
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


        //Modal controll
        $('.clientSelector').click(function(){
            $('#client').modal('show');
            var searchInput = $('#search_client');
            $(".client-sieve").sieve({ searchInput: searchInput, itemSelector: ".client-row" });

        });
        $('.client-row').click(function(){
            var clientId = $(this).children('input[type=hidden]').val();
            $('#client_Id').val(clientId);
            clientname = $(this).children().children().children('.clientname').text();
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
                url: "{{url('/dashboard/work/jobs/getproperty/')}}",
                data:{
                    '_token': $('input[name=_token]').val(),
                    'client_id': clientId
                },
                success: function(data){
                    $('body').waitMe("hide");
                    $('#properties').children().remove();
                    // console.log(data);

                    if (data.length == 0) {
                        window.location.href = "{{url('dashboard/properties/newproperty/')}}" + clientId;
                    //}
                    // else if(data.length == 1){
                    //      // console.log(data);
                    //     var property_id = data[0].property_id;
                    //     $('#property_Id').val(property_id);
                    //     $('.propertyField').show();
                    //     $('#propertyStreet1').text(data[0].street1);
                    //     $('#propertyStreet2').text(data[0].street2);
                    //     $('#propertyMain').text(data[0].city + ',' + data[0].state + ' ' + data[0].zip_code);
                    //     $('#client_name').text(clientname);
                    //     $('.form-submit').text('Create Job');
                    //     $('#client').modal('hide');
                    }else{
                        for (var i = 0; i < data.length; i++) {
                            var addHtml = $('#client_properties').tmpl({
                                property_id: data[i].property_id,
                                property_street1: data[i].street1,
                                property_street2: data[i].street2,
                                property_city: data[i].city,
                                property_state: data[i].state,
                                property_zipcode: data[i].zip_code,
                            }).html();
                            // console.log(addHtml);
                            $('#properties').append(addHtml);
                        }
                        $('#client').modal('hide');
                        $('#property').modal('show');
                        var searchInput = $('#search_property');
                        $("#properties").sieve({ searchInput: searchInput, itemSelector: ".property-row" });
                    }
                },

            });
            // console.log(clientName);
        });
        $('.property-row').click(function(){

            // $('#property').modal('hide');
        });
        // $('#createClient').click(function(){
        //     $('#client').modal('hide');
        //     $('#newClient').modal('show');
        // });
        // $('#createProp').click(function(){
        //     $('#property').modal('hide');
        //     $('#newProperty').modal('show');
        // });
        // $('input[name=startDate1]').change(function(){
        //     calculateDates();
        // });
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
    function selectJobtype(val){
        $('#jobType').val(val);

        console.log(val);
        // if (val == '1') {
        //     $('#tab-1 input[type=text]').attr('', true);
        //     $('#tab-2 input[type=text]').attr('', false);
        // }else if (val == '2') {
        //     $('#tab-1 input[type=text]').attr('', false);
        //     $('#tab-2 input[type=text]').attr('', true);
        // }
        $('.search-field').children('input').attr('', false);
        // var type = $('#jobType').val();
    }

    function selectTeam(obj){
        var team_ids = '';
        $(obj).children('option').each(function(){
            if ($(this).prop('selected') == true) {
                team_ids += team_ids == '' ? $(this).attr('value') : ',' + $(this).attr('value');
            }
        });
        $('#team_ids').val(team_ids);
        // console.log(team_ids);
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
        $('#subtotal_val').text('$' + total);
    }
    function deleteLineitem(obj){
         $('tr').has(obj).remove();
         var subTotal = 0;
        $('.total-val').each(function(){
            var total = $(this).text();
            with (Math){
                subTotal = parseFloat(subTotal) + parseFloat(total);
            }
        });
        // console.log(subTotal);
        $('#subtotal_val').text('$' + subTotal);
    }
    function selectService(obj){
        var row_id = $(obj).parent().find('.k-input').attr('aria-activedescendant');
        var selectedRow = $('li[id='+ row_id +']').children('div');
        var description = selectedRow.attr('data-description');
        var service_id = selectedRow.attr('data-id');
        var service_unit = selectedRow.attr('data-unit');
        var sss = $(obj).parent().parent().children('textarea').text(description);
        $(obj).parent().parent().parent().find('.service-id').val(service_id);
        $(obj).parent().parent().parent().find('.service-unit').val(service_unit);
        countCost($(obj).parent());
    }
    function saveLineitem(obj){
        var displayHtml = $('#lineItemRow').tmpl({
            service_val: 'Ceiling',
            descript_val: 'Painting ceiling',
            qty_val: '3',
            cost_val: '2',
            total_val: '5',
        }).html();
        $('tr').has(obj).replaceWith(displayHtml);

        var subTotal = 0;
        $('.total-val').each(function(){
            var total = $(this).text();
            with (Math){
                subTotal = parseInt(subTotal) + parseInt(total);
            }
        });
        // console.log(subTotal);
        $('#subtotal_val').text('$' + subTotal);

    }
    function editRow(obj){
        var addHtml = $('#editlineItemRow').tmpl({
            description: '2',
        }).html();
        $(obj).replaceWith(addHtml);
        var combobox = $('.combo-select').combobox().data('combobox');
    }
    function getProperty(obj){
        var property_id = $(obj).children('#propertyId').val();
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
            url: "{{url('/dashboard/work/jobs/select-property/')}}",
            data:{
                '_token': $('input[name=_token]').val(),
                'property_id': property_id
            },
            success: function(data){
                $('body').waitMe("hide");
                var property_id = data.property_id;
                $('#property_address').val(data.property_address);
                init_address = data.property_address;
                console.log('property_address===',data.property_address);
                var teams = data.teams;
                var addHtml = $('#select-team').tmpl({
                    teams: teams,
                }).html();
                $('.chosen-select').children().remove();
                $('.chosen-select').append(addHtml);
                $('.chosen-select').trigger("chosen:updated");
                google.maps.event.addDomListener(window, 'load', getLatitudeLongitude(initialize,init_address));
            }
        });
        $('#property_Id').val(property_id);
        var street1 = $(obj).children().children('#property_street1').text();
        var street2 = $(obj).children().children('#property_street2').text();
        var main = $(obj).children().children('#property_city').text() + ', ' +$(obj).children().children('#property_state').text() + $(obj).children().children('#property_city').text();

        $('.propertyField').show();
        $('#propertyStreet1').text(street1);
        $('#propertyStreet2').text(street2);
        $('#propertyMain').text(main);

        $('#client_name').text(clientname);
        $('#property').modal('hide');
        $('.form-submit').text('Create Job');

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
        lastDate = lastDate.setDate(lastDate.getDate() + 1);
        // console.log(newDate);
        // console.log(lastDate);

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
@if(!$data['quotes_services'])
    <tr class="Editable">
        <td>
            <i class="jobber-icon jobber-2x jobber-sort dragable-icon"></i>
        </td>
        <td>
            <input type="hidden" name="jobs[service][${i}][service_id]" class="service-id" onchange="countCost(this)" />
            <input type="text" name="jobs[service][${i}][name]" id="serviceRow${i}" value="" style="width:100%" onchange="selectService(this)" />
            <!-- <select class="input-lg form-control action-border combo-select comboService " name="jobs[service][${i}][name]"  onchange="selectService(this)">
                <option value="">Service / Product</option>
            @foreach ($data['services'] as $service) 
                <option value="{{$service->name}}" data-id="{{$service->service_id}}" data-unit="{{$service->cost}}" data-description="{{$service->description}}">{{$service->name}}</option>
            @endforeach
            </select> -->
            <textarea class="action-border input-lg form-control" name="jobs[service][${i}][description]" rows="2" ></textarea>
            <i class="hiddenIcon"></i>
        </td>
        <td>
            <input type="text" class="action-border input-lg form-control text-right service-quantity" name="jobs[service][${i}][quantity]" value="1" onkeyup="countCost(this)" />
        </td>
        <td>
            <input type="text" class="action-border input-lg form-control text-right service-unit" name="jobs[service][${i}][unit]" value="0.00"  onkeyup="countCost(this)"  />
        </td>
        <td>
            <input type="text" class="action-border input-lg form-control text-right service-total" name="jobs[service][${i}][total]" value="0.0" />
            <div class="serviceAction">
                <button type="button" class="btn btn-outline btn-sm btn-danger deleteLineitem" onclick="deleteLineitem(this)">Delete</button>
                <!-- <button type="button" class="btn btn-outline btn-sm btn-job btn-submit" 
                onclick="saveLineitem(this)">Save</button> -->
            </div>
        </td>
    </tr>
@else
    <tr class="Editable">
        <td>
            <i class="jobber-icon jobber-2x jobber-sort dragable-icon dragable-icon"></i>
        </td>
        <td>
            <input type="hidden" name="jobs[service][${i}][service_id]" class="service-id" onchange="countCost(this);" />
            <input type="text" name="jobs[service][${i}][name]" id="serviceRow${i}" value="" style="width:100%" onchange="selectService(this)" />
            <!-- <select class="input-lg form-control action-border combo-select comboService " name="jobs[service][${i}][name]"  onchange="selectService(this)">
                <option value="">Service / Product</option>
            @foreach ($data['services'] as $service) 
                <option value="{{$service->name}}" data-id="{{$service->service_id}}" data-unit="{{$service->cost}}" data-description="{{$service->description}}">{{$service->name}}</option>
            @endforeach
            </select> -->
            <textarea class="action-border input-lg form-control" name="jobs[service][${i}][description]" rows="2" ></textarea>
            <i class="hiddenIcon"></i>
        </td>
        <td>
            <p class="paragraph">---</p>
            <input type="hidden" name="jobs[service][${i}][quoted]" value="0" />
        </td>
        <td>
            <input type="text" class="action-border input-lg form-control text-right service-quantity" name="jobs[service][${i}][quantity]" value="1" onkeyup="countCost(this)" />
        </td>
        <td>
            <input type="text" class="action-border input-lg form-control text-right service-unit" name="jobs[service][${i}][unit]" value="0.00"  onkeyup="countCost(this)"  />
        </td>
        <td>
            <input type="text" class="action-border input-lg form-control text-right service-total" name="jobs[service][${i}][total]" value="0.0" />
            <div class="serviceAction">
                <button type="button" class="btn btn-outline btn-sm btn-danger deleteLineitem" onclick="deleteLineitem(this)">Delete</button>
                <!-- <button type="button" class="btn btn-outline btn-sm btn-job btn-submit" 
                onclick="saveLineitem(this)">Save</button> -->
            </div>
        </td>
    </tr>
@endif
</tbody>
</script>

<script type="text/x-jquery-tmpl" id="lineItemRow">
<tbody>
    <tr class="noEditable" onclick="editRow(this)">
        <td>
            <i class="jobber-icon jobber-2x jobber-sort dragable-icon"></i>
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
    <div class="thicklist row_holder">  
        <a class="thicklist-row property-row js-spinOnClick" href="#" onclick="getProperty(this)">
            <input type="hidden" name="propertyId" id="propertyId" value="${property_id}" />
            <p class="paragraph">
                <span id="property_street1"><small>${property_street1}</small></span>&nbsp;
                <span id="property_street2"><small>${property_street2}</small></span>&nbsp;
                <span id="property_city"><small>${property_city}</small></span>,&nbsp;
                <span id="property_state"><small>${property_state}</small></span>&nbsp;
                <span id="property_zipcode"><small>${property_zipcode}</small></span>
                <i class="fa fa-angle-right u-floatRight u-colorGreen u-a-i-fontsize"></i>
            </p>
        </a>  
    </div>
</div>
</script>

<script type="text/x-jquery-tmpl" id="select-team">
<select>
    @{{each teams}}
        <option value="${teams[$index].team_member_id}">${teams[$index].fullname}</option>
    @{{/each}}
</select>
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