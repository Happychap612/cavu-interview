<?php

namespace App\Http\Controllers;

use App\Models\CarPark\Space;

class SpacesController extends Controller
{
    public function show(Space $space)
    {
        return $space->makeHidden('id');
    }
}
