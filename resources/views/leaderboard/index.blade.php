@extends('layouts.app')
{!! config(['app.title' => 'Classement']) !!}

@section('content')
<div class="container">

    <div class="row">
        <div class="col-12">
            {!! $breadcrumbs->render() !!}
        </div>
    </div>

    <h1 class="text-center fs-3 pt-3 mb-4" style="color:#bfb59e;border-bottom:1px solid #443c32">
        Classement des joueurs Division
    </h1>

    <div class="row">
        <div class="col-lg-12 align-self-stretch">

            <div class="h-100">
                <div class="row">
                    <span class="text-muted text-center text-lg-end mb-4">
                        Prochaine mise à jour le {{ $refresh->format('d-m-Y à H:i:s') }}
                    </span>
                    <div class="col-lg-2 nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @if ($bossKills)
                            <button class="nav-link active" id="v-pills-bosskills-tab" data-bs-toggle="pill" data-bs-target="#v-pills-bosskills" type="button" role="tab" aria-controls="v-pills-bosskills" aria-selected="true">Boss Kills</button>
                        @endif
                        @if ($purpleOSDWaves)
                            <button class="nav-link" id="v-pills-purpleosdwaves-tab" data-bs-toggle="pill" data-bs-target="#v-pills-purpleosdwaves" type="button" role="tab" aria-controls="v-pills-purpleosdwaves" aria-selected="false">Vagues POD Violet</button>
                        @endif
                        @if ($fishCaughts)
                            <button class="nav-link" id="v-pills-fishcaught-tab" data-bs-toggle="pill" data-bs-target="#v-pills-fishcaught" type="button" role="tab" aria-controls="v-pills-fishcaught" aria-selected="false">Poissons Pêchés</button>
                        @endif
                    </div>

                    <div class="col-lg-10 tab-content" id="v-pills-tabContent">
                        @if ($bossKills)
                            <div class="tab-pane fade show active" id="v-pills-bosskills" role="tabpanel" aria-labelledby="v-pills-bosskills-tab" tabindex="0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Joueur</th>
                                        <th scope="col">Tribu</th>
                                        <th scope="col">Boss Kills</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bossKills as $bossKill)
                                        <tr>
                                            <th scope="row">{{ $bossKill->Name }}</th>
                                            <td>{{ $bossKill->TribeName }}</td>
                                            <td>{{ $bossKill->BossKills }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif

                        @if ($purpleOSDWaves)
                        <div class="tab-pane fade" id="v-pills-purpleosdwaves" role="tabpanel" aria-labelledby="v-pills-purpleosdwaves-tab" tabindex="0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Joueur</th>
                                        <th scope="col">Tribu</th>
                                        <th scope="col">POD Violet Vague Max</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purpleOSDWaves as $purpleOSDWave)
                                        <tr>
                                            <th scope="row">{{ $purpleOSDWave->Name }}</th>
                                            <td>{{ $purpleOSDWave->TribeName }}</td>
                                            <td>{{ $purpleOSDWave->PurpleOSDWaves }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif

                        @if ($fishCaughts)
                        <div class="tab-pane fade" id="v-pills-fishcaught" role="tabpanel" aria-labelledby="v-pills-fishcaught-tab" tabindex="0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Joueur</th>
                                        <th scope="col">Tribu</th>
                                        <th scope="col">Poissons Pêchés</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fishCaughts as $fishCaught)
                                        <tr>
                                            <th scope="row">{{ $fishCaught->Name }}</th>
                                            <td>{{ $fishCaught->TribeName }}</td>
                                            <td>{{ $fishCaught->FishCaught }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                  </div>

            </div>

        </div>
    </div>

</div>
@endsection
