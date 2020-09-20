<?php
declare(strict_types=1);

namespace App\Domain\Hexagon;

use Illuminate\Database\Eloquent\Model;

class Hexagon extends Model
{
    protected $fillable = [
        'name',
        'coords'
    ];

    public static function findByName(string $name)
    {
        return static::query()->where('name', $name)->first();
    }

    public static function findByCoords(string $coords)
    {
        return static::query()->where('coords', $coords)->first();
    }
}
