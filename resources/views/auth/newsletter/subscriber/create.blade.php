@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title or config('app.name') }}</div>

                <div class="panel-body">
                    <form action="{{ route('admin.subscriber.create.post') }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('post') }}
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name" class="control-label">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label for="email" class="control-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('list') ? 'has-error' : '' }}">
                            <label for="list" class="control-label">List</label>
                            <select name="list" id="list" class="form-control">
                                @foreach ($lists as $list)
                                    <option value="{{ $list->id }}">{{ $list->name }}</option>
                                @endforeach
                            </select>
                            <span class="help-block">{{ $errors->first('list') }}</span>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save Subcriber</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection