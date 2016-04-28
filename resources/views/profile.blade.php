@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Profile</div>
                <div class="panel-body">
                    @if(Session::has('messageStatus'))
                        @if(Session::get('messageStatus') == 'success')
                            <div class='alert alert-success'> <strong>Success!</strong> Your details have been updated</div>
                            @else
                            <div class='alert alert-danger'> <strong>Oops!</strong> Please fix any errors and try submitting again</div>                            
                        @endif  
                    @endif 
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('profile.edit') }}">
                        {!! csrf_field() !!}
                        <p><b>User ID: </b> {{$data[0]->id}}</p>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">email</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="email" value=
                                @if(old('email')!=null) 
                                    "{{ old('email')}}"
                                @else 
                                    @if($data[0]->email != null)
                                        "{{$data[0]->email}}"
                                    @else 
                                        ''
                                    @endif
                                @endif>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Phone number</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="phone" value=
                                @if(old('phone')!=null) 
                                    {{ old('phone') }}
                                @else 
                                    @if($data[0]->phone != null)
                                        {{$data[0]->phone}}
                                    @else 
                                        ''
                                    @endif
                                @endif>

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('postcode') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Postcode</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="postcode" value=
                                @if(old('postcode')!=null) 
                                    "{{ old('postcode')}}"
                                @else 
                                    @if($data[0]->postcode != null)
                                        "{{$data[0]->postcode}}"
                                    @else 
                                        ''
                                    @endif
                                @endif>

                                @if ($errors->has('postcode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('postcode') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-0">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-cog"></i> Change profile settings</a>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Items bought</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th> 
                                    <th>Price</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data[1] as $item)
                                    <tr>
                                        <td><a href=/item/{{$item->id}}>{{$item->item_name}}</a></td>
                                        <td>{{$item->quantity}}</td>
                                        <td>£{{$item->price}}</td>
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
