<?php


namespace App\Http\Controllers\Api;


use App\EMS\Country\Country;
use App\EMS\LeaveType\LeaveType;
use App\EMS\State\State;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Illuminate\Http\Request;

class GeneralApiController extends BaseController
{
    use MediaUploadingTrait;

    public function countryList()
    {
        try {
            $countries = Country::with('states')->where('status', 1)->get();
            $data = ['countries' => $countries];
            return $this->success($data);
        }catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function stateList(Request $request)
    {
        try {
            $states = State::with('country')->where('status', 1);

            if ($request->has("country_id") && $request->input('country_id')){
                $states = $states->where("country_id", $request->input("country_id"));
            }
            $data = ['states' => $states->get()];
            return $this->success($data);
        }catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function leaveTypeList()
    {
        try {
            $types = LeaveType::all();
            $data = ['leave_types' => $types];
            return $this->success($data);
        }catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }
}
