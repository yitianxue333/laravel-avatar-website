<html>
  <head>

  <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
  <meta content="utf-8" http-equiv="encoding">
  <link rel="stylesheet" type="text/css" href="../../../public/css/client.css">
  <link href="{{url('public/css/bootstrap.min.css')}}" rel="stylesheet">
  </head>
    <script src="{{ url('public/js/jquery-2.1.1.js')}}"></script>

 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyClhkjspT4SWJbvcf9uvVbHeAGZxTQILOU"></script>
<style>
   #wrapper { position: relative; }
   #over_map { position: absolute; top: 30px; left: 90%; z-index: 99; height: 90% ;}
   #side{overflow: auto;}
   #sortable { list-style-type: none; margin: 0; padding: 0; width: 100%;  }
  #sortable li { margin: 0px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
  #sortable li span { position: absolute; margin-left: -1.3em; }
  .mar{
      margin-top: 10px;
  }
</style>
<body>
<div id="wrapper">
   <div id="default" style="width:100%; height:100%"></div>
    <div id="over_map">
        
   </div>
</div>


<script type="text/javascript">
var icon_property = {
      url: "http://www.clker.com/cliparts/o/t/F/J/B/k/google-maps-md.png",
      scaledSize: new google.maps.Size(25, 30), // scaled size
      origin: new google.maps.Point(0,0), // origin
      anchor: new google.maps.Point(0, 0) // anchor
  };
var locations       = Array();
var markers         = [];
var marker;
var refreshTime     = 1000*30*5;
var myOptions       = {
                        center: new google.maps.LatLng({!!$latlong['latitude']!!},{!! $latlong['longitude']!!}),
                        zoom: 10,
                        styles: [
                        {
                          "elementType": "geometry",
                          "stylers": [
                            {
                              "color": "#242f3e"
                            }
                          ]
                        },
                        {
                          "elementType": "labels.text.fill",
                          "stylers": [
                            {
                              "color": "#746855"
                            }
                          ]
                        },
                        {
                          "elementType": "labels.text.stroke",
                          "stylers": [
                            {
                              "color": "#242f3e"
                            }
                          ]
                        },
                        {
                          "featureType": "administrative.locality",
                          "elementType": "labels.text.fill",
                          "stylers": [
                            {
                              "color": "#d59563"
                            }
                          ]
                        },
                        {
                          "featureType": "poi",
                          "elementType": "labels.text.fill",
                          "stylers": [
                            {
                              "color": "#d59563"
                            }
                          ]
                        },
                        {
                          "featureType": "poi.park",
                          "elementType": "geometry",
                          "stylers": [
                            {
                              "color": "#263c3f"
                            }
                          ]
                        },
                        {
                          "featureType": "poi.park",
                          "elementType": "labels.text.fill",
                          "stylers": [
                            {
                              "color": "#6b9a76"
                            }
                          ]
                        },
                        {
                          "featureType": "road",
                          "elementType": "geometry",
                          "stylers": [
                            {
                              "color": "#38414e"
                            }
                          ]
                        },
                        {
                          "featureType": "road",
                          "elementType": "geometry.stroke",
                          "stylers": [
                            {
                              "color": "#212a37"
                            }
                          ]
                        },
                        {
                          "featureType": "road",
                          "elementType": "labels.text.fill",
                          "stylers": [
                            {
                              "color": "#9ca5b3"
                            }
                          ]
                        },
                        {
                          "featureType": "road.highway",
                          "elementType": "geometry",
                          "stylers": [
                            {
                              "color": "#746855"
                            }
                          ]
                        },
                        {
                          "featureType": "road.highway",
                          "elementType": "geometry.stroke",
                          "stylers": [
                            {
                              "color": "#1f2835"
                            }
                          ]
                        },
                        {
                          "featureType": "road.highway",
                          "elementType": "labels.text.fill",
                          "stylers": [
                            {
                              "color": "#f3d19c"
                            }
                          ]
                        },
                        {
                          "featureType": "transit",
                          "elementType": "geometry",
                          "stylers": [
                            {
                              "color": "#2f3948"
                            }
                          ]
                        },
                        {
                          "featureType": "transit.station",
                          "elementType": "labels.text.fill",
                          "stylers": [
                            {
                              "color": "#d59563"
                            }
                          ]
                        },
                        {
                          "featureType": "water",
                          "elementType": "geometry",
                          "stylers": [
                            {
                              "color": "#17263c"
                            }
                          ]
                        },
                        {
                          "featureType": "water",
                          "elementType": "labels.text.fill",
                          "stylers": [
                            {
                              "color": "#515c6d"
                            }
                          ]
                        },
                        {
                          "featureType": "water",
                          "elementType": "labels.text.stroke",
                          "stylers": [
                            {
                              "color": "#17263c"
                            }
                          ]
                        }
                        ],
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    };
var map = new google.maps.Map(document.getElementById("default"),myOptions);
var property_marker = new google.maps.Marker({
  position: {lat: {!!$latlong['latitude']!!}, lng: {!! $latlong['longitude']!!}},
  map: map,
  // icon: icon_property, 
});
var startPosition=0;
function setMarkers(jsonData,clm) {
    var jsonData=JSON.parse(jsonData);
    var id=jsonData.id;
    var lat=parseFloat(jsonData.latitude);
    var lng=parseFloat(jsonData.longitude);
    var actionDesc=jsonData.actionDesc;
    var shiftName=jsonData.shiftName;
    var shiftBeginTime=jsonData.shiftBeginTime;
    var shiftEndTime=jsonData.shiftEndTime;
    var activeTime=jsonData.dateTime;
    var indicator=jsonData.indicator;
    var working=jsonData.working;
    var assignedTask=jsonData.assigned_task;
    console.log(assignedTask);
    
    $( "#over_map" ).empty();
    $.each( clm, function( i, val ) {
        $("#over_map").append("<div href='#' class='clm btn large grey' id="+val.task_pk+"><span>"+val.task_name+"</span></br><span style='font-size:x-small;padding-top: 5px'>"+val.user_name+"</span></div></br>")
        
    });

    latlngset = new google.maps.LatLng(lat, lng);
    if (!marker || !marker.setPosition) {
		if(working=="Y"){
        marker = new google.maps.Marker({
            title: id, 
            position: latlngset,
            icon: imageDirJs+"/marker_green.png"
            });
		} 
		else if(indicator=="BLUE"){
        marker = new google.maps.Marker({
            title: id, 
            position: latlngset,
			icon: imageDirJs+"/marker.png"
            });
		} 
		else if(indicator=="RED"){
        marker = new google.maps.Marker({
            title: id, 
            position: latlngset,
            icon: imageDirJs+"/marker_red.png"
            });
		} else {
        marker = new google.maps.Marker({
            title: id, 
            position: latlngset,
            icon: imageDirJs+"/marker.png"
            });
		}  
        // To add the marker to the map, call setMap();
        marker.setMap(map);
        markers.push(marker);
    }
    else{
        marker.setPosition(latlngset);
    }
   // map.setCenter(marker.getPosition())
   var contentTask='';

   $.each( assignedTask, function( i, val ) {
        contentTask+="<div href='#' class='clm btn large grey' id="+val.task_pk+"><span>"+val.task_name+"</span></br><span style='font-size:x-small;padding-top: 5px'>"+val.user_name+"</span></div></br>";
        
        var lati=val.lat;
        var lngi=val.lng;
        var destination = {lat: lati, lng:lngi};
        var origin = {lat:  lat, lng:lng};
        var randomColor = (function lol(m, s, c) {
        return s[m.floor(m.random() * s.length)] +
            (c && lol(m, s, c - 1));
    })(Math, '3456789ABCDEF', 4);
       
        var polylineOptionsActual = new google.maps.Polyline({
            strokeColor: "#"+randomColor,
            strokeOpacity: 1.0,
            strokeWeight: 5
            });
        var directionsDisplay = new google.maps.DirectionsRenderer({
          map: map,
          polylineOptions: polylineOptionsActual
        });
        // Set destination, origin and travel mode.
        var request = {
          destination: destination,
          origin: origin,
          travelMode: 'DRIVING',
        };

        // Pass the directions request to the directions service.
        var directionsService = new google.maps.DirectionsService();
        directionsService.route(request, function(response, status) {
          if (status == 'OK') {
            // Display the route on the map.
            directionsDisplay.setDirections(response);
          }
        });
    });
   
   var content="<div class='sortable_marker' id='"+jsonData.pk+"'> <img id='img' src='"+jsonData.user_dp+"' /><h3>"+jsonData.id+"</h3>"+contentTask+"</div>";
   
   // var content = "<div style='font-size: 1.2em;'><input type='hidden' id='pk' name='country' value='Norway'><b>"+id +"</b></div>Working on : "+actionDesc+"<br/>Shift : "+shiftName+"<br/>Begin Time : "+shiftBeginTime+" End Time : "+shiftEndTime+"<br/>Active Time : "+activeTime+"<ul id='sortable_marker'><li class='ui-state-default'><span class='ui-icon ui-icon-document'></span>Item 1</li><li class='ui-state-default'><span class='ui-icon ui-icon-document'></span>Item 2</li><li class='ui-state-default'><span class='ui-icon ui-icon-document'></span>Item 3</li></ul>";
    var infowindow = new google.maps.InfoWindow();
    infowindow.setContent(content);
    infowindow.open(map,marker);
    
    google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){return function() {
            infowindow.setContent(content);
            infowindow.open(map,marker);
            $(".clm").draggable({helper:'clone'});  
            $('.sortable_marker').droppable({
            // Drop should only fire when a draggable element is dropped into the sortables,
            // and NOT when the sortables themselves are sorted (without something being dragged into).
                drop: function(ev, ui){
                    asignTask(ui,$(this).attr("id"));
                    $("#"+$(this).attr("id")).append(ui.draggable.clone());
                }
            });
        };
        
    })(marker,content,infowindow)); 
    var startPosition=0;
     window.setTimeout(function() {
            $(".clm").draggable({helper:'clone'});  
            $('.sortable_marker').droppable({
            // Drop should only fire when a draggable element is dropped into the sortables,
            // and NOT when the sortables themselves are sorted (without something being dragged into).
                drop: function(ev, ui){
                    asignTask(ui,$(this).attr("id"));
                    var id= ui.draggable.attr("id");
                    $("#"+$(this).attr("id")).append(ui.draggable.clone()); 
                }
            });
     },500);
    
    marker='';

      
}

function asignTask(ui,id){
    var draggableId = ui.draggable.attr("id");
    //console.log(draggableId+" : "+id)
    $.ajax({
        type : 'POST',
        dataType : 'json',
        url : '//'+draggableId+'/'+id,//set dragable task here
        success : function(data){
            
        },
        error : function(XMLHttpRequest, textStatus, errorThrown){
            console.log(errorThrown);
            return false;
        }
    });
    
}

function drawPath(map,origin,destination){
     var directionsDisplay = new google.maps.DirectionsRenderer({
          map: map
        });

        // Set destination, origin and travel mode.
        var request = {
          destination: destination,
          origin: origin,
          travelMode: 'DRIVING'
        };

        // Pass the directions request to the directions service.
        var directionsService = new google.maps.DirectionsService();
        directionsService.route(request, function(response, status) {
          if (status == 'OK') {
            // Display the route on the map.
            directionsDisplay.setDirections(response);
          }
        });
}

$(document).ready(function()
{
  getGPSCoordinate();
  window.setInterval(function(){getGPSCoordinate();}, refreshTime);
  function getGPSCoordinate(){
  setAllMap(null);
        $.ajax({
            type : 'POST',
            dataType : 'json',
            url : 'google',
            success : function(data){
                console.log(data);
                var emp=data.emp;
                var clm=data.clm;
                
                for(var e in emp){
                    //locations[e]=new Array(data[e].id,data[e].latitude,data[e].longitude,data[e].actionDesc);
                    var dataJson = JSON.stringify(emp[e]);
                    setMarkers(dataJson,clm);
                    
               }
               
               if(data.length==0) {
                   /*setAllMap(null);
                   setMarkers(locations)*/
               }
            },
            error : function(XMLHttpRequest, textStatus, errorThrown){
				    console.log(errorThrown);
            return false;
            }
        });
  }

        var cityCircle = new google.maps.Circle({
          strokeColor: '#FF0000',
          strokeOpacity: 0.45,
          strokeWeight: 2,
          fillColor: '#FF0000',
          fillOpacity: 0.35,
          map: map,
          center: {lat: {!!$latlong['latitude']!!}, lng: {!! $latlong['longitude']!!}},
          radius: 50000,
        });
  

        var icon = {
              // url: "http://www.clker.com/cliparts/u/F/g/9/b/1/pushpin-google-md.png", // url
              url: "http://icons.iconarchive.com/icons/icons-land/vista-map-markers/32/Map-Marker-Ball-Azure-icon.png",
              scaledSize: new google.maps.Size(30, 30), // scaled size
              origin: new google.maps.Point(0,0), // origin
              anchor: new google.maps.Point(0, 0) // anchor
          };
        var infoWindowContent=[], infoWindow=[], marker = [];
        <?php foreach ($team_point as $key => $value): ?>
            <?php if($value['point'] != ''): ?>

            // Create our info window content
            infoWindowContent[{!!$key!!}] = '<div class="info_content">' +
                '<div class="row"><img alt="image" class="img-circle-map" src="../../../public/profile/'+'{!!$value['personal_info']->photo!!}' +'">' +
                '</div><div class="row"><h3 class="capitalize_name_label">'+'{!! $value['personal_info']->fullname !!}'+
                '</div></h3>' +
                '<div class="row task-map-btn" style="">Task</div>';
                // '<h4>'+'Phone: '+
                // '{!! $value['personal_info']->phone !!}'+' '+
                // '<br>'+'Email: '+
                // '{!! $value['personal_info']->email !!}'+' '+
                // '</h4>' +
                // '<p>'+'Address: '+
                // '{!! $value['personal_info']->street !!}'+' '+
                // '{!! $value['personal_info']->city !!}'+' '+
                // '{!! $value['personal_info']->state !!}'+' '+
                // '{!! $value['personal_info']->zip_code !!}'+' '+
                // '{!! $value['personal_info']->country !!}'+
                // '</p>' +
                // '</div>';

            // Initialise the inforWindow
            infoWindow[{!!$key!!}] = new google.maps.InfoWindow({
                content: infoWindowContent[{!!$key!!}]
            });



            marker[{!!$key!!}] = new google.maps.Marker({
              position: {lat: {!!$value['point']['latitude']!!}, lng: {!! $value['point']['longitude']!!}},
              map: map,
              icon: icon,
              title: '{!!$value['personal_info']->fullname !!}',
            });
            google.maps.event.addListener(marker[{!!$key!!}], 'click', function() {

                infoWindow[{!!$key!!}].open(map, marker[{!!$key!!}]);
            });

            <?php endif;?>
        <?php endforeach ?>
});

function setAllMap(map) {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}



</script>
</body>
</html>
