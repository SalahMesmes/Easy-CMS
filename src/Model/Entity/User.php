<?php

namespace EasyCMS\src\Model\Entity;

/**
 * Class User
 *
 * Represents a user in the system.
 */
class User
{
    /** @var int|null The unique identifier of the user. */
    private $id = 0;

    /** @var string|null The login username of the user. */
    private $login = 0;

    /** @var string|null The hashed password of the user. */
    private $password = 0;

    /** @var int|null The ID of the user's assigned right or permission. */
    private $idRight = 0;

    /**
     * User constructor.
     *
     * @param array $userData An associative array containing user data.
     */
    public function __construct(array $userData)
    {
        $this->hydrate($userData);
    }

    /**
     * Hydrates the user object with provided data.
     *
     * @param array $data An associative array containing user data.
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

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getIdRight()
    {
        return $this->idRight;
    }

    public function setIdRight($idRight)
    {
        $this->idRight = $idRight;
    }

}