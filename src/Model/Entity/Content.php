<?php

namespace EasyCMS\src\Model\Entity;

/**
 * Class Content
 * Represents content entity with its properties and methods.
 */
class Content
{
    /** @var int $id The ID of the content. */
    private $id = 0;

    /** @var string $contentName The name of the content. */
    private $contentName = 0;

    /** @var string $contentDescription The description of the content. */
    private $contentDescription = 0;

    /** @var string|null $creationDate The creation date of the content. */
    private $creationDate = 0;

    /** @var string|null $modificationDate The modification date of the content. */
    private $modificationDate = 0;

    /** @var int $isPublished The status of the content (published or not). */
    private $isPublished = 0;

    /** @var int $idUser The ID of the user who created the content. */
    private $idUser = 0;

    /** @var Position|null $position The position of the content. */
    private $position;

    /** @var ContentType|null $contentType The type of the content. */
    private $contentType;

    /**
     * Constructor method to initialize the Content object with data.
     * @param array $contentData The data to populate the content object.
     */
    public function __construct(array $contentData)
    {
        $this->hydrate($contentData);
    }

    /**
     * Hydrates the content object with data.
     * @param array $data The data to hydrate the content object.
     */
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            if ($key === 'contentType') {
                $this->setContentType(new ContentType($value));
            } else if ($key === 'position') {
                $this->setPosition(new Position($value));
            } else {
                $method = 'set' . $this->convertSnakeCaseToCamelCase($key);

                if (method_exists($this, $method)) {
                    $this->$method($value);
                }
            }
        }
    }

    /**
     * Converts snake_case strings to camelCase.
     * @param string $snakeCase The string in snake_case format.
     * @return string The string converted to camelCase.
     */
    private function convertSnakeCaseToCamelCase($snakeCase)
    {
        return str_replace('_', '', ucwords($snakeCase, '_'));
    }

    // Getters and setters for each property

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getContentName()
    {
        return $this->contentName;
    }

    public function setContentName($contentName)
    {
        $this->contentName = $contentName;
    }

    public function getContentDescription()
    {
        return $this->contentDescription;
    }

    public function setContentDescription($contentDescription)
    {
        $this->contentDescription = $contentDescription;
    }

    /**
     * Gets the formatted creation date of the content.
     * @return string|null The formatted creation date, or null if not set or invalid.
     */
    public function getCreationDate(): ?string
    {
        if (empty($this->creationDate)) {
            return null;
        }

        try {
            $dateTimeCreationDate = new \DateTime($this->creationDate);
            return $dateTimeCreationDate->format('d/m/Y à H\hi');
        } catch (\Exception $e) {
            return null;
        }
    }


    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    /**
     * Gets the formatted modification date of the content.
     * @return string|null The formatted modification date, or null if not set or invalid.
     */
    public function getModificationDate(): ?string
    {
        if (empty($this->modificationDate)) {
            return null;
        }

        try {
            $dateTimeModificationDate = new \DateTime($this->modificationDate);
            return $dateTimeModificationDate->format('d/m/Y à H:i:s');
        } catch (\Exception $e) {
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

    public function getIdUser()
    {
        return $this->idUser;
    }

    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * Gets the position of the content.
     * @return Position|null The position of the content, or null if not set.
     */
    public function getPosition(): ?Position
    {
        return $this->position;
    }

    /**
     * Sets the position of the content.
     * @param Position|null $position The position of the content.
     */
    public function setPosition(?Position $position)
    {
        $this->position = $position;
    }

    /**
     * Gets the type of the content.
     * @return ContentType|null The type of the content, or null if not set.
     */
    public function getContentType(): ?ContentType
    {
        return $this->contentType;
    }

    /**
     * Sets the type of the content.
     * @param ContentType $contentType The type of the content.
     */
    public function setContentType(ContentType $contentType)
    {
        $this->contentType = $contentType;
    }

}
