@extends('layout.menu')
@section('content')
<!-- <link rel="stylesheet" type="text/css" href="{{url('public/css/getjobber.css')}}"> -->
<link rel="stylesheet" type="text/css" href="{{url('public/css/plugins/chosen/chosen.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/plugins/combobox/bootstrap-combobox.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/custom.css')}}">
		<!-- <div class="page-heading">
            <div class="col-sm-4">
                <h1>Jobs</h1>
            </div>
            <a href="/work/jobs/new" class="btn btn-new">+ New Job</a>
        </div> -->
<div class="col-md-12">
    @if(isset($data['success'])) 
      <br>
      <div class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        {{$data['success']}}
      </div>
    @endif
</div>
<div class="col-md-12 u-marginBottom u-marginTop">
    @if(Session::get('permission') != '4')
    <div class="u-block u-floatRight" style="position: relative;">
        <a  class="u-floatRight btn btn-job u-textBold" data-toggle="dropdown" style="margin-left: -2px">Actions
            &nbsp;&nbsp;<i class="fa fa-angle-down"></i>
        </a>

    @if($data['status'] == 1)
        <a class="u-floatRight btn assign-btn u-textBold no-rightRadius visitView" data-id="{{$data['visits']['over_due'][0]->visit_id}}" style="height: 32px;">Show Late Visit</a>
    @elseif($data['status'] == 4)
        <a class="u-floatRight btn assign-btn u-textBold no-rightRadius" data-id="{{$data['job'][0]->job__id}}" onclick="closeJob(this);" style="height: 32px;">Close Job</a>
    @elseif($data['status'] == 5)
        @if(Session::get('permission') != '5')
        <a href="{{url('/dashboard/work/invoices/newinvoice')}}/{{$data['job'][0]->client_id}}?job_id={{$data['job'][0]->job__id}}" class="u-floatRight btn assign-btn u-textBold no-rightRadius" style="height: 32px;">Generate Invoice</a>
        @endif
    @endif
        <ul class="dropdown-menu dropdown-action" style="right: 0">
        @if($data['job'][0]->status == '1')
            <li class="u-borderBottom">
                <a href="{{url('dashboard/work/jobs/edit')}}/{{$data['job'][0]->job__id}}" class="paragraph u-block">
                    <i class="jobber-icon jobber-edit jobber-2x u-marginRightSmall u-colorGreyBlue"></i>
                    Edit
                </a>
            </li>
            <li>
                <a class="paragraph u-block" data-id="{{$data['job'][0]->job__id}}" onclick="closeJob(this);">
                    <i class="jobber-icon jobber-job jobber-2x u-marginRightSmall" style="color: #bbc520"></i>
                    Close Job
                </a>
            </li>
        @else
            <li>
                <a class="paragraph u-block" data-id="{{$data['job'][0]->job__id}}" onclick="reopenJob(this);">
                    <i class="jobber-icon jobber-redo jobber-2x u-marginRightSmall"></i>
                    Re-Open job
                </a>
            </li>
        @endif
            @if(Session::get('permission') != '5')
            <li>
                <a href="{{url('/dashboard/work/invoices/add')}}/{{$data['job'][0]->client_id}}" class="paragraph u-block">
                    <i class="jobber-icon jobber-invoice jobber-2x u-marginRightSmall"></i>
                    Generate Invoice
                </a>
            </li>
            @endif
            <li>
                <a href="{{ url('/dashboard/work/jobs/generate-pdf/')}}/{{$data['job'][0]->job__id}}" class="paragraph u-block">
                    <i class="jobber-icon jobber-pdf jobber-2x u-marginRightSmall"></i>
                    Download PDF
                </a>
            </li>
        </ul>
    </div>
    @endif
    <a href="{{ url('/dashboard/work/jobs/generate-pdf/')}}/{{$data['job'][0]->job__id}}" class="btn btn-outline btn-default u-floatRight u-marginRightSmall u-colorGreyBlue" style="padding: 1px 10px;"><i class="jobber-icon jobber-printer jobber-2x"></i></a>
</div>
<div class="col-md-12">
    <div class="ibox">
        <div class="ibox-title heading-borderTop">
            <div class="row">
                <div class="col-md-12">
                    <i class="jobber-icon jobber-job jobber-2x icon-circle icon-bg icon--green" style="color:white;"></i>
                @if($data['status'] == 1)
                    <span class="visitNotice inlineLabel--red">HAS A LATE VISIT</span>
                @elseif($data['status'] == 2)
                    <span class="visitNotice inlineLabel--green">TODAY</span>
                @elseif($data['status'] == 3)
                    <span class="visitNotice inlineLabel--green">UPCOMING</span>
                @elseif($data['status'] == 4)
                    <span class="visitNotice inlineLabel--orange">ACTION REQUIRED</span>
                @elseif($data['status'] == 5)
                    <span class="visitNotice inlineLabel--orange">REQUIRES INVOICING</span>
                @elseif($data['status'] == 6)
                    <span class="visitNotice inlineLabel--blue">ARCHIVED</span>
                @elseif($data['status'] == 7)
                    <span class="visitNotice inlineLabel--orange">UNSCHEDULED</span>
                @endif
                    <span class="headingTwo u-floatRight u-textNormal u-marginTop">Job #{{$data['job'][0]->job__id}}</span>
                </div>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
            <!-- <form class="work_order" action="" id="new_work_order" method="post"> -->
            {{ csrf_field() }}
                <div class="col-md-7">
                    <div class="job-client">
                        <h1 class="headingOne">Mr. {{ucfirst($data['job'][0]->first_name)}} {{ucfirst($data['job'][0]->last_name)}}</h1>
                        <span class="headingTwo u-textNormal u-marginTopSmall" id="jobDescription">{{$data['job'][0]->description}}</span>
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="headingOne u-marginTopBiggest">Property address</h4>
                                <div class="col-md-3 no-padding">
                                    <a href="{{url('/dashboard/calendar/map')}}" class="btn button-green">
                                        <i class="jobber-icon jobber-address jobber-2x"></i>
                                    </a>
                                    
                                </div>
                                <div class="addressText col-md-8 no-padding">
                                    <p class="paragraph">{{$data['job'][0]->street1}} {{$data['job'][0]->street2}}</p>
                                    <p class="paragraph">{{$data['job'][0]->city}} {{$data['job'][0]->state}},  {{$data['job'][0]->zip_code}}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4 class="headingOne u-marginTopBiggest">Contact details</h4>
                            @if(isset($data['contact']))
                                @foreach($data['contact'] as $one)
                                    @if($one->type == 1)
                                        <p class="paragraph">{{$one->value}}</p>
                                    @else
                                        <a href="" class="add-one no-padding u-textSmaller">{{$one->value}}</a>
                                    @endif
                                @endforeach
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="job-detail">
                        <h3 class="headingFive" style="margin-bottom: 30px;">Job details</h3>
                        <table class="jobDtailTable u-grid10">
                        @if($data['job'][0]->job_type == '1')
                            <tr>
                                <td><p class="paragraph headingTwo">Job type</p>
                                </td>
                                <td><p class="paragraph">
                                    One-off Job
                                </p>
                                </td>
                            </tr>
                            @if($data['job'][0]->unscheduled == '0')
                                <tr>
                                    <td><p class="paragraph headingTwo">Started on</p>
                                    </td>
                                    <td><p class="paragraph">{{$data['job'][0]->date_started}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="paragraph headingTwo">Ends on</p>
                                    </td>
                                    <td>
                                    <p class="paragraph">{{$data['job'][0]->date_ended}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td><p class="paragraph headingTwo">Billing frequency</p>
                                    </td>
                                    <td><p class="paragraph">Upon job completion</p>
                                    </td>
                                </tr>
                                @if($data['job'][0]->visit_frequence == '1')
                                    <tr>
                                        <td><p class="paragraph headingTwo">Schedule</p>
                                        </td>
                                        <td>
                                            <p class="paragraph">Daily</p>
                                        </td>
                                    </tr>
                                @elseif($data['job'][0]->visit_frequence == '2')
                                    <tr>
                                        <td><p class="paragraph headingTwo">Schedule</p>
                                        </td>
                                        <td>
                                            <p class="paragraph">Weekly</p>
                                        </td>
                                    </tr>
                                @elseif($data['job'][0]->visit_frequence == '3')
                                    <tr>
                                        <td><p class="paragraph headingTwo">Schedule</p>
                                        </td>
                                        <td>
                                            <p class="paragraph">Monthly</p>
                                        </td>
                                    </tr>
                                @elseif($data['job'][0]->visit_frequence == '4')
                                    <tr>
                                        <td><p class="paragraph headingTwo">Schedule</p>
                                        </td>
                                        <td>
                                            <p class="paragraph">One Time</p>
                                        </td>
                                    </tr>
                                @endif
                            @else
                                <tr>
                                    <td><p class="paragraph headingTwo">Schedule</p>
                                    </td>
                                    <td><p class="paragraph">Not set</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td><p class="paragraph headingTwo">Billing frequency</p>
                                    </td>
                                    <td><p class="paragraph">Upon job completion</p>
                                    </td>
                                </tr>
                            @endif
                            
                            @if($data['job'][0]->quote_id)
                                <tr>
                                    <td><p class="paragraph headingTwo">From quote</p>
                                    </td>
                                    <td><p class="paragraph"><a href="{{url('dashboard/work/quotes/info')}}/{{$data['job'][0]->quote_id}}">Quote#{{$data['job'][0]->quote_id}}</a></p>
                                    </td>
                                </tr>
                            @endif
                        @else
                            <tr>
                                <td><p class="paragraph headingTwo">Job type</p>
                                </td>
                                <td><p class="paragraph">
                                    Recurring Job
                                </p>
                                </td>
                            </tr>
                            <tr>
                                <td><p class="paragraph headingTwo">Started on</p>
                                </td>
                                <td><p class="paragraph">{{$data['job'][0]->date_started}}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="paragraph headingTwo">Lasts for</p>
                                </td>
                                <td>
                                <p class="paragraph">{{$data['job'][0]->duration}} 
                                @if($data['job'][0]->duration_unit == '1')
                                    days
                                @elseif($data['job'][0]->duration_unit == '2')
                                    weeks
                                @elseif($data['job'][0]->duration_unit == '3')
                                    months
                                @elseif($data['job'][0]->duration_unit == '4')
                                    years
                                @endif
                                </p>
                                </td>
                            </tr>
                            <tr>
                                <td><p class="paragraph headingTwo">Billing frequency</p>
                                </td>
                                <td><p class="paragraph">
                                @if($data['job'][0]->billing_frequency == '0')
                                    As needed
                                @elseif($data['job'][0]->billing_frequency == '1')
                                    After every visit
                                @elseif($data['job'][0]->billing_frequency == '2')
                                    Upon job completion
                                @elseif($data['job'][0]->billing_frequency == '3')
                                    Monthly on the last day of the month
                                @endif
                                </p>
                                </td>
                            </tr>
                            <tr>
                                <td><p class="paragraph headingTwo">Billing type</p>
                                </td>
                                <td><p class="paragraph">
                                @if($data['job'][0]->invoicing == '0')
                                    Per visit
                                @else
                                    Fixed price
                                @endif
                                </p>
                                </td>
                            </tr>
                            @if($data['job'][0]->visit_frequence == '1')
                                <tr>
                                    <td><p class="paragraph headingTwo">Schedule</p>
                                    </td>
                                    <td>
                                        <p class="paragraph">Weekly on {{date('l', strtotime($data['job'][0]->date_started))}}</p>
                                    </td>
                                </tr>
                            @elseif($data['job'][0]->visit_frequence == '2')
                                <tr>
                                    <td><p class="paragraph headingTwo">Schedule</p>
                                    </td>
                                    <td>
                                        <p class="paragraph">Every 2 weeks on {{date('l', strtotime($data['job'][0]->date_started))}}</p>
                                    </td>
                                </tr>
                            @elseif($data['job'][0]->visit_frequence == '3')
                                <tr>
                                    <td><p class="paragraph headingTwo">Schedule</p>
                                    </td>
                                    <td>
                                        <p class="paragraph">Monthly on the {{date('jS', strtotime($data['job'][0]->date_started))}} day of the month</p>
                                    </td>
                                </tr>
                            @elseif($data['job'][0]->visit_frequence == '3')
                                <tr>
                                    <td><p class="paragraph headingTwo">Schedule</p>
                                    </td>
                                    <td>
                                        <p class="paragraph">One Time</p>
                                    </td>
                                </tr>
                            @endif
                            @if($data['job'][0]->quote_id)
                                <tr>
                                    <td><p class="paragraph headingTwo">From quote</p>
                                    </td>
                                    <td><p class="paragraph"><a href="{{url('dashboard/work/quotes/info')}}/{{$data['job'][0]->quote_id}}">Quote#{{$data['job'][0]->quote_id}}</a></p>
                                    </td>
                                </tr>
                            @endif
                        @endif
                            <!-- <tr>
                                <td><p class="paragraph headingTwo">Schedule</p></td>
                                <td><p class="paragraph">Daily</p></td>
                            </tr> -->
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel blank-panel jobTypePanel">
                        <div class="row">
                            <div class="col-md-12" id="lineItem">
                                <div class="ibox">
                                    <div class="ibox-title">
                                        <h3 class="headingTwo">Line items</h3>
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
                                            <?php $total = 0; $quotedTotal = 0;?>
                                            @if(count($data['service']) != 0)
                                                @if(!$data['job'][0]->quote_id)
                                                    @foreach($data['service'] as $service)
                                                        <tr class="noEditable" onclick="editRow(this)">
                                                            <td>
                                                                <i class="jobber-icon jobber-sort jobber-2x dragable-icon"></i>
                                                            </td>
                                                            <td>
                                                                <h3 class="headingTwo u-colorGreen service-val text-left">{{$service->service_name}}</h3>
                                                                <p class="paragraph descript-val text-left"><small>{{$service->service_description}}</small></p>
                                                            </td>
                                                            <td>
                                                                <p class="paragraph qty-val"><small>{{$service->quantity}}</small></p>
                                                            </td>
                                                            <td>
                                                                <p class="paragraph cost-val"><small>${{$service->cost}}</small></p>
                                                            </td>
                                                            <td>
                                                                <p class="paragraph total-val"><small>${{$service->quantity*$service->cost}}</small></p>
                                                            </td>
                                                        </tr>
                                                    <?php $total += $service->quantity*$service->cost ?>
                                                    @endforeach
                                                @else
                                                    @foreach($data['service'] as $service)
                                                        <tr class="noEditable" onclick="editRow(this)">
                                                            <td>
                                                                <i class="jobber-icon jobber-sort jobber-2x dragable-icon"></i>
                                                            </td>
                                                            <td>
                                                                <h3 class="headingTwo u-colorGreen service-val text-left">{{$service->service_name}}</h3>
                                                                <p class="paragraph descript-val text-left"><small>{{$service->service_description}}</small></p>
                                                            </td>
                                                            <td>
                                                            @if($service->quoted == 0)
                                                                <p class="paragraph">_</p>
                                                            @else
                                                                <p class="paragraph"><small>${{$service->quoted}}</small></p>
                                                            @endif
                                                            </td>
                                                            <td>
                                                                <p class="paragraph qty-val"><small>{{$service->quantity}}</small></p>
                                                            </td>
                                                            <td>
                                                                <p class="paragraph cost-val"><small>${{$service->cost}}</small></p>
                                                            </td>
                                                            <td>
                                                                <p class="paragraph total-val"><small>${{$service->quantity*$service->cost}}</small></p>
                                                            </td>
                                                        </tr>
                                                    <?php $total += $service->quantity*$service->cost;
                                                        $quotedTotal += $service->quoted?>
                                                    @endforeach
                                                @endif
                                            @endif
                                            </tbody>
                                        </table>
                                        <!-- <a href="#" class="btn-job addItem-btn">Add Line item</a> -->
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
                            <div class="col-md-12" id="visits">
                                <div class="ibox">
                                    <div class="ibox-title">
                                        <h3 class="headingTwo">Visits</h3>
                                    @if(Session::get('permission') != '4')
                                        <a href="" class="assign-btn assign-btn-sm right-btn no-border" id="new_visit">+ New Visit</a>
                                    @endif
                                    </div>
                                    <div class="ibox-content no-padding">
                                        <div class="thicklist row_holder ">
                                        @if(count($data['visits']['over_due']) == 0 && count($data['visits']['today']) == 0 && count($data['visits']['upcoming']) == 0 && count($data['visits']['complete']) == 0)
                                            <div class="row no-margin u-marginBottom u-marginTop">
                                                <div class="col-md-1">
                                                    <i class="jobber-icon jobber-visit jobber-2x icon-circle icon-bg icon--gray"></i>
                                                </div>
                                                <div class="col-md-10">
                                                    <p class="paragraph u-textBold">No visits created</p>
                                                    <p class="paragraph">Get the team to work by scheduling a visit</p>
                                                    <div class="u-marginTopSmall">
                                                    @if(Session::get('permission') != '4')
                                                        <a href="" class="assign-btn assign-btn-sm"  data-toggle="modal" data-target="#visitCreate">New Visit</a>
                                                    @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            @if(count($data['visits']['over_due']) != 0)
                                                <h3 class="thicklist-sectionHeader section_header has_a_late_visit">Overdue</h3>
                                                @foreach($data['visits']['over_due'] as $visit)
                                                    <div class="thicklist-row visit-row">
                                                        <div class="row">
                                                            <div class="large-expand columns col-xs-1 ">
                                                                <label class="check-element">
                                                                    <input type="checkbox" class="check-button" name="visit-action" value="{{$visit->visit_id}}">
                                                                    <i class="checkbox fa"></i>
                                                                </label>
                                                            </div>
                                                            <div class="columns col-xs-11 visitView" data-id="{{$visit->visit_id}}">
                                                                <div class="row">
                                                                    <div class="columns col-xs-2">
                                                                        <span class="thicklist-text headingTwo paragraph u-colorRed">{{$visit->start_date}}&nbsp;&nbsp;&nbsp;
                                                                        <?php if($visit->start_time=='00:00'&&$visit->end_time=='00:00'){
                                                                                echo '';
                                                                            }else{
                                                                                echo $visit->start_time;
                                                                            }
                                                                        ?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="columns col-xs-5">
                                                                    @if($visit->status == 2)
                                                                        <p class="paragraph"><strong>Completed on :</strong>&nbsp;&nbsp; {{$visit->completed_on}}</p>
                                                                    @else
                                                                        <p class="paragraph">{{$visit->details}}</p>
                                                                    @endif
                                                                    </div>
                                                                    <div class="large-expand columns col-xs-5">
                                                                    @if(count($visit->visit_assign) == 0)
                                                                        <p class="paragraph">Not assigned yet</p>
                                                                    @else
                                                                        <p class="paragraph">Assigned to
                                                                            {{ucfirst($visit->visit_assign[0])}}
                                                                        <?php
                                                                            for ($i=1; $i < count($visit->visit_assign); $i++) { 
                                                                                echo " and ".ucfirst($visit->visit_assign[$i]);
                                                                            }
                                                                        ?>
                                                                        </p>
                                                                    @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                            @if(count($data['visits']['today']) != 0)
                                                <h3 class="thicklist-sectionHeader section_header">Today</h3>
                                                @foreach($data['visits']['today'] as $visit)
                                                    <div class="thicklist-row visit-row">
                                                        <div class="row">
                                                            <div class="large-expand columns col-xs-1 ">
                                                                <label class="check-element">
                                                                    <input type="checkbox" class="check-button" name="visit-action" value="{{$visit->visit_id}}">
                                                                    <i class="checkbox fa"></i>
                                                                </label>
                                                            </div>
                                                            <div class="columns col-xs-11 visitView" data-id="{{$visit->visit_id}}">
                                                                <div class="row">
                                                                    <div class="columns col-xs-2">
                                                                        <span class="thicklist-text headingTwo paragraph">{{$visit->start_date}}&nbsp;&nbsp;&nbsp;
                                                                        <?php if($visit->start_time=='00:00'&&$visit->end_time=='00:00'){
                                                                                echo '';
                                                                            }else{
                                                                                echo $visit->start_time;
                                                                            }
                                                                        ?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="columns col-xs-5">
                                                                    @if($visit->status == 2)
                                                                        <p class="paragraph"><strong>Completed on :</strong>&nbsp;&nbsp; {{$visit->completed_on}}</p>
                                                                    @else
                                                                        <p class="paragraph">{{$visit->details}}</p>
                                                                    @endif
                                                                    </div>
                                                                    <div class="large-expand columns col-xs-5">
                                                                    @if(count($visit->visit_assign) == 0)
                                                                        <p class="paragraph">Not assigned yet</p>
                                                                    @else
                                                                        <p class="paragraph">Assigned to
                                                                            {{ucfirst($visit->visit_assign[0])}}
                                                                        <?php
                                                                            for ($i=1; $i < count($visit->visit_assign); $i++) { 
                                                                                echo " and ".ucfirst($visit->visit_assign[$i]);
                                                                            }
                                                                        ?>
                                                                        </p>
                                                                    @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                            @if(count($data['visits']['upcoming']) != 0)
                                                <h3 class="thicklist-sectionHeader section_header">Upcoming</h3>
                                                @foreach($data['visits']['upcoming'] as $visit)
                                                    <div class="thicklist-row visit-row">
                                                        <div class="row">
                                                            <div class="large-expand columns col-xs-1 ">
                                                                <label class="check-element">
                                                                    <input type="checkbox" class="check-button" name="visit-action" value="{{$visit->visit_id}}">
                                                                    <i class="checkbox fa"></i>
                                                                </label>
                                                            </div>
                                                            <div class="columns col-xs-11 visitView" data-id="{{$visit->visit_id}}">
                                                                <div class="row">
                                                                    <div class="columns col-xs-2">
                                                                        <span class="thicklist-text headingTwo paragraph">{{$visit->start_date}}&nbsp;&nbsp;&nbsp;
                                                                        <?php if($visit->start_time=='00:00'&&$visit->end_time=='00:00'){
                                                                                echo '';
                                                                            }else{
                                                                                echo $visit->start_time;
                                                                            }
                                                                        ?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="columns col-xs-5">
                                                                    @if($visit->status == 2)
                                                                        <p class="paragraph"><strong>Completed on :</strong>&nbsp;&nbsp; {{$visit->completed_on}}</p>
                                                                    @else
                                                                        <p class="paragraph">{{$visit->details}}</p>
                                                                    @endif
                                                                    </div>
                                                                    <div class="large-expand columns col-xs-5">
                                                                    @if(count($visit->visit_assign) == 0)
                                                                        <p class="paragraph">Not assigned yet</p>
                                                                    @else
                                                                        <p class="paragraph">Assigned to
                                                                            {{ucfirst($visit->visit_assign[0])}}
                                                                        <?php
                                                                            for ($i=1; $i < count($visit->visit_assign); $i++) { 
                                                                                echo " and ".ucfirst($visit->visit_assign[$i]);
                                                                            }
                                                                        ?>
                                                                        </p>
                                                                    @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                            @if(count($data['visits']['complete']) != 0)
                                                <h3 class="thicklist-sectionHeader section_header today upcoming">Completed</h3>
                                                @foreach($data['visits']['complete'] as $visit)
                                                    <div class="thicklist-row visit-row" 
                                                    <?php echo $visit->status == 2 ?  'style="opacity: 0.5"' : '';?>>
                                                        <div class="row">
                                                            <div class="large-expand columns col-xs-1 ">
                                                                <label class="check-element">
                                                                    <input type="checkbox" class="check-button" name="visit-action" value="{{$visit->visit_id}}" checked="">
                                                                    <i class="checkbox fa"></i>
                                                                </label>
                                                            </div>
                                                            <div class="columns col-xs-11 visitView" data-id="{{$visit->visit_id}}">
                                                                <div class="row">
                                                                    <div class="columns col-xs-2">
                                                                        <span class="thicklist-text headingTwo paragraph">{{$visit->start_date}}&nbsp;&nbsp;&nbsp;
                                                                        <?php if($visit->start_time=='00:00'&&$visit->end_time=='00:00'){
                                                                                echo '';
                                                                            }else{
                                                                                echo $visit->start_time;
                                                                            }
                                                                        ?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="columns col-xs-5">
                                                                    @if($visit->status == 2)
                                                                        <p class="paragraph"><strong>Completed on :</strong>&nbsp;&nbsp; {{$visit->completed_on}}</p>
                                                                    @else
                                                                        <p class="paragraph">{{$visit->details}}</p>
                                                                    @endif
                                                                    </div>
                                                                    <div class="large-expand columns col-xs-5">
                                                                        <p class="paragraph">Completed by {{ucfirst($visit->username)}}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" id="teamcost">
                                <div class="ibox">
                                    <div class="ibox-title">
                                        <h3 class="headingTwo">Timesheets</h3>
                                        <a href="" class=" assign-btn assign-btn-sm right-btn  no-border newTimesheet">+ Add Time</a>
                                        <!-- <div class="dropdown-box">
                                            <a href="" class="dropdown-toggle assign-btn assign-btn-sm right-btn  no-border" data-toggle="dropdown" data-target="newbilling">New
                                            <i class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown-menu dropdown-user tax-dropdown" id="newbilling">
                                                <li>
                                                    <label class="radio-element">
                                                        <input type="radio" class="check-button" name="" value="1" checked=""  id="" data-id="" data-tax="0.2" data-name="tax1 (0.5%) (Default)">
                                                        <i class="fa"></i>
                                                        <span>
                                                            Time Entry
                                                        </span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="radio-element">
                                                        <input type="radio" class="check-button" name="" value="2" id="" data-id="" data-tax="0.2" data-name="tax2 (0.5%)">
                                                        <i class="fa"></i>
                                                        <span>
                                                            Expense
                                                        </span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div> -->
                                    </div>
                                    <div class="ibox-content no-padding">
                                        <!-- <div class="panel-heading no-padding">
                                            <div class="panel-options">
                                                <ul class="nav nav-tabs">
                                                    <li class="active">
                                                        <a data-toggle="tab" href="#team1" class="selectTab">
                                                        <p class="paragraph text-center">
                                                           Timesheets
                                                        </p>
                                                    </a></li>
                                                    <li class="">
                                                        <a data-toggle="tab" href="#team2" class="selectTab">
                                                        <p class="paragraph text-center">
                                                            Expenses
                                                        </p>
                                                    </a></li>
                                                </ul>
                                            </div>
                                        </div> -->
                                        <div class="panel-body no-padding">
                                            <div class="tab-content">
                                                <div id="time_sheets" class="tab-pane active">
                                                @if(count($data['timesheets'])=='0')
                                                    <div class="row no-margin u-marginBottom u-marginTop">
                                                        <div class="col-md-1">
                                                            <i class="jobber-icon jobber-timer jobber-2x icon-circle icon-bg icon--gray"></i>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <p class="paragraph u-textBold">No time tracked</p>
                                                            <p class="paragraph">Get a clearer picture of labour costs by tracking your team's time</p>
                                                            <div class="u-marginTopSmall">
                                                                <a href="" class="assign-btn assign-btn-sm newTimesheet">New Time Entry</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="thicklist row_holder ">  
                                                    @foreach($data['timesheets'] as $timesheet)
                                                        <a class="thicklist-row forTime" data-id="{{$timesheet->id}}" onclick="getTimesheet(this);">
                                                            <div class="row">
                                                                <div class="col-sm-4 ">
                                                                    <h4 class="headingTwo u-marginBottomSmallest">{{$timesheet->username}}</h3>
                                                                    <p class="paragraph">{{$timesheet->save_date}}</p>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <p class="paragraph u-marginTopSmall">{{$timesheet->note}}</p>
                                                                </div>
                                                                <div class="col-sm-4 text-right">
                                                                    <p class="headingTwo paragraph">{{$timesheet->duration}}</p>
                                                                    <p class="paragraph">{{$timesheet->start_time}} to {{$timesheet->end_time}}</p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                    </div>
                                                    <div class="text-right u-marginTopSmall">
                                                        <h3 class="headingTwo" style="padding-right: 15px;">Total hours  <span id="totaltime">{{$data['totalTime'][0]->total}}</span></h3>
                                                    </div>
                                                @endif
                                                </div>
                                                <!-- <div id="team2" class="tab-pane">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <i class="glyphicon glyphicon-wrench icon-circle icon-bg icon--gray"></i>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <p class="paragraph u-textBold">No expenses logged</p>
                                                            <p class="paragraph">Avoid lost receipts and forgotten expenses</p>
                                                            <div class="u-marginTopSmall">
                                                                <a href="#" class="assign-btn assign-btn-sm">New Expense</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" id="billing">
                                <div class="ibox">
                                    <div class="ibox-title">
                                        <h3 class="headingTwo">Billing <p class="paragraph" style="display: inline-block;font-weight: 100;">— when job completed</p></h3>
                                    @if(Session::get('permission') != '4')
                                        <div class="dropdown-box">
                                            <a href="" class="dropdown-toggle assign-btn assign-btn-sm right-btn  no-border" data-toggle="dropdown" href="" >New
                                            <i class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown-menu dropdown-action" style="right: 0">
                                            @if(Session::get('permission') != '5')
                                                <li class="u-borderBottom">
                                                    <a href="{{url('/dashboard/work/invoices/newinvoice')}}/{{$data['job'][0]->client_id}}" class="paragraph u-block">
                                                        <i class="jobber-icon jobber-invoice jobber-2x u-marginRightSmall u-colorGreyBlue"></i>
                                                        Invoice
                                                    </a>
                                                </li>
                                            @endif
                                                <li class="u-borderBottom">
                                                    <a href="" class="paragraph u-block new_invoice_reminder" id="">
                                                        <i class="jobber-icon jobber-reminder jobber-2x u-marginRightSmall u-colorGreyBlue"></i>
                                                        Invoice Reminder
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                    </div>
                                    <div class="ibox-content no-padding">
                                    @if(count($data['invoices'])=='0' && count($data['reminders']) == '0')
                                        <div class="row no-margin u-marginBottom u-marginTop">
                                            <div class="col-md-1">
                                                <i class="jobber-icon jobber-invoice jobber-2x icon-circle icon-bg icon--gray"></i>
                                            </div>
                                            <div class="col-md-10">
                                                <p class="paragraph u-textBold">No invoices or reminders</p>
                                            @if(Session::get('permission') != '4')
                                                <p class="paragraph">Fewer invoices slip through the cracks when you set up reminders</p>
                                                <div class="u-marginTopSmall">
                                                @if(Session::get('permission') != '5')
                                                    <a href="{{url('/dashboard/work/invoices/newinvoice')}}/{{$data['job'][0]->client_id}}" class="assign-btn assign-btn-sm">New Invoice</a>
                                                     &nbsp;&nbsp;or&nbsp;&nbsp;
                                                @endif
                                                    <a href="" class="assign-btn assign-btn-sm new_invoice_reminder">New Invoice Reminder</a>
                                                </div>
                                            @endif
                                            </div>
                                        </div>
                                    @else
                                        <div class="thicklist row_holder ">
                                        <?php $total_invoice=0;?>
                                        @foreach($data['invoices'] as $invoice)
                                            <a class="thicklist-row forTime" href="{{url('/dashboard/work/invoices/info')}}/{{$invoice->invoice_id}}">
                                                <div class="row">
                                                    <div class="col-sm-3 ">
                                                        <h4 class="headingTwo u-marginBottomSmallest">
                                                        #{{$invoice->invoice_id}} : {{$invoice->first_name}} {{$invoice->last_name}}

                                                        </h4>
                                                        <div class="inlineLabel u-marginBottomSmall"><span>Draft</span></div>
                                                        <!-- <p class="paragraph"></p> -->
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <p class="paragraph u-marginTopSmall"></p>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <p class="paragraph">{{$invoice->description}}</p>
                                                    </div>
                                                    <div class="col-sm-3 text-right">
                                                        <h4 class="paragraph headingTwo">${{$invoice->total}}</h4>
                                                    </div>
                                                </div>
                                            </a>
                                            <?php $total_invoice = $total_invoice + $invoice->total; ?>
                                        @endforeach
                                        @foreach($data['reminders'] as $reminder)
                                            <a class="thicklist-row" data-id="{{$reminder->invoice_reminder_id}}" onclick="reminderView(this);">
                                            @if($reminder->start_date == $reminder->end_date)
                                                @if($reminder->start_time == '')
                                                    <input type="hidden" name="reminder_duration" value="{{$reminder->start_date}} Anytime">
                                                @else
                                                    <input type="hidden" name="reminder_duration" value="{{$reminder->start_date}} {{$reminder->start_time}} - {{$reminder->end_time}}">
                                                @endif
                                            @else
                                                <input type="hidden" name="reminder_duration" value="{{$reminder->start_date}} - {{$reminder->end_date}}">
                                            @endif
                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        <h4 class="headingTwo u-marginBottomSmallest">
                                                            Invoice reminder {{$data['job'][0]->first_name}} {{$data['job'][0]->last_name}} for job #{{$data['job'][0]->job__id}}
                                                        </h4>
                                                        <!-- <p class="paragraph">
                                                            re: {{$data['job'][0]->first_name}} {{$data['job'][0]->last_name}}
                                                        </p> -->
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p class="paragraph u-marginTopSmall" id="reminder_detail">{{$reminder->details}}</p>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <p class="paragraph">
                                                        @if($reminder->start_date)
                                                            {{$reminder->start_date}} 
                                                            @if($reminder->start_time)
                                                                {{$reminder->start_time}} 
                                                            @endif
                                                        @else
                                                            Unscheduled
                                                        @endif
                                                        </p>
                                                        @if(count($reminder->team_members) == 0)
                                                            <p class="paragraph">Not assigned yet</p>
                                                        @else
                                                            <p class="paragraph">Assigned to
                                                                {{ucfirst($reminder->team_members[0])}}
                                                            <?php
                                                                for ($i=1; $i < count($reminder->team_members); $i++) { 
                                                                    echo " and ".ucfirst($reminder->team_members[$i]);
                                                                }
                                                            ?>
                                                            </p>
                                                        @endif
                                                    </div>
                                                    
                                                </div>
                                            </a>
                                        @endforeach
                                        </div>
                                        <div class="text-right u-marginTopSmall">
                                            <h4 class="headingTwo" style="padding-right: 15px;">Billed $<span id="">{{$total_invoice}}</span></h4>
                                        </div>
                                    @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" id="noteAttach">
                                <div class="ibox">
                                    <div class="ibox-title">
                                        <h3 class="headingTwo">Service details and Remarks</h3>
                                    </div>
                                    <div class="ibox-content">
                                    <form id="service_remark">
                                    {{ csrf_field() }}
                                        <input type="hidden" name="job_id" value="{{$data['job'][0]->job__id}}">
                                    @if(count($data['notes']) == 0 )
                                        <input type="hidden" name="note_id" value="">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 class="headingFive">Service Performed</h3>
                                                <textarea class="action-border input-lg form-control note" name="service_perform" value="" rows="3" placeholder="Service performed" onkeyup="show_savebtn(this);"></textarea>
                                            </div>
                                            <div class="col-md-12">
                                                <h3 class="headingFive u-marginTop">Remarks</h3>
                                                <textarea class="action-border input-lg form-control note" name="remarks" value="" rows="3" placeholder="Remarks"  onkeyup="show_savebtn(this);"></textarea>
                                            </div>
                                            <div class="col-md-12 text-right u-marginTop">
                                                <button class="btn btn-job" id="save_note" style="display: none;">Save</button>
                                            </div>
                                        </div>
                                    @else
                                        <input type="hidden" name="note_id" value="{{$data['notes'][0]->note_id}}">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 class="headingFive">Service Performed</h3>
                                                <textarea class="action-border input-lg form-control note" name="service_perform" value="" rows="3" placeholder="Service performed" onkeyup="show_savebtn(this);">{{$data['notes'][0]->service_perform}}</textarea>
                                            </div>
                                            <div class="col-md-12">
                                                <h3 class="headingFive u-marginTop">Remarks</h3>
                                                <textarea class="action-border input-lg form-control note" name="remarks" value="" rows="3" placeholder="Remarks"  onkeyup="show_savebtn(this);">{{$data['notes'][0]->remark}}</textarea>
                                            </div>
                                        @if(Session::get('permission') != '4')
                                            <div class="col-md-12 text-right u-marginTop">
                                                <button class="btn btn-job" id="save_note" style="display: none;">Save</button>
                                            </div>
                                        @endif
                                        </div>
                                    @endif
                                        <!-- <div class="text-right u-marginTop">
                                            <label title="Upload image file" for="attachFile" class="btn btn-sm button--greyBlue button--ghost u-textBold ">
                                                <input type="file" accept="/*" name="file" id="attachFile" class="hide">
                                                Add Attachment
                                            </label>
                                        </div> -->
                                    </form>    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- </form> -->
            </div>
        </div>
    </div>
    <!-- Modal1 -->
    <div class="modal inmodal" id="visitView" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left">Visit</h4>
            </div>
            <div class="modal-body no-padding">
                <div class="row no-margin u-marginBottomSmall u-marginTop">
                    <div class="col-md-6 u-borderRight">
                        <h2 class="headingThree u-marginTopSmallest u-marginBottom" id="visit_title">{{$data['job'][0]->first_name}} {{$data['job'][0]->last_name}}</h2>
                        <p class="paragraph">
                            {{$data['job'][0]->first_name}} {{$data['job'][0]->last_name}}
                        </p>
                        <p class="paragraph">
                            {{$data['job'][0]->street1}} {{$data['job'][0]->street2}}
                        </p>
                        <p class="paragraph">
                            {{$data['job'][0]->city}} {{$data['job'][0]->state}},  {{$data['job'][0]->zip_code}}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h4 class="headingThree u-marginTopSmaller">
                            <i class="jobber-icon jobber-2x jobber-calendar u-marginRightSmall"></i>
                            <span id="visitSchedule"></span>
                            <!-- {{$data['job'][0]->date_started}} {{$data['job'][0]->time_started==''? 'Anytime': ' '.$data['job'][0]->time_started}} -->
                        </h4>
                        <a class="paragraph u-marginBottomSmallest u-block">
                            <i class="jobber-icon jobber-2x jobber-phone u-marginRightSmall u-colorGreen"></i>
                            123-456-7890
                        </a>
                        <a class="paragraph u-block">
                            <i class="jobber-icon jobber-2x jobber-direction u-colorGreen u-marginRightSmall"></i>
                            Directions
                        </a>
                    </div>
                </div>
                <div class="row no-margin u-marginBottom">
                @if(Session::get('permission') != '4')
                    <div class="col-md-6">
                        <button  type="button" class="btn btn-job btn-lg u-textBold u-grid10 mark-active" id="mark_visit" value="" data-mark="0">Mark Complete</button>
                    </div>
                    <div class="col-md-6">
                        <div class="u-block" style="position: relative;">
                            <a class="btn btn-lg assign-btn u-textBold u-grid10" style="height: 43px;" data-toggle="dropdown" href="#">Action
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-action" style="right:0">
                                <li>
                                    <a class="paragraph u-block"  onclick="" id="visitEdit">
                                        <i class="jobber-icon jobber-2x jobber-edit u-marginRight u-colorGreyBlue"></i>
                                        Edit
                                    </a>
                                </li>
                                <!-- <li>
                                    <a class="paragraph u-block">
                                        <i class="jobber-icon jobber-2x jobber-visit u-marginRight u-colorGreen"></i>
                                        Update Future Visits
                                    </a>
                                </li> -->
                            @if(Session::get('permission') != '5' && Session::get('permission') != '6')
                                <li>
                                    <a class="paragraph u-block" onclick="" id="visitDelete">
                                        <i class="jobber-icon jobber-2x jobber-trash u-marginRight u-colorRed"></i>
                                        Delete
                                    </a>
                                </li>
                            @endif
                            </ul>
                        </div>
                    </div>
                @endif
                </div>
                <div class="row jobTypePanel" id="visitPanel">
                    <div class="col-md-12">
                        <div class="panel-heading no-padding">
                            <div class="panel-options">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#info_tap" class="selectTab">
                                        <p class="paragraph text-center">
                                           Info
                                        </p>
                                    </a></li>
                                    <li class="">
                                        <a data-toggle="tab" href="#client_tap" class="selectTab">
                                        <p class="paragraph text-center">
                                            Client
                                        </p>
                                    </a></li>
                                    <!-- <li class="">
                                        <a data-toggle="tab" href="#notes_tap" class="selectTab">
                                        <p class="paragraph text-center">
                                            Notes
                                            <span class="notesNum">0</span>
                                        </p>
                                    </a></li> -->
                                </ul>
                                <!-- <input type="hidden" name="jobType" id="jobType" value="0"/> -->
                            </div>
                        </div>
                        <div class="panel-body no-padding">
                            <div class="tab-content">
                                <div id="info_tap" class="tab-pane active">
                                    <div class="row no-margin u-borderBottom">
                                        <div class="col-md-12">
                                            <h4 class="headingTwo u-marginBottomSmall">Details</h4>
                                            <p class="paragraph u-textItalic u-marginBottom">No additional details</p>
                                        </div>
                                    </div>
                                    <div class="row no-margin u-borderBottom u-marginTop">
                                        <div class="col-md-4 u-borderRight">
                                            <h4 class="headingTwo u-marginBottomSmall">Job</h4>
                                            <a class="paragraph u-textItalic u-marginBottomSmaller u-block">
                                                <!-- <i class="fa fa-angle-right u-colorGreen u-floatRight u-a-i-fontsize"></i> -->
                                                Job #{{$data['job'][0]->job__id}}</a>
                                        </div>
                                        <div class="col-md-4 u-borderRight">
                                            <h4 class="headingTwo u-marginBottomSmall">Team</h4>
                                            <div class="inlineLabel inlineLabel--grey"><span>TOM</span></div>
                                        </div>
                                        <div class="col-md-4">
                                            <h4 class="headingTwo u-marginBottomSmall">Reminders</h4>
                                            <p class="paragraph">No reminders scheduled</p>
                                        </div>
                                    </div>
                                    <div class="row no-margin u-marginTop">
                                        <div class="col-md-12">
                                            <h4 class="headingTwo u-marginBottomSmall">Line items</h4>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row no-margin u-marginBottomSmall" style="border-bottom: 3px solid #e2e2e2;">
                                                <div class="col-sm-10 no-padding u-borderRight">
                                                    <p class="paragraph">SERVICE / PRODUCT</p>
                                                </div>
                                                <div class="col-sm-2 no-padding">
                                                    <p class="paragraph text-center">QTY</p>
                                                </div>
                                            </div>
                                            <div class="row no-margin u-marginBottomSmall">
                                                <div class="col-sm-10">
                                                    <h5 class="headingTwo no-margin">Closets</h5>
                                                    <p class="paragraph u-textSmaller">Paint closets</p>
                                                </div>
                                                <div class="col-sm-2">
                                                    <h5 class="headingTwo u-floatRight no-margin">5</h5>
                                                </div>
                                            </div>
                                            <div class="row no-margin u-marginBottomSmall">
                                                <div class="col-sm-10">
                                                    <h5 class="headingTwo no-margin">Baseboards</h5>
                                                    <p class="paragraph u-textSmaller">Paint baseboards</p>
                                                </div>
                                                <div class="col-sm-2">
                                                    <h5 class="headingTwo u-floatRight no-margin">1</h5>
                                                </div>
                                            </div>
                                            <div class="row no-margin u-marginBottomSmall">
                                                <div class="col-sm-10">
                                                    <h5 class="headingTwo no-margin">Ceiling</h5>
                                                    <p class="paragraph u-textSmaller">Paint ceiling</p>
                                                </div>
                                                <div class="col-sm-2">
                                                    <h5 class="headingTwo u-floatRight no-margin">1</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="client_tap" class="tab-pane">
                                    <div class="row no-margin u-marginBottom">
                                        <div class="col-md-12 no-padding">
                                            <h4 class="headingTwo u-marginBottomSmall">Client Details</h4>
                                        </div>
                                    </div>
                                    <div class="row u-marginBottomSmall">
                                        <div class="col-sm-3">
                                            <p class="paragraph">Name</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <a href="{{url('dashboard/clients/detail')}}/{{$data['job'][0]->client_id}}">
                                                <i class="fa fa-angle-right u-a-i-fontsize u-floatRight u-marginRightSmall"></i>
                                                <p class="paragraph u-textNormal u-colorBlue">{{$data['job'][0]->first_name}} {{$data['job'][0]->last_name}}</p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row u-marginBottomSmall">
                                        <div class="col-sm-3">
                                            <p class="paragraph">Phone</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <div>
                                                <i class="jobber-icon jobber-2x jobber-phone u-floatRight"></i>
                                                @if(isset($data['contact']))
                                                    @foreach($data['contact'] as $one)
                                                        @if($one->type == 1)
                                                            <p class="paragraph">{{$one->value}}</p>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row u-marginBottom">
                                        <div class="col-sm-3">
                                            <p class="paragraph">Email</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <div>
                                                <i class="jobber-icon jobber-2x jobber-email u-floatRight"></i>
                                                @if(isset($data['contact']))
                                                    @foreach($data['contact'] as $one)
                                                        @if($one->type == 2)
                                                            <div class="no-padding u-textSmaller">{{$one->value}}</div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row no-margin u-marginTop">
                                        <div class="col-md-12 no-padding">
                                            <h4 class="headingTwo u-marginBottomSmall">Property</h4>
                                        </div>
                                    </div>
                                    <div class="row u-marginBottom">
                                        <div class="col-sm-3">
                                            <p class="paragraph">Address</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <a href="{{url('dashboard/properties/detail')}}/{{$data['job'][0]->property_id}}">
                                                <i class="fa fa-angle-right u-a-i-fontsize u-floatRight u-marginRightSmall"></i>
                                                <p class="paragraph u-textNormal u-colorBlue">{{$data['job'][0]->street1}} {{$data['job'][0]->street2}}</p>
                                                <p class="paragraph u-textNormal u-colorBlue">{{$data['job'][0]->city}} {{$data['job'][0]->state}},  {{$data['job'][0]->zip_code}}</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div id="notes_tap" class="tab-pane">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea class="action-border input-lg form-control" name="" value="" rows="5" placeholder="Note details"></textarea>
                                            <div class="text-right u-marginTopSmall">
                                                <label title="Upload image file" for="attachFile" class="btn btn-sm button--greyBlue button--ghost u-textBold ">
                                                    <input type="file" accept="/*" name="file" id="attachFile" class="hide">
                                                    Add Attachment
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer no-border">
            </div>
        </div>
    </div>
    <!-- Modal2 -->
    <div class="modal inmodal" id="visitCreate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header no-border">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title headingTwo text-left">Schedule a visit</h4>
                </div>
                <div class="modal-body" id="visit_editable">
                <form method="post" id="visitForm">
                {{ csrf_field() }}
                    <input type="hidden" name="visit_id" id="visit_id">
                    <div class="row">
                        <div class="col-md-8 u-borderRight" id="editable_visit">
                            <div class="row">
                                <div class="col-md-12 u-marginBottom">
                                    <div class="u-grid10">
                                        <input type="text" name="title" class="form-control input-lg action-border" value="{{$data['job'][0]->first_name}} {{$data['job'][0]->last_name}} - {{$data['job'][0]->description}}" placeholder="Title">
                                        <textarea class="form-control action-border" name="details" rows="3" placeholder="Details"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 u-borderRight u-borderTop medium-expand">
                                    <div class="row no-margin">
                                        <h3 class="headingTwo u-marginTop">Scheduling</h3>
                                        <label class="scheduleLater">
                                            <input type="checkbox" class="check-button" name="visit-schedule" onclick="visit_check_schedule(this)">
                                            <i class="checkbox fa"></i>
                                            <span class="paragraph">
                                                Schedule later
                                            </span>
                                        </label>
                                    </div>
                                    <div class="row no-margin" id="visit_schedule_field">
                                        <div class="col-sm-12 no-padding" id="visit_date">
                                            <div class="input-group u-grid10 date" id="visit_start_date">
                                                <p class="paragraph">Start date</p>
                                                <input type="text" class="action-border input-lg form-control input-group-addon" name="visit_start_date" value="<?php  echo date('Y-m-d')?>"/>
                                            </div>
                                            <div class="input-group u-grid10 date" id="visit_end_date">
                                                <p class="paragraph">End date</p>
                                                <input type="text" class="action-border input-lg form-control input-group-addon" name="visit_end_date" value="<?php  echo date('Y-m-d')?>" required/>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 no-padding" id="visit_time" style="display: none">
                                            <div class="input-group date u-grid10 u-floatLeft" id="visit_time_start">
                                                <p class="paragraph">Start time</p>
                                                <input type="text" class="action-border input-lg form-control" name="visit_time_start" value="" placeholder="Start time" data-mask="99:99" onchange="validateHhMm(this)" required/>
                                            </div>
                                            <div class="input-group date u-grid10 u-floatLeft" id="visit_time_end">
                                                <p class="paragraph">End time</p>
                                                <input type="text" class="action-border input-lg form-control" name="visit_time_end" value="" placeholder="End time" data-mask="99:99" onchange="validateHhMm(this)" required/>
                                            </div>
                                        </div>
                                        <div class="u-marginTopSmall">
                                            <label class="check-element" id="">
                                                <input type="checkbox" class="check-button" name="allday" checked onclick="visit_allday_check(this)">
                                                <i class="checkbox fa"></i>
                                                <span class="paragraph">
                                                    All Day
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row no-margin u-marginTopSmaller u-paddingBottom">
                                        <div class="input-group u-grid10" id="">
                                            <h3 class="headingTwo u-marginTop">Team reminder</h3>
                                            <label class="fa select-label label-lg" style="display: block">
                                                <select class="input-lg form-control action-border" name="visit_reminder" onchange="">
                                                    <option value="0">No reminder set</option>
                                                    <option value="1">At start of task</option>
                                                    <option value="2">30 minutes before</option>
                                                    <option value="3">1 hours before</option>
                                                    <option value="4">2 hours before</option>
                                                    <option value="5">5 hours before</option>
                                                    <option value="6">24 hours before</option>
                                                </select>
                                            </label>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 u-borderTop medium-expand">
                                    <h3 class="headingTwo u-marginTop u-marginBottomBig">Assigned to</h3>
                                    <input type="hidden" name="visit_team_ids" id="visit_team_ids" />
                                    <select data-placeholder="Choose Team..." class="chosen-select-visit" multiple style="width:100%;" tabindex="4" onchange="visit_selectTeam(this)" id="">
                                        @foreach($data['teams'] as $team)
                                            <option value="{{$team->team_member_id}}">{{$team->fullname}}</option>
                                        @endforeach
                                    </select>
                                    <label class="check-element">
                                        <input type="checkbox" class="check-button" name="visit_notify" value="1">
                                        <i class="checkbox fa"></i>
                                        <span class="paragraph">
                                           Notify team by email
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h3 class="headingTwo u-marginTop">Job Details</h3>
                            <input type="hidden" name="job_id" value="{{$data['job'][0]->job__id}}" />
                            <input type="hidden" name="job_type" value="{{$data['job'][0]->job_type}}" />
                            <table class="table no-border">
                                <tr>
                                    <td class="no-border"><p class="paragraph">Job #</p></td>
                                    <td class="no-border"><a href="" style="line-height: 25px;">{{$data['job'][0]->job__id}}</a></td>
                                </tr>
                                <tr>
                                    <td class="no-border"><p class="paragraph">Client</p></td>
                                    <td class="no-border"><a href="" style="line-height: 25px;">{{$data['job'][0]->first_name}} {{$data['job'][0]->last_name}}</a></td>
                                </tr>
                                
                                <tr>
                                    <td class="no-border"><p class="paragraph">Phone</p></td>
                                    <td class="no-border">
                                    @if(isset($data['contact']))
                                        @foreach($data['contact'] as $one)
                                            @if($one->type == 1)
                                                <a href="" style="line-height: 25px;">{{$one->value}}</a>
                                            @endif
                                        @endforeach
                                    @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="no-border"><p class="paragraph">Address</p></td>
                                    <td class="no-border"><a href="" style="line-height: 25px;">
                                        {{$data['job'][0]->street1}} {{$data['job'][0]->street2}}<br>
                                        {{$data['job'][0]->city}} {{$data['job'][0]->state}},  {{$data['job'][0]->zip_code}}
                                    </a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card card--lightGrey text-center">
                            <p class="paragraph">
                              Line item changes must be done directly to the job when visits are one-off and span multiple days
                            </p>
                        </div>
                    </div>
                </form>
                </div>
                <div class="modal-footer no-border">
                @if(Session::get('permission') != '5' && Session::get('permission') != '6')
                    <button type="button" class="btn btn-outline btn-danger u-floatLeft delete_visit" data-id="" onclick="delete_visit(this);">Delete</button>
                @endif
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-job" id="save_visit">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal3 -->
    <div class="modal inmodal" id="timesheet" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left">Time for Job #{{$data['job'][0]->job__id}} - {{$data['job'][0]->first_name}} {{$data['job'][0]->last_name}}</h4>
            </div>
            <form action="#" method="post" id="timesheetForm">
            {{ csrf_field() }}
            <div class="modal-body timesheets">
                    <input type="hidden" name="id" value="" id="timesheet_id">
                    <input type="hidden" name="category" value="{{$data['job'][0]->job__id}}">
                    <div class="input-group u-grid10 u-marginBottomSmall" >
                        <p class="paragraph">
                            Start Time
                        </p>
                        <input type="text" class="action-border input-lg form-control " name="start" value="" data-mask="99:99" id="start_time" onchange="calculate_duration(this)" required/>
                    </div>
                    <div class="input-group u-grid10 u-marginBottomSmall" id="">
                        <p class="paragraph">
                            End Time
                        </p>
                        <input type="text" class="action-border input-lg form-control " name="end" value="" data-mask="99:99" id="end_time" onchange="calculate_duration(this)" required/>
                    </div>
                    <div class="input-group u-grid10 u-marginBottomSmall" id="">
                        <p class="paragraph">
                           Duration
                        </p>
                        <input type="text" class="action-border input-lg form-control " name="duration" value="" id="duration" data-mask="99:99" required/>
                    </div>
                    <div class="input-group u-grid10 u-marginBottomSmall" id="">
                        <textarea class="action-border input-lg form-control " name="note" rows="3" placeholder="Dtails" required id="details"/></textarea>
                    </div>
                    
                    <div class="input-group u-grid10 u-marginBottomSmall date" id="dateStart">
                        <p class="paragraph">
                            Date
                        </p>
                        <input type="text" class="action-border input-lg form-control input-group-addon" name="save_date" value="<?php echo date('Y-m-d')?>" style="text-align:left !important;"/>
                    </div>
            </div>
            <div class="modal-footer no-border">
            @if(Session::get('permission') != '5' && Session::get('permission') != '6')
                <button type="button" class="btn btn-outline btn-danger u-floatLeft" id="deleteTime">Delete</button>
            @endif
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-job">Save Time Entry</button>
            </div>
            </form>
        </div>
    </div>    
    <!-- Modal4 -->
    <div class="modal inmodal" id="invoice_reminder" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header no-border">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title headingTwo text-left">New Invoice Reminder</h4>
                </div>
                <div class="modal-body">
                <form method="post" id="reminderForm">
                {{ csrf_field() }}
                    <div class="row u-borderBottom">
                        <div class="col-md-8 u-borderRight" id="editable_reminder">
                            <div class="row">
                                <div class="col-md-12 u-marginBottom">
                                    <div class="u-grid10">
                                        <textarea class="form-control action-border" name="details" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 u-borderRight u-borderTop medium-expand">
                                    <div class="row no-margin">
                                        <h3 class="headingTwo u-marginTop">Scheduling</h3>
                                        <label class="scheduleLater">
                                            <input type="checkbox" class="check-button" name="schedule" onclick="check_schedule(this)">
                                            <i class="checkbox fa"></i>
                                            <span class="paragraph">
                                                Schedule later
                                            </span>
                                        </label>
                                    </div>
                                    <div class="row no-margin " id="schedule_field">
                                        <div class="col-sm-12 no-padding" id="reminder_date">
                                            <div class="input-group u-grid10 date" id="reminder_start_date">
                                                <p class="paragraph">Start date</p>
                                                <input type="text" class="action-border input-lg form-control input-group-addon" name="start_date" value="<?php  echo date('Y-m-d')?>"/>
                                            </div>
                                            <div class="input-group u-grid10 date" id="reminder_end_date">
                                                <p class="paragraph">End date</p>
                                                <input type="text" class="action-border input-lg form-control input-group-addon" name="end_date" value="<?php  echo date('Y-m-d')?>" required/>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 no-padding" id="reminder_time" style="display: none">
                                            <div class="input-group date u-grid10 u-floatLeft" id="time_start">
                                                <p class="paragraph">Start time</p>
                                                <input type="text" class="action-border input-lg form-control" name="start_time" value="" placeholder="Start time" data-mask="99:99" onchange="validateHhMm(this)" required/>
                                            </div>
                                            <div class="input-group date u-grid10 u-floatLeft" id="time_end">
                                                <p class="paragraph">End time</p>
                                                <input type="text" class="action-border input-lg form-control" name="end_time" value="" placeholder="End time" data-mask="99:99" onchange="validateHhMm(this)" required/>
                                            </div>
                                        </div>
                                        <div class="u-marginTopSmall">
                                            <label class="check-element" id="">
                                                <input type="checkbox" class="check-button" name="allday" checked onclick="allday_check(this)">
                                                <i class="checkbox fa"></i>
                                                <span class="paragraph">
                                                    All Day
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 u-borderTop medium-expand">
                                    <h3 class="headingTwo u-marginTop u-marginBottomBig">Assigned to</h3>
                                    <input type="hidden" name="team_ids" id="team_ids" />
                                    <select data-placeholder="Choose Team..." class="chosen-select chosen-select-reminder" multiple style="width:100%;" tabindex="4" onchange="selectTeam(this)" id="">
                                        @foreach($data['teams'] as $team)
                                            <option value="{{$team->team_member_id}}">{{$team->fullname}}</option>
                                        @endforeach
                                    </select>
                                    <label class="check-element">
                                        <input type="checkbox" class="check-button" name="notify1" value="1">
                                        <i class="checkbox fa"></i>
                                        <span class="paragraph">
                                           Notify team by email
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h3 class="headingTwo u-marginTop">Job Details</h3>
                            <input type="hidden" name="job_id" value="{{$data['job'][0]->job__id}}" />
                            <input type="hidden" name="job_type" value="{{$data['job'][0]->job_type}}" />
                            <table class="table no-border">
                                <tr>
                                    <td class="no-border"><p class="paragraph">Job #</p></td>
                                    <td class="no-border"><div style="line-height: 25px;">{{$data['job'][0]->job__id}}</div></td>
                                </tr>
                                <tr>
                                    <td class="no-border"><p class="paragraph">Client</p></td>
                                    <td class="no-border"><a href="{{url('dashboard/clients/detail')}}/{{$data['job'][0]->client_id}}" style="line-height: 25px;">{{$data['job'][0]->first_name}} {{$data['job'][0]->last_name}}</a></td>
                                </tr>
                                <tr>
                                    <td class="no-border"><p class="paragraph">Phone</p></td>
                                    <td class="no-border">
                                    @if(isset($data['contact']))
                                        @foreach($data['contact'] as $one)
                                            @if($one->type == 1)
                                                <div href="" style="line-height: 25px;">{{$one->value}}</div>
                                            @endif
                                        @endforeach
                                    @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="no-border"><p class="paragraph">Address</p></td>
                                    <td class="no-border"><a href="{{url('dashboard/properties/detail')}}/{{$data['job'][0]->property_id}}" style="line-height: 25px;">
                                        {{$data['job'][0]->street1}} {{$data['job'][0]->street2}}<br>
                                        {{$data['job'][0]->city}} {{$data['job'][0]->state}},  {{$data['job'][0]->zip_code}}
                                    </a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </form>
                </div>
                <div class="modal-footer no-border">
                @if(Session::get('permission') != '5' && Session::get('permission') != '6')
                    <button type="button" class="btn btn-outline btn-danger u-floatLeft delete_reminder" data-id="" onclick="delete_reminder(this);">Delete</button>
                @endif
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-job" id="save_reminder">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal5 -->
    <div class="modal inmodal" id="invoice_reminderView" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title headingTwo text-left">Reminder</h4>
                </div>
                <div class="modal-body no-padding">
                    <div class="row no-margin u-marginBottomSmall u-marginTop">
                        <div class="col-md-6 u-borderRight">
                            <h3 class="headingThree u-marginTopSmaller u-marginBottom" style="line-height: 25px;">Invoice reminder {{$data['job'][0]->first_name}} {{$data['job'][0]->last_name}} for job #{{$data['job'][0]->job__id}}</h3>
                        </div>
                        <div class="col-md-6">
                            <h4 class="headingThree u-marginTopSmaller u-marginBottom" id="">
                                <i class="jobber-icon jobber-calendar jobber-2x u-marginRightSmall"></i><span id="reminder_duration"></span>
                            </h4>
                        </div>
                    </div>
                    <div class="row no-margin u-marginBottom">
                    @if(Session::get('permission') != '4')
                        @if(Session::get('permission') != '5')
                        <div class="col-md-6">
                            <a  href="{{url('/dashboard/work/invoices/newinvoice')}}/{{$data['job'][0]->client_id}}" class="btn btn-job btn-lg u-textBold u-grid10" remote="true" id="">Create Invoice</a>
                        </div>
                        @endif
                        <div {{Session::get('permission') == '5'?'class=col-md-12':'class=col-md-6'}}>
                            <div class="u-block" style="position: relative;">
                                <a  class="btn btn-lg assign-btn u-textBold u-grid10" style="height: 42px;" data-toggle="dropdown" href="#">Action
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-action" style="right:0">
                                    <li>
                                        <a class="paragraph u-block edit_reminder" data-id="" onclick="edit_reminder(this);">
                                            <i class="jobber-icon jobber-edit jobber-2x u-marginRight u-colorGreyBlue "></i>
                                            Edit
                                        </a>
                                    </li>
                                @if(Session::get('permission') != '5' && Session::get('permission') != '6')
                                    <li>
                                        <a class="paragraph u-block delete_reminder" data-id="" onclick="delete_reminder(this);">
                                            <i class="jobber-icon jobber-trash jobber-2x u-marginRight u-colorRed " ></i>
                                            Delete
                                        </a>
                                    </li>
                                @endif
                                </ul>
                            </div>
                        </div>
                    @endif
                    </div>
                    <div class="row jobTypePanel" id="reminderPanel">
                        <div class="col-md-12">
                            <div class="panel-heading no-padding">
                                <div class="panel-options">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a data-toggle="tab" href="#reminder_info" class="selectTab">
                                            <p class="paragraph text-center">
                                               Info
                                            </p>
                                        </a></li>
                                        <li class="">
                                            <a data-toggle="tab" href="#reminder_client" class="selectTab">
                                            <p class="paragraph text-center">
                                                Client
                                            </p>
                                        </a></li>
                                    </ul>
                                    <!-- <input type="hidden" name="jobType" id="jobType" value="0"/> -->
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div id="reminder_info" class="tab-pane active">
                                        <div class="row no-margin u-borderBottom">
                                            <div class="col-md-12">
                                                <h4 class="headingTwo u-marginBottomSmall">Details</h4>
                                                <p class="paragraph u-marginBottom details">No additional details</p>
                                            </div>
                                        </div>
                                        <div class="row no-margin u-marginTop">
                                            <div class="col-md-6 u-borderRight">
                                                <h4 class="headingTwo u-marginBottom">Job</h4>
                                                <a href="{{url('dashboard/work/jobs/')}}/{{$data['job'][0]->job__id}}/view" class="paragraph u-marginBottomSmaller u-block"><i class="fa fa-angle-right u-colorGreen u-floatRight u-a-i-fontsize"></i>Job #{{$data['job'][0]->job__id}}</a>
                                            </div>
                                            <div class="col-md-6">
                                                <h4 class="headingTwo u-marginBottom">Assigned to</h4>
                                                <div class="inlineLabel u-marginBottomSmall"><span class="assigned_user">John Marker</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="reminder_client" class="tab-pane">
                                        <div class="row no-margin u-marginBottomSmall">
                                            <div class="col-md-12">
                                                <h4 class="headingTwo u-marginBottomSmall">Client Details</h4>
                                            </div>
                                        </div>
                                        <div class="row no-margin u-marginBottomSmall">
                                            <div class="col-sm-3">
                                                <p class="paragraph">Name</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <a href="{{url('dashboard/clients/detail')}}/{{$data['job'][0]->client_id}}">
                                                    <i class="jobber-icon jobber-arrowRight jobber-2x u-floatRight"></i>
                                                    <p class="paragraph u-colorBlue">{{$data['job'][0]->first_name}}{{$data['job'][0]->last_name}}</p>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row no-margin u-marginBottomSmall">
                                            <div class="col-sm-3">
                                                <p class="paragraph">Phone</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <div>
                                                    <i class="jobber-icon jobber-phone jobber-2x u-floatRight"></i>
                                                    @if(isset($data['contact']))
                                                        @foreach($data['contact'] as $one)
                                                            @if($one->type == 1)
                                                                <p class="paragraph u-colorBlue">{{$one->value}}</p>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row no-margin u-marginBottom">
                                            <div class="col-sm-3">
                                                <p class="paragraph">Email</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <div>
                                                    <i class="jobber-icon jobber-email jobber-2x u-floatRight"></i>
                                                    @if(isset($data['contact']))
                                                        @foreach($data['contact'] as $one)
                                                            @if($one->type == 2)
                                                                <p class="paragraph u-colorBlue">{{$one->value}}</p>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row no-margin u-marginTop">
                                            <div class="col-md-12">
                                                <h4 class="headingTwo u-marginBottomSmall">Property</h4>
                                            </div>
                                        </div>
                                        <div class="row no-margin u-marginBottom">
                                            <div class="col-sm-3">
                                                <p class="paragraph">Address</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <a href="{{url('dashboard/properties/detail')}}/{{$data['job'][0]->property_id}}">
                                                    <i class="jobber-icon jobber-arrowRight jobber-2x u-floatRight"></i>
                                                    <p class="paragraph u-colorBlue" style="line-height: 20px">{{$data['job'][0]->street1}} {{$data['job'][0]->street2}}</p>
                                                    <p class="paragraph u-colorBlue" style="line-height: 20px">{{$data['job'][0]->city}} {{$data['job'][0]->state}},  {{$data['job'][0]->zip_code}}</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer no-border">
                </div>
            </div>
        </div>
    </div>
    <!-- Modal6 -->
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
    <!-- Modal7 -->
    <div class="modal inmodal" id="incompleteVisit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title headingTwo text-left" style="font-size: 17px;">Job has incomplete visits</h4>
                </div>
                <div class="modal-body">
                    <form action="{{url('/dashboard/work/jobs/close-job')}}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="close_job_id" value="">
                    <div class="row">
                        <div class="col-md-12 u-borderBottom">
                            <p class="paragraph">This job has:</p>
                            <ul>
                                <li><p class="paragraph"><span id="late_visit_num"></span> incomplete visits</p></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="headingTwo paragraph u-marginTop">What would you like to do with incomplete visits?</h4>
                            <label class="radio-element">
                                <input type="radio" class="check-button" name="incomplete_action" value="1" checked="">
                                <i class="checkbox fa"></i>
                                <span style="font-weight: 100;">
                                   Remove all visits
                                </span>
                            </label>
                            <label class="radio-element">
                                <input type="radio" class="check-button" name="incomplete_action" value="2">
                                <i class="checkbox fa"></i>
                                <span style="font-weight: 100;">
                                   Complete all visits
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer row u-marginTop">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-job">Close Job</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

<script src="{{ url('public/js/jquery.sieve.js')}}"></script>
<script src="{{ url('public/js/country.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(){

        //Init DatePicker
        $('#dateStart').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        $('#reminder_start_date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        $('#reminder_end_date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        $('#visit_start_date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        $('#visit_end_date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });

        // var config = {
        //         '.chosen-select'           : {},
        //         '.chosen-select-deselect'  : {allow_single_deselect:true},
        //         '.chosen-select-no-single' : {disable_search_threshold:10},
        //         '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
        //         '.chosen-select-width'     : {width:"95%"}
        //     }

        //     for (var selector in config) {
        //         $(selector).chosen(config[selector]);
        //     }
        //Init Combobox
        // var combobox = $('.combo-select').combobox().data('combobox');

        //Action
        $('input[name=visit-action]').change(function(){
            if ($(this).prop('checked') == true) {
                var visit_id = $(this).val();
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
                // console.log(visit_id);
                $.ajax({
                    type: 'POST',
                    url: "{{url('dashboard/work/jobs/visit-complete')}}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        visit_id: visit_id,
                        action: '1'
                    },
                    success: function(str){
                        $('body').waitMe("hide");
                        if (str == 'success') {                            
                            window.location.reload();
                        }else if(str == 'failed'){
                            return;
                        }
                    },
                });
                return false;
            }else{
                var visit_id = $(this).val();
                // console.log(visit_id);
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
                    url: "{{url('dashboard/work/jobs/visit-complete')}}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        visit_id: visit_id,
                        action: '-1'
                    },
                    success: function(str){
                        $('body').waitMe("hide");
                        if (str == 'success') {
                            window.location.reload();
                        }
                    },
                });
                return false;
            }
        });
        $('#mark_visit').click(function(){
            if ($(this).attr('data-mark') == '0') {
                var visit_id = $(this).val();
                // console.log(visit_id);
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
                    url: "{{url('dashboard/work/jobs/visit-complete')}}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        visit_id: visit_id,
                        action: '1'
                    },
                    success: function(str){
                        $('body').waitMe("hide");
                        if (str == 'success') {
                            window.location.reload();
                        }
                    },
                });
                return false;
            }else{
                var visit_id = $(this).val();
                // console.log(visit_id);
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
                    url: "{{url('dashboard/work/jobs/visit-complete')}}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        visit_id: visit_id,
                        action: '-1'
                    },
                    success: function(str){
                        $('body').waitMe("hide");
                        if (str == 'success') {
                            window.location.reload();
                        }
                    },
                });
                return false;
            }
        });

        $('.addItem-btn').click(function(){
            var addHtml = $('#editlineItemRow').tmpl({
                description: '2',
            }).html();
            $('#lineItemBox').append(addHtml);
            var combobox = $('.combo-select').combobox().data('combobox');

            return false;
        });
        $('.btn-submit').click(function(){
            console.log('asdf');
        });


        //Modal controll
        $('.visitView').click(function(){
            var visit_id = $(this).attr('data-id');
            // console.log(visit_id);
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
                url: "{{url('dashboard/work/jobs/getVisit')}}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    visit_id: visit_id,
                },
                success: function(data){
                    $('body').waitMe("hide");
                    var addHtml = $('#visit_info').tmpl({data: data}).html();
                    // console.log(addHtml);
                    if (data.visit[0].status == '1') {
                        $('#mark_visit').attr('data-mark', 0);
                        $('#mark_visit').removeClass('mark-active');
                        $('#mark_visit').text('Mark Complete');
                    }else{
                        $('#mark_visit').attr('data-mark', 1);
                        $('#mark_visit').addClass('mark-active');
                        $('#mark_visit').text('Completed');
                    }
                    if (data.visit[0].start_time=='00:00'&&data.visit[0].end_time=='00:00') {
                        $('#visitSchedule').text(data.visit[0].start_date+'  Anytime');
                    }else{
                        $('#visitSchedule').text(data.visit[0].start_date+'  '+data.visit[0].start_time+' - '+data.visit[0].end_time);
                    }
                    $('#visit_title').text(data.visit[0].title);
                    $('#mark_visit').val(data.visit[0].visit_id);
                    $('#visitEdit').attr('onclick', 'visitEdit("'+ data.visit[0].visit_id +'");')
                    $('#visitDelete').attr('onclick', 'visitDelete("'+ data.visit[0].visit_id +'");')
                    $('#info_tap').children().remove();
                    $('#info_tap').append(addHtml);
                    $('#visitView').modal('show');
                },
            });
            return false;
        });
        // $('.forTime').click(function(){
        //     $('#forTime').modal('show');
        //     return false;
        // });
        $('#new_visit').click(function(){
            $('#visitCreate').modal('show');
            $('#visitCreate').find('input[type=text]').val('');
            $('#visitCreate').find('textarea').text('');
            $('#visitCreate').find('.delete_visit').hide();
            $('.chosen-select-visit').chosen();
            $('#save_visit').text('Save');
            return false;
        });

        $('#save_visit').click( function(){
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
                type: 'post',
                url: "{{url('/dashboard/work/jobs/visit-save')}}",
                data: $('#visitForm').serialize(),
                success: function(str){
                    $('body').waitMe("hide");
                    if (str == 'success') {
                        window.location.reload();
                    }
                },
            });
            return false;
        });


        $('.newTimesheet').click(function(){
            $('#deleteTime').hide();
            $('#timesheet_id').val('');
            $('#timesheet input[type=text]').val('');
            $('#timesheet textarea').text('');
            $('#timesheet').modal('show');
            return false;

        });
        $('#timesheetForm').on('submit', function(){
            var timesheet_id = $('#timesheet_id').val();
            // console.log('asdf');
            if (timesheet_id == '') {
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
                    type: 'GET',
                    url: "{{url('dashboard/timesheet/today/save')}}",
                    data: $('#timesheetForm').serialize(),
                    success: function(str){
                        $('body').waitMe("hide");
                        if (str == 'success') {
                            window.location.reload();
                        }
                    },
                });
                return false;
            }else{
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
                    type: 'GET',
                    url: "{{url('dashboard/timesheet/today/edit')}}",
                    data: $('#timesheetForm').serialize(),
                    success: function(str){
                        $('body').waitMe("hide");
                        if (str == 'success') {
                            window.location.reload();
                        }
                    },
                });
                return false;

            }
        });
        $('#deleteTime').click(function(){
            if(confirm('Are you sure?')){
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
                    type: 'GET',
                    url: "{{url('dashboard/timesheet/today/delete')}}",
                    data: {
                        delete_id: $('#timesheet_id').val(),
                    },
                    success: function(str){
                        $('body').waitMe("hide");
                        if (str == 'success') {
                            window.location.reload();
                        }
                    },
                });
            }
        });

        $('.new_invoice_reminder').click(function(){
            $('#invoice_reminder').modal('show');
            $('#invoice_reminder').find('input[type=text]').val('');
            $('#invoice_reminder').find('textarea').text('');
            $('#invoice_reminder').find('.delete_reminder').hide();
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
            // $('.chosen-select-reminder').chosen();
            return false;
        });
        $('#save_reminder').click(function(){
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
                type: 'post',
                url: "{{url('/dashboard/work/jobs/invoice_reminder')}}",
                data: $('#reminderForm').serialize(),
                success: function(str){
                    $('body').waitMe("hide");
                    if (str == 'success') {
                        window.location.reload();
                    }
                },
            });
            return false;
        });

        $('#save_note').click(function(){
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
                type: 'post',
                url: "{{url('/dashboard/work/jobs/note-save')}}",
                data: $('#service_remark').serialize(),
                success: function(str){
                    $('body').waitMe("hide");
                    if (str == 'success') {
                        window.location.reload();
                    }
                },
            });
            return false;
        });

    });

    function closeJob(obj){
        var job_id = $(obj).attr('data-id');
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
            url: "{{url('dashboard/work/jobs/before-close')}}",
            data: {
                '_token': $('input[name=_token]').val(),
                job_id: job_id,
            },
            success: function(data){
                $('body').waitMe("hide");
                if (data == 'success') {
                    window.location.href = "{{url('dashboard/work/jobs')}}/"+job_id+"/view";
                }else{
                    // console.log(data);
                    $('#incompleteVisit').modal('show');
                    $('#late_visit_num').text(data);
                    $('input[name=close_job_id]').val(job_id);
                }
            }
        });
    }

    function reopenJob(obj){
        var job_id = $(obj).attr('data-id');
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
            url: "{{url('dashboard/work/jobs/reopen-job')}}",
            data: {
                '_token': $('input[name=_token]').val(),
                job_id: job_id,
            },
            success: function(data){
                $('body').waitMe("hide");
                if (data == 'success') {
                    window.location.reload();
                }
                // else{
                //     // console.log(data);
                //     $('#incompleteVisit').modal('show');
                //     $('#late_visit_num').text(data);
                //     $('input[name=close_job_id]').val(job_id);
                // }
            }
        });
    }
    
    function visitEdit(visit_id){
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
            url: "{{url('dashboard/work/jobs/getVisit')}}",
            data: {
                '_token': $('input[name=_token]').val(),
                visit_id: visit_id,
            },
            success: function(data){
                $('body').waitMe("hide");
                // console.log(data);
                var addHtml = $('#visit_edit').tmpl({data: data}).html();
                $('#visit_editable').children().remove();
                $('#visit_editable').append(addHtml);
                $('#visitView').modal('hide');
                $('#visitCreate').modal('show');
                $('.chosen-select-visit').chosen();
                $('#visitCreate').find('.delete_visit').show();
                $('#visitCreate').find('.delete_visit').attr('data-id', data.visit[0].visit_id);
                $('#visit_start_date').datepicker({
                    format: 'yyyy-mm-dd',
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    autoclose: true
                });
                $('#visit_end_date').datepicker({
                    format: 'yyyy-mm-dd',
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    autoclose: true
                });
                $('#save_visit').text('Update');

            },
        });
        return false;
    }

    function delete_visit(obj){
        var visit_id = $(obj).attr('data-id');
        visitDelete(visit_id);
    }
    function visitDelete(visit_id){
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
            url: "{{url('dashboard/work/jobs/visit-delete')}}",
            data: {
                '_token': $('input[name=_token]').val(),
                visit_id: visit_id,
            },
            success: function(str){
                $('body').waitMe("hide");
                if (str == 'success') {
                    window.location.reload();
                }
            },
        });
        return false;
    }
    function visit_service_delete(obj){
        var visit_service_id = $(obj).attr('data-id');
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
            url: "{{url('dashboard/work/jobs/visit-service-delete')}}",
            data: {
                '_token': $('input[name=_token]').val(),
                visit_service_id: visit_service_id,
            },
            success: function(str){
                $('body').waitMe("hide");
                if (str == 'success') {
                    $(obj).parent().parent().remove();
                }
            },
        });
        return false;
    }
    function visit_check_schedule(obj){
        if($(obj).prop('checked') == true){
            $('#visit_schedule_field').hide();
        }else{
            $('#visit_schedule_field').show();
            
        }
    }
    function visit_allday_check(obj){
        if($(obj).prop('checked') == false){
            $('#visit_date').removeClass('col-sm-12');
            $('#visit_date').addClass('col-sm-6');
            $('#visit_time').show();
        }else{
            $('#visit_time').hide();
            $('#visit_date').removeClass('col-sm-6');
            $('#visit_date').addClass('col-sm-12');

        }
    }
    function visit_selectTeam(obj){
        var team_ids = '';
        $(obj).children('option').each(function(){
            if ($(this).prop('selected') == true) {
                team_ids += team_ids == '' ? $(this).attr('value') : ',' + $(this).attr('value');
            }
        });
        $('#visit_team_ids').val(team_ids);
        console.log(team_ids);
    }

    function getTimesheet(obj){
        var id = $(obj).attr('data-id');
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
            url: "{{url('/dashboard/work/jobs/getTimesheet/')}}",
            data:{
                '_token': $('input[name=_token]').val(),
                'timesheetId': id
            },
            success: function(data){
                $('body').waitMe("hide");
                if (data.length == 0) {
                    alert('Timesheet get faild!');
                    return false;
                }

                var timesheet_id = data[0].id;
                $('#timesheet_id').val(data[0].id);
                $('#start_time').val(data[0].start_time);
                $('#end_time').val(data[0].end_time);
                $('#duration').val(data[0].duration);
                $('#details').text(data[0].note);
                $('#dateStart').children('input').val(data[0].save_date);
                $('#deleteTime').show();
                $('#timesheet').modal('show');
                
            },

        });
        // console.log(id);
        return false;
    }

    function reminderView(obj){
        var reminder_id = $(obj).attr('data-id');
        var reminder_detail = $(obj).find('#reminder_detail').text();
        var reminder_duration = $(obj).find('[name=reminder_duration]').val();
        // console.log(reminder_duration);
        // $('#invoice_reminderView').modal('show');
        $('#invoice_reminderView').find('#reminder_duration').text(reminder_duration);
        // $('#invoice_reminderView').find('.details').text(reminder_detail);
        $('#invoice_reminderView').find('.edit_reminder').attr('data-id', reminder_id);
        $('#invoice_reminderView').find('.delete_reminder').attr('data-id', reminder_id);
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
            url: "{{url('/dashboard/work/jobs/getReminder/')}}",
            data:{
                '_token': $('input[name=_token]').val(),
                'invoice_reminder_id': reminder_id,
            },
            success: function(data){
                $('body').waitMe("hide");
                // console.log(data);
                var displayReminder = $('#reminder-info').tmpl({data: data}).html();
                $('#reminder_info').children().remove();
                $('#reminder_info').append(displayReminder);
                $('#invoice_reminderView').modal('show');
            },
        });
    }

    function edit_reminder(obj){
        var reminder_id = $(obj).attr('data-id');
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
            url: "{{url('/dashboard/work/jobs/getReminder/')}}",
            data:{
                '_token': $('input[name=_token]').val(),
                'invoice_reminder_id': reminder_id,
            },
            success: function(data){
                $('body').waitMe("hide");
                console.log(data['reminder'][0].start_date);
                if (data.length == 0) {
                    alert('Reminder get faild!');
                    return false;
                }
                $('#invoice_reminder').find('.modal-title').text("Invoice Reminder {{$data['job'][0]->first_name}} {{$data['job'][0]->last_name}} for job #{{$data['job'][0]->job__id}}");

                var displayReminder = $('#edit_reminder').tmpl({
                    id: data['reminder'][0].invoice_reminder_id,
                    details: data['reminder'][0].details,
                    start_date: data['reminder'][0].start_date,
                    end_date: data['reminder'][0].end_date,
                    start_time: data['reminder'][0].start_time,
                    end_time: data['reminder'][0].end_time,
                    member_id: data['reminder'][0].member_id,
                }).html();
                // console.log(displayReminder);
                $('#editable_reminder').replaceWith(displayReminder);
                $('#invoice_reminderView').modal('hide');
                $('#invoice_reminder').modal('show');
                $('#invoice_reminder').find('.delete_reminder').show();
                $('#invoice_reminder').find('.delete_reminder').attr('data-id', data['reminder'][0].invoice_reminder_id);
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
                $('#reminder_start_date').datepicker({
                    format: 'yyyy-mm-dd',
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    autoclose: true
                });
                $('#reminder_end_date').datepicker({
                    format: 'yyyy-mm-dd',
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    autoclose: true
                });
                
            },

        });
    }

    
    function check_schedule(obj){
        if($(obj).prop('checked') == true){
            $('#schedule_field').hide();
        }else{
            $('#schedule_field').show();
            
        }
    }
    
    function allday_check(obj){
        if($(obj).prop('checked') == false){
            $('#reminder_date').removeClass('col-sm-12');
            $('#reminder_date').addClass('col-sm-6');
            $('#reminder_time').show();
        }else{
            $('#reminder_time').hide();
            $('#reminder_date').removeClass('col-sm-6');
            $('#reminder_date').addClass('col-sm-12');

        }
    }

    function delete_reminder(obj){
        var reminder_id = $(obj).attr('data-id');
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
            url: "{{url('/dashboard/work/jobs/deleteReminder/')}}",
            data:{
                '_token': $('input[name=_token]').val(),
                'invoice_reminder_id': reminder_id,
            },
            success: function(data){
                $('body').waitMe("hide");
                if (data == 'success') {
                    window.location.reload();
                }
            }
        });
    }

    function deleteLineitem(obj){
         $('tr').has(obj).remove();
         var subTotal = 0;
        $('.total-val').each(function(){
            var total = $(this).text();
            with (Math){
                subTotal = parseInt(subTotal) + parseInt(total);
            }
        });
        console.log(subTotal);
        $('#subtotal_val').text('$' + subTotal);
    }
    function selectService(obj){
        var serviceId = $(obj).val();
        var sss = $(obj).parent().children('textarea').text(serviceId);
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
        console.log(subTotal);
        $('#subtotal_val').text('$' + subTotal);

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

    function show_savebtn(obj){
        var text1 = $('textarea[name=service_perform]').val();
        var text2 = $('textarea[name=remarks]').val();
        if (text1 == '' && text2 == '') {
            $('#save_note').hide();
        }else{
            $('#save_note').show();
        }
    }
    
    function validateHhMm(inputField) {
        var isValid = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/.test(inputField.value);
        if (isValid) {
            inputField.style.borderColor = 'white';
        } else {
          inputField.value = '00:00';
            inputField.style.borderColor = '#a94442';
        }

        return isValid;
    }
    function calculate_duration(obj){
        validateHhMm(obj);
        var selecter = $('.timesheets').has(obj);
        var start_picker = $('#start_time').val();
        var end_picker = $('#end_time').val();
        console.log(start_picker,end_picker);
        if (start_picker =='' || end_picker == '') {
          return false;
        }
        var duration_selecter = $('#duration');
        var duration_start = start_picker.split(':');
        var duration_end = end_picker.split(':');
        var execution = ( duration_end[0] * 60 + parseInt(duration_end[1])) - ( duration_start[0] *60 + parseInt(duration_start[1]));
        var duration_hour = Math.floor(execution/60);
        var duration_min = Math.abs(execution%60);
        if (duration_hour < 0 ) {
          duration_hour = duration_hour + 24;
        }
        if (duration_min < 10 ) {
          duration_min = '0' + duration_min;
        }
        if (duration_hour < 10) {
          duration_hour = '0' + duration_hour;
        }
        if (duration_hour == 'NaN' && duration_min == 'NaN' ) {
          duration_selecter.val('00:00');
        }else{

        duration_selecter.val(duration_hour + ':' + duration_min);
        }
    }
   
</script>

<script type="text/x-jquery-tmpl" id="edit_reminder">
<div>
    <div class="col-md-8 u-borderRight" id="editable_reminder">
        <div class="row">
            <div class="col-md-12 u-marginBottom">
                <div class="u-grid10">
                    <input type="hidden" name="reminder_id" value="${id}">
                    <textarea class="form-control action-border" name="details" rows="5">${details}</textarea>
                </div>
            </div>
            <div class="col-md-6 u-borderRight u-borderTop medium-expand">
                <div class="row no-margin">
                    <h3 class="headingTwo u-marginTop">Scheduling</h3>
                    <label class="scheduleLater">
                        <input type="checkbox" class="check-button" name="schedule"
                        onclick="check_schedule(this);">
                        <i class="checkbox fa"></i>
                        <span class="paragraph">
                            Schedule later
                        </span>
                    </label>
                </div>
                <div class="row no-margin" id="schedule_field">
                    <div class="col-sm-12 no-padding" id="reminder_date">
                        <div class="input-group u-grid10 date" id="reminder_start_date">
                            <p class="paragraph">Start date</p>
                            <input type="text" class="action-border input-lg form-control input-group-addon" name="start_date" value="${start_date}" onchange="calculateDates();"/>
                        </div>
                        <div class="input-group u-grid10 date" id="reminder_end_date">
                            <p class="paragraph">End date</p>
                            <input type="text" class="action-border input-lg form-control input-group-addon" name="end_date" value="${end_date}" required/>
                        </div>
                    </div>
                    <div class="col-sm-6 no-padding" id="reminder_time" style="display: none">
                        <div class="input-group date u-grid10 u-floatLeft" id="time_start">
                            <p class="paragraph">Start time</p>
                            <input type="text" class="action-border input-lg form-control" name="start_time" value="${start_time}" placeholder="Start time" data-mask="99:99" onchange="validateHhMm(this)" required/>
                        </div>
                        <div class="input-group date u-grid10 u-floatLeft" id="time_end">
                            <p class="paragraph">End time</p>
                            <input type="text" class="action-border input-lg form-control" name="end_time" value="${end_time}" placeholder="End time" data-mask="99:99" onchange="validateHhMm(this)" required/>
                        </div>
                    </div>
                    <div class="u-marginTopSmall">
                        <label class="check-element" id="">
                            <input type="checkbox" class="check-button" name="allday" onclick="allday_check(this);" checked>
                            <i class="checkbox fa"></i>
                            <span class="paragraph">
                                All Day
                            </span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-6 u-borderTop medium-expand">
                <h3 class="headingTwo u-marginTop u-marginBottomBig">Assigned to</h3>
                <input type="hidden" name="team_ids" id="team_ids" />
                <select data-placeholder="Choose Team..." class="chosen-select " multiple style="width:100%;" tabindex="4" onchange="selectTeam(this)" id="">
                    @foreach($data['teams'] as $team)
                        @if(in_array($team->team_member_id, explode(',', '${member_id}')))
                            <option value="{{$team->team_member_id}}" selected>{{$team->fullname}}</option>
                        @else
                            <option value="{{$team->team_member_id}}">{{$team->fullname}}</option>
                        @endif
                    @endforeach
                </select>
                <label class="check-element">
                    <input type="checkbox" class="check-button" name="notify1" value="1">
                    <i class="checkbox fa"></i>
                    <span class="paragraph">
                       Notify team by email
                    </span>
                </label>
            </div>
        </div>
    </div>
    
</div>
</script>

<script type="text/x-jquery-tmpl" id="reminder-info">
<div>
    <div class="row no-margin u-borderBottom">
        <div class="col-md-12">
            <h4 class="headingTwo u-marginBottomSmall">Details</h4>
            @{{if data.reminder[0].details == null}}
                <p class="paragraph u-marginBottom details">No additional details</p>
            @{{else}}
                <p class="paragraph u-marginBottom details">${data.reminder[0].details}</p>
            @{{/if}}
        </div>
    </div>
    <div class="row no-margin u-marginTop">
        <div class="col-md-6 u-borderRight">
            <h4 class="headingTwo u-marginBottom">Job</h4>
            <a href="{{url('dashboard/work/jobs/')}}/{{$data['job'][0]->job__id}}/view" class="paragraph u-marginBottomSmaller u-block"><i class="fa fa-angle-right u-colorGreen u-floatRight u-a-i-fontsize"></i>Job #{{$data['job'][0]->job__id}}</a>
        </div>
        <div class="col-md-6">
            <h4 class="headingTwo u-marginBottom">Assigned to</h4>
            @{{each data.members}}
                <div class="inlineLabel inlineLabel--grey u-marginBottomSmallest"><span class="assigned_user">${data.members[$index]}</span></div>
            @{{/each}}
        </div>
    </div>
</div>    
</script>

<script type="text/x-jquery-tmpl" id="visit_info">
<div>
    <div class="row no-margin u-borderBottom">
        <div class="col-md-12">
            <h4 class="headingTwo u-marginBottomSmall">Details</h4>
            @{{if data.visit[0].details == null}}
                <p class="paragraph u-textItalic u-marginBottom">No additional details</p>
            @{{else}}
                <p class="paragraph u-textItalic u-marginBottom">${data.visit[0].details}</p>
            @{{/if}}
        </div>
    </div>
    <div class="row no-margin u-borderBottom u-marginTop">
        <div class="col-md-4 u-borderRight">
            <h4 class="headingTwo u-marginBottomSmall">Job</h4>
            <div class="paragraph u-textItalic u-marginBottomSmaller u-block">
                <!-- <i class="fa fa-angle-right u-colorGreen u-floatRight u-a-i-fontsize"></i> -->
                Job #{{$data['job'][0]->job__id}}</div>
        </div>
        <div class="col-md-4 u-borderRight">
            <h4 class="headingTwo u-marginBottomSmall">Team</h4>
            @{{each data.members}}
                <div class="inlineLabel inlineLabel--grey u-marginBottomSmallest"><span>${data.members[$index]}</span></div>
            @{{/each}}
        </div>
        <div class="col-md-4">
            <h4 class="headingTwo u-marginBottomSmall">Reminders</h4>
            <p class="paragraph">No reminders scheduled</p>
        </div>
    </div>
    <div class="row no-margin u-marginTop">
        <div class="col-md-12">
            <h4 class="headingTwo u-marginBottomSmall">Line items</h4>
        </div>
        <div class="col-md-12">
            <div class="row no-margin u-marginBottomSmall" style="border-bottom: 3px solid #e2e2e2;">
                <div class="col-sm-10 no-padding u-borderRight">
                    <p class="paragraph">SERVICE / PRODUCT</p>
                </div>
                <div class="col-sm-2 no-padding">
                    <p class="paragraph text-center">QTY</p>
                </div>
            </div>
            @{{each data.services}}
            <div class="row no-margin u-marginBottomSmall">
                <div class="col-sm-10">
                    <h5 class="headingTwo no-margin">${data.services[$index].service_name}</h5>
                    <p class="paragraph u-textSmaller">${data.services[$index].service_description}</p>
                </div>
                <div class="col-sm-2">
                    <h5 class="headingTwo u-floatRight no-margin">${data.services[$index].quantity}</h5>
                </div>
            </div>
            @{{/each}}
        </div>
    </div>
</div>
</script>

<script type="text/x-jquery-tmpl" id="visit_edit">
<div>
    <form method="post" id="visitForm">
        {{ csrf_field() }}
            <input type="hidden" name="visit_id" id="visit_id" value="${data.visit[0].visit_id}">
            <div class="row">
                <div class="col-md-8 u-borderRight" id="editable_visit">
                    <div class="row">
                        <div class="col-md-12 u-marginBottom">
                            <div class="u-grid10">
                                <input type="text" name="title" class="form-control input-lg action-border" value="${data.visit[0].title}" placeholder="Title">
                                <textarea class="form-control action-border" name="details" rows="3" placeholder="Details">${data.visit[0].details}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6 u-borderRight u-borderTop medium-expand">
                            <div class="row no-margin">
                                <h3 class="headingTwo u-marginTop">Scheduling</h3>
                                <label class="scheduleLater">
                                    <input type="checkbox" class="check-button" name="visit-schedule" onclick="visit_check_schedule(this)">
                                    <i class="checkbox fa"></i>
                                    <span class="paragraph">
                                        Schedule later
                                    </span>
                                </label>
                            </div>
                            <div class="row no-margin" id="visit_schedule_field">
                                <div class="col-sm-12 no-padding" id="visit_date">
                                    <div class="input-group u-grid10 date" id="visit_start_date">
                                        <p class="paragraph">Start date</p>
                                        <input type="text" class="action-border input-lg form-control input-group-addon" name="visit_start_date" value="${data.visit[0].start_date}"/>
                                    </div>
                                    <div class="input-group u-grid10 date" id="visit_end_date">
                                        <p class="paragraph">End date</p>
                                        <input type="text" class="action-border input-lg form-control input-group-addon" name="visit_end_date" value="${data.visit[0].end_date}" required/>
                                    </div>
                                </div>
                                <div class="col-sm-6 no-padding" id="visit_time" style="display: none">
                                    <div class="input-group date u-grid10 u-floatLeft" id="visit_time_start">
                                        <p class="paragraph">Start time</p>
                                        <input type="text" class="action-border input-lg form-control" name="visit_time_start" value="${data.visit[0].start_time}" placeholder="Start time" data-mask="99:99" onchange="validateHhMm(this)" required/>
                                    </div>
                                    <div class="input-group date u-grid10 u-floatLeft" id="visit_time_end">
                                        <p class="paragraph">End time</p>
                                        <input type="text" class="action-border input-lg form-control" name="visit_time_end" value="${data.visit[0].end_time}" placeholder="End time" data-mask="99:99" onchange="validateHhMm(this)" required/>
                                    </div>
                                </div>
                                <div class="u-marginTopSmall">
                                    <label class="check-element" id="">
                                        <input type="checkbox" class="check-button" name="allday" checked onclick="visit_allday_check(this)">
                                        <i class="checkbox fa"></i>
                                        <span class="paragraph">
                                            All Day
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="row no-margin u-marginTopSmaller u-paddingBottom">
                                <div class="input-group u-grid10" id="">
                                    <h3 class="headingTwo u-marginTop">Team reminder</h3>
                                    <label class="fa select-label label-lg" style="display: block">
                                        <select class="input-lg form-control action-border" name="visit_reminder" onchange="">
                                        @{{if data.visit[0].visit_reminder == '0'}}
                                            <option value="0" selected>No reminder set</option>
                                        @{{else}}
                                            <option value="0">No reminder set</option>
                                        @{{/if}}
                                        @{{if data.visit[0].visit_reminder == '1'}}
                                            <option value="1" selected>At start of task</option>
                                        @{{else}}
                                            <option value="1">At start of task</option>
                                        @{{/if}}
                                        @{{if data.visit[0].visit_reminder == '2'}}
                                            <option value="2" selected>30 minutes before</option>
                                        @{{else}}
                                            <option value="2">30 minutes before</option>
                                        @{{/if}}
                                        @{{if data.visit[0].visit_reminder == '3'}}
                                            <option value="3" selected>1 hours before</option>
                                        @{{else}}
                                            <option value="3">1 hours before</option>
                                        @{{/if}}
                                        @{{if data.visit[0].visit_reminder == '4'}}
                                            <option value="4" selected>2 hours before</option>
                                        @{{else}}
                                            <option value="4">2 hours before</option>
                                        @{{/if}}
                                        @{{if data.visit[0].visit_reminder == '5'}}
                                            <option value="5" selected>5 hours before</option>
                                        @{{else}}
                                            <option value="5">5 hours before</option>
                                        @{{/if}}
                                        @{{if data.visit[0].visit_reminder == '6'}}
                                            <option value="6" selected>24 hours before</option>
                                        @{{else}}
                                            <option value="6">24 hours before</option>
                                        @{{/if}}
                                        </select>
                                    </label>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 u-borderTop medium-expand">
                            <h3 class="headingTwo u-marginTop u-marginBottomBig">Assigned to</h3>
                            <input type="hidden" name="visit_team_ids" id="visit_team_ids" value="${data.visit[0].member_id}" />
                            <select data-placeholder="Choose Team..." class="chosen-select-visit" multiple style="width:100%;" tabindex="4" onchange="visit_selectTeam(this)" id="">
                                @foreach($data['teams'] as $team)
                                    <option value="{{$team->team_member_id}}">{{$team->fullname}}</option>
                                @endforeach
                            </select>
                            <label class="check-element">
                                <input type="checkbox" class="check-button" name="visit_notify" value="1">
                                <i class="checkbox fa"></i>
                                <span class="paragraph">
                                   Notify team by email
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <h3 class="headingTwo u-marginTop">Job Details</h3>
                    <input type="hidden" name="job_id" value="{{$data['job'][0]->job__id}}" />
                    <input type="hidden" name="job_type" value="{{$data['job'][0]->job_type}}" />
                    <table class="table no-border">
                        <tr>
                            <td class="no-border"><p class="paragraph">Job #</p></td>
                            <td class="no-border"><div style="line-height: 25px;">{{$data['job'][0]->job__id}}</div></td>
                        </tr>
                        <tr>
                            <td class="no-border"><p class="paragraph">Client</p></td>
                            <td class="no-border"><a href="{{url('dashboard/clients/detail')}}/{{$data['job'][0]->client_id}}" style="line-height: 25px;">{{$data['job'][0]->first_name}} {{$data['job'][0]->last_name}}</a></td>
                        </tr>
                        <tr>
                            <td class="no-border"><p class="paragraph">Phone</p></td>
                            <td class="no-border">
                            @if(isset($data['contact']))
                                @foreach($data['contact'] as $one)
                                    @if($one->type == 1)
                                        <div href="" style="line-height: 25px;">{{$one->value}}</div>
                                    @endif
                                @endforeach
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="no-border"><p class="paragraph">Address</p></td>
                            <td class="no-border"><a href="{{url('dashboard/properties/detail')}}/{{$data['job'][0]->property_id}}" style="line-height: 25px;">
                                {{$data['job'][0]->street1}} {{$data['job'][0]->street2}}<br>
                                {{$data['job'][0]->city}} {{$data['job'][0]->state}},  {{$data['job'][0]->zip_code}}
                            </a></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" id="">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h3 class="headingTwo">Line items</h3>
                        </div>
                        <div class="ibox-content table-content">
                            <table class="table lineitemTable text-right">
                                <thead>
                                    <tr>
                                        <th width="50%" align="left">
                                            <h4 class="headingTwo">SERVICE / PRODUCT</h4>
                                        </th>
                                        <th width="10%" class="text-right">
                                            <h4 class="headingTwo">QTY.</h4>
                                        </th>
                                        <th width="15%" class="text-right">
                                            <h4 class="headingTwo">UNIT COST ($)</h4>
                                        </th>
                                        <th width="15%" class="text-right">
                                            <h4 class="headingTwo">TOTAL ($)</h4>
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="lineItemBox">
                                    @{{each data.services}}
                                        <tr class="">
                                            <td>
                                                <h3 class="headingTwo service-val text-left">${data.services[$index].service_name}</h3>
                                                <p class="paragraph descript-val text-left">${data.services[$index].service_description}</p>
                                            </td>
                                            <td>
                                                <input type="hidden" name="service[${$index}][service_id]" value="${data.services[$index].visit_service_id}">
                                                <input type="text" name="service[${$index}][quantity]" value="${data.services[$index].quantity}" class="form-control action-border input-lg">
                                            </td>
                                            <td>
                                                <p class="paragraph cost-val">-</p>
                                            </td>
                                            <td>
                                                <p class="paragraph total-val">-</p>
                                            </td>
                                            <td>
                                                <a data-id="${data.services[$index].visit_service_id}" onclick="visit_service_delete(this);" class="service-close">×</a>
                                            </td>
                                        </tr>
                                    @{{/each}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
</div>
</script>

@stop