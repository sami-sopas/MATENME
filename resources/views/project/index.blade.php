<x-app-layout>
    <header class="flex items-center mb-3 py-4">

        <div class="flex justify-between w-full items-center">
            <h3 class="mr-auto text-gray-600 text-xl">My Projects</h3>
            <a href="/projects/create" class="button">New Project</a>
        </div>

    </header>

    <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse ($projects as $project)
        <div class="lg:w-1/3 px-3 pb-6">
            <div class="bg-white p-3 rounded-lg shadow-md" style="height: 200px">
                <h3 class="text-2xl mb-6 py-4 -ml-3 border-l-4 border-blue-300 pl-4">
                    <a href="{{$project->path()}}">{{ $project->title }}</a>
                </h3>

                <div class="text-gray-600 pl-3">{{ Str::limit($project->description, 100) }}</div>
            </div>
        </div>
        @empty
            <div>
                No projects yet
            </div>
        @endforelse
        </main>
</x-app-layout>
