<?php
declare(strict_types=1);

namespace Iaejean\Task;

use Iaejean\Conexion\MySQL;

/**
 * Class TaskDao
 * @package Iaejean\Task
 */
class TaskDao
{
    /**
     * @var TaskDao
     */
    private static $instance;
    /**
     * @var MySQL
     */
    private $mysql;
    /**
     * @const string
     */
    const TABLE = 'lista_de_tareas';

    /**
     * TaskDao constructor.
     */
    protected function __construct()
    {
        $this->mysql = MySQL::getInstance();
    }

    /**
     * @return TaskDao
     */
    public static function getInstance(): TaskDao
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }
        return self::$instance = new self;
    }

    /**
     * @param $task
     * @return array
     */
    private function map($task)
    {
        if ($task instanceof Task) {
            return $this->mapTask($task);
        }

        if (is_array($task)) {
            return $this->mapArray($task);
        }
    }

    /**
     * @param Task $task
     * @return array
     */
    private function mapTask(Task $task)
    {
        return $this->filterArray([
            'id_task'          => $task->getId(),
            'v_description'    => $task->getDescription(),
            'd_execution_time' => $task->getExecutionTime(),
            'i_finished'       => $task->isFinished()
        ]);
    }

    /**
     * @param array $task
     * @return array
     */
    private function mapArray(array $task)
    {
        return $this->filterArray([
            'id'            => $task['id_task'],
            'description'   => $task['v_description'],
            'executionTime' => $task['d_execution_time'],
            'finished'      => $task['i_finished']
        ]);
    }

    /**
     * @param array $array
     * @return array
     */
    private function filterArray(array $array = array())
    {
        foreach ($array as $key => $val) {
            if (empty($val)) {
                unset($array[$key]);
            }
        }
        return $array;
    }

    /**
     * @param Task $task
     * @return int
     */
    public function insert(Task $task): int
    {
        return $this->mysql->insert(self::TABLE, $this->map($task));
    }

    /**
     * @param Task $data
     * @param Task $filter
     * @return bool
     */
    public function update(Task $data, Task $filter): bool
    {
        return $this->mysql->update(self::TABLE, $this->map($data), $this->map($filter));
    }

    /**
     * @param Task $task
     * @return array
     */
    public function get(Task $task): array
    {
        $result = $this->mysql->select('*', self::TABLE);
        $list = [];
        foreach ($result as $item) {
            $list[] = $this->map($item);
        }
        return $list;
    }
}
