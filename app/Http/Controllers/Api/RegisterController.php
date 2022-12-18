<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon;
use Illuminate\Support\Facades\Hash;
   
class RegisterController extends BaseController
{
  
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'User register successfully.');
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric',
            'password' => 'required',
        ],
        [
            'phone.required' => 'Phone Field is Required',
            'phone.numeric' => 'Phone Field must be a numbers',
            'password.required' => 'Password Field is Required',
        ]
        );
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        // Status Validation
        $status = User::where('phone',$request->phone)->value('status');
        if($status == 0){
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }

        $email = User::where('phone',$request->phone)->value('email');
        if(blank($email)){
            return $this->sendError('Unauthorised.', ['error'=>'Invalid Credentials']);
        }

        if(Auth::attempt(['email' => $email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $token =  $user->createToken('AdeshaToken')->plainTextToken; 
            $success['user_id'] =  $user->id;
            $success['status'] =  $user->status;
            $success['role'] =  $user->getrole->name;
            
   
            return $this->sendResponse($success,$token, 'login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    public function otp_login(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric',
            'deviceToken' => 'required',
        ],
        [
            'phone.required' => 'Phone Field is Required',
            'phone.numeric' => 'Phone Field must be a numbers',
            'deviceToken.required' => 'deviceToken Field is Required',
        ]
        );
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $phone=$request->phone;
        $email=User::where('phone',$phone)->value('email');
        $id=User::where('phone',$phone)->value('id');
        $user=Auth::loginUsingId($id);
        $user=User::where('email','=',$email)->first();

        $deviceToken = $request->deviceToken;
        User::where('id',$id)->update([
            'last_login_at' => Carbon\Carbon::now('Asia/Kolkata')->toDateTimeString(),
            'deviceToken' => $deviceToken,
        ]);

        if(blank($email)){
            return $this->sendError('Unauthorised.', ['error'=>'Invalid Credentials']);
        }

            $user = Auth::user(); 
            $token =  $user->createToken('AdeshaToken')->plainTextToken; 
            $success['user_id'] =  $user->id;
            $success['status'] =  $user->status;
            $success['role'] =  $user->getrole->name;
            
   
            return $this->sendResponse($success,$token, 'login successfully.');
        
    }

    public function logout(Request $request) {
        auth('sanctum')->user()->tokens()->delete();
        $response = [
            'status'  => 200,
            'message' => "Logout Successfully",
            'data'    => "Nil",
        ];
        return response()->json($response, 200);
    }


    public function reset_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone'         => 'required',
            'password'      => 'required|min:6',
            'device_token'  => 'required',
        ],
        [
            'phone.required'        => 'phone Field is Required',
            'password.required'     => 'Password Field is Required',
            'password.min'          => 'Password Field is Required minimum 6 characters',
            'device_token.required' => 'device_token Field is Required',
        ]
        );
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        // user validation
        $res = User::where('phone',$request->phone)->get();
        if(!blank($res)){
            User::where('phone',$request->phone)->update([
                'password'      => Hash::make($request->password),
                'deviceToken'  => $request->device_token,
            ]);
            return response()->json([
                'status'  => 200,
                'message' => "Reset Password Successfully!",
                'data'    => "Nil"
            ], 200);
        }else{
            return response()->json([
                'status'  => 400,
                'message' => "User Not Found",
                'data'    => "Nil"
            ], 400);
        }
        
    }

}