@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{$result_count}} results found</div>

                <div class="panel-body">
                    @if($data != null)
                        <div class="table-responsive">
                            <table class="table" style="width:100%">
                                <thead>
                                    <tr>
                                    <th class="col-md-6">Item</th> 
                                    <th class="col-md-3 text-right">Review</th>
                                    </tr>
                                </thead> 
                                <tbody>
                                    @foreach($data as $item)
                                        <tr> 
                                            <td>
                                                <b><a href=/item/{{$item->id}}>{{$item->item_name}}</a><b>
                                            </td>
                                            <td class="text-right">
                                                <p>
                                                    @if($item->rating != "0.00")
                                                        {{$item->rating}}/5
                                                    @else
                                                        -- No rating --
                                                    @endif
                                                </p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- make links to go to other pages -->
                            {{ $data->appends(Request::except('page'))->render() }}
                        </div>
                    @else
                    No posts were found with that keyword
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
