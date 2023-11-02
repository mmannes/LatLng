<?php
namespace MMannes;
/**
 * @property-read float $lat
 * @property-read float $lng
 */
class LatLng {

    private $lat;
    private $lng;

    /**
     * Creates a new instance of LagLng
     * @param float $lat latitude in degrees
     * @param float $lng longitude in degrees
     */
    public function __construct($lat, $lng) {
        $this->lat = $lat;
        $this->lng = $lng;
    }

    public function __get($prop) {
        return $this->$prop;
    }

    /**
     * Calculates de distance between to LatLng objects
     * @param LatLng $from
     * @param LatLng $to
     * @return float surface distance in quilometers
     */
    static function distance(LatLng $from, LatLng $to) {
        $earth_radius = 6366.707; // Spherical Earth Approximate of Radius 
                                  // (Phillips, Warren (2004). Mechanics of Flight. John Wiley & Sons, Inc. p. 923.)

        $lat_from_rad = deg2rad($from->lat);
        $lat_to_rad = deg2rad($to->lat);
        $lng_from_rad = deg2rad($from->lng);
        $lng_to_rad = deg2rad($to->lng);

        $distance = acos(
                sin($lat_from_rad) * sin($lat_to_rad) + 
                cos($lat_from_rad) * cos($lat_to_rad) * cos($lng_to_rad-$lng_from_rad)
            ) * $earth_radius;
      
        return $distance;
    }

    /**
	 * Determines whether a given LatLng is in a fence of LatLngs
	 * @param LatLng $point
	 * @param LatLng[] $fence
	 * @return bool
	 */
	public static function pointInFence(LatLng $point, $fence) {
		$polyCorners = count($fence);
		$polyX = array();
		$polyY = array();
		foreach($fence as $corner) {
			$polyX[] = (float) $corner->lng;
			$polyY[] = (float) $corner->lat;
		}
		$x = $point->lng;
		$y = $point->lat;
		$j = $polyCorners - 1;
		$oddNodes = false;
		for($i = 0; $i < $polyCorners; $i++) {
			if($polyY[$i] < $y && $polyY[$j] >= $y  ||  $polyY[$j] < $y && $polyY[$i] >= $y) {
				if ($polyX[$i] + ($y - $polyY[$i]) / ($polyY[$j] - $polyY[$i]) * ($polyX[$j] - $polyX[$i]) < $x) {
					$oddNodes = !$oddNodes; 
				}
			}
			$j = $i;
		}
		return $oddNodes;
	}

}
