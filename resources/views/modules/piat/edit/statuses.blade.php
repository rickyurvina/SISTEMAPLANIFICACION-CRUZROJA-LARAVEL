<div class="float-right" style="margin-top: 0.5rem;">
    <ol class="breadcrumb breadcrumb-lg breadcrumb-arrow mb-0">
        <li class="@if ($piat->status->isActive(\App\States\Poa\Piat\Pending::class)) active @endif">
            <a href="#" @if ($piat->status->to() instanceof \App\States\Poa\Piat\ApprovedPiat)  @endif
            wire:click="changeStatus">
                <span class="badge border rounded-pill bg-white">1</span>
                <span
                        class="hidden-md-down">{{ \App\States\Poa\Piat\Pending::label() }}</span>
            </a>
        </li>
        <li class="@if ($piat->status->isActive(\App\States\Poa\Piat\ApprovedPiat::class)) active @endif">
            <a href="#" @if ($piat->status->to() instanceof \App\States\Poa\Piat\Confirmed)  @endif
            wire:click="changeStatus">
                <span class="badge border rounded-pill bg-white">2</span>
                <span
                        class="hidden-md-down">{{ \App\States\Poa\Piat\ApprovedPiat::label() }}</span>
            </a>
        </li>
        <li class="@if ($piat->status->isActive(\App\States\Poa\Piat\Confirmed::class)) active @endif">
            <a href="#" @if ($piat->status->to() instanceof \App\States\Poa\Piat\Pending)  @endif
            wire:click="changeStatus">
                <span class="badge border rounded-pill bg-white">3</span>
                <span class="hidden-md-down">{{ \App\States\Poa\Piat\Confirmed::label() }}</span>
            </a>
        </li>
    </ol>
</div>