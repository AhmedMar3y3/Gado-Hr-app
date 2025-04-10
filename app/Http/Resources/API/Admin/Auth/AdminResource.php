<?php

namespace App\Http\Resources\API\Admin\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    private $token;
    public function setToken($token){
        $this->token = $token;

        return $this;
    }

    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'token' => $this->token ?? "",
        ];
    }
}
