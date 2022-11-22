<x-app-layout>

    <div class="flex mb-3 py-4">
        <div class="flex justify-between w-full items-end">
            <h2 class="text-gray-400">My Projects</h2>
            <a href="{{route('projects.create')}}" class="btn btn-blue">New Project</a>
        </div>
    </div>


    <div class="lg:flex lg:flex-wrap -mx-3">

        @forelse($projects as $project)

            <div class="lg:w-1/3 px-3 pb-6">
                <div class="bg-white rounded-lg p-5 shadow" style="height:200px">
                    <h3 class="font-normal text-xl mb-3 py-4 border-l-4 border-blue-picton -ml-5 pl-4"><a href="{{route('projects.show',$project)}}">{{$project->title}}</a></h3>
                    <div class="text-gray-400">{{Str::limit($project->description,100)}}</div>
                </div>
            </div>
        @empty
            <div>No projects yet.</div>
        @endforelse
    </div>



</x-app-layout>

