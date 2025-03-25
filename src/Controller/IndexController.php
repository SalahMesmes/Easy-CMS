<?php

namespace EasyCMS\src\Controller;

use EasyCMS\src\Model\IndexManager;
use EasyCMS\src\Model\UserManager;
use EasyCMS\src\Model\Entity\User;

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
    $data = [];
    if (isset($_POST['login']) && isset($_POST['password'])) {

        if ($user = $this->_manager->getUserByLogin($_POST['login'])) {
            if (\sodium_crypto_pwhash_str_verify($user->getPassword(), $_POST['password'])) {
                $_SESSION['userId'] = $user->getId();
                $_SESSION['userLogin'] = $user->getLogin();
                $_SESSION['userIdRight'] = $user->getIdRight();
                $data = ['user' => $user];
                header('Location:index.php?controller=profile');
                exit;
            } else {
                $_SESSION['login'] = $user->getLogin();
                $data['message'] = [
                    'type'    => 'warning',
                    'message' => 'Le mot de passe est incorrect'
                ];
                $data['loginSpace'] = true;
            }
        } else {
            $data['message'] = [
                'type'    => 'warning',
                'message' => 'Le login est incorrect'
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


    public function registerAction()
{
    // Vérifier que le formulaire a été soumis
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        // Vérifier si l'utilisateur existe déjà
        $existingUser = $this->_manager->getUserByLogin($username);
        if ($existingUser) {
            $data = [
                'message' => [
                    'type' => 'warning',
                    'message' => "Ce nom d'utilisateur est déjà pris."
                ]
            ];
            $this->render('register', $data);
            return;
        }

        // Hacher le mot de passe avec sodium
        // Assurez-vous que l'extension sodium est activée et que l'appel se fait avec \ pour le namespace global
        $hashedPassword = \sodium_crypto_pwhash_str(
            $password,
            SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE
        );

        // Créer un nouvel objet User
        $user = new \EasyCMS\src\Model\Entity\User([
            'login'    => $username,
            'password' => $hashedPassword,
            // Choisissez ici un droit par défaut, par exemple 2 pour un éditeur
            'id_right' => 2
        ]);

        // Insérer l'utilisateur dans la base de données
        $userManager = new \EasyCMS\src\Model\UserManager();
        $insertedUser = $userManager->insertUser($user);

        if ($insertedUser) {
            // Rediriger vers la page de connexion en cas de succès
            header('Location: index.php?controller=index&action=login');
            exit;
        } else {
            $data = [
                'message' => [
                    'type' => 'warning',
                    'message' => "Erreur lors de l'enregistrement de l'utilisateur."
                ]
            ];
            $this->render('register', $data);
        }
    } else {
        // Si aucune donnée n'est soumise, afficher le formulaire d'inscription
        $this->render('register');
    }
}

}