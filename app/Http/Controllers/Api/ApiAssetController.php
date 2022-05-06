<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\AssetResource;
use App\Models\Asset;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use function auth;
use function config;


class ApiAssetController extends Controller
{
    public function index(Request $request)
    {

        return AssetResource::collection(Asset::all());
    }
}
