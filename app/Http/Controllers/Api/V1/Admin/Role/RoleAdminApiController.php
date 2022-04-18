<?php


namespace App\Http\Controllers\Api\V1\Admin\Role;


use App\EMS\Role\Repositories\RoleRepositoryInterface;
use App\EMS\Role\Exceptions\RoleException;
use App\EMS\Role\Repositories\RoleRepository;
use App\EMS\Role\Requests\CreateRoleRequest;
use App\EMS\Role\Requests\UpdateRoleRequest;
use App\Http\Controllers\Api\V1\Admin\AdminBaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class RoleAdminApiController extends AdminBaseController
{
    private object $roleRepo;

    public function __construct(RoleRepositoryInterface $roleRepo){
        $this->roleRepo = $roleRepo;
        $this->middleware(function ($request, $next){
            if (Gate::denies('role_access')){
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

            $list = $this->roleRepo->listRoles();

            if ($request->has('search') && $request->input('search')){
                $search = $request->input('search');
                $list = $list->where("title", "LIKE", "%".$search."%");
            }

            $data = [
                'role' => $this->roleRepo->paginateArrayResults($list->all(), $per_page, $page),
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
            $role = $this->roleRepo->findRoleById($id);
            if ($role){
                $data = ['role' => $role];
                return $this->success($data);
            }else{
                return $this->notFound('Not Found');
            }
        }catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function store(CreateRoleRequest $request)
    {
        try {
            $role = $this->roleRepo->createRole($request->except('attachment'));
            $data = ['role' =>  $role = $this->roleRepo->findRoleById($role->id)];
            return $this->success($data);
        } catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function update(UpdateRoleRequest $request, int $id)
    {
        try {
            $role = $this->roleRepo->findRoleById($id);
            if ($role){

                $roleUpdate = new RoleRepository($role);
                try {
                    $roleUpdate->updateRole($request->except('attachment'));
                } catch (RoleException $e) {
                    logger($e);
                    return $this->failed("Record Updating Failed");
                }
                $data = [
                    'role' => $this->roleRepo->findRoleById($id)
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
            $role = $this->roleRepo->findRoleById($id);
            if ($role) {
                $roleDelete = new RoleRepository($role);
                $roleDelete->deleteRole();
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
