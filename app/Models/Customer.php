<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
    ];

    /**
     * Should the model use timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * The bookings for the customer
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
