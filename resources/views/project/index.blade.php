<x-app-layout>
    <div class="flex align-center">
        <h1 class="mr-auto text-4xl">Projects</h1>
        <a href="/projects/create" class="text-blue-500 my-5">New Project</a>
    </div>

    <div class="flex">
        @forelse ($projects as $project)
            <div class="bg-white mr-4 p-3 rounded-md shadow-md w-1/3" style="height: 200px">
                <h3 class="text-2xl mb-6 py-4">{{ $project->title }}</h3>

                <div class="text-gray-600">{{ Str::limit($project->description, 100) }}</div>
            </div>
        @empty
            <div>
                No projects yet
            </div>
        @endforelse
    </div>
</x-app-layout>
