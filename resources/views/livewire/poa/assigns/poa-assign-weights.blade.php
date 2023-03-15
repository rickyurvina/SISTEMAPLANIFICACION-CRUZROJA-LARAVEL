<div wire:ignore.self class="modal fade in" id="poa-assign-weights" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-info">
                    {{ __('general.assign_weights') }}
                </h5>
                <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <form wire:submit.prevent="submitAssign()" method="post" autocomplete="off">
                <div class="modal-body">
                    <div class="card-body p-3">
                        @if($programs)
                            <div class="row">
                                <div class="col-lg-12 required">
                                    <table class="table table-bordered table-hover m-0">
                                        <thead class="thead-themed">
                                        <tr>
                                            <th class=" text-center" tabindex="0" aria-controls="dt-basic-example" rowspan="1" colspan="2">
                                                <h3>{{trans('general.programs_weights')}}</h3></th>
                                        </tr>
                                        <tr role="row">
                                            <th class=" text-center" rowspan="1" colspan="1">
                                                <span class="">{{trans('general.name')}}</span></th>
                                            <th class="text-center" rowspan="1"
                                                colspan="1">{{trans('general.value')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($programs as $index => $program)
                                            <tr>
                                                <th scope="row" class="text-center align-middle w-75">{{ $program->planDetail->name }}</th>
                                                <td class="text-center w-25">
                                                    <input type="number" step="0.01" min="0" max="100" pattern="^[0-9]+"
                                                           style="width: 60%; margin: 0 auto; margin-left: 20%; padding-left: 2em"
                                                           wire:model="weights.{{$index}}"
                                                           class="form-control bg-transparent text-center w-100 p-2 ml-0">
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr id="1" role="row" class="add">
                                            <td class="dtr-control text-center">
                                                <h4>{{trans('general.sum_weights')}}</h4>
                                            </td>
                                            <td class="dtr-control text-center">
                                                @if($sumWeights==100)
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
                            </div>
                            <div class="col-12 text-center">
                                @if($sumWeights!=100)
                                    <h2 class="badge badge-danger badge-pill">{{trans('general.sum_of_weights')}}
                                        100</h2>
                                @endif
                            </div>
                        @endif
                        <div class="modal-footer justify-content-center   ">
                            @if($sumWeights==100 )
                                <x-form.modal.footer wirecancelevent="resetForm" class="disabled"></x-form.modal.footer>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>