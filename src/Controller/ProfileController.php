<?php

namespace EasyCMS\src\Controller;

/**
 * Class ProfileController
 * 
 * This class represents the controller for the profile view.
 */
class ProfileController extends Controller
{
    /**
     * Constructor method.
     * Calls the parent constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Default action method.
     * Renders the profile view if the user is logged in.
     */
    public function defaultAction()
    {
        if( isset($_SESSION['userId'] ) ){
            
            $this->render('profile');
        } 
        
    }
}