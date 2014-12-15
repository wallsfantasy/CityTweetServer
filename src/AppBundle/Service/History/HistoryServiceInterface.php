<?php

namespace AppBundle\Service\History;

/**
 * Interface for application history service
 *
 * @package Location
 * @subpackage AppBundle
 * @author Tee Tanawatanakul
 */
interface HistoryServiceInterface
{
    /**
     * Key prefix
     */
    const HISTORY_KEY_PREFIX = 'history_';
    
    /**
     * Default history TTL
     */
    const DEFAULT_TTL = 3600;
    
    /**
     * Add history or create new history for the session
     * 
     * @param string $sessionId
     * @param string $key
     */
    public function add($sessionId, $key);
    
    /**
     * Clear history
     * 
     * @param string  $sessionId
     * @return array
     */
    public function get($sessionId);
}
