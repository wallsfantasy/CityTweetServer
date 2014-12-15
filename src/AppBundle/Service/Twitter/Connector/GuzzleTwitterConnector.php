<?php

namespace AppBundle\Service\Twitter\Connector;

// DI
use Guzzle\Http\Client;
// associations
use AppBundle\Service\Twitter\Api\TwitterApiQueryInterface;

/**
 * Twitter provider using Guzzle as backend
 *
 * @package Location
 * @subpackage AppBundle
 * @author Tee Tanawatanakul
 */
class GuzzleTwitterConnector implements TwitterConnectorInterface
{
    /**
     * Guzzle http client
     * 
     * @access private
     * @var Client
     */
    private $_guzzle;

    /**
     * Constructor
     * 
     * @param Client    $guzzle            Guzzle http client
     */
    public function __construct(Client $guzzle)
    {
        $this->_guzzle = $guzzle;
    }

    /**
     * {@inheritDoc}
     */
    public function getData(TwitterApiQueryInterface $query)
    {
        // get query from query object
        $param = $query->getQuery();
        $data = $this->_guzzle->get($param)->send()->getBody(true);
        
        return $data;
    }
}
