@extends('layout.menu')
@section('content')
<link rel="stylesheet" type="text/css" href="{{url('public/css/custom.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/plugins/combobox/bootstrap-combobox.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/client.css')}}">
<link rel="stylesheet"  href="{{url('public/css/plugins/iCheck/custom.css')}}">

@include('notification')

<div class="wrapper wrapper-content">
	<form role="search" class="" method="post" action="{{route('clients.create')}}">
	{{ csrf_field() }}	
		<div class="client-container">

	        <div class="row container container-client">
	            <div class="col-lg-6 client">
	                <div class="ibox-content">
		        	@if(isset($data['success']))
	                <div class="flash flash--success clearfix hideForPrint js-flash">
	                    <div class="flash-content">{{$data['success']}} </div>
	                    <i class="pull-right jobber-icon jobber-2x jobber-cross" class="js-dismissFlash icon" onClick = "hideflash(this);"></i>
	                </div>
	                @endif
		            	<div class=" row ibox-content-title">
		                  		<span class="badge circle badge-primary "><i class="jobber-icon jobber-2x jobber-person"></i></span>
		              			<span class="title">Clients details</span>
		                </div>
		                <div class="ibox-content-body">
		                  	<div class="body-auth">
		                  		@if(isset($data['notvalid']))
				                	<p style="color: red">{{$data['notvalid']}}</p>
				                @endif
				                <div class="row show-grid auth">
				                	<div class="col-md-4 focus-state">
				                    	<input type="text" name="id" placeholder="Unique Id" class="form-control" value="{{$id->number+1}}">
				                    </div>
				                    <div class="col-md-4 focus-state">
				                    	<input type="text" name="clientFname" placeholder="First name" class="form-control" required>
				                    </div>
				                    <div class="col-md-4 focus-state">
				                    	<input type="text" name="clientLname" placeholder="Last name" class="form-control" >
				                    </div>
				                </div>
				                <div class="row show-grid auth">
				                    <div class="col-md-12 focus-state">
				                    	<input type="text" name="companyname" placeholder="Company name" class="form-control">
				                    </div>
				                </div><br/>
				                @foreach ($errors->all() as $error)
					                <li>{{ $errors }}</li>
					            @endforeach

				                <div class="checkbox style-ichecks">
				                	<label class="check-element" style="display: flex; margin-left: -15px;" >
	                                    <input type="checkbox" class="companycheck" name="companycheck">
	                                    <i class="checkbox fa"></i>
	                                    <span style="margin-top: 6px"><h4>Use company name as the primary 	name</h4></span>
	                                </label>
				                </div>

				            </div>

				            <div class="body-contact">
				            	<h3> Contact detail</h3><br/>
				            	<div id="space-phone">
				            		<div class="input-group-contact m-b phone">
					            		<div class="col-md-1 contact-select">
					            			<input value='1' class='checkbox i-checks adding-radio is_primary' data-type='phone' type='radio' name='is_phone_primary[]'>
					            		</div>
		                                <div class="col-md-3 contact-select focus-state">
		                                    <select class="form-control m-b" name="phone_option[]" >
		                                   		<option value="1"><h4>Main</h4></option>
		                                   		<option value="2"><h4>Work</h4></option>
		                                   		<option value="3"><h4>Mobile</h4></option>
		                                   		<option value="4"><h4>Home</h4></option>
		                                   		<option value="5"><h4>Fax</h4></option>
		                                   		<option value="6"><h4>Other</h4></option>
		                                     </select>                                    
		                                </div>
		                                <div class="col-md-8 contact-select focus-state easychange-phone">
		                               		<input type="text" class="form-control" name="phone_value[]" >
		                                </div><br>
		                            </div>
								</div>
				            	

								<div class="create-info">
	                            	<a id="phone" onClick="addPinfo(this)">Add Another Phone Number</a>
                        	    </div>
                        	    <div id="space-email">
                        	    	<div class="input-group-contact m-b eml-add focus-state email">
		                            	<div class="col-md-1 contact-select">
					            			<input value='1' class='checkbox i-checks adding-radio is_primary' data-type='email' type='radio' name='is_email_primary[]'>
					            		</div>
		                                <div class="col-md-3 contact-select">
		                                    <select class="form-control m-b"  name="email_option[]" >
		                                   		<option value="1"><h4>Main</h4></option>
		                                   		<option value="2"><h4>Work</h4></option>
		                                   		<option value="3"><h4>Personal</h4></option>
		                                   		<option value="4"><h4>Other</h4></option>
		                                     </select>                                    
		                                </div>
		                                <div class="col-md-8 contact-select focus-state easychange-email" >
		                               		<input type="email" class="form-control" name="email_value[]" >
		                                </div>
		                                <br>
		                            </div>
                        	    </div>
	                            <div class="create-info">
	                                <a  id="email" onClick="addEinfo(this)">Add Another Email Address</a>
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
				                <div class="row show-grid auth">
				                    <div class="col-md-12 focus-state">
				                    	<input type="text" placeholder="Street 1" name="street1" class="form-control" required>
				                    </div>
				                    <div class="col-md-12 focus-state">
				                    	<input type="text" placeholder="Street 2" name="street2" class="form-control" >
				                    </div>
				                    <div class="input-group-contact m-b ">
		                                <div class="col-md-6 focus-state">
		                                     <input type="text" class="form-control city" name="city" placeholder="City" ></input>
		                                </div>
		                                <div class="col-md-6 focus-state">
		                                     <input type="text" class="form-control state" name="state" placeholder="State" ></input>
		                                </div>
		                                <div class="col-md-6 focus-state">
		                               		<input type="text" placeholder="Zip code" name="zipcode"   class="form-control" maxlength="5" pattern="[0-9]*" id="zip">
		                                </div>
		                                <div class="col-md-6 country-select focus-state">
		                                    <select class="form-control auth-country" name="Pcountry" id="countryfirst" >
		                                     </select>                                    
		                                </div>
		                            </div>
		                            <p class="zip-error">Not a real zip code.</p>
				                </div>
				            </div><br>
				        <div class="tax-label">
				            <h4>Taxs</h4>
			            </div>
			            <div class="btn-group tax-dropbox-group">
			            	@foreach($taxes as $key=>$tax)
			            	<?php if($key ==0):?>
                            <a data-toggle="dropdown" class="dropdown-toggle display-tax">
                            	{{$tax->name}} ({{$tax->value}}%)</a>
                            <input   value ="{{$tax->value}}" id="taxRadios{{$key}}" data-name="{{$tax->name}} ({{$tax->value}}%) (Default)"		class="dropdown-radio tax-radio hidden-data" name="taxradio" >
                             <?php endif;?>
                            @endforeach

                            <ul class="dropdown-menu tax-dropmenu ">
	                            <div class="border-board tax_title">
	                            	Select Tax Rate
	                            </div>
                            	@foreach($taxes as $key=>$tax)
                            	<li>
                                <?php if($tax->is_default == 1):?>
                                <label class="cursor-pointer">
	                                <div class="tax-dropdown">
	                                	<input type="radio"  value ="{{$tax->value}}" id="taxRadios{{$key}}" data-name="{{$tax->name}} ({{$tax->value}}%) (Default)"		class="dropdown-radio tax-radio" name="taxradio" checked="checked">
	                                	<span>{{$tax->name}} ({{$tax->value}}%) (Default)</span>
	                                </div>
	                             </label>
	                         <?php else:?>
	                         	<label class="cursor-pointer">
	                                <div class="tax-dropdown">
	                                	<input type="radio"  value ="{{$tax->value}}" id="taxRadios{{$key}}" data-name="{{$tax->name}} ({{$tax->value}}%)"		class="dropdown-radio tax-radio" name="taxradio">
	                                	<span>{{$tax->name}} ({{$tax->value}}%)</span>
	                                </div>
	                             </label>
	                         <?php endif;?>
                                </li>
                                @endforeach
                            </ul>
                        </div>


				            <div class="checkbox auth">
			                	<label class="flex-div check-element">
			                		<input id="billing-address" value="1" class="" type="checkbox" name="billing-check" checked = 'checked'/>
			                		<i class="checkbox fa"></i>
			                		  <span style="margin-top: 6px"><h4>Billing address is the same as 	property address</h4><span>
			                	</label>
			                </div>

							<div class="body-auth billing">
				                <div class="row show-grid auth">
				                	<h4>Billing address</h4>
				                    <div class="col-md-12 focus-state">
				                    	<input type="text" placeholder="Street 1" name="Bstreet1" class="form-control" id="bstreet1">
				                    </div>
				                    <div class="col-md-12 focus-state">
				                    	<input type="text" placeholder="Street 2" name="Bstreet2" class="form-control" id="bstreet2">
				                    </div>
				                    <div class="input-group-contact m-b">
		                                <div class="col-md-6 focus-state">
		                                     <input type="text" class="form-control city" name="Bcity" placeholder="City" id="bcity"></input>
		                                </div>
		                                <div class="col-md-6 focus-state">
		                                     <input type="text" class="form-control state" name="Bstate" placeholder="State" id="bstate"></input>
		                                </div>
		                                <div class="col-md-6 focus-state">
		                               		<input type="text" placeholder="Zip code" name="Bzipcode" maxlength="5" pattern="[0-9]*"  class="form-control" id="bzipcode">
		                                </div>
		                                <div class="col-md-6  focus-state billing-country country-select">
		                                       <select class="form-control auth-country" name="Bcountry" id="countrysecond" >
		                                     </select>                               
		                                </div>
		                            </div>
		                            <p class="Bzip-error">Not a real zip code.</p>
				                </div>
				            </div>
				            <span class="div-divider"></span>
				    	</div>            
	                </div>
	            </div>
	        </div>

	        <div class="row">
	        	<div class="col-lg-12">
	        		<div class="ibox-content blank-btn-area">
	        		<div class="button-area">
			        	<button type="submit" class="pull-right btn-job form-submit" onClick="return senddata()"><span>Create Client</span></button>
			    		<button type="button" class="pull-right cancelAdd-btn button--greyBlue button--ghost" onclick="location.href='{{ url('dashboard/clients') }}'"><span>Cancel</span></button>
			    		</div>
		    		</div>
	    		</div>
	        </div>
	        <div class="hidden-data">
	        </div>
    	</div>
    	<input type="hidden" name="index_of_phone" value="-1">
    	<input type="hidden" name="index_of_email" value="-1">
    </form>   
    
</div>
<script src="{{ url('public/js/country.js')}}"></script>
<script src="{{ url('public/js/plugins/iCheck/icheck.min.js')}}"></script>
<script>
	$(document).ready(function(){
        // var flag = 1; 
 
		$('#billing-address').click(function() {
			// console.log($('#billing-address').is(':checked'));
			if($('#billing-address').is(':checked') == true) {
				// $('#billing-address').prop('checked',true);
				$('.billing').fadeOut('fast');
				$('#bstreet1').prop('required', true);
			}
			else {
				// $('#billing-address').prop('checked',false);
				$('.billing').fadeIn('fast');
				$('#bstreet1').prop('required', false);
			}
		});

		
	   $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
	});

	$('.companycheck').click(function(ele){
    	if($('input[name="clientFname"]').is(':required')==true){
    		$('input[name="clientFname"]').prop('required', false);
    		$('input[name="companyname"]').prop('required', true);
    	}
    	else{
    		$('input[name="clientFname"]').prop('required', true);
    		$('input[name="companyname"]').prop('required', false);

    	}
    });
	

	$('.dropdown-toggle').click(function(){
    	$('.tax-dropmenu').fadeIn('fast');
    });

    function addPinfo(ele){
		var spaceid ="space-".concat(ele.id);
		var id="#".concat(spaceid);
		var rclass=".".concat(ele.id);
		innerHTML = "<div class='new input-group-contact m-b '>" + 
					"	<div class='col-md-1 contact-select '>" + 
					" 		<input value='1' class='checkbox i-checks adding-radio is_primary' data-type='phone' type='radio' name='is_phone_primary[]'>" + 
					"	</div>" + 
					"	<div class='col-md-3 contact-select'>" + 
					"		<select class='form-control m-b' name='phone_option[]'>" + 
					"			<option value='1'><h4>Main</h4></option>" + 
					" 			<option value='2'><h4>Work</h4></option>" + 
					" 			<option value='3'><h4>Mobile</h4></option>" + 
					" 			<option value='4'><h4>Home</h4></option>" + 
					" 			<option value='5'><h4>Fax</h4></option>" + 
					" 			<option value='6'><h4>Other</h4></option>" + 
					" 		</select>" + 
					" 	</div>" + 
					" 	<div class='col-md-7 contact-select'>" + 
					"		<input type='text' class='form-control' name='phone_value[]' >" + 
					" 	</div>" + 
					"	<div class='col-md-1' >" + 
					" 		<i  class='fa fa-trash pull-left bin' onClick='removediv(this)'></i>" + 
					"	</div>" + 
					"	<br>" + 
					"</div>";
		// $(rclass).remove();
		$(id).append(innerHTML);
		$('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
	}

	function addEinfo(ele) {
		var spaceid ="space-".concat(ele.id);
		var id="#".concat(spaceid);
		var rclass=".".concat(ele.id);
		innerHTML = "<div class='new input-group-contact m-b '>" + 
					"	<div class='col-md-1 contact-select '>" + 
					"		<input value='1' class='checkbox i-checks adding-radio is_primary' data-type='email' type='radio' name='is_email_primary[]'>" + 
					"	</div>" + 
					"	<div class='col-md-3 contact-select'>" + 
					"		<select class='form-control m-b' name='email_option[]'>" + 
					"			<option value='1'><h4>Main</h4></option>" + 
					" 			<option value='2'><h4>Work</h4></option>" + 
					" 			<option value='3'><h4>Personal</h4></option>" + 
					" 			<option value='4'><h4>Other</h4></option>" + 
					" 		</select>" + 
					" 	</div>" + 
					"	<div class='col-md-7 contact-select'>" + 
					" 		<input type='email' class='form-control' name='email_value[]' required>" + 
					" 	</div>" + 
					"	<div class='col-md-1'>" + 
					"		<i  class='fa fa-trash pull-left bin' onClick='removediv(this)'></i>" + 
					"	</div>" + 
					"	<br>" + 
					"</div>";
		// $(rclass).remove();
		$(id).append(innerHTML);
		$('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
	}

	populateCountries('countryfirst');
	populateCountries('countrysecond');

	$('.tax-radio').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

	function displayTaxVals() {
	  var singleValues = $( "input[name = taxradio]:checked" ).attr('data-name');
	  $( ".display-tax" ).html(  singleValues );
	  $('.tax-dropmenu').fadeOut('fast');
	}

	$( ".cursor-pointer").click( displayTaxVals );

	displayTaxVals();

	function removediv(ele){
		$(ele).parent().parent().remove();
	}

	function senddata() {
		var $index_of_phone = -1;
		var $index_of_email = -1;
		
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

	$.ajax({
	  	url: "http://ip-api.com/json",
	  	type: 'GET',
	  	success: function(json) {
	    	country = json.country;
	    	city = json.city;
	    	$('#countryfirst').val(country);
	    	$('#countrysecond').val(country);
	    	$('input[name="street2"]').val(country);
	    	$('input[name=city]').val(city);
	    	$('input[name=Bcity]').val(city);
	  	},
	  	error: function(err) {
	    	console.log("Request failed, error= " + err);
	  	}
	});

	$('#countryfirst').change(function(){
	    	$('input[name="street2"]').val($(this).val());
	});
	
	$(document).mouseup(function(e) 
    {
        var container = $(".tax-dropmenu");

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0) 
        {
            container.hide();
        }
    });
    function initAutocomplete() {
      	var geocoder = new google.maps.Geocoder();
			$('#zip').bind('change focusout', function () {
			    var $this = $(this);
			    if ($this.val().length == 5) {
			        geocoder.geocode({ 'address': $this.val() }, function (result, status) {
			            var state = "N/A";
			            var city = "N/A";
			            //start loop to get state from zip
			            // console.log(result);
		            if(result.length !=0){
			            for (var component in result[0]['address_components']) {
			                for (var i in result[0]['address_components'][component]['types']) {
			                    // if (result[0]['address_components'][component]['types'][i] == "locality") {
			                        // state = result[0]['address_components'][component]['short_name'];
			                        city = result[0]['address_components'][1]['long_name'];
			                        $('input[name=city]').val(city);
			                    // }
			                    if (result[0]['address_components'][component]['types'][i] == "administrative_area_level_1") {
			                        // state = result[0]['address_components'][component]['short_name'];
			                        // state = result[0]['address_components'][component]['long_name'];
			                        // $('input[name=state]').val(state);
			                    }
			                    if (result[0]['address_components'][component]['types'][i] === 'country') {
				                    country = result[0]['address_components'][component]['long_name'];
				                    $('#countryfirst').val(country);
				                }

			                }
			            }
			        }
			        else{
			        	$('.zip-error').show();
			        }
			        });
			    }
			});
			$('#bzipcode').bind('change focusout', function () {
			    var $this = $(this);
			    if ($this.val().length == 5) {
			        geocoder.geocode({ 'address': $this.val() }, function (result, status) {
			            var state = "N/A";
			            var city = "N/A";
			            //start loop to get state from zip
			            // console.log(result);
		            if(result.length !=0){
			            for (var component in result[0]['address_components']) {
			                for (var i in result[0]['address_components'][component]['types']) {
			                    // if (result[0]['address_components'][component]['types'][i] == "locality") {
			                        // state = result[0]['address_components'][component]['short_name'];
			                        city = result[0]['address_components'][1]['long_name'];
			                        $('input[name=Bcity]').val(city);
			                    // }
			                    if (result[0]['address_components'][component]['types'][i] == "administrative_area_level_1") {
			                        // state = result[0]['address_components'][component]['short_name'];
			                        // state = result[0]['address_components'][component]['long_name'];
			                        // $('input[name=Bstate]').val(state);
			                    }
			                    if (result[0]['address_components'][component]['types'][i] === 'country') {
				                    country = result[0]['address_components'][component]['long_name'];
				                    $('#countrysecond').val(country);
				                }
			                }
			            }
			        }
			        else{
			        	$('.Bzip-error').show();
			        }
			        });
			    }
			});    
      }
  	function hideflash(ele){
        $(ele).parent().hide();
    }


</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyClhkjspT4SWJbvcf9uvVbHeAGZxTQILOU&libraries=places&callback=initAutocomplete"
     async defer>
</script>

@stop
