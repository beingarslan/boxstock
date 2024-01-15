<?php
namespace App\Http\Controllers;
use App\Mail\UserAccountApproved;
use App\Mail\UserNotificationEmail;
use App\Mail\UserWasVerifiedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function index() {
        $users = User::all()->except(Auth::id());
        return response()->json([
            'user' => $users
        ], 201);
    }

    public function singleUser($id) {
        $user = User::find($id);
        return response()->json([
            'user' => $user
        ], 201);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::where('email', '=', $request->email)->first();

        if(!$user->approved) {
            return response()->json(['error' => 'Your account is not approved'], 401);
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Email or Password did not match'], 401);
        }

        return $this->createNewToken($token);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'country' => 'required',
            'password' => 'required|string|confirmed|min:6',
            'phone_number' => 'required|string',
            'user_name' => 'required|string',
            'city' => 'required',
            'post_code' => 'required',
            'street_name' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $path = '';
        if($request->hasFile('image')){
            //get filename with the extension
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            // GET just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //get just ext
            $extension = $request->file('image')->getClientOriginalExtension();
            //filename to store
            $user_iamge = $filename.'_'.time().'.'.$extension;
            $request->file('image')->move(public_path('/users'),$user_iamge);
            $path = "/users/" . $user_iamge;
        } else {
            $user_iamge = 'no.png';
        }

        $user = User::create(array_merge(
            $validator->validated(),
            [
                'password' => bcrypt($request->password),
                'phone_number' => $request->phone_number
            ]
        ));

        if($path) {
            $user->image = $path;
            $user->save();
        }

        Mail::to($user->email)->send(new UserNotificationEmail($user));
        Mail::to(env('ADMIN_EMAIL'))->send(new UserWasVerifiedMail($user));

        return response()->json([
            'message' => 'We will send you email for account approved. Thank you',
            'user' => $user
        ], 201);
    }

    public function verify(Request $request) {

    }

    /**
     * @param VerificationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendVerificationCode(VerificationRequest $request)
    {
        $user = User::where([
            'email' => $request->input('email'),
            'email_verified_at' => null
        ])->first();

        return $this->sendEmailVerificationCodeRespond($user);

    }

    public function passwordResetVerificationCode(VerificationRequest $request)
    {
        $user = User::where([
            'email' => $request->input('email')
        ])->first();
        if ( $user ) {
            $user->passwordResetVerificationCode();
        }

        return response()->json([
            'message' => 'Password Reset Verification Code Sent'
        ]);
    }

    /**
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendEmailVerificationCodeRespond($user)
    {
        if ( $user )
        {
            $user->sendEmailVerificationCode();
        }

        return response()->json([
            'message' => 'Email verification code sent'
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(): \Illuminate\Http\JsonResponse
    {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile(): \Illuminate\Http\JsonResponse
    {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken(string $token): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    public function update($id, Request $request) {
        $user = User::find($id);

        $user->update($request->all());
        if($request->approved) {
            $user->approved = $request->approved;
            Mail::to($user->email)->send(new UserAccountApproved($user));
        }

        if(isset($request->password)) {
            $user->password = bcrypt($request->password);
        }

        $user->save();
        return response()->json('The user successfully updated');
    }

    public function delete($id) {
        User::destroy($id);
        return response()->json('The user successfully deleted');
    }
}
