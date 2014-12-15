<?php

namespace AppBundle\Service\Twitter\Api;

// DI
use Guzzle\Http\Client;
use Guzzle\Plugin\Oauth\OauthPlugin;

/**
 * An easy query object for Twitter API
 *
 * @package Location
 * @subpackage AppBundle
 * @author Tee Tanawatanakul
 * @see https://dev.twitter.com/rest/public/search
 */
class TwitterApiQuery implements TwitterApiQueryInterface
{
    /**
     * Twitter API prefix
     */
    const DEFAULT_TWITTER_API = '1.1';
    
    /**
     * URL query string
     * 
     * @access private
     * @var string
     */
    private $_url;

    /**
     * Constructor
     * 
     * @param string            $search       Search string
     * @param string|float|null $apiVersion   Twitter API Version
     */
    public function __construct($search, $apiVersion = null)
    {
        // insert api version to url
        $apiVersion = ($apiVersion !== null) ? $apiVersion : self::DEFAULT_TWITTER_API;
        $this->_url = '/' . $apiVersion . '/search/tweets.json?';
        
        // append search string
        $this->_url .= 'q=' . urlencode($search);        
    }

    /**
     * Add location parameter to URL
     * 
     * @param string|float  $latitude
     * @param string|float  $longitude
     * @param string        $radius
     * 
     * @return $this
     */
    public function location($latitude, $longitude, $radius)
    {
        $param = '&geocode=';
        $value = $latitude . ',' . $longitude . ',' . $radius;
        
        $this->_url .= $param . $value;
        
        return $this;
    }
    
    /**
     * Add result type parameter to URL
     * 
     * @param string $resultType
     * @return $this
     */
    public function resultType($resultType)
    {
        $param = '&result_type=';
        $value = $resultType;
        
        $this->_url .= $param . $value;
        
        return $this;
    }
    
    /**
     * Add language parameter to URL
     * 
     * @param string $lang
     * @return $this
     */
    public function language($lang)
    {        
        $param = '&lang=';
        $value = $param . $lang;
        
        $this->_url .= $param . $value;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getQuery()
    {
        return $this->_url;
    }
}
