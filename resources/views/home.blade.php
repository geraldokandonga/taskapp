@extends('layouts.master')

@section('content')
<input type="hidden" id="csrf_token" value="{{ csrf_token() }}">
<div class="row mt-5">
    <div class="col-md-10 offset-md-1">
        <h3 class="text-center mb-4">
            Task Manager
        </h3>
        <div class="row">
            <div class="col-md-12">
                <div class="text-right">
                    <button type="button" class="btn-add-project btn btn-info btn-sm pull-right mb-1">
                        <i class="fa fa-plus"></i> Add New Project
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <ul id="project_list" class="list-group list-unstyled">
                <select class="form-control" id="selected_project_id" name="project_id">
                    <option>Select Project</option>
                    @foreach ($projects as $key => $project)
                    <option value="{{ $project->id }}">
                        {{ $project->name }}
                    </option>
                    @endforeach
                </select>
            </ul>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="project_modal" tabindex="-1" role="dialog" aria-labelledby="project_modal_label"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="g-3 needs-validation" novalidate id="project_form">
                <input type="hidden" id="project_id" value="" />
                <input type="hidden" id="_method" value="" />
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="project_modal_label">Create New Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <label for="project_name" class="form-label">Project Name</label>
                        <input type="text" class="form-control" id="project_name" required autocomplete="off">
                        <div class="invalid-feedback">
                            Please provide a valid project name.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close </button>
                    <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


@stop
@section('additional_js')
<script type="text/javascript" src="{{ url('/assets/js/project.js') }}"></script>
@stop
