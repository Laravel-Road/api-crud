<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'description' => $this->description ?? 'n/a',
            'expired_at' => $this->expired_at ? $this->expired_at->format('d/m/Y') : 'n/a',
            'user_id' => $this->user_id,
        ];
    }
}
