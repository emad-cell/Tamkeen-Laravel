<?php

namespace App\Http\Controllers\Api;

use App\Enum\RolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;


class AuthController extends Controller
{
    public function associationRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::default()],
            'full_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:20',
            // 'license' => 'required|string|max:255',
            // 'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            // 'image' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, 'Failed to create your account', $validator->errors()->toArray());
        }
        // $filePath = null;
        // if ($request->hasFile('file')) {
        //     $file = $request->file('file');
        //     $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file->getClientOriginalName());
        //     $filePath = $file->storeAs('uploads/associations/Files', $fileName, 'public');
        // }
        // $imagePath = null;
        // if ($request->hasFile('image')) {
        //     $file = $request->file('image');
        //     $imageName = time() . '_' . $file->getClientOriginalName();
        //     $imagePath = $file->storeAs('uploads/associations/Images', $imageName, 'public');
        // }
        $validated = $validator->validated();

        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ])->assignRole(RolesEnum::Association);

        // Create association profile
        $user->association()->create([
            'full_name' => $validated['full_name'],
            // 'mobile_number' => $validated['mobile_number'],
            // 'lisence' => $validated['license'],
            // 'file_path' => $filePath,
            // 'image' => $imagePath,
            'accepted' => 1,
        ]);
        $data['token'] = $user->createToken('Auth')->plainTextToken;
        $data['name'] = $user->full_name;
        $data['email'] = $user->email;
        event(new Registered($user));
        // return ApiResponse::sendResponse(201, 'تم تسجيل طلبك بنجاح . يرجى انتظار رسالة قبول الطلب عبر البريد الالكتروني', []);

        return ApiResponse::sendResponse(
            200,
            'Your account created successfully',
            $data
        );
    }



    public function clientRegister(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::default()],
            'full_name' => 'required|string|max:255',
            // 'mobile_number' => 'required|string|max:20',
            // 'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            // 'image' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, 'Failed to create your account', $validator->errors()->toArray());
        }
        // $filePath = null;
        // if ($request->hasFile('file')) {
        //     $file = $request->file('file');
        //     $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file->getClientOriginalName());
        //     $filePath = $file->storeAs('uploads/clients/Files', $fileName, 'public');
        // }
        // $imagePath = null;
        // if ($request->hasFile('image')) {
        //     $file = $request->file('image');
        //     $imageName = time() . '_' . $file->getClientOriginalName();
        //     $imagePath = $file->storeAs('uploads/clients/Images', $imageName, 'public');
        // }

        $validated = $validator->validated();

        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ])->assignRole(RolesEnum::Client);

        // Create client profile
        $user->client()->create([
            'full_name' => $validated['full_name'],
            // 'mobile_number' => $validated['mobile_number'],
            // 'file_path' => $filePath,
            'accepted' => 1,
            // 'image' => $imagePath,
        ]);
        $data['token'] = $user->createToken('Auth')->plainTextToken;
        $data['name'] = $user->full_name;
        $data['email'] = $user->email;
        event(new Registered($user));
        // return ApiResponse::sendResponse(201, 'تم تسجيل طلبك بنجاح . يرجى انتظار رسالة قبول الطلب عبر البريد الالكتروني', []);

        return ApiResponse::sendResponse(
            200,
            'Your account created Successfully',
            $data
        );
    }


    public function Login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return ApiResponse::sendResponse(
                422,
                'Failed to login',
                $validator->errors()->toArray()
            );
        }

        $validated = $validator->validated();

        if (!Auth::attempt($validated)) {
            return ApiResponse::sendResponse(
                401,
                'User Credentials Doesn\'t exist',
                []
            );
        }

        $user = Auth::user();

        // 🛑 التحقق من حالة القبول
        $accepted =
            $user->client?->accepted ??
            $user->association?->accepted ??
            0;



        $role = $user->getRoleNames()->first();

        $abilities = match ($role) {
            'admin' => ['access:admin'],
            'association' => ['access:association'],
            'client' => ['access:client'],
            default => [],
        };

        $data = [
            'token' => $user->createToken('Auth', $abilities)->plainTextToken,
            'name' => $user->client?->full_name
                ?? $user->association?->full_name
                ?? 'User',
            'email' => $user->email,
            'role' => $role,
            'state' => $accepted,
            'id' => $user->id,
        ];
        if ($accepted == 0 && $role != "admin") {
            Auth::logout();
            return ApiResponse::sendResponse(
                403,
                'حسابك قيد المراجعة ولم يتم قبوله بعد',
                ['حسابك قيد المراجعة ولم يتم قبوله بعد']
            );
        }
        return ApiResponse::sendResponse(
            200,
            'User Logged In Successfully',
            $data
        );
    }

}
