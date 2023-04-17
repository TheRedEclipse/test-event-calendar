<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentStoreRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use App\Services\DepartmentService;

class DepartmentController extends Controller
{
    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
        $this->middleware('auth.role:admin')->only(['index']);
        $this->middleware('auth.role:admin')->only(['store']);
        $this->middleware('auth.role:admin')->only(['show']);
        $this->middleware('auth.role:admin')->only(['update']);
        $this->middleware('auth.role:admin')->only(['restore']);
        $this->middleware('auth.role:admin')->only(['destroy']);
        $this->middleware('auth.role:admin')->only(['forceDestroy']);
    }

    /**
     * Display a listing of the Department.
     *
     * @return object
     */
    public function index(): object
    {
        return response()->json([
            'success' => true,
            'departments' => $this->departmentService->index()
        ]);
    }

    /**
     * Display a public listing of the Department.
     *
     * @return object
     */
    public function publicIndex(): object
    {
        return response()->json([
            'success' => true,
            'departments' => $this->departmentService->publicIndex()
        ]);
    }

    /**
     * Store a newly created Department in storage.
     *
     * @param  object $request
     * @return object
     */
    public function store(DepartmentStoreRequest $request): object
    {
        return response()->json([
            'success' => true,
            'department' => $this->departmentService->store($request)
        ]);
    }

    /**
     * Display the specified Department.
     *
     * @param  int  $id
     * @return object
     */
    public function show(int $id): object
    {
        return response()->json([
            'success' => true,
            'department' => $this->departmentService->show($id)
        ]);
    }

    /**
     * Update the specified Department in storage.
     *
     * @param  object $request
     * @param  int  $id
     * @return object
     */
    public function update(DepartmentUpdateRequest $request, int $id): object
    {
        return response()->json([
            'success' => true,
            'department' => $this->departmentService->update($request, $id)
        ]);
    }

    /**
     * Restore the specified Department from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(int $id): object
    {
        return response()->json([
            'success' => true,
            'department' => $this->departmentService->restore($id)
        ]);
    }

    /**
     * Soft delete the specified Department from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): object
    {
        return response()->json([
            'success' => true,
            'department' => $this->departmentService->destroy($id)
        ]);
    }

    /**
     * Remove the specified Department from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy(int $id): object
    {
        return response()->json([
            'success' => true,
            'department' => $this->departmentService->forceDestroy($id)
        ]);
    }
}
