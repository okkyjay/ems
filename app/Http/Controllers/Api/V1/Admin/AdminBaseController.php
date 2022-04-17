<?php


namespace App\Http\Controllers\Api\V1\Admin;


use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;

class AdminBaseController extends BaseController
{
    /**
     * logged in employee
     *
     */

    public function user()
    {
        return Auth::guard('admin')->user();
    }
}
