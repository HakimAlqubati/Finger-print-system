<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class VacationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'emp_id' => $this->emp_id,
            'emp_name' => $this->user->name,
            'date' => $this->date,
            'type' => $this->type,
            'no_of_days' => $this->no_of_days,
            'from_time' => $this->from_time,
            'to_time' => $this->to_time,
            'status' => $this->status,
            'vacation_reason' => $this->vacation_reason,
            'manager_notes' => $this->manager_notes,
        ];
    }
}
