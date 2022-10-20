<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\TableOrder;

class Table extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    protected $table = 'tables';

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function tableOrders()
    {
        return $this->hasMany(TableOrder::class);
    }
    public function tableOrder()
    {
        return $this->hasOne(TableOrder::class);
    }
}
