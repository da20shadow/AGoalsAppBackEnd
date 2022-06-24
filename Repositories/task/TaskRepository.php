<?php

namespace Repositories\task;

use Database\DBConnector;
use Database\PDODatabase;
use Models\task\TaskDTO;
use PDOException;

class TaskRepository
{

    private PDODatabase $db;

    public function __construct()
    {
        $this->db = DBConnector::create();
    }

    public function insert(TaskDTO $taskDTO,$parent): string
    {
        $getParentId = 'getParentId';
        if ($parent == 'goal_id'){
            $getParentId = 'getGoalID';
        }

        try {
            $this->db->query(
                "INSERT INTO tasks
                    (task_title,task_description,due_date,$parent,user_id)
                        VALUES
                    (:title,:description,:due_date,:$parent,:user_id)"
            )->execute(array(
                ":title" => $taskDTO->getTaskTitle(),
                ":description" => $taskDTO->getTaskDescription(),
                ":due_date" => $taskDTO->getDueDate(),
                $parent => $taskDTO->$getParentId(),
                ":user_id" => $taskDTO->getUserID()
            ));
            return "Successfully Created! TASK TITLE: ". $taskDTO->getTaskTitle();
        }catch (PDOException $exception){
            return "Error! Can't create TASK TITLE: ". $taskDTO->getTaskTitle() . " ". $exception->getMessage();
        }
    }

    public function delete(int $taskId): string
    {
        try {
            $this->db->query(
                "DELETE 
                        FROM tasks
                        WHERE task_id = :task_id"
            )->execute(array(
                ":task_id" => $taskId
            ));
            return "Successfully Deleted!";
        }catch (PDOException $exception){
            return "Error " . $exception->getMessage();
        }
    }

    public function getTaskById($taskId): ?TaskDTO
    {
        try {
            return $this->db->query("
         SELECT task_id AS taskId, 
                     task_title AS taskTitle,
                     task_description AS taskDescription,
                     due_date AS dueDate
                FROM tasks WHERE task_id = :task_id")
                 ->execute(array(
                     ":task_id" => $taskId
                 ))->fetch(TaskDTO::class)
                 ->current();
        }catch (PDOException $exception){
            return null;
        }
    }

    public function getAll($parentType,$parentId): array|\Generator
    {
        $parent = 'parent_id';
        if ($parentType == 'goal_id'){
            $parent = 'goal_id';
        }
        try {
            return $this->db->query(
                "SELECT 
                    task_id AS taskId, 
                    task_title AS taskTitle,
                    task_description AS taskDescription,
                    due_date AS dueDate,
                    progress,
                    completed, 
                    $parent,
                    user_id
                    FROM tasks
                    WHERE $parent = :$parent"
            )->execute(array(
                ":$parent" => $parentId
            ))
                ->fetch(TaskDTO::class);

        }catch (PDOException $exception){
            return ["message" => $exception->getMessage()];
        }
    }

}