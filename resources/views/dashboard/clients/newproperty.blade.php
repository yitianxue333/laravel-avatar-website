@extends('layout.menu')
@section('content')

<link rel="stylesheet" type="text/css" href="{{url('public/css/client.css')}}">
<link rel="stylesheet"  href="{{url('public/css/plugins/iCheck/custom.css')}}">

@include('notification')
 <div class="newproperty">
 <form class="new-property" method="post" action="{{route('properties.create')}}">
 	{{ csrf_field() }}	
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                	<div class="ibox-title-backto">
	        			<!-- <h4>Back to:<a onclick="location.href='{{url('dashboard/properties')}}'">      Properties</a></h4> -->
	        		</div>
                        <div class="tproperty col-lg-8 col-lg-offset-2">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                	<div class="panel-title">
	                                 	<div  class="pull-left circle">
	                                   		<i class="jobber-icon jobber-2x jobber-property icon-margin" aria-hidden="true" style="margin-top: 5px !important"></i>
	                                    </div>
	                                    <div class="title">New property for {{$client_name}}</div>
                                    </div>
                                    <div class="info-new-property">
                                    	<div class="property-info">
							                <div class="row show-grid auth">
							                    <div class="col-md-12">
							                    	<input type="text" placeholder="Street 1" name="street1" class="form-control" required>
							                    </div>
							                    <div class="col-md-12">
							                    	<input type="text" placeholder="Street 2" name="street2" class="form-control" >
							                    </div>
							                    <div class="input-group-contact m-b">
					                                <div class="col-md-6 ">
					                                     <input type="text" class="form-control city" name="city" placeholder="City" ></input>
					                                </div>
					                                <div class="col-md-6 ">
					                                     <input type="text" class="form-control state" name="state" placeholder="State" ></input>
					                                </div>
					                                <div class="col-md-6 ">
					                               		<input type="text" placeholder="Zip code" name="zipcode" class="form-control" maxlength="5"  id ="zip">
					                                </div>
					                                <div class="col-md-6 country-select">
		                                                	<select class="auth-country form-control" id="country" name="country">
		                                                		<option value="">kingdom</option>
		                                                	</select>                    
					                                </div>
					                            </div>
                                                <p class="zip-error">Not a real zip code.</p>
							                </div>
							            </div>
                                    </div>
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
                                            <div class="border-board tax_title">
                                                Select Tax Rate
                                            </div>
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
                                </div>
                                <input  class="hidden-data" value="{{$client_id}}" name="client_id" type="text"></input>
                                <div class="panel-body">
	                                <div class="button-area">
							        	<button type="submit" class="pull-right btn-job form-submit" ><strong>Create Property</strong></button>
							    		<button type="button" class="pull-right cancelAdd-btn button--greyBlue button--ghost" onclick="location.href='{{url('dashboard/clients/detail/'.$client_id)}}'"><strong>Cancel</strong></button>
			    					</div>
                                </div>
                            </div>
                        </div>
                    	<!-- sidebar-right -->
                </div>
            </div>
        </div>
</form>
</div>
<script src="{{ url('public/js/country.js')}}"></script>
<script src="{{ url('public/js/plugins/iCheck/icheck.min.js')}}"></script>

<script type="text/javascript">
	$('.tax-radio').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

	$('.dropdown-toggle').click(function(){
    	$('.tax-dropmenu').fadeIn('fast');
    });

	function displayTaxVals() {
	  var singleValues = $( "input[name = taxradio]:checked" ).attr('data-name');
	  // console.log(singleValues);
	  $( ".display-tax" ).html(  singleValues );
	  $('.tax-dropmenu').fadeOut('fast');
	}

	$( ".cursor-pointer").click( displayTaxVals );

	displayTaxVals();

	
    populateCountries('country');

   	$.ajax({
        url: "http://ip-api.com/json",
        type: 'GET',
        success: function(json) {
            country = json.country;
            city = json.city;
            $('#country').val(country);
            $('input[name=city]').val(city);
        },
        error: function(err) {
            console.log("Request failed, error= " + err);
        }
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
                                if (result[0]['address_components'][component]['types'][i] == "locality") {
                                    state = result[0]['address_components'][component]['short_name'];
                                    city = result[0]['address_components'][component]['long_name'];
                                    $('input[name=city]').val(city);
                                }
                                if (result[0]['address_components'][component]['types'][i] === 'country') {
                                    country = result[0]['address_components'][component]['long_name'];
                                    $('#country').val(country);
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
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyClhkjspT4SWJbvcf9uvVbHeAGZxTQILOU&libraries=places&callback=initAutocomplete"
     async defer>
</script>
@stop
