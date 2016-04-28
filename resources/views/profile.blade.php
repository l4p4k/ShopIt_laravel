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
                        <p><b>Email: </b> @if($data[0]->email != null) {{$data[0]->email}} @else --- @endif</p>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Phone number</label>
                            <div class="col-md-4">
                                <input type="phone" class="form-control" name="phone" value=
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
                                <input type="postcode" class="form-control" name="postcode" value=
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
        </div>
    </div>
</div>
@endsection
