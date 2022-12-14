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
        <form action="{{route('projects.store')}}" class="pt-3" method="POST">
            @include('projects._form',['project' =>new App\Models\Project ,'buttonText'=>'Create Project','cancelRoute'=>'index'])
        </form>
    </div>

</x-app-layout>
