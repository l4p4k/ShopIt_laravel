@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    Welcome to SHOPIT!

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                <th><a href="<?php Request::root(); ?>/filter/name">Name</a></th> 
                                <th><a href="<?php Request::root(); ?>/filter/price">Price</a></th>
                                <th><a href="<?php Request::root(); ?>/filter/review">Review</a></th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($data as $key => $item) {
                                        echo "<tr> <td>";
                                        $str = $item['name'];
                                        echo wordwrap($str,50,"<br>\n");
                                        echo "</td> <td>";
                                        $str = "£".$item['price'];
                                        echo wordwrap($str,50,"<br>\n");
                                        echo"</td> <td>";
                                        echo $item['review']."/10";
                                        echo "</td> </tr>";
                                    }
                                ?>
                            </tbody>
                        </table>

                        <?php
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
