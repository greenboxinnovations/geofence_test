<?php
/**
* REFERENCE
* http://stackoverflow.com/questions/217578/how-can-i-determine-whether-a-2d-point-is-within-a-polygon
*/


// geofence processing
require_once 'geofence_checker.php';
$geo_check = new GeofenceChecker();



// get points from "get_points.php"
// copy from console
// or google maps directly
$geofence_points = [
	[18.549009, 73.771049],
	[18.548044, 73.770981],
	[18.547842, 73.771706],
	[18.548746, 73.772491],
	[18.549170, 73.771889]
];


// private variables are set for testing
$geo_check->setGeofence($geofence_points);


// check pairs
// in
$A = [18.548162116567774,73.7714478984243];
$B = [18.5481824596542,73.77169466165367];
$C = [18.548701207538947,73.7717912211782];
// out of bounding
$D = [18.546956784372,73.77050912526909];
// in bounding but out of polgon
$E = [18.547975, 73.771881]; // intersections 0
$F = [18.549079, 73.771350]; // intersections 2


echo '<pre>';

$geo_check->checkPoint($A, 'A');
$geo_check->checkPoint($B, 'B');
$geo_check->checkPoint($C, 'C');
$geo_check->checkPoint($D, 'D');
$geo_check->checkPoint($E, 'E');
$geo_check->checkPoint($F, 'F');

echo '</pre>';

?>