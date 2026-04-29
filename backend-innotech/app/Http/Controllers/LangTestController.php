<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LangTestController extends Controller
{
    public function testLang()
    {
        return response()->json([
            'lang' => App::getLocale(),
            'message' => __('messages.retrieved_successfully'),
        ]);
    }
}

