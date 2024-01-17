<x-app-layout>
    <div class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
        <h1 class="text-2xl font-normal mb-10 text-center">
            Edit your project
        </h1>

        <form
            method="POST"
            action="{{ $project->path() }}"
            >
        @method('PATCH')
        @include('project.form',[
            'buttonText' => 'Update Project'
        ])
        </form>
    </div>
</x-app-layout>
