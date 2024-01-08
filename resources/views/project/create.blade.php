<x-app-layout>
    <form method="POST" action="/projects">
        @csrf
        <h1 class="heading is-1">Create a project</h1>

        <div class="field">
            <label for="title" class="label">Title</label>

            <div class="control">
                <input type="text" name="title" placeholder="Title">
            </div>
        </div>

        <div class="field">
            <label for="description" class="label">Description</label>

            <div class="control">
                <textarea name="description" id="" cols="30" rows="10"></textarea>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button type="submit">Create Project</button>

                <a href="/projects">Cancel</a>
            </div>
        </div>
    </form>
</x-app-layout>
