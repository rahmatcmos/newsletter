@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title or config('app.name') }}</div>

                <div class="panel-body">
                    <div class="alert alert-success">@lang('newsletter.message.unsubscribed')</div>
                    <p>@lang('newsletter.reason')</p>

                    <form action="{{ route('newsletter.reason.post') }}" method="post" data-toggle="validator">
                        {{ csrf_field() }}
                        {{ method_field('post') }}

                        @if (empty(request('email')))
                            <div class="form-group">
                                <label for="email" class="control-label">@lang('newsletter.form.email')</label>
                                <input type="text" class="form-control" name="email" value="{{ old('email') }}" required>
                            </div>
                        @endif

                        @foreach ($reasons as $reason)
                            <div class="radio">
                                <label>
                                    <input type="radio" name="reason" id="reason-{{ $reason->id }}" value="{{ $reason->description }}"> {{ $reason->description }}
                                </label>
                            </div>
                        @endforeach
                        <div class="radio">
                            <label>
                                <input type="radio" name="reason" id="reason-other" value="other">@lang('newsletter.form.reasonOther')</small>
                            </label>
                        </div>

                        <div class="form-group">
                            <textarea name="reason_text" id="reason"  rows="5" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">@lang('newsletter.button.send')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
