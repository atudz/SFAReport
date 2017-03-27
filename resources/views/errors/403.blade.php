@include('layout.assets.head')
@include('layout.assets.css')

<div class="container-xs-height full-height">
    <div class="row-xs-height">
        <div class="col-xs-height col-middle">
            <div class="text-center">
                <div class="container-xs">
                    <h1 class="font-heading text-uppercase">403 Forbidden</h1>
                    <p class="font-heading">You don't have permission to access this page.</p>

                    <a href="{{ url('/') }}" class="btn btn-link mg-t-40 text-primary"><i
                                class="fa fa-angle-left mg-r-10"></i> Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>