<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Models\RegesterRequest;
use App\Http\Requests\StoreRegesterRequestRequest;
use App\Http\Requests\UpdateRegesterRequestRequest;
use App\Mail\ClientAcceptedMail;
use App\Models\Association;
use App\Models\Client;
use Illuminate\Support\Facades\Mail;

use App\Models\Service;
use App\Models\User;

class RegesterRequestController extends Controller
{
    public function getUsers()
    {
        $users = User::where('id', '!=', 1)
            ->with(['client', 'association', 'roles']) // eager load
            ->get();

        // فلترة المستخدمين حسب الحقل accepted
        $filtered = $users->filter(function ($user) {
            $clientAccepted = $user->client ? $user->client->accepted == 1 : false;
            $associationAccepted = $user->association ? $user->association->accepted == 1 : false;

            return $clientAccepted || $associationAccepted;
        });

        // إعادة النتائج بعد الفلترة وتحويلها إلى مصفوفة عادية
        $result = $filtered->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->getRoleNames()->first(), // Spatie
                'client' => $user->client,       // بيانات client إذا موجود
                'association' => $user->association,  // بيانات association إذا موجود
            ];
        })->values()->all(); // ← تحويل إلى مصفوفة

        return ApiResponse::sendResponse(200, 'All services retrieved', $result);
    }
    public function gePendtUsers()
    {
        $users = User::where('id', '!=', 1)
            ->with(['client', 'association', 'roles']) // eager load
            ->get();

        // فلترة المستخدمين حسب الحقل accepted
        $filtered = $users->filter(function ($user) {
            $clientAccepted = $user->client ? $user->client->accepted == 0 : false;
            $associationAccepted = $user->association ? $user->association->accepted == 0 : false;

            return $clientAccepted || $associationAccepted;
        });

        // إعادة النتائج بعد الفلترة وتحويلها إلى مصفوفة عادية
        $result = $filtered->map(function ($user) {
            return [
                'id' => $user->id,
                'image_url' => $user->client->image ? asset('storage/' . $user->client->image) : null,
                'file_url' => $user->client->file_path ? asset('storage/' . $user->client->file_path) : null,
                'email' => $user->email,
                'role' => $user->getRoleNames()->first(), // Spatie
                'client' => $user->client,       // بيانات client إذا موجود
                'association' => $user->association,  // بيانات association إذا موجود
            ];
        })->values()->all(); // ← تحويل إلى مصفوفة

        return ApiResponse::sendResponse(200, 'All services retrieved', $result);
    }


    public function active(int $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if ($user->hasRole('client')) {
            $client = $user->client;
            if ($client) {
                $client->accepted = 1;
                $client->save();
                //     Mail::to($user->email)->send(new ClientAcceptedMail($user));
                $token = $user->tokens()->latest()->first()?->token;
                return response()->json([
                    'message' => 'Client activated successfully',
                    'token' => $token,
                    'user' => $user,
                ]);
            }
        }

        if ($user->hasRole('association')) {
            $association = $user->association;
            if ($association) {
                $association->accepted = 1;
                $association->save();
                if ($user->email) {
                    Mail::to($user->email)->send(new ClientAcceptedMail($user));
                }


                $token = $user->tokens()->latest()->first()?->token;

                return response()->json([
                    'message' => 'Association activated successfully',
                    'token' => $token,
                    'user' => $user,
                ]);
            }
        }

        return response()->json(['message' => 'User has no valid role or related record not found'], 400);
    }
    public function stats()
    {
        // 1. عدد الخدمات
        $servicesCount = Service::count();

        // 2. عدد العملاء (clients) المقبولين
        $clientsCount = Client::where('accepted', 1)->count();

        // 3. عدد الجمعيات (associations) المقبولين
        $associationsCount = Association::where('accepted', 1)->count();

        // 4. عدد غير المقبولين (clients + associations)
        $pendingCount = Client::where('accepted', 0)->count()
            + Association::where('accepted', 0)->count();

        return response()->json([
            'services_count' => $servicesCount,
            'clients_count' => $clientsCount,
            'associations_count' => $associationsCount,
            'pending_count' => $pendingCount,
        ]);
    }
}
