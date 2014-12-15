<?php

namespace AppBundle\Controller;

// DI
use FOS\RestBundle\Controller\FOSRestController;
// toolsets
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as REST;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * REST controller for History resource
 *
 * @package Location
 * @subpackage AppBundle
 * @author Tee Tanawatanakul
 */
class HistoryRestController extends FOSRestController
{
    // Services
    static $historyService = 'history_service';
    
    //[GET] /api/histories
    /**
     * Get History collection.
     * 
     * @ApiDoc(
     *   section = "History",
     *   resource = true,
     *   description = "Get collection of histories",
     *   statusCodes = {
     *      200 = "Successfully get collection of entities"
     *   }
     * )
     * 
     * @return Response
     */
    public function getHistoriesAction(Request $req)
    {
        $session = $req->getSession();
        $sessionId = $session->getId();
        
        $histories = $this->getHistories($sessionId);
        
        $code = 200;
        $view = $this->view($histories, $code);
        return $this->handleView($view);
    }
    
    /**
     * Get histories from history service
     * 
     * @param string $sessionId
     * @return array
     */
    public function getHistories($sessionId)
    {
        $historySrv = $this->get(static::$historyService);
        /* @var $historySrv \AppBundle\Service\History\HistoryService */
        
        $histories = $historySrv->get($sessionId);
        
        array_reverse($histories);
        return $histories;
    }
}
