@extends('layouts.app')

@push('css')
<style>
.profile {
  margin: 20px 0;
}

/* Profile sidebar */
.profile-sidebar {
  padding: 20px 0 10px 0;
  background: #fff;
}

.profile-userpic img {
  float: none;
  margin: 0 auto;
  -webkit-border-radius: 5% !important;
  -moz-border-radius: 5% !important;
  border-radius: 5% !important;
}

.profile-usertitle {
  text-align: center;
  margin-top: 20px;
}

.profile-usertitle-name {
  color: #5a7391;
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 7px;
}

.profile-usertitle-job {
  text-transform: uppercase;
  color: #5b9bd1;
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 15px;
}

.profile-userbuttons {
  text-align: center;
  margin-top: 10px;
}

.profile-userbuttons .btn {
  text-transform: uppercase;
  font-size: 11px;
  font-weight: 600;
  padding: 6px 15px;
  margin-right: 5px;
}

.profile-userbuttons .btn:last-child {
  margin-right: 0px;
}

.profile-usermenu {
  margin-top: 30px;
}

.profile-usermenu ul li {
  border-bottom: 1px solid #f0f4f7;
}

.profile-usermenu ul li:last-child {
  border-bottom: none;
}

.profile-usermenu ul li a {
  color: #93a3b5;
  font-size: 14px;
  font-weight: 400;
}

.profile-usermenu ul li a i {
  margin-right: 8px;
  font-size: 14px;
}

.profile-usermenu ul li a:hover {
  background-color: #fafcfd;
  color: #5b9bd1;
}

.profile-usermenu ul li.active {
  border-bottom: none;
}

.profile-usermenu ul li.active a {
  color: #5b9bd1;
  background-color: #f6f9fb;
  border-left: 2px solid #5b9bd1;
  margin-left: -2px;
}

/* Profile Content */
.profile-content {
  padding: 20px;
  background: #fff;
  min-height: 460px;
}
</style>
@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title or config('app.name') }}</div>
                <div class="panel-body">
					<div class="row">
						<div class="col-md-4">
							<div class="profile-sidebar">
								<div class="profile-userpic">
									<img src="https://www.gravatar.com/avatar/{{ md5($user->email) }}?s=150" class="img-responsive" alt="{{ $user->name }}">
								</div>

								<div class="profile-usertitle">
									<div class="profile-usertitle-name">
										{{ $user->name }}
									</div>
									<div class="profile-usertitle-job">
										{{ ucwords($user->group) }}
									</div>
								</div>

								@if ($user->group === 'user')
									<div class="profile-userbuttons">
										<a href="{{ route('admin.list', ['user' => $user->id]) }}" class="btn btn-default btn-sm">Lists ({{ $user->lists->count() }})</a>
										<a href="{{ route('admin.list', ['user' => $user->id]) }}" class="btn btn-default btn-sm">Subscribers ({{ $user->subscribers->count() }})</a>
									</div>
								@endif

								<div class="profile-usermenu">
									<ul class="nav">
										<li class="active">
											<a href="{{ url()->current() }}#summary">
											<i class="fa fa-home fa-fw"></i>
											Overview </a>
										</li>
										<li>
											<a href="{{ route('admin.user.edit', $user->id) }}">
											<i class="fa fa-user fa-fw"></i>
											Account Settings </a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-md-8">
							<h3>@lang('user.activity')</h3>

                            <div class="table-responsive">

                                <table class="table">
                                    <thead>
                                        <th>@lang('user.form.action')</th>
                                        <th>@lang('user.form.log')</th>
                                        <th>@lang('user.form.date')</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($activities as $activity)
                                            <tr>
                                                <td>{{ $activity->log_name }}</td>
                                                <td>{{ trans($activity->description) }}</td>
                                                <td>{{ $activity->created_at->format(config('date.format')) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>

                            {{ $activities->links() }}
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
