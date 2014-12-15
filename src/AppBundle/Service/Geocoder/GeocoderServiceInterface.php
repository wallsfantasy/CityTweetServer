<?php

namespace AppBundle\Service\Geocoder;

use Geocoder\Result\Geocoded;

/**
 * Interface for application Geocoder service
 *
 * @package Location
 * @subpackage AppBundle
 * @author Tee Tanawatanakul
 */
interface GeocoderServiceInterface
{
    /**
     * Get geocode from a place
     * 
     * @param string $place
     * @return Geocoded
     */
    public function getGeocode($place);
}
