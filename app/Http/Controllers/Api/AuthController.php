<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     summary="Register a new user",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="User's name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="User's email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="mobile",
     *         in="query",
     *         description="User's mobile",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="201", description="User registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'mobile' => 'required',
                ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

//    public function sendVerificationCode(Request $request)
//    {
//        $mobile = $request->mobile;
//        $code = mt_rand(10000, 99999);
//        $user = User::query()->where('mobile', $mobile)->first();
//        if (!$user) {
//            return response(['status' => false, 'message' => 'این شماره موبایل ثبت نشده است.'], 200);
//        }


        //send code with message

//        if (!$this->sendCode($mobile, $code)) {
//            return response(['status' => false, 'message' => 'خطایی در ارسال کد فعالسازی رخ داد.'], 200);
//        }

//        $user->verify_code = $code;
//        $user->save();
//        return response(['status' => true, 'message' => 'کد فعالسازی برای شما ارسال شد.'], 200);
//
//
//    }



    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Authenticate user and generate JWT token",
     *     @OA\Parameter(
     *         name="mobile",
     *         in="query",
     *         description="User's mobile",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="verify_code",
     *         in="query",
     *         description="User's verify_code",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Login successful"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function loginUser(Request $request)
    {
        $verifyCode = trim($request->verify_code);

        if ($verifyCode !=12345678) {
            return response(['status' => false, 'message' => 'کد وارد شده صحیح نیست.'], 200);
        }
        $user = User::query()->where(['mobile' => $request->mobile])->first();

        if (!$user) {
            return response(['status' => false, 'message' => 'شماره موبایل وارد شده صحیح نیست.'], 200);
        }


        $user->verify_code = null;
        $user->save();

        $token = $user->createToken("API TOKEN")->plainTextToken;

        return response([
            'status' => true,
            'token' => $token,
            ], 200);
    }
}
