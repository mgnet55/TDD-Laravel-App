<div class="card flex flex-col mt-3" style="min-height:200px">
    <h3 class="font-normal text-xl mb-3 py-4 border-l-4 border-blue-picton -ml-5 pl-4">Invite a User</h3>

    <form action="{{route('projects.invite',$project)}}" method="post">
        @csrf
        <div class="mb-3">
            <label>
                <input
                    type="email"
                    name="email"
                    required
                    class="border border-grey rounded w-full"
                    placeholder="user@example.com">
            </label>
        </div>
        <button type="submit" class="btn btn-blue">Invite</button>

        <x-errors :bag="'invitations'" class="mt-2"/>

    </form>
</div>
