<div>
    <div class="row" x-data="{
                    isAdding: false
                }" x-cloak>

        <div class="form-group col-lg-2">
            <input type="text" class="form-control form-control-sm rounded-0 cursor-text add-input @error('code') is-invalid  @enderror" placeholder="{{__('general.code')}}"
                   x-on:focus="isAdding = true"
                   x-on:click.outside="isAdding = false;"
                   x-ref="inputText"
                   x-on:keydown.escape="isAdding = false"
                   wire:model.defer="code"
            >
            <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('code',':message') }} </div>
        </div>

        <div class="form-group col-lg-8">
            <input type="text" class="form-control form-control-sm rounded-0 cursor-text add-input @error('newPlanDetail') is-invalid  @enderror"" placeholder="{{__('general.name')}}"
                   x-on:focus="isAdding = true"
                   x-on:click.outside="isAdding = false;"
                   x-ref="inputText"
                   x-on:keydown.escape="isAdding = false"
                   wire:model.defer="newPlanDetail"
            >
            <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('newPlanDetail',':message') }} </div>

        </div>

        <div class="form-group col-lg-2">
            <div class="input-group-append">
                <button class="btn btn-sm btn-primary shadow-0 rounded-0" type="button" id="button-addon2"
                        wire:click="save"
                >+ {{__('general.add')}}
                </button>
            </div>
        </div>
    </div>


</div>