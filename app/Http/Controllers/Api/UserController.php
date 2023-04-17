<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserIndexRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('auth.role:admin')->only(['index']);
        $this->middleware('auth.role:admin')->only(['store']);
        $this->middleware('auth.role:admin')->only(['show']);
        $this->middleware('auth.role:admin')->only(['update']);
        $this->middleware('auth.role:admin')->only(['restore']);
        $this->middleware('auth.role:admin')->only(['destroy']);
        $this->middleware('auth.role:admin')->only(['forceDestroy']);
    }

    /**
     * Display a listing of the User.
     *
     * @return object
     */
    public function index(): object
    {
        return response()->json([
            'success' => true,
            'users' => $this->userService->index()
        ]);
    }

    /**
     * Display a public listing of the User.
     *
     * @return object
     */
    public function publicIndex(): object
    {
        return response()->json([
            'success' => true,
            'users' => $this->userService->publicIndex()
        ]);
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  object $request
     * @return object
     */
    public function store(UserStoreRequest $request): object
    {
        return response()->json([
            'success' => true,
            'user' => $this->userService->store($request)
        ]);
    }

    /**
     * Display the specified User.
     *
     * @param  int  $id
     * @return object
     */
    public function show(int $id): object
    {
        return response()->json([
            'success' => true,
            'user' => $this->userService->show($id)
        ]);
    }

    /**
     * Update the specified User in storage.
     *
     * @param  object $request
     * @param  int  $id
     * @return object
     */
    public function update(UserUpdateRequest $request, int $id): object
    {
        return response()->json([
            'success' => true,
            'user' => $this->userService->update($request, $id)
        ]);
    }

    /**
     * Restore the specified User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(int $id): object
    {
        return response()->json([
            'success' => true,
            'user' => $this->userService->restore($id)
        ]);
    }

    /**
     * Soft delete the specified User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): object
    {
        return response()->json([
            'success' => true,
            'user' => $this->userService->destroy($id)
        ]);
    }

    /**
     * Remove the specified User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy(int $id): object
    {
        return response()->json([
            'success' => true,
            'user' => $this->userService->forceDestroy($id)
        ]);
    }
}
