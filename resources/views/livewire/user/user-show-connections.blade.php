<div wire:ignore.self class="modal fade in" id="user-show-connections" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 60% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-info">
                    {{trans('general.connections')}}   {{trans('general.of')}}  {{$user->getFullName()}}
                </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body" style="overflow-y: auto; height:450px; ">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover m-0">
                            <thead class="bg-primary-50">
                            <tr>
                                <th>{{trans('general.date')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($connections as $item)
                                <tr>
                                    <td>{{ $item->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{--                    <x-pagination :items="$connections"/>--}}
                </div>
            </div>
        </div>
    </div>
</div>