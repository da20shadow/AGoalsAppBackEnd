<?php

namespace Service\user;

require_once ($_SERVER['DOCUMENT_ROOT']. '/AGoalsAppBackEnd/vendor/autoload.php');
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Models\user\UserDTO;

class Auth
{
    private static string $key = 'sdklfjdkfghjdfkgjfhjkg';

    public static function auth(UserDTO $userDTO){
        $iat = time();
        $exp = $iat + 60 * 60;
        $payload = array(
            'iss' => 'http://localhost:8090/AGoalsAppBackEnd/', //Api.domain.com - issuer
            'aud' => 'http://localhost:8090/AGoalsAppBackEnd/', //domain.com - audience
            'iat' => $iat, //time JWT created
            'exp' => $exp, //expiration JWT time
            'user_id' => $userDTO->getUserId(),
            'username' => $userDTO->getUsername(),
            'email' => $userDTO->getEmail(),
        );

        $jwt = JWT::encode($payload,self::$key,'HS256');

        http_response_code(200);
        echo json_encode(array(
            'token' => $jwt,
            'expires' => $exp
        ),JSON_PRETTY_PRINT);

    }

    public static function decodeToken($token){
        try {

            $token = JWT::decode($token, new Key(self::$key,'HS256'));
            echo json_encode($token,JSON_PRETTY_PRINT);

        }catch (\Exception $exception){
            echo json_encode($exception->getMessage(),JSON_PRETTY_PRINT);
        }
    }
}