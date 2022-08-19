<div class="toast-container position-absolute top-0 end-0">
    @foreach (['primary', 'danger', 'warning', 'success', 'info'] as $type)
        @if(Session::has($type))
            <div class="toast toast-{{ $type }} align-items-center position-relative mt-5 me-5 p-3 p-3" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        @if($type == "danger")
                            <i class="fa fa-exclamation" aria-hidden="true"></i>
                        @elseif ($type == "success")
                            <i class="fa fa-check" aria-hidden="true"></i>
                        @endif
                        {!! Session::get($type) !!}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    @endforeach
</div>
