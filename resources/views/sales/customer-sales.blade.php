
@if(sizeof($sales) > 0)
    <div class="accordian">
        @foreach(@$sales as $key => $sale)
            <div class="border-1 m-1">
                <div class="">
                    <button class="btn btn-success w-100 d-flex justify-content-between align-items-center"
                            type="button"
                            data-toggle="collapse"
                            data-target="#my{{$key}}"
                            aria-expanded="{{$key == 0 ? 'true' : 'false'}}"
                            aria-controls="my{{$key}}">
                        <div class="w-50 d-flex justify-content-between align-items-center">
                            <span>{{$key+1}} - {{showDateTime($sale->created_at)}}</span>
                            <span class="font-weight-bold">Total: {{$sale->total}}</span>
                        </div>
                        <i class="fa fa-chevron-down"></i>
                    </button>
                </div>
                <div id="my{{$key}}" class="collapse {{$key == 0 ? 'show' : 'false'}}">
                    <div class="accordion-body p-1 m-1 shadow-sm border">
                        <table class="table table-sm">
                            <tr class="bg-light">
                                <th colspan="3">Products</th>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                            </tr>
                            @if(sizeof($sale->items) > 0)
                                @foreach(@$sale->items as $item)
                                    <tr>
                                        <td>{{$item->product ? $item->product->name : 'N/A'}}</td>
                                        <td>{{$item->quantity}} - ({{$item->product ? $item->product->unit ? $item->product->unit->name : 'N/A' : 'N/A'}})</td>
                                        <td>Rs. {{$item->amount}}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="bg-light">
                                    <th colspan="3">No Items Found!</th>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div>
        <p class="text-center">No Sale Found!</p>
    </div>
@endif


