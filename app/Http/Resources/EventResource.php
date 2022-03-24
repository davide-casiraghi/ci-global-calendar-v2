<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $teachers = $this->teachers;
        $teachersIds = $teachers->map(function($teacher){
            return $teacher->id;
        });

        $organizers = $this->organizers;
        $organizersIds = $organizers->map(function($organizer){
            return $organizer->id;
        });

        return [
            'id' => $this->id,
            'title' => $this->title,
            'event_category_id' => $this->event_category_id,
            'teachers' => $teachersIds,
            'organizers' => $organizersIds,
            //'teachers' => TeacherResource::collection($this->teachers),
            //'organizers' => OrganizerResource::collection($this->organizers),
        ];
    }
}
