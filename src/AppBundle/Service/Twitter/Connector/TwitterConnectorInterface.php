<?php

namespace AppBundle\Service\Twitter\Connector;

use AppBundle\Service\Twitter\Api\TwitterApiQueryInterface;

/**
 * Interface for application's Twitter connector
 *
 * @package Location
 * @subpackage AppBundle
 * @author Tee Tanawatanakul
 */
interface TwitterConnectorInterface
{
    /**
     * Get raw data from Twitter by given query
     * 
     * @param TwitterApiQueryInterface $query       Twitter API query object
     * 
     * @return string                               Result from Twitter server
     */
    public function getData(TwitterApiQueryInterface $query);
}
