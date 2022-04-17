<?php


namespace App\Http\Controllers\Api\V1\Employee\Complaint;


use App\EMS\Complaint\Exceptions\ComplaintException;
use App\EMS\Complaint\Repositories\ComplaintRepository;
use App\EMS\Complaint\Repositories\ComplaintRepositoryInterface;
use App\EMS\Complaint\Requests\CreateComplaintRequest;
use App\EMS\Complaint\Requests\UpdateComplaintRequest;
use App\Http\Controllers\Api\V1\Employee\EmployeeBaseController;
use Illuminate\Http\Request;

class ComplaintController extends EmployeeBaseController
{
    private object $complaintRepo;

    public function __construct(ComplaintRepositoryInterface $complaintRepository){
        $this->complaintRepo = $complaintRepository;
    }

    public function index(Request $request)
    {
        try {
            $loggedInEmployee = $this->user();

            $page = $request->input('page', 1);
            $query = ['employee_id' => $loggedInEmployee->id];
            $list = $this->complaintRepo->listEmployeeComplaints($query);

            if ($request->has('search')){
                $search = $request->input('search');
                $list = $list->where("name", "LIKE", "%".$search."%");
            }

            $data = [
                'complaints' => $this->complaintRepo->paginateArrayResults($list),
                'page' => $page
            ];
            return $this->success($data);

        }catch (\Exception $exception){
            return $this->failed("Unknown Failure");
        }
    }

    public function store(CreateComplaintRequest $request)
    {
        try {
            $loggedInEmployee = $this->user();
            if ((int)$loggedInEmployee->id === (int)$request->input('employee_id')){
                $complaint = $this->complaintRepo->createComplaint($request->all());
                $data = ['complaint' => $complaint];
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
            $complaint = $this->complaintRepo->findComplaintById($id);
            if ($complaint && $complaint->employee_id == $this->user()->id){
                $data = ['complaint' => $complaint];
                return $this->success($data);
            }else{
                return $this->notFound('Forbidden');
            }
        }catch (\Exception $exception){
            return $this->failed("Unknown Failure");
        }
    }

    public function update(UpdateComplaintRequest $request, int $id)
    {
        try {
            $complaint = $this->complaintRepo->findComplaintById($id);
            if ($complaint && $complaint->employee_id == $this->user()->id){

                $complaintUpdate = new ComplaintRepository($complaint);
                try {
                    $complaintUpdate->updateComplaint($request->all());
                } catch (ComplaintException $e) {
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
            $complaint = $this->complaintRepo->findComplaintById($id);
            if ($complaint && $complaint->employee_id == $this->user()->id) {
                $complaintDelete = new ComplaintRepository($complaint);
                $complaintDelete->deleteComplaint();
            }else{
                return $this->notFound("Forbidden");
            }
        }catch (\Exception $exception){
            return $this->failed("Unknown Failure");
        }
    }
}
