<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Domain;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $domains = Domain::all();
        return view('activities.index')->with(compact('domains'));
    }
}
