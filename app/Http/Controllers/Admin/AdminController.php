<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

        //direct admin profile
        public function profile(){
            $id= auth()->user()->id;
            $userData = User::where('id',$id)->first();
            // dd($userData->toArray());
            return view('admin.profile.index')->with(['user'=>$userData]);
        }

        public function updateProfile($id,Request $request){
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required',
            ]);
            if ($validator->fails()) {
                return back()
                            ->withErrors($validator)
                            ->withInput();
            }
            $data = [
                'category_name'=>$request->name,
            ];

            $updateData = $this->requestUserData($request);
           User::where('id',$id)->update($updateData);
           return back()->with(['updateSuccess'=>"User info updated...."]);
        }

        //Change password
        public function changePassword($id, Request $request){
            $validator = Validator::make($request->all(), [
                'oldPassword' => 'required',
                'newPassword' => 'required',
                'confirmPassword' => 'required',

            ]);
            if ($validator->fails()) {
                return back()
                            ->withErrors($validator)
                            ->withInput();
            }
            $data = User::where('id',$id)->first();
            $oldPassword = $request->oldPassword;
            $newPassword = $request->newPassword;
            $confirmPassword = $request->confirmPassword;
            $hashedPassword = $data['password'];

            if(Hash::check($oldPassword,$hashedPassword)){
                if($newPassword !=$confirmPassword){
                    return back()->with(['notSameError'=>'New passwords does not match!']);
                }else{
                    if(strlen($newPassword)<=6 || strlen($confirmPassword)<=6){
                        return back()->with(['LengthError'=>'Passwords must be greater than 6!']);
                    }else{
                    //change password
                    $hash = Hash::make($newPassword);
                    User::where('id',$id)->update([
                         'password'=>$hash,
                     ]);
                     return back()->with(['success'=>'Password Changed...']);
                    }
                }
            }else{
                dd('password not match');
                return back()->with(['notMatchError'=>'Old Password does not match!']);
            }
        }

        //change Password Page
        public function changePasswordPage(){
            return view('admin.profile.changePassword');
        }
        //Private Func
        private function requestUserData($request){
            return [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
            ];
        }
}
