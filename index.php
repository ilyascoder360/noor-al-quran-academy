s
<?php
/* ══════════════════════════════════════════════════════════════
   NOOR AL-QURAN ACADEMY  —  index.php
   PHP Contact Form Handler
   ══════════════════════════════════════════════════════════════ */

$form_status  = '';
$form_class   = '';
$TO_EMAIL     = 'your@gmail.com';          // ← Change to your Gmail
$SUBJECT_PREFIX = '[Noor Al-Quran] ';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_submit'])) {

    // ── Sanitise inputs
    $name    = htmlspecialchars(trim($_POST['name']    ?? ''), ENT_QUOTES, 'UTF-8');
    $email   = filter_var(trim($_POST['email']   ?? ''), FILTER_SANITIZE_EMAIL);
    $phone   = htmlspecialchars(trim($_POST['phone']   ?? ''), ENT_QUOTES, 'UTF-8');
    $course  = htmlspecialchars(trim($_POST['course']  ?? ''), ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars(trim($_POST['message'] ?? ''), ENT_QUOTES, 'UTF-8');

    // ── Basic validation
    if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$message) {
        $form_status = 'Please fill in all required fields with a valid email.';
        $form_class  = 'error';
    } else {
        // ── Build email body
        $body  = "New enquiry from Noor Al-Quran Academy website\n";
        $body .= "═══════════════════════════════════\n";
        $body .= "Name    : {$name}\n";
        $body .= "Email   : {$email}\n";
        $body .= "Phone   : {$phone}\n";
        $body .= "Course  : {$course}\n";
        $body .= "Message :\n{$message}\n";
        $body .= "═══════════════════════════════════\n";
        $body .= "Sent via: " . ($_SERVER['SERVER_NAME'] ?? 'localhost') . "\n";
        $body .= "Time    : " . date('Y-m-d H:i:s') . "\n";

        // ── RFC 2822 headers
        $headers  = "From: {$name} <{$email}>\r\n";
        $headers .= "Reply-To: {$email}\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        $subject = $SUBJECT_PREFIX . "Enquiry from {$name}";

        if (@mail($TO_EMAIL, $subject, $body, $headers)) {
            $form_status = "JazakAllah Khair! Your message has been sent. We'll contact you within 24 hours, In sha Allah.";
            $form_class  = 'success';
        } else {
            $form_status = 'Sorry, the mail server could not send your message. Please email us directly.';
            $form_class  = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quran Online Academy — Learn Quran Online</title>
<link rel="icon" type="image/png" href="assets/icon.png">
<meta name="description" content="Learn Quran online with certified teachers. Qaida, Tajweed & Hifz courses for all ages. Book your free trial today.">

<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Font Awesome 6 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

<script>
  /* ── Tailwind custom config ── */
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          emerald: {
            50:  '#ecfdf5', 100: '#d1fae5', 200: '#a7f3d0',
            300: '#6ee7b7', 400: '#34d399', 500: '#10b981',
            600: '#059669', 700: '#047857', 800: '#065f46',
            900: '#064e3b', 950: '#022c22',
          },
          gold: {
            50:  '#fffbeb', 100: '#fef3c7', 200: '#fde68a',
            300: '#fcd34d', 400: '#fbbf24', 500: '#f59e0b',
            600: '#d97706', 700: '#b45309', 800: '#92400e',
            900: '#78350f',
          },
        },
        fontFamily: {
          sans:    ['Inter', 'sans-serif'],
          display: ['Playfair Display', 'serif'],
          arabic:  ['Amiri', 'serif'],
        },
      }
    }
  }
</script>

<style>
  /* ── Global ── */
  html { scroll-behavior: smooth; }
  body { font-family: 'Inter', sans-serif; }

  /* ── Islamic geometric hero background ── */
  .hero-pattern {
    background-color: #022c22;
    background-image:
      radial-gradient(circle at 20% 50%, rgba(5,150,105,0.3) 0%, transparent 50%),
      radial-gradient(circle at 80% 20%, rgba(217,119,6,0.2) 0%, transparent 40%),
      url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100'%3E%3Cpolygon points='50,5 61,35 95,35 68,57 79,91 50,70 21,91 32,57 5,35 39,35' fill='none' stroke='rgba(245,158,11,0.08)' stroke-width='1'/%3E%3Ccircle cx='50' cy='50' r='30' fill='none' stroke='rgba(245,158,11,0.05)' stroke-width='0.5'/%3E%3C/svg%3E");
    background-size: auto, auto, 100px 100px;
  }

  /* ── Nav glass blur ── */
  .nav-glass {
    background: rgba(2, 44, 34, 0.9);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(245,158,11,0.15);
  }

  /* ── Gradient text ── */
  .gold-text {
    background: linear-gradient(135deg, #fbbf24, #f59e0b, #d97706);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  /* ── Card hover lift ── */
  .card-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
  .card-lift:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,0.15); }

  /* ── Pulse CTA ring ── */
  @keyframes ring-pulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(245,158,11,0.5); }
    50%      { box-shadow: 0 0 0 12px rgba(245,158,11,0); }
  }
  .ring-pulse { animation: ring-pulse 2.5s infinite; }

  /* ── Section divider ornament ── */
  .ornament::before, .ornament::after {
    content: '✦';
    color: #d97706;
    margin: 0 12px;
    font-size: 0.8rem;
  }

  /* ── YouTube iframe responsive ── */
  .yt-wrap { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 12px; }
  .yt-wrap iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none; }

  /* ── Form status messages ── */
  .status-success { background:#d1fae5; border:1px solid #059669; color:#065f46; }
  .status-error   { background:#fee2e2; border:1px solid #dc2626; color:#7f1d1d; }

  /* ── Mobile menu ── */
  #mobile-menu { transition: max-height 0.35s ease, opacity 0.35s ease; }
  #mobile-menu.hidden { max-height: 0; opacity: 0; overflow: hidden; }
  #mobile-menu.open   { max-height: 400px; opacity: 1; }

  /* ── Scrollbar ── */
  ::-webkit-scrollbar { width: 6px; }
  ::-webkit-scrollbar-track { background: #022c22; }
  ::-webkit-scrollbar-thumb { background: #d97706; border-radius: 3px; }
</style>
</head>

<body class="bg-gray-50 text-gray-800">
    

<!-- ═══════════════════════════════════════════
     STICKY NAVIGATION
═══════════════════════════════════════════ -->
<header class="nav-glass fixed top-0 left-0 right-0 z-50">
  <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">

      <!-- Logo -->
      <a href="#home" class="flex items-center gap-3 group">
        <div class="w-9 h-9 bg-gold-500 rounded-lg flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
          <i class="fa-solid fa-book-quran text-emerald-950 text-lg"></i>
        </div>
        <div>
          <span class="font-display text-lg font-bold text-white leading-none block">Noor Al-Quran</span>
          <span class="text-gold-400 text-xs tracking-widest uppercase">Academy</span>
        </div>
      </a>

      <!-- Desktop Links -->
      <ul class="hidden md:flex items-center gap-8">
        <?php foreach([
          ['#home','Home'],['#courses','Courses'],['#videos','Tutorials'],
          ['#contact','Contact']
        ] as [$href,$label]): ?>
        <li>
          <a href="<?= $href ?>" class="text-gray-300 hover:text-gold-400 text-sm font-medium tracking-wide transition-colors duration-200 relative after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-gold-400 hover:after:w-full after:transition-all">
            <?= $label ?>
          </a>
        </li>
        
        <?php endforeach; ?>
        <li>
    <a href="login.php" class="text-gray-300 hover:text-gold-400 text-sm font-medium">
        <i class="fa-solid fa-user-lock mr-1"></i> LMS Login
    </a>
</li>
 <li>
  </a>
                    

<a href="register.php" class="bg-yellow-500 text-emerald-900 px-5 py-2 rounded-lg font-bold hover:bg-white transition-all shadow-lg">
    Join Now
</a>
</li>

        <li>
          <a href="#contact" class="ring-pulse bg-gold-500 hover:bg-gold-400 text-emerald-950 font-bold text-sm px-5 py-2 rounded-full transition-all duration-200 shadow-lg">
            <i class="fa-solid fa-calendar-check mr-1.5"></i>Book Trial
          </a>
        </li>
        <ul class="hidden md:flex items-center gap-8">
    <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
    <li>
        <a href="admin_dashboard.php" class="flex items-center gap-2 bg-red-500/20 text-red-400 border border-red-500/40 px-4 py-1.5 rounded-full text-xs font-bold hover:bg-red-600 hover:text-white transition-all duration-300 shadow-lg shadow-red-900/20">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
            </span>
            <i class="fa-solid fa-user-shield"></i> 
            ADMIN PORTAL
        </a>
    </li>
    <?php endif; ?>

    </ul>
        
      </ul>

      <!-- Hamburger -->
      <button id="menu-btn" class="md:hidden text-gold-400 text-2xl focus:outline-none" aria-label="Toggle menu">
        <i class="fa-solid fa-bars" id="menu-icon"></i>
      </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden pb-4">
      <?php foreach([
        ['#home','fa-house','Home'],['#courses','fa-graduation-cap','Courses'],
        ['#videos','fa-play','Tutorials'],['#teachers','fa-chalkboard-teacher','Teachers'],
        ['#contact','fa-envelope','Contact']
      ] as [$href,$icon,$label]): ?>
      <a href="<?= $href ?>" class="mobile-link flex items-center gap-3 text-gray-300 hover:text-gold-400 py-2.5 px-2 text-sm border-b border-white/5 transition-colors">
        <i class="fa-solid <?= $icon ?> w-4 text-gold-500"></i><?= $label ?>
      </a>
      <?php endforeach; ?>
      <a href="#contact" class="mt-3 block text-center bg-gold-500 text-emerald-950 font-bold py-2.5 rounded-lg text-sm">
        <i class="fa-solid fa-calendar-check mr-1.5"></i>Book Free Trial
      </a>
    </div>
  </nav>
</header>


<!-- ═══════════════════════════════════════════
     HERO SECTION
═══════════════════════════════════════════ -->
<section id="home" class="hero-pattern min-h-screen flex items-center pt-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 w-full">
    <div class="grid lg:grid-cols-2 gap-16 items-center">

      <!-- Left Content -->
      <div>
        <div class="inline-flex items-center gap-2 bg-gold-500/10 border border-gold-500/30 text-gold-400 text-xs font-semibold tracking-widest uppercase px-4 py-2 rounded-full mb-6">
          <i class="fa-solid fa-star-and-crescent"></i>
          Online Quran Academy
        </div>

        <p class="font-arabic text-4xl text-gold-400 mb-3 leading-relaxed" dir="rtl">
          بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ
        </p>

        <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
          Learn the Holy
          <span class="gold-text block">Quran Online</span>
          With Experts
        </h1>

        <p class="text-gray-300 text-lg leading-relaxed mb-8 max-w-lg">
          One-on-one live sessions with certified scholars. Flexible timings, all age groups, and courses for every level — from Qaida to Hifz.
        </p>

        <!-- Stats strip -->
        <div class="flex flex-wrap gap-6 mb-10">
          <?php foreach([
            
            
            ['100%','Satisfaction Rate'],
          ] as [$n,$l]): ?>
          <div class="text-center">
            <div class="font-display text-2xl font-bold text-gold-400"><?= $n ?></div>
            <div class="text-gray-400 text-xs mt-0.5"><?= $l ?></div>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- CTA Buttons -->
        <div class="flex flex-wrap gap-4">
          <a href="#contact" class="ring-pulse inline-flex items-center gap-2 bg-gold-500 hover:bg-gold-400 text-emerald-950 font-bold px-8 py-3.5 rounded-full shadow-xl transition-all duration-200 text-sm">
            <i class="fa-solid fa-calendar-check"></i>
            Book Free Trial
          </a>
          <a href="#courses" class="inline-flex items-center gap-2 border border-white/30 text-white hover:border-gold-400 hover:text-gold-400 font-medium px-8 py-3.5 rounded-full transition-all duration-200 text-sm">
            <i class="fa-solid fa-book-open"></i>
            View Courses
          </a>
        </div>
      </div>

      <!-- Right Card -->
      <div class="hidden lg:block">
        <div class="bg-white/5 border border-gold-500/20 rounded-2xl p-8 backdrop-blur-sm">
          <h3 class="font-display text-gold-400 text-lg mb-6 text-center">
            <i class="fa-solid fa-mosque mr-2"></i>Why Choose Us?
          </h3>
          <ul class="space-y-4">
            <?php foreach([
              ['fa-user-graduate','Certified & Ijazah-holding tutors'],
              ['fa-video','Live 1-on-1 sessions via Zoom/Skype'],
              ['fa-calendar-days','Flexible timings — 7 days a week'],
              
              ['fa-globe','Students from 30+ countries'],
              ['fa-gift','3 Free trial classes — no card needed'],
              ['fa-chart-line','Progress reports every month'],
              ['fa-shield-halved','Safe, moderated learning environment'],
            ] as [$icon,$text]): ?>
            <li class="flex items-start gap-3">
              <span class="w-7 h-7 bg-gold-500/15 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                <i class="fa-solid <?= $icon ?> text-gold-400 text-xs"></i>
              </span>
              <span class="text-gray-300 text-sm leading-relaxed"><?= $text ?></span>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════
     COURSES SECTION
═══════════════════════════════════════════ -->
<section id="courses" class="py-24 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="text-center mb-16">
      <p class="text-gold-600 text-sm font-semibold tracking-widest uppercase ornament">Our Programs</p>
      <h2 class="font-display text-4xl font-bold text-emerald-900 mt-2 mb-4">Courses for Every Level</h2>
      <div class="w-16 h-1 bg-gold-500 mx-auto rounded-full mb-4"></div>
      <p class="text-gray-500 max-w-xl mx-auto leading-relaxed">
        Structured courses designed by Islamic scholars to take you from beginner to advanced, step by step.
      </p>
    </div>

    <!-- Course Cards -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

      <?php
      $courses = [
        [
          'icon'  => 'fa-arabic',
          'fa'    => 'fa-solid fa-pen-nib',
          'badge' => 'Beginner',
          'badge_color' => 'bg-blue-100 text-blue-700',
          'title' => 'Noorani Qaida',
          'arabic'=> 'نورانی قاعدہ',
          'desc'  => 'Start from scratch. Learn Arabic letters, joining rules, and correct pronunciation before moving to the Quran.',
          'features' => ['Arabic alphabet & sounds','Letter joining rules','Short & long vowels','Practice exercises'],
          'price' => '$20',
          'duration' => '3 classes/week',
          'age'   => 'All ages',
          'color' => 'from-blue-600 to-emerald-700',
          'icon_bg' => 'bg-blue-50',
          'icon_color' => 'text-blue-600',
        ],
        [
          'fa'    => 'fa-solid fa-quran',
          'badge' => 'Intermediate',
          'badge_color' => 'bg-emerald-100 text-emerald-700',
          'title' => 'Tajweed ul-Quran',
          'arabic'=> 'تجوید القرآن',
          'desc'  => 'Master the rules of Tajweed for beautiful, accurate recitation. Learn Makharij, Sifaat, and all recitation rules.',
          'features' => ['Rules of Noon & Meem','Madd (elongation) rules','Qalqala & Waqf','Practical recitation'],
          'price' => '$30',
          'duration' => '4 classes/week',
          'age'   => '8+ years',
          'color' => 'from-emerald-700 to-teal-600',
          'icon_bg' => 'bg-emerald-50',
          'icon_color' => 'text-emerald-700',
        ],
       
        [
          'fa'    => 'fa-solid fa-child-reaching',
          'badge' => 'Kids',
          'badge_color' => 'bg-purple-100 text-purple-700',
          'title' => 'Kids Islamic Program',
          'arabic'=> 'اسلامی تعلیم',
          'desc'  => 'Fun, engaging Quran & Islamic studies for children aged 4–12 with interactive methods and patience.',
          'features' => ['Qaida for beginners','Duas & short surahs','Islamic manners','Fun learning activities'],
          'price' => '$18',
          'duration' => '3 classes/week',
          'age'   => '4–12 years',
          'color' => 'from-purple-600 to-pink-500',
          'icon_bg' => 'bg-purple-50',
          'icon_color' => 'text-purple-600',
        ],
        [
          'fa'    => 'fa-solid fa-language',
          'badge' => 'All Levels',
          'badge_color' => 'bg-teal-100 text-teal-700',
          'title' => 'Quran Translation',
          'arabic'=> 'ترجمہ القرآن',
          'desc'  => 'Understand the divine message word by word. Learn translation and Tafseer to connect deeply with the Quran.',
          'features' => ['Word-by-word translation','Tafseer (commentary)','Vocabulary building','Contextual understanding'],
          'price' => '$28',
          'duration' => '3 classes/week',
          'age'   => '12+ years',
          'color' => 'from-teal-600 to-cyan-500',
          'icon_bg' => 'bg-teal-50',
          'icon_color' => 'text-teal-600',
        ],
        
      ];

      foreach ($courses as $c): ?>
      <div class="card-lift bg-white rounded-2xl overflow-hidden shadow-md border border-gray-100 flex flex-col">
        <!-- Card top banner -->
        <div class="bg-gradient-to-r <?= $c['color'] ?> p-6 relative">
          <span class="inline-block <?= $c['badge_color'] ?> text-xs font-bold px-3 py-1 rounded-full mb-3">
            <?= $c['badge'] ?>
          </span>
          <h3 class="font-display text-xl font-bold text-white"><?= $c['title'] ?></h3>
          <p class="font-arabic text-white/70 text-lg mt-1" dir="rtl"><?= $c['arabic'] ?></p>
          <div class="absolute top-4 right-4 w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center">
            <i class="<?= $c['fa'] ?> text-white text-xl"></i>
          </div>
        </div>

        <!-- Card body -->
        <div class="p-6 flex-1 flex flex-col">
          <p class="text-gray-500 text-sm leading-relaxed mb-5"><?= $c['desc'] ?></p>
          <ul class="space-y-2 mb-6 flex-1">
            <?php foreach ($c['features'] as $f): ?>
            <li class="flex items-center gap-2 text-sm text-gray-600">
              <i class="fa-solid fa-circle-check text-emerald-500 text-xs flex-shrink-0"></i>
              <?= $f ?>
            </li>
            <?php endforeach; ?>
          </ul>

          <!-- Card footer -->
          <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
            <div>
              <div class="font-display text-2xl font-bold text-emerald-800"><?= $c['price'] ?><span class="text-sm font-normal text-gray-400">/mo</span></div>
              <div class="text-xs text-gray-400 mt-0.5">
                <i class="fa-regular fa-clock mr-1"></i><?= $c['duration'] ?> &nbsp;·&nbsp;
                <i class="fa-solid fa-user mr-1"></i><?= $c['age'] ?>
              </div>
            </div>
            <a href="#contact" class="inline-flex items-center gap-1.5 bg-emerald-800 hover:bg-emerald-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
              Enroll <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>

    </div><!-- /grid -->
  </div>
</section>
<section id="how-it-works" class="py-24 bg-white font-['Plus_Jakarta_Sans']">
    <div class="container mx-auto px-4">
        
        <div class="text-center mb-20">
            <span class="text-emerald-600 font-bold tracking-[0.2em] uppercase text-sm mb-3 block">Simple Process</span>
            <h2 class="text-4xl md:text-5xl font-extrabold text-emerald-900 mb-6 tracking-tight">
                How It <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500">Works</span>
            </h2>
            <div class="w-16 h-1.5 bg-yellow-500 mx-auto rounded-full mb-6"></div>
            <p class="text-gray-500 max-w-2xl mx-auto text-lg leading-relaxed font-medium">
                Start your journey towards professional Quranic education from the comfort of your home in just three easy steps.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-16 relative">
            
            <div class="relative text-center group">
                <div class="w-24 h-24 bg-emerald-50 text-emerald-700 rounded-[2rem] flex items-center justify-center mx-auto mb-8 transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-sm border border-emerald-100/50">
                    <i class="fa-solid fa-calendar-day text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-emerald-900 mb-4 tracking-tight">1. Book Free Trial</h3>
                <p class="text-gray-500 px-4 leading-relaxed font-medium">
                    Fill out our registration form or message on <span class="text-emerald-600 font-semibold">WhatsApp</span> to schedule your 3-day trial.
                </p>
                <div class="hidden md:block absolute top-12 -right-10 text-emerald-100">
                    <i class="fa-solid fa-arrow-right-long text-3xl"></i>
                </div>
            </div>

            <div class="relative text-center group">
                <div class="w-24 h-24 bg-emerald-700 text-white rounded-[2rem] flex items-center justify-center mx-auto mb-8 transform group-hover:scale-110 group-hover:-rotate-6 transition-all duration-500 shadow-2xl shadow-emerald-200">
                    <i class="fa-solid fa-chalkboard-user text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-emerald-900 mb-4 tracking-tight">2. Meet Your Tutor</h3>
                <p class="text-gray-500 px-4 leading-relaxed font-medium">
                    Log in via Skype or Zoom to meet your certified tutor and start your first interactive <span class="text-emerald-600 font-semibold">live session</span>.
                </p>
                <div class="hidden md:block absolute top-12 -right-10 text-emerald-100">
                    <i class="fa-solid fa-arrow-right-long text-3xl"></i>
                </div>
            </div>

            <div class="relative text-center group">
                <div class="w-24 h-24 bg-emerald-50 text-emerald-700 rounded-[2rem] flex items-center justify-center mx-auto mb-8 transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-sm border border-emerald-100/50">
                    <i class="fa-solid fa-star-and-crescent text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-emerald-900 mb-4 tracking-tight">3. Regular Learning</h3>
                <p class="text-gray-500 px-4 leading-relaxed font-medium">
                    Choose a flexible schedule that fits your lifestyle and continue your regular <span class="text-emerald-600 font-semibold">Quranic studies</span>.
                </p>
            </div>

        </div>

        <div class="text-center mt-20">
            <a href="#contact" class="inline-flex items-center gap-3 bg-emerald-800 text-white px-12 py-5 rounded-2xl font-bold text-lg shadow-xl hover:bg-emerald-900 hover:-translate-y-1 transition-all duration-300">
                <span>Start Free Trial</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

    </div>
</section>
<section class="py-24 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col lg:flex-row items-center gap-16">
            
            <div class="w-full lg:w-1/2 relative">
                <div class="relative rounded-[2.5rem] overflow-hidden border-[10px] border-emerald-50 shadow-xl">
                    <img src="https://images.unsplash.com/photo-1584697964400-2af6a2f6204c?auto=format&fit=crop&w=1000&q=80" 
                         alt="Live Quran Session" 
                         class="w-full h-[480px] object-cover">
                    
                    <div class="absolute top-6 left-6 bg-white/90 backdrop-blur px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm border border-emerald-100">
                        <span class="flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                        </span>
                        <span class="font-sans text-[10px] font-bold uppercase tracking-widest text-emerald-900">Live Now</span>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/2 space-y-8">
                <div class="space-y-4">
                    <h4 class="font-sans text-emerald-700 font-bold uppercase tracking-widest text-xs">Modern Learning Experience</h4>
                    <h2 class="font-display text-4xl md:text-5xl font-bold text-emerald-900 leading-tight">
                        Every Lesson Now <br>
                        <span class="text-emerald-800 italic">Live & Effortless</span>
                    </h2>
                </div>

                <p class="font-sans text-gray-500 text-lg leading-relaxed font-normal">
                    Our academy provides interactive live sessions via Zoom. Learn Quran from the comfort of your home with real-time screen sharing and direct interaction.
                </p>

                <div class="space-y-3 pt-2">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-check text-emerald-600 text-sm"></i>
                        <span class="font-sans text-emerald-900 font-medium">Real-time interaction with tutors</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-check text-emerald-600 text-sm"></i>
                        <span class="font-sans text-emerald-900 font-medium">Professional Zoom Environment</span>
                    </div>
                </div>

                <div class="pt-6">
                    <a href="YOUR_ZOOM_LINK" target="_blank" 
                       class="inline-flex items-center gap-3 bg-[#065f46] text-white px-8 py-3.5 rounded-2xl font-sans font-bold text-lg hover:bg-[#047857] transition-all shadow-md group">
                        Join Class
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                    <p class="font-sans text-[10px] text-gray-400 mt-4 uppercase tracking-widest font-bold ml-1">
                        Starts your live session
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════
     VIDEO TUTORIALS SECTION
═══════════════════════════════════════════ -->
<section id="videos" class="py-24 bg-emerald-950">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="text-center mb-16">
      <p class="text-gold-400 text-sm font-semibold tracking-widest uppercase ornament">Free Lessons</p>
      <h2 class="font-display text-4xl font-bold text-white mt-2 mb-4">Video Tutorial Gallery</h2>
      <div class="w-16 h-1 bg-gold-500 mx-auto rounded-full mb-4"></div>
      <p class="text-gray-400 max-w-xl mx-auto leading-relaxed">
        Watch free sample lessons from our expert teachers and experience the quality of our teaching before enrolling.
      </p>
    </div>

    <!-- Featured Video Row -->
    <div class="grid lg:grid-cols-2 gap-8 mb-10">

      <!-- Video 1 — Noorani Qaida -->
      <div class="group">
        <div class="yt-wrap shadow-2xl ring-1 ring-gold-500/20 group-hover:ring-gold-500/50 transition-all duration-300">
          <!--
            Noorani Qaida lesson — replace VIDEO_ID_1 with any YouTube video ID.
            Example IDs for Qaida lessons (publicly available):
              WlzJF1D7QYI  |  MH-mbZHTc28  |  KRfV0RBfBvc
          -->
          <iframe
            src="https://www.youtube.com/embed/WlzJF1D7QYI?rel=0&modestbranding=1&color=white"
            title="Noorani Qaida Lesson 1 — Learn Arabic Letters"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen
            loading="lazy">
          </iframe>
        </div>
        <div class="mt-4 flex items-start gap-3">
          <div class="w-9 h-9 bg-gold-500/15 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
            <i class="fa-solid fa-pen-nib text-gold-400 text-sm"></i>
          </div>
          <div>
            <h4 class="font-display text-white font-bold">Noorani Qaida — Lesson 1</h4>
            <p class="text-gray-400 text-sm mt-1">Learn Arabic alphabets and correct pronunciation from scratch. Perfect for complete beginners of all ages.</p>
            <div class="flex items-center gap-3 mt-2">
              <span class="text-xs bg-blue-500/15 text-blue-400 px-2.5 py-1 rounded-full"><i class="fa-solid fa-signal mr-1"></i>Beginner</span>
              <span class="text-xs text-gray-500"><i class="fa-regular fa-clock mr-1"></i>~18 min</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Video 2 — Quran Recitation with Tajweed -->
      <div class="group">
        <div class="yt-wrap shadow-2xl ring-1 ring-gold-500/20 group-hover:ring-gold-500/50 transition-all duration-300">
          <!--
            Tajweed / Quran recitation lesson — replace VIDEO_ID_2 with any YouTube video ID.
            Example IDs for Tajweed lessons (publicly available):
              _4PcnT8mDeA  |  5frgfmJnDiA  |  Q8VPiTJJ4ec
          -->
          <iframe
            src="https://www.youtube.com/embed/_4PcnT8mDeA?rel=0&modestbranding=1&color=white"
            title="Learn Quran Recitation with Tajweed Rules"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen
            loading="lazy">
          </iframe>
        </div>
        <div class="mt-4 flex items-start gap-3">
          <div class="w-9 h-9 bg-emerald-500/15 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
            <i class="fa-solid fa-quran text-emerald-400 text-sm"></i>
          </div>
          <div>
            <h4 class="font-display text-white font-bold">Tajweed Rules — Complete Guide</h4>
            <p class="text-gray-400 text-sm mt-1">Master the essential Tajweed rules to recite the Quran beautifully and correctly, as revealed to Prophet Muhammad ﷺ.</p>
            <div class="flex items-center gap-3 mt-2">
              <span class="text-xs bg-emerald-500/15 text-emerald-400 px-2.5 py-1 rounded-full"><i class="fa-solid fa-signal mr-1"></i>Intermediate</span>
              <span class="text-xs text-gray-500"><i class="fa-regular fa-clock mr-1"></i>~25 min</span>
            </div>
          </div>
        </div>
      </div>

    </div><!-- /featured videos -->

    <!-- Additional playlist-style thumbnails -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6">
      <?php
      $playlist = [
        ['fa-solid fa-moon','Surah Al-Fatiha','Recitation','text-gold-400','bg-gold-400/10'],
        ['fa-solid fa-star','Surah Al-Ikhlas','Memorization','text-blue-400','bg-blue-400/10'],
        ['fa-solid fa-fire','Makhraj Lesson','Pronunciation','text-rose-400','bg-rose-400/10'],
        ['fa-solid fa-droplet','Madd Rules','Tajweed','text-teal-400','bg-teal-400/10'],
      ];
      foreach ($playlist as [$icon,$title,$tag,$tc,$bc]): ?>
      <a href="#videos" class="<?= $bc ?> border border-white/10 hover:border-gold-500/40 rounded-xl p-4 flex flex-col items-center text-center gap-2 transition-all duration-200 group card-lift">
        <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center group-hover:scale-110 transition-transform">
          <i class="<?= $icon ?> <?= $tc ?> text-lg"></i>
        </div>
        <div class="text-white text-xs font-semibold leading-tight"><?= $title ?></div>
        <div class="<?= $tc ?> text-xs"><?= $tag ?></div>
        <div class="w-7 h-7 rounded-full bg-white/10 flex items-center justify-center">
          <i class="fa-solid fa-play text-white text-xs ml-0.5"></i>
        </div>
      </a>
      <?php endforeach; ?>
    </div>

    <div class="text-center mt-10">
      <a href="https://www.youtube.com/@NoorAlQuranAcademy" target="_blank" rel="noopener"
         class="inline-flex items-center gap-2 border border-gold-500/40 text-gold-400 hover:bg-gold-500 hover:text-emerald-950 font-semibold px-6 py-3 rounded-full transition-all duration-200 text-sm">
        <i class="fa-brands fa-youtube text-lg"></i>
        Watch Full Playlist on YouTube
      </a>
    </div>

  </div>
</section>





<!-- ═══════════════════════════════════════════
     TESTIMONIALS
═══════════════════════════════════════════ -->
<section class="py-20 bg-emerald-900">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
      <p class="text-gold-400 text-sm font-semibold tracking-widest uppercase ornament">Reviews</p>
      <h2 class="font-display text-3xl font-bold text-white mt-2">What Our Students Say</h2>
    </div>
    <div class="grid md:grid-cols-3 gap-6">
      <?php
      $reviews = [
        ['SA','Sara Ahmed','United Kingdom','My daughter started from zero and within 6 months she recites beautifully with Tajweed. The teacher is incredibly patient.'],
        ['YK','Yusuf Khan','United States','Alhamdulillah, I completed my Hifz. The structured revision system and daily sessions made all the difference. Highly recommended!'],
        ['LM','Laura Martinez','Canada','As a new Muslim learning to read Arabic, this academy was a true blessing. Flexible schedule and a very supportive teacher.'],
      ];
      foreach ($reviews as [$init,$name,$from,$text]): ?>
      <div class="bg-emerald-800/60 border border-white/10 rounded-2xl p-6 relative">
        <div class="font-arabic text-gold-400 text-5xl opacity-30 leading-none absolute top-3 left-5">"</div>
        <div class="flex gap-1 text-gold-400 text-sm mb-3 mt-4">
          <?php for($i=0;$i<5;$i++): ?><i class="fa-solid fa-star"></i><?php endfor; ?>
        </div>
        <p class="text-gray-300 text-sm leading-relaxed italic mb-5"><?= $text ?></p>
        <div class="flex items-center gap-3 border-t border-white/10 pt-4">
          <div class="w-9 h-9 rounded-full bg-gold-500/20 flex items-center justify-center text-gold-300 font-bold text-sm"><?= $init ?></div>
          <div>
            <div class="text-white text-sm font-semibold"><?= $name ?></div>
            <div class="text-gray-400 text-xs"><?= $from ?></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════
     PRICING BANNER
═══════════════════════════════════════════ -->
<section class="py-16 bg-gold-500">
  <div class="max-w-5xl mx-auto px-4 text-center">
    <h2 class="font-display text-3xl font-bold text-emerald-950 mb-3">Start With 3 Free Trial Classes</h2>
    <p class="text-emerald-900/80 mb-8 max-w-lg mx-auto">No credit card required. Experience our teaching quality before committing to a plan. Cancel anytime.</p>
    <div class="flex flex-wrap justify-center gap-6 mb-8">
      <?php foreach([
        ['fa-lock-open','No commitment'],
        ['fa-credit-card','No card needed'],
        ['fa-globe','Any device, anywhere'],
        ['fa-headset','24/7 support'],
      ] as [$icon,$label]): ?>
      <div class="flex items-center gap-2 text-emerald-950 font-medium text-sm">
        <i class="fa-solid <?= $icon ?>"></i><?= $label ?>
      </div>
      <?php endforeach; ?>
    </div>
    <a href="#contact" class="ring-pulse inline-flex items-center gap-2 bg-emerald-950 hover:bg-emerald-900 text-white font-bold px-10 py-4 rounded-full shadow-xl transition-all">
      <i class="fa-solid fa-calendar-check"></i>Book My Free Trial
    </a>
  </div>
</section>


<!-- ═══════════════════════════════════════════
     CONTACT / ENROLMENT FORM
═══════════════════════════════════════════ -->
<section id="contact" class="py-24 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid lg:grid-cols-2 gap-16 items-start">

      <!-- Left Info -->
      <div>
        <p class="text-gold-600 text-sm font-semibold tracking-widest uppercase ornament">Enrol Today</p>
        <h2 class="font-display text-4xl font-bold text-emerald-900 mt-2 mb-4">Get in Touch</h2>
        <div class="w-16 h-1 bg-gold-500 rounded-full mb-6"></div>
        <p class="text-gray-500 leading-relaxed mb-8">
          Fill in the form and our team will contact you within 24 hours, In sha Allah, to arrange your free trial class and match you with the right teacher.
        </p>
        <ul class="space-y-5">
          <?php foreach([
            ['fa-envelope','Email','quranonlineclass1@gmail.com'],
            ['fa-whatsapp','WhatsApp','+92 3079683868'],
            ['fa-clock','Office Hours','Mon–Sat  9 AM – 10 PM (PKT)'],
            ['fa-globe','Students From','30+ Countries Worldwide'],
          ] as [$icon,$label,$val]): ?>
          <li class="flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
              <i class="fa-brands fa-<?= str_starts_with($icon,'fa-brands') ? substr($icon,9) : '' ?><?php if(!str_starts_with($icon,'fa-brands')): ?><i class="fa-solid <?= $icon ?> text-emerald-700 text-base"></i><?php endif; ?><?= str_starts_with($icon,'fa-brands') ? ' text-emerald-700 text-base' : '' ?>
              <?php if($icon==='fa-whatsapp'): ?><i class="fa-brands fa-whatsapp text-emerald-700 text-base"></i><?php elseif($icon!=='fa-whatsapp'): ?><i class="fa-solid <?= $icon ?> text-emerald-700 text-base"></i><?php endif; ?>
              </div>
            <div>
              <div class="text-xs text-gray-400 uppercase tracking-wide"><?= $label ?></div>
              <div class="text-gray-700 font-medium text-sm"><?= $val ?></div>
            </div>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <!-- Right Form -->
      <div class="bg-gray-50 border border-gray-100 rounded-2xl p-8 shadow-sm">

        <?php if ($form_status): ?>
        <div class="status-<?= $form_class ?> rounded-xl px-4 py-3 text-sm font-medium mb-6 flex items-start gap-2">
          <i class="fa-solid <?= $form_class==='success' ? 'fa-circle-check text-emerald-600' : 'fa-circle-xmark text-red-600' ?> mt-0.5 flex-shrink-0"></i>
          <span><?= $form_status ?></span>
        </div>
        <?php endif; ?>

        <form method="POST" action="#contact" class="space-y-5" novalidate>
          <input type="hidden" name="form_submit" value="1">

          <!-- Name -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
              <i class="fa-solid fa-user text-emerald-600 mr-1.5"></i>Full Name <span class="text-red-500">*</span>
            </label>
            <input type="text" name="name" required placeholder="e.g. Ahmed Ali"
              value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
              class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition bg-white">
          </div>

          <!-- Email + Phone -->
          <div class="grid sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                <i class="fa-solid fa-envelope text-emerald-600 mr-1.5"></i>Email <span class="text-red-500">*</span>
              </label>
              <input type="email" name="email" required placeholder="you@email.com"
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition bg-white">
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                <i class="fa-solid fa-phone text-emerald-600 mr-1.5"></i>Phone / WhatsApp
              </label>
              <input type="tel" name="phone" placeholder="+92 300 000 0000"
                value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition bg-white">
            </div>
          </div>

          <!-- Course Select -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
              <i class="fa-solid fa-book-quran text-emerald-600 mr-1.5"></i>Course of Interest
            </label>
            <select name="course" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white transition">
              <option value="">— Select a course —</option>
              <?php foreach([
                'Noorani Qaida (Beginner)',
                'Tajweed ul-Quran',
                'Hifz ul-Quran',
                'Kids Islamic Program (4–12)',
                'Quran Translation & Tafseer',
                'Islamic Studies',
                'Not sure — advise me',
              ] as $opt): ?>
              <option value="<?= $opt ?>" <?= (($_POST['course'] ?? '') === $opt) ? 'selected' : '' ?>><?= $opt ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Message -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
              <i class="fa-solid fa-comment text-emerald-600 mr-1.5"></i>Message <span class="text-red-500">*</span>
            </label>
            <textarea name="message" rows="4" required
              placeholder="Tell us your current level, preferred schedule, or any questions..."
              class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition bg-white resize-none"><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
          </div>

          <!-- Submit -->
          <button type="submit"
            class="w-full ring-pulse bg-emerald-800 hover:bg-emerald-700 text-white font-bold py-3.5 rounded-xl transition-all text-sm flex items-center justify-center gap-2 shadow-lg">
            <i class="fa-solid fa-paper-plane"></i>
            Send Enquiry — Book Free Trial
          </button>

          <p class="text-center text-xs text-gray-400">
            <i class="fa-solid fa-lock mr-1"></i>Your information is safe and will never be shared.
          </p>
        </form>
      </div><!-- /form card -->

    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════
     FOOTER
═══════════════════════════════════════════ -->
<footer class="bg-emerald-950 text-gray-400">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">

      <!-- Brand -->
      <div class="lg:col-span-1">
        <div class="flex items-center gap-3 mb-4">
          <div class="w-9 h-9 bg-gold-500 rounded-lg flex items-center justify-center">
            <i class="fa-solid fa-book-quran text-emerald-950 text-lg"></i>
          </div>
          <div>
            <span class="font-display text-white font-bold block leading-none">Noor Al-Quran</span>
            <span class="text-gold-400 text-xs tracking-widest">Academy</span>
          </div>
        </div>
        <p class="text-sm leading-relaxed mb-5">Spreading the light of the Holy Quran to Muslims around the world, one student at a time. Est. 2018.</p>
        <div class="flex gap-3">
          <?php foreach([
            ['fa-brands fa-facebook-f','#'],
            ['fa-brands fa-instagram','#'],
            ['fa-brands fa-youtube','#'],
            ['fa-brands fa-whatsapp','#'],
          ] as [$icon,$href]): ?>
          <a href="<?= $href ?>" class="w-8 h-8 bg-white/5 hover:bg-gold-500 hover:text-emerald-950 rounded-lg flex items-center justify-center text-sm transition-all">
            <i class="<?= $icon ?>"></i>
          </a>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Courses -->
      <div>
        <h4 class="font-display text-gold-400 text-sm font-bold mb-4 tracking-wide">Courses</h4>
        <ul class="space-y-2 text-sm">
          <?php foreach(['Noorani Qaida','Tajweed ul-Quran','Hifz Program','Kids Islamic Program','Quran Translation','Islamic Studies'] as $c): ?>
          <li><a href="#courses" class="hover:text-gold-400 transition-colors"><?= $c ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <!-- Academy -->
      <div>
        <h4 class="font-display text-gold-400 text-sm font-bold mb-4 tracking-wide">Academy</h4>
        <ul class="space-y-2 text-sm">
          <?php foreach(['About Us','Our Teachers','Pricing Plans','Free Trial','Blog','Testimonials'] as $l): ?>
          <li><a href="#" class="hover:text-gold-400 transition-colors"><?= $l ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <!-- Contact -->
      <div>
        <h4 class="font-display text-gold-400 text-sm font-bold mb-4 tracking-wide">Contact Us</h4>
        <ul class="space-y-3 text-sm">
          <li class="flex items-center gap-2"><i class="fa-solid fa-envelope w-4 text-gold-500"></i> quranonlineclass1@gmail.com</li>
          <li class="flex items-center gap-2"><i class="fa-brands fa-whatsapp w-4 text-gold-500"></i> +92 3079683868</li>
          <li class="flex items-center gap-2"><i class="fa-solid fa-clock w-4 text-gold-500"></i> Mon–Sat, 9AM–10PM</li>
          <li class="flex items-start gap-2"><i class="fa-solid fa-location-dot w-4 text-gold-500 mt-0.5"></i> Online — serving 30+ countries</li>
        </ul>
      </div>

    </div>

    <div class="border-t border-white/10 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-600">
      <p>© <?= date('Y') ?> Noor Al-Quran Academy. All rights reserved. Designed with <span class="text-red-400">♥</span> for the Ummah.</p>
      <div class="flex gap-5">
        <a href="#" class="hover:text-gold-400 transition-colors">Privacy Policy</a>
        <a href="#" class="hover:text-gold-400 transition-colors">Terms of Service</a>
        <a href="#" class="hover:text-gold-400 transition-colors">Refund Policy</a>
      </div>
    </div>
  </div>
</footer>

<!-- ═══════════════════════════════════════════
     JAVASCRIPT — Mobile menu + scroll spy
═══════════════════════════════════════════ -->
<script>
/* ── Mobile menu toggle ── */
const btn      = document.getElementById('menu-btn');
const menu     = document.getElementById('mobile-menu');
const menuIcon = document.getElementById('menu-icon');

btn.addEventListener('click', () => {
  const isOpen = menu.classList.contains('open');
  menu.classList.toggle('hidden', isOpen);
  menu.classList.toggle('open', !isOpen);
  menuIcon.className = isOpen ? 'fa-solid fa-bars' : 'fa-solid fa-xmark';
});

/* Close mobile menu when a link is tapped */
document.querySelectorAll('.mobile-link, #mobile-menu a').forEach(link => {
  link.addEventListener('click', () => {
    menu.classList.remove('open');
    menu.classList.add('hidden');
    menuIcon.className = 'fa-solid fa-bars';
  });
});

/* ── Smooth back-to-top via logo ── */
document.querySelector('a[href="#home"]')?.addEventListener('click', e => {
  e.preventDefault();
  window.scrollTo({ top: 0, behavior: 'smooth' });
});

/* ── Intersection observer: fade-in sections ── */
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.style.opacity = '1';
      entry.target.style.transform = 'translateY(0)';
    }
  });
}, { threshold: 0.1 });

document.querySelectorAll('section').forEach(sec => {
  sec.style.opacity = '0';
  sec.style.transform = 'translateY(24px)';
  sec.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
  observer.observe(sec);
});

/* ── Fix first section (hero) visible immediately ── */
const hero = document.getElementById('home');
if (hero) { hero.style.opacity = '1'; hero.style.transform = 'none'; }
</script>
<!-- ═══════════════════════════════════════════
     WHATSAPP FLOATING BUTTON
═══════════════════════════════════════════ -->
<a href="https://wa.me/923079683868"
   target="_blank"
   rel="noopener"
   class="whatsapp-float"
   aria-label="Chat on WhatsApp">
   
   <span class="whatsapp-tooltip">Chat With Us</span>

   <div class="whatsapp-icon-wrap">
      <i class="fa-brands fa-whatsapp"></i>
   </div>
</a>

<style>
/* ── WhatsApp Floating Button ── */
.whatsapp-float{
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 9999;
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    font-family: 'Inter', sans-serif;
}

/* Tooltip */
.whatsapp-tooltip{
    background: rgba(2, 44, 34, 0.92);
    color: #fbbf24;
    padding: 10px 16px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.3px;
    border: 1px solid rgba(245,158,11,0.25);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    opacity: 0;
    transform: translateX(10px);
    pointer-events: none;
    transition: all 0.3s ease;
}

/* Show tooltip on hover */
.whatsapp-float:hover .whatsapp-tooltip{
    opacity: 1;
    transform: translateX(0);
}

/* Circle button */
.whatsapp-icon-wrap{
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: linear-gradient(135deg, #10b981, #047857);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 31px;
    box-shadow:
      0 10px 25px rgba(5,150,105,0.35),
      0 0 0 0 rgba(16,185,129,0.5);
    border: 2px solid rgba(251,191,36,0.35);
    transition: all 0.3s ease;
    animation: whatsappPulse 2.5s infinite;
}

/* Hover Effect */
.whatsapp-float:hover .whatsapp-icon-wrap{
    transform: translateY(-4px) scale(1.05);
    box-shadow:
      0 15px 35px rgba(5,150,105,0.45),
      0 0 0 12px rgba(16,185,129,0);
}

/* Pulse Animation */
@keyframes whatsappPulse {
    0%{
        box-shadow:
          0 10px 25px rgba(5,150,105,0.35),
          0 0 0 0 rgba(16,185,129,0.45);
    }

    70%{
        box-shadow:
          0 10px 25px rgba(5,150,105,0.35),
          0 0 0 16px rgba(16,185,129,0);
    }

    100%{
        box-shadow:
          0 10px 25px rgba(5,150,105,0.35),
          0 0 0 0 rgba(16,185,129,0);
    }
}

/* Mobile Responsive */
@media (max-width: 640px){

    .whatsapp-float{
        bottom: 18px;
        right: 18px;
    }

    .whatsapp-icon-wrap{
        width: 58px;
        height: 58px;
        font-size: 28px;
    }

    .whatsapp-tooltip{
        display: none;
    }
}
</style>
<a href="https://wa.me/923079683868?text=Hi,%20I%20want%20to%20learn%20Quran" 
       class="whatsapp-float" 
       target="_blank">
        
        <div class="whatsapp-tooltip">
            Hi, I want to learn Quran
        </div>

        <div class="whatsapp-icon-wrap">
            <i class="fab fa-whatsapp"></i>
        </div>
    </a>

    <footer class="bg-gray-900 text-white py-6 text-center">
        <p>&copy; 2026 Al-Quran Academy. All rights reserved.</p>
    </footer>

</body>
</html>
</body>
</html>