<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserService\UserServiceInterface;

class UserController extends Controller
{

    private $users;

    private $userService;

    public function __construct(User $userModel, UserServiceInterface $userService)
    {
        $this->users = $userModel;
        $this->userService = $userService;
    }

    public function login(Request $request)
    {
        $input = $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $token = $this->userService->logIn($input);

        if (empty($token)) {
            return response()->json([
                'status' => 'fail'
            ], 401);
        } else {
            return response()->json([
                'status' => 'ok',
                'api_token' => $token
            ]);
        }
    }

    public function index(Request $request)
    {
        $event = $request->input('event', '');
        $users = $this->userService->getUserListByEvent($event);

        return response()->json([
            'status' => 'ok',
            'data' => $users
        ]);
    }

    public function show($id)
    {
        $user = $this->users->findOrFail($id);

        return response()->json([
            'status' => 'ok',
            'data' => $user
        ]);
    }

    public function store(Request $request)
    {
        $input = $this->validate($request,
            [
                'name' => 'required',
                'email' => 'email|unique:users,email',
                'password' => 'required',
                'event_id' => 'required'
            ]);

        $user = $this->userService->newUser($input);

        return response()->json([
            'status' => 'ok',
            'data' => $user
        ]);
    }

    public function update($id, Request $request)
    {
        $input = $this->validate($request,
            [
                'name' => 'required',
                'email' => 'email|unique:users,email,' . $id . ',id',
                'password' => 'required',
                'event_id' => 'required'
            ]);

        $user = $this->users->find($id);
        $user->update($input);

        return response()->json([
            'status' => 'ok'
        ]);
    }

    public function destroy($id)
    {
        $this->users->findOrFail($id)->delete();

        return response()->json([
            'status' => 'ok'
        ]);
    }
}
