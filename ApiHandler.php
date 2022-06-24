<?php

use Database\DBConnector;

spl_autoload_register();
class ApiHandler
{
    public static function processUserRequest($formData){
        $db = DBConnector::create();
        $userRepository = new \Repositories\user\UserRepository($db);
        $userService = new \Service\user\UserService($userRepository);

        if (count($formData) == 2){
            //Login: Username and password
            $userService->login($formData);

        }else {
            //Registration: username email password
            $userService->register($formData);
        }

    }

    public static function updateUser($formData){
        //TODO implement update user feature
        echo "User Updated!";
    }

    public static function processGoalRequest($formData){

    }

    public static function processTaskRequest($formData){

    }

}