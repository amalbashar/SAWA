


<nav class="header-area header-sticky background-header">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <!-- ***** Logo Start ***** -->
          <a > <div style="width: 150px; height: 150px; position: relative; top: -32px;">  <img src="{{ asset('images/logo.jpg') }}" ></div></a>
          <div class="search-input">
            <form id="search" action="#">
              <input type="text" placeholder="Type Something" id='searchText' name="searchKeyword" onkeypress="handle" />
              <i class="fa fa-search"></i>
            </form>
          </div>
            <!-- ***** Logo End ***** -->
            <!-- ***** Menu Start ***** -->
            <ul class="nav">
              <li ><a href="index.html" class="active"  >Home</a></li>
              <li><a href="services.html">Services</a></li>
              <li><a href="courses.html">Book</a></li>
              <li><a href="team.html">Advices</a></li>
              <li><a href="events.html">Events</a></li>



              <ul>
                <!-- إذا كان المستخدم غير مسجل الدخول -->
                @guest
                    <li><a href="">Register</a></li>
                @endguest

                <!-- إذا كان المستخدم مسجل الدخول -->
                @auth
                <li><a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a></li>
                <!-- نموذج لطلب تسجيل الخروج -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endauth
        </ul>


            </ul>
            <a class="menu-trigger">
              <span>Menu</span>
            </a>
            <!-- ***** Menu End ***** -->
          </nav>
        </div>
      </div>
    </div>
  </nav>
