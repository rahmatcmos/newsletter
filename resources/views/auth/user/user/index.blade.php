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
                        <a href="{{ route('admin.user.create') }}" class="btn btn-primary create"><i class="fa fa-plus"> </i> @lang('user.create')</a>
                    </p>

                    <form action="{{ url()->current() }}" method="get" role="form">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon3">@lang('user.form.keyword'):</span>
                            <input type="text" class="form-control" name="query" value="{{ request('query') }}">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">@lang('user.button.search')</button>
                            </span>
                        </div>
                    </form>

                    <div class="table-responsive">

                        <table class="table">
                            <thead>
                                <th>@lang('user.form.group')</th>
                                <th>@lang('user.form.name')</th>
                                <th>@lang('user.form.email')</th>
                                <th>@lang('user.form.list')</th>
                                <th>@lang('user.form.joinDate')</th>
                                <th class="text-right">@lang('user.form.action')</th>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ ucwords($user->group) }}</td>
                                        <td>
                                            {{ $user->name }}
                                            @if ($user->id == auth()->user()->id)
                                                <span class="label label-info">@lang('user.you')</span>
                                            @endif
                                        </td>
                                        <td>{{ strtolower($user->email) }}</td>
                                        <td>{{ $user->lists->count() }}</td>
                                        <td>{{ $user->created_at->format(config('date.format')) }}</td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.user.profile', $user->id) }}" class="btn btn-default" title="@lang('user.profile', ['name' => $user->name])">
                                                <i class="fa fa-user"></i>
                                            </a>

                                            <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-default" title="@lang('user.edit', ['name' => $user->name])">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a href="{{ route('admin.user.delete', $user->id) }}" class="btn btn-danger delete {{ auth()->user()->id == $user->id ? 'disabled' : '' }}" title="@lang('user.delete', ['name' => $user->name])" data-id="{{ $user->id }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

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
                <h4 class="modal-title">@lang('user.warning')</h4>
            </div>
            <div class="modal-body">
                <p>@lang('user.message.deleteWarning')</p>
                <form action="{{ route('admin.user.delete') }}" method="post" role="form" id="delete-form">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                    <input type="hidden" name="id" id="user-id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('user.button.close')</button>
                <button type="button" class="btn btn-danger delete"> <i class="fa fa-trash"></i> @lang('user.button.delete')</button>
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
            $('#user-id').val($(this).attr('data-id'))
            return false
        })

        $('button.delete').click(function(){
            $('#delete-form').submit()
        })
    })
</script>
@endpush
