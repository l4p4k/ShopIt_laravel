@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    Welcome to SHOPIT!
                    <p>Sort:</p>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td><form method="GET" action="{{ route('index') }}"><input type="hidden" name="filter" value="item_name"><input type="hidden" name="order" value="asc"><input type="submit" value="Asc Item name"></form></td>
                                <td><form method="GET" action="{{ route('index') }}"><input type="hidden" name="filter" value="item_name"><input type="hidden" name="order" value="desc"><input type="submit" value="Desc Item name"></form></td>
                            </tr><tr>
                                <td><form method="GET" action="{{ route('index') }}"><input type="hidden" name="filter" value="price"><input type="hidden" name="order" value="asc"><input type="submit" value="Lowest price"></form></td>
                                <td><form method="GET" action="{{ route('index') }}"><input type="hidden" name="filter" value="price"><input type="hidden" name="order" value="desc"><input type="submit" value="Highest price"></form></td>
                            </tr><tr>
                                <td><form method="GET" action="{{ route('index') }}"><input type="hidden" name="filter" value="review"><input type="hidden" name="order" value="desc"><input type="submit" value="Best review"></form></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Item</th> 
                                    <th>Price</th> 
                                    <th>Review</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                    <tr> 
                                        <td>
                                            @if($item->item_image)
                                                <img src="/uploads/{{$item->id}}.png" alt="no image" width="100" height="100">
                                            @else
                                                <img src="/site_images/no image.png" alt="no image" width="100" height="100">
                                            @endif
                                        </td>
                                        <!-- item name with link to view item -->
                                        <td>
                                             <a href=/item/{{$item->id}}>
                                                {{$item->item_name}}
                                            </a>
                                        </td> 
                                        <!-- Price of item -->
                                        <td>
                                            £{{$item->price}}
                                        </td> 
                                        <!-- item review out of 10 -->
                                        <td>
                                            @if(!$item->rating == 0)
                                            {{$item->rating}}/5
                                            @else
                                            No score
                                            @endif
                                        </td> 
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    {{ $data->appends(Request::except('page'))->render() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
