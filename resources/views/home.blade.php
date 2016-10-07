@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <p>Halo, {{ auth()->user()->name }}!</p>
                    <p>Selamat datang di aplikasi manajemen nawala berbasis Laravel.</p>

                    <p><a href="https://www.github.com/arvernester/newsletter" class="btn btn-primary">Github</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
