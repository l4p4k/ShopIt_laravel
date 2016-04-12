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
                                <th><form method="POST" action="{{ route('index') }}"> {!! csrf_field() !!}<input type="hidden" name="filter" value="Item_name"><input type="submit" value="Item"></th> </form>
                                <th><form method="POST" action="{{ route('index') }}"> {!! csrf_field() !!}<input type="submit" name="filter" value="Price"></th> </form>
                                <th><form method="POST" action="{{ route('index') }}"> {!! csrf_field() !!}<input type="submit" name="filter" value="review"></th> </form>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                        <tr> 
                                            <!-- item name with link to view item -->
                                            <td>
                                                 <a href=/item/{{$item->item_id}}>
                                                    {{$item->item_name}}
                                                </a>
                                            </td> 
                                            <!-- Price of item -->
                                            <td>
                                                £{{$item->price}}
                                            </td> 
                                            <!-- item review out of 10 -->
                                            <td>
                                                @if(!$item->review == 0)
                                                {{$item->review}}/10
                                                @else
                                                No score
                                                @endif
                                            </td> 
                                        </tr>
                                @endforeach
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
