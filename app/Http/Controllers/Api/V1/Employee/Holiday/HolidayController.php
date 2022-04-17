<?php


namespace App\Http\Controllers\Api\V1\Employee\Holiday;


use App\EMS\Holiday\Exceptions\HolidayException;
use App\EMS\Holiday\Repositories\HolidayRepository;
use App\EMS\Holiday\Repositories\HolidayRepositoryInterface;
use App\EMS\Holiday\Requests\CreateHolidayRequest;
use App\EMS\Holiday\Requests\UpdateHolidayRequest;
use App\Http\Controllers\Api\V1\Employee\EmployeeBaseController;
use Illuminate\Http\Request;

class HolidayController extends EmployeeBaseController
{
    private object $holidayRepo;

    public function __construct(HolidayRepositoryInterface $holidayRepository){
        $this->holidayRepo = $holidayRepository;
    }

    public function index(Request $request)
    {
        try {
            $loggedInEmployee = $this->user();

            $page = $request->input('page', 1);
            $query = ['employee_id' => $loggedInEmployee->id];
            $list = $this->holidayRepo->listHolidays();

            if ($request->has('search')){
                $search = $request->input('search');
                $list = $list->where("name", "LIKE", "%".$search."%");
            }

            $data = [
                'holidays' => $this->holidayRepo->paginateArrayResults($list),
                'page' => $page
            ];
            return $this->success($data);

        }catch (\Exception $exception){
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
            $holiday = $this->holidayRepo->findHolidayById($id);
                $data = ['holiday' => $holiday];
                return $this->success($data);
        }catch (\Exception $exception){
            return $this->failed("Unknown Failure");
        }
    }

}
