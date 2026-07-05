<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>clw-backend — The lightweight backend framework for modern APIs</title>
  <meta name="description" content="clw-backend is a fast, type-safe backend framework for building REST and GraphQL APIs with built-in auth, first-class DX, and zero-config deployment." />

  <!-- Google Font: Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="{{ asset('frontend/assets/css/styles.css')}}" />
</head>
<body>

  <!-- ============ HEADER / NAVBAR ============ -->
  <header class="site-header" id="siteHeader">
    <div class="container header-inner">

      <a href="{{ route('frontend.index')}}" class="logo" aria-label="clw-backend home">
        <span class="logo-mark" aria-hidden="true">
          <img src="{{asset('backend/assets/images/fabicon.png')}}" alt="logo" width="20px">
        </span>
        <span class="logo-word">CLW-DOCS</span>
      </a>

      <nav class="main-nav" id="mainNav" aria-label="Primary">
        <ul class="nav-list">
          <li><a href="https://cleanwater1.com/">Clean Water</a></li>
          <li><a href="https://events.cleanwater1.com/">Events</a></li>
          <li><a href="https://tools.cleanwater1.com/index.php">Tools</a></li>
          <li><a href="https://blog.cleanwater1.com/">Blog</a></li>
          <li><a href="{{ url('/docs/api')}}">Api</a></li>
        </ul>

        <!-- shown inside off-canvas nav on mobile -->
        <div class="nav-actions-mobile">
          <a href="#get-started" class="btn btn-primary btn-block">Get Started</a>
        </div>
      </nav>

      <div class="header-actions">

        <button class="icon-btn theme-toggle" id="themeToggle" type="button" aria-label="Toggle dark mode">
          <svg class="icon-sun" width="19" height="19" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <circle cx="12" cy="12" r="4.5" stroke="currentColor" stroke-width="2"/>
            <path d="M12 2v2.2M12 19.8V22M4.2 4.2l1.55 1.55M18.25 18.25l1.55 1.55M2 12h2.2M19.8 12H22M4.2 19.8l1.55-1.55M18.25 5.75l1.55-1.55" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
          <svg class="icon-moon" width="19" height="19" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M20 14.5A8.5 8.5 0 1 1 9.5 4a7 7 0 0 0 10.5 10.5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
          </svg>
        </button>

        <a href="#get-started" class="btn btn-primary header-cta">Docs</a>

        <button class="hamburger" id="hamburgerBtn" type="button" aria-label="Toggle menu" aria-expanded="false" aria-controls="mainNav">
          <span></span><span></span><span></span>
        </button>
      </div>

    </div>
  </header>

  <!-- backdrop for mobile off-canvas nav -->
  <div class="nav-backdrop" id="navBackdrop"></div>

  <main>

    <!-- ============ HERO ============ -->

        <section class="features" id="features">
        <div class="container not-found-section">
            <div class="section-head fade-in">
            
                <h2 class="section-title">404 Not found! </h2>
                <p class="section-subtitle"><a href="{{ route('frontend.index')}}">Go Back </a></p>
            </div>

        
        </div>
     </section>

  </main>

  <!-- ============ FOOTER ============ -->
  <footer class="site-footer" id="blog">
    <div class="container footer-grid">

      <div class="footer-brand">
      <a href="{{ route('frontend.index')}}" class="logo" aria-label="clw-backend home">
            <span class="logo-mark" aria-hidden="true">
              <img src="{{asset('backend/assets/images/fabicon.png')}}" alt="logo" width="20px">
            </span>
            <span class="logo-word">CLW-DOCS</span>
          </a>
        <p>cleanwater1 is a leading provider of water quality solutions and the only to offer a complete set of end-to-end water quality and wastewater treatment products and solutions.</p>

      </div>

      <div class="footer-col">
        <h4>Solutions</h4>
        <ul>
          <li><a href="https://cleanwater1.com/">Clean Water </a></li>
          <li><a href="https://cleanwater1.com/water-quality-solutions?hsLang=en">Water Quality</a></li>
          <li><a href="https://cleanwater1.com/wastewater-solutions">Wastewater Treatment</a></li>
          <li><a href="https://cleanwater1.com/services">Service</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Resources</h4>
        <ul>
          <li><a href="#docs">API Documentation</a></li>
          <li><a href="https://cleanwater1.com/email-preference-center">Profile and Preference</a></li>
          <li><a href="https://cleanwater1.com/team-and-locations">Team Map and Locations</a></li>
          <li><a href="https://cleanwater1.com/learning-track-sign-up">Learning Tracks</a></li>
          <li><a href="https://events.cleanwater1.com/">Upcoming Events</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Company</h4>
        <ul>
          <li><a href="https://cleanwater1.com/who-we-are">About</a></li>
          <li><a href="https://cleanwater1.com/news">News</a></li>
          <li><a href="https://cleanwater1.com/careers">Careers</a></li>
          <li><a href="https://cleanwater1.com/privacy-policy">Privacy Policy</a></li>
          <li><a href="https://cleanwater1.com/cookies-policy">Cookies Policy</a></li>
          <li><a href="https://cleanwater1.com/contact-us">Contact Us</a></li>
        </ul>
      </div>

    </div>

    <div class="container footer-bottom">
      <p>&copy; <span id="year"></span> clw-docs-backend. All rights reserved.</p>
      <p>By <a href="https://pixit.com.au/"> Pixit Design </a></p>
    </div>
  </footer>

  <script src="{{ asset('frontend/assets/js/script.js')}}"></script>
</body>
</html>
