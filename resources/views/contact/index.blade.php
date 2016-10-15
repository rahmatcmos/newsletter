@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title or config('app.name') }}</div>

                <div class="panel-body">
                    @include('partials.message')

                    <form role="form" action="{{ route('contact.post') }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('post') }}

                        <div class="form-group {{ $errors->has('name') ? 'has-error' : null }}">
                            <label for="name" class="control-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        </div>

                        <div class="form-group {{ $errors->has('email') ? 'has-error' : null }}">
                            <label for="name" class="control-label">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" class="form-control">
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        </div>

                        <div class="form-group">
                            <label for="subject" class="control-label">Subject</label>
                            <select name="subject" id="subject" class="form-control">
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject }}">{{ $subject }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group {{ $errors->has('message') ? 'has-error' : null }}">
                            <label for="message" class="control-label">Message</label>
                            <textarea name="message" id="message" cols="30" rows="5" class="form-control">{{ old('message') }}</textarea>
                        </div>

                        <div class="form-group">
                            <input type="file" name="attach">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
