<?php

namespace Models\task;

class TaskDTO
{
    private int $taskId;
    private string $taskTitle;
    private string $taskDescription;
    private string $dueDate;
    private int $progress;
    private int $completed;
    private $parent_id = null;
    private $goal_id = null;
    private int $user_id = 1;

    public static function create($task_title,$task_description,$due_date,
                                  $user_id): TaskDTO
    {
        return (new TaskDTO())
            ->setTaskTitle($task_title)
            ->setTaskDescription($task_description)
            ->setDueDate($due_date)
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
     * @param int $progress
     */
    public function setProgress(int $progress): void
    {
        $this->progress = $progress;
    }

    /**
     * @param int $completed
     */
    public function setCompleted(int $completed): void
    {
        $this->completed = $completed;
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
     */
    public function setParentId(int $parent_id)
    {
        $this->parent_id = $parent_id;
    }

    /**
     * @param int $goal_id
     */
    public function setGoalId(int $goal_id)
    {
        $this->goal_id = $goal_id;
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
    public function getProgress(): int
    {
        return $this->progress;
    }

    /**
     * @return int
     */
    public function getCompleted(): int
    {
        return $this->completed;
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