<?php

namespace AppBundle\Entity\Twitter;

use AppBundle\Entity\Twitter\Tweet;
//use JMS\Serializer\Annotation as Serializer;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tweet result collection entity
 *
 * @package Location
 * @subpackage AppBundle
 * @author Tee Tanawatanakul
 * 
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TweetResultRepository")
 * @ORM\Table(name="tweet_result")
 */
class TweetResult
{
    /**
     * ID
     * @access private
     * @var integer
     * 
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * Tweets
     * 
     * @var Tweet[]
     *  
     * @ORM\ManyToMany(targetEntity="Tweet", orphanRemoval=true, cascade={"persist", "remove"})
     * @ORM\JoinTable(name="tweet_result_tweets",
     *      joinColumns={@ORM\JoinColumn(name="tweet_result_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tweet_id", referencedColumnName="id", unique=true, onDelete="CASCADE")}
     * )
     */
    public $tweets;
    
    /**
     * Latitude coordinate
     * 
     * @var float
     * 
     * @ORM\Column(name="latitude", type="float")
     */
    public $latitude;
    
    /**
     * Longitude coordinate
     * 
     * @var float
     * 
     * @ORM\Column(name="longitude", type="float")
     */
    public $longitude;

    /**
     * Created At
     * 
     * @var \DateTime
     * 
     * @ORM\Column(name="principal", type="datetime")
     */
    public $createdAt;

    /**
     * Constructor
     * 
     * @param string    $id
     * @param Tweet[]   $tweets
     */
    public function __construct($id, $tweets, $latitude, $longitude)
    {
        $this->id        = $id;
        $this->tweets    = $tweets;
        $this->latitude  = $latitude;
        $this->longitude = $longitude;
        $this->createdAt = new \DateTime('now');
    }

    /**
     * Set ID
     * 
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = trim($id);
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return TweetResult
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return TweetResult
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return TweetResult
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Add tweets
     *
     * @param \AppBundle\Entity\Twitter\Tweet $tweets
     * @return TweetResult
     */
    public function addTweet(\AppBundle\Entity\Twitter\Tweet $tweets)
    {
        $this->tweets[] = $tweets;

        return $this;
    }

    /**
     * Remove tweets
     *
     * @param \AppBundle\Entity\Twitter\Tweet $tweets
     */
    public function removeTweet(\AppBundle\Entity\Twitter\Tweet $tweets)
    {
        $this->tweets->removeElement($tweets);
    }

    /**
     * Get tweets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTweets()
    {
        return $this->tweets;
    }
}
