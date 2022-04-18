<?php


namespace App\Http\Controllers\Api\V1\Admin\Country;


use App\EMS\Country\Repositories\CountryRepositoryInterface;
use App\EMS\Country\Exceptions\CountryException;
use App\EMS\Country\Repositories\CountryRepository;
use App\EMS\Country\Requests\CreateCountryRequest;
use App\EMS\Country\Requests\UpdateCountryRequest;
use App\Http\Controllers\Api\V1\Admin\AdminBaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class CountryAdminApiController extends AdminBaseController
{
    private object $countryRepo;

    public function __construct(CountryRepositoryInterface $countryRepo){
        $this->countryRepo = $countryRepo;
        $this->middleware(function ($request, $next){
            if (Gate::denies('country_access')){
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

            $list = $this->countryRepo->listCountries();

            if ($request->has('search') && $request->input('search')){
                $search = $request->input('search');
                $list = $list->where("email", "LIKE", "%".$search."%");
            }

            $data = [
                'country' => $this->countryRepo->paginateArrayResults($list->all(), $per_page, $page),
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
            $country = $this->countryRepo->findCountryById($id);
            if ($country){
                $data = ['country' => $country];
                return $this->success($data);
            }else{
                return $this->notFound('Not Found');
            }
        }catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function store(CreateCountryRequest $request)
    {
        try {
            $country = $this->countryRepo->createCountry($request->except('attachment'));
            $data = ['country' =>  $country = $this->countryRepo->findCountryById($country->id)];
            return $this->success($data);
        } catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function update(UpdateCountryRequest $request, int $id)
    {
        try {
            $country = $this->countryRepo->findCountryById($id);
            if ($country){

                $countryUpdate = new CountryRepository($country);
                try {
                    $countryUpdate->updateCountry($request->except('attachment'));
                } catch (CountryException $e) {
                    logger($e);
                    return $this->failed("Record Updating Failed");
                }
                $data = [
                    'country' => $this->countryRepo->findCountryById($id)
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
            $country = $this->countryRepo->findCountryById($id);
            if ($country) {
                $countryDelete = new CountryRepository($country);
                $countryDelete->deleteCountry();
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
