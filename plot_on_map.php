<!DOCTYPE html>
<html>
<head>
<title>Geofence</title>
<!-- <script type="text/javascript" src="../js/jquery.js"></script> -->

<!-- <script
  src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
  integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
  crossorigin="anonymous"></script> -->

<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>



<style type="text/css">
*{padding: 0;margin: 0;}
#map{height: 100vh;width: 100%;background-color: green;}
</style>

<!-- <script type="text/javascript">
$(document).ready(function(){
	
	var map;	

	//load map
	function init_map(){

		var mapOptions = {
			zoom: 18,
			center: {
				lat: 18.548295,
				lng: 73.771608
			}
		};

		map = new google.maps.Map(document.getElementById('map'), mapOptions);
		map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
		
		//called when map is loaded
		google.maps.event.addListenerOnce(map, 'idle', function(){

			plotFence();

			// add points here
			// in polygon
			var A = {lat:18.548162116567774, lng:73.7714478984243};
			var B = {lat:18.5481824596542, lng:73.77169466165367};
			var C = {lat:18.548701207538947, lng:73.7717912211782};

			// out of bounding
			var D = {lat:18.546956784372, lng:73.77050912526909};

			// in bounding but out of polgon
			var E = {lat:18.547975, lng:73.771881}; // intersections 0
			var F = {lat:18.549079, lng:73.771350}; // intersections 2


			var xmin = {lat:18.547842, lng: 73.770981};
			var xmax = {lat:18.54917, lng: 73.772491};


			addMarker(A, map, "A");
			addMarker(B, map, "B");
			addMarker(C, map, "C");
			addMarker(D, map, "D");
			addMarker(E, map, "E");
			addMarker(F, map, "F");
			addMarker(xmin, map, "xmin");
			addMarker(xmax, map, "xmax");

		});
	}


	function plotFence(){

		var fence = [{lat: 18.549009, lng: 73.771049},
					{lat: 18.548044, lng: 73.770981},
					{lat: 18.547842, lng: 73.771706},
					{lat: 18.548746, lng: 73.772491},
					{lat: 18.549170, lng: 73.771889}];
		
		var polygon = new google.maps.Polygon({
			paths: fence
		});
		polygon.setMap(map);
	}




	// Adds a marker to the map.
	function addMarker(location, map, label) {

		var marker = new google.maps.Marker({
			position: location,
			label: label,
			map: map
		});
	}

	init_map();
});
</script> -->
	
</head>
<body>

<div id="map"></div>
<script type="text/javascript">
	
	var map;	

	//load map
	function init_map(){

		var mapOptions = {
			zoom: 18,
			center: {
				lat: 18.548295,
				lng: 73.771608
			}
		};

		map = new google.maps.Map(document.getElementById('map'), mapOptions);
		map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
		
		//called when map is loaded
		google.maps.event.addListenerOnce(map, 'idle', function(){

			plotFence();

			// add points here
			// in polygon
			var A = {lat:18.548162116567774, lng:73.7714478984243};
			var B = {lat:18.5481824596542, lng:73.77169466165367};
			var C = {lat:18.548701207538947, lng:73.7717912211782};

			// out of bounding
			var D = {lat:18.546956784372, lng:73.77050912526909};

			// in bounding but out of polgon
			var E = {lat:18.547975, lng:73.771881}; // intersections 0
			var F = {lat:18.549079, lng:73.771350}; // intersections 2


			var xmin = {lat:18.547842, lng: 73.770981};
			var xmax = {lat:18.54917, lng: 73.772491};


			addMarker(A, map, "A");
			addMarker(B, map, "B");
			addMarker(C, map, "C");
			addMarker(D, map, "D");
			addMarker(E, map, "E");
			addMarker(F, map, "F");
			// addMarker(xmin, map, "xmin");
			// addMarker(xmax, map, "xmax");

		});
	}


	function plotFence(){

		var fence = [{lat: 18.549009, lng: 73.771049},
					{lat: 18.548044, lng: 73.770981},
					{lat: 18.547842, lng: 73.771706},
					{lat: 18.548746, lng: 73.772491},
					{lat: 18.549170, lng: 73.771889}];
		
		var polygon = new google.maps.Polygon({
			paths: fence
		});
		polygon.setMap(map);
	}




	// Adds a marker to the map.
	function addMarker(location, map, label) {

		var marker = new google.maps.Marker({
			position: location,
			label: label,
			map: map
		});
	}

	init_map();
</script>
</body>
</html>
