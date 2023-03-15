<div class="col-12">
    <div class="d-flex flex-column align-items-center justify-content-center p-4">
        @if (is_object($user->picture))
            <img src="{{ Storage::url($user->picture->id) }}" class="rounded-circle width-2" alt="{{ $user->name }}">
        @else
            <img src="{{ asset_cdn("img/user.svg") }}" class="rounded-circle width-2" alt="{{ $user->name }}">
        @endif
        <h5 class="mb-0 fw-700 text-center mt-3">
            @if(\Illuminate\Support\Facades\Auth::user()->id==$user->id)
                <a href="javascript:void(0);" data-toggle="modal" data-target="#edit_contact_modal"
                   data-id="{{ $user->id }}" class="dropdown-item">
                    {{$user->getFullName()}}
                </a>
            @else
                {{$user->getFullName()}}
            @endif

            <small class="text-muted mb-0">{{$user->personal_notes}}</small>
        </h5>
        <div class="mt-4 text-center demo">
            <a href="javascript:void(0);" class="fs-xl" style="color:#3b5998">
                <i class="fab fa-facebook"></i>
            </a>
            <a href="javascript:void(0);" class="fs-xl" style="color:#38A1F3">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="javascript:void(0);" class="fs-xl" style="color:#0077B5">
                <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="javascript:void(0);" class="fs-xl" style="color:#00AFF0">
                <i class="fab fa-skype"></i>
            </a>
        </div>
    </div>
</div>
