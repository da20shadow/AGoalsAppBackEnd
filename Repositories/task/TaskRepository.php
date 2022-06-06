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

    public function insert(TaskDTO $taskDTO): string
    {
        try {
            $this->db->query(
                "INSERT INTO tasks
                    (task_title,task_description,due_date,parent_id,goal_id,user_id)
                        VALUES
                    (:title,:description,:due_date,:parent_id,:goal_id,:user_id)"
            )->execute(array(
                ":title" => $taskDTO->getTaskTitle(),
                ":description" => $taskDTO->getTaskDescription(),
                ":due_date" => $taskDTO->getDueDate(),
                ":parent_id" => $taskDTO->getParentId() == 0 ? NULL : $taskDTO->getParentId(),
                ":goal_id" => $taskDTO->getGoalID() == 0 ? NULL : $taskDTO->getGoalID(),
                ":user_id" => $taskDTO->getUserID()
            ));
            return "Successfully Created! TASK TITLE: ". $taskDTO->getTaskTitle();
        }catch (PDOException $exception){
            return "Error! Can't create TASK TITLE: ". $taskDTO->getTaskTitle() . " ". $exception->getMessage();
        }
    }

    public function getAllFromGoalId($goalId): array|\Generator
    {
        try {
            return $this->db->query(
                "SELECT task_id AS taskID, 
                    task_title AS taskTitle,
                    task_description AS taskDescription,
                    due_date AS dueDate,
                    progress,
                    completed, 
                    goal_id,
                    user_id
                    FROM tasks
                    WHERE goal_id = :goal_id"
            )->execute(array(
                ":goal_id" => $goalId
            ))
                ->fetch(TaskDTO::class);

        }catch (PDOException $exception){
            return ["message" => $exception->getMessage()];
        }
    }

    public function getAllWithParentTaskId($parentTaskId): array|\Generator
    {
        try {
            return $this->db->query(
                "SELECT task_id AS taskID, 
                    task_title AS taskTitle,
                    task_description AS taskDescription,
                    due_date AS dueDate,
                    progress,
                    completed, 
                    parent_id,
                    user_id
                    FROM tasks
                    WHERE parent_id = :parent_id"
            )->execute(array(
                ":parent_id" => $parentTaskId
            ))
                ->fetch(TaskDTO::class);

        }catch (PDOException $exception){
            return ["message" => $exception->getMessage()];
        }
    }
}