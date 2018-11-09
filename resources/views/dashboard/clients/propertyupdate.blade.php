@extends('layout.menu')
@section('content')

<link rel="stylesheet" type="text/css" href="{{url('public/css/client.css')}}">
<link rel="stylesheet"  href="{{url('public/css/plugins/iCheck/custom.css')}}">

@include('notification') 
 <div class="newproperty">
 <form class="new-property" method="post" action="{{route('properties.update',['property_id'=>$property[0]->property_id])}}">
 	{{ csrf_field() }}	
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                	<div class="ibox-title-backto">
	        		</div>
                        <div class="tproperty col-lg-8 col-lg-offset-2">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                	<div class="panel-title">
	                                 	<div  class="pull-left circle">
	                                   		<i class="jobber-icon jobber-2x jobber-property" aria-hidden="true"></i>
	                                    </div>
	                                    <div class="title">Property Information for {{$property[0]->first_name}} &nbsp{{$property[0]->last_name}}</div>
                                    </div>
                                    <div class="info-new-property">
                                    	<div class="property-info">
							                <div class="row show-grid auth">
							                    <div class="col-md-12">
							                    	<input type="text" placeholder="Street 1" name="street1" class="form-control" value="{{$property[0]->street1}}" required>
							                    </div>
							                    <div class="col-md-12">
							                    	<input type="text" placeholder="Street 2" name="street2" class="form-control" value="{{$property[0]->street2}}" >
							                    </div>
							                    <div class="input-group-contact m-b">
					                                <div class="col-md-6 ">
					                                     <input type="text" class="form-control city" name="city" placeholder="City" value="{{$property[0]->city}}" ></input>
					                                </div>
					                                <div class="col-md-6 ">
					                                     <input type="text" class="form-control state" name="state" placeholder="State" value="{{$property[0]->state}}" ></input>
					                                </div>
					                                <div class="col-md-6 ">
					                               		<input type="text" placeholder="Zip code" name="zipcode" class="form-control" value="{{$property[0]->zip_code}}" >
					                                </div>
					                                <div class="col-md-6 country-select">
		                                                	<select class="auth-country form-control" id="country" name="country" value="{{$property[0]->country}}">
		                                                	</select>                    
					                                </div>
					                            </div>
							                </div>
							            </div>
                                    </div>
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
                                       
                                    @if ($tax->value == $property[0]->tax)
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
                                </div>
                                <!-- <input class="hidden-data" name="property_id" value="{{$property[0]->property_id}}"></input> -->
                                <div class="panel-body">
	                                <div class="button-area">
	                                	<button type="submit" name="delete" value="delete" class="btn btn-lg btn-danger btn-outline button--ghost u-floatLeft" ><span>Delete</strong></span>

							        	<button type="submit" name="update" value="update" class="pull-right btn-job form-submit" ><span>Update Property</span></button>

							    		<button type="button" class="pull-right cancelAdd-btn button--greyBlue button--ghost" onclick="location.href='{{url('dashboard/properties/detail/'.$property[0]->property_id)}}'"><span>Cancel</span></button>
			    					</div>
                                </div>

                            </div>
                        </div>
                        <input class='hidden-data'  value='{{$property[0]->country}}' name='property-country'>
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

    $(document).ready(function(){
        var country = $('input[name=property-country]').val();
        $('#country').val(country);
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
</script>

@stop
