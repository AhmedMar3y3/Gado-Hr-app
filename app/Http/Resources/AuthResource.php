<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

     private $token;
     public function setToken($token){
         $this->token = $token;
 
         return $this;
     }
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'role' => $this->role->formattedName(),
            'job' => $this->job->title,
            'image' => $this->image,
            'token' => $this->token,
        ];
    }
}
