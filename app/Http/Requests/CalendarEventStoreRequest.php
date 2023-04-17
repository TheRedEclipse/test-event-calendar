<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalendarEventStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'start' => 'required|date',
            'departments' => 'array',
            'departments.*.id' => 'exists:departments,id',
            'users' => 'array',
            'users.*.id' => 'exists:users,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => __('calendar_event.title_required'),
            'description.required' => __('calendar_event.description_required'),
            'start.required' => __('calendar_event.start_required'),
        ];
    }
}
