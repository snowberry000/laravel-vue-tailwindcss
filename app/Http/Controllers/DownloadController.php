<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class DownloadController extends Controller
{

    /**
     * List downloads for an user and no one else.
     */
    public function index()
    {
        return Inertia::render('Downloads/Index');
    }
}