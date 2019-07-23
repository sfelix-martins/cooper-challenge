<!-- Product Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('product_id', 'Product Id:') !!}
    {!! Form::text('product_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Value Field -->
<div class="form-group col-sm-6">
    {!! Form::label('value', 'Value:') !!}
    {!! Form::number('value', null, ['class' => 'form-control']) !!}
</div>

<!-- Ordered At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ordered_at', 'Ordered At:') !!}
    {!! Form::date('ordered_at', null, ['class' => 'form-control','id'=>'ordered_at']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#ordered_at').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- Requester Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('requester_name', 'Requester Name:') !!}
    {!! Form::text('requester_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Requester.address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('requester.address', 'Requester.address:') !!}
    {!! Form::text('requester.address', null, ['class' => 'form-control']) !!}
</div>

<!-- Forwarding Agent Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('forwarding_agent_name', 'Forwarding Agent Name:') !!}
    {!! Form::text('forwarding_agent_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::text('status', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('orders.index') !!}" class="btn btn-default">Cancel</a>
</div>
