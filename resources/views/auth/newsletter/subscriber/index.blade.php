@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title or config('app.name') }}</div>

                <div class="panel-body">
                	@if ($subscribers->total() === 0)
                		<div class="alert alert-info">@lang('newsletter.subscribers.message.noSubscriber')</div>
                	@endif

                    @include('partials.message')

                    <a href="" class="btn btn-primary create"> <i class="fa fa-plus"></i> @lang('newsletter.subscribers.button.create')</a>
                    <a href="" class="btn btn-default"> <i class="fa fa-file-excel-o"></i> @lang('newsletter.subscribers.button.export')</a>
                    <a href="" class="btn btn-default"> <i class="fa fa-file-excel-o"></i> @lang('newsletter.subscribers.button.import')</a>
                    <a href="" class="btn btn-danger truncate {{ (auth()->user()->group === 'user' OR $subscribers->total() <= 0) ? 'disabled' : '' }}"> <i class="fa fa-trash"></i> @lang('newsletter.subscribers.button.truncate')</a>

                    <hr>

                    <form action="{{ url()->current() }}" method="get" role="form">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon3">@lang('newsletter.subscribers.form.keyword'):</span>
                            <input type="text" class="form-control" name="query" value="{{ request('query') }}">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">@lang('newsletter.subscribers.button.search')</button>
                            </span>
                        </div>
                    </form>

                    <div class="table-responsive">

                        <table class="table table-border">
                        	<thead>
                                <th><input type="checkbox"></th>
                                <th>@lang('newsletter.subscribers.form.user')</th>
                                <th>@lang('newsletter.subscribers.form.list')</th>
                        		<th>@lang('newsletter.subscribers.form.name')</th>
                        		<th>@lang('newsletter.subscribers.form.email')</th>
                        		<th>@lang('newsletter.subscribers.form.status')</th>
                                <th>@lang('newsletter.subscribers.form.joinDate')</th>
                        		<th>@lang('newsletter.subscribers.form.action')</th>
                        	</thead>
                        	@foreach ($subscribers as $subscriber)
                        	<tr class="{{ $subscriber->status === 'unsubscribed' ? 'text-muted' : '' }}">
                                <td><input type="checkbox" value="{{ $subscriber->id }}"></td>
                                <td>
                                    @if (! empty($subscriber->list->user))
                                    <a href="{{ route('admin.user.profile', $subscriber->list->user->id) }}">   {{ $subscriber->list->user->name }}
                                    </a>
                                    @else
                                        @lang('newsletter.subscribers.userDeleted')
                                    @endif
                                </td>
                                <td><a href="{{ route('admin.subscriber', $subscriber->list->slug) }}">{{ $subscriber->list->name }}</a></td>
                        		<td>{{ $subscriber->name }}</td>
                        		<td>{{ $subscriber->email }}</td>
                        		<td><span class="label label-{{ $labels[$subscriber->status] }}">{{ $subscriber->status }}</span></td>
                                <td>{{ $subscriber->created_at->format(config('date.format')) }}</td>
                        		<td class="text-right">
                                    <a href="" class="btn btn-default" title="Send newsletter"><i class="fa fa-envelope"></i></a>
                                    <a href="{{ route('admin.subscriber.edit', $subscriber->id) }}" class="btn btn-default" title="Edit current subscriber"><i class="fa fa-pencil"></i></a>
                        			<a href="{{ route('admin.subscriber.delete', $subscriber->id) }}" class="btn btn-danger delete" title="Delete current subscriber"><i class="fa fa-trash"></i></a>
                        		</td>
                        	</tr>
                        	@endforeach
                        </table>

                    </div>

                    {{ $subscribers->appends([
                        'query' => request('query'),
                        'by' => request('by'),
                        'column' => request('column')
                    ])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<div id="truncateModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">@lang('newsletter.subscribers.warning')</h4>
            </div>
            <form action="{{ route('admin.subscriber.truncate') }}" method="post" id="form-truncate">
                {{ csrf_field() }}
                {{ method_field('delete') }}

                <div class="modal-body">
                    <p>@lang('newsletter.subscribers.message.deleteWarning')</p>
                    <p>@lang('newsletter.subscribers.message.passwordConfirm')</p>
                        <div class="form-group">
                            <label for="password">@lang('newsletter.subscribers.form.password')</label>
                            <input type="password" name="password" class="form-control" id="confirm-password">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        @lang('newsletter.subscribers.button.close')
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-trash"></i>
                        @lang('newsletter.subscribers.button.truncate')
                     </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">@lang('newsletter.subscribers.warning')</h4>
            </div>
            <div class="modal-body">
                <p>@lang('newsletter.subscribers.message.deleteWarning')</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('newsletter.subscribers.button.close')</button>
                <button type="button" class="btn btn-danger delete"> <i class="fa fa-trash"></i> @lang('newsletter.subscribers.button.delete')</button>
            </div>
        </div>
    </div>
</div>

<div id="create-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('newsletter.subscribers.create')</h4>
            </div>
            <form action="{{ route('admin.subscriber.create.post') }}" method="post" role="form" id="create-subscriber" data-toggle="validator">
            {{ csrf_field() }}
            {{ method_field('post') }}
                <div class="modal-body">
                    <div class="validations"></div>
                    <div class="form-group">
                        <label for="name">@lang('newsletter.subscribers.form.name')</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email">@lang('newsletter.subscribers.form.email')</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="list" class="control-label">@lang('newsletter.subscribers.form.list')</label>
                        <select name="list" id="list" class="form-control" required></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <i class="fa fa-spinner fa-spin fa-fw loader"></i>
                    <button type="button" class="btn btn-default dismiss" data-dismiss="modal">
                        @lang('newsletter.subscribers.button.close')
                    </button>
                    <button type="submit" class="btn btn-primary create">
                        <i class="fa fa-save"></i>
                        @lang('newsletter.subscribers.button.save')
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('component/bootstrap-validator/dist/validator.min.js') }}"></script>
@endpush

@push('script')
<script>
    $(function(){
        $('.loader').hide()

        // delete all data
        $('a.truncate').click(function(){
            $('#truncateModal').modal()
            $('#confirm-password').focus()
            return false
        })

        // delete single row
        $('a.delete').click(function(){
            $('#deleteModal').modal()
            $('button.delete').attr('data-url', $(this).attr('href'))
            return false
        })

        $('button.delete').click(function(){
            $(location).attr('href', $(this).attr('data-url'))
        })

        $('a.create').click(function(){
            $('#create-modal').modal()
            return false
        })

        $('#create-modal').on('show.modal.bs', function(){
            $('.validations').empty().hide()
            $('#name, #email').empty()

            // request list
            $.get('{{ route('admin.list') }}', {}, function(response){
                if (response.isSuccess == true) {
                    $('#list').empty()
                    $.each(response.content, function(i, obj){
                        $('#list').append($('<option>').text(obj.name).attr('value', obj.id));
                    });
                }
            })
        })

        $('#create-subscriber').submit(function(){
            $('.loader').show()
            $('button.create, button.dismiss').attr('disabled', true)

            $.post($(this).attr('action'), $(this).serialize(), function(response, status, xhr){
                if (response.isSuccess) {
                    $('.validations').addClass('alert alert-success').text(response.message).fadeIn()
                    $('#name, #email').val('')
                }

                // manipulate element
                $('.loader').hide()
                $('button.create, button.dismiss').attr('disabled', false)
            })
            return false;
        })
    })
</script>
@endpush
