<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $order->id !!}</p>
</div>

<!-- Product Id Field -->
<div class="form-group">
    {!! Form::label('product_id', 'Product Id:') !!}
    <p>{!! $order->product_id !!}</p>
</div>

<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{!! $order->amount !!}</p>
</div>

<!-- Value Field -->
<div class="form-group">
    {!! Form::label('value', 'Value:') !!}
    <p>{!! $order->value !!}</p>
</div>

<!-- Ordered At Field -->
<div class="form-group">
    {!! Form::label('ordered_at', 'Ordered At:') !!}
    <p>{!! $order->ordered_at !!}</p>
</div>

<!-- Requester Name Field -->
<div class="form-group">
    {!! Form::label('requester_name', 'Requester Name:') !!}
    <p>{!! $order->requester_name !!}</p>
</div>

<!-- Requester Address Field -->
<div class="form-group">
    {!! Form::label('requester_address', 'Requester Address:') !!}
    <p>{!! $order->displayRequesterAddress() !!}</p>
</div>

<!-- Forwarding Agent Name Field -->
<div class="form-group">
    {!! Form::label('forwarding_agent_name', 'Forwarding Agent Name:') !!}
    <p>{!! $order->forwarding_agent_name !!}</p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    <p>{!! $order->displayStatus() !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $order->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $order->updated_at !!}</p>
</div>

