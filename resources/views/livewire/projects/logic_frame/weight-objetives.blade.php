<div wire:ignore.self class="modal fade" id="project-objectives-weight" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">{{ trans('general.assign_weights') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetForm">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            @if($objectives)
                <div class="modal-body">
                    <table class="table table-bordered table-hover m-0">
                        <thead class="thead-themed">
                        <tr class="text-center">
                            <th class="w-75">{{ trans_choice('general.result',1) }}</th>
                            <th class="w-25">{{ __('general.weight') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($i = 0)
                        @foreach($objectives as $item)
                            <tr>
                                <th scope="row" class="text-center align-middle w-75">{{ $item->name }}</th>
                                <td class="text-center w-25">
                                    <input type="number" step="0.01" min="0" max="100" pattern="^[0-9]+"
                                           style="width: 60%; margin: 0 auto; margin-left: 20%; padding-left: 2em"
                                           wire:model="weights.{{ $i++ }}.weight"
                                           class="form-control bg-transparent text-center w-100 p-2 ml-0">
                                </td>
                            </tr>
                        @endforeach
                        <tr id="1" role="row" class="add">
                            <td class="dtr-control text-center">
                                <h4>{{trans('general.sum_weights')}}</h4>
                            </td>
                            <td class="dtr-control text-center">
                                @if($sumWeights == 100)
                                    <span class="badge badge-success badge-pill"
                                          style="margin-left: 5%;">{{ round($sumWeights,2) }}%</span>
                                @else
                                    <span class="badge badge-danger badge-pill"
                                          style="margin-left: 5%;">{{ round($sumWeights,2) }}%</span>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                @if($sumWeights!=100)
                    <div class="col-12 text-center">
                        <h2 class="badge badge-danger badge-pill">{{ trans('general.sum_of_weights') }} 100</h2>
                    </div>
                @else
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-outline-secondary mr-1" data-dismiss="modal">
                            <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                        </button>
                        <button wire:click="store()" type="button" class="btn btn-primary waves-effect waves-themed">{{ __('general.save') }}</button>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>