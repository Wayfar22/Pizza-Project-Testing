@extends('admin.layout.app')

@section('content')

<div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-8 offset-3 mt-5">
            <div class="col-md-9">
              <div class="card">
                <div class="card-header p-2">
                  <legend class="text-center">User Profile</legend>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <form class="form-horizontal" method="post" action="{{route('admin#updateCategory')}}">
                        @csrf
                        <div class="form-group row">
                          <label for="inputName" class="col-sm-2 col-form-label">Category Name</label>
                          <div class="col-sm-10">
                            <input type="hidden" name="id" value="{{$category->category_id}}">
                            <input type="text" class="form-control" placeholder="Name" name="name" value="{{$category->category_name}}">
                            @if ($errors->has('name'))
                            <p class="text-danger">{{$errors->first()}}</p>
                          @endif
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10 ">
                            <button type="submit" class="btn bg-dark text-white float-end">Update</button>                      </form>

                            <form method="get" action="{{route('admin#category')}}"><button type="submit" class="btn bg-danger text-white float-end me-3">Cancel</button></form>
                          </div>
                        </div>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

@endsection
