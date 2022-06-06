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

        if (preg_match("/^\/tasks$/", $url) || preg_match("/^\/tasks\/$/", $url)) {

            try {
                $file = "../Config/db.ini";
                $dbInfo = parse_ini_file($file);

                $pdo = new PDO($dbInfo['dsn'],$dbInfo['user'],$dbInfo['pass']);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $db = new PDODatabase($pdo);
                $taskRepository = new TaskRepository($db);
                $result = TaskService::getAllFromGoalId($taskRepository,2);

                $arr = [];
                foreach ($result as $task){
                    $taskInfo = ["title" => $task->getTaskTitle(),
                                "description" => $task->getTaskDescription(),
                                "due_date" => $task->getDueDate(),
                                "goal_id" => $task->getGoalId(),
                        ];
                    array_push($arr,$taskInfo);
                }

                http_response_code(201);
                echo json_encode($arr,JSON_PRETTY_PRINT);

            }catch (Exception $err){
                http_response_code(400);
                $result = ["message" => $err->getMessage()];
                echo json_encode($result);
            }

        }
        else if (preg_match("/^\/tasks\/goal\/\d+$/", $url)) {

            $task_goal_id = str_replace("/tasks/goal/", '', $url);
            if ($task_goal_id == 0){ return; }

            try {
                $taskService = new TaskService();
                $result = $taskService->getAllFromGoalId($task_goal_id);

                if (count($result) > 0){
                    http_response_code(201);
                    echo json_encode($result,JSON_PRETTY_PRINT);
                }else {
                    http_response_code(400);
                    $noData = ["message" => "No Tasks For Goal ID " . $task_goal_id];
                    echo json_encode($noData,JSON_PRETTY_PRINT);
                }

            }catch (Exception $err){
                http_response_code(400);
                $result = ["message" => $err->getMessage()];
                echo json_encode($result);
            }

        }
        else if (preg_match("/^\/tasks\/parent\/\d+$/", $url)) {

            $task_parent_id = str_replace("/tasks/parent/", '', $url);
            if ($task_parent_id == 0){ return; }

            try {
                $taskService = new TaskService();
                $result = $taskService->getAllWithParentTaskId($task_parent_id);

                if (count($result) > 0){
                    http_response_code(201);
                    echo json_encode($result,JSON_PRETTY_PRINT);
                }else {
                    http_response_code(400);
                    $noData = ["message" => "No Tasks With Parent Task ID " . $task_parent_id];
                    echo json_encode($noData,JSON_PRETTY_PRINT);
                }

            }catch (Exception $err){
                http_response_code(400);
                $result = ["message" => $err->getMessage()];
                echo json_encode($result);
            }

        }
        else if (preg_match("/^\/tasks\/create$/", $url)) {

            if ($_SERVER['REQUEST_METHOD'] === 'POST'){

                $message = ["message" => "You want to create a new task! METHOD POST"];

                if (isset($inputData['task_title']) && isset($inputData['task_description'])
                    && isset($inputData['due_date']) && isset($inputData['user_id'])){

                    if (isset($inputData['parent_id']) && $inputData['parent_id'] != 0){

                        $task = $this->createTaskDTO($inputData,'parent');
                        $result = $this->insertTaskDTO($task);
                        $message = [ "message" => $result ];

                    }else if (isset($inputData['goal_id']) && $inputData['goal_id'] != 0){

                        $task = $this->createTaskDTO($inputData,'goal');
                        $result = $this->insertTaskDTO($task);
                        $message = [ "message" => $result ];

                    }else {

                        http_response_code(400);
                        $message =["message" => "An Error occur!"];
                    }

                }

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

    private function insertTaskDTO (TaskDTO $task): string
    {
        try {
            $file = "../Config/db.ini";
            $dbInfo = parse_ini_file($file);

            $pdo = new PDO($dbInfo['dsn'],$dbInfo['user'],$dbInfo['pass']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db = new PDODatabase($pdo);
            $taskRepository = new TaskRepository($db);
            $result = TaskService::create($task,$taskRepository);
            http_response_code(201);

        }catch (Exception $err){
            http_response_code(400);
            $result = $err->getMessage();
        }
        return $result;
    }

    public function createTaskDTO(array $taskInfo, $parentType): TaskDTO
    {
        $task = TaskDTO::create(
            $taskInfo['task_title'],
            $taskInfo['task_description'],
            $taskInfo['due_date'],
            $taskInfo['user_id'],
        );

        if ($parentType == 'goal'){

            $task->setGoalId($taskInfo['goal_id']);

        }else if ($parentType == 'parent') {

            $task->setGoalId($taskInfo['parent_id']);
        }

        return $task;
    }
}