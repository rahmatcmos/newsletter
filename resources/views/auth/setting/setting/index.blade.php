@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title or config('app.name') }}</div>
                <div class="panel-body">
                    @include('partials.message')

                    <div class="response alert"></div>

					<ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#global">Applications</a></li>
                        <li><a data-toggle="tab" href="#date">Date &amp; Time</a></li>
                        <li><a data-toggle="tab" href="#newsletter">Email Settings</a></li>
                        <li><a data-toggle="tab" href="#sender">Email Sender</a></li>
                    </ul>

                    <form action="{{ route('admin.setting.post') }}" role="post" method="post" id="form-setting">
	                    {{ csrf_field() }}
	                    {{ method_field('post') }}

	                    <div class="tab-content">
	                        <div id="global" class="tab-pane fade in active">
	                        	<h4>Applications</h4>
	                        	<hr>
	                        	<div class="form-group {{ $errors->has('app_name') ? 'has-error' : '' }}">
	                        		<label for="name" class="control-label">Application Name</label>
	                        		<input type="text" name="app_name" value="{{ old('app_name', config('app.name')) }}" class="form-control">
	                        	</div>
	                        	<div class="form-group {{ $errors->has('app_email') ? 'has-error' : '' }}">
	                        		<label for="name" class="control-label">Email</label>
	                        		<input type="email" name="app_email" value="{{ old('app_email', config('app.email')) }}" class="form-control">
	                        	</div>

	                        	<div class="form-group">
	                        		<label for="newsletter_list" class="control-label">Default List</label>
	                        		<select name="newsletter_list" id="list-default" class="form-control" required>
	                        			@foreach($lists as $list)
	                        				<option value="{{ $list->id }}">{{ $list->name }}</option>
	                        			@endforeach
	                        		</select>
	                        	</div>
	                        </div>
	                        <div id="date" class="tab-pane fade">
								<h4>Date and Time</h4>
								<hr>
	                        	<div class="form-group {{ $errors->has('app_timezone') ? 'has-error' : '' }}">
	                        		<label for="name" class="control-label">Timezone</label>
	                        		<input type="text" name="app_timezone" value="{{ old('app_timezone', config('app.timezone')) }}" class="form-control">
	                        	</div>
	                        	<div class="form-group {{ $errors->has('date_format') ? 'has-error' : '' }}">
	                        		<label for="name" class="control-label">Format</label>
	                        		<input type="text" name="date_format" value="{{ old('date_format', config('date.format')) }}" class="form-control">
	                        	</div>
	                        </div>
	                        <div id="newsletter" class="tab-pane fade">
	                        	<h4>Email Settings</h4>
	                        	<hr>
								<div class="form-group">
									<label for="smtp_host" class="control-label">Driver</label>
									<select name="mail_driver" id="mail_driver" class="form-control">
										@foreach ($drivers as $value => $name)
											<option value="{{ $value }}" {{ $value == config('mail.driver') ? 'selected' : '' }}>{{ $name }}</option>
											}
										@endforeach
									</select>
								</div>

								<div class="form-group">
									<label for="mail_host" class="control-label">Mail Host</label>
									<input type="text" name="mail_host" value="{{ old('mail_host', config('mail.host')) }}" class="form-control">
								</div>

								<div class="form-group">
									<label for="mail_port" class="control-label">Port</label>
									<input type="text" name="mail_port" value="{{ old('mail_port', config('mail.port')) }}" class="form-control">
								</div>

								<div class="form-group">
									<label for="mail_username" class="control-label">Mail Username</label>
									<input type="text" name="mail_username" value="{{ old('mail_username', config('mail.username')) }}" class="form-control">
								</div>

								<div class="form-group">
									<label for="mail_password" class="control-label">Mail Password</label>
									<input type="password" name="mail_password" value="{{ old('mail_password', config('mail.password')) }}" class="form-control">
								</div>

								<div class="form-group">
									<label for="mail_encryption" class="control-label">Encryption</label>
									<input type="text" name="mail_encryption" value="{{ old('mail_encryption', config('mail.encryption')) }}" class="form-control" placeholder="tls, ssl">
								</div>

								<div class="form-group">
									<label for="mail_sendmail" class="control-label">Sendmail Path</label>
									<input type="text" name="mail_sendmail" value="{{ old('mail_sendmail', config('mail.sendmail')) }}" class="form-control" placeholder="">
								</div>
	                        </div>
	                        <div id="sender" class="tab-pane fade">
								<h4>Sender</h4>
								<hr>
								<div class="form-group">
									<label for="mail_from_name" class="control-label">Name</label>
									<input type="text" name="mail_from_name" value="{{ old('mail.from.name', config('mail.from.name')) }}" class="form-control">
								</div>

								<div class="form-group">
									<label for="mail_from_address" class="control-label">Email</label>
									<input type="text" name="mail_from_address" value="{{ old('mail_from_address', config('mail.from.address')) }}" class="form-control">
								</div>
	                        </div>
	                    </div>

	                    <div class="form-group">
	                    	<button type="submit" class="btn btn-primary">Save Settings</button>
	                    	<button type="button" class="btn btn-default test-email">Test Email</button>
	                    	<i class="fa fa-spinner fa-spin loader"></i>
	                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal-email" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Email tester</h4>
            </div>
            <form action="{{ route('admin.setting.email') }}" method="post" id="form-truncate">
                {{ csrf_field() }}
                {{ method_field('post') }}

                <div class="modal-body">
                    <p>Email will be send to address below</p>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" class="form-control" id="confirm-password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-envelope"></i> Send Email</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
	<script>
		$(function(){
			$('.loader, .response').hide()

			$('.test-email').click(function(){
				$('#modal-email').modal()
				return false
			})

			$('#form-setting').submit(function(){
				$('.loader').show()
				$('.response').fadeOut()

				$.post($(this).attr('action'), $(this).serialize(), function(response){
					$('.response').text(response.message)
						.addClass(response.status == true ? 'alert-success' : 'alert-danger')
						.fadeIn()

					$('.loader').fadeOut()
				}, 'json')
				return false;
			})
		})
	</script>
@endpush
