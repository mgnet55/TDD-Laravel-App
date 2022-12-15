@props(['bag'=>'default'])
@if($errors->$bag->any())
    <ul {{$attributes}}>
        @foreach($errors->$bag->all() as $error)
            <li class="text-red-600 text-sm">{{$error}}</li>
        @endforeach
    </ul>
@endif
