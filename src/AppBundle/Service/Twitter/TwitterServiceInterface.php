<?php

namespace AppBundle\Service\Twitter;

use AppBundle\Entity\Twitter\TweetResult;

/**
 * Interface for application Twitter service
 *
 * @package Location
 * @subpackage AppBundle
 * @author Tee Tanawatanakul
 */
interface TwitterServiceInterface
{
    /**
     * Default tweet location radius
     */
    const DEFAULT_RADIUS = '5km';
    
    /**
     * Get tweet result object by city name
     * <p>Search twitter message for city name given lat/long coordinate</p>
     * 
     * @param string    $cityName       Name of the city to get tweets (e.g. Bangkok)
     * @param float     $latitude       Latitude (e.g. 13.7500)
     * @param float     $longitude      Longitude (e.g. 100.4667)
     * @param string    $radius         Radius in text (e.g. 5km) default as DEFAULT_RADIUS
     * 
     * @return TweetResult
     * 
     * @see https://dev.twitter.com/rest/public/search
     */
    public function getTweetResultByCity($cityName, $latitude, $longitude, $radius = TwitterServiceInterface::DEFAULT_RADIUS);
}
