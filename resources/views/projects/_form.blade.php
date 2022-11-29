@if ($errors->any())
    <div class="text-red-600 mb-2 text-sm">
        <ul class="list-disc">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@csrf

<div class="mb-2">
    <label for="title">Title
        <input class="w-full rounded" type="text" required name="title" placeholder="title"
               value="{{$project->title}}">
    </label>
</div>

<div class="mb-2">
    <label for="description">Description
        <input class=" w-full rounded" type="text" required name="description" placeholder="description"
               value="{{$project->description}}">
    </label>
</div>

<div class="mb-2">
    <label for="notes">General Notes
        <textarea class="w-full rounded" rows="5" name="notes" placeholder="notes">{{$project->notes}}</textarea>
    </label>
</div>


<button class="btn btn-blue" type="submit">{{$buttonText}}</button>
<a href="{{url('projects/'.$project->id)}}" class="btn bg-gray-800">Cancel</a>

