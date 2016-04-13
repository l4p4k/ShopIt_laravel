@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">My cart</div>

                <div class="panel-body">
                    @if($data != null)
                        <div class="table-responsive">
                            <table class="table" style="width:100%">
                                <tbody>
                                @if(Session::has('cart'))
                                    @foreach($data as $key => $cart_item)
                                        <?php 
                                        $cart = Session::get('cart');
                                        $quantity = $cart[$key]['1'];
                                        ?>
                                        <tr> 
                                            <td>
                                                
                                                <b><a href=/item/{{$cart_item->item_id}}>{{$cart_item->item_name}}</a><b> x{{$quantity}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <a href='/delete_cart' class='btn btn-danger'>Delete cart</a>
                                @else
                                    Your cart is empty
                                @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
