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
                            <div class="table-responsive">
                                <table class="table" style="width:100%">
                                    <tbody>
                                        <?php $full_total = 0;?>
                                        @foreach($data as $key => $cart_item)
                                            <?php 
                                            $cart = Session::get('cart');
                                            $quantity = $cart[$key]['1'];
                                            ?>
                                            <tr> 
                                                <td>
                                                    <b><a href=/item/{{$cart_item->id}} >{{$cart_item->item_name}}</a><b> x{{$quantity}}
                                                </td>
                                                <td>
                                                    <?php 
                                                    $row_total = $cart_item->price*$quantity; 
                                                    $full_total = $full_total+$row_total;
                                                    ?>
                                                    £{{number_format((float)$row_total, 2, '.', '')}}
                                                </td>
                                                <td>
                                                    <a href=/cart_delete_item/{{$key}} class='btn btn-danger'>x</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <b>Total: £{{number_format((float)$full_total, 2, '.', '')}}</b>
                                                </td>
                                            </tr>
                                    </tbody>
                                </table>
                                <a href='/delete_cart' class='btn btn-danger'>Delete cart</a>
                                <a href=/checkout class='btn btn-info'>Checkout</a>
                            </div>
                        @endif
                    @else
                        Your cart is empty
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
