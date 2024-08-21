<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Parsedown;

class ChangelogController extends Controller
{
    /**
     * Display the specified resource card.
     */
    public function show()
    {
        // List the files in the public disk
        $markdown = Storage::disk('public')->get('CHANGELOG.md');

        $parsedown = new Parsedown();
        $html      = $parsedown->text($markdown);

        return view('changelog', ['html' => $html]);
    }
}
