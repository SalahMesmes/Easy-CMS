<?php

namespace EasyCMS\src\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;

/**
 * This file contains the definition of the abstract Controller class.
 */
abstract class Controller
{
    protected $twig; 
    protected $pathView = 'src/View';

    /**
     * Constructor method to set up the Twig environment and process the action.
     */
    public function __construct()
    {

        $loader = new FilesystemLoader( $this->pathView );
        $this->twig = new Environment( $loader, [
            'debug' => true
        ]);
        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->addExtension(new DebugExtension());

        if ( isset($_REQUEST['action']) ) {
            $action = $_REQUEST['action'] . 'Action';
            $this->$action();

        } else {
            $this->defaultAction();
        }

    }

    /**
     * Abstract method to be implemented by classes extending this Controller.
     */
    abstract public function defaultAction();

    /**
     * Renders the specified view using Twig and the provided data.
     * @param string $view The name of the view
     * @param array $data The data to be passed to the view
     */
    protected function render($view, $data=[])
    {   
        
        extract( $data );
        $fileNameView = ucfirst( $view ) . 'View.twig';
        $filePath = $this->pathView . '/' . $fileNameView;
        if( file_exists( $filePath ) ) {
            echo $this->twig->render( $fileNameView, $data );
        } else {
            die('View file not exists');
        }
        
    }

}