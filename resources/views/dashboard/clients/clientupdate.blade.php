@extends('layout.menu')
@section('content')
<link rel="stylesheet" type="text/css" href="{{url('public/css/custom.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/plugins/combobox/bootstrap-combobox.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/client.css')}}">
<link rel="stylesheet"  href="{{url('public/css/plugins/iCheck/custom.css')}}">


@include('notification')
<div class="wrapper wrapper-content">
    <form role="search" class="" method="post" action="{{route('client.update',['client_id' => $clients[0]->client_id])}}">
    {{ csrf_field() }}  
        <div class="client-container">

            <div class="row container container-client">
           <!--  <div class='notifications top-right'></div> -->
                <div class="col-lg-6 client">
                    <div class="ibox-content">
                        <div class=" row ibox-content-title">
                                <span class="badge circle badge-primary "><i class="jobber-icon jobber-2x jobber-person"></i></span>
                                <span class="title">Clients details</span>
                        </div>
                        <div class="ibox-content-body">

                            <div class="body-auth">
                                <div class="row show-grid auth">

                                    <div class="col-md-6 focus-state">
                                    <?php if($clients->first()->use_company ==1):?>
                                        <input type="text" name="Fname" value="{{$clients[0]->first_name}}"placeholder="First name" class="form-control" >
                                    <?php else:?>
                                        <input type="text" name="Fname" value="{{$clients[0]->first_name}}"placeholder="First name" class="form-control" required>
                                    <?php endif;?>
                                    </div>
                                    <div class="col-md-6 focus-state">
                                        <input type="text" name="Lname" value="{{$clients[0]->last_name}}"placeholder="Last name" class="form-control" >
                                    </div>
                                </div>
                                <div class="row show-grid auth">

                                    <div class="col-md-12 focus-state">
                                        <input type="text" name="companyname" value="{{$clients[0]->company}}" placeholder="Company name" class="form-control" >
                                    </div>
                                </div><br/>
                             
                                 <?php if($clients->first()->use_company ==1):?>
                                    <div class="checkbox style-ichecks">
                                        <label class="check-element" style="display: flex; margin-left:-15px;" >
                                            <input type="checkbox" class="companycheck" name="companycheck" checked>
                                            <i class="checkbox fa"></i>
                                            <span style="margin-top: 6px"><h4>Use company name as the primary   name</h4></span>
                                        </label>
                                    </div>  
                                <?php else:?>
                                    <div class="checkbox style-ichecks">
                                        <label class="check-element" style="display: flex; margin-left:-15px;" >
                                            <input type="checkbox" class="companycheck" name="companycheck">
                                            <i class="checkbox fa"></i>
                                            <span style="margin-top: 6px"><h4>Use company name as the primary   name</h4></span>
                                        </label>
                                    </div>  
                                <?php endif;?>
                            </div>


                            <div class="body-contact">
                                <h3> Contact detail</h3><br/>
                                <div id="space-phone" class="row">
                                    @foreach ($contact1 as $one)
                                        <div class="row input-group-contact m-b phone">
                                            <div class="col-md-1 ">
                                                <input value='1' class='checkbox i-checks adding-radio' type='radio' name='is_phone_primary[]' {{ $one->is_primary == 1 ? 'checked' : '' }}>
                                            </div>
                                            <div class="col-md-3 contact-select focus-state">
                                                <select class="form-control select_capitalize" name="phone_option[]">
                                                    <?php $data= array(' ','main','work','mobile','home','fax','other'); ?>                                                
                                                    @for($i = 1; $i<count($data); $i++) 
                                                        <option value = {{$i}} {{ $i== $one->option ? 'selected' : '' }}> {{ $data[$i] }}</option>
                                                    @endfor
                                                </select>                                    
                                            </div>
                                            <div class="col-md-7 contact-select focus-state easychange-phone">
                                                <input type="text" value = "{{$one->value}}" class="form-control" name="phone_value[]" >
                                            </div>
                                            <div class="col-md-1">
                                                <i  class='fa fa-trash pull-left bin' onClick='removediv(this)'></i>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="row input-group-contact m-b phone">
                                        <div class="col-md-1 ">
                                            <input value='1' class='checkbox i-checks adding-radio' type='radio' name='is_phone_primary[]'>
                                        </div>
                                        <div class="col-md-3 contact-select focus-state">
                                            <select class="form-control select_capitalize" name="phone_option[]">
                                                <?php $data= array(' ','main','work','mobile','home','fax','other'); ?>                                                
                                                @for($i = 1; $i<count($data); $i++) 
                                                    <option value = {{$i}}> {{ $data[$i] }}</option>
                                                @endfor
                                            </select>                                    
                                        </div>
                                        <div class="col-md-7 contact-select focus-state easychange-phone">
                                            <input type="text" value = "" class="form-control" name="phone_value[]" >
                                        </div>
                                        <div class='col-md-1'>
                                            <i  class='fa fa-trash pull-left bin' onClick='removediv(this)'></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="create-info">
                                    <a id="phone" onClick="addPinfo(this)">Add Another Phone Number</a>
                                </div>

                                <div id="space-email" class="row">
                                    @foreach ($contact2 as $one)
                                        <div class="row input-group-contact m-b email">
                                            <div class="col-md-1 ">
                                                <input value='1' class='checkbox i-checks adding-radio' type='radio' name='is_email_primary[]' {{ $one->is_primary == 1 ? 'checked' : '' }}>
                                            </div>
                                            <div class="col-md-3 contact-select focus-state">
                                                <select class="form-control select_capitalize" name="email_option[]">
                                                    <?php $data= array(' ','main','work','personal','other'); ?>
                                                    @for($i = 1; $i<count($data); $i++) 
                                                        <option value = {{$i}} {{ $i== $one->option ? 'selected' : '' }}> {{ $data[$i] }}</option>
                                                    @endfor
                                                </select>                                    
                                            </div>
                                            <div class="col-md-7 contact-select focus-state easychange-email">
                                                <input type="text" value = "{{$one->value}}" class="form-control" name="email_value[]" >
                                            </div>
                                            <div class="col-md-1">
                                                <i  class='fa fa-trash pull-left bin' onClick='removediv(this)'></i>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="row input-group-contact m-b email">
                                        <div class="col-md-1 ">
                                            <input value='1' class='checkbox i-checks adding-radio' type='radio' name='is_email_primary[]'>
                                        </div>
                                        <div class="col-md-3 contact-select focus-state">
                                            <select class="form-control select_capitalize" name="email_option[]">
                                                <?php $data= array(' ','main','work','personal','other'); ?>
                                                @for($i = 1; $i<count($data); $i++) 
                                                    <option value = {{$i}}> {{ $data[$i] }}</option>
                                                @endfor
                                            </select>                                    
                                        </div>
                                        <div class="col-md-7 contact-select focus-state easychange-email">
                                            <input type="text" value = "" class="form-control" name="email_value[]" >
                                        </div>
                                        <div class='col-md-1'>
                                            <i  class='fa fa-trash pull-left bin' onClick='removediv(this)'></i>
                                        </div>
                                    </div>
                                </div> 
                                <div class="create-info">
                                    <a id="email" onClick="addEinfo(this)">Add Another Phone Number</a>
                                </div>   
                            </div>
                        </div>
                     </div>
                    </div>


                <div class="col-lg-6 property property-add">
                    <div class="ibox ibox-content ">
                        <div class="row ibox-content-title">
                                <span class="circle badge badge-primary "><i class="jobber-icon jobber-2x jobber-property"></i></span>
                                <span class="title">Property details</span>
                        </div>   
                        <div class="ibox-content-body">

                            <div class="body-auth">
                            <?php if($countproperty>1):?>
                                <div id="collapseThree" class="panel-collapse">
                                    <div class="panel-body">
                                       <div class="blue-panel-body">
                                            <div class="row">
                                                <div class="col-sm-2 ">
                                                    <div class="jobber-icon jobber-knot jobber-2x"></div>
                                                </div>
                                                <div class="col-sm-10 pipe-div">
                                                    <h4>This client has multiple properties</h4><br>
                                                    <h5>Multiple properties can only be edited individually. To edit a property, select it from the client's list of properties.</h5>
                                                </div>
                                            </div>
                                       </div>
                                    </div>
                                </div>
                                 @foreach($properties as $property)
                                     <?php if($property->type ==2):?>
                                            <div class="checkbox auth">
                                                <label class="flex-div flex-div-second check-element">
                                                    <input id="billing-address" value="1" class="checkbox" type="checkbox" name="billing-check" checked>
                                                    <i class="checkbox fa"></i>
                                                    <span style="margin-top: 6px"><h4>Billing address is the same as  property address</h4><span>
                                                </label>
                                            </div>

                                        <div class="body-auth billing">
                                            <div class="row show-grid auth">
                                                <h4>Billing address</h4>
                                                <div class="col-md-12 focus-state">
                                                    <input type="text" placeholder="Street 1" value="{{$property->street1}}" name="Bstreet1" value class="form-control" id="bstreet1">
                                                </div>
                                                <div class="col-md-12 focus-state">
                                                    <input type="text" placeholder="Street 2" value="{{$property->street2}}" name="Bstreet2" class="form-control" id="bstreet2">
                                                </div>
                                                <div class="input-group-contact m-b">
                                                    <div class="col-md-6 focus-state">
                                                         <input type="text" class="form-control city" name="Bcity" placeholder="City" value="{{$property->city}}" id="bcity"></input>
                                                    </div>
                                                    <div class="col-md-6 focus-state">
                                                         <input type="text" class="form-control state" value="{{$property->state}}" name="Bstate" placeholder="State" id="bstate"></input>
                                                    </div>
                                                    <div class="col-md-6 focus-state">
                                                        <input type="text" placeholder="Zip code" value="{{$property->zip_code}}" name="Bzipcode" class="form-control" id="bzipcode">
                                                    </div>
                                                    <div class="col-md-6  focus-state billing-country country-select">
                                                           <select class="form-control auth-country" name="Bcountry" id="countrysecond" >
                                                         </select>                               
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       <?php elseif($property->type == -1):?>
                                            <div class="checkbox  auth">
                                                <label class="flex-div flex-div-single check-element">
                                                    <input id="billing-address-single" value="1" class="" type="checkbox" name="billing-check">
                                                    <i class="checkbox fa"></i>
                                                      <span style="margin-top: 6px"><h4>Billing address is the same as     property address</h4><span>
                                                </label>
                                            </div>
                                        <div class="body-auth uncollapse">
                                            <div class="row show-grid auth">
                                                <h4>Billing address</h4>
                                                <div class="col-md-12 focus-state">
                                                    <input type="text" placeholder="Street 1" value="{{$property->street1}}" name="Bstreet1" value class="form-control" id="bstreet1">
                                                </div>
                                                <div class="col-md-12 focus-state">
                                                    <input type="text" placeholder="Street 2" value="{{$property->street2}}" name="Bstreet2" class="form-control" id="bstreet2">
                                                </div>
                                                <div class="input-group-contact m-b">
                                                    <div class="col-md-6 focus-state">
                                                         <input type="text" class="form-control city" name="Bcity" placeholder="City" value="{{$property->city}}" id="bcity"></input>
                                                    </div>
                                                    <div class="col-md-6 focus-state">
                                                         <input type="text" class="form-control state" value="{{$property->state}}" name="Bstate" placeholder="State" id="bstate"></input>
                                                    </div>
                                                    <div class="col-md-6 focus-state">
                                                        <input type="text" placeholder="Zip code" value="{{$property->zip_code}}" name="Bzipcode" class="form-control" id="bzipcode">
                                                    </div>
                                                    <div class="col-md-6  focus-state billing-country country-select">
                                                           <select class="form-control auth-country" name="Bcountry" id="countrysecond" >
                                                         </select>                               
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       <?php endif;?>
                                       @endforeach



                                <?php elseif($countproperty ==1):?>
                                @if($properties->first()->type == -1)
                                <div class="row show-grid auth">
                                 <input class='hidden-data' type='text' value='' name='property_id'>
                                    <div class="col-md-12 focus-state">
                                        <input type="text" placeholder="Street 1" name="street1" value="" class="form-control" >
                                    </div>
                                    <div class="col-md-12 focus-state">
                                        <input type="text" placeholder="Street 2" name="street2" value=""class="form-control" >
                                    </div>
                                    <div class="input-group-contact m-b ">
                                        <div class="col-md-6 focus-state">
                                             <input type="text" class="form-control city" name="city" placeholder="City" value="" ></input>
                                        </div>
                                        <div class="col-md-6 focus-state">
                                             <input type="text" class="form-control state" value=""name="state" placeholder="State" ></input>
                                        </div>
                                        <div class="col-md-6 focus-state">
                                            <input type="text" placeholder="Zip code" name="zipcode" class="form-control" value="" >
                                        </div>
                                        <div class="col-md-6 country-select focus-state">
                                            <select class="form-control auth-country" name="Pcountry" id="countryfirst" >
                                             </select>                                    
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="row show-grid auth">
                                 <input class='hidden-data' type='text' value='{{$properties[0]->property_id}}' name='property_id'>
                                    <div class="col-md-12 focus-state">
                                        <input type="text" placeholder="Street 1" name="street1" value="{{$properties[0]->street1}}" class="form-control" >
                                    </div>
                                    <div class="col-md-12 focus-state">
                                        <input type="text" placeholder="Street 2" name="street2" value="{{$properties[0]->street2}}"class="form-control" >
                                    </div>
                                    <div class="input-group-contact m-b ">
                                        <div class="col-md-6 focus-state">
                                             <input type="text" class="form-control city" name="city" placeholder="City" value="{{$properties[0]->city}}" ></input>
                                        </div>
                                        <div class="col-md-6 focus-state">
                                             <input type="text" class="form-control state" value="{{$properties[0]->state}}"name="state" placeholder="State" ></input>
                                        </div>
                                        <div class="col-md-6 focus-state">
                                            <input type="text" placeholder="Zip code" name="zipcode" class="form-control" value="{{$properties[0]->zip_code}}" >
                                        </div>
                                        <div class="col-md-6 country-select focus-state">
                                            <select class="form-control auth-country" name="Pcountry" id="countryfirst" >
                                             </select>                                    
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <br>

                                <div class="tax-label">
                                    <h4>Taxs</h4>
                                </div>
                                 <div class="btn-group tax-dropbox-group">
                             
                                    <a data-toggle="dropdown" class="dropdown-toggle display-tax"></a>
                                    <ul class="dropdown-menu tax-dropmenu">
                                      <div class="border-board tax_title">
                                          Select Tax Rate
                                      </div>
                                    @foreach($taxes as $key=>$tax)
                                       
                                    @if ($tax->value == $properties[0]->tax)
                                        <?php if($tax->is_default == 1):?> 
                                        <li>
                                        <label class="cursor-pointer">
                                            <div class="tax-dropdown">
                                                <input type="radio"  value ="{{$tax->value}}" id="taxRadios{{$key}}" data-name="{{$tax->name}} ({{$tax->value}}%) (Default)"     class="dropdown-radio tax-radio" name="taxradio" checked="checked">
                                                <span>{{$tax->name}} ({{$tax->value}}%) (Default)</span>
                                            </div>
                                         </label>
                                         </li>
                                     <?php else:?>
                                        <li>
                                        <label class="cursor-pointer">
                                            <div class="tax-dropdown">
                                                <input type="radio"  value ="{{$tax->value}}" id="taxRadios{{$key}}" data-name="{{$tax->name}} ({{$tax->value}}%)"     class="dropdown-radio tax-radio" name="taxradio" checked="checked">
                                                <span>{{$tax->name}} ({{$tax->value}}%)</span>
                                            </div>
                                         </label>
                                         </li>
                                     <?php endif;?>
                                    @else
                                        <?php if($tax->is_default == 1):?> 
                                        <li>
                                        <label class="cursor-pointer">
                                            <div class="tax-dropdown">
                                                <input type="radio"  value ="{{$tax->value}}" id="taxRadios{{$key}}" data-name="{{$tax->name}} ({{$tax->value}}%) (Default)"     class="dropdown-radio tax-radio" name="taxradio" >
                                                <span>{{$tax->name}} ({{$tax->value}}%) (Default)</span>
                                            </div>
                                         </label>
                                         </li>
                                     <?php else:?>
                                        <li>
                                        <label class="cursor-pointer">
                                            <div class="tax-dropdown">
                                                <input type="radio"  value ="{{$tax->value}}" id="taxRadios{{$key}}" data-name="{{$tax->name}} ({{$tax->value}}%)"     class="dropdown-radio tax-radio" name="taxradio">
                                                <span>{{$tax->name}} ({{$tax->value}}%)</span>
                                            </div>
                                         </label>
                                         </li>
                                     <?php endif;?>
                                     @endif
                                        @endforeach
                                    </ul>
                                </div>

                                 @foreach($properties as $property)
                                <?php if($property->type ==2):?>
                                <div class="checkbox  auth">
                                    <label class="flex-div flex-div-second check-element" >
                                        <input id="billing-address" value="1" class="" type="checkbox" name="billing-check" checked ="checked"/>
                                        <i class="checkbox fa"></i>
                                        <span style="margin-top: 6px"><h4>Billing address is the same as     property address</h4><span>
                                    </label>
                                </div>

                            <div class="body-auth billing">
                                <div class="row show-grid auth">
                                    <h4>Billing address</h4>
                                    <div class="col-md-12 focus-state">
                                        <input type="text" placeholder="Street 1" value="" name="Bstreet1" value class="form-control" id="bstreet1">
                                    </div>
                                    <div class="col-md-12 focus-state">
                                        <input type="text" placeholder="Street 2" value="" name="Bstreet2" class="form-control" id="bstreet2">
                                    </div>
                                    <div class="input-group-contact m-b">
                                        <div class="col-md-6 focus-state">
                                             <input type="text" class="form-control city" name="Bcity" placeholder="City" value="" id="bcity"></input>
                                        </div>
                                        <div class="col-md-6 focus-state">
                                             <input type="text" class="form-control state" value="" name="Bstate" placeholder="State" id="bstate"></input>
                                        </div>
                                        <div class="col-md-6 focus-state">
                                            <input type="text" placeholder="Zip code" value="" name="Bzipcode" class="form-control" id="bzipcode">
                                        </div>
                                        <div class="col-md-6  focus-state billing-country country-select">
                                               <select class="form-control auth-country" name="Bcountry" id="countrysecond" >
                                             </select>                               
                                        </div>
                                    </div>
                                </div>
                            </div>
                               <?php elseif($property->type == -1):?>
                                    <div class="checkbox  auth">
                                        <label class="flex-div flex-div-single check-element">
                                            <input id="billing-address-single" value="1" class="" type="checkbox" name="billing-check">
                                            <i class="checkbox fa"></i>
                                            <span style="margin-top: 6px"><h4>Billing address is the same as     property address</h4><span>
                                        </label>
                                    </div>

                                <div class="body-auth uncollapse">
                                    <div class="row show-grid auth">
                                        <h4>Billing address</h4>
                                        <div class="col-md-12 focus-state">
                                            <input type="text" placeholder="Street 1" value="{{$property->street1}}" name="Bstreet1" value class="form-control" id="bstreet1">
                                        </div>
                                        <div class="col-md-12 focus-state">
                                            <input type="text" placeholder="Street 2" value="{{$property->street2}}" name="Bstreet2" class="form-control" id="bstreet2">
                                        </div>
                                        <div class="input-group-contact m-b">
                                            <div class="col-md-6 focus-state">
                                                 <input type="text" class="form-control city" name="Bcity" placeholder="City" value="{{$property->city}}" id="bcity"></input>
                                            </div>
                                            <div class="col-md-6 focus-state">
                                                 <input type="text" class="form-control state" value="{{$property->state}}" name="Bstate" placeholder="State" id="bstate"></input>
                                            </div>
                                            <div class="col-md-6 focus-state">
                                                <input type="text" placeholder="Zip code" value="{{$property->zip_code}}" name="Bzipcode" class="form-control" id="bzipcode">
                                            </div>
                                            <div class="col-md-6  focus-state billing-country country-select">
                                                   <select class="form-control auth-country" name="Bcountry" id="countrysecond" >
                                                 </select>                               
                                            </div>
                                        </div>
                                    </div>
                                </div>

                               <?php endif;?>
                           @endforeach
                            <?php elseif($countproperty == 0):?>
                                <div class="row show-grid auth">
                                 <input class='hidden-data' type='text' value='' name='property_id'>
                                    <div class="col-md-12 focus-state">
                                        <input type="text" placeholder="Street 1" name="street1" value="" class="form-control" >
                                    </div>
                                    <div class="col-md-12 focus-state">
                                        <input type="text" placeholder="Street 2" name="street2" value=""class="form-control" >
                                    </div>
                                    <div class="input-group-contact m-b ">
                                        <div class="col-md-6 focus-state">
                                             <input type="text" class="form-control city" name="city" placeholder="City" value="" ></input>
                                        </div>
                                        <div class="col-md-6 focus-state">
                                             <input type="text" class="form-control state" value="" name="state" placeholder="State" ></input>
                                        </div>
                                        <div class="col-md-6 focus-state">
                                            <input type="text" placeholder="Zip code" name="zipcode" class="form-control" value="" >
                                        </div>
                                        <div class="col-md-6 country-select focus-state">
                                            <select class="form-control auth-country" name="Pcountry" id="countryfirst" >
                                             </select>                                    
                                        </div>
                                    </div>
                                </div>
                                <br>
                                
                                   <div class="tax-label">
                                        <h4>Taxs</h4>
                                    </div>
                                    <div class="btn-group tax-dropbox-group">
                                        @foreach($taxes as $key=>$tax)
                                        <?php if($key ==0):?>
                                        <a data-toggle="dropdown" class="dropdown-toggle display-tax">
                                            {{$tax->name}} ({{$tax->value}}%)</a>
                                        <input   value ="{{$tax->value}}" id="taxRadios{{$key}}" data-name="{{$tax->name}} ({{$tax->value}}%) (Default)"        class="dropdown-radio tax-radio hidden-data" name="taxradio" >
                                         <?php endif;?>
                                        @endforeach
                                        <ul class="dropdown-menu tax-dropmenu ">
                                            @foreach($taxes as $key=>$tax)
                                            <li>
                                            <?php if($tax->is_default == 1):?>
                                            <label class="cursor-pointer">
                                                <div class="tax-dropdown">
                                                    <input type="radio"  value ="{{$tax->value}}" id="taxRadios{{$key}}" data-name="{{$tax->name}} ({{$tax->value}}%) (Default)"        class="dropdown-radio tax-radio" name="taxradio" checked="checked">
                                                    <span>{{$tax->name}} ({{$tax->value}}%) (Default)</span>
                                                </div>
                                             </label>
                                         <?php else:?>
                                            <label class="cursor-pointer">
                                                <div class="tax-dropdown">
                                                    <input type="radio"  value ="{{$tax->value}}" id="taxRadios{{$key}}" data-name="{{$tax->name}} ({{$tax->value}}%)"      class="dropdown-radio tax-radio" name="taxradio">
                                                    <span>{{$tax->name}} ({{$tax->value}}%)</span>
                                                </div>
                                             </label>
                                         <?php endif;?>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                <div class="checkbox  auth">
                                    <label class="flex-div flex-div-second check-element">
                                        <input id="billing-address" value="1" class="" type="checkbox" name="billing-check" />
                                        <i class="checkbox fa"></i>
                                        <span style="margin-top: 6px"><h4>Billing address is the same as     property address</h4><span>
                                    </label>
                                </div>

                                <div class="row show-grid auth">
                                 <input class='hidden-data' type='text'  name='property_id'>
                                    <div class="col-md-12 focus-state">
                                        <input type="text" placeholder="Street 1" name="Bstreet1"  class="form-control" >
                                    </div>
                                    <div class="col-md-12 focus-state">
                                        <input type="text" placeholder="Street 2" name="Bstreet2" class="form-control" >
                                    </div>
                                    <div class="input-group-contact m-b ">
                                        <div class="col-md-6 focus-state">
                                             <input type="text" class="form-control city" name="Bcity" placeholder="City" value="" ></input>
                                        </div>
                                        <div class="col-md-6 focus-state">
                                             <input type="text" class="form-control state" name="Bstate" placeholder="State" ></input>
                                        </div>
                                        <div class="col-md-6 focus-state">
                                            <input type="text" placeholder="Zip code" name="Bzipcode" class="form-control"  >
                                        </div>
                                        <div class="col-md-6 country-select focus-state">
                                            <select class="form-control auth-country" name="Pcountry" id="countryfirst" >
                                             </select>                                    
                                        </div>
                                    </div>
                                </div>
                            <?php endif;?>
                            </div><br>
                        </div>            
                    </div>
                </div>
            </div>
            @if(!empty($contact1))
                @foreach($contact1 as $contact)
                    <input class="hidden-data" type="text" name="info[]" value="{{$contact->contact_id}}"></input>
                @endforeach
            @else
                    <input class="hidden-data" type="text" name="info[]" value="0"></input>
            @endif

            @if(!empty($contact2))
                @foreach($contact2 as $contact)
                    <input class="hidden-data" type="text" name="info[]" value="{{$contact->contact_id}}"></input>
                @endforeach
            @else
                    <input class="hidden-data" type="text" name="info[]" value="0"></input>
            @endif
            <input class="hidden-data" value="{{$countproperty}}" name="count"></input>
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox-content blank-btn-area">
                    <div class="button-area">
                        <button type="submit" value ="delete" name="delete" class="btn btn-lg btn-danger btn-outline button--ghost u-floatLeft" onClick="return senddata()">Delete</button>
                        <button type="submit" value="update" name="update" class="pull-right btn-job form-submit" onClick="return senddata()">Update Client</button>
                        <button type="button" class="pull-right cancelAdd-btn button--greyBlue button--ghost" onclick="location.href='{{url('dashboard/clients/detail/'. $clients[0]->client_id)}}'">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="index_of_phone" value="{{ $index_of_phone }}">
        <input type="hidden" name="index_of_email" value="{{ $index_of_email }}">
    </form>   
     @foreach($properties as $key => $one)
        @if($one->type == 1)
            <input class='hidden-data'  value='{{$one->country}}' name='property-country'>
        @endif
        @if($one->type == -1)
            <input class='hidden-data'  value='{{$one->country}}' name='billing-country'>
        @endif
    @endforeach
    
</div>
<script src="{{ url('public/js/country.js')}}"></script>
<script src="{{ url('public/js/plugins/iCheck/icheck.min.js')}}"></script>
<script>
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    $('.companycheck').click(function(){
        if($('input[name="Fname"]').is(':required')==true){
            $('input[name="companyname"]').prop('required', true);
            $('input[name="Fname"]').prop('required', false);
        }
        else{
            $('input[name="companyname"]').prop('required', false);
            $('input[name="Fname"]').prop('required', true);
        }
    });
    $('.flex-div-second').click(function() {
        if($('#billing-address').is(':checked') == true) {
            $('.billing').fadeOut('fast');
        }
        else {
            $('.billing').fadeIn('fast');
        }
    });

    $('.flex-div-single').click(function() {
        if($('#billing-address-single').is(':checked') == true) {
            $('.uncollapse').fadeOut('fast');
        }
        else {
            $('.uncollapse').fadeIn('fast');
        }
    });
    function addPinfo(ele){     
        var spaceid ="space-".concat(ele.id);
        var id="#".concat(spaceid);
        var rclass=".".concat(ele.id);
        innerHTML = "<div class='row input-group-contact m-b phone'>" + 
                    "   <div class='col-md-1'>" + 
                    "       <input value='1' class='checkbox i-checks adding-radio is_primary' data-type='phone' type='radio' name='is_phone_primary[]'>" + 
                    "   </div>" + 
                    "   <div class='col-md-3 contact-select'>" + 
                    "       <select class='form-control' name='phone_option[]'>" + 
                    "           <option value='1'><h4>Main</h4></option>" + 
                    "           <option value='2'><h4>Work</h4></option>" + 
                    "           <option value='3'><h4>Mobile</h4></option>" + 
                    "           <option value='4'><h4>Home</h4></option>" + 
                    "           <option value='5'><h4>Fax</h4></option>" + 
                    "           <option value='6'><h4>Other</h4></option>" + 
                    "       </select>" + 
                    "   </div>" + 
                    "   <div class='col-md-7 contact-select'>" + 
                    "       <input type='text' class='form-control' name='phone_value[]' >" + 
                    "   </div>" + 
                    "   <div class='col-md-1' >" + 
                    "       <i  class='fa fa-trash pull-left bin' onClick='removediv(this)'></i>" + 
                    "   </div>" + 
                    "   <br>" + 
                    "</div>";
        // $(rclass).remove();
        $(id).append(innerHTML);
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    }

    function addEinfo(ele){
        var spaceid ="space-".concat(ele.id);
        var id="#".concat(spaceid);
        var rclass=".".concat(ele.id);
        innerHTML = "<div class='row input-group-contact m-b email'>" + 
                    "   <div class='col-md-1'>" + 
                    "       <input value='1' class='checkbox i-checks adding-radio is_primary' data-type='email' type='radio' name='is_email_primary[]'>" + 
                    "   </div>" + 
                    "   <div class='col-md-3 contact-select'>" + 
                    "       <select class='form-control' name='email_option[]'>" + 
                    "           <option value='1'><h4>Main</h4></option>" + 
                    "           <option value='2'><h4>Work</h4></option>" + 
                    "           <option value='3'><h4>Personal</h4></option>" + 
                    "           <option value='4'><h4>Other</h4></option>" + 
                    "       </select>" + 
                    "   </div>" + 
                    "   <div class='col-md-7 contact-select'>" + 
                    "       <input type='email' class='form-control' name='email_value[]' required>" + 
                    "   </div>" + 
                    "   <div class='col-md-1'>" + 
                    "       <i  class='fa fa-trash pull-left bin' onClick='removediv(this)'></i>" + 
                    "   </div>" + 
                    "   <br>" + 
                    "</div>";
        $(id).append(innerHTML);
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    }

    populateCountries('countryfirst');
    populateCountries('countrysecond');



    $(document).ready(function(){
        $('#countryfirst').val($('input[name=property-country]').val());
        $('#countrysecond').val($('input[name=billing-country]').val());
    });

    $('.tax-radio').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    function displayTaxVals() {
      var singleValues = $( "input[name = taxradio]:checked" ).attr('data-name');
      // console.log(singleValues);
      $( ".display-tax" ).html(  singleValues );
      $('.tax-dropmenu').fadeOut('fast');
    }

    $( ".cursor-pointer").click( displayTaxVals );

    displayTaxVals();

    $('.dropdown-toggle').click(function(){
        $('.tax-dropmenu').fadeIn('fast');
    });


    function removediv(ele){
        $(ele).parent().parent().remove();
    }

    function senddata(){
        var $index_of_phone = {{ $index_of_phone }};
        var $index_of_email = {{ $index_of_email }};
        
        var $i = 0;
        $('#space-phone input[name="is_phone_primary[]"]').each(function() {
            if($(this).is(':checked')) {
                $index_of_phone = $i;
            }

            $i ++;
        });
        
        var $i = 0;
        $('#space-email input[name="is_email_primary[]"]').each(function() {
            if($(this).is(':checked')) {
                $index_of_email = $i;
            }

            $i ++;
        });

        $('input[name="index_of_phone"]').val($index_of_phone);
        $('input[name="index_of_email"]').val($index_of_email);

        return true;
    }

    function add_info(ele){
        var spaceid ="space-".concat(ele.id);
        var id="#".concat(spaceid);
        var rclass=".hidden-radio-".concat(ele.id);
        var cclass = ".easychange-".concat(ele.id);
        
        $(cclass).removeClass('col-md-9').addClass('col-md-8');
        $(rclass).show();
    }
    $(document).mouseup(function(e) 
    {
        var container = $(".tax-dropmenu");

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0) 
        {
            container.hide();
        }
    });
</script>

@stop
