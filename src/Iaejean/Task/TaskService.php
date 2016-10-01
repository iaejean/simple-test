<?php
declare(strict_types=1);

namespace Iaejean\Task;

use Iaejean\Helpers\SerializerHelper;

/**
 * Class TaskService
 * @package Iaejean\Task
 */
class TaskService
{
    /**
     * @var TaskService
     */
    private static $instance;
    /**
     * @var TaskDao
     */
    private $taskDao;

    /**
     * TaskService constructor.
     */
    protected function __construct()
    {
        $this->taskDao = TaskDao::getInstance();
    }

    /**
     * @return TaskService
     */
    public static function getInstance(): TaskService
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }
        return self::$instance = new self;
    }

    /**
     * @param Task $task
     * @return int
     */
    public function insert(Task $task): int
    {
        return $this->taskDao->insert($task);
    }

    /**
     * @param Task $task
     * @param Task $filter
     * @return bool
     */
    public function update(Task $task, Task $filter): bool
    {
        $task->setExecutionTime(date('Y-m-d H:i:s'));
        return $this->taskDao->update($task, $filter);
    }

    /**
     * @param Task|null $task
     * @return array
     */
    public function get(Task $task = null): array
    {
        return $this->taskDao->get($task);
    }
}
