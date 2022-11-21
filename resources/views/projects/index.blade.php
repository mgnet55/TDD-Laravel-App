<x-app-layout>

    <div class="flex items-center mb-3">
        <a href="{{route('projects.create')}}" class="btn btn-primary">New Project</a>
    </div>


    <div class="flex">

        @forelse($projects as $project)
        <div class="bg-white mr-4 rounded p-5 shadow w-1/3">
            <h3 class="font-normal text-xl py-4">{{$project->title}}</h3>
            <div class="text-gray-400">{{Str::limit($project->description,100)}}</div>
        </div>
        @empty
            <div>No projects yet.</div>
        @endforelse
    </div>



</x-app-layout>

