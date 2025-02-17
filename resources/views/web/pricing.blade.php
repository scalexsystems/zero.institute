@extends('layouts.web')

@section('content')
    @include('web.partials.header')

    <div class="container">
        <div class="row">
            <div class="col-10 pt-5 offset-lg-1 p-0">
                <div class="text-center">
                    <h1><strong> Pricing </strong></h1>
                </div>

                <ul class="nav pricing-nav-tabs text-center justify-content-center">
                    <li class="nav-item pricing-nav-item px-4">
                        <a href="#free" data-toggle="tab" class="nav-link pricing-nav-link active"> Free </a>
                    </li>
                    <li class="nav-item pricing-nav-item">
                        <a href="#fee-payments" data-toggle="tab" class="nav-link pricing-nav-link"> Fee Payments </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="free" class="tab-pane active">
                        @include('web.partials.free')

                    </div>

                    <div id="fee-payments" class="tab-pane">
                        @include('web.partials.fee-payments')

                    </div>
                </div>


            </div>
        </div>
    </div>

    <style lang="scss" scoped>
        .pricing-nav-item {
            font-size: 1.6rem;
        }

        .pricing-nav-link.active {
            background-color: white !important;
        }

        .pricing-nav-link {
            padding: 1.6rem 1rem;
            background-color: #dfdfdf;
            color: black;
            width: 20rem;
        }

        .tab-content {
            background-color: white;
        }

        .pricing-nav-tabs {
            padding-top: 3rem;
        }

        .nav-link:hover {
            color: inherit;
        }

        .active:hover {
            color: inherit;
        }

        .nav-link:focus {
            color: inherit;
        }

        .active:focus {
            color: inherit;
        }

    </style>

    @include('web.partials.bootstrap')
    @include('web.partials.footer')

@endsection


