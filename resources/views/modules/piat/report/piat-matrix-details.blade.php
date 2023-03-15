@if($piat)
    <div class="d-flex flex-wrap align-items-center justify-content-between w-100 mr-2">
        <div class="d-flex flex-wrap w-100">
            <div class="d-flex flex-wrap p-2 w-100">
                <x-label-section>{{ trans('poa.piat_matrix_create_placeholder_name')}}</x-label-section>
                <x-content-detail>{{ $this->piat->name}}</x-content-detail>
            </div>
            <div class="d-flex flex-wrap p-2 w-50">
                <x-label-section>{{ trans('poa.piat_matrix_create_placeholder_place')}}</x-label-section>
                <x-content-detail>{{ $this->piat->place}}</x-content-detail>
            </div>
            <div class="d-flex p-2 w-50">
                <x-label-section>{{ trans('general.location')}}</x-label-section>
                <x-content-detail>{{ $this->piat->location($this->piat->parish)->getPath()}}</x-content-detail>
            </div>
            <div class="d-flex p-2 w-25">
                <x-label-section>{{ trans('poa.piat_matrix_create_placeholder_date')}}</x-label-section>
                <x-content-detail>{{ $this->piat->date}}</x-content-detail>
            </div>
            <div class="d-flex p-2 w-25">
                <x-label-section>{{ trans('poa.piat_matrix_create_placeholder_end_date')}}</x-label-section>
                <x-content-detail>{{ $this->piat->end_date}}</x-content-detail>
            </div>
            <div class="d-flex p-2 w-25">
                <x-label-section>{{ trans('poa.piat_matrix_create_placeholder_initial_time')}}</x-label-section>
                <x-content-detail>{{ $this->piat->initial_time}}</x-content-detail>
            </div>
            <div class="d-flex p-2 w-25">
                <x-label-section>{{ trans('poa.piat_matrix_create_placeholder_end_time')}}</x-label-section>
                <x-content-detail>{{ $this->piat->end_time}}</x-content-detail>
            </div>

            <div class="d-flex p-2 w-25">
                <x-label-section>{{ trans('poa.piat_matrix_create_placeholder_resp_male')}}</x-label-section>
                <x-content-detail>{{ $this->piat->manResponsibles()}}</x-content-detail>
            </div>
            <div class="d-flex p-2 w-25">
                <x-label-section>{{ trans('poa.piat_matrix_create_placeholder_resp_female')}}</x-label-section>
                <x-content-detail>{{ $this->piat->womenResponsibles()}}</x-content-detail>
            </div>
            <div class="d-flex p-2 w-25">
                <x-label-section>{{ trans('poa.piat_matrix_create_placeholder_vol_male')}}</x-label-section>
                <x-content-detail>{{ $this->piat->males_volunteers}}</x-content-detail>
            </div>
            <div class="d-flex p-2 w-25">
                <x-label-section>{{ trans('poa.piat_matrix_create_placeholder_vol_female')}}</x-label-section>
                <x-content-detail>{{ $this->piat->females_volunteers}}</x-content-detail>
            </div>
        </div>
    </div>
@endif