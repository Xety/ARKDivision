<footer class="footer  mt-auto col-sm-12 col-lg-10 offset-lg-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                &copy; {{ date('Y', time()) }} {{ config('app.name') }}.
                <ul class="list-inline d-inline-block mb-0">
                    <li class="list-inline-item">
                    <a href="{{ config('division.site.github_url') }}" target="_blank">
                        <i class="fa fa-github-alt" data-toggle="tooltip" title="Source Code available on Github"></i>
                    </a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-6 text-lg-end">
                <i class="fa fa-code text-primary" style="font-weight: bold;"></i> avec <i class="fa fa-heart" style="color: #fa6c65"></i> et <i class="fa fa-coffee" style="color: #826644"></i> par <a href="https://github.com/Xety" target="_blank">@ZoRo</a>
            </div>
        </div>
    </div>
</footer>
