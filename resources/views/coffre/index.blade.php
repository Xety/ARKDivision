@extends('layouts.app')
{!! config(['app.title' => 'Coffrees']) !!}

@section('content')
<div class="container">

    <div class="row">
        <div class="col-12">
            {!! $breadcrumbs->render() !!}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
            @include('partials.user._sidebar')
        </div>
        <div class="col-lg-9">
            <h1 class="p-2" style="color:#bfb59e;border-bottom:1px solid #443c32">
                Coffres
            </h1>

            <div class="row">
                <div class="col-12 pb-3">
                    <div class="alert alert-primary" role="alert">
                        <i aria-hidden="true" class="fa fa-exclamation"></i> Les coffres sont réinitialisés à chaque début de mois.
                    </div>

                    @php
                        $day = 1;
                    @endphp
                    @while ($day <= $days)

                        @if ($day == 1 || $day == 6 || $day == 11 || $day == 16 || $day == 21 || $day == 26)
                            <div class="row justify-content-center">
                        @endif

                        <div class="col-lg-2" style="border:1px solid; min-height:100px">
                            {{ $day }}
                            @if ($day <= Auth::user()->claimed_coffre_count_monthly)
                                CLAIMED
                            @endif

                            @if (($day == Auth::user()->claimed_coffre_count_monthly + 1) && $nextClaimDate < $now)
                                CLAIMABLE
                            @endif

                            @if (array_key_exists('bonus_' . $day . '_days_points_amount' ,config('division.coffres.bonus_points')))
                                Bonus de {{ config('division.coffres.bonus_points.' . 'bonus_' . $day . '_days_points_amount') }}
                            @endif
                        </div>

                        @if ($day == 5 || $day == 10 || $day == 15 || $day == 20 || $day == 25 || $day == 30)
                            </div>
                        @endif

                        @php
                            $day++;
                        @endphp
                    @endwhile

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
