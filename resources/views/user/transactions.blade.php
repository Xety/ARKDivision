@extends('layouts.app')
{!! config(['app.title' => 'Mes transactions']) !!}

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
                Transactions
            </h1>

            <div class="row">
                @if ($transactions->isNotEmpty())
                    <div role="alert" class="alert alert-primary">
                        <i aria-hidden="true" class="fa fa-exclamation"></i> Vous trouverez toutes les transactions de donations que vous avez effectuées sur Division ci-dessous.
                    </div>

                    <table class="table table-striped col-lg-12">
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

                    <div class="row text-center">
                        <div class="col-12">
                            {{ $transactions->render() }}
                        </div>
                    </div>

                @else
                    Vous n'avez aucune transactions.
                @endif

            </div>
        </div>

    </div>
</div>
@endsection
