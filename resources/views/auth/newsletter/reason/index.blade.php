@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title or config('app.name') }}</div>
                <div class="panel-body">
                    @include('partials.message')

                    <a href="" class="btn btn-primary create"><i class="fa fa-plus"></i> Create New</a>
                    <hr>
                    
                    <table class="table">
                        <thead>
                            <th>Text</th>
                            <th class="text-right">Actions</th>
                        </thead>
                        <tbody>
                            @foreach ($reasons as $reason)
                                <tr>
                                    <td>{{ $reason->description }}</td>
                                    <td class="text-right">
                                        <a href="" class="btn btn-default"><i class="fa fa-edit"></i></a>
                                        <a href="" class="btn btn-danger delete"><i class="fa fa-trash"></i></a>
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