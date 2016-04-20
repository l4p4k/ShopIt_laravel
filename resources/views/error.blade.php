@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Error</div>

                <div class="panel-body">
                    @if($data != null)
                        <h2>-- {{$data}} --</h2>
                    @else
                        <h2>Wooooooooo... leave now!</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
