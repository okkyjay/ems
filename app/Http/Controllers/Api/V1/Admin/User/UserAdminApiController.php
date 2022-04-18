<?php


namespace App\Http\Controllers\Api\V1\Admin\User;


use App\EMS\User\Repositories\UserRepositoryInterface;
use App\EMS\User\Exceptions\UserException;
use App\EMS\User\Repositories\UserRepository;
use App\EMS\User\Requests\CreateUserRequest;
use App\EMS\User\Requests\UpdateUserRequest;
use App\Http\Controllers\Api\V1\Admin\AdminBaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class UserAdminApiController extends AdminBaseController
{
    private object $userRepo;

    public function __construct(UserRepositoryInterface $userRepo){
        $this->userRepo = $userRepo;
        $this->middleware(function ($request, $next){
            if (Gate::denies('user_access')){
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

            $list = $this->userRepo->listUsers();

            if ($request->has('search') && $request->input('search')){
                $search = $request->input('search');
                $list = $list->where("name", "LIKE", "%".$search."%");
            }

            $data = [
                'user' => $this->userRepo->paginateArrayResults($list->all(), $per_page, $page),
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
            $user = $this->userRepo->findUserById($id);
            if ($user){
                $data = ['user' => $user];
                return $this->success($data);
            }else{
                return $this->notFound('Not Found');
            }
        }catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function store(CreateUserRequest $request)
    {
        try {
            $user = $this->userRepo->createUser($request->except('attachment'));
            $data = ['user' =>  $user = $this->userRepo->findUserById($user->id)];
            return $this->success($data);
        } catch (\Exception $exception){
            logger($exception);
            return $this->failed("Unknown Failure");
        }
    }

    public function update(UpdateUserRequest $request, int $id)
    {
        try {
            $user = $this->userRepo->findUserById($id);
            if ($user){

                $userUpdate = new UserRepository($user);
                try {
                    $userUpdate->updateUser($request->except('attachment'));
                } catch (UserException $e) {
                    logger($e);
                    return $this->failed("Record Updating Failed");
                }
                $data = [
                    'user' => $this->userRepo->findUserById($id)
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
            $user = $this->userRepo->findUserById($id);
            if ($user) {
                $userDelete = new UserRepository($user);
                $userDelete->deleteUser();
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
