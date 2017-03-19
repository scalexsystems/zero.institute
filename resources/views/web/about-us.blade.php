@extends('layouts.web')

@section('content')
    @include('web.partials.header')

    <section id="about">
   <div class="container">
       <div class="row">
           <div class="col-10 py-5 offset-lg-1">
               <div class="text-center">
                   <h1><strong>About Us </strong></h1>
               </div>

               <p class="my-5 about-text">
                   Scalex Zero is a Digital Infrastructure service for Higher Education, founded by alumni of IIT Guwahati.
                   Zero aims to help the institutes accelerate their admin processes and promote academic discussions on a single platform.
                   <br/><br/>
                   High pricing is a major hurdle for technology intervention in educational institutes.
                   We offer a free, light-weight and developer-friendly platform that allows the institutes
                   to offload resource intensive task of building and managing technology and focus on learning.
                   Institutes can use the platform for academic collaboration, assessments, attendance, communication and fee payments.
                   <br/><br/>
                   All products and services related to Zero are a part of Scalex Systems Pvt. Ltd., a company incorporated under Government of India
                   <br/><br/>
                   You can reach out to us at <a href="mailto:contact@zero.institute">contact@zero.institute</a>
               </p>

           </div>
       </div>
   </div>
</section>

<style lang="scss">
   .about-text {
     font-size: 1.2rem;
   }
</style>

    @include('web.partials.footer')
@endsection
