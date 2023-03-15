
<div class="col-12">
    <div class="p-3 text-center">
        @foreach($user->roles as $role)
            <span class="badge badge-info badge-pill">{{ $role->name }}</span>
        @endforeach
    </div>
</div>
<div class="col-12">
    <div class="p-3 text-center">
        @foreach($user->companies as $company)
            <span class="badge badge-primary badge-pill">{{ $company->name }}</span>
        @endforeach
    </div>
</div>