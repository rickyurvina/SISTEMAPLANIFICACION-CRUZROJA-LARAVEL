<div>
  <div class="card">
            <x-search route="{{ route('source-information.index') }}"/>
    <div class="table-responsive">
      <table class="table m-0">
        <thead class="bg-primary-50">
        <tr>
          <th>@sortablelink('code', trans('general.code'))</th>
          <th>@sortablelink('description', trans('general.description'))</th>
          @can('budget-crud-budget')
          <th class="text-center color-primary-500">{{ trans('general.actions') }}</th>
          @endcan
        </tr>
        </thead>
        <tbody>
        @foreach($financialSource as $item)
          <tr>
            <td>{{ $item->code }}
            </td>
            <td>{{ $item->description }}</td>
            @can('budget-crud-budget')
            <td class="text-center">

            </td>
            @endcan
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
            <x-pagination :items="$financialSource"/>
  </div>

</div>
