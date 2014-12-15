<?php

/*
 * All rights reserved. (c) 2014, D-SYSTEM & SERVICES
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS 
 * "AS IS" WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED OR 
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED WARRANTIES 
 * OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 * 
 * @copyright (c) 2014, D-SYSTEM & SERVICES
 */

namespace AppBundle\Repository;

// inheritance
use Doctrine\ORM\EntityRepository;
// association
use AppBundle\Entity\Twitter\TweetResult as Entity;

/**
 * Repository class for Tweet Result Entity
 *
 * @package Location
 * @subpackage AppBundle
 * @author Tee Tanawatanakul
 */
class TweetResultRepository extends EntityRepository
{
    /**
     * Create an entity
     * 
     * @param Entity $entity
     */
    public function create(Entity $entity)
    {
        $now = new \DateTime('now');
        $entity->setCreatedAt($now);
        
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    /**
     * Update an entity
     * 
     * @param Entity $entity
     */
    public function update(Entity $entity)
    {
        $this->_em->merge($entity);
        $this->_em->flush();
    }

    /**
     * Delete an entity
     * 
     * @param string $id
     */
    public function delete($id)
    {
        $entity = $this->find($id);
        $this->_em->remove($entity);
        $this->_em->flush();
    }
    
    /**
     * Validate cache and returns entity if it's still valid
     * 
     * @param string  $id
     * @param integer $ttl
     * 
     * @return Entity|null
     */
    public function validateCache($id, $ttl)
    {
        $entity = $this->find($id);
        /* @var $entity \AppBundle\Entity\Twitter\TweetResult */
        
        if($entity === null) {
            return false;
        }
        
        // create expire dateTime to compare entity age
        $expire = clone($entity->getCreatedAt());
        $intervalText = date_interval_create_from_date_string($ttl . ' seconds');
        $expire->add($intervalText);
        $now = new \DateTime('now');
        
        if($now > $expire) {
            // cache expires, delete entity
            $this->delete($id);
            return false;
        } else {
            return $entity;
        }
        
    }
}
