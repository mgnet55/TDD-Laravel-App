<x-app-layout>

    <div class="flex mb-3 py-4">
        <div class="flex justify-between w-full items-end">
            <h2 class="text-sm text-gray-400">My Projects</h2>
            <a href="{{route('projects.create')}}" class="btn btn-blue">New Project</a>
        </div>
    </div>


    <div class="lg:flex lg:flex-wrap -mx-3">

        @forelse($projects as $project)

            <div class="lg:w-1/3 px-3 pb-6">
                <x-project.card :project="$project"></x-project.card>
            </div>
        @empty
            <div>No projects yet.</div>
        @endforelse
    </div>



</x-app-layout>

