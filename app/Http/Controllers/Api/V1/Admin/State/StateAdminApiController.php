<?php


namespace App\Http\Controllers\Api\V1\Admin\State;


use App\EMS\State\Repositories\StateRepositoryInterface;
use App\EMS\State\Exceptions\StateException;
use App\EMS\State\Repositories\StateRepository;
use App\EMS\State\Requests\CreateStateRequest;
use App\EMS\State\Requests\UpdateStateRequest;
use App\Http\Controllers\Api\V1\Admin\AdminBaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class StateAdminApiController extends AdminBaseController
{
    private object $stateRepo;

    public function __construct(StateRepositoryInterface $stateRepo){
        $this->stateRepo = $stateRepo;
        $this->middleware(function ($request, $next){
            if (Gate::denies('state_access')){
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

            $list = $this->stateRepo->listStates();

            if ($request->has('search') && $request->input('search')){
                $search = $request->input('search');
                $list = $list->where("name", "LIKE", "%".$search."%");
            }

            $data = [
                'state' => $this->stateRepo->paginateArrayResults($list->all(), $per_page, $page),
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
            $state = $this->stateRepo->findStateById($id);
            if ($state){
                $data = ['state' => $state];
                return $this->success($data);
            }else{
                return $this->notFound('Not Found');
            }
        }catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function store(CreateStateRequest $request)
    {
        try {
            $state = $this->stateRepo->createState($request->except('attachment'));
            $data = ['state' =>  $state = $this->stateRepo->findStateById($state->id)];
            return $this->success($data);
        } catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function update(UpdateStateRequest $request, int $id)
    {
        try {
            $state = $this->stateRepo->findStateById($id);
            if ($state){

                $stateUpdate = new StateRepository($state);
                try {
                    $stateUpdate->updateState($request->except('attachment'));
                } catch (StateException $e) {
                    logger($e);
                    return $this->failed("Record Updating Failed");
                }
                $data = [
                    'state' => $this->stateRepo->findStateById($id)
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
            $state = $this->stateRepo->findStateById($id);
            if ($state) {
                $stateDelete = new StateRepository($state);
                $stateDelete->deleteState();
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
