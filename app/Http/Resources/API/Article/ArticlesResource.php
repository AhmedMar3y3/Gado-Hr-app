<?php
namespace App\Http\Resources\API\Article;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticlesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id'      => $this->id,
            'title'   => $this->title,
            'content' => $this->content,
            'about_employee' => $this->about_employee
        ];

        if ($this->about_employee) {
            $data['employee'] = [
                'name'  => optional($this->employee)->name,
                'image' => optional($this->employee)->image ?? env('APP_URL') . '/defaults/profile.webp',
                'job_title' => optional($this->employee)->job->title,
            ];
        }

        return $data;
    }
}
