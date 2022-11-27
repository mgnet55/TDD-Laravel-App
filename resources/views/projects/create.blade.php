<x-app-layout>
    <div class="flex mb-3 py-4">
        <div class="flex justify-between w-full items-end">
            <p class="text-gray-400 text-sm">
                <a href="{{route('projects.index')}}">My Projects</a>
            </p>
        </div>
    </div>

    <div class="card">

        <h2 class="text-lg text-gray-400 mb-3">Create Project</h2>

        <form action="/projects" class="pt-3" method="POST">
            @if ($errors->any())
                <div class="text-red-600 mb-2">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>* {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @csrf

            <div class="mb-2">
                <label class="" for="title">Title
                    <input class="w-full rounded" name="title" type="text" placeholder="title">
                </label>
            </div>

            <div class="mb-2">
                <label for="description" class="">Description
                    <input class=" w-full rounded" name="description" type="text" placeholder="description">
                </label>
            </div>

            <div class="mb-2">
                <label for="notes" class="w-full">General Notes
                    <textarea class="w-full rounded" name="notes" placeholder="notes" rows="5"></textarea>
                </label>
            </div>


            <button class="btn btn-blue" type="submit">Create Project</button>
            <a href="{{route('projects.index')}}" class="btn bg-gray-800">Cancel</a>
        </form>
    </div>

</x-app-layout>
