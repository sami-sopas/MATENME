<x-app-layout>
    <div class="flex align-center">
        <h1 class="mr-auto text-3xl">Projects</h1>
        <a href="/projects/create" class="text-blue-500 mt-5">New Project</a>
    </div>


    @forelse ($projects as $project)
    <li>
        <a href="{{ $project->path() }}">
            {{$project->title}}
        </a>
    </li>

    @empty
        <li>No proyectos mano.</li>
    @endforelse
</x-app-layout>
