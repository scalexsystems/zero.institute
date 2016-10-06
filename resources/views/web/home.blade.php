@extends('layouts.web')

@section('content')
    @include('web.partials.header')
    <main>
        <section id="intro">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 text-xs-center">
                        <h1>Open Technology for Education</h1>
                        <p>We believe open technology will derive growth and create new opportunities. Get invited for
                            early
                            access!</p>
                    </div>

                    <div class="col-xs-12">
                        @include('web.partials.invite')
                    </div>

                    <div class="col-xs-12">
                        <!-- Video here! -->
                        @include('web.partials.video')
                    </div>

                    <div class="col-xs-12 m-b-3 p-b-3 text-xs-center">
                        <span style="padding: .5rem 1.5rem; background: white; border: 1px solid #efefef; border-radius: 2px">{{ $count }}
                            institutes on-board</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="pricing">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 text-xs-center">
                        <img src="{{ asset('img/web/features/price-tag.svg') }}" alt="₹0/-">

                        <p>Get Invited for early access!</p>
                    </div>

                    <div class="col-xs-12">
                        @include('web.partials.invite')
                    </div>
                </div>
            </div>
        </section>

        <section id="the-video">
            <div class="container text-xs-center">
                <div class="row">
                    <div class="col-xs-12 m-y-2">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="//www.youtube.com/embed/iV7idUln3_E?html5=1"
                                    frameborder="0"
                                    allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="features">
            <div class="container text-xs-center text-md-left">
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <img src="{{ asset('img/web/features/one-stop.svg') }}" alt="Screen shot of Zero app menu.">
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <h3>One-stop solution</h3>
                        <p>Now switch between different administrative sections with just a single click. Zero
                            Hassle.</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <img src="{{ asset('img/web/features/registration.svg') }}"
                             alt="Screen shot of Zero Registration panel.">
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <h3>Student Registration</h3>
                        <p>With suggestive model, Zero assists institutes in student registrations, including the
                            back-logger
                            students.</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <img src="{{ asset('img/web/features/profile.svg') }}"
                             alt="Screen shot of Zero digital profile.">
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <h3>Digital Profiling</h3>
                        <p>Create digital profiles of students, teachers and employees of your institute and get rid of
                            pile of
                            paperwork.</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <img src="{{ asset('img/web/features/academics.svg') }}"
                             alt="Screen shot of Zero academics portal.">
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <h3>Institute Academics Portal</h3>
                        <p>Take care of all academic activities - student registration, course management, departments,
                            academic
                            calendar etc.</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <img src="{{ asset('img/web/features/library.svg') }}"
                             alt="Screen shot of Zero library portal.">
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <h3>Institute Library</h3>
                        <p>Zero helps institutes in library activities from cataloguing to circulation, all in one
                            place.</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <img src="{{ asset('img/web/features/attendance.svg') }}"
                             alt="Screen shot of Zero attendance portal.">
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <h3>Institute Attendance</h3>
                        <p>Track students’ attendance and generate analytics.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="security">
            <div class="container text-xs-center text-md-left">
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <img src="{{ asset('img/web/features/security.svg') }}" alt="Zero feature set">
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <h3>Safe and Secure!</h3>
                        <p>Keeping your information safe is our utmost priority. Encryption with HTTPS brings a higher
                            level of
                            security and privacy to your information.</p>
                        <p>It means that your information is safe even when it travels between your device and Zero.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="clients">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 text-xs-center">
                        <h2>Working with some of the best institutes in the country</h2>
                    </div>

                    <div class="col-xs-12 col-md-6 client">
                        <img src="{{ asset('img/web/clients/logo-iiitg.png') }}" alt="Logo of Assam Textile Institute">

                        <div>
                            <h3>IIIT Guwahati</h3>
                            <p>Indian Institute of Information Technology Guwahati (IIITG) is an institution under MHRD,
                                Govt. of India.
                                It offers courses in Electronics and Communication Engineering (ECE) and Computer
                                Science Engineering
                                (CSE).</p>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-6 client">
                        <img src="{{ asset('img/web/clients/logo-ati.png') }}" alt="Logo of Assam Textile Institute">

                        <div>
                            <h3>Assam Textile Institute</h3>
                            <p>Assam Textile Institute, a premier institute was established in the year 1920, is the
                                only Institute,
                                which offers courses on Textile Technology, Garment Technology and Fashion Technology
                                under one roof.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="invite">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 text-xs-center">
                        <h2>Get invited for early access!</h2>
                    </div>

                    <div class="col-xs-12">
                        @include('web.partials.invite')
                    </div>
                </div>
            </div>
        </section>
    </main>
    @include('web.partials.footer')
@endsection