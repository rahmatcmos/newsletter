@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title or config('app.name') }}</div>
                <div class="panel-body">
                    @include('partials.message')
                    <h1>{{ $newsletter->title }} <small>{{ $newsletter->description }}</small></h1>
                    <div class="content">
                        {!! $newsletter->content !!}
                    </div>

                    <p>
                        <a href="" class="btn btn-primary">Sent to All</a>
                        <a href="" class="btn btn-default">Sent to List</a>
                        <a href="" class="btn btn-default">Sent to Specified Subscribers</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection