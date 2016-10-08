@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Error</div>

                <div class="panel-body text-center">
                	<h1>{{ $exception->getStatusCode() }}</h1>
                	<p>Ooop! {{ $exception->getMessage() }}</p>
                	<p>
                		<a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
                	</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
