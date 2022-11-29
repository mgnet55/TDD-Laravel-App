<x-app-layout>

    <div class="flex mb-3 py-4">
        <div class="flex justify-between w-full items-end">
            <p class="text-gray-400 text-sm">
                <a href="{{route('projects.index')}}">My Projects</a>
            </p>
        </div>
    </div>

    <div class="card">

        <h2 class="text-lg text-gray-400 mb-3">Update Project</h2>
        <form action="{{route('projects.update',$project)}}" class="pt-3" method="POST">
            @method('PATCH')
            @include('projects._form',['buttonText'=>'Update Project','cancelRoute'=>'show'])
        </form>
    </div>

</x-app-layout>
