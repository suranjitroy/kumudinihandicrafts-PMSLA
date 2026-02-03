<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      @guest
        <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
      @endguest
      
      <li class="nav-item">
        <span class="nav-link d-none">
            Logged in as: 
            <strong>
              {{-- {{ Auth::user()->getRoleNames()->first() }} --}}
            @foreach(Auth::user()->getRoleNames() as $role)
                {{ $role }}
            @endforeach
            </strong>
        </span>
      </li>
    
    </ul>

    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
       <!-- Notifications Dropdown Menu -->

        <li class="nav-item dropdown">
              <a class="nav-link" href="#" data-toggle="dropdown" id="notificationDropdown">
                  <i class="fa fa-bell"></i>
                  @if(auth()->user()->unreadNotifications->count())
                  <span class="badge badge-danger" id="notifyCount">{{ auth()->user()->unreadNotifications->count() }}
                  </span>
                  @endif
              </a>

              {{-- <div class="dropdown-menu" id="notificationList"></div> --}}
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notificationList"></div>
        </li>



        <li class="nav-item d-none d-sm-inline-block">
        <form action="{{ route('logout') }}" method="post">
          @csrf
          <button class=" btn nav-link"><i class="fas fa-power-off"></i></button>
        </form>
      </li>
      <!-- Navbar Search -->
      {{-- <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li> --}}

      <!-- Messages Dropdown Menu -->
      {{-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li> --}}
      
      {{-- <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li> --}}
      {{-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> --}}
    </ul>
  </nav>

  @section('scripts')

  <script>
    function loadNotificationCount() {
        $.ajax({
            url: "{{ route('notifications.count') }}",
            type: "GET",
            success: function (count) {
                $("#notifyCount").text(count);
            }
        });
    }

    function loadNotificationList() {
        $.ajax({
            url: "{{ route('notifications.list') }}",
            type: "GET",
            success: function (notifications) {
                let html = "";
                const markAsReadUrl = "{{ url('/markasread') }}";

                notifications.forEach(function (item) {
                    html += `
                        <p class="dropdown-item">
                            <strong>${item.data.no} ${item.data.title}</strong><br>
                            <small>${item.data.message}</small>
                        </p>
                        <a href=" ${markAsReadUrl}/${item.id} " class="p-2 text-white bg-red rounded-lg">Mark as read</a>
                        <div class="dropdown-divider"></div>
                    `;

                    
                });
                html += `
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    `;


                $("#notificationList").html(html);
            }
        });
    }

    // Load counter every 5 seconds
    setInterval(function() {
        loadNotificationCount();
        loadNotificationList();
    }, 5000);

    // Load on page load
    loadNotificationCount();
    loadNotificationList();
</script>


  @endsection