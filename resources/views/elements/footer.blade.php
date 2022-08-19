<footer class="footer mt-auto" >
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                &copy; {{ date('Y', time()) }} {{ config('app.name') }} | {!! link_to(route('page.terms'), 'Conditions d\'Utilisation') !!}
            </div>

            <div class="col-lg-6 text-lg-end">
                <i class="fa fa-code text-primary" style="font-weight: bold;"></i> avec <i class="fa fa-heart" style="color: #fa6c65"></i> et <i class="fa fa-coffee" style="color: #826644"></i> par <a href="https://github.com/Xety" target="_blank">@ZoRo</a>
            </div>
        </div>
    </div>
</footer>
