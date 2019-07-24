<!-- Product Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('product_id', 'Product:') !!}
    {!! Form::select('product_id', $products, null, ['class' => 'form-control'])  !!}
</div>

<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Requester Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('requester_name', 'Requester Name:') !!}
    {!! Form::text('requester_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Requester Address Zipcode Field -->
<div class="form-group col-sm-6">
    {!! Form::label('requester_address[zipcode]', 'Requester Zipcode:') !!}
    {!! Form::text('requester_address[zipcode]', null, ['class' => 'form-control']) !!}
</div>

<!-- Requester Address Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('requester_address[address]', 'Requester Address:') !!}
    {!! Form::text('requester_address[address]', null, ['class' => 'form-control']) !!}
</div>

<!-- Requester Address UF Field -->
<div class="form-group col-sm-6">
    {!! Form::label('requester_address[uf]', 'Requester UF:') !!}
    {!! Form::text('requester_address[uf]', null, ['class' => 'form-control']) !!}
</div>

<!-- Requester Address City Field -->
<div class="form-group col-sm-6">
    {!! Form::label('requester_address[city]', 'Requester City:') !!}
    {!! Form::text('requester_address[city]', null, ['class' => 'form-control']) !!}
</div>

<!-- Requester Address Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('requester_address[number]', 'Requester Number:') !!}
    {!! Form::text('requester_address[number]', null, ['class' => 'form-control']) !!}
</div>

<!-- Forwarding Agent Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('forwarding_agent_name', 'Forwarding Agent Name:') !!}
    {!! Form::text('forwarding_agent_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
@if (request()->routeIs('orders.edit'))
    <div class="form-group col-sm-6">
        {!! Form::label('status', 'Status:') !!}
        {!! Form::select('status', $statuses, null, ['class' => 'form-control']) !!}
    </div>
@endif

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('orders.index') !!}" class="btn btn-default">Cancel</a>
</div>
