<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <title></title>
</head>
<body>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="/projects" class="container pt-3" method="POST">


    @csrf
    <h1 class="heading is-1">Create a Project</h1>
    <div class="field">
        <label class="label" for="title">Title</label>
        <div class="control">
            <input class="input" name="title"type="text" placeholder="Enter placeholder">
        </div>
    </div>

    <div class="field">
        <label for="description" class="label">Description</label>
        <div class="control">
            <textarea class="textarea" name="description" placeholder="placeholder" rows="5"></textarea>
        </div>
    </div>

    <div class="field">
        <div class="control">
            <button class="button is-link" type="submit">Create Project</button>
        </div>
    </div>
</form>
</body>

</html>
