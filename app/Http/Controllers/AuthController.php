<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendEmailResetJob;


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
    //ini untuk function reset password, email yang di input akan dicek
    public function resetPassword(Request $request){
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
        ]);
        if($validate->fails()) {
            return back()->with('error', 'ada yang salah, pastikan password yang anda masukkan sama dan berisi minimal 8 karakter');
        }
        $check_token = DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->token,
        ])->first();
            if(! $check_token) {
                return back()->withInput()->with('fail', 'Invalid token');
            }else {
                if (Carbon::now()->lte($check_token->created_at)) {
                    User::where('email', $request->email)->update([
                        'password' => Hash::make($request->password),
                    ]);
    
                    PasswordReset::where([
                        'email' => $request->email,
                    ])->delete();
                }else {
                    return redirect()->route('login')->with('error', 'Masa habis token sudah tidak berlaku');
                }
    
            return redirect()->intended('login')->with('success', 'Password berhasil diubah')->with('verifiedEmail', $request->email);
        }
        }
        //ini untuk route get di web.php memasukkan password baru
        public function showResetForm(Request $request, $token = null){
            
            $check_expired = PasswordReset::where([
                'email' => $request->input('email'),
                'token'=>$request->token,
                ])->first();
            $check_token = PasswordReset::where([
                'email'=>$request->email,
                'token'=>$request->token,
                ])->first();
    
            if(!$check_token){
                //jika token yang dicek tidak ada
                return redirect()->route('login')->with('error', 'Link reset password telah digunakan');
            }else{
                //jika token yang dicek ada
                if (Carbon::now()->lte($check_expired->created_at)) {
                    return view('Auth.reset_password')->with(['token' => $token, 'email' => $request->email]);
                }else {
                    return redirect()->route('login')->with('error', 'Link reset password telah expired');
                }
            }
        }
        public function email_test(Request $request){
            $request->validate([
                'email'=>'required|email|exists:users,email'
            ]);
    
            $token = Str::random(64);
            //ini function untuk membuat token dan mengatur expired dari created at
            DB::table('password_resets')->insert([
                'email'=>$request->email,
                'token'=>$token,
                'created_at'=>Carbon::now()->addMinutes(60), //batas waktu expired
                'is_verified' => 0,
            ]);
    
            $data['action_link'] = route('reset_password',['token'=>$token,'email'=>$request->email]);
            $data['body'] = "Kami telah menerima permintaan untuk mengatur ulang kata sandi akun yang terkait dengan ".$request->email." pada <b>Literasi Digital Tuna Netra</b>. Anda dapat mengatur ulang kata sandi dengan mengklik tautan di bawah ini";
    
                // Mail::send('email-test',['action_link'=>$data['action_link'],'body'=>$data['body']], function($message) use ($request){
                // $message->from('imasnurdianto.stu@pnc.ac.id','Imas Nurdianto');
                // $message->to($request->email, '')->subject('Reset Password');
            // });
            
    
            $data['email'] = $request->email;
      
            dispatch(new SendEmailResetJob($data));
            // dd(session()->all());
        
            // return back()->with('success', 'Reset Password sudah dikirim ke email anda! silahkan cek email');
            return redirect()->route('login')->with('success', 'Reset Password sudah dikirim ke email anda! silahkan cek email');
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
