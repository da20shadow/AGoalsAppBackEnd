<?php
require_once ("ApiHandler.php");
$url = str_replace('AGoalsAppBackEnd/',
    '',$_SERVER['REQUEST_URI']);
echo $url;
echo "<br>";
$inputData = json_decode(file_get_contents('php://input'), true);

if (preg_match("/^\/users\/$/",$url)){

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $inputData){

        ApiHandler::processUserRequest($inputData);

    }else if ($_SERVER['REQUEST_METHOD'] === 'GET' && $inputData){
        //TODO: when get to do something for example return last 10 registered or top users etc
        echo "You want to get user public info!";
        var_dump($inputData);
    }
    else if ($_SERVER['REQUEST_METHOD'] === 'PATCH' && $inputData){
        //TODO implement the update Account feature
        echo "You want to update the user info!";
        var_dump($inputData);
        ApiHandler::updateUser($inputData);
    }
}
else if(preg_match("/^\/users\/\d+$/",$url)){
    $user_id = str_replace('/users/','',$url);

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && $inputData){
    //TODO: display the user profile if is public info about the user no need input data
        var_dump($inputData);
        echo "Info about the user ID: $user_id";
    }

}
else if(preg_match("/^\/goals\/$/",$url)){

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && $inputData){
    //TODO: 100% need token to verify that this is the user's goals list
        var_dump($inputData);
        echo "All Goals?";
    }

}
else if(preg_match("/^\/goals\/\d+$/",$url)){

    $goal_id = str_replace('/goals/','',$url);
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && $inputData){

        echo "Info about the Goal ID: $goal_id";
        var_dump($inputData);
    }
}
else {
    echo "<h1 style='color:red;text-align: center; font-size: 55px;'>Error 404!</h1>";
    echo "<h1 style='color:red;text-align: center; font-size:55px;'>Page Not Found!</h1>";
}