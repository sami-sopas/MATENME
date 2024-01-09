<x-app-layout>
    <header class="flex items-center mb-3 py-4">

        <div class="flex justify-between w-full items-center">
            <h3 class="mr-auto text-gray-600 text-lg">My Projects</h3>
            <a href="/projects/create" class="button">New Project</a>
        </div>

    </header>

    <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse ($projects as $project)
        <div class="lg:w-1/3 px-3 pb-6">
            <x-card :project="$project">
            </x-card>
        </div>
        @empty
            <div>
                No projects yet
            </div>
        @endforelse
        </main>
</x-app-layout>
