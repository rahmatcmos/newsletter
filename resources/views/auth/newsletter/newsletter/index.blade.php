@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title or config('app.name') }}</div>
                <div class="panel-body">
                    @include('partials.message')
                    <h2>Coming Soon!</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection