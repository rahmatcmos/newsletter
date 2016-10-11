@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title or config('app.name') }}</div>
                <div class="panel-body">
                    @include('partials.message')

                    <table class="table">
                        <thead>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Send Date</th>
                            <th>Create Date</th>
                            <th class="text-right">Actions</th>
                        </thead>
                        <tbody>
                            @foreach ($newsletters as $newsletter)
                                <td><a href="{{ route('admin.newsletter.detail', $newsletter->id) }}">{{ $newsletter->title }}</a></td>
                                <td>{{ $newsletter->description }}</td>
                                <td>{{ $newsletter->status }}</td>
                                <td>{{ $newsletter->sent_at->format(config('date.format')) }}</td>
                                <td>{{ $newsletter->created_at->format(config('date.format')) }}</td>
                                <td class="text-right">
                                    <a href="" class="btn btn-primary" title="Send newsletter"><i class="fa fa-envelope"></i></a>
                                    <a href="" class="btn btn-default" title="Edit current item"><i class="fa fa-edit"></i></a>
                                    <a href="" class="btn btn-danger" title="Delete current item"><i class="fa fa-trash"></i></a>
                                </td>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $newsletters->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection