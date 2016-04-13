@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">My cart</div>

                <div class="panel-body">
                    @if($data != null)
                        @if(Session::has('cart'))
                            @foreach(Session::get('cart') as $cart_item)
                            <?php $item_id = $cart_item['0']; ?>
                                {{$data[$item_id]->item_name}}x{{$cart_item['1']}}
                                <br>
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
