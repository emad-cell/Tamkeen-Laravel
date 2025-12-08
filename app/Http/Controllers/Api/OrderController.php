<?php

namespace App\Http\Controllers\Api;

use App\Enum\RolesEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ServiceResource;
use App\Mail\OrderAcceptedMail;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display orders
     */
    // public function index(int $id): JsonResponse
    // {

    //         $orders = Order::with(['client:id', 'service:id'])
    //             ->where('client_id', $id)
    //             ->orderBy('created_at', 'desc')
    //             ->get();
    //     return ApiResponse::sendResponse(200, "Orders retrieved successfully",  OrderResource::collection($orders));
    // }

    /**
     * Create a new order
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['status']= 'pending';
        $order = Order::create($data);

        return ApiResponse::sendResponse(201, 'Service Ordered Successfully', new OrderResource($order));
    }

    /**
     * Display a specific order
     */
    public function show(int $id): JsonResponse
    {
        $orders = Order::with(['client', 'service'])
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return ApiResponse::sendResponse(200, "Orders retrieved successfully", $orders);
    }


    /**
     * Update an order
     */
    public function update(int $id): JsonResponse
    {
        $order = Order::find($id);

        if (!$order) {
            return ApiResponse::sendResponse(404, 'Order not found');
        }

        // Update order status
        $order->update(['status' => 'active']);
        // $number=$order->->user && $this->user->association ? $this->user->association->full_name : null,
        // Send email to the user
        if ($order->email) { // make sure user exists and has email
            Mail::to($order->email)->send(new OrderAcceptedMail($order));
        }

        return ApiResponse::sendResponse(200, 'Order updated successfully', new OrderResource($order));
    }


    /**
     * Delete an order
     */
    public function destroy(int $id): JsonResponse
    {
        $user = Auth::user();
        $order = Order::findOrFail($id);

        if (!$this->canAccessOrder($user, $order)) {
            return response()->json(['message' => 'غير مصرح لك بحذف هذا الطلب'], 403);
        }

        $order->delete();

        return response()->json(['message' => 'تم حذف الطلب بنجاح']);
    }

    /**
     * Check if user can access the order
     */
    private function canAccessOrder($user, Order $order): bool
    {
        return $user->hasRole(RolesEnum::Admin) || $order->client_id === $user->id;
    }
}
