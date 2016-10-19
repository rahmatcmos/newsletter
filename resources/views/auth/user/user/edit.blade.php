@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title or config('app.name') }}</div>

                <div class="panel-body">
                    @include('partials.message')

                    <form action="{{ route('admin.user.edit.put') }}" method="post" role="form" data-toggle="validator">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        <input type="hidden" name="id" value="{{ $user->id }}" id="user-id">

                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name" class="control-label">@lang('user.form.name')</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        </div>

                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label for="email" class="control-label">@lang('user.form.email')</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        </div>

                        <div class="form-group {{ $errors->has('group') ? 'has-error' : '' }}">
                            <label for="group" class="control-label">@lang('user.form.group')</label>
                            <select name="group" id="user-group" class="form-control">
                                @foreach ($groups as $value => $label)
                                    <option value="{{ $value }}" {{ $user->group == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <span class="help-block">{{ $errors->first('group') }}</span>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i>
                                @lang('user.button.update')
                            </button>
                            <a href="{{ route('admin.user') }}" class="btn btn-default">
                                @lang('user.button.back')
                            </a>
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
