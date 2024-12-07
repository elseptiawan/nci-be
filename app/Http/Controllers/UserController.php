<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\ApiResponseHelper;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return ApiResponseHelper::success($users, 'Users retrieved successfully');
    }
}
