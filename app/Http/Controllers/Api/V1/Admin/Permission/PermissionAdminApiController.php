<?php


namespace App\Http\Controllers\Api\V1\Admin\Permission;


use App\EMS\Permission\Repositories\PermissionRepositoryInterface;
use App\EMS\Permission\Exceptions\PermissionException;
use App\EMS\Permission\Repositories\PermissionRepository;
use App\EMS\Permission\Requests\CreatePermissionRequest;
use App\EMS\Permission\Requests\UpdatePermissionRequest;
use App\Http\Controllers\Api\V1\Admin\AdminBaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class PermissionAdminApiController extends AdminBaseController
{
    private object $permissionRepo;

    public function __construct(PermissionRepositoryInterface $permissionRepo){
        $this->permissionRepo = $permissionRepo;
        $this->middleware(function ($request, $next){
            if (Gate::denies('permission_access')){
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

            $list = $this->permissionRepo->listPermissions();

            if ($request->has('search') && $request->input('search')){
                $search = $request->input('search');
                $list = $list->where("title", "LIKE", "%".$search."%");
            }

            $data = [
                'permission' => $this->permissionRepo->paginateArrayResults($list->all(), $per_page, $page),
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
            $permission = $this->permissionRepo->findPermissionById($id);
            if ($permission){
                $data = ['permission' => $permission];
                return $this->success($data);
            }else{
                return $this->notFound('Not Found');
            }
        }catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function store(CreatePermissionRequest $request)
    {
        try {
            $permission = $this->permissionRepo->createPermission($request->except('attachment'));
            $data = ['permission' =>  $permission = $this->permissionRepo->findPermissionById($permission->id)];
            return $this->success($data);
        } catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function update(UpdatePermissionRequest $request, int $id)
    {
        try {
            $permission = $this->permissionRepo->findPermissionById($id);
            if ($permission){

                $permissionUpdate = new PermissionRepository($permission);
                try {
                    $permissionUpdate->updatePermission($request->except('attachment'));
                } catch (PermissionException $e) {
                    logger($e);
                    return $this->failed("Record Updating Failed");
                }
                $data = [
                    'permission' => $this->permissionRepo->findPermissionById($id)
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
            $permission = $this->permissionRepo->findPermissionById($id);
            if ($permission) {
                $permissionDelete = new PermissionRepository($permission);
                $permissionDelete->deletePermission();
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
