@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title or config('app.name') }}</div>
                <div class="panel-body">
                    @include('partials.message')

                    <a href="" class="btn btn-primary create">
                        <i class="fa fa-plus"></i>
                        @lang('newsletter.lists.button.create')
                    </a>
                    <hr>

                    <table class="table">
                        <thead>
                            <th>@lang('newsletter.lists.form.user')</th>
                            <th>@lang('newsletter.lists.form.name')</th>
                            <th>@lang('newsletter.lists.form.description')</th>
                            <th>@lang('newsletter.lists.form.totalSubs')</th>
                            <th>@lang('newsletter.lists.form.user')</th>
                            <th>@lang('newsletter.lists.form.createDate')</th>
                            <th class="text-right">@lang('newsletter.lists.form.action')</th>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                                <tr>
                                    <td>
                                        @if (! empty($list->user))
                                            <a href="{{ route('admin.user.profile', $list->user->id) }}">
                                                {{ $list->user->name }}
                                            </a>

                                            @if (auth()->id() === $list->user->id)
                                                <span class="label label-info">You</span>
                                            @endif
                                        @else
                                            @lang('newsletter.list.userDeleted')
                                        @endif
                                    </td>
                                    <td><a href="{{ route('admin.subscriber', $list->slug) }}">{{ $list->name }}</a></td>
                                    <td>{{ $list->description }}</td>
                                    <td>{{ $list->subscribers->count() }} {{ $list->subscribers->count() <= 1 ? 'person' : 'people' }}</td>
                                    <td>
                                        @if ($list->id === (int) config('newsletter.list'))
                                            <span class="label label-success">@@lang('newsletter.lists.yes')</span>
                                        @else
                                            <span class="label label-danger">@@lang('newsletter.lists.no')</span>
                                        @endif
                                    </td>
                                    <td>{{ $list->created_at->format(config('date.format')) }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.list.edit', $list->id) }}" class="btn btn-default edit {{ (! empty($list->user) AND auth()->id() !== $list->user->id AND auth()->user()->group === 'user') ? 'disabled' : '' }}" title="Edit current item"><i class="fa fa-pencil"></i></a>
                                        <a href="{{ route('admin.list.delete', $list->id) }}" class="btn btn-danger delete {{ (! empty($list->user) auth()->id() !== $list->user->id AND auth()->user()->group === 'user') ? 'disabled' : '' }}" title="Delete current item"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $lists->appends(['user' => request('user')])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<div id="create-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">@lang('newsletter.lists.create')</h4>
            </div>
            <form action="{{ route('admin.list.create.post') }}" method="post" role="form" id="create-list">
            {{ csrf_field() }}
            {{ method_field('post') }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">@lang('newsletter.lists.form.name')</label>
                        <input type="text" name="name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="email">@lang('newsletter.lists.form.description')</label>
                        <textarea name="description" id="description" class="form-control" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('newsletter.lists.button.close')</button>
                    <button type="submit" class="btn btn-primary delete">
                        <i class="fa fa-save"></i>
                        @lang('newsletter.lists.button.save')
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="delete-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">@lang('newsletter.lists.delete')</h4>
            </div>

            <div class="modal-body">
                <p>@lang('newsletter.lists.message.deleteWarning')</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default dismiss" data-dismiss="modal">@lang('newsletter.lists.button.close')</button>
                <button type="button" class="btn btn-danger delete">
                    <i class="fa fa-trash"></i>
                    @lang('newsletter.lists.button.delete')
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(function(){
        $('a.create').click(function(){
            $('#create-modal').modal()
            return false
        })

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
