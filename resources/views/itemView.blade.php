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
                        <img src="/uploads/{{$data->item_id}}.png" alt="no image" width="300" height="300">
                    @else
                        <img src="/site_images/no image.png" alt="no image" width="300" height="300">
                    @endif
                    <h3>£{{$data->price}}</h3>
                    <p>Review: 
                        @if(!$data->review == 0)
                        {{$data->review}}/10
                        @else
                        -- No score --
                        @endif
                    </p>
                    <form class="form-inline" role="form" method="post" action="{{ url('/add_to_cart') }}">
                        {!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                            <label class="control-label">Quantity</label>

                            <input type="text" class="form-control" name="quantity" value="{{ old('quantity') }}">

                            @if ($errors->has('quantity'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('quantity') }}</strong>
                                </span>
                            @endif
                        </div>

                        <input type="hidden" name="item_id" value="{{$data->item_id}}">

                        <div class="form-group">
                            <button type="submit" class="btn">
                                <i class="fa fa-shopping-basket" aria-hidden="true"></i> Add to cart
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <!-- WIP: Make an error route to redirect to -->
            <h1>ERROR</h1>
            @endif
        </div>
    </div>
</div>
@endsection
