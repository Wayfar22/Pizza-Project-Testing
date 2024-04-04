<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Pizza;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PizzaController extends Controller
{
     //direct pizza page
     public function pizza(){
        $data = Pizza::paginate(7);
        if(count($data)==0){
            $emptyStatus = 0;
        }else{
            $emptyStatus = 1;
        }
        return view('admin.pizza.list')->with(['pizza'=>$data,'status'=>$emptyStatus]);
    }

    //direct crteate pizza page
    public function createPizza(){
        $category = Category::get();
        // dd($category->toArray());
        return view('admin.pizza.create')->with(['category'=>$category]);
    }

    //Insert pizza data
    public function insertPizza(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'image'=>'required',
            'price'=>'required',
            'publish'=>'required',
            'discount'=>'required',
            'category'=>'required',
            'buyOneGetOne'=>'required',
            'waitingTime'=>'required',
            'description' => 'required',
        ],[
            'buyOneGetOne.required'=>"Choose buy one get one",
            'name.required'=>"Need to fill",
        ]);
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $file = $request->file('image');
        $fileName = uniqid()."_".$file->getClientOriginalName();
        $file->move(public_path().'/uploads/',$fileName);
        $data =$this->requestPizzaData($request,$fileName);
        Pizza::create($data);
        return redirect()->route('admin#pizza')->with(['createSuccess'=>'Pizza created....']);
    }

    //Delete pizza
    public function deletePizza($id){
        $data = Pizza::select('image')->where('pizza_id',$id)->first();
        $fileName = $data['image'];
        // dd($fileName);
        Pizza::where('pizza_id',$id)->delete();//db delete
        //photo delete
        if(File::exists(public_path().'/uploads/'.$fileName)){
            File::delete(public_path().'/uploads/'.$fileName);
        }
        return back()->with(['deleteSuccess'=>"Pizza Deleted..."]);
    }

    //Pizza Info
    public function PizzaInfo($id){
            $data = Pizza::where('pizza_id',$id)->first();
            return view('admin.pizza.info')->with(['pizza'=>$data]);
    }

    //Edit pizza
    public function editPizza($id){
    $category = Category::get();
    $data = Pizza::select('pizzas.*','categories.category_id', 'categories.category_name')
            ->join('categories','pizzas.category_id','=','categories.category_id')
            ->where('pizza_id',$id)
            ->first();
            // dd($data->toArray());
        return view('admin.pizza.edit')->with(['pizza'=>$data,'category'=>$category]);
    }

    //Update Pizza
    public function updatePizza($id, Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'price'=>'required',
            'publish'=>'required',
            'discount'=>'required',
            'category'=>'required',
            'buyOneGetOne'=>'required',
            'waitingTime'=>'required',
            'description' => 'required',
        ],[
            'buyOneGetOne.required'=>"Choose buy one get one",
            'name.required'=>"Need to fill",
        ]);
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $updateData =$this->requestUpdatePizzaData($request);

        // dd($updateData);
        if(isset($updateData['image'])){
            //get old image
            $data = Pizza::select('image')->where('pizza_id',$id)->first();
            $fileName = $data['image'];
            // dd($data->toArray());
            //delete old image
            if(File::exists(public_path().'/uploads/'.$fileName)){
                File::delete(public_path().'/uploads/'.$fileName);}
            //get new image
            $file = $request->file('image');
            $fileName = uniqid()."_".$file->getClientOriginalName();
            $file->move(public_path().'/uploads/',$fileName);

            $updateData['image'] = $fileName;

        }
            Pizza::where('pizza_id',$id)->update($updateData);
            return redirect()->route('admin#pizza')->with(['updateSuccess'=>"Pizza updated"]);
    }

    //Search Pizza
    public function pizzaSearch(Request $request){
        $searchKey = $request->table_search;
        $searchData = Pizza::orwhere('pizza_name','like','%'.$searchKey.'%')
                            ->orwhere('price','like','%'.$searchKey.'%')
                            ->paginate(7);
        // dd($request->all());
        $searchData->appends($request->all());
        // dd($searchData);
        // dd(count($searchData));
            if(count($searchData) == 0){
                $emptyStatus = 0;
            }else{
                $emptyStatus = 1;
            }
        return view('admin.pizza.list')->with(['pizza'=>$searchData,'status'=>$emptyStatus]);
    }

    //Request image for update
    private function requestUpdatePizzaData($request){
        // dd($request->all());
        $arr = [
        'pizza_name'=>$request->name,
        'price'=>$request->price,
        'publish_status'=>$request->publish,
        'category_id'=>$request->category,
        'discount_price'=>$request->discount,
        'buy_one_get_one_status'=>$request->buyOneGetOne,
        'waiting_time'=>$request->waitingTime,
        'description' => $request->description,
        'created_at'=>Carbon::now(),
        'updated_at'=>Carbon::now(),];

        if(isset($request->image)){
            $arr['image']=$request->image;
            // dd($arr);
         };
         return $arr;
    }

    //Request pizza data
    private function requestPizzaData($request,$fileName){
        return [
            'pizza_name'=>$request->name,
            'image'=>$fileName,
            'price'=>$request->price,
            'publish_status'=>$request->publish,
            'category_id'=>$request->category,
            'discount_price'=>$request->discount,
            'buy_one_get_one_status'=>$request->buyOneGetOne,
            'waiting_time'=>$request->waitingTime,
            'description' => $request->description,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ];
    }


}


