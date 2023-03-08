
  <nav
      id="navbar"
      class="navbar" 
      role="navigation" 
      aria-label="main navigation"
    >
    <div class="navbar-brand">
      <a class="navbar-item" @click="menuToggle()" >
        <img src="https://BTAXFF3PetiteVue.spurblickale.repl.co/public/img/logo_day.png" height="80">
      </a>
  
      <div 
        role="button" 
        class="navbar-burger" 
        aria-label="menu" 
        aria-expanded="false" 
        data-target="navbarBasicExample"
        @click="menuToggle()"
        >
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </div>
    </div>
  
    <div id="navbarBasicExample" class='navbar-menu' :class="{'is-active': mnuToggle }">
      <div class="navbar-start">
        <a class="navbar-item">
          Home
        </a>
  
        <a class="navbar-item">
          Blog
        </a>
  
        <div class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link">
            More
          </a>
  
          <div class="navbar-dropdown">
            <a class="navbar-item">
              About
            </a>
            <a class="navbar-item">
              Jobs
            </a>
            <a class="navbar-item">
              Contact
            </a>
            <hr class="navbar-divider">
            <a class="navbar-item">
              Report an issue
            </a>
          </div>
        </div>
      </div>
  
      <div class="navbar-end">
        <div class="navbar-item">
          <div class="buttons">
            <a class="button is-primary">
              <strong>Sign up</strong>
            </a>
            <a class="button is-light" href="https://BTAXFF3PetiteVue.spurblickale.repl.co/login">
              Log in
            </a>
          </div>
        </div>
      </div>
    </div>
  </nav>
