<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Auth.login');
    }
    public function lupa_password()
    {
        return view('Auth.lupa_password');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('Dashboard.dashboard');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function login(Request $request)
    {
        
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);


        //berfungsi jika format email salah
        if($validate->fails()){
            // return response(['message'=> $validate->errors()], 200);
            return back()->with('error', 'The email must be a valid email address!');
        } else {
            //berfungsi jika password salah/tidak sama
            $credentials = request(['email', 'password']);
            // $credentials = Arr::add($credentials, 'status', 'active');
            if(!Auth::attempt($credentials)){
                $respon = [
                    'status' => 'error',
                    'msg' => 'Unauthorized',
                    'errors' => null,
                    'content' => null,
                ];
                return back()->with('error', 'Invalid! Email atau Password yang anda masukkan Salah!');
                // return response(['message'=>'Invalid Credential'], 401);
                // return response(['message'=>'Login Failed! Email atau Password yang anda masukkan Salah!'], 401);
            }
            //ini untuk menangkap error login
            $user = User::where('email', $request->email)->first();
            if(!Hash::check($request->password, $user->password, [])){
                throw new Exception('Error in login');
            }
            //ini untuk function ketika dinyatakan data valid dan di redirect menuju dashboard
            $tokenResult = $user->createToken('token-auth')->plainTextToken;
            $respon = [
                'status' => 'success',
                'msg' => 'Login successfully',
                'content' => [
                    'status_code' => 200,
                    'access_code' => $tokenResult,
                    'token_type' => 'Bearer',
                ],
            ];
            //  return response()->json($respon, 200);
            // if($user->role_id == 2){
            //     return redirect()->intended('/analisis_penumpang')->with('success', 'Selamat Datang Admin '.$user->name.'');
            // }else {
                return redirect()->intended('/dashboard')->with('success', 'Selamat Datang Admin '.$user->name.''); 
            // }
            // dd(session()->all());
        }
    }

    //ini untuk function logout
    public function logout (Request $request) {
        Cache::flush();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success','Anda Berhasil Logout');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
