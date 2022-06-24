<?php

namespace Repositories\user;

use Database\PDODatabase;
use Generator;
use Models\user\UserDTO;
use PDOException;

class UserRepository
{
    private PDODatabase $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    function insert(UserDTO $userDTO): string
    {
        try {
            $this->db->query(
                "INSERT INTO users
                (username,email,password)
                VALUES
                (:username,:email,:password)
                "
            )->execute(array(
                ":username" => $userDTO->getUsername(),
                ":email" => $userDTO->getEmail(),
                ":password" => $userDTO->getPassword()
            ));
            return "Welcome " . $userDTO->getUsername() .
                " You are successfully Registered!";
        }catch (PDOException $PDOException){
            $log = $PDOException->getMessage(); //TODO: log the error
            return false;
        }
    }

    function getUserById($user_id){
        //TODO: return user by id
    }

    function loginUser($username,$password): ?UserDTO
    {
        try {
            return $this->db->query("
                SELECT 
                id AS user_id,
                username,
                email,
                password
                FROM users 
                WHERE username = :username AND password = :password")
                ->execute(array(
                    ":username" => $username,
                    ":password" => $password,
                ))->fetch(UserDTO::class)
                ->current();

        }catch (PDOException $PDOException){
            $log = $PDOException->getMessage(); //TODO: log the error
            return null;
        }
    }

    function getUserByUsername($username): ?UserDTO
    {
        try {
            return $this->db->query("
                SELECT 
                id AS user_id,
                username,
                email,
                password
                FROM users 
                WHERE username = :username")
                ->execute(array(
                    ":username" => $username
                ))->fetch(UserDTO::class)
                    ->current();

        }catch (PDOException $PDOException){
            $log = $PDOException->getMessage(); //TODO: log the error
            return null;
        }
    }

    function getUserByEmail($email){
        try {
            return $this->db->query("
                SELECT 
                id AS user_id,
                username,
                email,
                password
                FROM users 
                WHERE email = :email")
                ->execute(array(
                    ":email" => $email
                ))->fetch(UserDTO::class)
                ->current();

        }catch (PDOException $PDOException){
            $log = $PDOException->getMessage(); //TODO: log the error
            return null;
        }
    }
}