<?php

namespace Models\user;

use Exception;

class UserDTO
{
    private int $user_id;
    private string $username;
    private string $email;
    private string $password;
    private string $first_name;
    private string $last_name;

    public static function create($username,$email,$password,$re_password): UserDTO
    {
        return (new UserDTO())
            ->setUsername($username)
            ->setEmail($email)
            ->setPassword($password,$re_password);
    }

    public function __toString(): string
    {
        // TODO: Implement __toString() method.
        return "Username: " . $this->getUsername() . " Password: " . $this->getPassword();
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @param string $username
     * @return UserDTO
     * @throws Exception
     */
    public function setUsername(string $username): UserDTO
    {
        if (strlen($username) < 5 || strlen($username) > 45){
            throw new Exception('The username must be between 5 and 45 characters');
        }
        if (trim($username) == ""){
            throw new Exception("The username can't be empty!");
        }
        if (!preg_match("/^[\w]{5,45}$/",$username)){
            throw new Exception("The username can contains only letters, digits and underscore!");
        }
        $this->username = $username;
        return $this;
    }

    /**
     * @param string $password
     * @param string $re_password
     * @return UserDTO
     * @throws Exception
     */
    public function setPassword(string $password, string $re_password): UserDTO
    {
        if (strlen($password) < 8 || strlen($password) > 75){
            throw new Exception("Password must be between 8 and 75 characters!");
        }
        if (trim($password) == ""){
            throw new Exception("Password can't be empty!");
        }
        if ($password != $re_password){
            throw new Exception("Password and re-password doesn't match!");
        }

        //TODO Convert the password to hash encryption with the Class Encryption not like this!
        $password = password_hash($password,PASSWORD_ARGON2I);
//        $password = md5($password);
        $this->password = $password;
        return $this;
    }

    /**
     * @param string $email
     * @return UserDTO
     * @throws Exception
     */
    public function setEmail(string $email): UserDTO
    {

        if (strlen($email) < 9 || strlen($email) > 145){
            throw new Exception("The Email must be between 9 and 145 characters!");
        }
        if (trim($email) == ""){
            throw new Exception("The email can not be empty!");
        }
        if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            throw new Exception("The email is invalid!");
        }
        if (!preg_match("/^[a-z]+[a-z\d_]+@[a-z]{3,20}[.][a-z]{2,7}$/",$email)){
            throw new Exception("The email is invalid!");
        }

        $this->email = $email;
        return $this;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }


}