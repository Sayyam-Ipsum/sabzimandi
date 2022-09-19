<div class="d-flex justify-content-end">
    <span>Date: {{show_date(@$sale->created_at)}}</span>
</div>
<div>
    <table class="table table-sm">
        <tr class="bg-dark text-white">
            <th >Customer</th>
            <th>Phone</th>
        </tr>
        <tr>
            <td>{{@$sale->customer ? @$sale->customer->name : 'N/A'}}</td>
            <td>{{@$sale->customer ? @$sale->customer->phone ? @$sale->customer->phone : 'N/A' : 'N/A'}}</td>
        </tr>
        <tr class="bg-light">
            <th>Total</th>
            <th>{{@$sale->total}}</th>
        </tr>
    </table>

    <table class="table table-sm">
        <tr class="bg-success text-white">
            <th colspan="3">Products</th>
        </tr>
        <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Amount</th>
        </tr>
        @foreach(@$sale->items as $item)
            <tr>
                <td>{{$item->product ? $item->product->name : 'N/A'}}</td>
                <td>{{$item->quantity}} - ({{$item->product ? $item->product->unit ? $item->product->unit : 'N/A' : 'N/A'}})</td>
                <td>Rs. {{$item->amount}}</td>
            </tr>
        @endforeach
    </table>
</div>
