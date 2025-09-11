<?php

namespace App\Http\Controllers\Api;

use App\Http\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        $settings=Setting::find(1);
        if($settings){
            return ApiResponse::sendResponse(200,'Settings Retrived Successfully',new SettingResource($settings));
        }
        return ApiResponse::sendResponse(200, 'Settings NOt Found', []);
    }
}
