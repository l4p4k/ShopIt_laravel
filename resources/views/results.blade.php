@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

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
                                    @foreach($data as $data_item)
                                    @foreach($data_item as $item)
                                        <tr> 
                                            <td>
                                                <b><a href=/item/{{$item->item_id}}>{{$item->item_name}}</a><b>
                                            </td>
                                            <td class="text-right">
                                                <p>{{$item->review}}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
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
