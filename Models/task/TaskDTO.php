<?php

namespace Models\task;

class TaskDTO
{
    private int $taskId;
    private string $taskTitle;
    private string $taskDescription;
    private string $dueDate;
    private $parent_id;
    private $goal_id;
    private int $user_id = 0;

    public static function create($task_title,$task_description,$due_date,
                                  $user_id, $paren_id = null, $goal_id = null): TaskDTO
    {
        return (new TaskDTO())
            ->setTaskTitle($task_title)
            ->setTaskDescription($task_description)
            ->setDueDate($due_date)
            ->setParentId($paren_id)
            ->setGoalId($goal_id)
            ->setUserId($user_id);
    }

    /**
     * @param int $taskId
     */
    public function setTaskId(int $taskId): void
    {
        $this->taskId = $taskId;
    }

    /**
     * @param string $taskTitle
     * @return TaskDTO
     */
    public function setTaskTitle(string $taskTitle): TaskDTO
    {
        $this->taskTitle = $taskTitle;
        return $this;
    }

    /**
     * @param string $taskDescription
     * @return TaskDTO
     */
    public function setTaskDescription(string $taskDescription): TaskDTO
    {
        $this->taskDescription = $taskDescription;
        return $this;
    }

    /**
     * @param string $dueDate
     * @return TaskDTO
     */
    public function setDueDate(string $dueDate): TaskDTO
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    /**
     * @param int $user_id
     * @return TaskDTO
     */
    public function setUserId(int $user_id): TaskDTO
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @param int $parent_id
     * @return TaskDTO
     */
    public function setParentId(int $parent_id): TaskDTO
    {
        $this->parent_id = $parent_id;
        return $this;
    }

    /**
     * @param int $goal_id
     * @return TaskDTO
     */
    public function setGoalId(int $goal_id): TaskDTO
    {
        $this->goal_id = $goal_id;
        return $this;
    }



    /**
     * @return int
     */
    public function getTaskId(): int
    {
        return $this->taskId;
    }

    /**
     * @return string
     */
    public function getTaskTitle(): string
    {
        return $this->taskTitle;
    }

    /**
     * @return string
     */
    public function getTaskDescription(): string
    {
        return $this->taskDescription;
    }

    /**
     * @return string
     */
    public function getDueDate(): string
    {
        return $this->dueDate;
    }

    /**
     * @return int
     */
    public function getParentId(): int
    {
        return $this->parent_id;
    }

    /**
     * @return int
     */
    public function getGoalId(): int
    {
        return $this->goal_id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }


}