@if($viewProjectActivity)
    @include('modules.budget.certifications.create.header-projects')
    @if($expensesProject)
        <div class="table-responsive">
            <table class="table table-light table-hover">
                @include('modules.budget.certifications.create.header-table-form')
                <tbody>
                @foreach($expensesProject as $item)
                    @include('modules.budget.certifications.create.body-table-form')
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endif
