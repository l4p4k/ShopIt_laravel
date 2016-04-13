<style>
.key {
    background-color: black;
    color: white;
    font-family: Arial, Helvetica, Sans-serif;
    font-size: 16;
    text-align: center;
} 
p,h1 {
    font-family: Arial, Helvetica, Sans-serif;
}
</style>
<h1>Shop it!</h1>
<p>Thank you for shopping with us</p>
<p>Here are your items:</p>

<!-- initialise variable -->
<?php $full_total = 0;?>
@foreach($cart_details as $key => $cart_item)
    <p>+ {{$cart_item->item_name}}
    <?php 
    $cart = Session::get('cart');
    $quantity = $cart[$key]['1'];
    ?> =

    <!-- get price and total -->
    <?php 
    $row_total = $cart_item->price*$quantity; 
    $full_total = $full_total+$row_total;
    ?>
    £{{number_format((float)$cart_item->price, 2, '.', '')}}

    x{{$quantity}}
    </p>

@endforeach
    <p>
        <b>Total: £{{number_format((float)$full_total, 2, '.', '')}}</b>
    </p>
<br>
<p><b>Please show this code in-store to collect your items:</b></p>
<div class="key">
    {{$code}}
</div>
