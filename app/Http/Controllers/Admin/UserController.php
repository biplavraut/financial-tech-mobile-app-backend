<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends CommonController
{
    //
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index()
    {
        //return $this->userService->getForIndex($this->paginationLimit);
        return UserResource::collection($this->userService->getForIndex($this->paginationLimit));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateBlocked(Request $request)
    {
        //
        //dd($request->verified);
        $data  = $this->userService->update($request->id, ["blocked" => $request->blocked]);
        return new UserResource($data);
    }
}
