<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "title"=>$this->title,
            "preview"=>url($this->preview),
            "author"=>$this->author->author,
            "genres" => GenreResource::collection($this->genres()->get())
        ];
    }
}
