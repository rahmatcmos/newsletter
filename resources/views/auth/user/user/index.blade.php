@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title or config('app.name') }}</div>
                <div class="panel-body">
                    @include('partials.message')

                    <form action="{{ url()->current() }}" method="get" role="form">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon3">Search for:</span>
                            <input type="text" class="form-control" name="query" value="{{ request('query') }}">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </span>
                        </div>
                    </form>

                    <table class="table">
                        <thead>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Create Date</th>
                            <th class="text-right">Actions</th>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        {{ $user->name }}
                                        @if ($user->id == auth()->user()->id)
                                            <span class="label label-info">It's You!</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('d.m.Y H.i') }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-default"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('admin.user.delete', $user->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection