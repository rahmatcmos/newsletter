@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title or config('app.name') }}</div>

                <div class="panel-body">
                    <form action="{{ route('admin.subscriber.create.post') }}" method="post" role="form" data-toggle="validator" id="subscriber-form">
                    {{ csrf_field() }}
                    {{ method_field('post') }}
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name" class="control-label">@lang('newsletter.subscribers.form.name')</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        </div>

                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label for="email" class="control-label">@lang('newsletter.subscribers.form.email')</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        </div>

                        <div class="form-group {{ $errors->has('list') ? 'has-error' : '' }}">
                            <label for="list" class="control-label">@lang('newsletter.subscribers.form.list')</label>
                            <select name="list" id="list" class="form-control" required></select>
                            <span class="help-block">{{ $errors->first('list') }}</span>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" class="create">
                                <i class="fa fa-save"></i>
                                @lang('newsletter.subscribers.button.save')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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
        $('#list').empty()
        $.getJSON('{{ route('admin.list') }}', {}, function(response){
            $.each(response.content, function(i, obj){
                $('#list').append($('<option>').text(obj.name).attr('value', obj.id));
            });
        })

        $('#subscriber-form').submit(function(){
            $('button.create').html('Saving Subcriber...')
        })
    })
</script>
@endpush
