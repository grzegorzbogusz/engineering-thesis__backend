<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class UserCollection extends ResourceCollection
{
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        return parent::toArray($request);
    }
}
