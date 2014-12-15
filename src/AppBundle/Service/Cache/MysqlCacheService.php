<?php

namespace AppBundle\Service\Cache;

use AppBundle\Entity\Twitter\TweetResult;
use AppBundle\Repository\TweetResultRepository;

/**
 * Cache service by using mysql as backend
 *
 * @package Location
 * @subpackage AppBundle
 * @author Tee Tanawatanakul
 */
class MysqlCacheService implements CacheServiceInterface
{
    /**
     * Caching storage
     * 
     * @access private
     * @var TweetResultRepository
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
        $data = $this->_storage->validateCache($key, CacheServiceInterface::DEFAULT_TTL);
        return $data;
    }
    
    /**
     * {@inheritDoc}
     */
    public function set($key, $data, $ttl = CacheServiceInterface::DEFAULT_TTL)
    {
        $key = str_replace(' ', '', $key);
        $data->setId($key);
        $this->_storage->create($data);
    }
}
