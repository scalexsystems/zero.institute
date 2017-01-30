<footer>
  <div class="container">
    <div class="row">
      {{--Scalex Logo--}}
      <div class="col-xs-12 col-md-2 text-xs-center text-md-left">
        <a href="http://zero.institute/" class="brand-link" title="Zero for Institutes">
          <img src="{{ asset('img/web/logo-zero-institute.svg') }}" alt="Logo: Scalex Zero">
        </a>
      </div>
      {{--Links/Site Map--}}
      <div class="col-xs-12 col-md-6">
        <div class="row">
          <div class="col-xs-4">
            <h6>Company</h6>
            <ul class="nav">
              <li class="nav-item"><a href="http://scalex.xyz/" class="nav-link" target="_blank">Scalex Systems</a></li>
              <li class="nav-item"><a href="http://scalex.xyz/blog" class="nav-link" target="_blank">Blog</a></li>
              <li class="nav-item"><a href="http://scalex.xyz/team" class="nav-link" target="_blank">Team</a></li>
            </ul>
          </div>
          <div class="col-xs-4">
            <h6>Products</h6>
            <ul class="nav">
              <li class="nav-item">
                <a href="http://zero.institute/" class="nav-link">
                  Zero Institute
                  <span class="sr-only" itemscope itemtype="http://schema.org/SoftwareApplication">
                    <span itemprop="name">Scalex Zero</span><br>
                    <span itemprop="applicationCategory">Education Management</span><br>
                    Requires <span itemprop="operatingSystem">All</span><br>
                    <span itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                      Rating <span itemprop="ratingValue">5</span>
                      (<span itemprop="ratingCount">26 ratings</span>)
                    </span>
                    <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                      Price: <span itemprop="price">0</span> <span itemprop="priceCurrency" content="INR"></span>
                    </span>
                  </span>
                </a>
              </li>
            </ul>
          </div>
          <div class="col-xs-4">
            <h6>Contact Us</h6>
            <ul class="nav">
              <li class="nav-item"><a href="@include('web.partials.setup')" class="nav-link">Setup</a></li>
              <li class="nav-item"><a href="http://angel.co/scalexsystems/jobs" class="nav-link" target="_blank">We're hiring!</a></li>
            </ul>
          </div>
        </div>
      </div>
      {{--Social Links & Copyright--}}
      <div class="col-xs-12 col-md-4 text-xs-center text-md-left">
        <p class="social">
          <a href="https://facebook.com/scalexsystems" title="Scalex System on Facebook"><i class="fa fa-facebook-square"></i></a>
          <a href="https://twitter.com/scalexsystems" title="Scalex System on Twitter"><i class="fa fa-twitter-square"></i></a>
          <a href="https://www.linkedin.com/company/scalex" title="Scalex System on LinkedIn"><i class="fa fa-linkedin-square"></i></a>
          <a href="https://instagram.com/scalexsystems" title="Scalex System on Instagram"><i class="fa fa-instagram"></i></a>
          <a href="https://www.youtube.com/watch?v=BVZ1_QtQBk4" title="Scalex System on Youtube"><i class="fa fa-youtube-play"></i></a>
          <a href="https://github.com/scalexsystems" title="Scalex System on Github"><i class="fa fa-github-square"></i></a>
        </p>
        <small class="copyright">
          Copyright &copy; 2016 Scalex Systems Pvt. Ltd.

          <span class="sr-only" itemscope itemtype="http://schema.org/Organization">
              <span itemprop="name">Scalex Systems Pvt. Ltd.</span><br>
              <span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                  <span itemprop="streetAddress">BTM Layout Stage 2</span><br>
                  <span itemprop="addressLocality">Bangalore</span><br>
                  <span itemprop="addressRegion">Karnataka</span>
                  <span itemprop="postalCode">560076</span>
              </span>
              Phone: <span itemprop="telephone">8473994808</span>
          </span>
        </small>
        <div class="pt-1">
          <small class="text-muted">Search powered by</small> <img src="{{ asset('/img/web/algolia.svg') }}" style="width:50px">
        </div>
      </div>
    </div>
  </div>
</footer>
