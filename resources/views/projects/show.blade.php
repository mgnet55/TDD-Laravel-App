<x-app-layout>


    <h1>{{$project->title}}</h1>
    <div>{{$project->description}}</div>

    <a href="{{route('projects.index')}}" class="btn btn-default">Go Back</a>

</x-app-layout>
