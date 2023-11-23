<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        $regions = Region::when(!request('code'), function($query) {
            $query->whereRaw('CHAR_LENGTH(code) = 2');
        })->when(request('code'), function($query) {
            $code_length = strlen(request('code'));
            switch($code_length) {
                case 2:
                $query->whereRaw('CHAR_LENGTH(code) = 5')
                    ->whereRaw('LEFT(code, 2) = "' . request('code') . '"');
                break;
                case 5:
                $query->whereRaw('CHAR_LENGTH(code) = 8')
                    ->whereRaw('LEFT(code, 5) = "' . request('code') . '"');
                break;
                case 8:
                $query->whereRaw('CHAR_LENGTH(code) = 13')
                    ->whereRaw('LEFT(code, 8) = "' . request('code') . '"');
                break;
                case 13:
                $query->where('code', request('code'));
            }
        })->get();
        return view('register.region-select')->with(['regions' => $regions]);
    }
}
