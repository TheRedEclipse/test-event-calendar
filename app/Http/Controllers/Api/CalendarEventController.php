<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CalendarEventStoreRequest;
use App\Services\CalendarEventService;

class CalendarEventController extends Controller
{
    protected $calendarEventService;

    public function __construct(CalendarEventService $calendarEventService)
    {
        $this->calendarEventService = $calendarEventService;
        $this->middleware('auth:api')->only(['store']);
        $this->middleware('auth:api')->only(['show']);

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
            'calendar_events' => $this->calendarEventService->index()
        ]);
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  object $request
     * @return object
     */
    public function store(CalendarEventStoreRequest $request): object
    {
        return response()->json([
            'success' => true,
            'calendar_event' => $this->calendarEventService->store($request)
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
            'calendar_event' => $this->calendarEventService->show($id)
        ]);
    }
}
