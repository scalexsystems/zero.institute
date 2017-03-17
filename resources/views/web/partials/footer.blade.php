<footer>
  <div class="container">
    <div class="row">
      {{--Scalex Logo--}}
      <div class="col-12 col-md-3 text-center text-md-left">
        <a href="http://zero.institute/" class="brand-link" title="Zero for Institutes">
          <img src="{{ asset('img/web/logo-zero-institute.svg') }}" alt="Logo: Scalex Zero">
        </a>
        <div class="small text-muted py-4"> Open Technology For Higher Education </div>
      </div>
      {{--Links/Site Map--}}
      <div class="col-12 col-md-6">
        <div class="row">
          <div class="col-6">
            <h6 class="px-3">Company</h6>
            <ul class="nav flex-column">
              <li class="nav-item"><a href="http://scalex.xyz/" class="nav-link" target="_blank">Scalex Systems</a></li>
              <li class="nav-item"><a href="/pricing" class="nav-link" target="_blank">Pricing</a></li>
              <li class="nav-item"><a href="/about" class="nav-link" target="_blank">About</a></li>
              <li class="nav-item"><a href="/features" class="nav-link" target="_blank">Features</a></li>
            </ul>
          </div>
          <div class="col-4">
            <h6 class="px-3">Products</h6>
            <ul class="nav flex-column">
              <li class="nav-item"><a href="/" class="nav-link" target="_blank">Support</a></li>
              <li class="nav-item"><a href="@include('web.partials.setup')" class="nav-link" target="_blank">Setup</a></li>
              <li class="nav-item"><a href="http://angel.co/scalexsystems/jobs" class="nav-link" target="_blank">We're Hiring</a></li>
            </ul>
          </div>
        </div>
      </div>
      {{--Social Links & Copyright--}}
      <div class="col-12 col-md-3 text-center text-md-left">
        <p class="social">
          <a href="https://facebook.com/scalexsystems" title="Scalex System on Facebook"><i class="fa fa-facebook-square"></i></a>
          <a href="https://twitter.com/scalexsystems" title="Scalex System on Twitter"><i class="fa fa-twitter-square"></i></a>
          <a href="https://www.linkedin.com/company/scalex" title="Scalex System on LinkedIn"><i class="fa fa-linkedin-square"></i></a>
          <a href="https://instagram.com/scalexsystems" title="Scalex System on Instagram"><i class="fa fa-instagram"></i></a>
          <a href="https://www.youtube.com/watch?v=BVZ1_QtQBk4" title="Scalex System on Youtube"><i class="fa fa-youtube-play"></i></a>
          <a href="https://github.com/scalexsystems" title="Scalex System on Github"><i class="fa fa-github-square"></i></a>
        </p>
        <small class="copyright">
          Copyright &copy; 2017 Scalex Systems Pvt. Ltd.

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

  <style lang="scss" scoped>
    footer {
      background: white;
    }


  </style>
</footer>
