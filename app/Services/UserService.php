<?php
namespace App\Services;

use App\Models\ModelHasCalendarEvent;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Return list of User model
     *
     * @return object
     */
    public function index(): object
    {
        return $this->user->withTrashed()->paginate(4);
    }

    /**
     * Return public list of User model
     *
     * @return object
     */
    public function publicIndex(): object
    {
        return $this->user->get();
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  object $request
     * @return object
     */
    public function store(object $request): object
    {
        return $this->user->create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'user_role_id' => $request->user_role_id,
            'department_id' => $request->department['id'] ?? null
        ]);
    }

    /**
     * Show the specified User in storage.
     *
     * @param  int  $id
     * @return object
     */
    public function show(int $id): object
    {
        return $this->user->whereId($id)->with('department')->withTrashed()->firstOrFail();
    }

    /**
     * Update the specified User in storage.
     *
     * @param  object $request
     * @param  int  $id
     * @return object
     */
    public function update(object $request, int $id): int
    {
        $user = $this->user->whereId($id)->firstOrFail();

        $user->update([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'department_id' => $request->department['id'] ?? null
        ]);

        return $id;
    }

    /**
     * Update the specified User.
     *
     * @param  object $request
     * @param  int  $id
     * @return object
     */
    public function restore(int $id): int
    {
        $user = $this->user->whereId($id)->withTrashed()->firstOrFail();

        $user->restore();

        return $id;
    }

    /**
     * Soft delete the specified User from storage.
     *
     * @param  int  $id
     * @return int
     */
    public function destroy(int $id): int
    {
        $user = $this->user->whereId($id)->firstOrFail();

        $user->delete();

        return $id;
    }

    /**
     * Remove the specified User from storage.
     *
     * @param  int  $id
     * @return int
     */
    public function forceDestroy(int $id): int
    {
        $user = $this->user->whereId($id)->withTrashed()->firstOrFail();

        $userCalendarEvents = ModelHasCalendarEvent::where([
            'model_type' => User::class,
            'model_id' => $user->id
          
        ]);

        $userCalendarEvents->forceDelete();

        $user->forceDelete();

        return $id;
    }
}