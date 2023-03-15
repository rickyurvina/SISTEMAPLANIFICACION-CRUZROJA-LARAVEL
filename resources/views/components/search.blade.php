<form action="{{ $route }}" method="get">
    <div class="card-header pr-2 d-flex align-items-center flex-wrap">
        <div class="d-flex position-relative ml-auto w-100">
            <i class="fal fa-search position-absolute pos-left fs-lg px-3 py-2 mt-1"></i>
            <input type="text" id="search" name="search" value="{{ request()->get('search', '') }}" class="form-control bg-subtlelight pl-6"
                   placeholder="{{ trans('general.search_placeholder') }}">
        </div>
    </div>
</form>