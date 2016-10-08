@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title or config('app.name') }}</div>

                <div class="panel-body">
                    <div class="alert alert-success">You are successfully unsubscribed our newsletter. </div>
                    <p>We sad to hear that. If you have time, glad to you give some reason why you leave us.</p>

                    <form action="{{ route('newsletter.reason.post') }}">
                        @foreach ($reasons as $reason)
                            <div class="radio">
                                <label>
                                    <input type="radio" name="reason" id="reason-{{ $reason->id }}" value="{{ $reason->description }}"> {{ $reason->description }}
                                </label>
                            </div>
                        @endforeach
                        <div class="radio">
                            <label>
                                <input type="radio" name="reason" id="reason-other" value="other"> Other &mdash; Please provide reason below</small>
                            </label>
                        </div>

                        <div class="form-group">
                            <textarea name="reason_text" id="reason"  rows="5" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection