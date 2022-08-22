<?php

namespace App\Http\Resources;

use App\Models\Period as ModelsPeriod;
use Illuminate\Http\Resources\Json\JsonResource;

class Period extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'period_type' => $this->period_type,
            'from_time' => $this->from_time,
            'to_time' => $this->to_time,

        ];
    }
}
