<?php
declare(strict_types=1);

namespace Iaejean\Task;

use Iaejean\Helpers\SerializerHelper;
use Tonic\Application;
use Tonic\Request;
use Tonic\Resource;
use Tonic\Response;

/**
 * Class TaskController
 * @package Iaejean\Task
 *
 * @uri /v1/task
 * @uri /v1/task/:id
 */
class TaskController extends Resource
{
    /**
     * @var TaskService
     */
    private $taskService;

    /**
     * TaskController constructor.
     * @param Application $app
     * @param Request $request
     */
    public function __construct(Application $app, Request $request)
    {
        parent::__construct($app, $request);
        $this->taskService = TaskService::getInstance();
    }

    /**
     * @method GET
     * @return Response
     */
    public function listAction(): Response
    {
        $listTasks = $this->taskService->get(new Task());
        return new Response(Response::OK, SerializerHelper::toJSON($listTasks));
    }

    /**
     * @method PUT
     * @param null $id
     * @return Response
     */
    public function updateAction($id = null)
    {
        /** @var Task $task */
        $task = SerializerHelper::parseJSON($this->request->getData(), 'Iaejean\Task\Task');
        $this->taskService->update($task, new Task((int)$id));
        return new Response(Response::ACCEPTED, SerializerHelper::toJSON($task));
    }

    /**
     * @method POST
     * @return Response
     */
    public function insertAction(): Response
    {
        /** @var Task $task */
        $task = SerializerHelper::parseJSON($this->request->getData(), 'Iaejean\Task\Task');
        $this->taskService->insert($task);
        return new Response(Response::CREATED, SerializerHelper::toJSON($task));
    }
}
