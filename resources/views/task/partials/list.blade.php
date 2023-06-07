@forelse($tasks as $row)
@include('task.partials.row', ['row' => $row])
@empty
<li class="text-center mb-5 mt-5">No data</li>
@endforelse
