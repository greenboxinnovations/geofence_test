<!DOCTYPE html>
<html>
<head>
<title>Geofence</title>
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>
<style type="text/css">
*{padding: 0;margin: 0;}
body{width: 100%;height: 100%;}
#map{height: 100vh;width: 100%;}


</style>


<script type="text/javascript">
	$(document).ready(function(){	
		var route_id;
		var route_type = 1;		


		var mapOptions = {
	        zoom: 10,
	        center: {
	            lat: 18.5203,
	            lng: 73.8567
	        }
	    };

		map = new google.maps.Map(document.getElementById('map'), mapOptions);
		map.setMapTypeId(google.maps.MapTypeId.ROADMAP);

		var drawingManager = new google.maps.drawing.DrawingManager({
			drawingMode: google.maps.drawing.OverlayType.MARKER,
			drawingControl: true,
			drawingControlOptions: {
			position: google.maps.ControlPosition.TOP_CENTER,
			drawingModes: [	        
				google.maps.drawing.OverlayType.POLYGON,
				google.maps.drawing.OverlayType.MARKER
			]
		}});		
		drawingManager.setMap(map);
		

		google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
			if (event.type == google.maps.drawing.OverlayType.POLYGON) {
				
				var path = event.overlay.getPath().getArray();
				console.log("\nPOLYGON Path: ");
				for(var i=0;i<path.length;i++){					
					var lat = path[i].lat();
					var lng = path[i].lng();					
					console.log('lat:'+lat+' lng:'+lng);
				}
				console.log("\n");
			}//overlay polygon


			if (event.type == google.maps.drawing.OverlayType.MARKER) {				
				var lat = event.overlay.position.lat();
				var lng = event.overlay.position.lng();
				console.log('lat:'+lat+' lng:'+lng);
			}
			
		});
	


	});
</script>	
</head>
<body>

<div id="map"></div>

</body>
</html>
