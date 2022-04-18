<?php


namespace App\Http\Controllers\Api\V1\Admin\Todo;


use App\EMS\Todo\Repositories\TodoRepositoryInterface;
use App\EMS\Todo\Exceptions\TodoException;
use App\EMS\Todo\Repositories\TodoRepository;
use App\EMS\Todo\Requests\CreateTodoRequest;
use App\EMS\Todo\Requests\UpdateTodoRequest;
use App\Http\Controllers\Api\V1\Admin\AdminBaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class TodoAdminApiController extends AdminBaseController
{
    private object $todoRepo;

    public function __construct(TodoRepositoryInterface $todoRepo){
        $this->todoRepo = $todoRepo;
        $this->middleware(function ($request, $next){
            if (Gate::denies('todo_access')){
                return $this->forbidden();
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        try {
            $page = $request->input('page', 1);
            $per_page = $request->input('per_page', 20);

            $list = $this->todoRepo->listTodos();

            if ($request->has('search') && $request->input('search')){
                $search = $request->input('search');
                $list = $list->where("name", "LIKE", "%".$search."%");
            }

            $data = [
                'todo' => $this->todoRepo->paginateArrayResults($list->all(), $per_page, $page),
                'page' => $page
            ];
            return $this->success($data);

        }catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure ");
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */

    public function show(int $id)
    {
        try {
            $todo = $this->todoRepo->findTodoById($id);
            if ($todo){
                $data = ['todo' => $todo];
                return $this->success($data);
            }else{
                return $this->notFound('Not Found');
            }
        }catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function store(CreateTodoRequest $request)
    {
        try {
            $todo = $this->todoRepo->createTodo($request->except('attachment'));
            $data = ['todo' =>  $todo = $this->todoRepo->findTodoById($todo->id)];
            return $this->success($data);
        } catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function update(UpdateTodoRequest $request, int $id)
    {
        try {
            $todo = $this->todoRepo->findTodoById($id);
            if ($todo){

                $todoUpdate = new TodoRepository($todo);
                try {
                    $todoUpdate->updateTodo($request->except('attachment'));
                } catch (TodoException $e) {
                    logger($e);
                    return $this->failed("Record Updating Failed");
                }
                $data = [
                    'todo' => $this->todoRepo->findTodoById($id)
                ];
                return $this->success($data,'Record Updated');
            }else{
                return $this->notFound('Forbidden');
            }
        }catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function destroy(int $id)
    {
        try {
            $todo = $this->todoRepo->findTodoById($id);
            if ($todo) {
                $todoDelete = new TodoRepository($todo);
                $todoDelete->deleteTodo();
                return $this->success([], "Success");
            }else{
                return $this->notFound("Record Not Found");
            }
        }catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }
}
