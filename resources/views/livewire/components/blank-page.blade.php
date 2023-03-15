<div>
        <div class="h-alt-hf d-flex flex-column align-items-center justify-content-center text-center">
            <div class="alert alert-danger bg-white pt-4 pr-2 pb-3 pl-2" id="demo-alert">

                <img  src="{{ asset_cdn("img/no_info.png") }}" width="auto" height="auto" alt="No Info">

                <h1 class="fs-xxl fw-700 color-fusion-500 d-flex align-items-center justify-content-center m-0">
                    <span class="color-danger-700">{{$title}}</span>
                </h1>
                <h3 class="fw-500 mb-0 mt-3">
                    {{$subTitle}}
                </h3>
                <p class="container container-sm mb-0 mt-1">
                    {{$content}}
                </p>
                {{--            <div class="mt-4">--}}
                {{--                <a href="#" class="btn btn-outline-default bg-fusion-800">--}}
                {{--                    <span class="fw-700">Cancel</span>--}}
                {{--                </a>--}}
                {{--                <a href="#" class="btn btn-primary">--}}
                {{--                    <span class="fw-700">Continue</span>--}}
                {{--                </a>--}}
                {{--            </div>--}}
            </div>
        </div>
</div>
