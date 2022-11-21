<x-app-layout>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="/projects" class="pt-3" method="POST">


        @csrf
        <h1 class="heading is-1">Create a Project</h1>
        <div class="field">
            <label class="label" for="title">Title</label>
            <div class="control">
                <input class="input" name="title" type="text" placeholder="Enter placeholder">
            </div>
        </div>

        <div class="field">
            <label for="description" class="label">Description</label>
            <div class="control">
                <textarea class="textarea" name="description" placeholder="placeholder" rows="5"></textarea>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="btn btn-primary" type="submit">Create Project</button>
                <a href="{{route('projects.index')}}" class="btn btn-default">Cancel</a>
            </div>
        </div>
    </form>

</x-app-layout>
