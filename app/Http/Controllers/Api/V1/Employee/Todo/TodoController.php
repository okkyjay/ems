<?php


namespace App\Http\Controllers\Api\V1\Employee\Todo;


use App\EMS\Employee\Repositories\EmployeeRepositoryInterface;
use App\EMS\Todo\Exceptions\TodoException;
use App\EMS\Todo\Repositories\TodoRepository;
use App\EMS\Todo\Repositories\TodoRepositoryInterface;
use App\EMS\Todo\Requests\CreateTodoRequest;
use App\EMS\Todo\Requests\UpdateTodoRequest;
use App\Http\Controllers\Api\V1\Employee\EmployeeBaseController;
use Illuminate\Http\Request;

class TodoController extends EmployeeBaseController
{
    private object $todoRepo;
    private object $employeeRepo;

    public function __construct(TodoRepositoryInterface $todoRepository, EmployeeRepositoryInterface $employeeRepository){
        $this->todoRepo = $todoRepository;
        $this->employeeRepo = $employeeRepository;
    }

    public function index(Request $request)
    {
        try {
            $loggedInEmployee = $this->user();

            $page = $request->input('page', 1);
            $query = ['employee_id' => $loggedInEmployee->id];
            $list = $this->todoRepo->listEmployeeTodos($query);

            if ($request->has('search')){
                $search = $request->input('search');
                $list = $list->where("name", "LIKE", "%".$search."%");
            }

            $data = [
                'todos' => $this->todoRepo->paginateArrayResults($list),
                'page' => $page
            ];
            return $this->success($data);

        }catch (\Exception $exception){
            return $this->failed("Unknown Failure");
        }
    }

    public function store(CreateTodoRequest $request)
    {
        try {
            $loggedInEmployee = $this->user();
            if ((int)$loggedInEmployee->id === (int)$request->input('employee_id')){
                $todo = $this->todoRepo->createTodo($request->all());
                $data = ['todo' => $todo];
                return $this->success($data);
            }else{
                return $this->notFound('Forbidden');
            }
        } catch (\Exception $exception){
            return $this->failed("Unknown Failure");
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
            if ($todo && $todo->employee_id == $this->user()->id){
                $data = ['todo' => $todo];
                return $this->success($data);
            }else{
                return $this->notFound('Forbidden');
            }
        }catch (\Exception $exception){
            return $this->failed("Unknown Failure");
        }
    }

    public function update(UpdateTodoRequest $request, int $id)
    {
        try {
            $todo = $this->todoRepo->findTodoById($id);
            if ($todo && $todo->employee_id == $this->user()->id){

                $todoUpdate = new TodoRepository($todo);
                try {
                    $todoUpdate->updateTodo($request->all());
                } catch (TodoException $e) {
                }
                $data = [];
                return $this->success($data);
            }else{
                return $this->notFound('Forbidden');
            }
        }catch (\Exception $exception){
            return $this->failed("Unknown Failure");
        }
    }

    public function destroy(int $id)
    {
        try {
            $todo = $this->todoRepo->findTodoById($id);
            if ($todo && $todo->employee_id == $this->user()->id) {
                $todoDelete = new TodoRepository($todo);
                $todoDelete->deleteTodo();
                return $this->success([]);
            }else{
                return $this->notFound("Forbidden");
            }
        }catch (\Exception $exception){
            return $this->failed("Unknown Failure");
        }
    }
}
