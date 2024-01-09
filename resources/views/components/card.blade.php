
    <div class="card" style="height: 200px">
        <h3 class="text-2xl mb-6 py-4 -ml-3 border-l-4 border-blue-300 pl-4">
            <a href="{{$project->path()}}">{{ $project->title }}</a>
        </h3>

        <div class="text-gray-600 pl-3">{{ Str::limit($project->description, 100) }}</div>
    </div>

