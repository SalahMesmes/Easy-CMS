<?php

namespace EasyCMS\src\Model;

use EasyCMS\src\Model\Entity\User;

/**
 * Class IndexManager
 * 
 * The IndexManager class handles database operations related to users.
 */
class IndexManager extends Manager 
{
    /**
     * Retrieve a user from the database based on their login.
     *
     * @param string $login The login name of the user to retrieve.
     * @return User|null The User object if found, or null if not found or an error occurs.
     */
    public function getUserByLogin(string $login): ?User
    {
        $sql = 'SELECT * FROM users WHERE login=:login';
        $req = $this->dbManager->db->prepare( $sql );
        if( $req->execute( ['login' => $login] ) ){
           $userData = $req->fetch( \PDO::FETCH_ASSOC );
           if( $userData ){
                $user = new User($userData); 
                return $user;
           } else {
            return null;
           }
        } else {
            return null;
        }


    }

}