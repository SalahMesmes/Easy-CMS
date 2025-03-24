<?php

namespace EasyCMS\src\Model;

use EasyCMS\src\Model\Entity\User;
use EasyCMS\src\Model\Entity\Right;

/**
 * Class UserManager
 * 
 * The UserManager class handles database operations related to users and rights.
 */
class UserManager extends Manager
{
    /**
     * Retrieve all users from the database.
     *
     * @return array|null An array of User objects if users are found, or null if no users are found or an error occurs.
     */
    public function getAllUsers(): ?array
    {
        $listUsers = [];
        $sql = "SELECT * FROM users";
        $req = $this->dbManager->db->prepare( $sql );
        if( $req->execute()){
            $listUserData = $req->fetchAll( \PDO::FETCH_ASSOC );

            foreach( $listUserData as $userData){
                $user = new User($userData);
                $listUsers[] = $user;
                
            }
            
            return $listUsers;
        } else {
            return null;
        }
    }

    /**
     * Retrieve a user from the database by their ID.
     *
     * @param int $id The ID of the user to retrieve.
     * @return User|null The User object if found, or null if not found or an error occurs.
     */
    public function getUserById($id): ?User
    {
        $sql = "SELECT * FROM users WHERE id=:id";
        $req = $this->dbManager->db->prepare( $sql );
        if( $req->execute( ['id' => $id] )){
            $userData = $req->fetch( \PDO::FETCH_ASSOC );
            $user = new User($userData);           
            return $user;
        } else {
            return null;
        }
    }

    /**
     * Retrieve all rights from the database.
     *
     * @return array|null An array of Right objects if rights are found, or null if no rights are found or an error occurs.
     */
    public function getAllRights(): ?array
    {
        $listRights = [];
        $sql = "SELECT * FROM rights";
        $req = $this->dbManager->db->prepare( $sql );
        if( $req->execute()){
            $listRightsData = $req->fetchAll( \PDO::FETCH_ASSOC );

            foreach( $listRightsData as $rightData){
                $right = new Right($rightData);
                $listRights[] = $right;
                
            }
            
            return $listRights;
        } else {
            return null;
        }
    }

    /**
     * Update a user's information in the database.
     *
     * @param User $user The User object containing updated information.
     * @return bool|null True if the update is successful, false if unsuccessful, or null if the provided User object is null.
     */
    public function updateUser(User $user): ?bool
    {
        if( $user ) {
            $sql = "UPDATE users 
                    SET 
                        login=:login,
                        password=:password,
                        id_right=:id_right
                    WHERE 
                        id=:id";
            $req = $this->dbManager->db->prepare( $sql );
            $state = $req->execute([
                ':id'           => $user->getId(),
                ':login'        => $user->getLogin(),
                ':password'     => $user->getPassword(),
                ':id_right'     => $user->getIdRight()

            ]);
            return $state;
        }

        return false;
    }

    /**
     * Delete a user from the database by their ID.
     *
     * @param int $id The ID of the user to delete.
     * @return bool True if the deletion is successful, false otherwise.
     */
    public function deleteUserById($id): bool
    {
        $sql = "DELETE FROM users WHERE id =:id";

        try {
            $req = $this->dbManager->db->prepare($sql);
            $req->execute(['id' => $id]);

            // Check the number of affected rows to confirm deletion
            $rowCount = $req->rowCount();

            return $rowCount > 0;
        } catch (\PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
            return false;
        }
    }

    /**
     * Insert a new user into the database.
     *
     * @param User $user The User object representing the new user to insert.
     * @return User|null The User object with the newly inserted ID if successful, or null if unsuccessful.
     */
    public function insertUser(User $user): ?User
    {
        $sql = "INSERT INTO users (
                    login,
                    password,
                    id_right
                ) VALUES (
                    :login,
                    :password,
                    :id_right
                )";
        $req = $this->dbManager->db->prepare( $sql );
        $state = $req->execute([
            ':login'        => $user->getLogin(),
            ':password'     => $user->getPassword(),
            ':id_right'     => $user->getIdRight()
        ]);
        
        if( !$state ) {
            return null;
        } else {
            $idUser = $this->dbManager->db->lastInsertId();
            $user->setId($idUser);
            
            return $user;
        }  
    }
}