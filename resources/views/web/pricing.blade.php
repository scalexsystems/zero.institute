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
                            <a href="#free" class="nav-link pricing-nav-link active"> Free </a>
                        </li>
                        <li class="nav-item pricing-nav-item">
                            <a href="#" class="nav-link pricing-nav-link"> Fee Payments </a>
                        </li>
                    </div>

                    <div id="free" class="tab-content">
                        @include('web.partials.free')

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
@endsection


