<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CalendarEvent extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'start'
    ];

    public function users()
    {
        return $this->morphedByMany(
            User::class,
            'model',
            'model_has_calendar_events',
            'calendar_event_id',
            'model_id',
        );
    }

    /**
     * Create CalendarEvent with required relationships
     *
     * @param object $request
     * @return int
     */
    public function createWithRelation(object $request): int
    {
        $calendarEventId = $this->create([
            'title' => $request->title,
            'description' => $request->description,
            'start' => Carbon::parse($request->start)->setTimezone('Europe/Moscow')
        ])->id;

        $users = [];

        if ($request->departments) {
            foreach ($request->departments as $department) {
                $department = Department::whereId($department['id'])->with('user')->firstOrFail();
                foreach ($department->user as $user) {
                    $users[] =  $user->toArray();
                }
            }
        }

        $mergedUsers = array_merge($request->users, $users);

        $removedUserDuplicates = array_map("unserialize", array_unique(array_map("serialize", $mergedUsers)));

        foreach ($removedUserDuplicates as $user) {
            ModelHasCalendarEvent::create([
                'model_id' => $user['id'],
                'model_type' => User::class,
                'calendar_event_id' => $calendarEventId
            ]);
        }

        return $calendarEventId;
    }
}
