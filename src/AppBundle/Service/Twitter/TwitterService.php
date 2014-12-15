<?php

namespace AppBundle\Service\Twitter;

// DI
use AppBundle\Service\Twitter\Connector\TwitterConnectorInterface;
use AppBundle\Service\Geocoder\GeocoderServiceInterface;
// associations
use AppBundle\Service\Twitter\Api\TwitterApiQuery;
use AppBundle\Entity\Twitter\TweetResult;
use AppBundle\Entity\Twitter\Tweet;

/**
 * Facade for Twitter application service
 *
 * @package Location
 * @subpackage AppBundle
 * @author Tee Tanawatanakul
 */
class TwitterService implements TwitterServiceInterface
{
    
    /**
     * Twitter provider
     * 
     * @access private
     * @var TwitterConnectorInterface
     */
    private $_twitter;

    /**
     * Constructor
     * 
     * @param TwitterConnectorInterface $twitter    Twitter connector
     */
    public function __construct(TwitterConnectorInterface $twitter)
    {
        $this->_twitter = $twitter;
    }

    /**
     * {@inheritDoc}
     */
    public function getTweetResultByCity($cityName, $latitude, $longitude, $radius = TwitterServiceInterface::DEFAULT_RADIUS)
    {
        $query = new TwitterApiQuery($cityName);
        $query->location($latitude, $longitude, $radius);
        $query->resultType('recent');

        // get data and create tweet result object
        $data        = $this->_twitter->getData($query);
        $tweets      = $this->getTweets($data);
        $tweetResult = new TweetResult($cityName, $tweets, $latitude, $longitude);

        return $tweetResult;
    }

    /**
     * Get tweet result object from raw twitter data
     * 
     * @param string $json   Raw twitter data
     * 
     * @return TweetResult
     */
    private function getTweets($json)
    {
        $rawArray = json_decode($json, true);

        // create Tweet objects
        $tweets = [];
        $statuses = $rawArray['statuses'];
        foreach ($statuses as $rawTweet) {
            $id              = $rawTweet['id'];
            $screenName      = $rawTweet['user']['screen_name'];
            $profileImageUrl = $rawTweet['user']['profile_image_url'];
            $text            = $rawTweet['text'];
            $latitude        = $rawTweet['coordinates']['coordinates'][1];
            $longitude       = $rawTweet['coordinates']['coordinates'][0];
            $placeName       = $rawTweet['place']['name'];
            $createdAt       = $rawTweet['created_at'];

            $tweet = new Tweet($id, $screenName, $profileImageUrl, $text, $latitude, $longitude, $placeName, $createdAt);
            array_push($tweets, $tweet);
        }

        return $tweets;
    }
}
