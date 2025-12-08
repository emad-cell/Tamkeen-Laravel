<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\ApiResponse;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;

class ServiceController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function index()
    {
        $services = Service::paginate(config('pagination.count'));
        return ApiResponse::sendResponse(200, 'All services retrieved', ServiceResource::collection($services));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),  [
            'user_id' => 'required|integer|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'type' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'requirements' => 'nullable|string',
            'status' => 'required|in:pending,active,closed',
            'capacity' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
        $data = $validator->validated();
        $data['status']='active';
        // $data['user_id'] = $request->user()->id;
        $service = Service::create($data);

        return ApiResponse::sendResponse(201, 'Service created successfully', new ServiceResource($service));
    }

    /**
     * Display the specified resource (API).
     */
    public function show(Service $service)
    {
        return ApiResponse::sendResponse(200, 'Service fetched successfully', new ServiceResource($service));
    }

    /**888888
     * Update the specified resource in storage (API).
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $data = $request->validated();
        $service->update($data);

        return ApiResponse::sendResponse(200, 'Service updated successfully', new ServiceResource($service));
    }

    /**
     * Remove the specified resource from storage (API).
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return ApiResponse::sendResponse(200, 'Service deleted successfully',[]);
    }
}
