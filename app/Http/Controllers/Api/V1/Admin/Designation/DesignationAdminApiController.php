<?php


namespace App\Http\Controllers\Api\V1\Admin\Designation;


use App\EMS\Designation\Repositories\DesignationRepositoryInterface;
use App\EMS\Designation\Exceptions\DesignationException;
use App\EMS\Designation\Repositories\DesignationRepository;
use App\EMS\Designation\Requests\CreateDesignationRequest;
use App\EMS\Designation\Requests\UpdateDesignationRequest;
use App\Http\Controllers\Api\V1\Admin\AdminBaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class DesignationAdminApiController extends AdminBaseController
{
    private object $designationRepo;

    public function __construct(DesignationRepositoryInterface $designationRepo){
        $this->designationRepo = $designationRepo;
        $this->middleware(function ($request, $next){
            if (Gate::denies('designation_access')){
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

            $list = $this->designationRepo->listDesignations();

            if ($request->has('search') && $request->input('search')){
                $search = $request->input('search');
                $list = $list->where("email", "LIKE", "%".$search."%");
            }

            $data = [
                'designation' => $this->designationRepo->paginateArrayResults($list->all(), $per_page, $page),
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
            $designation = $this->designationRepo->findDesignationById($id);
            if ($designation){
                $data = ['designation' => $designation];
                return $this->success($data);
            }else{
                return $this->notFound('Not Found');
            }
        }catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function store(CreateDesignationRequest $request)
    {
        try {
            $designation = $this->designationRepo->createDesignation($request->except('attachment'));
            $data = ['designation' =>  $designation = $this->designationRepo->findDesignationById($designation->id)];
            return $this->success($data);
        } catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function update(UpdateDesignationRequest $request, int $id)
    {
        try {
            $designation = $this->designationRepo->findDesignationById($id);
            if ($designation){

                $designationUpdate = new DesignationRepository($designation);
                try {
                    $designationUpdate->updateDesignation($request->except('attachment'));
                } catch (DesignationException $e) {
                    logger($e);
                    return $this->failed("Record Updating Failed");
                }
                $data = [
                    'designation' => $this->designationRepo->findDesignationById($id)
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
            $designation = $this->designationRepo->findDesignationById($id);
            if ($designation) {
                $designationDelete = new DesignationRepository($designation);
                $designationDelete->deleteDesignation();
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
