<?php

namespace Service\task;

use Models\task\TaskDTO;
use Repositories\task\TaskRepository;

class TaskService
{
    private TaskRepository $taskRepository;


    public function __construct()
    {
        $this->taskRepository = new TaskRepository();
    }


    public function create(TaskDTO $taskDTO): string
    {

        return $this->taskRepository->insert($taskDTO);

    }

    public function getAllFromGoalId($goalId) : array
    {
        $resultGenerator = $this->taskRepository->getAllFromGoalId($goalId);

        $arr = [];
        foreach ($resultGenerator as $task){
            $taskInfo = ["title" => $task->getTaskTitle(),
                "description" => $task->getTaskDescription(),
                "due_date" => $task->getDueDate(),
                "goal_id" => $task->getGoalId(),
            ];
            array_push($arr,$taskInfo);
        }
        return $arr;

    }

    public function getAllWithParentTaskId($parentId) : array
    {
        $resultGenerator = $this->taskRepository->getAllWithParentTaskId($parentId);

        $arr = [];
        foreach ($resultGenerator as $task){
            $taskInfo = ["title" => $task->getTaskTitle(),
                "description" => $task->getTaskDescription(),
                "due_date" => $task->getDueDate(),
                "parent_id" => $task->getParentId(),
            ];
            array_push($arr,$taskInfo);
        }
        return $arr;

    }


}