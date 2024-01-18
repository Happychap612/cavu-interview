<?php

namespace App\Models;

use App\Models\CarPark\Space;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarPark extends Model
{
    /**
     * Should the model use timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    public $weekendRate = 10;
    public $weekdayRate = 5;
    public $summerRate = 15;
    public $winterRate = 10;

    /**
     * The spaces for the car park
     */
    public function spaces(): HasMany
    {
        return $this->hasMany(Space::class);
    }
}
