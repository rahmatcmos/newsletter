@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    {!! $about !!}

                    <p>
                        <a href="https://github.com/arvernester/newsletter" class="btn btn-primary">View on Github</a>
                        <a href="https://laravel.web.id" class="btn btn-default">Visit Website</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
