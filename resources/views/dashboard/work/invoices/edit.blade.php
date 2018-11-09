@extends('layout.menu')
@section('content')
<link rel="stylesheet" type="text/css" href="{{url('public/css/plugins/chosen/chosen.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/plugins/combobox/bootstrap-combobox.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/plugins/kendo/kendo.common-material.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/plugins/kendo/kendo.rtl.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/plugins/kendo/kendo.material.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/workcustom.css')}}">
<div class="invoice-edit">
    <div class="col-md-12">
        <div class="ibox">
            <div class="invoice-main-body">
                <div class="ibox-content no-border">
                    <div class="row">
                    @foreach ($clientinfos as $clientinfo)
                    <form class="work_order" action="{{url('dashboard/work/invoices/update/')}}" id="new_work_order" method="post">
                    {{ csrf_field() }}
                        <div class="col-md-12">
                            <h1 class="headingOne">Invoices for {{$clientinfo->first_name}} {{$clientinfo->last_name}}
                        </div>
                        <div class="col-md-7">
                            <div class="invoice-client">
                                </h1>
                                <input type="hidden" name="invoice[client_id]" id="client_id" value="{{$clientinfo->client_id}}">
                                <input type="hidden" name="invoice[invoice_id]" id="invoice_id" value="{{$clientinfo->invoice_id}}">
                                
                                <input type="hidden" name="invoice[property_id]" id="property_id" value="{{$clientinfo->property_id}}">
                                <div class="">
                                    <h3 class="headingFive">Invoice description</h5>
                                    <input type="text" name="invoice[description]" placeholder="Description" value="{{$clientinfo->description}}" 
                                    class="description action-border" />
                                </div>
                                <div class="invoice-property-address">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="client-address-title grey-title"><strong>Property address</strong></p>
                                            <p class="client-address-info">{{$clientinfo->street1}} {{$clientinfo->street2}}<br>{{$clientinfo->city}}, {{$clientinfo->state}}</p>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                        <div class="col-md-5 white-bg" style="padding: 0 15px;">
                            <h3 class="headingFive">Invoice details</h3>
                            <ul class="header-list">
                                <li class="list-item font-p14 align-middle">
                                    <div class="col-md-4">
                                        <span>Issued Date</span>
                                    </div> 
                                    <div class="col-md-8">
                                        @if($clientinfo->issue_date == null)
                                        <div class="col-md-8">
                                            <span class="date-sent">Date Sent</span>
                                        </div>
                                        <div class="custom-issue-date" style="display: none;">
                                            <div class="col-md-8">
                                                <div class="input-group date" id="issuedate">
                                                    <input type="text" class="action-border form-control input-group-addon text-center" name="invoice[issuedate]" />
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-white" onclick="hiddenisuue()">Cancel</button>
                                        </div>
                                        @else
                                        <span class="date-sent" style="display: none;">Date Sent</span>
                                        <div class="custom-issue-date">
                                            <div class="col-md-8">
                                                <div class="input-group date" id="issuedate">
                                                    <input type="text" class="action-border form-control input-group-addon text-center" name="invoice[issuedate]" value="{{$clientinfo->issue_date}}" />
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-white" onclick="hiddenisuue()">Cancel</button>
                                        </div>
                                        @endif
                                    </div>
                                </li>
                                <li class="list-item font-p14 align-middle">
                                    <div class="col-md-4">
                                        <span>Payment Due</span>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="col-md-8">
                                            <span class="date-due" style="display: none;">Net 30</span>
                                        </div>
                                        <div class="custom-due-type" style="">
                                            <div class="col-md-8">
                                                <label class="fa select-label">
                                                    <select id="due-option" class="show-option action-border">
                                                        <option value="1" <?php echo $clientinfo->pay_due_type == 1? "selected": "";?>>Upon receipt</option>
                                                        <option value="2" <?php echo $clientinfo->pay_due_type == 2? "selected": "";?>>Net 15day</option>
                                                        <option value="3" <?php echo $clientinfo->pay_due_type == 3? "selected": "";?>>Net 30day</option>
                                                        <option value="4" <?php echo $clientinfo->pay_due_type == 4? "selected": "";?>>Net 45day</option>
                                                        <option value="5" <?php echo $clientinfo->pay_due_type == 5? "selected": "";?>>Custom</option>
                                                    </select>
                                                </label>
                                                <input type="hidden" name="invoice[due_type]" class="due_type" value="3">
                                            </div>
                                            <button type="button" class="btn btn-sm btn-white" onclick="hiddendue()">Cancel</button>
                                        </div>
                                    </div>
                                </li>
                                @if($clientinfo->pay_due_type == 5)
                                <li class="list-item font-p14 align-middle duecustom">
                                    <div class="col-md-4">
                                        <span>Due Date</span>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="custom-due-date">
                                            <div class="col-md-12">
                                                <div class="input-group date" id="duedate">
                                                    <input type="text" class="action-border form-control input-group-addon text-center" name="invoice[due_date]" value="{{$clientinfo->payment_date}}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @else
                                <li class="list-item font-p14 align-middle duecustom" style="display: none;">
                                    <div class="col-md-4">
                                        <span>Due Date</span>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="custom-due-date">
                                            <div class="col-md-12">
                                                <div class="input-group date" id="duedate">
                                                    <input type="text" class="action-border form-control input-group-addon text-center" name="invoice[due_date]" value="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endif
                            </ul>    
                        </div>
                        <div class="col-md-12">
                             <div class="row">
                                <div class="col-md-12" id="lineItem">
                                    <div class="ibox">
                                        <div class="ibox-content table-content">
                                            <table class="table lineitemTable text-right">
                                                <thead>
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
                                                </thead>
                                                <tbody id="lineItemBox">
                                                <input type="hidden" value="{{$i = 0}}"></input>
                                                @foreach($serviceinfos as $serviceinfo)
                                                    <tr>
                                                        <input type="hidden" name="invoice[lineitem][{{$i}}][invoice_service_id]" class="invoice_service_id" value="{{$serviceinfo->invoice_service_id}}">
                                                        <td>
                                                            <i class="jobber-icon jobber-2x jobber-sort"></i>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" class="action-border  form-control service_id" name="invoice[lineitem][{{$i}}][service_id]" value="{{$serviceinfo->service_id}}" required="" />
                                                            <input type="text" class="form-control grey-title" name="invoice[lineitem][{{$i}}][name]" id="servicelist_{{$i}}" required="" onchange="selectService(this)" value="{{$serviceinfo->service_name}}" style="width: 100%;">
                                                            <textarea class="action-border form-control service" value="" rows="3" name="invoice[lineitem][{{$i}}][description]"  required="">{{$serviceinfo->service_description}}</textarea>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="action-border  form-control text-right quantity" name="invoice[lineitem][{{$i}}][quantity]" value="{{$serviceinfo->quantity}}" required="" onchange="setquantity(this);" />
                                                        </td>
                                                        <td>
                                                            <input type="text" class="action-border  form-control text-right unitcostval" value="{{$serviceinfo->cost}}"  name="invoice[lineitem][{{$i}}][unitcost]" required="" onchange="setcost(this);" />
                                                        </td>
                                                        <td>
                                                            <input type="text" id="total" class="action-border form-control text-right total" value="{{$serviceinfo->cost*$serviceinfo->quantity}}"/>
                                                            <button type="button" class="btn btn-white btn-xs del-product-btn pull-right"  onclick="deleterow(this);">Delete</button>
                                                        </td>
                                                    </tr>
                                                <input type="hidden" value="{{$i++}}">
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <hr style="width: 100%;border:#eee 1px solid;">
                                            <button type="button" class="btn-invoices addItem-btn">Add Line item</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" id="message-sub">
                                    <div class="col-md-6" id="message-send">
                                        <div class="invoice-main-footer-first">
                                            <textarea class="action-border form-control" name="invoice[message]" value="" rows="5" placeholder="Client Messages">{{$clientinfo->client_message}}</textarea>
                                            <!-- <div class="message-client-view">
                                                <div class="col-md-12">
                                                    <span><i class="jobber-icon jobber-2x jobber-eye" style="margin-right: 5px;"></i>Client View</span>
                                                    <a class="message-view-option">Change</a>
                                                    <button type="button" class="btn btn-xs btn-cancel">Cancel</a>
                                                </div>
                                            </div>
                                            <div class="message-client-option">
                                                <div class="col-md-12">
                                                    <p>Adjust what your client will see on this invoice. To change the default for all feature invoices, view PDF configration.</p>
                                                </div>
                                                <div class="option-setting">
                                                    <div class="option-setitem">
                                                        <label class="check-element">
                                                            <input type="checkbox" name="quantities" value="1" class="quantities">
                                                            <i class="checkbox fa"></i>Quantities
                                                        </label>
                                                    </div>
                                                    <div class="option-setitem">
                                                        <label class="check-element">
                                                            <input type="checkbox" name="unitcost" class="unitcost" value="2">
                                                            <i class="checkbox fa"></i>Unit cost
                                                        </label>
                                                    </div>
                                                    <div class="option-setitem">
                                                        <label class="check-element">
                                                            <input type="checkbox" name="linetotal" class="linetotal" value="3">
                                                            <i class="checkbox fa"></i>Line item totals
                                                        </label>
                                                    </div>
                                                    <div class="option-setitem">
                                                        <label class="check-element">
                                                            <input type="checkbox" name="totals" class="totals" value="4">
                                                            <i class="checkbox fa"></i>Totals
                                                        </label>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="sub-info">
                                        <div class="invoice-main-footer-second">
                                        <ul class="subinfo-list"> 
                                            <li class="list-item">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6 text-left">
                                                            <span class="subtotal">Subtotal</span>
                                                        </div>
                                                        <div class="col-md-6 text-right">
                                                            <span class="pull-right">
                                                                <span>$</span>
                                                                <span class="subtotal-value">0.00</span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-item">
                                            @if($clientinfo->discount)
                                            <div class="col-md-12" id="discount-default" style="display: none;">
                                                <div class="row div-flex">
                                                    <div class="col-md-6 text-left">
                                                        <span class="discount">Discount</span>
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <span class="discount-value-note">
                                                            Add Discount
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12" id="discount-update" style="display: block;">
                                            <div class="row align-middle div-flex">
                                                <div class="col-md-3 text-left">
                                                    <span class="discount-value-type pull-left">Discount</span>
                                                </div>
                                                <div class="col-md-6 text-center">
                                                    <div class="discount-edit">
                                                        <div class="input-group" style="margin: 0 auto;">
                                                            <input step="1" type="number" value="{{$clientinfo->discount}}" name="invoice[discount_rate]" id="invoice_discount_rate" class="numberInput action-border"/>
                                                            <select name="invoice[discount_type]" id="invoice_discount_type" class="action-border"><option <?php echo $clientinfo->discount_percent == 1 ? "selected": ""; ?> value="1">$</option>
                                                            <option <?php echo $clientinfo->discount_percent == 2 ? "selected": ""; ?> value="2">%</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="row div-flex align-middle pull-right">  
                                                        <span>
                                                            <span>$</span>
                                                            <span class="discount-val">0.0</span>
                                                        </span>&nbsp&nbsp&nbsp&nbsp
                                                        <a class="del-discount"><i class="jobber-icon jobber-2x jobber-trash"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                            @else
                                            <div class="col-md-12" id="discount-default">
                                                <div class="row div-flex">
                                                    <div class="col-md-6 text-left">
                                                        <span class="discount">Discount</span>
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <span class="discount-value-note">
                                                            Add Discount
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12" id="discount-update">
                                                <div class="row align-middle div-flex">
                                                    <div class="col-md-3 text-left">
                                                        <span class="discount-value-type pull-left">Discount</span>
                                                    </div>
                                                    <div class="col-md-6 text-center">
                                                        <div class="input-group discount-edit" style="margin: 0 auto;">
                                                            <input step="1" type="number" value="0" name="invoice[discount_rate]" id="invoice_discount_rate" class="numberInput action-border"/>
                                                            <select name="invoice[discount_type]" id="invoice_discount_type" class="action-border"><option selected="selected" value="1">$</option>
                                                            <option value="2">%</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="row div-flex align-middle pull-right">  
                                                            <span>
                                                                <span>$</span>
                                                                <span class="discount-val">0.0</span>
                                                            </span>&nbsp&nbsp&nbsp&nbsp
                                                            <a class="del-discount"><i class="jobber-icon jobber-2x jobber-trash"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            </li>
                                            <li class="list-item">
                                            @if($clientinfo->tax)
                                            <div class="col-md-12">
                                                <div class="row align-middle div-flex">
                                                    <div class="col-md-6">
                                                        <span class="tax pull-left">Tax({{$clientinfo->tax}}%)</span>
                                                        <input type="hidden" class="taxval" name="invoice[tax]" value="{{$clientinfo->tax}}" />   
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row div-flex align-middle pull-right">
                                                        <span class="tax-value pull-right">
                                                            <button data-toggle="popover" class="btn btn-sm btn-white tax-btn" data-container="body" data-trigger="focus" data-placement="left" title="Select Tax Rate" type="button" data-html="true" id="login" style="display: none;">
                                                                Add Tax
                                                              </button>
                                                            <div id="pop-content" class="hide">
                                                                <div class="pop-body">
                                                                    <div class="pop-list">
                                                                        <ul class="tax-rate-list" style="list-style: none;margin-left:-30px;">
                                                                            @foreach($taxs as $tax)
                                                                            <li>
                                                                                <label class="radio-element">
                                                                                    <input type="radio" class="check-button" data-name="{{$tax->name}}" name="taxcheck" value="{{$tax->value}}" onclick="gettaxrate(this);">
                                                                                    <i class="fa"></i>
                                                                                    <span>
                                                                                       {{$tax->name}}({{$tax->value}}%)
                                                                                    </span>
                                                                                </label>
                                                                            </li>
                                                                            @endforeach
                                                                        </ul>
                                                                        <hr>
                                                                        <a data-toggle="modal" href="#modal-create-tax" class="create-tax-btn" style="font-size: 12px;color: #7db00e;"><strong>+Create a Tax Rate</strong></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </span>
                                                        <span class="tax_val"></span>&nbsp&nbsp&nbsp&nbsp
                                                        <a class="del-taxrate pull-right" style="display: block;"><i class="jobber-icon jobber-2x jobber-trash" onclick="deltaxrate(this);"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            <div class="col-md-12">
                                                <div class="row align-middle div-flex">
                                                    <div class="col-md-6">
                                                        <span class="tax pull-left">Tax</span>
                                                        <input type="hidden" class="taxval" name="invoice[tax]" value="0" />   
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row div-flex align-middle pull-right">
                                                            <span class="tax-value pull-right">
                                                                <button data-toggle="popover" class="btn btn-sm btn-white tax-btn pull-right" data-container="body" data-trigger="focus" data-placement="left" title="Select Tax Rate" type="button" data-html="true" id="login" >
                                                                    Add Tax
                                                                  </button>
                                                                <div id="pop-content" class="hide">
                                                                    <div class="pop-body">
                                                                        <div class="pop-list">
                                                                            <ul class="tax-rate-list" style="list-style: none;margin-left:-30px;">
                                                                                @foreach($taxs as $tax)
                                                                                <li>
                                                                                    <label class="radio-element">
                                                                                        <input type="radio" class="check-button" data-name="{{$tax->name}}" name="taxcheck" value="{{$tax->value}}" onclick="gettaxrate(this);">
                                                                                        <i class="fa"></i>
                                                                                        <span>
                                                                                           {{$tax->name}}({{$tax->value}}%)
                                                                                        </span>
                                                                                    </label>
                                                                                </li>
                                                                                @endforeach
                                                                            </ul>
                                                                            <hr>
                                                                            <a data-toggle="modal" href="#modal-create-tax" class="create-tax-btn" style="font-size: 12px;color: #7db00e;"><strong>+Create a Tax Rate</strong></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </span>
                                                            <span class="tax_val"></span>&nbsp&nbsp&nbsp&nbsp
                                                            <a class="del-taxrate pull-right">
                                                                <i class="jobber-icon jobber-2x jobber-trash" onclick="deltaxrate(this);"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            </li>
                                            <li class="list-item bottom-border-fat">
                                                <div class="col-md-12">
                                                    <strong><p class="total-all pull-left">Total</p></strong>
                                                    <strong><p class="pull-right"><span>$</span><span class="total-all-value">0.0</span></p></strong>
                                                </div>
                                            </li>
                                            <li class="list-item">
                                                @if($clientinfo->deposit)
                                                <div class="col-md-12" id="deposit-default" style="display: none;">
                                                    <div class="row div-flex">
                                                        <div class="col-md-6 text-left">
                                                            <span class="deposit-titile">Required deposit</span>
                                                        </div>
                                                        <div class="col-md-6 text-right">
                                                            <a class="deposit-value-note">Add Required Deposit</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="deposit-update" style="display: block;">
                                                    <div class="row align-middle div-flex">
                                                        <div class="col-md-3 text-left">
                                                            <span class="pull-left">Deposit</span>
                                                        </div>
                                                        <div class="col-md-6 text-center">
                                                            <div class="deposit-edit">
                                                                <div class="input-group" style="margin: 0 auto;">
                                                                    <input step="1" type="number" value="{{$clientinfo->deposit}}" name="invoice[deposit_rate]" id="invoice_deposit_rate" class="numberInput action-border"/>
                                                                    <select name="invoice[deposit_type]" id="invoice_deposit_type" class="action-border">
                                                                        <option <?php $clientinfo->deposit_percent == 1 ? "selected" : "" ; ?> value="1">$</option>
                                                                        <option <?php $clientinfo->deposit_percent == 2 ? "selected" : "" ; ?> value="2">%</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="row div-flex align-middle pull-right">
                                                                <span>
                                                                    <span>$</span><span class="depositone-value">0.0</span>
                                                                </span>&nbsp&nbsp&nbsp&nbsp
                                                                <a class="del-deposit">
                                                                    <i class="jobber-icon jobber-2x jobber-trash"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @else
                                                <div class="col-md-12" id="deposit-default">
                                                    <div class="row div-flex">
                                                        <div class="col-md-6 text-left">
                                                            <span class="deposit-titile">Required deposit</span>
                                                        </div>
                                                        <div class="col-md-6 text-right">
                                                            <a class="deposit-value-note">Add Required Deposit</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="deposit-update">
                                                    <div class="row align-middle div-flex">
                                                        <div class="col-md-3 text-left">
                                                            <span class="pull-left">Deposit</span>
                                                        </div>
                                                        <div class="col-md-6 text-center">
                                                            <div class="deposit-edit">
                                                                <div class="input-group" style="margin: 0 auto;">
                                                                    <input step="1" type="number" value="0" name="invoice[deposit_rate]" id="invoice_deposit_rate" class="numberInput action-border"/>
                                                                    <select name="invoice[deposit_type]" id="invoice_deposit_type" class="action-border">
                                                                        <option selected="selected" value="1">$</option>
                                                                        <option value="2">%</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="row div-flex align-middle pull-right">  
                                                                <span>
                                                                    <span>$</span><span class="depositone-value">0.0</span>
                                                                </span>&nbsp&nbsp&nbsp&nbsp
                                                                <a class="del-deposit">
                                                                    <i class="jobber-icon jobber-2x jobber-trash"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </li>
                                        </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <div class="control-group">
                                <a type="button" href="{{url('/dashboard/work/invoices/delete')}}/{{$clientinfo->invoice_id}}" class="btn btn-white del-invoice-btn pull-left" tabindex="-1">Delete</a>
                                <input type="hidden" class="submit-flag" name="submit-flag" value="0">
                                <a class="btn cancelAdd-btn  button--greyBlue button--ghost" tabindex="-1" href="{{url('/dashboard/work/invoices')}}">Cancel</a>
                                <div class="btn-group dropup">
                                    <button class="btn action-btn" type="submit"><strong>Update invoice</strong></button>
                                    <button data-toggle="dropdown" class="btn dropdown-toggle action-btn" aria-haspopup="true" aria-expanded="false"><span class="fa fa-chevron-down"></span></button>
                                    <ul class="dropdown-menu">
                                        <div class="col-md-12" style="padding: 10px;">Save and...</div>
                                        <li>
                                            <a class="sendmail">
                                                <span class="align-middle " style="display: flex;">
                                                    <i class="jobber-icon jobber-2x jobber-email"></i>
                                                    <span><strong>&nbsp&nbspEmail to Client</strong></span>
                                                </span>
                                            </a>
                                        </li>
                                        @if($clientinfo->status != 3)
                                        <li>
                                            <a class="record-payment">
                                                <span class="align-middle markaspaid" style="display: flex;">
                                                    <i class="jobber-icon jobber-2x jobber-marksent orange-tag"></i>
                                                    <span><strong>&nbsp&nbspRecord Payment</strong></span>
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal inmodal" id="modal-create-tax" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title headingTwo text-left">Create a Tax Rate</h4>
                    </div>
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="panel-body">
                            <div class="panel-group">
                                <div class="panel-collapse collapse in">
                                    <div class="panel-content">
                                        <div class="input-group">
                                            <input type="text" class="action-border form-control u-grid5" name="taxname" placeholder="Tax name" value="" required="" />
                                            <input type="number" class="action-border form-control u-grid5" name="taxvalue" placeholder="Tax Rate" value="" required="" />
                                            <input type="text" class="action-border form-control" name="taxdescription" placeholder="Internal Description" value="" required="" />
                                        </div>
                                        <div class="input-group">
                                            <label class="check-element">
                                                <input type="checkbox" class="check-button taxdefault" name="taxdefault" value="-1">
                                                <i class="checkbox fa"></i>
                                                <span>
                                                    Make default for new quotes and invoices
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-quotes create-tax-rate">Create Tax Rate</button>
                    </div>
                </div>
            </div>
        </div>
        
    <script type="text/javascript">
        $("[data-toggle=popover]").popover({
            html: true, 
            content: function() {
                return $('#pop-content').html();
            }
        });
    </script>
    <script type="text/javascript">
    $(document).ready(function(){
        var invoicenum = {{$i}};
        var total = 0;

        var servicenum = {{count($serviceinfos)}} - 1;
        for (var num = 0; num <= servicenum; num++) {
            var id = 'servicelist_' + num;
            createCombo(id);
        }

        $('.saveinvoice').on('click', function(){
            $('#new_work_order').submit();
        });
        $('.sendmail').click(function(){
            $('.submit-flag').val('1');
            $('#new_work_order').submit();
        });
        $('.record-payment').click(function(){
            $('.submit-flag').val('2');
            $('#new_work_order').submit();
        });

        $('#issuedate').datepicker({
            format: 'yyyy-mm-dd',
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        $('#duedate').datepicker({
            format: 'yyyy-mm-dd',
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        
        var stars = $('.rating-stars').children().children('li.star');

        for (var i = 0; i < $('.rating').val(); i++) {
            $(stars[i]).addClass('selected');
        }
        /* 1. Visualizing things on Hover - See next part for action on click */
        $('#stars li').on('mouseover', function(){
            var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

            // Now highlight all the stars that's not after the current hovered star
            $(this).parent().children('li.star').each(function(e){
              if (e < onStar) {
                $(this).addClass('hover');
              }
              else {
                $(this).removeClass('hover');
              }
            });

            }).on('mouseout', function(){
                $(this).parent().children('li.star').each(function(e){
                  $(this).removeClass('hover');
                });
        });

        /* 2. Action to perform on click */
        $('#stars li').on('click', function(){
            var onStar = parseInt($(this).data('value'), 10); // The star currently selected
            var stars = $(this).parent().children('li.star');
            $('.rating').val(onStar);
            for (i = 0; i < stars.length; i++) {
              $(stars[i]).removeClass('selected');
            }

            for (i = 0; i < onStar; i++) {
              $(stars[i]).addClass('selected');
            }
        });

        $('.taxdefault').on('change',function() {
            var $input = $( this );
            if($input.is( ":checked" )) {
                $input.val(1);
            }else {
                $input.val(-1);
            }
        });

        $('.create-tax-rate').click(function(){
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
            var formData = new FormData();
            formData.append('_token', $('input[name=_token]').val());
            formData.append('name', $('input[name=taxname]').val());
            formData.append('value', $('input[name=taxvalue]').val());
            formData.append('description', $('input[name=taxdescription]').val());
            formData.append('default', $('input[name=taxdefault]').val());
            $.ajax({
                url: "{{url('dashboard/work/createtax')}}",
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (data) {
                    $('body').waitMe("hide");
                    $('#modal-create-tax').modal('hide');
                    $('.tax').html(data['name']+'('+data['value']+'%)');
                    $('.taxval').val(data['value']);
                    $('.tax-btn').hide();
                    $('.del-taxrate').show();
                    setallvalue();
                    $('.tax-rate-list').append('<li><label class="radio-element"><input type="radio" class="check-button" data-name="'+data["name"]+'" name="taxcheck" value="'+data["value"]+'" onclick="gettaxrate(this);"><i class="fa"></i><span>'+data["name"]+'('+data["value"]+'%)</span></label><li>');
                }
            });
        });
        
        $('.textAction').click(function(){
            $(this).parent().hide();
            $('.numberInputWrapper').show();
        });
        
        $('.addItem-btn').click(function(){
            invoicenum++;
            var addHtml = $('#editlineItemRow').tmpl({
                i: invoicenum,
            }).html();
            $('#lineItemBox').append(addHtml);
            createCombo('servicelist_' + invoicenum);
            if($('.lineitemTable > tbody > tr').length < 2){
                $('.lineitemTable > tbody > tr .del-product-btn').css('display','none');
            }else{
                $('.lineitemTable > tbody > tr .del-product-btn').css('display','inline');
            };
            return false;
        });
        // $('.del-product-btn').click(function(){
        //     $('.del-product-btn').parent().parent().remove();
        // });
        $('.total').each(function(){
            total += Number(parseFloat($(this).val()));
        });
        $('.subtotal-value').html(total);
        
        
        $('.message-view-option').on('click',function(){
            $('.message-view-option').hide();
            $('.btn-cancel').show();
            $('.message-client-option').show();
        });
        $('.btn-cancel').on('click', function(){
            $('.message-view-option').show();
            $('.btn-cancel').hide();
            $('.message-client-option').hide();
        });
        $('#invoice_discount_rate').on('change', function(){
            // $('.discount-value-type').html($('#invoice_discount_type').val());
            $('.discount-value').html($('#invoice_discount_rate').val());
        });
        $('#invoice_discount_type').on('change', function(){
            // $('.discount-value-type').html($('#invoice_discount_type').val());
            $('.discount-value').html($('#invoice_discount_rate').val());
        });
        $('#invoice_deposit_rate').on('change', function(){
            $('.deposit-value-type').html($('#invoice_deposit_type').val());
            $('.deposit-value').html($('#invoice_deposit_rate').val());
        });
        $('#invoice_deposit_type').on('change', function(){
            $('.deposit-value-type').html($('#invoice_deposit_type').val());
            $('.deposit-value').html($('#invoice_deposit_rate').val());
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
        $('.client').click(function(){
            var clientId = $(this).children('input[type=hidden]').val()
            $('#client').modal('hide');
            $('#property').modal('show');
        })
        setallvalue();
    });
    function selectService(obj){
        var row_id = $(obj).parent().find('.k-input').attr('aria-activedescendant');
        var selectedRow = $('li[id='+ row_id +']').children('div');
        var description = selectedRow.attr('data-description');
        var service_id = selectedRow.attr('data-id');
        var service_unit = selectedRow.attr('data-unit');
        if (typeof(service_unit) == "undefined") {
            service_unit = 0;
        }
        var quantity = $(obj).parent().parent().parent().find('.quantity').val();
        var total = Number(quantity)*Number(service_unit);
        $(obj).parent().parent().children('textarea').text(description);
        $(obj).parent().parent().children('.service_id').val(service_id);
        $(obj).parent().parent().parent().find('.unitcostval').val(service_unit);
        $(obj).parent().parent().parent().find('.total').val(total);
        setallvalue();
    }

    $('.del-discount').on('click', function(){
        $('#discount-default').show();
        $('#discount-update').hide();
        $('#invoice_discount_rate').val(0);
        setallvalue();
    });
    $('.discount-value-note').on('click', function(){
        $('#discount-default').hide();
        $('#discount-update').show();
        setallvalue();
    });
    $('.del-deposit').on('click', function(){
        $('#deposit-default').show();
        $('#deposit-update').hide();
        $('#invoice_deposit_rate').val(0);
        setallvalue();
    });
    $('.deposit-value-note').on('click', function(){
        $('#deposit-default').hide();
        $('#deposit-update').show();
        setallvalue();
    });
    
    function setallvalue(){
        var subtotalval = 0;
        var discount = 0;
        var tax = 0;
        var deposit = 0;
        var totalall = 0;
        $('.total').each(function(){
            subtotalval += Number((Number($(this).val())).toFixed(2));
        });
        if($('#invoice_discount_type').val() == "1"){
            discount = $('#invoice_discount_rate').val();
        } else if($('#invoice_discount_type').val() == "2"){
            discount = Number((Number($('#invoice_discount_rate').val())*Number($('.subtotal-value').html())/100).toFixed(2));
        }
        tax = Number((Number($('.taxval').val())*Number(subtotalval-discount)/100).toFixed(2));
        // console.log(tax)
        totalall = Number((subtotalval - discount + tax).toFixed(2));
        if($('#invoice_deposit_type').val() == "1"){
            deposit = Number($('#invoice_deposit_rate').val());
        } else if($('#invoice_deposit_type').val() == "2"){
            deposit = Number((Number($('#invoice_deposit_rate').val())*Number(totalall)/100).toFixed(2));
        }
        
        $('.subtotal-value').html(subtotalval);
        $('.discount-val').html(discount);
        if (tax) {
            $('.tax_val').html('$'+tax);
        }else{
            $('.tax_val').css('display','none');
        }
        $('.total-all-value').html(totalall);
        $('.depositone-value').html(deposit);
    }
    function gettaxrate(id){
        
        $('.tax').html($(id).data('name')+'('+$(id).val()+'%)');
        $('.taxval').val($(id).val());
        $('.tax-btn').hide();
        $('.tax_val').show();
        $('.del-taxrate').show();
        setallvalue();
    }
    function deltaxrate(id){
        $(id).parent().hide();
        $('.tax-btn').show();
        $('.tax').html('Tax');
        $('.taxval').val(0);
        setallvalue();
    }
    function deleterow(id){
        $(id).parent().parent().remove();
        setallvalue();
        var invoice_service_id = $(id).parent().parent().find('.invoice_service_id').val();
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
            url: "{{url('dashboard/work/invoices/delservice')}}",
            data: {
                '_token': $('input[name=_token]').val(),
                'invoice_service_id': invoice_service_id,
            },
            type: 'POST',
            success: function (data) {
                $('body').waitMe("hide");
            }
        });
    }

    function setquantity(obj){
        var subtotalval = 0;
        var totalall = 0;
        var discount = 0;
        var tax = 0;
        with (Math){
            total = Number($(obj).val())*Number($(obj).parent().parent().children().children('.unitcostval').val());
        }
        $(obj).parent().parent().children().children('.total').val(total);
        
        setallvalue();

    }
    function setcost(obj){
        var subtotalval = 0;
        var totalall = 0;
        var discount = 0;
        var tax = 0;
        with (Math){
            total = Number($(obj).val())*Number($(obj).parent().parent().children().children('.quantity').val());
        }
        $(obj).parent().parent().children().children('.total').val(total);
        setallvalue();
    }

    function hiddenisuue() {
        $('.custom-issue-date').hide();
        $('.date-sent').show();
        $('#issuedate input').val('');
    }

    $('.date-sent').click(function(){
        $('.custom-issue-date').show();
        $('.date-sent').hide();
        $('#issuedate input').val('<?php echo date('Y-m-d')?>');
    });

    function hiddendue() {
        $('.custom-due-type').hide();
        $('.date-due').show();
        $('.duecustom').hide();
        $('#duedate input').val('');
        $('#due-option').children('option').attr('selected', false);
        $('#due-option option:nth-child(3)').attr('selected', true);
        $('.due_type').val(3);
    }

    $('.date-due').click(function(){
        $('.custom-due-type').show();
        $('.date-due').hide();
    });

    $('#due-option').change(function(){
        var due = $('#due-option').val();
        if (due == '5') {
            $('.duecustom').show();
        }else{
            $('.duecustom').hide();
        }
        $('.due_type').val(due);
    });

    $('#invoice_discount_rate').on('change', function(){
        // $('.discount-value-type').html($('#invoice_discount_type').val());
        // $('.discount-value').html($('#invoice_discount_rate').val());

        var discount = 0;
        if($('#invoice_discount_type').val() == "1"){
            discount = $('#invoice_discount_rate').val();
        } else if($('#invoice_discount_type').val() == "2"){
            discount = parseFloat($('#invoice_discount_rate').val())*parseFloat($('.subtotal-value').html())/100;
        }
        setallvalue();

    });
    
    $('#invoice_discount_type').on('change', function(){
        setallvalue();
    });
    $('#invoice_deposit_rate').on('change', function(){
        $('.deposit-value-type').html($('#invoice_deposit_type').val());
        $('.deposit-value').html($('#invoice_deposit_rate').val());

        setallvalue();
    });
    $('#invoice_deposit_type').on('change', function(){
        $('.deposit-value-type').html($('#invoice_deposit_type').val());
        $('.deposit-value').html($('#invoice_deposit_rate').val());

       setallvalue();
    });
    
    
    if($('.lineitemTable > tbody > tr').length < 2){
        $('.lineitemTable > tbody > tr .del-product-btn').css('display','none');
    }else{
        $('.lineitemTable > tbody > tr .del-product-btn').css('display','block');
    };
    
</script>
<script type="text/x-jquery-tmpl" id="editlineItemRow">
    <tbody>
        <tr>
            <input type="hidden" name="invoice[lineitem][${i}][invoice_service_id]" class="invoice_service_id" value="">
            <td>
                <i class="jobber-icon jobber-2x jobber-sort"></i>
            </td>
            <td>
                <input type="hidden" class="action-border  form-control service_id" name="invoice[lineitem][${i}][service_id]" value="" required="" />
                <input type="text" class="form-control grey-title" name="invoice[lineitem][${i}][name]" id="servicelist_${i}" required="" onchange="selectService(this)" style="width: 100%;">
                <textarea class="action-border  form-control service" value="" rows="3" name="invoice[lineitem][${i}][description]"  required=""></textarea>
            </td>
            <td>
                <input type="text" class="action-border  form-control text-right quantity" name="invoice[lineitem][${i}][quantity]" value="1" required="" onchange="setquantity(this);" />
            </td>
            <td>
                <input type="text" class="action-border  form-control text-right unitcostval" name="invoice[lineitem][${i}][unitcost]" value="0.00" required="" onchange="setcost(this);" />
            </td>
            <td>
                <input type="text" class="action-border  form-control text-right total" value="0.0"/>
                <button type="button" class="btn btn-white btn-xs del-product-btn pull-right" onclick="deleterow(this)">Delete</button>
            </td>
        </tr>
    </tbody>
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
                                '<div class="col-md-2  pull-right">'+
                                    '<p class="paragraph pull-right u-marginTop">$#: data.cost #</p>'+
                                '</div>'
                            +'</div>',
                dataSource: [
                    @foreach ($services as $service)
                        { service_id: "{{$service->service_id}}", name: "{{$service->name}}", description: "{{$service->description}}", cost: "{{$service->cost}}"},
                    @endforeach
                ],
                height: 400
            });

        }
    </script>
</div>
@stop