<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    // resources/js/app.js/
    public function image(Request $request)
    {
        return $file = $request->file('test')->store('images/adverts', 'public_public');
    }
}
