@extends('layout.menu')
@section('content')

<link rel="stylesheet" type="text/css" href="{{url('public/css/client.css')}}">

 <div class="row location">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">

				<div class="location row">
					
					<div class ="col-md-4">
						    <h3 class="headingThree">Mailing Address on Property</h3><br>
    						<div class="feed-element">
                        <div class="empty-info-div">
          			             <div class="pull-left circle">
          			             	<i class="jobber-icon jobber-2x jobber-property"></i>
          			           	 </div>
          			            <div class="media-body ">
          			               {{$property->street1}} {{$property->street2}}<br>{{$property->city}} &nbsp {{$property->state}}<br>{{$property->country}}
          			            </div>
        		            </div>
    		        </div>
				        <div class="card u-bgColorYellowLightest u-marginBottom">
					        <p class="paragraph u-textSmaller">
					          Proper map coordinates let Jobber help you put together the best possible schedule, and get your teams to the right address.
					        </p>
						    </div>
    						<div class = "coordinates row">
        							<br>
                      <div class="col-sm-12">
        							<h3 class="headingFive u-marginBottomSmaller">By Coordinates</h3><br>
        							<form action="{{route('location.save',['property_id'=>$property->property_id])}}" id="map-form" method = "post">
        							   {{ csrf_field() }}	
                         @if($latlong != 'Not found')
          							<div class="col-sm-6 latitude">
            								<label class="fieldLabel" for="property_latitude">Latitude</label><br>
            								<input type="text" value="{{$latlong['latitude']}}" name="latitude" class="form-control">
                            </input>
          							</div>
          							<div class="col-sm-6 longitude">
            								<label class="fieldLabel" for="property_longitude">longitude</label><br>
            								<input type="text" value="{{$latlong['longitude']}}" name="longitude" class="form-control"></input>
          							</div>
                        @else
                          <div class="col-sm-6 latitude">
                            <label class="fieldLabel" for="property_latitude">Latitude</label><br>
                            <input type="text" value="" name="latitude" class="form-control">
                            </input>
                        </div>
                        <div class="col-sm-6 longitude">
                            <label class="fieldLabel" for="property_longitude">longitude</label><br>
                            <input type="text" value="" name="longitude" class="form-control"></input>
                        </div>
                          @endif
        							</form>
                      </div>
    						</div>
  					  <div class="map-btn">
      							<button type="submit" name="save" value="save" class="pull-right btn-job form-submit" form="map-form"><span>Save</span></button>
      			    		<button type="button" class="pull-right cancelAdd-btn button--greyBlue button--ghost" onclick="location.href='{{url('dashboard/properties/detail/'.$property->property_id)}}'"><span>Cancel</span></button>
  		    		</div>
			    </div>
				   
					<div class ="col-md-8">
						<input id="pac-input" class="controls hidden-data" type="text" placeholder="Search Box">
              <h3>  MAP  </h3>
             @if($latlong != 'Not found')
						<div id="map">
						</div>
            @else
              <h2>  Unfortunately Not Found Location </h2>
            @endif
					</div>
					<input class="hidden-data" value="{{$property->street1}} {{$property->street2}} {{$property->city}} {{$property->state}} {{$property->zip_code}}" name="location"></input>
					
				</div>
			</div>
		</div>
	</div>
</div>



<script>
      function initAutocomplete() {
      	var lati = $('input[name="latitude"]').val();
      	var longi = $('input[name="longitude"]').val();

        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: parseInt(lati), lng: parseInt(longi)},
          zoom: 5,
          mapTypeId: 'roadmap'
        });

        var marker = new google.maps.Marker({
          position: {lat: parseInt(lati), lng: parseInt(longi)},
          map: map,
          draggable: true,
        });
        google.maps.event.addListener(marker, "mouseup", function (event) {
            var lat = event.latLng.lat();
            var lng = event.latLng.lng();
            // alert(lat);
           $('input[name=latitude]').val(lat);
           $('input[name=longitude]').val(lng);

    		});
      }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyClhkjspT4SWJbvcf9uvVbHeAGZxTQILOU&libraries=places&callback=initAutocomplete"
         async defer>
    </script>
@stop
