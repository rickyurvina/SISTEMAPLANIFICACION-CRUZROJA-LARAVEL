<div wire:ignore.self class="modal fade in" id="project-create-services" tabindex="-1" role="dialog"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary color-white">
                <h5 class="modal-title h4">{{ __('general.service') }} de {{$result->text ??''}}</h5>
                <button type="button" wire:click="resetForm()" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            @if($linesAction)
                <div class="modal-body">
                    @if($result)
                        <div class="row">
                            <div class="form-group col-12" wire:ignore>
                                <select class="form-control" id="select2-services">
                                    @foreach($linesAction as $line)
                                        @if($line->services->count()>0)
                                            <optgroup label=" {{trans('general.lines_action').' '. $line->name}}" class="bg-gray-100">
                                                @foreach($line->services as $item)
                                                    @if($auxServices)
                                                        <option value="{{ $item->id }}" {{ in_array($item->id, $this->auxServices) ? 'selected':'' }}>{{ $item->name }}</option>
                                                    @else
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endif
                                                @endforeach
                                            </optgroup>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

@push('page_script')
    <script>
        window.addEventListener('updateSelector', event => {
            $('#select2-services').select2({
                dropdownParent: $("#project-create-services"),
                placeholder: "{{ trans('general.select').' '.trans('general.services') }}"
            }).on('change', function (e) {
            @this.set('servicesSelect', $(this).val());
            });
        });

        $('#select2-services').select2({
            dropdownParent: $("#project-create-services"),
            placeholder: "{{ trans('general.select').' '.trans('general.services') }}"
        }).on('change', function (e) {
        @this.set('servicesSelect', $(this).val());
        });

    </script>
@endpush
