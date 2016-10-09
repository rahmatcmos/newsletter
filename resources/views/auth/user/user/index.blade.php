@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title or config('app.name') }}</div>
                <div class="panel-body">
                    @include('partials.message')

                    <p>
                        <a href="{{ route('admin.user.create') }}" class="btn btn-primary create"><i class="fa fa-plus"> </i> Create New User</a>
                    </p>

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
                                        <a href="{{ route('admin.user.delete', $user->id) }}" class="btn btn-danger delete {{ auth()->user()->id == $user->id ? 'disabled' : '' }}"><i class="fa fa-trash"></i></a>
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

<div id="delete-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Warning</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure wan to delete this user? This action can't be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger delete"> <i class="fa fa-trash"></i> Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(function(){
        $('a.delete').click(function(){
            $('#delete-modal').modal()
            $('button.delete').attr('data-url', $(this).attr('href'))
            return false
        })

        $('button.delete').click(function(){
            $(location).attr('href', $(this).attr('data-url'))
        })
    })
</script>
@endpush