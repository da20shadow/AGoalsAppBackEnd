<?php
spl_autoload_register(function ($className){
    include_once "../". str_replace("\\","/",$className). ".php";
});

use Database\DBConnector;
use Database\PDODatabase as PDODatabase;
use Models\task\TaskDTO as TaskDTO;
use Repositories\task\TaskRepository as TaskRepository;
use Service\task\TaskService as TaskService;

class TasksHandler
{

    public function processRequest($url,$inputData)
    {
        $url = trim($url);
        $taskService = null;

        try {
            $taskService = new TaskService();
        }catch (Exception $err){
            http_response_code(400);
            $result = ["message" => $err->getMessage()];
            echo json_encode($result);
        }

        if ($taskService == null){
            $result = ["message" => "An Error Occur!"];
            echo json_encode($result);
            return;
        }

        if (preg_match("/^\/tasks$/", $url) || preg_match("/^\/tasks\/$/", $url)) {

            $message = ["message" => "You want list with all tasks in the site!"];
            http_response_code(201);
            echo json_encode($message,JSON_PRETTY_PRINT);

        }
        else if (preg_match("/^\/tasks\/goal\/\d+$/", $url)) {
            //returns all tasks with goal_id

            $task_goal_id = str_replace("/tasks/goal/", '', $url);
            if ($task_goal_id == 0){ return; }
            $taskService->getAll('goal_id',$task_goal_id);

        }
        else if (preg_match("/^\/tasks\/parent\/\d+$/", $url)) {
            //returns all tasks with parent_id

            $task_parent_id = str_replace("/tasks/parent/", '', $url);
            if ($task_parent_id == 0){ return; }
            $taskService->getAll('parent_id',$task_parent_id);

        }
        else if (preg_match("/^\/tasks\/create$/", $url)) {
            //Creates a new task
            if ($_SERVER['REQUEST_METHOD'] === 'POST'){

                $result = $taskService->create($inputData);

                if (str_contains($result,'Error')){
                    http_response_code(400);
                }else {
                    http_response_code(201);
                }
                $message = ["message" => $result];

            } else {
                http_response_code(400);
                $message = ["message" => "An Error occur!"];
            }

            echo json_encode($message);

        }
        else if (preg_match("/^\/tasks\/delete\/\d+$/", $url)) {
            //Creates a new task
            if ($_SERVER['REQUEST_METHOD'] === 'DELETE'){
                $taskId = str_replace("/tasks/delete/", '', $url);
                $result = $taskService->delete($taskId);

                if (str_contains($result,'Error')){
                    http_response_code(400);
                }else {
                    http_response_code(201);
                }
                $message = ["message" => $result];

            } else {
                http_response_code(400);
                $message = ["message" => "An Error occur!"];
            }

            echo json_encode($message);

        } else {

            http_response_code(401);
            $error = ["message" => "Invalid Request!"];
            echo json_encode($error);

        }
    }


}