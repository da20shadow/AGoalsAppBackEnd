<?php

namespace Service\user;

use Exception;
use Models\user\UserDTO;
use Repositories\user\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register($formData)
    {
        $result = $this->generateUserDTO($formData);

        if (!$result instanceof UserDTO) {
            http_response_code(403);
            $error = ["message" => $result];
            echo json_encode($error, JSON_PRETTY_PRINT);
            return;
        }

        if ($this->findUserByUsername($result->getUsername())) {
            http_response_code(403);
            $error = ["message" => "Username (" . $result->getUsername() . ") already registered!"];
            echo json_encode($error, JSON_PRETTY_PRINT);
            return;
        }

        if ($this->findUserByEmail($result->getEmail())) {
            http_response_code(403);
            $error = ["message" => "Email (" . $result->getEmail() . ") already registered!"];
            echo json_encode($error, JSON_PRETTY_PRINT);
            return;
        }

        $message = $this->userRepository->insert($result);

        if (!$message) {
            http_response_code(403);
            $error = ["message" => "An Error Occur! Please, try again or contact us!"];
            echo json_encode($error, JSON_PRETTY_PRINT);
            return;
        }

        http_response_code(201);
        $success = ["message" => $message];
        echo json_encode($success, JSON_PRETTY_PRINT);


    }

    public function login($formData)
    {
        //TODO to create a special method that finds user by username and password
        $user = $this->findUserByUsername($formData['username']);

        if (null === $user ||
            false === password_verify($formData['password'],$user->getPassword())){

            http_response_code(401);
            $error = ["message" => "Wrong Username or Password!"];
            echo json_encode($error, JSON_PRETTY_PRINT);
            return;
        }
        Auth::auth($user);
    }

    function findUserByUsername($username): ?UserDTO
    {
        $result = $this->userRepository->getUserByUsername($username);
        if ($result instanceof UserDTO) {
            return $result;
        }
        return null;
    }

    function findUserByEmail($email): ?UserDTO
    {
        $result = $this->userRepository->getUserByEmail($email);
        if ($result instanceof UserDTO) {
            return $result;
        }
        return null;
    }

    private function generateUserDTO($formData): UserDTO|string
    {
        if (isset($formData['username']) && isset($formData['email'])
            && isset($formData['password']) && isset($formData['re_password'])) {

            $username = $formData['username'];
            $email = $formData['email'];
            $password = $formData['password'];
            $re_password = $formData['re_password'];

            try {
                return UserDTO::create($username, $email, $password, $re_password);
            } catch (Exception $exception) {
                return $exception->getMessage();
            }

        }
        return "All fields must be filed!";
    }
}