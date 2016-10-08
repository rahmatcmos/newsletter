@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title or config('app.name') }}</div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Primary</th>
                            <th>Create Date</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                                <tr>
                                    <td>{{ $list->name }}</td>
                                    <td>{{ $list->description }}</td>
                                    <td>
                                        @if ($list->is_default)
                                            <span class="label label-success">Yes</span>
                                        @else
                                            <span class="label label-danger">No</span>
                                        @endif
                                    </td>
                                    <td>{{ $list->created_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection