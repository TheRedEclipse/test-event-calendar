<?php

namespace App\Services;

use App\Models\CalendarEvent;

class CalendarEventService
{
    protected $calendarEvent;

    public function __construct(CalendarEvent $calendarEvent)
    {
        $this->calendarEvent = $calendarEvent;
    }

    /**
     * Return list of CalendarEvent model
     *
     * @return mixed
     */
    public function index(): mixed
    {
        $calendarEvent = $this->calendarEvent->with(['users']);

        $user = auth()->user();

        if ($user && $user->userRole->name !== 'admin') {
            $calendarEvent->whereHas('users', function ($query) use ($user) {
                $query->where('users.id', '=', $user->id);
            });
        }

        if (!$user) {
            return [];
        }

        return $calendarEvent->get();
    }

    /**
     * Store a newly created CalendarEvent in storage.
     *
     * @param  object $request
     * @return object
     */
    public function store(object $request): int
    {
        return $this->calendarEvent->createWithRelation($request);
    }

    /**
     * Show the specified CalendarEvent in storage.
     *
     * @param  int  $id
     * @return object
     */
    public function show(int $id): object
    {
        return $this->calendarEvent->whereId($id)->with(['users.department'])->firstOrFail();
    }
}
