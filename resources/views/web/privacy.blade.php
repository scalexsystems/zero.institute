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
        <div class="col-10 py-5 tab-content" id="privacy-policy">
            <h1>Privacy Policy</h1>
            <p>
                Scalex Zero: www.zero.institute (“Zero”,” Scalex”, “we,” “us” or “our”) is an internet based platform,
                wholly
                owned & managed by Scalex Systems Private Limited, a company registered under the Indian Companies Act. Zero
                recognises the importance of protecting the information collected from users in the operation of its
                services,
                and takes responsible steps to maintain the security, integrity and privacy of any information in accordance
                with this Privacy Policy herein.
            </p>

            <p class="text-muted">Updated: October 2, 2016</p>

            <h2>Information we collect and receive</h2>

            <ul>
                <li>
                    <h3>Account and profile information:</h3>
                    <p>The only information we require to create your Zero account is an email address and password.</p>

                    <ul>
                        <li type="dash">
                            <b>Additional information required to create a verified profile includes:</b>
                            <ol>
                                <li>Personal Information: First and Last name, Gender, Date of Birth</li>
                                <li>Information related to institute: Unique Identification Number, Date of joining/admission,
                                    Department,
                                    Discipline
                                </li>
                                <li>Contact Information: Residential Address, Phone Number, Email Address</li>
                            </ol>
                        </li>
                    </ul>

                    <ul>
                        <li type="dash">
                            <b>Optional information you can enter into your profile includes:</b>
                            <ol>
                                <li>Personal Information: Category, AADHAR ID, Passport, Religion, Mother Tongue</li>
                                <li>Career Information: Experience and Education Qualifications</li>
                                <li>Medical Information: Blood Group, Disability, Allergies.</li>
                            </ol>
                        </li>
                    </ul>

                    <p>Your Institute Administrator may request you to provide optional information about yourself in your
                        profile,
                        and
                        Zero has no control over such additional information collected.</p>

                    <p>
                        <b>Any information you add to your profile is visible only to the administration of your
                            Institute.</b>
                    </p>
                </li>
                <li>
                    <h3>Log Data:</h3>
                    <p>When you use Zero, our servers automatically record information, including information that your
                        browser
                        sends
                        whenever you visit a website or your mobile app sends when you’re using it. This log data may
                        include your
                        Internet Protocol address, the address of the web page you visited before coming to Zero, your
                        browser type
                        and
                        settings, the date and time of your request, information about your browser configuration and
                        plug-ins, and
                        language preferences. <b>Log data does not contain your profile information.</b></p>
                </li>
                <li>
                    <h3>Device Information:</h3>
                    <p>In addition to log data, we may collect information about the device you’re using Zero on, including
                        what
                        type of
                        device it is, what operating system you’re using, device settings, unique device identifiers, and
                        crash
                        data.
                        Whether we collect some or all of this information often depends on what type of device you’re using
                        and its
                        settings.</p>
                </li>
                <li>
                    <h3>Geo-Location Information:</h3>
                    <p><b>Precise GPS from mobile devices is collected only with your permission.</b> WiFi and IP addresses
                        received
                        from your browser or device may be used to determine approximate location.</p>
                </li>
                <li>
                    <h3>Zero Usage Information:</h3>
                    <p>This is information about which courses, groups, people, features, content, and links you interact
                        with
                        within
                        Zero and what integrations with related services you use.</p>
                </li>
            </ul>

            <h2>How we use your information</h2>

            <p>We use your information for the following:</p>

            <ul>
                <li>
                    <h3>Understanding and improving our products:</h3>
                    <p>To make the product better, we have to understand how users are using it. We have a fair bit of data
                        about
                        usage
                        and we intend to use it in different ways to improve our products, including research. This policy
                        is not
                        intended to place any limits on what we do with usage data that is aggregated or de-identified so it
                        is no
                        longer tied to a Zero user.</p>
                </li>
                <li>
                    <h3>Investigating and preventing bad stuff from happening:</h3>
                    <p>We work hard to keep Zero secure and to prevent abuse and fraud.</p>
                </li>
                <li>
                    <h3>Communicating with you:</h3>

                    <ul>
                        <li>
                            <p>
                                <b>Solving your problems and responding to your requests</b><br>
                                If you contact us with a problem or a question, we will use your contact information to
                                respond to
                                that
                                request and address your problems or concerns.
                            </p>
                        </li>
                        <li>
                            <p>
                                <b>Email messages</b><br>
                                We may contact you to inform you about changes in our services, our service offerings and
                                important
                                service related notices, such as changes to this policy or security and fraud notices. These
                                messages
                                are considered as a part of the service and you may not opt-out of them. In addition, we
                                sometimes
                                send
                                emails to Zero users about new product features or other news about Zero. You can opt-out of
                                these
                                at
                                any time.
                            </p>
                        </li>
                    </ul>
                </li>
            </ul>

            <h2>Sharing and Disclosure</h2>

            <ul>
                <li>
                    <h3>About you with your organisation or Institute Administrator(s)</h3>
                    <p>There may be times when you contact Zero to help resolve an issue specific to a group you are a
                        member of. In
                        order to help resolve the issue, we may need to share your concern with your institute
                        administrator. When
                        possible, we will try to mask or remove any identifying information before sharing these
                        communications.</p>
                </li>
                <li>
                    <h3>With third party service providers</h3>
                    <p>We may employ third party companies or individuals to process personal information on our behalf,
                        based on
                        our
                        instructions and in compliance with this Privacy Policy. For example, we may share data with a
                        security
                        consultant to help us get better at preventing unauthorised access or with an email vendor to send
                        messages
                        on
                        our behalf. We may also share data with hosting providers and other consultants who work on our
                        behalf.</p>
                </li>
            </ul>

            <h2>Security</h2>
            <p>Zero takes reasonable steps to protect information you provide to us as a part of your use of the Zero
                service
                from loss, misuse, and unauthorised access or disclosure. These steps take into account the sensitivity of
                the
                information we collect, process and store and the current state of technology.</p>

            <p>When you enter sensitive information (such as sign-in credentials) we encrypt the transmission of that
                information using secure socket layer technology (SSL). We follow generally accepted standards to protect
                the
                personal data submitted to us, both during transmission and once we receive it. However, no electronic or
                email
                transmission or digital storage mechanism is ever fully secure or error free.</p>

            <p>If you believe you have found a security vulnerability on Zero, please let us know right away. We will
                investigate all reports and do our best to quickly fix valid issues.</p>


            <h2>Children’s information</h2>
            <p>Zero is not directed to children under 13. If you learn that a minor child has provided us with personal
                information without your consent, please contact us.</p>


            <h2>Changes to this Privacy Policy</h2>
            <p>We may change this policy from time to time, and if we do, we’ll post any changes on this page. If you
                continue
                to use Zero after those changes are in effect, you agree to the revised policy. If the changes are material,
                we
                may provide more prominent notice or seek your consent to the new policy.</p>


            <h2>Contact Information</h2>
            <p>Please feel free to contact us if you have any questions about Zero’s Privacy Policy or practices. You may
                contact us at <a href="mailto:feedback@zero.institute">feedback@zero.institute</a></p>
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
