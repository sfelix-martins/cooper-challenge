<div class="table-responsive">
    <table class="table" id="orders-table">
        <thead>
            <tr>
                <th>Product Id</th>
        <th>Amount</th>
        <th>Value</th>
        <th>Ordered At</th>
        <th>Requester Name</th>
        <th>Requester.address</th>
        <th>Forwarding Agent Name</th>
        <th>Status</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{!! $order->product_id !!}</td>
            <td>{!! $order->amount !!}</td>
            <td>{!! $order->value !!}</td>
            <td>{!! $order->ordered_at !!}</td>
            <td>{!! $order->requester_name !!}</td>
            <td>{!! $order->requester.address !!}</td>
            <td>{!! $order->forwarding_agent_name !!}</td>
            <td>{!! $order->status !!}</td>
                <td>
                    {!! Form::open(['route' => ['orders.destroy', $order->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('orders.show', [$order->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('orders.edit', [$order->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
