<x-app-layout>
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between w-full items-center">
            <p class="mr-auto text-gray-600 text-lg">
                <a href="/projects"> My Projects </a> / {{ $project->title }}
            </p>
            <a href="/projects/create" class="button">New Project</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-8">

                <div class="mb-6">
                    <h3 class="text-gray-600 text-xl mb-3">Tasks</h3>

                    @foreach ($project->tasks as $task)
                        <div class="card mb-3">{{ $task->body }}</div>
                    @endforeach
                    <div class="card mb-3">
                        <form action="{{ $project->path() . '/tasks' }}" method="POST">
                            @csrf
                            <input name="body" placeholder="Add a New Task..." type="text" class="w-full border-none">
                        </form>
                    </div>

                </div>

                <div>
                    <h3 class="text-gray-600 text-xl mb-3">General Notes</h3>

                    <textarea class="card w-full border-none" style="min-height: 200px;">Lorem Impsum</textarea>
                </div>
            </div>

            <div class="lg:w-1/4 px-3">
                <x-card :project="$project">
                </x-card>
            </div>
        </div>
    </main>

    <a href="/projects" class="mt-5 text-blue-500">Go Back</a>
</x-app-layout>

