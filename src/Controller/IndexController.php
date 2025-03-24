<?php

namespace EasyCMS\src\Controller;

use EasyCMS\src\Model\IndexManager;

/**
 * Class IndexController
 * 
 * This class represents the controller for the index view.
 */
class IndexController extends Controller
{
    /**
     * @var IndexManager Instance of the IndexManager responsible for managing index operations.
     */
    private $_manager;

    /**
     * Constructor method.
     * Instantiates a new IndexManager and calls the parent constructor.
     */
    public function __construct()
    {
        $this->_manager = new IndexManager();
        parent::__construct();
    }

    /**
     * Default action method.
     * Renders the index view based on whether the user is logged in or not.
     */
    public function defaultAction()
    {
        if( isset($_SESSION['userId'] ) ){
                $this->render('index');
        } else {
            $this->render('index');
        }
        
    }

    /**
     * Action method for rendering the login form.
     * Renders the index view with a flag indicating that the login form should be displayed.
     */
    public function loginAction()
    {
        $loginSpace = true;
        $data = [
            'loginSpace' => $loginSpace
        ];
        $this->render('index', $data);
    }

    /**
     * Action method for verifying login credentials.
     * Verifies the provided login credentials and redirects to the profile page upon successful login.
     * Otherwise, displays an error message and the login form.
     */
    public function verifyLoginAction()
    {
        $data=[];
        if( isset( $_POST['login'] ) && isset( $_POST['password'] ) ) {
 
            if( $user = $this->_manager->getUserByLogin( $_POST['login'] ) ) {
                if ($user->getPassword() === $_POST['password']) {
                    $_SESSION['userId'] = $user->getId();
                    $_SESSION['userLogin'] = $user->getLogin();
                    $_SESSION['userIdRight'] = $user->getIdRight();
                    $data = [
                        'user' => $user
                    ]; 
                    header('Location:index.php?controller=profile');
                    exit;
                }
                 else {
                    $_SESSION['login'] = $user->getLogin();
                    $data['message'] = [
                        'type'  => 'warning',
                        'message'  => 'Le mot de passe est incorrect'
                    ];
                    $data['loginSpace'] = true;
                }
            } else {
                $data['message'] = [
                    'type'  => 'warning',
                    'message'  => 'Le login est incorrect'
                ];
                $data['loginSpace'] = true;
            }
        } 

        $this->render('index', $data);

    }

    /**
     * Action method for logging out the user.
     * Destroys session and redirects to the home page.
     */
    public function logoutAction()
    {
        session_destroy();
        header('Location: .');
        exit;
    }
}