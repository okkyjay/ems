<?php


namespace App\Http\Controllers\Api\V1\Admin\Holiday;


use App\EMS\Holiday\Repositories\HolidayRepositoryInterface;
use App\EMS\Holiday\Exceptions\HolidayException;
use App\EMS\Holiday\Repositories\HolidayRepository;
use App\EMS\Holiday\Requests\CreateHolidayRequest;
use App\EMS\Holiday\Requests\UpdateHolidayRequest;
use App\Http\Controllers\Api\V1\Admin\AdminBaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class HolidayAdminApiController extends AdminBaseController
{
    private object $holidayRepo;

    public function __construct(HolidayRepositoryInterface $holidayRepo){
        $this->holidayRepo = $holidayRepo;
        $this->middleware(function ($request, $next){
            if (Gate::denies('holiday_access')){
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

            $list = $this->holidayRepo->listHolidays();

            if ($request->has('search') && $request->input('search')){
                $search = $request->input('search');
                $list = $list->where("name", "LIKE", "%".$search."%");
            }

            $data = [
                'holiday' => $this->holidayRepo->paginateArrayResults($list->all(), $per_page, $page),
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
            $holiday = $this->holidayRepo->findHolidayById($id);
            if ($holiday){
                $data = ['holiday' => $holiday];
                return $this->success($data);
            }else{
                return $this->notFound('Not Found');
            }
        }catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function store(CreateHolidayRequest $request)
    {
        try {
            $holiday = $this->holidayRepo->createHoliday($request->except('attachment'));
            $data = ['holiday' =>  $holiday = $this->holidayRepo->findHolidayById($holiday->id)];
            return $this->success($data);
        } catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function update(UpdateHolidayRequest $request, int $id)
    {
        try {
            $holiday = $this->holidayRepo->findHolidayById($id);
            if ($holiday){

                $holidayUpdate = new HolidayRepository($holiday);
                try {
                    $holidayUpdate->updateHoliday($request->except('attachment'));
                } catch (HolidayException $e) {
                    logger($e);
                    return $this->failed("Record Updating Failed");
                }
                $data = [
                    'holiday' => $this->holidayRepo->findHolidayById($id)
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
            $holiday = $this->holidayRepo->findHolidayById($id);
            if ($holiday) {
                $holidayDelete = new HolidayRepository($holiday);
                $holidayDelete->deleteHoliday();
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
