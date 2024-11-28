<!-- Site wrapper -->

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="bi bi-list"></i>
      </a>
    </li>
  </ul>
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Navbar Search -->
    <li class="nav-item">
      <a class="nav-link" data-widget="navbar-search" href="#" role="button">
        <i class="bi bi-search"></i>
      </a>
      <div class="navbar-search-block">
        <form class="form-inline">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="bi bi-search"></i>
              </button>
              <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                <i class="bi bi-x-lg"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </li>

    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="bi bi-bell"></i>
        <span class="badge badge-warning navbar-badge">15</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">15 Notifications</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="bi bi-envelope-fill mr-2"></i> 4 new messages
          <span class="float-right text-muted text-sm">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="bi bi-person-fill mr-2"></i> 8 friend requests
          <span class="float-right text-muted text-sm">12 hours</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="bi bi-file-earmark-fill mr-2"></i> 3 new reports
          <span class="float-right text-muted text-sm">2 days</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
      </div>
    </li>

    <!-- Profile Dropdown Menu -->
    <li class="nav-item dropdown user-menu">
      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        <!-- Placeholder for user profile image -->
        <img id="userImage" src="adminlte/dist/img/avatar.png" class="user-image rounded-circle shadow" alt="User Image"
          style="height: 35px; width: 35px;">

        <!-- Placeholder for username -->
        <span id="username" class="d-none d-md-inline">{{ auth()->user()->username }}</span>
      </a>

      <!-- Dropdown Menu -->
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="background-color: #CBD5DC; padding: 10px;">
        <!-- User Information with custom background and italic role -->
        <div class="dropdown-item-text text-left pb-2 mb-2">
          <strong></strong> {{ auth()->user()->user_fullname }} <br>
          <strong></strong> <em>{{ auth()->user()->user_type->user_type_name }}</em> <!-- Role in italic -->
        </div>
        <div class="dropdown-divider"></div>

        <!-- Profile option -->
        <a href="{{ url('/profile')}}" class="dropdown-item">
          <i class="bi bi-person-fill mr-2"></i> Profile
        </a>
        <!-- Logout option -->
        <a href="{{ url('/logout') }}" class="dropdown-item">
          <i class="bi bi-box-arrow-right mr-2"></i> Logout
        </a>
      </div>
    </li>
  </ul>
</nav>