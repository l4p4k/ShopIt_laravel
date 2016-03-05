@extends('layouts.app')
<?php
use Faker\Factory as Faker;
?>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    Your Application's Landing Page.
                    <?php
                    $faker = Faker::create();
                    echo "<br>Random Number 0 to 999.99 = ".$faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 999);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
