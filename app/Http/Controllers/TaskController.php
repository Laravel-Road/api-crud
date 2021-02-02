<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"/tasks"},
     *     summary="Display a listing of the resource",
     *     description="get all tasks on database and paginate then",
     *     path="/tasks",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="only",
     *          in="query",
     *          description="filter results using field1;field2;field3...",
     *          @OA\Schema(type="string"),
     *          style="form"
     *     ),
     *     @OA\Parameter(
     *          name="search",
     *          in="query",
     *          description="search results using key:value",
     *          @OA\Schema(type="string"),
     *          style="form"
     *     ),
     *     @OA\Parameter(
     *          name="operators",
     *          in="query",
     *          description="set fileds operators using field1:operator1",
     *          @OA\Schema(type="string"),
     *          style="form"
     *     ),
     *     @OA\Parameter(
     *          name="sort",
     *          in="query",
     *          description="order results using field:direction",
     *          @OA\Schema(type="string"),
     *          style="form"
     *     ),
     *     @OA\Parameter(
     *          name="with",
     *          in="query",
     *          description="get relations using relation1;relation2;relation3...",
     *          @OA\Schema(type="string"),
     *          style="form"
     *     ),
     *     @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="define page",
     *          @OA\Schema(type="string"),
     *          style="form"
     *     ),
     *     @OA\Parameter(
     *          name="limit",
     *          in="query",
     *          description="limit per page",
     *          @OA\Schema(type="int"),
     *          style="form"
     *     ),
     *     @OA\Response(
     *         response="200", description="List of tasks"
     *     )
     * )
     *
     * @return TaskCollection
     */
    public function index()
    {
        $limit = request()->has('limit') ? request()->get('limit') : null;
        return new TaskCollection(Task::paginate($limit));
    }

    /**
     * @OA\Post(
     *     tags={"/tasks"},
     *     summary="Store a newly created resource in storage.",
     *     description="store a new task on database",
     *     path="/tasks",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="expired_at", type="string"),
     *             @OA\Property(property="user_id", type="string"),
     *       )
     *     ),
     *     @OA\Response(
     *         response="201", description="New task created"
     *     )
     * )
     *
     * @param  TaskStoreRequest $request
     * @return TaskResource
     */
    public function store(TaskStoreRequest $request)
    {
        return new TaskResource(Task::create($request->validated()));
    }

    /**
     * @OA\Get(
     *     tags={"/tasks"},
     *     summary="Display the specified resource.",
     *     description="show task",
     *     path="/tasks/{task}",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         description="Task id",
     *         in="path",
     *         name="task",
     *         required=true,
     *        @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200", description="Show task"
     *     )
     * )
     *
     * @param  Task $task
     * @return TaskResource
     */
    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    /**
     * @OA\Put(
     *     tags={"/tasks"},
     *     summary="Update the specified resource in storage",
     *     description="update a task on database",
     *     path="/tasks/{task}",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         description="Task id",
     *         in="path",
     *         name="task",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="expired_at", type="string"),
     *             @OA\Property(property="user_id", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response="200", description="Task updated"
     *     )
     * )
     *
     * @param  TaskUpdateRequest $request
     * @param  Task $task
     *
     * @return TaskResource
     */
    public function update(TaskUpdateRequest $request, Task $task)
    {
        $task->update($request->validated());

        return new TaskResource($task);
    }

    /**
     * @OA\Delete(
     *     tags={"/tasks"},
     *     summary="Remove the specified resource from storage.",
     *     description="remove a task on database",
     *     path="/tasks/{task}",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         description="Task id",
     *         in="path",
     *         name="task",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="204", description="Task deleted"
     *     )
     * )
     *
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return response()->json(null, 204);
    }
}
