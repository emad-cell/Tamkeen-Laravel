<?php

use App\Models\User;
use App\Models\Service;
use App\Models\Order;

it('can test user relationships with data', function () {
    // Create test user
    $user = User::factory()->create();

    // Create test service for this user
    $service = Service::factory()->create(['user_id' => $user->id]);

    // Create test order for this user and service
    $order = Order::factory()->create([
        'client_id' => $user->id,
        'service_id' => $service->id
    ]);

    // Test relationships
    expect($user->orders)->toHaveCount(1);
    expect($user->services)->toHaveCount(1);
    expect($user->orders->first()->id)->toBe($order->id);
    expect($user->services->first()->id)->toBe($service->id);
});

it('can test service relationships with data', function () {
    $user = User::factory()->create();
    $service = Service::factory()->create(['user_id' => $user->id]);
    $order = Order::factory()->create([
        'client_id' => $user->id,
        'service_id' => $service->id
    ]);

    // Test relationships
    expect($service->user->id)->toBe($user->id);
    expect($service->orders)->toHaveCount(1);
    expect($service->orders->first()->id)->toBe($order->id);
});

it('can test order relationships with data', function () {
    $user = User::factory()->create();
    $service = Service::factory()->create(['user_id' => $user->id]);
    $order = Order::factory()->create([
        'client_id' => $user->id,
        'service_id' => $service->id
    ]);

    // Test relationships
    expect($order->client->id)->toBe($user->id);
    expect($order->service->id)->toBe($service->id);
});
