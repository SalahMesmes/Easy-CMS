<?php

namespace EasyCMS\src\Model\Entity;

/**
 * Class Position
 *
 * Represents a position entity for content on a page.
 */
class Position
{
    /** @var int|null The unique identifier of the position. */
    private $id = 0;

    /** @var int|null The position number. */
    private $positionNumber = 0;

    /** @var Page|null The page associated with this position. */
    private $page;

    /**
     * Position constructor.
     *
     * @param array $positionData An associative array containing position data.
     */
    public function __construct(array $positionData)
    {
        $this->hydrate($positionData);
    }

    /**
     * Hydrates the position object with provided data.
     *
     * @param array $data An associative array containing position data.
     * @return void
     */
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            if ($key === 'page') {
                $this->setPage(new Page(['id' => $value]));
            } else {
                $method = 'set' . $this->convertSnakeCaseToCamelCase($key);

                if (method_exists($this, $method)) {
                    $this->$method($value);
                }
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

    public function getPositionNumber()
    {
        return $this->positionNumber;
    }

    public function setPositionNumber($positionNumber)
    {
        $this->positionNumber = $positionNumber;
    }

    /**
     * Gets the page associated with this position.
     *
     * @return Page|null The page associated with this position.
     */
    public function getPage(): ?Page
    {
        return $this->page;
    }

    /**
     * Sets the page associated with this position.
     *
     * @param Page $page The page associated with this position.
     * @return void
     */
    public function setPage(Page $page)
    {
        $this->page = $page;
    }

}
