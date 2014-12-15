<?php

namespace AppBundle\Service\Geocoder;

// DI
use Geocoder\Geocoder;

/**
 * Facade for Geocoder application service
 *
 * @package Location
 * @subpackage AppBundle
 * @author Tee Tanawatanakul
 */
class GeocoderService implements GeocoderServiceInterface
{
    /**
     * Flag for underlying geocoder library
     */
    const GEOCODING_PROVIDER = 'google_maps';
    
    /**
     * Geocoder Service
     * 
     * @access private
     * @var Geocoder
     */
    private $_geocoder;

    /**
     * Constructor
     * 
     * @param Geocoder $geocoder Geocoder object
     */
    public function __construct(Geocoder $geocoder)
    {
        $this->_geocoder  = $geocoder;
    }

    /**
     * {@inheritDoc}
     */
    public function getGeocode($place)
    {
        $location = $this->_geocoder
                ->using(self::GEOCODING_PROVIDER)
                ->geocode($place);
        return $location;
    }
}
