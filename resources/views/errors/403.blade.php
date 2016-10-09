@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Oops! Something went error</div>

                <div class="panel-body text-center">
                	<h1>{{ $exception->getStatusCode() }}</h1>
                    <h4>{{ $exception->getMessage() }}</h4>
                	<p>
                		<a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
                        <a href="{{ url()->previous() }}" class="btn btn-default">Back to Previous Page</a>
                	</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
