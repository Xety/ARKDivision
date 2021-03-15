@extends('layouts.app')
{!! config(['app.title' => 'Mes transactions']) !!}

@section('content')
<div class="container pt-6 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<div class="container pt-2">

    <div class="row">
        <div class="col-md-3">
            @include('partials.user._sidebar')
        </div>
        <div class="col-md-9">
            <section class="row">

                @if ($transactions->isNotEmpty())
                    <div role="alert" class="alert alert-primary">
                        <i aria-hidden="true" class="fa fa-exclamation"></i> Vous trouverez toutes les transactions de donations que vous avec effectuées sur Division ci-dessous.
                    </div>

                    <table class="table table-hover col-md-12 table-transactions">
                        <thead>
                            <tr>
                                <th scope="col">Paiement ID</th>
                                <th scope="col">Montant</th>
                                <th scope="col">Devise</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>
                                    {{ $transaction->payment_id }}
                                </td>
                                <td>
                                    {{ $transaction->amount }}
                                </td>
                                <td>
                                    {{ $transaction->currency }}
                                </td>
                                <td>
                                    {{ $transaction->created_at->formatLocalized('%d %B %Y - %T') }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="col-md 12 text-xs-center">
                        {{ $transactions->render() }}
                    </div>
                @else
                    Vous n'avez aucune transactions.
                @endif

            </section>
        </div>
    </div>
</div>
@endsection
