<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<base href=" <?= ($SCHEME.'://'.$HOST.$BASE.'/') ?> ">
	<title>Brighter Taxis Ltd</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css" />
  </head>

  <body>
      <header>
        <nav class="navbar" role="navigation" aria-label="main navigation">
          <div class="navbar-brand">
            <a class="navbar-item">
              Brighter Taxis Ltd
            </a>
        
            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
            </a>
          </div>
        
          <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
              <a class="navbar-item">
                Home
              </a>
        
              <a class="navbar-item">
                Documentation
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
            <?php if (isset($SESSION['logged_in']) && $SESSION['logged_in']): ?>
              
                <div class="navbar-item has-dropdown is-hoverable">
                  <a class="navbar-link">
                    More
                  </a>
          
                  <div class="navbar-dropdown">
                    <a class="navbar-item">
                      Notifications
                    </a>
                    <a class="navbar-item">
                      Account
                    </a>
                    <a class="navbar-item">
                      Contact
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="/logout">
                      Logout
                    </a>
                  </div>
                </div>
              
              <?php else: ?>
                <!-- <div class="navbar-end">
                  <div class="navbar-item">
                    <div class="buttons">
                      <a class="button is-primary">
                        <strong>Sign up</strong>
                      </a>
                      <a class="button is-light">
                        Log in
                      </a>
                    </div>
                  </div>
                </div> -->
                <div class="navbar-item has-dropdown is-hoverable">
                  <a class="navbar-link">
                    Login
                  </a>
                  <div class="navbar-dropdown">
                    <form action="<?= ($BASE) ?>" method="post" class="">
                      <input type="text" class="form-control" placeholder="Email" name="username" id="username" required autofocus>
                      <input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
                      <input type="hidden" name="login" value="login" />
                      <input type="hidden" name="session_csrf" value="<?= ($CSRF) ?>" />
                      <button class="btn" type="submit">Login</button>
                    </form>
                  </div>
                </div>
              
            <?php endif; ?>
          </div>
        </nav>
      </header>

      