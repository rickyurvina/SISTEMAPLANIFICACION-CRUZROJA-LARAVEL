<div class="card-footer-pagination text-muted py-2">
    @if ($items->firstItem())
        {!! $items->withPath(request()->url())->appends(request()->except('page'))->links() !!}
    @endif
</div>
