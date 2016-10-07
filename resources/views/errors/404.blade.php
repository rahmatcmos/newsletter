@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Error</div>

                <div class="panel-body text-center">
                	<h1>{{ $exception->getStatusCode() }}</h1>
                	<p>Ooop! There is something error with application.</p>
                	<p>
                		<a href="" class="btn btn-primary">Back to Home</a>
                	</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
