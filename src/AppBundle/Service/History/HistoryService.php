<?php

namespace AppBundle\Service\History;

/**
 * Facade for history service
 *
 * @package Location
 * @subpackage AppBundle
 * @author Tee Tanawatanakul
 */
class HistoryService implements HistoryServiceInterface
{
    /**
     * History storage
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
    public function add($sessionId, $key)
    {
        $historySessionId = $this->getHistorySessionId($sessionId);

        $exist = $this->_storage->get($historySessionId);
        if(!$exist) {
            // initialize new session history
            $this->create($historySessionId);
        }
        
        $this->appendHistory($historySessionId, $key);
    }
    
    /**
     * {@inheritDoc}
     */
    public function get($sessionId)
    {
        $historySessionId = $this->getHistorySessionId($sessionId);
        
        $historyLine = $this->_storage->get($historySessionId);
        
        // return null array if there's no history
        if(!$historyLine) {
            return [];
        }
        
        $histories = explode(',', $historyLine);
        unset($histories[0]);
        
        return array_reverse($histories);
    }
    
    /**
     * Get ID of history from session ID
     * 
     * @param type $sessionId
     * @return string
     */
    public function getHistorySessionId($sessionId)
    {
        $prefix = HistoryServiceInterface::HISTORY_KEY_PREFIX;
        $historySessionId = $prefix. $sessionId;
        
        return $historySessionId;
    }
    
    /**
     * Create new history for session
     * 
     * @param string $historySessionId
     */
    private function create($historySessionId)
    {
        $this->_storage->set($historySessionId, '');
    }
    
    /**
     * Append history
     * 
     * @param string $historySessionId
     * @param string $key
     */
    private function appendHistory($historySessionId, $key)
    {   
        // append history
        $previous = $this->_storage->get($historySessionId);
        
        $histories = explode(',', $previous);
        unset($histories[0]);
        
        foreach($histories as $existId => $existKey) {
            if($key === $existKey) {
                unset($histories[$existId]);
            }
        }
        
        $current = $previous . ',' . $key;
        $this->_storage->set($historySessionId, $current);
    }
}
