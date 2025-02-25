<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg fixed-top shadow-sm" style="background: linear-gradient(135deg, #ff416c, #ff4b2b);">
  <div class="container-fluid">
      <!-- Brand -->
      <a class="navbar-brand font-weight-bold text-white" href="{{ route('index.home') }}" style="font-size: 1.5rem;">
          ❤️ HeartSpark
      </a>

   <!-- Toggle Button for Mobile -->
      <button class="navbar-toggler border-0 text-dark" type="button" 
      data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" 
      aria-expanded="false" aria-label="Toggle navigation"
      style="background-color: white; padding: 8px 12px; border-radius: 5px;">
      <i class="fas fa-bars"></i>
      </button>


      <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
          <!-- Search Bar (Desktop) -->
          <form class="form-inline mx-auto d-none d-lg-block w-50">
              <input class="form-control w-100 shadow-sm" type="search" placeholder="🔍 Search profiles..." 
                     style="border-radius: 20px; padding: 10px; border: none;">
          </form>

          <!-- Right Section -->
          <ul class="navbar-nav ms-auto align-items-center">
              <li class="nav-item mx-2">
                  <a class="nav-link text-white font-weight-bold" href="{{route('home')}}">
                      <i class="fas fa-home"></i> Home
                  </a>
              </li>
              <li class="nav-item mx-2">
                  <a class="nav-link text-white font-weight-bold" href="{{ route('inbox') }}">
                      <i class="fas fa-envelope"></i> Inbox
                  </a>
              </li>
              <li class="nav-item mx-2">
                  <a class="nav-link text-white font-weight-bold" href="{{ route('profile.show') }}">
                      <i class="fas fa-user"></i> Profile
                  </a>
              </li>

              <!-- Logout Button -->
              <li class="nav-item mx-2">
                  <form action="{{ route('logout') }}" method="POST" class="d-inline">
                      @csrf
                      <button type="submit" class="btn btn-sm text-white px-3" 
                              style="border-radius: 20px; background: rgba(255, 255, 255, 0.3);">
                          Logout
                      </button>
                  </form>
              </li>

              <!-- Upgrade Button -->
              <li class="nav-item mx-2">
                  <a class="btn btn-sm text-white px-4 font-weight-bold" href="{{route('plans')}}" 
                     style="border-radius: 20px; background: rgba(255, 255, 255, 0.4); transition: 0.3s;">
                      Upgrade
                  </a>
              </li>
          </ul>
      </div>
  </div>
</nav>
