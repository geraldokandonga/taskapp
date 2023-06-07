@extends('layouts.master')

@section('content')
<input type="hidden" id="csrf_token" value="{{ csrf_token() }}">
<div class="row mt-5">
    <div class="col-md-10 offset-md-1">
        <h3 class="text-center mb-4">
            {{$project->name}} Tasks
        </h3>
        <div class="row">
            <div class="col-md-12">
                <div class="text-right">
                    <button type="button" class="btn-add-task btn btn-info btn-sm pull-right mb-1"><i
                            class="fa fa-plus"></i> Add</button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row task-list-header">
                <div class="col-md-8">Task Name</div>
                <div class="col-md-1 text-center">Priority</div>
                <div class="col-md-2 text-center">Date</div>
                <div class="col-md-1 text-center">Action</div>
            </div>
        </div>
        <ul id="task_list" class="list-group list-unstyled">
            @include('task.partials.list', ['tasks' => $tasks])
        </ul>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="edit_task_modal" tabindex="-1" role="dialog" aria-labelledby="edit_modal_label"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="g-3 needs-validation" novalidate id="edit_task_form">
                <input type="hidden" id="task_id" value="" />
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="edit_modal_label">Title Here</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <label for="task_name" class="form-label">Task Name</label>
                        <input type="text" class="form-control" id="task_name" required autocomplete="off">
                        <div class="invalid-feedback">
                            Please provide a valid task name.
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="task_priority" class="form-label">Priority</label>
                        <input type="number" class="form-control" id="task_priority" required autocomplete="off">
                        <div class="invalid-feedback">
                            Please provide a number.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"> Close </button>
                    <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- new task modal form -->
<div class="modal fade" id="new_task_modal" tabindex="-1" role="dialog" aria-labelledby="new_modal_label"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="g-3 needs-validation" novalidate id="new_task_form">
                <input type="hidden" id="project_id" value="{{$project->id}}" />
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="edit_modal_label">Title Here</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <label for="task_name" class="form-label">Task Name</label>
                        <input type="text" class="form-control" id="task_name" required autocomplete="off">
                        <div class="invalid-feedback">
                            Please provide a valid task name.
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="task_priority" class="form-label">Priority</label>
                        <input type="number" class="form-control" id="task_priority" required autocomplete="off">
                        <div class="invalid-feedback">
                            Please provide a number.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"> Close </button>
                    <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@stop

@section('additional_js')
<script type="text/javascript" src="{{ url('/assets/js/task.js') }}"></script>
@stop
