<?php
namespace App\Services;

use App\Models\Department;
use App\Models\User;

class DepartmentService
{
    protected $department;

    public function __construct(Department $department)
    {
        $this->department = $department;
    }

    /**
     * Return list of Department model
     *
     * @return object
     */
    public function index(): object
    {
        return $this->department->withTrashed()->paginate(4);
    }

    /**
     * Return public list of Department model
     *
     * @return object
     */
    public function publicIndex(): object
    {
        return $this->department->get();
    }

    /**
     * Store a newly created Department in storage.
     *
     * @param  object $request
     * @return object
     */
    public function store(object $request): object
    {
        return $this->department->create($request->all());
    }

    /**
     * Show the specified Department in storage.
     *
     * @param  int  $id
     * @return object
     */
    public function show(int $id): object
    {
        return $this->department->whereId($id)->withTrashed()->firstOrFail();
    }

    /**
     * Update the specified Department in storage.
     *
     * @param  object $request
     * @param  int  $id
     * @return object
     */
    public function update(object $request, int $id): int
    {
        $department = $this->department->whereId($id)->firstOrFail();

        $department->update($request->all());

        return $id;
    }

    /**
     * Update the specified Department.
     *
     * @param  object $request
     * @param  int  $id
     * @return object
     */
    public function restore(int $id): int
    {
        $department = $this->department->whereId($id)->withTrashed()->firstOrFail();

        $department->restore();

        return $id;
    }

    /**
     * Soft delete the specified Department from storage.
     *
     * @param  int  $id
     * @return int
     */
    public function destroy(int $id): int
    {
        $department = $this->department->whereId($id)->firstOrFail();

        $departmentUsers = User::whereDepartmentId($department->id)->get();

        foreach ($departmentUsers as $user) {
            User::whereId($user->id)->update([
                'department_id' => null
            ]);
        }

        $department->delete();

        return $id;
    }

    /**
     * Remove the specified Department from storage.
     *
     * @param  int  $id
     * @return int
     */
    public function forceDestroy(int $id): int
    {
        $department = $this->department->whereId($id)->withTrashed()->firstOrFail();

        $departmentUsers = User::whereDepartmentId($department->id)->get();

        foreach ($departmentUsers as $user) {
            User::whereId($user->id)->update([
                'department_id' => null
            ]);
        }

        $department->forceDelete();

        return $id;
    }
}