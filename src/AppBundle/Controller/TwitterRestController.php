<?php

namespace AppBundle\Controller;

// DI
use FOS\RestBundle\Controller\FOSRestController;
// toolsets
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// association
use AppBundle\Entity\Twitter\TweetResult;
use Lsw\MemcacheBundle\Cache\MemcacheInterface;

/**
 * REST controller for Twitter resource
 *
 * @package Location
 * @subpackage AppBundle
 * @author Tee Tanawatanakul
 */
class TwitterRestController extends FOSRestController
{
    // Services
    static $twitterService   = 'twitter_service';
    static $geocoderService  = 'geocoder_service';
    static $cacheService     = 'cache_service';
    static $szService        = 'jms_serializer';
    static $historyService   = 'history_service';
    static $validatorService = 'validator'; // we don't need it yet..
    // Query parameters
    static $paramCityName    = 'city';
    static $paramRadius      = 'radius';
    // Default values
    static $cacheTtl         = 3600;
    static $defaultLocation  = 'Bangkok';

    //[GET] /api/locations
    /**
     * Get collection of Tweets
     * 
     * @ApiDoc(
     *   section = "Twitter",
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
    public function getTweetsAction(Request $req)
    {
        // get parameters and initialize default values
        $cityName = $req->get(static::$paramCityName);
        $cityName = ($cityName !== null) ? $cityName : self::$defaultLocation;

        // get sessionId to add history
        $sessionId = $req->getSession()->getId();
        $result = $this->getTweetResultByCityName($cityName, $sessionId);

        $code     = 200;
        $view     = $this->view($result, $code);
        $response = $view->getResponse();

        return $this->handleView($view);
    }

    /**
     * Get tweet result by city name
     * 
     * @param string $cityName
     * @return TweetResult
     */
    public function getTweetResultByCityName($cityName, $sessionId)
    {
        $twitterServ  = $this->get(static::$twitterService);
        $geocoderServ = $this->get(static::$geocoderService);
        $cacheServ    = $this->get(static::$cacheService);
        $historyServ  = $this->get(static::$historyService);
        /* @var $twitterServ  \AppBundle\Service\Twitter\TwitterService */
        /* @var $geocoderServ \AppBundle\Service\Geocoder\GeocoderService */
        /* @var $cacheServ    \AppBundle\Service\Cache\CacheService */
        /* @var $historyServ  \AppBundle\Service\History\HistoryService */

        // get geocode and real name of given city name
        $geocoded = $geocoderServ->getGeocode($cityName);
        if ($geocoded->getCityDistrict() !== null) {
            $resultId = $geocoded->getCityDistrict();
        } elseif ($geocoded->getCity() !== null) {
            $resultId = $geocoded->getCity();
        } elseif ($geocoded->getCounty() !== null) {
            $resultId = $geocoded->getCounty();
        } elseif ($geocoded->getRegion() !== null) {
            $resultId = $geocoded->getRegion();
        } elseif ($geocoded->getCountry() !== null) {
            $resultId = $geocoded->getCountry();
        } else {
            throw new \Exception('Oops, cannot find city "' . $cityName . '"', 404);
        }
        
        // add history to this session
        $historyServ->add($sessionId, $resultId);
        
        // return Tweet Result if cache exist
        $cachedValue = $cacheServ->get($resultId);
        if ($cachedValue) {
            return $cachedValue;
        }
        
        // use twitter service to search and cache the result
        $tweetResult = $twitterServ->getTweetResultByCity($resultId, $geocoded->getLatitude(), $geocoded->getLongitude());
        $cacheServ->set($resultId, $tweetResult, static::$cacheTtl);

        return $tweetResult;
    }
}
