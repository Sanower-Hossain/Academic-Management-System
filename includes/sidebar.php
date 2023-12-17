  <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
          <div class="sb-sidenav-menu">
              <div class="nav">

                  <a class="nav-link" href="<?php echo $_SESSION['designation'] == 'Teacher' ? 'teacher.php' : 'student.php' ?>">
                      <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                      Dashboard
                  </a>
                  <a class="nav-link" href="profile.php">
                      <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                      Profile
                  </a>
                  <a class="nav-link" href="logout.php">
                      <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                      Signout
                  </a>
              </div>
          </div>

      </nav>
  </div>