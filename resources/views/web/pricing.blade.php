@extends('layouts.web')

@section('content')
    @include('web.partials.header')

        <div class="container">
            <div class="row">
                <div class="col-10 py-5 offset-lg-1">
                    <div class="text-center">
                        <h1><strong> Pricing </strong></h1>
                    </div>

                    <div class="nav pricing-nav-tabs">
                        <li class="nav-item pricing-nav-item px-4">
                            <a href="#free" data-toggle="tab" class="nav-link pricing-nav-link active"> Free </a>
                        </li>
                        <li class="nav-item pricing-nav-item">
                            <a href="#fee" data-toggle="tab" class="nav-link pricing-nav-link"> Fee Payments </a>
                        </li>
                    </div>

                    <div class="tab-content">
                        <div id="free" class="tab-pane active">
                            @include('web.partials.free')

                        </div>

                        <div id="fee" class="tab-pane">
                            @include('web.partials.feePayments')

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
          padding: 1.6rem 6rem;
          background-color: #dfdfdf;
          color: black;
        }

        .tab-content {
            background-color: white;
        }

        .pricing-nav-tabs {
           padding: 3rem 0 0 6rem;
        }

    </style>

    {{--<script src="{{ mix('/vendor/bootstrap.js') }}" defer></script>--}}
    @include('web.partials.footer')

@endsection


