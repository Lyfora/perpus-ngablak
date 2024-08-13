<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    //
    public function actionLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                $notification = [
                    'type' => 'error',
                    'message' => $validator->errors()->first(),
                ];
                return redirect()->back()->with(['notification' => $notification]);
            }
            $credentials = $request->only('email', 'password');


            if (Auth::attempt($credentials)) {
                $notification = [
                    'type' => 'success',
                    'message' => 'Login berhasil',
                ];
                return redirect()->route('dashboard')->with(['notification' => $notification]);
            }


            $notification = [
                'type' => 'error',
                'message' => 'Email atau password salah',
            ];
            return redirect()->back()->with(['notification' => $notification]);
        } catch (\Exception $e) {
            $notification = [
                'type' => 'error',
                'message' => 'Gangguan Pada Server'
            ];
            return redirect()->back()->with(['notification' => $notification]);
        }
    }
    public function actionLogout()
    {
        Auth::logout();
        return redirect()->route('admin.signin');
    }

    public function viewSignIn()
    {
        return view('Admin.SignIn');
    }

    public function viewForgotPassword()
    {
        return view('Admin.ForgotPassword');
    }

    public function actionForgotPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email'
            ]);

            if ($validator->fails()) {
                $notification = [
                    'type' => 'error',
                    'message' => $validator->errors()->first(),
                ];
                return redirect()->back()->with(['notification' => $notification]);
            }

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                $notification = [
                    'type' => 'error',
                    'message' => 'Email tidak ditemukan',
                ];
                return redirect()->back()->with(['notification' => $notification]);
            }

            Mail::send(
                "email_template",
                [
                    "user" => $user->name,
                    "title" => "Permohonan Reset Password",
                    "button_title" => "Reset Password",
                    "content" => "Klik tombol dibawah ini untuk mereset password anda",
                    "link" => "test"
                    // "link" => URL::route('reset-password', ['token' => $user->reset_password_token])
                ],
                function ($message) use ($user) {
                    $message->to($user->email, $user->email)
                        ->subject("Permohonan Reset Password");
                }
            );

            $notification = [
                'type' => 'success',
                'message' => 'Link reset password telah dikirim ke email anda',
            ];

            return redirect()->back()->with(['notification' => $notification]);
        } catch (\Exception $e) {
            $notification = [
                'type' => 'error',
                'message' => 'Gangguan Pada Server'
            ];
            return redirect()->back()->with(['notification' => $notification]);
        }
    }

    public function viewResetPassword($token)
    {
        return view('Admin.ResetPassword', ['token' => $token]);
    }

    public function actionResetPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'token' => 'required',
                'password' => 'required|confirmed',
            ]);

            if ($validator->fails()) {
                $notification = [
                    'type' => 'error',
                    'message' => $validator->errors()->first(),
                ];
                return redirect()->back()->with(['notification' => $notification]);
            }

            $user = User::where('reset_password_token', $request->token)->first();

            if (!$user) {
                $notification = [
                    'type' => 'error',
                    'message' => 'Token tidak valid',
                ];
                return redirect()->back()->with(['notification' => $notification]);
            }

            $user->password = bcrypt($request->password);
            $user->reset_password_token = null;
            $user->save();

            $notification = [
                'type' => 'success',
                'message' => 'Password berhasil direset',
            ];

            return redirect()->route('admin.signin')->with(['notification' => $notification]);
        } catch (\Exception $e) {
            $notification = [
                'type' => 'error',
                'message' => 'Gangguan Pada Server'
            ];
            return redirect()->back()->with(['notification' => $notification]);
        }
    }

    public function actionChangePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
            ]);

            if ($validator->fails()) {
                $notification = [
                    'type' => 'error',
                    'message' => $validator->errors()->first(),
                ];
                return redirect()->back()->with(['notification' => $notification]);
            }

            $user = User::find(auth()->id());

            if (!password_verify($request->old_password, $user->password)) {
                $notification = [
                    'type' => 'error',
                    'message' => 'Password lama salah',
                ];
                return redirect()->back()->with(['notification' => $notification]);
            }

            $user->password = bcrypt($request->password);
            $user->save();

            $notification = [
                'type' => 'success',
                'message' => 'Password berhasil diubah',
            ];

            return redirect()->back()->with(['notification' => $notification]);
        } catch (\Exception $e) {
            $notification = [
                'type' => 'error',
                'message' => 'Gangguan Pada Server'
            ];
            return redirect()->back()->with(['notification' => $notification]);
        }
    }
}
