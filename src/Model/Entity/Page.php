<?php

namespace EasyCMS\src\Model\Entity;

/**
 * Class Page
 *
 * Represents a website page entity.
 */
class Page
{
    /** @var int|null The unique identifier of the page. */
    private $id = 0;

    /** @var string|null The name of the page. */
    private $pageName = 0;

    /** @var string|null The name of the website the page belongs to. */
    private $websiteName = 0;

    /** @var bool|null Indicates whether the page is the home page of the website. */
    private $isHomePage = 0;

    /** @var string|null The creation date of the page. */
    private $creationDate = 0;

    /** @var string|null The creation date of the page. */
    private $modificationDate = 0;

    /** @var bool|null Indicates whether the page is published. */
    private $isPublished = 0;

    /** @var int|null The identifier of the user who created or modified the page. */
    private $idUser = 0;

    /**
     * Page constructor.
     *
     * @param array $pageData An associative array containing page data.
     */
    public function __construct(array $pageData)
    {    
        $this->hydrate( $pageData );
    }

    /**
     * Hydrates the page object with provided data.
     *
     * @param array $data An associative array containing page data.
     * @return void
     */
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . $this->convertSnakeCaseToCamelCase($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * Converts a snake_case string to CamelCase.
     *
     * @param string $snakeCase The string in snake_case format.
     * @return string The string converted to CamelCase format.
     */
    private function convertSnakeCaseToCamelCase($snakeCase)
    {
        return str_replace('_', '', ucwords($snakeCase, '_'));
    }

    // Getters and setters
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getPageName(): ?string
    {
        return $this->pageName;
    }

    public function setPageName($pageName)
    {
        $this->pageName = $pageName;
    }

    public function getWebsiteName(): ?string
    {
        return $this->websiteName;
    }

    public function setWebsiteName($websiteName)
    {
        $this->websiteName = $websiteName;
    }

    public function getIsHomePage(): ?bool
    {
        return $this->isHomePage;
    }

    public function setIsHomePage($isHomePage)
    {
        $this->isHomePage = $isHomePage;
    }

    public function getCreationDate(): ?string
    {
        $dateTimeCreationDate = new \DateTime($this->creationDate);
        $creationDate = $dateTimeCreationDate->format('d/m/Y à H\hi');
        return $creationDate;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function getModificationDate(): ?string
    {
        $dateTimeModificationDate = new \DateTime($this->modificationDate);
        $modificationDate = $dateTimeModificationDate->format('d/m/Y à H\hi');
        return $modificationDate;
    }

    public function setModificationDate($modificationDate)
    {
        $this->modificationDate = $modificationDate;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    

}


