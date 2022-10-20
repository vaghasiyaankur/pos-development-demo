<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    protected $table = 'permissions';

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'function'
            ]
        ];
    }
}
