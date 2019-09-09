@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">To Do List</div>

                <div class="panel-body">
                    <form class="form-horizontal" id="todo-form">
                        <div class="form-group">
                            <label for="todo" class="col-md-4 control-label">Todo</label>

                            <div class="col-md-6">
                                <input id="todo" type="text" class="form-control" name="todo" value="{{ old('todo') }}">
                                <span class="help-block hide"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="button" class="btn btn-primary" id="add-todo">
                                    <i class="fa fa-btn fa-plus"></i> Add
                                </button>
                            </div>
                        </div>
                    </form>

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Todo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary" id="delete-selected" disabled>
                            <i class="fa fa-btn fa-trash"></i> Delete Selected
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var userId = '{{ $userId }}';
</script>
<script type="text/javascript" src="{{ url('js/script.js') }}"></script>
@endsection
