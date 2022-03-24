<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /*$events = $this->events;
        $eventsIds = $events->map(function($event){
            return $event->id;
        });*/

        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'bio' => $this->bio,
            'country' => $this->country,
            //'events' => $eventsIds,
        ];
    }
}