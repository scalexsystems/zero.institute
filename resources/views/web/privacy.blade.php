@extends('layouts.web')

@section('content')
    @include('web.partials.header')
    <div class="container">
        <div class="row">
            <ul class="nav nav-pills privacy-tabs col-12 pb-2 pl-4">
                <li class="nav-item"> <a href="#privacy-policy" class="nav-link privacy-link active"> Privacy Policy </a> </li>
                <li class="nav-item"> <a class="nav-link text-muted privacy-link"> Admin Terms </a> </li>
                <li class="nav-item"> <a class="nav-link privacy-link"> User Terms </a> </li>
            </ul>
        </div>
        <div class="col-10 py-5 tab-content active" id="privacy-policy">
            @include('web.partials.privacyPolicy')
        </div>

        <div class="col-10 py-5 tab-content" id="admin-terms">
            @include('web.partials.adminTerms')
        </div>
    </div>
    </div>

    <style lang="scss" scoped>
        .privacy-tabs {
            background-color: #dfdfdf;
        }

        .container {
            background-color: white;
        }

        .privacy-link.active {
            background-color: inherit !important;
            color: inherit !important;
            border-bottom: 2px solid #969696;
        }

        .privacy-link {
            /*color: #fdfdfd !important;*/
        }


    </style>




    @include('web.partials.footer')
@endsection
