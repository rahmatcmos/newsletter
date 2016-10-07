@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title or config('app.name') }}</div>

                <div class="panel-body">
                	@if ($subscribers->total() === 0)
                		<div class="alert alert-info">There is no people subscribed subscriber.</div>
                	@endif

                    <a href="" class="btn btn-primary"> <i class="fa fa-plus"></i> Create New</a>
                    <a href="" class="btn btn-default"> <i class="fa fa-file-excel-o"></i> Export</a>
                    <a href="" class="btn btn-default"> <i class="fa fa-file-excel-o"></i> Import</a>
                    <a href="" class="btn btn-danger"> <i class="fa fa-trash"></i> Truncate</a>

                    <table class="table table-border">
                    	<thead>
                            <th><input type="checkbox"></th>
                    		<th>Name</th>
                    		<th>Email</th>
                    		<th>Status</th>
                    		<th>Actions</th>
                    	</thead>
                    	@foreach ($subscribers as $subscriber)
                    	<tr class="{{ $subscriber->status === 'unsubscribed' ? 'text-muted' : '' }}">
                            <td><input type="checkbox" value="{{ $subscriber->id }}"></td>
                    		<td>{{ $subscriber->name }}</td>
                    		<td>{{ $subscriber->email }}</td>
                    		<td><span class="label label-{{ $labels[$subscriber->status] }}">{{ $subscriber->status }}</span></td>
                    		<td>
                                <a href="" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                    			<a href="" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    		</td>
                    	</tr>
                    	@endforeach
                    </table>

                    {{ $subscribers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection