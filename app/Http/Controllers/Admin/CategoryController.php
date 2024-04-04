<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    // //direct admin home page
    // public function index(){
    //     return view('admin.home');
    // }


    //direct admin profile
    public function category(){
        $data = Category::paginate(7);
        // dd($data->toArray());
        return view('admin.category.list')->with(['category'=>$data]);
    }

    public function addCategory(){
        return view('admin.category.addCategory');
    }

    public function createCategory(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = [
            'category_name'=>$request->name,
        ];
        Category::create($data);
        return redirect()->route('admin#category')->with(['categorySuccess'=>"Category Added...."]);
    }
    //deletecategory
    public function deleteCategory($id){
        // dd($id);
        Category::where('category_id',$id)->delete();
        return back()->with(['deleteSuccess'=>"Category Deleted!"]);
    }
    //editCategory
    public function editCategory($id){
          $data = Category::where('category_id',$id)->first();
        //   dd($data->toArray());
          return view('admin.category.updateCategory')->with(['category'=>$data]);
    }

    public function updateCategory(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $updateData = [
            'category_name'=>$request->name,
        ];
        Category::where('category_id',$request->id)->update($updateData);

        return redirect()->route('admin#category')->with(['updateSuccess'=>"Category updated..."]);
        }

    //search Category
    public function searchCategory(Request $request){
        $data = Category::where('category_name','like','%'.$request->searchData.'%')->paginate(7);
        $data->appends($request->all());
        return view('admin.category.list')->with(['category'=>$data]);
    }


}
