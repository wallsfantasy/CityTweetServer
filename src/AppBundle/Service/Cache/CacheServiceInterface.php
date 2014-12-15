<?php

namespace AppBundle\Service\Cache;

/**
 * Interface for application caching service
 *
 * @package Location
 * @subpackage AppBundle
 * @author Tee Tanawatanakul
 */
interface CacheServiceInterface
{
    /**
     * Default cache TTL
     */
    const DEFAULT_TTL = 3600;
    
    /**
     * Get cache result by key
     * 
     * @param string $key
     * @return string|false
     */
    public function get($key);
    
    /**
     * Set cache
     * 
     * @param string  $key
     * @param mixed   $data
     * @param integer $ttl
     */
    public function set($key, $data, $ttl = CacheServiceInterface::DEFAULT_TTL);
}
