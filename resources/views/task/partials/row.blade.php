<li class="list-group-item task-row" id="task-row-{{$row->id}}" data-id="{{ $row->id }}"
    data-project-id="{{ $row->project_id }}" class="">
    <div class="row">
        <div class="col-md-8">{{ $row->name }}</div>
        <div class="col-md-1 text-center">{{ $row->priority }}</div>
        <div class="col-md-2 text-center">{{ date('m/d/Y', strtotime($row->created_at))}}</div>
        <div class="col-md-1 text-center">
            @include('task.partials.button')
        </div>
    </div>
</li>
