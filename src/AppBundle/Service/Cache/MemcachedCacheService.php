<?php

namespace AppBundle\Service\Cache;

/**
 * Facade for application caching service
 *
 * @package Location
 * @subpackage AppBundle
 * @author Tee Tanawatanakul
 */
class MemcachedCacheService implements CacheServiceInterface
{
    /**
     * Caching storage
     * 
     * @access private
     * @var \Lsw\MemcacheBundle\Cache\MemcacheInterface
     */
    private $_storage;

    /**
     * Constructor
     * 
     * @param object $storage Cache storage backend
     */
    public function __construct($storage)
    {
        $this->_storage  = $storage;
    }
    
    /**
     * {@inheritDoc}
     */
    public function get($key)
    {
        $key = str_replace(' ', '', $key);
        $data = $this->_storage->get($key);
        return $data;
    }
    
    /**
     * {@inheritDoc}
     */
    public function set($key, $data, $ttl = CacheServiceInterface::DEFAULT_TTL)
    {
        $key = str_replace(' ', '', $key);
        $this->_storage->set($key, $data, $ttl);
    }
}
