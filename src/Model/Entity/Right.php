<?php

namespace EasyCMS\src\Model\Entity;

/**
 * Class Right
 *
 * Represents a user's right or permission.
 */
class Right
{
    /** @var int|null The unique identifier of the right. */
    private $id = 0;

    /** @var string|null The name of the right. */
    private $rightName = 0;

    /**
     * Right constructor.
     *
     * @param array $rightData An associative array containing right data.
     */
    public function __construct(array $rightData)
    {
        $this->hydrate($rightData);
    }

    /**
     * Hydrates the right object with provided data.
     *
     * @param array $data An associative array containing right data.
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

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getRightName()
    {
        return $this->rightName;
    }

    public function setRightName($rightName)
    {
        $this->rightName = $rightName;
    }

}