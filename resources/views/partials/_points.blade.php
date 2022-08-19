@if ($hasLinkedSteam)
    <div class="{{ $header ? 'd-flex align-items-center' : 'd-inline-block fs-6' }}">
        <img src="{{ asset('images/icon-point.png') }}" style="margin-right: 6px;">
        <span class="total-points {{ $header ? 'fs-4' : ''}}" id="total-points" akhi="{{ $playerPoints }}">0</span>
        <span style="font-size:16px;color:#fff">Points</span>
    </div>
@else
<div class="{{ $header ? 'd-flex align-items-center' : 'd-inline-block fs-6' }}" data-bs-title="Liez votre compte Steam pour avoir accès à vos Points et d'autres fonctionnalitées! (Rubrique Social dans votre compte)" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-container="body">
    <img src="{{ asset('images/icon-point.png') }}" style="margin-right: 6px;">
    <span class="total-points {{ $header ? 'fs-4' : ''}}" id="total-points" akhi="0">0</span>
    <span style="font-size:16px;color:#fff">Points</span>
</div>
@endif