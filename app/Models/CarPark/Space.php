<?php

namespace App\Models\CarPark;

use App\Models\CarPark;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Space extends Model
{
    use HasFactory;

    /**
     * Should the model use timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    
    /**
     * The table for the model
     *
     * @var string
     */
    protected $table = 'car_park_spaces';

    /**
     * Get the car park that the space is in
     */
    public function carPark(): BelongsTo
    {
        return $this->belongsTo(CarPark::class);
    }
}
