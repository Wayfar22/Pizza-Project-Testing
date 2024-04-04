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
                  <legend class="text-center">Pizza Info</legend>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane " id="activity">
                        <div class="row">
                            <div class="col-sm-6 mt-2 pr-2 text-center">
                                <img class="rounded-circle " src="{{asset('uploads/'.$pizza->image)}}" style="width:200px; height:200px">
                            </div>

                            <div class="col-sm-6 mt-2 pl-3">
                                <div class="mt-2">
                                    <b>Name</b> : <span>{{$pizza->pizza_name}}</span>
                                </div>
                                <div class="mt-2">
                                    <b>Price</b> : <span>{{$pizza->price}} Ks</span>
                                </div>
                                <div class="mt-2">
                                    <b>Publish Status</b> :
                                    <span>
                                        @if ($pizza->publish_status ==1)
                                            YES
                                        @else
                                            NO
                                        @endif</span>
                                </div>
                                <div class="mt-2">
                                    <b>Category</b> : <span>{{$pizza->category_id}}</span>
                                </div>
                                <div class="mt-2">
                                    <b>Dscount Price</b> : <span>{{$pizza->discount_price}} Ks</span>
                                </div>
                                <div class="mt-2">
                                    <b>Buy one get one</b> :
                                    <span>
                                        @if ($pizza->buy_one_get_one_status ==1)
                                            YES
                                        @else
                                            NO
                                        @endif
                                    </span>
                                </div>
                                <div class="mt-2">
                                    <b>Waiting Time</b> : <span>{{$pizza->waiting_time}}</span>
                                </div>
                                <div class="mt-2">
                                    <b>Description</b> : <span>{{$pizza->description}}</span>
                                </div>
                            </div>

                        </div>

                            <form method="get" action="{{route('admin#pizza')}}"><button type="submit" class="btn bg-primary text-white float-end me-3 mt-3">Back</button></form>
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
