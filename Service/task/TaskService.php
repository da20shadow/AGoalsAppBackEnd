<?php

namespace Service\task;

use Exception;
use Models\task\TaskDTO;
use Repositories\task\TaskRepository;

class TaskService
{
    private TaskRepository $taskRepository;


    public function __construct()
    {
        $this->taskRepository = new TaskRepository();
    }


    public function create($formData): string
    {

        if (isset($formData['parent_id'])){
            $parent = 'parent_id';
            $parentType = 'parent';
        }else if (isset($formData['goal_id'])){
            $parent = 'goal_id';
            $parentType = 'goal';
        }else{
            return "Error! Invalid Parent ID neither goal ID!";
        }

        if (!isset($formData['task_title']) || !isset($formData['task_description'])
            || !isset($formData['due_date']) || !isset($formData['user_id'])){
            return "Error! All fields are required!";
        }

        try {
            $taskDTO = $this->generateTaskDTO($formData,$parentType);
        }catch (Exception $exception){
            return "Error! ". $exception->getMessage();
        }

        return $this->taskRepository->insert($taskDTO,$parent);

    }

    /**
     * @param $parentType //parent_id or goal_id
     * @param $parentId
     */
    public function getAll($parentType,$parentId)
    {
        $resultGenerator = $this->taskRepository->getAll($parentType,$parentId);

        $arr = $this->generateTaskListBy($parentType,$resultGenerator);

        if (count($arr) > 0){
            http_response_code(201);
            echo json_encode($arr,JSON_PRETTY_PRINT);
        }else {
            http_response_code(400);
            $noData = ["message" => "No Tasks For Goal ID " . $parentId];
            echo json_encode($noData,JSON_PRETTY_PRINT);
        }
    }

    private function generateTaskListBy($parentType,$resultGenerator): array
    {
        $parent = 'parent_id';
        $getParentId = 'getParentId';

        if ($parentType == 'goal_id'){
            $parent = 'goal_id';
            $getParentId = 'getGoalId';
        }

        $arr = [];
        foreach ($resultGenerator as $task){
            $taskInfo = [
                "task_id" => $task->getTaskId(),
                "title" => $task->getTaskTitle(),
                "description" => $task->getTaskDescription(),
                "due_date" => $task->getDueDate(),
                $parent => $task->$getParentId(),
            ];
            array_push($arr,$taskInfo);
        }

        return $arr;

    }

    private function generateTaskDTO($formData,$parentType): TaskDTO
    {

        $task = TaskDTO::create(
            $formData['task_title'],
            $formData['task_description'],
            $formData['due_date'],
            $formData['user_id'],
        );

        if ($parentType == 'goal'){

            $task->setGoalId($formData['goal_id']);

        }else if ($parentType == 'parent') {

            $task->setParentId($formData['parent_id']);
        }

        return $task;
    }
}