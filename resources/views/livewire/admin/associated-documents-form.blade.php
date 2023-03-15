<div class="tab-pane fade" id="associated_documents" role="tabpanel">
    <div class="card">
        <x-empty-content>
            <x-slot name="img">
                <i class="fas fa-cloud-upload-alt" style="color: #2582fd;"></i>
            </x-slot>
            <x-slot name="title">
                {{ trans('general.files') }}
            </x-slot>
            <x-slot name="info">
                {{ trans('messages.info.empty_attachment') }}
            </x-slot>
            <div class="d-flex flex-column">
                <a href="#" x-on:click.prevent="$refs.input.click()"><i class="fas fa-paperclip"></i> {{ trans('general.add_attachments') }}</a>
                <div x-show="isUploading">
                    <progress max="100" x-bind:value="progress"></progress>
                </div>
            </div>
        </x-empty-content>
        <input type="file" wire:model="file" style="display: none" x-ref="input" id="fileInput">
    </div>
</div>

{{-- <div class="tab-pane fade" id="associated_documents" role="tabpanel">
    <form wire:submit.prevent="submit" enctype="multipart/form-data">
  
        <div>
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>
      
        <div class="form-group">
            <label for="exampleInputName">Title:</label>
            <input type="text" class="form-control" id="exampleInputName" placeholder="Enter title" wire:model="title">
            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputFile">File:</label>
            <input type="file" class="form-control" id="exampleInputFile" wire:model="file">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
      
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div> --}}