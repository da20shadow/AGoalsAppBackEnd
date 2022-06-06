<?php

namespace Service;

class UserService
{
    private array $users = [
      ["id" => 1, "username" => "Admin"],
      ["id" => 2, "username" => "John"],
      ["id" => 3, "username" => "Peter"],
      ["id" => 4, "username" => "Maria"],
    ];

    function getAll(): array
    {
      return $this->users;
    }

    public function getUserById($user_id){
        foreach ($this->users as $user){
            if ($user['id'] == $user_id){
                return $user;
            }
        }
    }

}