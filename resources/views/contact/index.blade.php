@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title or config('app.name') }}</div>

                <div class="panel-body">
                    @include('partials.message')

                    <form role="form" action="{{ route('contact.post') }}" method="post" enctype="multipart/form-data" id="form-contact" data-toggle="validator">
                        {{ csrf_field() }}
                        {{ method_field('post') }}

                        <div class="form-group {{ $errors->has('name') ? 'has-error' : null }}">
                            <label for="name" class="control-label">@lang('contact.form.name')</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        </div>

                        <div class="form-group {{ $errors->has('email') ? 'has-error' : null }}">
                            <label for="name" class="control-label">@lang('contact.form.email')</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" class="form-control" required>
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        </div>

                        <div class="form-group">
                            <label for="subject" class="control-label">@lang('contact.form.subject')</label>
                            <select name="subject" id="subject" class="form-control" required>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject }}">{{ $subject }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group {{ $errors->has('message') ? 'has-error' : null }}">
                            <label for="message" class="control-label">@lang('contact.form.message')</label>
                            <textarea name="message" id="message" cols="30" rows="5" class="form-control" required data-minlength="10">{{ old('message') }}</textarea>
                            <span class="help-block">{{ $errors->first('message') }}</span>
                        </div>

                        <div class="form-group {{ $errors->has('attach') ? 'has-error' : null }}">
                            <input type="file" name="attach">
                            <span class="help-block">{{ $errors->first('attach') }}</span>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary send"><i class="fa fa-envelope"></i> @lang('contact.button.send')</button>
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
