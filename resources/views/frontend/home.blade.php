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

      <a href="#" class="logo" aria-label="clw-backend home">
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
          <li><a href="#docs">Api</a></li>
        </ul>

        <!-- shown inside off-canvas nav on mobile -->
        <div class="nav-actions-mobile">
          <a href="#get-started" class="btn btn-primary btn-block">Docs</a>
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
    <section class="hero">
      <div class="container hero-inner">
        <div class="hero-copy fade-in">
          <a href="#changelog" class="pill">
            <span class="pill-dot"></span>
            v1.0 is now available
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>

          <h1 class="hero-title">
            The backend framework that gets out of your way.
          </h1>

          <p class="hero-subtitle">
            CLW-DOCS backend is a lightweight, type-safe framework for building REST APIs in Node.js. Spin up a production-ready server in minutes,
            not days — with sane defaults and none of the boilerplate.
          </p>

          <div class="hero-actions">
            <a href="#docs" class="btn btn-primary btn-lg">
              Read the Docs
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
            <a href="https://github.com/" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-lg">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M12 .5C5.65.5.5 5.65.5 12c0 5.09 3.29 9.4 7.86 10.93.57.1.79-.25.79-.55v-2.13c-3.2.7-3.87-1.36-3.87-1.36-.53-1.33-1.29-1.69-1.29-1.69-1.05-.72.08-.7.08-.7 1.16.08 1.77 1.19 1.77 1.19 1.03 1.77 2.7 1.26 3.36.96.1-.75.4-1.26.73-1.55-2.56-.29-5.25-1.28-5.25-5.7 0-1.26.45-2.29 1.19-3.09-.12-.29-.52-1.46.11-3.05 0 0 .97-.31 3.18 1.18a11.05 11.05 0 0 1 5.8 0c2.2-1.49 3.18-1.18 3.18-1.18.63 1.59.23 2.76.11 3.05.74.8 1.19 1.83 1.19 3.09 0 4.43-2.7 5.4-5.27 5.68.41.36.78 1.07.78 2.16v3.2c0 .3.21.66.79.55A10.51 10.51 0 0 0 23.5 12C23.5 5.65 18.35.5 12 .5Z"/>
              </svg>
              View on GitHub
            </a>
          </div>

          <div class="hero-meta">
            <span>MIT Licensed</span>
            <span class="dot-sep">&bull;</span>
            <span>Zero dependencies core</span>
            <span class="dot-sep">&bull;</span>
            <span>TypeScript native</span>
          </div>
        </div>

        <div class="hero-visual fade-in">
          <div class="code-window">
            <div class="code-window-header">
              <span class="wdot wdot-red"></span>
              <span class="wdot wdot-yellow"></span>
              <span class="wdot wdot-green"></span>
              <span class="code-window-title">terminal</span>
            </div>
            <pre class="code-block"><code><span class="c-comment"># install the CLI</span>
<span class="c-fn">npm</span> install <span class="c-string">-g</span> clw-backend

<span class="c-comment"># scaffold a new project</span>
<span class="c-fn">clw</span> new my-api <span class="c-string">--template</span> rest

<span class="c-comment"># start the dev server</span>
<span class="c-fn">cd</span> my-api <span class="c-op">&&</span> <span class="c-fn">clw</span> dev

<span class="c-comment">→ server ready on http://localhost:4000</span>
<span class="c-comment">→ watching for changes...</span></code></pre>
          </div>
        </div>
      </div>
    </section>

    <!-- ============ TRUST BAR ============ -->
    <section class="trust-bar fade-in">
      <div class="container">
        <p class="trust-label">Built on tools you already trust</p>
        <ul class="trust-logos">
          <li>Php</li>
          <li>Laravel</li>
          <li>Node.js</li>
          <li>TypeScript</li>
          <li>MySql</li>
          <li>Next.js</li>
          
        </ul>
      </div>
    </section>

    <!-- ============ FEATURES ============ -->
    <section class="features" id="features">
      <div class="container">
        <div class="section-head fade-in">
          <span class="eyebrow">Features</span>
          <h2 class="section-title">Everything you need, nothing you don't</h2>
          <p class="section-subtitle">clw-backend ships with the essentials baked in, so you can focus on your product instead of wiring up infrastructure.</p>
        </div>

        <div class="features-grid">

          <article class="feature-card fade-in">
            <div class="feature-icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M13 2L4 14h6l-1 8 9-12h-6l1-8Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <h3>Fast &amp; lightweight</h3>
            <p>A minimal core with near-zero overhead. Cold starts in milliseconds and a footprint small enough for serverless and edge runtimes.</p>
          </article>

          <article class="feature-card fade-in">
            <div class="feature-icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M9 12l2 2 4-4M12 3l8 4v5c0 4.4-3.4 8.5-8 9-4.6-.5-8-4.6-8-9V7l8-4Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <h3>Type-safe by default</h3>
            <p>End-to-end TypeScript inference from your route handlers to your client SDK — catch API contract mismatches before they ship.</p>
          </article>

          <article class="feature-card fade-in">
            <div class="feature-icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 12h16M4 18h10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            </div>
            <h3>REST &amp; GraphQL support</h3>
            <p>Define your schema once and expose it as REST endpoints, a GraphQL API, or both — no duplicated logic, no extra glue code.</p>
          </article>

          <article class="feature-card fade-in">
            <div class="feature-icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><rect x="5" y="11" width="14" height="9" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="M8 11V7a4 4 0 1 1 8 0v4" stroke="currentColor" stroke-width="1.8"/></svg>
            </div>
            <h3>Built-in authentication</h3>
            <p>Session, JWT, and OAuth strategies ready out of the box, with sensible security defaults so you're not rolling your own auth.</p>
          </article>

          <article class="feature-card fade-in">
            <div class="feature-icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 2v4M12 18v4M4.9 4.9l2.8 2.8M16.3 16.3l2.8 2.8M2 12h4M18 12h4M4.9 19.1l2.8-2.8M16.3 7.7l2.8-2.8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            </div>
            <h3>Easy deployment</h3>
            <p>Ship to Docker, a VPS, or your favorite serverless platform with a single config file and zero vendor lock-in.</p>
          </article>

          <article class="feature-card fade-in">
            <div class="feature-icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M8 9l-4 3 4 3M16 9l4 3-4 3M13.5 5l-3 14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <h3>Great DX &amp; CLI tooling</h3>
            <p>A batteries-included CLI for scaffolding, migrations, and codegen — plus instant hot-reload during local development.</p>
          </article>

        </div>
      </div>
    </section>

    <!-- ============ STATS ============ -->
    <section class="stats fade-in">
      <div class="container stats-grid">
        <div class="stat-item">
          <span class="stat-number">10k+</span>
          <span class="stat-label">Downloads / month</span>
        </div>
        <div class="stat-item">
          <span class="stat-number">2.4k</span>
          <span class="stat-label">GitHub stars</span>
        </div>
        <div class="stat-item">
          <span class="stat-number">99.9%</span>
          <span class="stat-label">Uptime reported</span>
        </div>
        <div class="stat-item">
          <span class="stat-number">120+</span>
          <span class="stat-label">Contributors</span>
        </div>
      </div>
    </section>


  </main>

  <!-- ============ FOOTER ============ -->
  <footer class="site-footer" id="blog">
    <div class="container footer-grid">

      <div class="footer-brand">
      <a href="#" class="logo" aria-label="clw-backend home">
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
