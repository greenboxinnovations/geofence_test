<?php
/**
* pass array of points
* REFERENCE
* http://stackoverflow.com/questions/217578/how-can-i-determine-whether-a-2d-point-is-within-a-polygon
*/


// init
// set fence
// calculate bounding box

// checkPoint
	// if in bounding box
		// for each side in fence
			// check intersection

class GeofenceChecker
{	
	private $_polygon_sides = null;	

	private $_xmin;
	private $_xmax;
	private $_ymin;
	private $_ymax;
	private $_e;
	private $_ray_y_coord;


	function __construct(){}

	//get data from the route table
	public function setGeofence($geofence_points){

		$this->_polygon_sides = $this->_createPolygonSidesArray($geofence_points);

		$this->_setBoundingBoxVariables($geofence_points);

	}


	// this is the basic checker
	public function checkPoint($pair, $print_tag){
		
		if($this->_polygon_sides == null) {
			print_r("geofence not set");
			return;
		}

		$x = $pair[0];
		$y = $pair[1];		
				
	
		if( $this->_isInBoundingBox($x, $y)){

			// point is could be inside			
			print("\nPoint ".$print_tag." within Bounding Box\n");
			$this->_checkPolygon($x, $y, $print_tag);			
		} 
		else{

			// point is outside			
			print("\nPoint ".$print_tag." is OUTSIDE Bounding Box\n");			
		}		
	}






	private function _isInBoundingBox($x, $y){
		if($x < $this->_xmin || $x > $this->_xmax || $y < $this->_ymin || $y > $this->_ymax){			
			return false;
		}
		return true;
	}


	// this checks intersections 
	// if odd point is inside
	// else if even point is outside	
	private function _checkPolygon($x, $y, $print_tag){

		// Test the ray against all sides
		$intersections = 0;

		$total_sides = sizeof($this->_polygon_sides);	
		

		for ($side = 0; $side < $total_sides; $side++) {
			
		    // Test if current side intersects with ray.
		    // If yes, intersections++			

			// vector 1
			$v1x1 = $x;													// construct ray
			$v1y1 = $y;													// [x,y] to [x,(ymax + e)]
			$v1x2 = $x;
			$v1y2 = $this->_ray_y_coord;
			// echo $v1y2;

			// vector 2
			$v2x1 = $this->_polygon_sides[$side]['x1'];					// these values are static for a side of a route
			$v2y1 = $this->_polygon_sides[$side]['y1'];					// this comes from db
			$v2x2 = $this->_polygon_sides[$side]['x2'];
			$v2y2 = $this->_polygon_sides[$side]['y2'];


			if( $this->_areIntersecting($v1x1, $v1y1, $v1x2, $v1y2, $v2x1, $v2y1, $v2x2, $v2y2)
			)
			{
				$intersections++;
			}
		}

		print("Intersections found: ".$intersections."\n");
		if (($intersections & 1) == 1) {								//odd even check
		    // Inside of polygon
			print("Point ".$print_tag." is INSIDE\n");		    
		} else {
		    // Outside of polygon			
			print("Point ".$print_tag." is OUTSIDE\n");			
		}
	}


	// function to check ray intersections	
	private function _areIntersecting($v1x1, $v1y1, $v1x2, $v1y2,
    								 $v2x1, $v2y1, $v2x2, $v2y2)
	{
		// Convert vector 1 to a line (line 1) of infinite length.
		// We want the line in linear equation standard form: A*x + B*y + C = 0
		// See: http://en.wikipedia.org/wiki/Linear_equation
		$a1 = $v1y2 - $v1y1;
		$b1 = $v1x1 - $v1x2;
		$c1 = ($v1x2 * $v1y1) - ($v1x1 * $v1y2);
		// if side arrays are stored,
		// a1, b1, c1 can be calculated and stored too

		$d1 = ($a1 * $v2x1) + ($b1 * $v2y1) + $c1;
		$d2 = ($a1 * $v2x2) + ($b1 * $v2y2) + $c1;

		if ($d1 > 0 && $d2 > 0) return false;
    	if ($d1 < 0 && $d2 < 0) return false;

		$a2 = $v2y2 - $v2y1;
		$b2 = $v2x1 - $v2x2;
		$c2 = ($v2x2 * $v2y1) - ($v2x1 * $v2y2);

		$d1 = ($a2 * $v1x1) + ($b2 * $v1y1) + $c2;
		$d2 = ($a2 * $v1x2) + ($b2 * $v1y2) + $c2;

		if ($d1 > 0 && $d2 > 0) return false;
    	if ($d1 < 0 && $d2 < 0) return false;

    	// colinear case is missing from the link
    	return true;

    }


    // a side is made from 2 points
	// connect last point to first to complete the polygon
	private function _createPolygonSidesArray($array){

		// x1,y1 is the first point
		// x2,y2 is the second point
		// hence a side has x1,y1,x2,y2	

		$ret = array();


		for ($i=0; $i < sizeof($array)-1; $i++) { 
			// print($array[$i]);

			$x1 = $array[$i][0];
			$y1 = $array[$i][1];
			// echo '<div>'.$x1.' '.$y1.'</div>';

			$x2 = $array[$i+1][0];
			$y2 = $array[$i+1][1];
			// echo '<div>'.$x2.' '.$y2.'</div>';

			$temp = array();
			$temp['x1'] = $x1;
			$temp['y1'] = $y1;
			$temp['x2'] = $x2;
			$temp['y2'] = $y2;
			array_push($ret, $temp);
		}	

		// connect last point and first point

		$temp = array();
		$temp['x1'] = $x2;
		$temp['y1'] = $y2;
		$temp['x2'] = $array[0][0];
		$temp['y2'] = $array[0][1];
		array_push($ret, $temp);

		return $ret;
	}


	// calculate variables required for the bounding box
	// Xmin,Ymin,Xmax,Ymax, epsilon
	private function _setBoundingBoxVariables($geofence_points){

		$xmin = null;
		$xmax = null; 
		$ymin = null;
		$ymax = null;


		for ($i=0; $i < sizeof($geofence_points); $i++) { 

			$x = $geofence_points[$i][0];
			$y = $geofence_points[$i][1];

			// first pass
			if($xmin == null){
				$xmin = $x;
				$xmax = $x; 
				$ymin = $y;
				$ymax = $y;
			}
			else {

				//for x
				if($x < $xmin)
					$xmin = $x;
				if($x > $xmax)
					$xmax = $x;

				//for y
				if($y < $ymin)
					$ymin = $y;
				if($y > $ymax)
					$ymax = $y;
			}	
		}

		$e = (($xmax - $xmin) / 100);
		// echo '<div>xmin '.$xmin.'</div>';
		// echo '<div>xmax '.$xmax.'</div>';
		// echo '<div>ymin '.$ymin.'</div>';
		// echo '<div>ymax '.$ymax.'</div>';
		// echo '<div>e '.$e.'</div>';


		$this->_xmin = $xmin;
		$this->_xmax = $xmax;
		$this->_ymin = $ymin;
		$this->_ymax = $ymax;
		$this->_e 	 = $e;
		$this->_ray_y_coord = $ymax + $e;


		echo "xmin ".$xmin;
		echo "xmax ".$xmax;
		echo "ymin ".$ymin;
		echo "ymax ".$ymax;
	}
}
?>