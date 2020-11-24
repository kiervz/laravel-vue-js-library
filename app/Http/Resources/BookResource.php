<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'id' => $this->id,
            'isbn' => $this->isbn,
            'call_number' => $this->call_number,
            'title' => $this->title,
            'author' => $this->author,
            'publisher' => $this->publisher,    
            'category' => $this->category->name,
            'year_published' => $this->year_published,
            'total_copies' => $this->total_copies,
        ];
    }
}
