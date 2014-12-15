<?php

namespace AppBundle\Controller;

// DI
use FOS\RestBundle\Controller\FOSRestController;
// toolsets
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * REST controller for Location resource
 *
 * @package Location
 * @subpackage AppBundle
 * @author Tee Tanawatanakul
 */
class LocationRestController extends FOSRestController
{
    // Services
    static $geocodingService = 'geocoder_service';
    static $validatorService = 'validator'; // we don't need it yet..
    // Parameters
    static $paramCityName = 'city';
    // Default values
    static $defaultCity = 'Bangkok';

    //[GET] /api/locations
    /**
     * Get collection of locations
     * 
     * @ApiDoc(
     *   section = "Location",
     *   resource = true,
     *   description = "Get collection of locations",
     *   filters = {
     *      {"name"="city", "dataType"="string", "description"="City to search"}
     *   },
     *   statusCodes = {
     *      200 = "Successfully get collection of entities"
     *   }
     * )
     * 
     * @return Response
     */
    public function getLocationsAction(Request $req)
    {
        $geocoder = $this->get(static::$geocodingService);
        /* @var $geocoder \AppBundle\Service\Geocoder\GeocoderService */

        // get parameters and initialize default values
        $cityName = $req->get(static::$paramCityName);
        $cityName = ($cityName !== null) ? $cityName : self::$defaultCity;

        // build result
        $result = $geocoder->getGeocode($cityName);

        $code = 200;
        $view = $this->view($result, $code);
        return $this->handleView($view);
    }
}
