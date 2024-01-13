<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class CompanyDetailsResource extends JsonResource
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
            'email' => $this->email,
            'website' => $this->website,
            'logo' => $this->logo,
            'ext' => $this->ext,
            'token' => $this->token,
            'url' => $this->url,
            'thumbnail_url' => $this->thumbnail_url,
            'created_by' => new UserResource($this->createdBy),
            'updated_by' => isset($this->updatedBy->id) ? new UserResource($this->updatedBy) : [],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
