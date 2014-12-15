<?php

namespace AppBundle\Service\Twitter\Api;

/**
 * Interface for Twitter API query object
 *
 * @package Location
 * @subpackage AppBundle
 * @author Tee Tanawatanakul
 */
interface TwitterApiQueryInterface
{
    /**
     * Returns query string according to Twitter API
     * 
     * @return string
     */
    public function getQuery();
}
