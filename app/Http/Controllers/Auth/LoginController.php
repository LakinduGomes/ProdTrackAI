<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Handle user login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $input = $request->all();

        // Validation
        $validator = Validator::make($input, [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        $user = User::where('email', $input['email'])->first();

        if (!$user) {
            return response()->json(['status' => false, 'errors' => [
                'email' => 'The email address does not match our records.',
            ]]);
        }

        // Check if the user account is active
        if ($user->status == 0) {
            return response()->json(['status' => false, 'errors' => [
                'email' => 'Sorry! Your account is deactivated. Please contact the support team.',
            ]]);
        }

        // Attempt login
        if (Auth::attempt(['email' => $input['email'], 'password' => $input['password'], 'status' => 1])) {
            $route = route('dashboard');
            return response()->json(['status' => true, 'message' => 'Success', 'route' => $route]);
        } else {
            return response()->json(['status' => false, 'errors' => [
                'password' => 'Invalid credentials. Please try again.',
            ]]);
        }
    }
}
