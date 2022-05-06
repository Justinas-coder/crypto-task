<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\AssetResource;
use App\Models\Asset;
use Illuminate\Http\Request;



class ApiAssetController extends Controller
{
    public function index(Request $request)
    {

        return AssetResource::collection(Asset::all());
    }
}
