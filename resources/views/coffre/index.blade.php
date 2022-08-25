@extends('layouts.app')
{!! config(['app.title' => 'Coffrees']) !!}

@push('scripts')
<script type="text/javascript">
let items = document.querySelectorAll('.carousel .carousel-item')

items.forEach((el) => {
    const minPerSlide = 6;
    let next = el.nextElementSibling;
    for (var i=1; i<minPerSlide; i++) {
        if (!next) {
            // wrap carousel by using first child
        	next = items[0]
      	}
        let cloneChild = next.cloneNode(true);
        el.appendChild(cloneChild.children[0]);
        next = next.nextElementSibling;
    }
});
</script>
    @if ($user->last_claimed_coffre->isSameDay($nextClaimDatePreviousDay) == true)
    <script>
        // The data/time we want to countdown to
        var countDownDate = new Date('{{ $nextClaimDate->format('F d, Y H:i:s') }}').getTime();

        // Run myfunc every second
        var myfunc = setInterval(function() {

        var now = new Date().getTime();
        var timeleft = countDownDate - now;

        // Calculating the days, hours, minutes and seconds left
        var hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);

        // Result is output to the specific element
        document.getElementById("hours").innerHTML = hours + "h "
        document.getElementById("mins").innerHTML = minutes + "m "
        document.getElementById("secs").innerHTML = seconds + "s "

        // Display the message when countdown is over
        if (timeleft < 0) {
            clearInterval(myfunc);
            document.getElementById("hours").innerHTML = ""
            document.getElementById("mins").innerHTML = ""
            document.getElementById("secs").innerHTML = ""
            document.getElementById("timer-end").innerHTML = "";
        }
        }, 1000);
    </script>
    @endif
@endpush

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
                    <div class="alert alert-primary mb-3" role="alert">
                        <i aria-hidden="true" class="fa fa-exclamation"></i> Les coffres seront réinitialisés le {{ $firstDayOfNextMonth->format('d-m-Y') }}
                    </div>

                    <div class="mb-3">
                        <span id="timer-end" class="test-muted">
                            @if ($user->last_claimed_coffre->isSameDay($nextClaimDatePreviousDay) == true)
                                Le prochain coffre sera dévérouillé dans <span id="hours">xh</span>  <span id="mins">xm</span> <span id="secs">xs</span>
                            @endif
                        </span>
                    </div>

                    <div class="row mx-auto my-auto justify-content-center">
                        <div id="coffresCarousel" class="carousel slide" data-bs-ride="false">
                            <div class="carousel-inner" role="listbox">
                                @php
                                    $day = 1;
                                @endphp
                                @while ($day <= $days)
                                    @php
                                        $claimed = false;
                                        $claimable = false;
                                        $bonus = false;

                                        if ($day <= $user->claimed_coffre_count_monthly) {
                                            $claimed = true;
                                        }

                                        if (($day == $user->claimed_coffre_count_monthly + 1) && ($user->last_claimed_coffre->isSameDay($nextClaimDatePreviousDay) == false)) {
                                            $claimable = true;
                                        }

                                        if (array_key_exists('bonus_' . $day . '_days_points_amount' ,config('division.coffres.bonus_points'))) {
                                            $bonus = true;
                                        }
                                    @endphp

                                    <div class="carousel-item {{ $claimable ? 'active' : '' }} {{ ($claimed == false && $claimable == false && $day == Auth::user()->claimed_coffre_count_monthly + 1) ? 'active' : '' }}">
                                        <div class="col-lg-2">
                                            <div class="card text-center" style="border:0px;">

                                                    {{-- If the coffre is Claimed --}}
                                                    @if ($claimed)
                                                            @if ($bonus)
                                                                <div class="card-img">
                                                                    <img src="{{ asset('images/coffres/chest-bonus-open.jpg') }}" class="img-fluid" style="top: inherit;">
                                                                </div>
                                                                <div class="card-img-overlay" style="top: inherit;">
                                                                    Jour {{ $day }}
                                                                </div>
                                                            @else
                                                                <div class="card-img">
                                                                    <img src="{{ asset('images/coffres/chest-open.jpg') }}" class="img-fluid">
                                                                </div>
                                                                <div class="card-img-overlay" style="top: inherit;">
                                                                    Jour {{ $day }}
                                                                </div>
                                                            @endif
                                                    @endif

                                                    {{-- If the coffre is Claimable --}}
                                                    @if ($claimable)
                                                            @if ($bonus)
                                                                <a href="{{ route('users.coffre.claim') }}" onclick="event.preventDefault(); document.getElementById('coffre-claim-form').submit();">
                                                                    <div class="card-img">
                                                                        <img src="{{ asset('images/coffres/chest-bonus-highlight.jpg') }}" class="img-fluid">
                                                                    </div>
                                                                    <div class="card-img-overlay" style="top: inherit;">
                                                                        Jour {{ $day }}
                                                                    </div>
                                                                </a>
                                                            @else
                                                                <a href="{{ route('users.coffre.claim') }}" onclick="event.preventDefault(); document.getElementById('coffre-claim-form').submit();">
                                                                    <div class="card-img">
                                                                        <img src="{{ asset('images/coffres/chest-closed-highlight.jpg') }}" class="img-fluid">
                                                                    </div>
                                                                    <div class="card-img-overlay" style="top: inherit;">
                                                                        Jour {{ $day }}
                                                                    </div>
                                                                </a>
                                                            @endif
                                                            {!! Form::open([
                                                                'route' => 'users.coffre.claim',
                                                                'id' => 'coffre-claim-form',
                                                                'method' => 'post',
                                                                'style' => 'display: none;'
                                                            ]) !!}
                                                            {!! Form::close() !!}
                                                    @endif

                                                    {{-- If the coffre is Locked --}}
                                                    @if ($claimed == false && $claimable == false)
                                                            @if ($bonus)
                                                                <div class="card-img">
                                                                    <img src="{{ asset('images/coffres/chest-bonus.jpg') }}" class="img-fluid">
                                                                </div>
                                                                <div class="card-img-overlay" style="top: inherit;">
                                                                    <img src="{{ asset('images/coffres/cadenas-chest.png') }}">
                                                                </div>
                                                            @else
                                                                <div class="card-img">
                                                                    <img src="{{ asset('images/coffres/chest-closed.jpg') }}" class="img-fluid">
                                                                </div>
                                                                <div class="card-img-overlay" style="top: inherit;">
                                                                    <img src="{{ asset('images/coffres/cadenas-chest.png') }}">
                                                                </div>
                                                            @endif
                                                    @endif
                                            </div>
                                        </div>
                                    </div>

                                    @php
                                        $day++;
                                    @endphp
                                @endwhile
                            </div>

                            <a class="carousel-control-prev bg-transparent w-aut" href="#coffresCarousel" role="button" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </a>
                            <a class="carousel-control-next bg-transparent w-aut" href="#coffresCarousel" role="button" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
