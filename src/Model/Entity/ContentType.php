<?php

namespace EasyCMS\src\Model\Entity;

/**
 * Class ContentType
 * Represents a content type entity with its properties and methods.
 */
class ContentType
{
    /** @var int|null $id The ID of the content type. */
    private $id;

    /** @var string|null $contentTypeName The name of the content type. */
    private $contentTypeName;

    /** @var string|null $contentTypeDescription The description of the content type. */
    private $contentTypeDescription;

    /**
     * Constructor method.
     * Initializes a new instance of the ContentType class with provided data.
     *
     * @param array $contentTypeData An array containing the data to hydrate the content type object.
     */
    public function __construct(array $contentTypeData)
    {    
        $this->hydrate( $contentTypeData );
    }

    /**
     * Hydrates the content type object with provided data.
     *
     * @param array $data An associative array containing the data to hydrate the content type object.
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
     * Converts a snake_case string to camelCase.
     *
     * @param string $snakeCase The string in snake_case format.
     * @return string The converted string in camelCase format.
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

    public function getContentTypeName()
    {
        return $this->contentTypeName;
    }

    public function setContentTypeName($contentTypeName)
    {
        $this->contentTypeName = $contentTypeName;
    }

    public function getContentTypeDescription()
    {
        return $this->contentTypeDescription;
    }

    public function setContentTypeDescription($contentTypeDescription)
    {
        $this->contentTypeDescription = $contentTypeDescription;
    }

}
