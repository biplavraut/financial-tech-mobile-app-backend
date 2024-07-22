<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends CommonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArrayWithoutNullValues($request)
    {
        return [
            'id' => $this->id,
            'title'             => $this->title,
            'subTitle'            => $this->sub_title,
            'page' => $this->page,
            'feature' => $this->feature,
            'image'             => $this->imageUrl('image'),
            'display' => $this->display == 1,
            'link' => $this->link,
            'createdAt' => date('F d, Y h:i A', strtotime($this->created_at)),
        ];
    }
}
