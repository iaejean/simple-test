<?php
declare(strict_types=1);

namespace Iaejean\Task;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class Task
 * @package Iaejean\Task
 */
class Task
{
    /**
     * @var integer
     * @Serializer\Type("integer")
     */
    private $id;
    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $executionTime;
    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $description;
    /**
     * @var boolean
     * @Serializer\Type("boolean")
     */
    private $finished;

    /**
     * Task constructor.
     * @param int $id
     * @param string $executionTime
     * @param string $description
     * @param bool $finished
     */
    public function __construct(
        int $id = null,
        string $executionTime = null,
        string $description = null,
        bool $finished = null
    ) {
        $this->id = $id;
        $this->executionTime = $executionTime;
        $this->description = $description;
        $this->finished = $finished;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Task
     */
    public function setId(int $id): Task
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getExecutionTime()
    {
        return $this->executionTime;
    }

    /**
     * @param string $executionTime
     * @return Task
     */
    public function setExecutionTime(string $executionTime): Task
    {
        $this->executionTime = $executionTime;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Task
     */
    public function setDescription(string $description): Task
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isFinished()
    {
        return $this->finished;
    }

    /**
     * @param boolean $finished
     * @return Task
     */
    public function setFinished(bool $finished): Task
    {
        $this->finished = $finished;
        return $this;
    }
}
