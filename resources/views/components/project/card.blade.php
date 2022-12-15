<div class="card flex flex-col" style="height:200px">
    <h3 class="font-normal text-xl mb-3 py-3.5 border-l-4 border-blue-picton -ml-5 pl-4"><a
            href="{{route('projects.show',$project)}}">{{$project->title}}</a></h3>
    <div class="text-gray-400 mb-2 flex-1">{{Str::limit($project->description,100)}}</div>

    <footer class="mb-3">
        @can('owner',$project)
            <form action="{{route('projects.destroy',$project)}}" method="post" class="text-right">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs">Delete</button>

            </form>
        @endcan
    </footer>
</div>
