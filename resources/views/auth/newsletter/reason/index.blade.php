@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title or config('app.name') }}</div>
                <div class="panel-body">
                    @include('partials.message')

                    <a href="" class="btn btn-primary create"><i class="fa fa-plus"></i> Create New</a>
                    <hr>
                    
                    <table class="table">
                        <thead>
                            <th>Text</th>
                            <th class="text-right">Actions</th>
                        </thead>
                        <tbody>
                            @foreach ($reasons as $reason)
                                <tr>
                                    <td>{{ $reason->description }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.reason.detail', $reason->id) }}" class="btn btn-default edit"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('admin.reason.delete', $reason->id) }}" class="btn btn-danger delete"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="create-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create New Unsubscribe Reason</h4>
            </div>
            <form action="{{ route('admin.reason.create.post') }}" method="post" role="form" id="create-reason" data-toggle="validator">
            {{ csrf_field() }}
            {{ method_field('post') }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="email">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary delete"> <i class="fa fa-save"></i> Create Reason</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="edit-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Unsubscribe Reason</h4>
            </div>
            <form action="{{ route('admin.reason.edit.post') }}" method="post" role="form" id="edit-reason" data-toggle="validator">
            <input type="hidden" value="" name="reason_id" id="reason-id">
            {{ csrf_field() }}
            {{ method_field('post') }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="email">Description</label>
                        <textarea name="description" id="description-edit" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary delete"> <i class="fa fa-save"></i> Edit Reason</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="delete-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete Reason</h4>
            </div>

            <div class="modal-body">
                <p>Are you sure wan to delete this item? This action can't be undone.</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default dismiss" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger delete"> <i class="fa fa-trash"></i> Delete Reason</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('component/bootstrap-validator/dist/validator.min.js') }}"></script>
@endpush

@push('script')
<script>
    $(function(){
        $('a.create').click(function(){
            $('#create-modal').modal()
            return false
        })

        $('a.delete').click(function(){
            $('#delete-modal').modal()
            $('button.delete').attr('data-url', $(this).attr('href'))
            return false
        })

        $('button.delete').click(function(){
            $(location).attr('href', $(this).attr('data-url'))
        })

        $('a.edit').click(function(){
            $.get($(this).attr('href'), {}, function(response){                
                if (response.isSuccess) {
                    $('#reason-id').val(response.content.id)
                    $('#description-edit').val(response.content.text)
                }
            })

            $('#edit-modal').modal()
            return false
        })
    })
</script>
@endpush