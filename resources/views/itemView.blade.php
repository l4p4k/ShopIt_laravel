@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if($data!=NULL)
                <div class="panel panel-default">
                    <div class="panel-heading">{{$data->item_name}}</div>

                    <div class="panel-body">
                        @if($data->item_image)
                            <img src="/uploads/{{$data->id}}.png" alt="no image" width="300" height="300">
                        @else
                            <img src="/site_images/no image.png" alt="no image" width="300" height="300">
                        @endif
                        <h3>£{{$data->price}}</h3>
                        <p>Rating: 
                        @if($data->rating != "0.00")
                            <b>{{$data->rating}}/5</b> from <b>{{$ratings}}</b> votes
                        @else
                            -- No rating --
                        @endif
                        </p>
                        @if($data->item_quantity != 0)
                            <form class="form-inline" role="form" method="post" action="{{ url('/add_to_cart') }}">
                                {!! csrf_field() !!}
                                <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                                    <label class="control-label">Quantity/{{$data->item_quantity}}</label>

                                    <input type="text" class="form-control" name="quantity" value="{{ old('quantity') }}">

                                    @if($errors->has('quantity'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('quantity') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <input type="hidden" name="item_id" value="{{$data->id}}">

                                <div class="form-group">
                                    <button type="submit" class="btn">
                                        <i class="fa fa-shopping-basket" aria-hidden="true"></i> Add to cart
                                    </button>
                                </div>
                            </form>
                        @else
                            <p><i>Out of stock</i></p>
                        @endif
                    </div>
                </div>

                <!-- user can rate if they have bought item before -->
                @if(Session::has('bought'))
                    <div class="panel panel-default">
                        <div class="panel-heading">Rate</div>

                        <div class="panel-body">
                            @if(!Session::has('rating'))
                                <form class="form-inline" role="form" method="post" action="{{ url('/rate') }}">
                                    {!! csrf_field() !!}
                                    <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                                        <label class="control-label">Rate this item:</label>

                                        <select name="rating">
                                            <option value=5>Awesome!</option>
                                            <option value=4>Good</option>
                                            <option value=3>Ok!</option>
                                            <option value=2>Bad</option>
                                            <option value=1>Very bad!</option>
                                        </select>

                                        @if($errors->has('quantity'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('quantity') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <input type="hidden" name="item_id" value="{{$data->id}}">

                                    <div class="form-group">
                                        <button type="submit" class="btn">
                                            Rate
                                        </button>
                                    </div>
                                </form>
                            @else
                                <p><i>You have rated {{Session::get('rating')}}</i></p>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Admin tools to change the item -->
                @if(!Auth::guest())
                    @if(Auth::user()->admin == 1)
                        <div class="panel panel-default">
                            <div class="panel-heading">Admin tools</div>

                            <div class="panel-body">
                                @if(Session::has('error'))
                                    <p class="errors">{!! Session::get('error') !!}</p>
                                    <div class='alert alert-danger'> <strong>Error!</strong> {!! Session::get('error') !!} </div>
                                @elseif(Session::has('success'))
                                    <div class='alert alert-success'> <strong>Success!</strong> {!! Session::get('success') !!} </div>
                                @endif

                                <form class="form-horizontal" role="form" method="POST" action="{{ url('/change_item') }}" enctype="multipart/form-data">
                                    {!! csrf_field() !!}

                                    <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label">Item picture </label>(max size: 2MB)

                                        <div class="col-md-6">
                                            <input type="file" class="form-control" name="image" id="image" value="{{ old('image') }}">

                                            @if ($errors->has('image'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('image') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <input type="hidden" name="change_type" value="image">
                                    <input type="hidden" name="item_id" value="{{$data->id}}">

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary"> Change item image
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <form class="form-horizontal" role="form" method="POST" action="{{ url('/change_item') }}">
                                    {!! csrf_field() !!}
                                    <div class="form-group{{ $errors->has('item_name') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label">Item name</label>

                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="item_name" value=
                                            @if(old('item_name')!=null) 
                                                "{{ old('item_name') }}"
                                            @else 
                                                @if($data->item_name != null)
                                                    "{{$data->item_name}}"
                                                @else 
                                                    ''
                                                @endif
                                            @endif>

                                            @if ($errors->has('item_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('item_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label">Price</label>

                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="price" value=
                                            @if(old('price')!=null) 
                                                "{{ old('price') }}"
                                            @else 
                                                @if($data->price != null)
                                                    "{{$data->price}}"
                                                @else 
                                                    ''
                                                @endif
                                            @endif>

                                            @if ($errors->has('price'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('price') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <input type="hidden" name="change_type" value="details">
                                    <input type="hidden" name="item_id" value="{{$data->id}}">

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">Change item details
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                @if($data->item_quantity == 0)
                                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/add_stock') }}">
                                        {!! csrf_field() !!}
                                        <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                                            <label class="col-md-4 control-label">Amount</label>

                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="quantity" value="{{ old('quantity') }}">

                                                @if ($errors->has('quantity'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('quantity') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <input type="hidden" name="item_id" value="{{$data->id}}">

                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-4">
                                                <button type="submit" class="btn btn-primary">Add stock
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                @endif
                                <a href='/item_delete/{{$data->id}}' class='btn btn-danger'>Delete item</a>
                            </div>
                        </div>
                    @endif
                @endif
            <!-- else if no data is present -->
            @else
            <!-- WIP: Make an error route to redirect to -->
            <h1>ERROR</h1>
            @endif
        </div>
    </div>
</div>
@endsection
