@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">About</div>

                <div class="panel-body">
                    {!! $about !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
