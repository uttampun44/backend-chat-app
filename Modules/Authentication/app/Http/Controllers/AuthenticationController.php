<?php

namespace Modules\Authentication\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Authentication\app\Repositories\AuthenticationRepository;
use Modules\Authentication\Http\Requests\LoginRequest;
use Modules\Authentication\Http\Requests\SignupRequest;

class AuthenticationController extends Controller
{
    protected $repository;

    public function __construct(AuthenticationRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('authentication::index');
    }

    // login method
    // this method is used to login the user
    public function postLogin(LoginRequest $request)
    {
        try {
            $data = $request->validated();
            $result = $this->repository->postLogin($data);
            return response()->json([
                'status' => true,
                'message' => 'Login successfully',
                'token' => $result
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    // logout method
    // this method is used to logout the user
    public function postLogout()
    {
        try {
            $result = $this->repository->postLogout();
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    // signup method
    // this method is used to register the user
    public function postSignup(SignupRequest $request)
    {
        try {
            $data = $request->validated();
            $result = $this->repository->postRegister($data);
            return response()->json([
                'status' => true,
                'message' => 'Data stored successfully',
                'data' => $result
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    // email confirmation method
    // this method is used to confirm the email of the user
    public function postEmailConfirmation(Request $request)
    {
        try {
            $data = $request->all();
            $result = $this->repository->postConfirmEmail($data);
            return response()->json([
                'status' => true,
                'message' => 'Email confirmation successfully',
                'data' => $result
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    // otp method
    // this method is used to send the otp to the user
    public function postOtp(Request $request)
    {
        try {
          
             $this->repository->postOtp($request->all());
            return response()->json([
                'status' => true,
                'message' => 'OTP successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    // reset password method
    // this method is used to reset the password of the user
    public function postResetPassword(Request $request)
    {
        try {
         
             $this->repository->postResetPassword($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Password reset successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('authentication::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('authentication::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('authentication::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
