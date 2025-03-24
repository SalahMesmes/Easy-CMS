<?php

namespace EasyCMS\src\Controller;

use EasyCMS\src\Model\EditManager;

use EasyCMS\src\Model\Entity\Page;

use EasyCMS\src\Model\Entity\Content;
use EasyCMS\src\Model\Entity\Navigation;
use EasyCMS\src\Model\Entity\Position;
use EasyCMS\src\Model\WebsiteManager;

/**
 * Class EditController
 * 
 * This class represents the controller for editing content and pages in the CMS.
 */
class EditController extends Controller
{
    /**
     * @var EditManager Instance of the EditManager responsible for managing editing operations.
     */
    private $_manager;

    private $websiteManager;

    /**
     * Constructor
     * 
     * Initializes a new EditManager instance to manage editing operations.
     */
    public function __construct()
    {
        $this->_manager = new EditManager();
        $this->websiteManager = new WebsiteManager();
               
        parent::__construct();
    }

    /**
     * Default Action
     * 
     * Represents the default action for the EditController.
     * If the user is logged in, it renders the editing view, otherwise, it renders the index view.
     */
    public function defaultAction()
    {
        if( isset( $_SESSION['userId'] ) ){
                $this->render('edit');
        } else {
            $this->render('index');
        }
        
    }

    /**
     * Action to edit a page.
     * Retrieves all pages and renders the editing view with the list of pages.
     */
    public function editPageAction()
    {
        if( $listPages = $this->_manager->getAllPages() ){
            $listContentsPages = $this->_manager->getAllContents();
            $listPositionsPages = $this->_manager->getAllPositions();
            $listContentTypesPages = $this->_manager->getAllContentTypes();
            $data = [
                'listPages' => $listPages,
                'listContentsPages' => $listContentsPages,
                'listPositionsPages' => $listPositionsPages,
                'listContentTypesPages' => $listContentTypesPages
            ]; 
            $this->render('edit', $data);
        }
    }

    /**
     * Action to publish quickly a page.
     */
    public function publishPageAction()
    {
        if( isset($_REQUEST['pageId'])){
            $page = $this->_manager->getPageById($_REQUEST['pageId']);
            if( isset($_REQUEST['toPublish']) ){
                $page->setIsPublished(1);
            } else {
                $page->setIsPublished(0);
            }
    
            if( $page = $this->_manager->updatePage($page) ){
                if( $listPages = $this->_manager->getAllPages() ){
                    $listContentsPages = $this->_manager->getAllContents();
                    $listPositionsPages = $this->_manager->getAllPositions();
                    $listContentTypesPages = $this->_manager->getAllContentTypes();
                    $data = [
                        'listPages' => $listPages,
                        'listContentsPages' => $listContentsPages,
                        'listPositionsPages' => $listPositionsPages,
                        'listContentTypesPages' => $listContentTypesPages
                    ]; 
                    $this->render('edit', $data);
                }
            }
        }

        
    }


    /**
     * Action to update a page.
     * Retrieves the selected page by ID and renders the editing view with the selected page data.
     */
    public function updatePageAction()
    {
        
        if( isset($_REQUEST['pageId']) ){
            $id = $_REQUEST['pageId'];
            if( $selectedPage = $this->_manager->getPageById($id) ){
                $listPages = $this->_manager->getAllPages();
                $data = [
                    'listPages' => $listPages,
                    'selectedPage' => $selectedPage
                ]; 
                $this->render('edit', $data);
            }
        }
    }

    /**
     * Action to validate updating a page.
     * Updates the selected page with new data and renders the editing view with updated data and a success message.
     */
    public function updatePageValidAction()
    {
        $data = [
            'message'   => [
                'type'      => 'warning',
                'message'   => 'Erreur lors de la modification' 
            ]
        ];

        if ( isset($_REQUEST['id']) && !empty($_REQUEST['pageName']) && !empty($_REQUEST['stringIsHomePage']) ){
            $page = $this->_manager->getPageById( $_REQUEST['id']);
            $page->setPageName($_REQUEST['pageName']);
            if( $_REQUEST['stringIsHomePage'] === 'Oui' ){
                $page->setIsHomePage(1);
            }else{
                $page->setIsHomePage(0);
            }
            if( isset($_REQUEST['toPublish']) ){
                $page->setIsPublished(1);
            } else {
                $page->setIsPublished(0);
            }
            $page->setIdUser($_SESSION['userId']);
            if($this->_manager->updatePage( $page )) {
                $data['message']['type'] = 'success';
                $data['message']['message'] = 'Modification de la page effectuée !';
            }
            $data['selectedPage'] = $page;
        }
        $data['listPages'] = $this->_manager->getAllPages();
        $this->render('edit', $data);
    }

    /**
     * Action to delete a page.
     * Deletes the page with the provided ID and renders the editing view with a success or error message.
     */
    public function deletePageAction()
    {
        $message = [
            'type'      => 'warning',
            'message'   => 'Erreur lors de la suppression' 
        ];

        if ( isset($_REQUEST['id']) ) {
            $id = $_REQUEST['id'];
            if( $this->_manager->deletePageById( $id ) ){
                $message['type'] = 'success';
                $message['message'] = 'Suppression de la page effectuée !';
                $selectedPage = null;
            } else {
                $selectedPage = $this->_manager->getPageById($id);
            }
        } 
        $listPages = $this->_manager->getAllPages();
        $data = [
            'listPages'         => $listPages,
            'message'           => $message,
            'selectedPage'      => $selectedPage
        ];

        $this->render('edit', $data);
    }

    /**
     * Action to create a new page.
     * Renders the editing view with the option to create a new page.
     */
    public function createPageAction()
    {
        $data = [
            'listPages' => $this->_manager->getAllPages(),
            'createPage' => true
        ]; 
        $this->render('edit', $data);
    }

    /**
     * Action to validate creating a new page.
     * Creates a new page with provided data and renders the editing view with success or error message.
     */
    public function createPageValidAction()
    {
        $data = [
            'message'   => [
                'type'      => 'warning',
                'message'   => 'Erreur lors de la création' 
            ],
            'createPage' => true
        ];

        if ( !empty($_REQUEST['pageName']) && !empty($_REQUEST['stringIsHomePage']) ){
            $page = new Page([]);
            $page->setPageName($_REQUEST['pageName']);
            if( $_REQUEST['stringIsHomePage'] === 'Oui' ){
                $page->setIsHomePage(1);
            }else{
                $page->setIsHomePage(0);
            }
            if( isset($_REQUEST['toPublish']) ){
                $page->setIsPublished(1);
            } else {
                $page->setIsPublished(0);
            }
            $page->setIdUser( $_SESSION['userId'] );

            if($this->_manager->insertPage( $page )) {
                $data['message']['type'] = 'success';
                $data['message']['message'] = 'Création de la page effectuée !';
            }
            
        }
        $data['listPages'] = $this->_manager->getAllPages();
        $this->render('edit', $data);
    }

    /**
     * Action to edit content.
     * Retrieves all contents and renders the editing view with the list of contents.
     */
    public function editContentAction()
    {
        $data = [];
        if( $listContents = $this->_manager->getAllContents() ){
            $data = [
                'listContents' => $listContents
            ]; 
            
        }
        $this->render('edit', $data);
    }

    /**
     * Action to update content.
     * Retrieves the selected content by ID and renders the editing view with the selected content data.
     */
    public function updateContentAction()
    {
        
        if( isset($_REQUEST['contentId']) ){
            $id = $_REQUEST['contentId'];
            if( $selectedContent = $this->_manager->getContentById($id) ){
                $listContents = $this->_manager->getAllContents();
                $listContentTypes = $this->_manager->getAllContentTypes();
                $listPositions = $this->_manager->getAllPositions();
                $data = [
                    'listContents'      => $listContents,
                    'listContentTypes'  => $listContentTypes,
                    'listPositions'     => $listPositions,
                    'selectedContent'   => $selectedContent
                ]; 
                
            }
        }
        $this->render('edit', $data);
    }
   
    /**
     * Action to validate updating content.
     * Updates the selected content with provided data and renders the editing view with success or error message.
     */
    public function updateContentValidAction()
    {
        $message = [
            'type'      => 'warning',
            'message'   => 'Erreur lors de la modification' 
        ];

        $content = null;
        if ( isset($_REQUEST['id']) && !empty($_REQUEST['contentName']) && !empty($_REQUEST['contentDescription']) ){
            $content = $this->_manager->getContentById( $_REQUEST['id']);
            $content->setContentName($_REQUEST['contentName']);
            $contentType = $this->_manager->getContentTypeById($_REQUEST['contentType']);
            $content->setContentType($contentType);
            $content->setContentDescription($_REQUEST['contentDescription']);
            if( isset($_FILES['img']) ){
                
                if( $_FILES['img']['error'] === UPLOAD_ERR_OK ){
                    $allowedExtensions = ['jpg', 'jpeg', 'png'];
                    $uploadDir = 'assets/images/';
                    $uploadFile = $uploadDir . basename($_FILES['img']['name']);
                    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
                    $maxFileSize = 128 * 1024; // 128 Ko

                    // Check file size
                    if ($_FILES['img']['size'] <= $maxFileSize) {
                        // Check file extension
                        if (in_array($imageFileType, $allowedExtensions)) {
                            // Move uploaded file to target directory
                            if (move_uploaded_file($_FILES['img']['tmp_name'], $uploadFile)) {
                                // File uploaded successfully

                                // Save file name in content description
                                $imageName = $_FILES['img']['name'];
                                $content->setContentDescription($imageName);

                            } else {
                                // An error occurred while uploading the file
                                $message['type'] = 'warning';
                                $message['message'] = 'Erreur lors du téléchargement du fichier.';
                            }
                        } else {
                            // Unauthorized file extension
                            $message['type'] = 'warning';
                            $message['message'] = 'Seuls les fichiers JPG, JPEG et PNG sont autorisés.';
                        }
                    } else {
                        // Excessive file size
                        $message['type'] = 'warning';
                        $message['message'] = 'La taille du fichier ne doit pas dépasser 128 Ko.';
                    }
                } else {
                    // No file uploaded or an error occurred
                    $message['type'] = 'warning';
                    $message['message'] = 'La taille du fichier ne doit pas dépasser 128 Ko.';
                }

            }
                
            
            if( isset($_REQUEST['toPublish']) ){
                $content->setIsPublished(1);
            } else {
                $content->setIsPublished(0);
            }
            $position = new Position([]);
            if( isset($_REQUEST['position']) ){
                $idPosition = $_REQUEST['position'];
                $idPosition = ($idPosition === "") ? 0 : $idPosition;
                if ( $idPosition != 0 ) {
                    $position = $this->_manager->getPositionById($_REQUEST['position']);
                }                   
            }
            $content->setPosition($position);
            $content->setIdUser( $_SESSION['userId'] );
            if($this->_manager->updateContent( $content )) {
                $message['type'] = 'success';
                $message['message'] = 'Modification du contenu effectuée !';
            }
        }
        $listContents = $this->_manager->getAllContents();
        $listContentTypes = $this->_manager->getAllContentTypes();
        $listPositions = $this->_manager->getAllPositions();
        $data = [
            'listContents'      => $listContents,
            'listContentTypes'  => $listContentTypes,
            'listPositions'     => $listPositions,
            'message'           => $message,
            'selectedContent'   => $content
        ]; 
        $this->render('edit', $data);
    }
    
    /**
     * Action to delete content.
     * Deletes the content with the provided ID and renders the editing view with a success or error message.
     */
    public function deleteContentAction()
    {
        $message = [
            'type'      => 'warning',
            'message'   => 'Erreur lors de la suppression' 
        ];

        if ( isset($_REQUEST['id']) ) {
            $id = $_REQUEST['id'];
            if( $this->_manager->deleteContentById( $id ) ){
                $message['type'] = 'success';
                $message['message'] = 'Suppression du contenu effectuée !';
                $selectedContent = $this->_manager->getContentById($id);
            }
        }
        $listContents = $this->_manager->getAllContents();
        $listContentTypes = $this->_manager->getAllContentTypes();
        $listPositions = $this->_manager->getAllPositions();
        $data = [
            'listContents'      => $listContents,
            'listContentTypes'  => $listContentTypes,
            'listPositions'     => $listPositions,
            'message'           => $message,
            'selectedContent'   => $selectedContent
        ];

        $this->render('edit', $data);
    }

    /**
     * Action to create a new content.
     * Renders the editing view with the option to create a new content.
     */
    public function createContentAction()
    {
        $data = [
            'listContents' => $this->_manager->getAllContents(),
            'listContentTypes'  => $this->_manager->getAllContentTypes(),
            'listPositions' => $this->_manager->getAllPositions(),
            'createContent' => true
        ]; 
        $this->render('edit', $data);
    }

    /**
     * Action to validate creating new content.
     * Creates new content with provided data and renders the editing view with success or error message.
     */
    public function createContentValidAction()
    {
        $message = [
            'type'      => 'warning',
            'message'   => 'Erreur lors de la création' 
        ];

        if ( !empty($_REQUEST['contentName']) && !empty($_REQUEST['contentDescription']) ){
            $content = new Content([]);
            $content->setContentName($_REQUEST['contentName']);
            $content->setContentDescription($_REQUEST['contentDescription']);
            $contentType = $this->_manager->getContentTypeById($_REQUEST['contentType']);
            $content->setContentType($contentType);
            if( isset($_REQUEST['toPublish']) ){
                $content->setIsPublished(1);
            } else {
                $content->setIsPublished(0);
            }
            $position = new Position([]);
            if( isset($_REQUEST['position']) ){
                $idPosition = $_REQUEST['position'];
                $idPosition = ($idPosition === "") ? 0 : $idPosition;
                if ( $idPosition != 0 ) {
                    $position = $this->_manager->getPositionById($_REQUEST['position']);
                }                   
            }
            $content->setPosition($position);
            
            $content->setIdUser( $_SESSION['userId'] );
            if($this->_manager->insertContent( $content )) {
                $message['type'] = 'success';
                $message['message'] = 'Création du contenu effectuée !';
            }
        }
        $listContents = $this->_manager->getAllContents();
        $listContentTypes = $this->_manager->getAllContentTypes();
        $listPositions = $this->_manager->getAllPositions();
        $data = [
            'listContents'      => $listContents,
            'listContentTypes'  => $listContentTypes,
            'listPositions'     => $listPositions,
            'message'           => $message,
            'createContent' => true
        ]; 
        $this->render('edit', $data);
    }

    /**
     * Action to edit navigation.
     * Retrieves all navigations and renders the editing view with the list of navigations.
     */
    public function editNavAction()
    {
        if( $listNavigations = $this->_manager->getAllNavigations() ){
            $data = [
                'listNavigations' => $listNavigations
            ]; 
            $this->render('edit', $data);
        }
    }

    /**
     * Action to update navigation.
     * Retrieves the selected navigation by ID and renders the editing view with the selected navigation data.
     */
    public function updateNavAction()
    {
        
        if( isset($_REQUEST['navId']) ){
            $id = $_REQUEST['navId'];
            if( $selectedNav = $this->_manager->getNavigationById($id) ){
                $listNavigations = $this->_manager->getAllNavigations();
                $listNavPages = $this->_manager->getAllPages();
                $data = [
                    'listNavigations'   => $listNavigations,
                    'listNavPages'      => $listNavPages,
                    'selectedNav'       => $selectedNav
                ]; 
                
            }
        }
        $this->render('edit', $data);
    }

    /**
     * Action to validate updating navigation.
     * Updates the navigation with provided data and renders the editing view with success or error message.
     */
    public function updateNavValidAction()
    {
        $message = [
            'type'      => 'warning',
            'message'   => 'Erreur lors de la modification' 
        ];

        if ( isset($_REQUEST['id']) && !empty($_REQUEST['navName']) ){
            $nav = $this->_manager->getNavigationById( $_REQUEST['id']);
            $nav->setNavName($_REQUEST['navName']);
            $navPage = $this->_manager->getPageById($_REQUEST['navPage']);
            $nav->setPage($navPage);
            if( isset($_REQUEST['toPublish']) ){
                $nav->setIsPublished(1);
            } else {
                $nav->setIsPublished(0);
            }            
            $nav->setIdUser($_SESSION['userId']); 
            if($this->_manager->updateNavigation( $nav )) {
                $message['type'] = 'success';
                $message['message'] = 'Modification de la navigation effectuée !';
            }
        }
        
        $listNavigations = $this->_manager->getAllNavigations();
        $listNavPages = $this->_manager->getAllPages();
        $data = [
            'listNavigations'   => $listNavigations,
            'listNavPages'      => $listNavPages,
            'message'           => $message,
            'selectedNav'       => $nav
        ];

        $this->render('edit', $data);
    }

    /**
     * Action to delete navigation.
     * Deletes the navigation with the provided ID and renders the editing view with a success or error message.
     */
    public function deleteNavAction()
    {
        $message = [
            'type'      => 'warning',
            'message'   => 'Erreur lors de la suppression' 
        ];

        if ( isset($_REQUEST['id']) ) {
            $id = $_REQUEST['id'];
            if( $this->_manager->deleteNavById( $id ) ){
                $message['type'] = 'success';
                $message['message'] = 'Suppression de la navigation effectuée !';
                $selectedNav = null;
            } else {
                $selectedNav = $this->_manager->getPageById($id);
            }
        } 
        $listNavigations = $this->_manager->getAllNavigations();
        $listNavPages = $this->_manager->getAllPages();
        $data = [
            'listNavigations'   => $listNavigations,
            'listNavPages'      => $listNavPages,
            'message'           => $message,
            'selectedNav'       => $selectedNav
        ];

        $this->render('edit', $data);
    }

    /**
     * Action to create navigation.
     * Renders the editing view with necessary data to create a new navigation.
     */
    public function createNavAction()
    {    
        $data = [
            'listNavigations'   => $this->_manager->getAllNavigations(),
            'listNavPages'      => $this->_manager->getAllPages(),
            'createNav'         => true
        ]; 
        $this->render('edit', $data);
    }

    /**
     * Action to validate creating navigation.
     * Creates a new navigation with provided data and renders the editing view with success or error message.
     */
    public function createNavValidAction()
    {
        $message = [
            'type'      => 'warning',
            'message'   => 'Erreur lors de la création' 
        ];

        if ( !empty($_REQUEST['navName']) ){
            $nav = new Navigation([]);
            $nav->setNavName($_REQUEST['navName']);
            $navPage = $this->_manager->getPageById($_REQUEST['navPage']);
            $nav->setPage($navPage);
            if( isset($_REQUEST['toPublish']) ){
                $nav->setIsPublished(1);
            } else {
                $nav->setIsPublished(0);
            }            
            $nav->setIdUser( $_SESSION['userId'] );
            if($this->_manager->insertNavigation( $nav )) {
                $message['type'] = 'success';
                $message['message'] = 'Création de la navigation effectuée !';
            }
        }

        $listNavigations = $this->_manager->getAllNavigations();
        $listNavPages = $this->_manager->getAllPages();
        $data = [
            'listNavigations'   => $listNavigations,
            'listNavPages'      => $listNavPages,
            'message'           => $message,
            'createNav'         => true
        ];
        $this->render('edit', $data);
    }

}