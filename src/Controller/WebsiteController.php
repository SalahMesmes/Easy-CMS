<?php

namespace EasyCMS\src\Controller;

use EasyCMS\src\Model\WebsiteManager;

/**
 * Class WebsiteController
 * 
 * Controller class for managing website-related actions.
 */
class WebsiteController extends Controller
{
    /** 
     * @var WebsiteManager Instance of WebsiteManager 
     * */
    private $_manager;

    /**
     * Constructor method.
     * Initializes the WebsiteManager instance.
     */
    public function __construct()
    {
        $this->_manager = new WebsiteManager();
        parent::__construct();
    }

    /**
     * Default action method for displaying the homepage.
     * Retrieves and displays the published homepage along with its contents and navigation.
     */
    public function defaultAction()
    {
        $data=[];
        if( $homePage = $this->_manager->getPublishedHomePage()){
            if( $listContentsOfHomePage = $this->_manager->getPublishedContentsByIdPage( $homePage->getId() ) ){
                // Sort the list of contents by positionNumber
                usort($listContentsOfHomePage, function($a, $b) {
                    return $a->getPosition()->getPositionNumber() - $b->getPosition()->getPositionNumber();
                });
                if( $listNav = $this->_manager->getAllPublishedNav() ){
                    $data = [
                        'homePage'                  => $homePage,
                        'listContentsOfHomePage'    => $listContentsOfHomePage,
                        'listNav'                   => $listNav
                    ];

                }                
            }
        }
        $this->render('website', $data);
    }

    /**
     * Action method for selecting a specific page.
     * Retrieves and displays the selected page along with its contents and navigation.
     */
    public function selectPageAction(){
        
        if( isset( $_REQUEST['pageId'] ) ){
            
            if($page = $this->_manager->getPageById($_REQUEST['pageId'])){
                if($listContents = $this->_manager->getPublishedContentsByIdPage( $_REQUEST['pageId'] )){
                    
                    usort($listContents, function($a, $b) {
                        return $a->getPosition()->getPositionNumber() - $b->getPosition()->getPositionNumber();
                    });
                }
            }
            
        }

        $data = [
            'listNav'                   => $this->_manager->getAllPublishedNav(),
            'page'                      => $page,
            'listContents'              => $listContents
        ];

        $this->render('website', $data);
    }
}