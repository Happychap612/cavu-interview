<?php

namespace App\Models;

use App\Models\CarPark\Space;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    public $fillable = [
        'customer_id',
        'car_park_space_id',
        'start',
        'end',
        'cancelled',
    ];

    /**
     * The customer that made the booking
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * The car park space that the booking is for
     */
    public function carParkSpace(): BelongsTo
    {
        return $this->belongsTo(Space::class, 'id', 'car_park_space_id');
    }
}
