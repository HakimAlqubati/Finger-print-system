<?php

namespace App\Http\Resources;

use App\Http\Resources\Period as ResourcesPeriod;
use App\Models\Period;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkDay extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'company_id' => $this->company_id,
            'company_name' => $this->company->name,
            'periods' => ResourcesPeriod::collection($this->periods()->get())
        ];
    }
}
