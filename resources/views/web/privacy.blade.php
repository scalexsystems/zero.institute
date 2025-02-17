@extends('layouts.web')

@section('content')
    @include('web.partials.header')
    <div class="container-fluid">
        <div class="row privacy-tabs-wrapper">
            <ul class="nav nav-pills privacy-tabs col-12 pl-4">
                <li class="nav-item"> <a class="nav-link privacy-link active" data-toggle="tab" href="#privacy-policy" > Privacy Policy </a> </li>
                <li class="nav-item"> <a class="nav-link privacy-link" data-toggle="tab" href="#admin-terms"> Admin Terms </a> </li>
                <li class="nav-item"> <a class="nav-link privacy-link" data-toggle="tab" href="#user-terms"> User Terms </a> </li>
            </ul>
        </div>
            <div class="tab-content privacy-tab-content py-5">
                <div class="col-10 tab-pane active" id="privacy-policy">
                    @include('web.partials.privacy-policy')
                </div>

                <div class="col-10 tab-pane" id="admin-terms">
                    @include('web.partials.admin-terms')
                </div>

                <div class="col-10 tab-pane" id="user-terms">
                    @include('web.partials.user-terms')
                </div>
            </div>
        </div>
    </div>

    <style lang="scss" scoped>
        .privacy-tabs-wrapper {
            background-color: #f7f7f7;
            padding-left: 8rem;
        }

        .container-fluid {
            background-color: white;
        }

        .privacy-link.active {
            background-color: inherit !important;
            color: inherit !important;
            border-bottom: 2px solid #969696;
        }

        .privacy-link {
            color: #939393 !important;
        }

        .privacy-tab-content {
            padding-left: 8rem;
        }

        footer {
            margin-top: 0 !important;
        }


    </style>

    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>


    @include('web.partials.footer')
@endsection
