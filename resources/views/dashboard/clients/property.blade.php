
@extends('layout.menu')
@section('content')

<link rel="stylesheet" type="text/css" href="{{url('public/css/custom.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/plugins/combobox/bootstrap-combobox.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/css/client.css')}}">
@include('notification')
<div class="property">
        <div class="ibox">
            <div class="ibox-content">
            	<div class="row  content-up">
					<div class="ibox-title-right">
                        @if( $permission != 3  && $permission != 4)
    				  	<div class="pull-right" data-toggle="modal" data-target="#client">
                        	<button type="button" class="border-un"><span>+  New Property &nbsp &nbsp</span></button>
                        </div>
                        @endif
	        		</div>
	        		<div class="">
		        		<div class="">
		        			<h1>Properties</h1>
		        		</div>
	        		</div>
		        </div>
	            <div class="row">
	            	 <div class="col-lg-12">
	                        <div class="panel panel-default">
	                            <div class="panel-heading">
									<div class="col-lg-6 search-area">
										<input class="search form-control focus-state" type="text" placeholder="Search Properties" id="search-property"/>
									</div>  
									<div class="col-lg-6 sort-area">
										<span>SORT</span>
										<select class="sort form-control focus-state" id="sort-label" onchange="sortdiv(this);">
											<option value="owner">Owner</option>
											<option value="street">Street</option>
											<option value="city">City</option>
											<option value="state">State</option>
											<option value="country">Country</option>
											<option value="zipcode">Zip Code</option>
										</select>
									</div>                              

	                            </div>
                
	                            <div class="panel-body min-size" id="list-property-info">
                                    @foreach($properties as $property)
                                    <div filter-value="{{$property->name }} {{$property->street1}} {{$property->street2}} {{$property->city}} {{$property->state}} {{$property->country}} {{$property->phone_number}} {{$property->company}}" owner="{{$property->name}}" street="{{$property->street1}} {{$property->street2}}" city="{{$property->city}}" state="{{$property->state}}" country="{{$property->country}}"  zipcode="{{$property->zip_code}}">
	                                <a  class="client-show-detail" id ="" onclick="location.href='{{ url('dashboard/properties/detail/'.$property->property_id) }}'">
                                        <div class="feed-element row assign">
                                            <?php if($property->use_company!=1):?>
                                            <div class="col-xs-1 jobber-icon jobber-person jobber-2x"></div>
                                        <?php else:?>
                                            <div class="col-xs-1 jobber-icon jobber-company jobber-2x"></div>
                                        <?php endif;?>
                                            <div class="col-xs-2 ">
                                                @if($property->use_company == -1)
                                                <span class="stats-label capitalize_name_label" >{{$property->name}}</span>
                                                @else
                                                <span class="stats-label capitalize_name_label" >{{$property->company}}</span>
                                                @endif
                                            </div>
                                            <div class="col-xs-2 ">
                                                <span class="stats-label capitalize_name_label">{{$property->street1}} {{$property->street2}}</span>
                                            </div>
                                            <div class="col-xs-2">
                                                <span class="stats-label capitalize_name_label">{{$property->city}}</span>
                                            </div>
                                            <div class="col-xs-2">
                                                <span class="stats-label capitalize_name_label">{{$property->state}}</span>
                                            </div>
                                            <div class="col-xs-2 ">
                                                <span class="stats-label capitalize_name_label">{{$property->country}}</span>
                        
                                            </div>
                                            <div class="col-xs-1">
                                                <span class="stats-label select_capitalize" >{{$property->zip_code}}</span>
                                                
                                            </div>
                                        </div>
                                    </a>
                                    </div>
                                    @endforeach
	                            </div><div class ="col-md-12 pagination-center">{!! $properties->render() !!}</div>
                                  
	                        </div>
	                    </div>
	             </div>
            </div>
        </div>
        
</div>


 <div class="modal inmodal" id="client" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title headingTwo text-left">Select or create a client</h4>
            </div>
            <div class="modal-body">
                <p class="paragraph u-marginBottomSmall">
                    Which client would you like to create this property for?
                </p>
                <div class="ibox clientbox">
                    <div class="ibox-title">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <!-- <label class="fa search-label"> -->
                                    <form>
                                        <input type="text" placeholder="Search clients..." 
                                        class="search-input action-border" id="search" required/>
                                        <button class="close-icon" type="reset">
                                            ×
                                        </button>
                                    </form>
                                    <!-- </label> -->
                                </div>
                            </div>
                            <div class="col-md-6 text-right">
                                <button  type="button" class="btn-job creteNew u-textBold" remote="true" onclick="location.href='{{url('dashboard/clients/add')}}'">+ Create New Client</button>
                                <span class="middle-text">Or</span>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content no-padding">
                        @foreach($clients as $client)
                        <div filter="{{$client->first_name}}  {{$client->last_name}} {{$client->company}}">
                    	<a class="clientinmodal" onclick="location.href='{{url('dashboard/properties/newproperty/'.$client->client_id)}}'" >
                        <div class="thicklist row_holder ">  
                            <div class="thicklist-row client js-spinOnClick">
                                <input type="hidden" name="clientId" id="clientId" value="1" />
                                <div class="row">
                                    <div class="columns col-sm-1">
                                        <i class="icon-user fa fa-2x fa-user"></i>
                                    </div>
                                    <div class="columns col-sm-6">
                                        @if($client->use_company == -1)
                                        <h3 class="headingFive u-marginTopSmallest">
                                            {{$client->first_name}}  {{$client->last_name}}
                                        </h3>
                                        @else
                                        <h3 class="headingFive u-marginTopSmallest">
                                            {{$client->company}}
                                        </h3>
                                        @endif
                                        <p class="paragraph">{{$client->count}} Properties | {{$client->phone_number}}</p>
                                    </div>

                                    <div class="columns col-sm-5 text-right">
                                        <p class="paragraph">
                                             @if(empty($client->interval))
                                                Just registered
                                            @else 
                                             Activity about {{$client->interval}} ago
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>  
                        </div>
                        </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


<script type="text/javascript">
    
var displayArr = [];

function getDisplayType(element) {
    var elementStyle = element.currentStyle || window.getComputedStyle(element, "");
    return elementStyle.display;
}

document.getElementById('search-property').onkeyup = function() {
    var displaySet = false;
    var itemsData   = 'filter-value';
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


function getDisplayType(element) {
    var elementStyle = element.currentStyle || window.getComputedStyle(element, "");
    return elementStyle.display;
}

document.getElementById('search').onkeyup = function() {
    var displaySet = false;
     var itemsData   = 'filter';
    var searchVal = this.value.toLowerCase();
    var filterItems = document.querySelectorAll('[' + itemsData + ']');
    for(var i = 0; i < filterItems.length; i++) {
        if (!displaySet) {
            displayArr.push(getDisplayType(filterItems[i]));
        }

        filterItems[i].style.display = 'none';

        if(filterItems[i].getAttribute('filter').toLowerCase().indexOf(searchVal) >= 0) {
            filterItems[i].style.display = displayArr[i];       
        }
    }
    
    displaySet = true;
}



function sortdiv(ele) {

    var container = document.getElementById("list-property-info");
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

  
</script>
@stop
