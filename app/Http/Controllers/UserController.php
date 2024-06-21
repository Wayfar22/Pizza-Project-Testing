<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //direct user home page
    public function index(){
        return view('user.home');
    }

    //direct user List page
    public function userList(){
        $userData = User::where('role','user')->paginate(7);
        return view('admin.user.userList')->with(['user'=>$userData]);
    }

     //direct user List page
     public function adminList(){
        $userData = User::where('role','admin')->paginate(7);
        return view('admin.user.adminList')->with(['admin'=>$userData]);
    }

    // //User Search
    // public function userSearch(Request $request){
    //     $key = $request->searchData;
    //     $searchData = User::where('role','user')
    //                     ->where(function($query) use ($key){
    //                         $query->orWhere('name','like','%'.$key.'%')
    //                         ->orWhere('email','like','%'.$key.'%')
    //                         ->orWhere('phone','like','%'.$key.'%')
    //                         ->orWhere('address','like','%'.$key.'%');
    //                     })
    //                         ->paginate(7);

    //     $searchData->appends($request->all());
    //     return view('admin.user.userList')->with(['user'=>$searchData]);
    // }

    // //Admin Search
    // public function adminSearch(Request $request){
    //     $key = $request->searchData;
    //     $searchData = User::where('role','admin')
    //                     ->where(function($query) use ($key){
    //                         $query->orWhere('name','like','%'.$key.'%')
    //                         ->orWhere('email','like','%'.$key.'%')
    //                         ->orWhere('phone','like','%'.$key.'%')
    //                         ->orWhere('address','like','%'.$key.'%');
    //                     })
    //                         ->paginate(7);

    //     $searchData->appends($request->all());
    //     return view('admin.user.adminList')->with(['admin'=>$searchData]);
    // }

     //User Search
     public function userSearch(Request $request){
        $response = $this->searching($request,'user');
        return view('admin.user.userList')->with(['user'=>$response]);
    }

    //Admin Search
    public function adminSearch(Request $request){
       $response = $this->searching($request,'admin');
        return view('admin.user.adminList')->with(['admin'=>$response]);
    }

    //Admin/user Search
    private function searching($request,$role){
                $searchData = User::where('role',$role)
                        ->where(function($query) use ($request){
                            $query->orWhere('name','like','%'.$request->searchData.'%')
                            ->orWhere('email','like','%'.$request->searchData.'%')
                            ->orWhere('phone','like','%'.$request->searchData.'%')
                            ->orWhere('address','like','%'.$request->searchData.'%');
                        })
                        ->paginate(7);
        $searchData->appends($request->all());
        return $searchData;
    }

    //userDelete
    public function userDelete($id){
        User::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>'User Deleted!.....']);
    }
}
