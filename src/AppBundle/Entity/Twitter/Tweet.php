<?php

namespace AppBundle\Entity\Twitter;

//use JMS\Serializer\Annotation as Serializer;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tweet entity
 *
 * @package Location
 * @subpackage AppBundle
 * @author Tee Tanawatanakul
 * 
 * @ORM\Entity()
 * @ORM\Table(name="tweet")
 */
class Tweet
{
    /**
     * ID
     * 
     * @var integer
     * 
     * @ORM\Id
     * @ORM\Column(type="bigint")
     */
    public $id;
    
    /**
     * Screen name
     * 
     * @var string 
     * 
     * @ORM\Column(name="screen_name", type="string")
     */
    public $screenName;
    
    /**
     * Url of profile image
     * 
     * @var string
     * 
     * @ORM\Column(name="profile_image_url", type="string")
     */
    public $profileImageUrl;
    
    /**
     * Tweet text
     * 
     * @var string
     * 
     * @ORM\Column(name="text", type="string")
     */
    public $text;
    
    /**
     * Latitude
     * 
     * @var float
     * 
     * @ORM\Column(name="latitude", type="float")
     */
    public $latitude;
    
    /**
     * Longitude
     * 
     * @var float
     * 
     * @ORM\Column(name="longitude", type="float")
     */
    public $longitude;
    
    /**
     * Place name
     * 
     * @var string
     * 
     * @ORM\Column(name="place_name", type="string")
     */
    public $placeName;
    
    /**
     * Created at
     * 
     * @var string
     * 
     * @ORM\Column(name="created_at", type="string")
     */
    public $createdAt;
    
    /**
     * Constructor
     * 
     * @param string    $id
     * @param string    $screenName
     * @param string    $profileImageUrl
     * @param string    $text
     * @param float     $latitude
     * @param float     $longitude
     * @param string    $placeName
     * @param \DateTime $createdAt
     */
    public function __construct($id, $screenName, $profileImageUrl, $text, $latitude, $longitude, $placeName, $createdAt)
    {
        $this->id = $id;
        $this->screenName = $screenName;
        $this->profileImageUrl = $profileImageUrl;
        $this->text = $text;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->placeName = $placeName;
        $this->createdAt = $createdAt;
    }
}
