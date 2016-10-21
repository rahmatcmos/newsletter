@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title or config('app.name') }}</div>
                <div class="panel-body">
                    @include('partials.message')

                    <form action="{{ route('admin.list.edit.post') }}" role="form" method="post">
                        {{ csrf_field() }}
                        {{ method_field('post') }}
                        <input type="hidden" name="id" value="{{ $list->id }}">

                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name" class="control-label">@lang('newsletter.lists.form.name')</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $list->name) }}" class="form-control">
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        </div>

                        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                            <label for="description" class="control-label">@lang('newsletter.lists.form.description')</label>
                            <textarea name="description" class="form-control" id="description" rows="5">{{ old('description', $list->description) }}</textarea>
                            <span class="help-block">{{ $errors->first('description') }}</span>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"> </i>
                                @lang('newsletter.lists.button.save')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
