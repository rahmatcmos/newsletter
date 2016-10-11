@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title or config('app.name') }}</div>
                <div class="panel-body">
                    @include('partials.message')

					
					<ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#global">Global</a></li>
                        <li><a data-toggle="tab" href="#newsletter">Newsletters</a></li>
                    </ul>

                    <form action="{{ route('admin.setting.post') }}" role="post" method="post">
	                    {{ csrf_field() }}
	                    {{ method_field('post') }}

	                    <div class="tab-content">
	                        <div id="global" class="tab-pane fade in active">
	                        	<h4>Applications</h4>
	                        	<hr>
	                        	<div class="form-group {{ $errors->has('app_name') ? 'has-error' : '' }}">
	                        		<label for="name">Application Name</label>
	                        		<input type="text" name="app_name" value="{{ old('app_name', config('app.name')) }}" class="form-control">
	                        	</div>
	                        </div>
	                        <div id="newsletter" class="tab-pane fade">
	                            <h3>Menu 1</h3>
	                            <p>Some content in menu 1.</p>
	                        </div>
	                    </div>

	                    <div class="form-group">
	                    	<button type="submit" class="btn btn-primary">Save Settings</button>
	                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection