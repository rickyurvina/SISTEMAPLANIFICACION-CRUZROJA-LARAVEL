@if($viewPoaActivity)
    @include('modules.budget.certifications.create.header-poa')
    @if($expensesPoa->count()>0)
        <div class="table-responsive">
            <table class="table table-light table-hover">
                @include('modules.budget.certifications.create.header-table-form')
                <tbody>
                @foreach($expensesPoa as $item)
                    @include('modules.budget.certifications.create.body-table-form')
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endif