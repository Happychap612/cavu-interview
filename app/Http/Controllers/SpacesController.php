<?php

namespace App\Http\Controllers;

use App\Models\CarPark\Space;

class SpacesController extends Controller
{
    /**
     * Singular parking space show action, returns the space without the ID as in
     * this context the api consumer would already know the ID
     *
     * @param Space $space
     * @return Space
     */
    public function show(Space $space)
    {
        return $space->makeHidden('id');
    }
}
