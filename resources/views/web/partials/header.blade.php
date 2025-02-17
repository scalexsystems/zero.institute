<header>
  <nav class="navbar navbar-light">
    <div class="container d-flex flex-row">
      <a class="navbar-brand" href="/" title="Home">
        <img src="{{ asset('img/web/logo-zero-institute.svg') }}" alt="Logo: Scalex Zero">
      </a>

      <ul class="navbar-nav ml-auto flex-row">
        <li class="nav-item hidden-sm-down mx-4">
          <a class="nav-link"
             href="/">
              Features
          </a>
        </li>

          <li class="nav-item hidden-sm-down mx-4">
          <a class="nav-link"
             href="/pricing">
              Pricing
          </a>
        </li>

          <li class="nav-item hidden-sm-down mx-4">
          <a class="nav-link"
             href="/about">
              About
          </a>
        </li>

          <li class="nav-item hidden-sm-down mx-4">
          <a class="nav-link"
             href="/">
              FAQ
          </a>
        </li>


        <li class="nav-item mx-4">
          <a class="nav-link login-link px-4"
             href="/login">
              Login
          </a>
        </li>
      </ul>
    </div>
  </nav>
</header>

<style lang="scss" scoped>
  header .navbar {
    padding: 1.5rem 1rem;
  }

 .login-link {
    border: 1px solid;
    border-radius: 2px;
    padding-top: 0;
    padding-bottom: 0;
    margin-top: 7px;

 }

 header .navbar-brand {
    padding-top: 0;
     vertical-align: center;
 }
</style>