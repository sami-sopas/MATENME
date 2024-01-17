<x-app-layout>
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between w-full items-center">
            <p class="mr-auto text-gray-600 text-lg">
                <a href="/projects"> My Projects </a> / {{ $project->title }}
            </p>
            <a href="{{ $project->path() . '/edit' }}" class="button">Edit Project</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-8">

                <div class="mb-6">
                    <h3 class="text-gray-600 text-xl mb-3">Tasks</h3>

                    @foreach ($project->tasks as $task)
                        <div class="card mb-3">
                            <form method="POST" action="{{ $task->path() }}">
                                @method('PATCH')
                                @csrf
                                <div class="flex items-center">
                                    <input name="body" type="text" value="{{ $task->body }}" class="w-full {{ $task->completed ? 'text-gray-500' : '' }} border-none">
                                    <input type="checkbox" name="completed" id="" class="rounded" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                                </div>
                            </form>
                        </div>
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

                    <form action="{{ $project->path() }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <textarea
                            name="notes"
                             class="card w-full border-none mb-3"
                             style="min-height: 200px;"
                             placeholder="Write your notes here!">
                             {{ $project->notes }}
                        </textarea>

                        <button type="submit" class="button">Save</button>
                    </form>

                    @if($errors->any())
                        <div class="field mt-6">
                                @foreach($errors->all() as $error)
                                    <li class="text-sm text-red-500">{{ $error }}</li>
                                @endforeach
                        </div>
                    @endif

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

