@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">New Item</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/new_item') }}" enctype="multipart/form-data">
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

                        <div class="form-group{{ $errors->has('item_name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Item name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="item_name" value="{{ old('item_name') }}">

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
                                <input type="text" class="form-control" name="price">

                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if(Session::has('error'))
                            <p class="errors">{!! Session::get('error') !!}</p>
                            <div class='alert alert-danger'> <strong>Error!</strong> {!! Session::get('error') !!} </div>
                        @elseif(Session::has('success'))
                            <div class='alert alert-success'> <strong>Success!</strong> {!! Session::get('success') !!} </div>
                        @endif
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-plus-square"></i> New item
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <div class="panel panel-default">
                <div class="panel-heading">Stats</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <p class="text-center"><b>Lowest rated products<b></p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th> 
                                    <th>Rating</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lowest_rated as $rate)
                                    <tr>
                                        <td><a href=/item/{{$rate->id}}>{{$rate->item_name}}</a></td>
                                        <td>£{{$rate->price}}</td>
                                        <td>{{$rate->rating}}/5</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                        <p class="text-center"><b>Lowest stocked products<b></p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th> 
                                    <th>Stock</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lowest_stock as $stock)
                                    <tr>
                                        <td><a href=/item/{{$stock->id}}>{{$stock->item_name}}</a></td>
                                        <td>£{{$stock->price}}</td>
                                        <td>{{$stock->item_quantity}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <p class="text-center"><b>Most bulk buys<b></p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Items bought in bulk</th> 
                                    <th>Stock</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($most_bulk as $bulk_buy)
                                    <tr>
                                        <td><a href=/item/{{$bulk_buy->id}}>{{$bulk_buy->item_name}}</a></td>
                                        <td>{{$bulk_buy->quantity}}</td>
                                        <td>{{$bulk_buy->item_quantity}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
