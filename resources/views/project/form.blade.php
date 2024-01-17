@csrf

<div class="field mb-6">
    <label for="title" class="label text-sm mb-2 block">
        Title
    </label>

    <div class="control">
        <input
            type="text"
            name="title"
            placeholder="Title"
            value="{{ $project->title }}"
            required
            class="input bg-transparent border border-gray-400 rounded p-2 text-xs w-full">
    </div>
</div>

<div class="field">
    <label for="description" class="label">Description</label>

    <div class="control">
        <textarea
            class="w-full border border-gray-400 rounded p-2"
            name="description"
            id=""
            cols="5"
            rows="6"
            required>
            {{ $project->description  }}
        </textarea>
    </div>
</div>

<div class="field">
    <div class="control">
        <button type="submit" class="button">{{ $buttonText }}</button>

        <a href="{{ $project->path() }}">Cancel</a>
    </div>
</div>

    @if($errors->any())
        <div class="field mt-6">
                @foreach($errors->all() as $error)
                    <li class="text-sm text-red-500">{{ $error }}</li>
                @endforeach
        </div>
    @endif
</form>
