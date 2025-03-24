<?php

namespace EasyCMS\src\Model\Entity;

/**
 * Class Navigation
 * Represents a navigation entity with its properties and methods.
 */
class Navigation
{
    /** @var int The ID of the navigation. */
    private $id = 0;

    /** @var string The name of the navigation. */
    private $navName = 0;

    /** @var string|null The creation date of the navigation. */
    private $creationDate = 0;

    /** @var string|null The modification date of the navigation. */
    private $modificationDate = 0;

    /** @var int The flag indicating whether the navigation is published or not. */
    private $isPublished = 0;

    /** @var Page|null The page associated with the navigation. */
    private $page;

    /** @var int The ID of the user who created the navigation. */
    private $idUser = 0;

    /** @var int The ID of the position associated with the navigation. */
    private $idPosition = 0;

    /**
     * Navigation constructor.
     * @param array $contentData The data to hydrate the navigation object.
     */
    public function __construct(array $contentData)
    {
        $this->hydrate($contentData);
    }

    /**
     * Hydrates the navigation object with data.
     * @param array $data The data to hydrate the navigation object.
     */
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            if ($key === 'page') {
                $this->setPage(new Page($value));
            } else {
                $method = 'set' . $this->convertSnakeCaseToCamelCase($key);

                if (method_exists($this, $method)) {
                    $this->$method($value);
                }
            }
        }
    }

    /**
     * Converts snake_case to CamelCase.
     * @param string $snakeCase The string in snake_case format.
     * @return string The string converted to CamelCase.
     */
    private function convertSnakeCaseToCamelCase($snakeCase)
    {
        return str_replace('_', '', ucwords($snakeCase, '_'));
    }

    // Getters and setters

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNavName()
    {
        return $this->navName;
    }

    public function setNavName($navName)
    {
        $this->navName = $navName;
    }

    public function getCreationDate(): ?string
    {
        // Assurez-vous que $this->creationDate n'est pas vide
        if (empty($this->creationDate)) {
            return null;
        }

        try {
            $dateTimeCreationDate = new \DateTime($this->creationDate);
            return $dateTimeCreationDate->format('d/m/Y à H\hi');
        } catch (\Exception $e) {
            // Gérer l'erreur si la date n'est pas valide
            return null;
        }
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function getModificationDate(): ?string
    {
        // Assurez-vous que $this->modificationDate n'est pas vide
        if (empty($this->modificationDate)) {
            return null;
        }

        try {
            $dateTimeModificationDate = new \DateTime($this->modificationDate);
            return $dateTimeModificationDate->format('d/m/Y à H:i:s');
        } catch (\Exception $e) {
            // Gérer l'erreur si la date n'est pas valide
            return null;
        }
    }

    public function setModificationDate($modificationDate)
    {
        $this->modificationDate = $modificationDate;
    }

    public function getIsPublished()
    {
        return $this->isPublished;
    }

    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;
    }

    /**
     * Gets the page associated with the navigation.
     * @return Page|null The page associated with the navigation.
     */
    public function getPage(): ?Page
    {
        return $this->page;
    }

    /**
     * Sets the page associated with the navigation.
     * @param Page $page The page associated with the navigation.
     */
    public function setPage(Page $page)
    {
        $this->page = $page;
    }

    public function getIdUser()
    {
        return $this->idUser;
    }

    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    public function getIdPosition()
    {
        return $this->idPosition;
    }

    public function setIdPosition($idPosition)
    {
        $this->idPosition = $idPosition;
    }
}
