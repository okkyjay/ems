<?php


namespace App\Http\Controllers\Api\V1\Admin\Complaint;


use App\EMS\Complaint\Repositories\ComplaintRepositoryInterface;
use App\EMS\Complaint\Exceptions\ComplaintException;
use App\EMS\Complaint\Repositories\ComplaintRepository;
use App\EMS\Complaint\Requests\CreateComplaintRequest;
use App\EMS\Complaint\Requests\UpdateComplaintRequest;
use App\Http\Controllers\Api\V1\Admin\AdminBaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class ComplaintAdminApiController extends AdminBaseController
{
    private object $complaintRepo;

    public function __construct(ComplaintRepositoryInterface $complaintRepo){
        $this->complaintRepo = $complaintRepo;
        $this->middleware(function ($request, $next){
            if (Gate::denies('complaint_access')){
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

            $list = $this->complaintRepo->listComplaints();

            if ($request->has('search') && $request->input('search')){
                $search = $request->input('search');
                $list = $list->where("email", "LIKE", "%".$search."%");
            }

            $data = [
                'complaint' => $this->complaintRepo->paginateArrayResults($list->all(), $per_page, $page),
                'page' => $page
            ];
            return $this->success($data);

        }catch (\Exception $exception){
            return $this->failed("Unknown Failure ".$exception->getMessage());
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
            $complaint = $this->complaintRepo->findComplaintById($id);
            if ($complaint){
                $data = ['complaint' => $complaint];
                return $this->success($data);
            }else{
                return $this->notFound('Not Found');
            }
        }catch (\Exception $exception){
            return $this->failed("Unknown Failure");
        }
    }

    public function store(CreateComplaintRequest $request)
    {
        try {
            $request->merge([
                'status' => 1,
                'password' => bcrypt($request->input('password'))
            ]);
            $complaint = $this->complaintRepo->createComplaint($request->all());
            $data = ['complaint' =>  $complaint = $this->complaintRepo->findComplaintById($complaint->id)];
            return $this->success($data);
        } catch (\Exception $exception){
            return $this->failed("Unknown Failure".$exception->getMessage());
        }
    }

    public function update(UpdateComplaintRequest $request, int $id)
    {
        try {
            $complaint = $this->complaintRepo->findComplaintById($id);
            if ($complaint){

                $complaintUpdate = new ComplaintRepository($complaint);
                try {
                    $complaintUpdate->updateComplaint($request->all());
                } catch (ComplaintException $e) {
                    return $this->failed("Record Updating Failed");
                }
                $data = [
                    'complaint' => $this->complaintRepo->findComplaintById($id)
                ];
                return $this->success($data,'Record Updated');
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
            $complaint = $this->complaintRepo->findComplaintById($id);
            if ($complaint) {
                $complaintDelete = new ComplaintRepository($complaint);
                $complaintDelete->deleteComplaint();
                return $this->success([], "Success");
            }else{
                return $this->notFound("Record Not Found");
            }
        }catch (\Exception $exception){
            return $this->failed("Unknown Failure");
        }
    }
}
