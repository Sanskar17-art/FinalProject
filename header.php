<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Worker UI</title>
  <link rel="stylesheet" href="CSS/header.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<header class="header">
  <div class="logo">Worker UI</div>
  <nav class="nav">
    <a href="Worker_Home.php" class="nav-link"><i class="fas fa-home"></i> Home</a>
    <a href="Worker_Tasks.php" class="nav-link"><i class="fas fa-tasks"></i> Tasks</a>
    <a href="Worker_Ratings.php" class="nav-link"><i class="fas fa-star"></i> Ratings</a>
    <a href="Worker_Report.php" class="nav-link"><i class="fas fa-chart-bar"></i> Report</a>
    <a href="Backend/logout.php" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
      <i class="fas fa-sign-out-alt"></i> Logout
    </a>
  </nav>
  <div class="profile">
    <a href="Worker_ProfileUp.php">
      <img src="https://tse2.mm.bing.net/th?id=OIP.zM7ArKyeNVAiOeTyujsvWwHaHa&pid=Api&P=0&h=180" alt="User">
    </a>
  </div>
  <div class="mobile-menu-btn">
    <i class="fas fa-bars"></i>
  </div>
</header>

<!-- Hidden logout form -->
<form id="logout-form" action="Backend/logout.php" method="POST" style="display: none;">
  <input type="hidden" name="logout" value="1">
</form>

<script>
  // Header scroll effect
  window.addEventListener('scroll', function() {
    const header = document.querySelector('.header');
    if (window.scrollY > 50) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  });

  // Mobile menu toggle
  const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
  const nav = document.querySelector('.nav');
  
  mobileMenuBtn.addEventListener('click', function() {
    nav.classList.toggle('active');
    this.querySelector('i').classList.toggle('fa-bars');
    this.querySelector('i').classList.toggle('fa-times');
  });

  // Close mobile menu when clicking outside
  document.addEventListener('click', function(e) {
    if (!nav.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
      nav.classList.remove('active');
      mobileMenuBtn.querySelector('i').classList.remove('fa-times');
      mobileMenuBtn.querySelector('i').classList.add('fa-bars');
    }
  });

  // Add active class to current page link
  const currentPath = window.location.pathname;
  document.querySelectorAll('.nav-link').forEach(link => {
    if (link.getAttribute('href') === currentPath.split('/').pop()) {
      link.classList.add('active');
    }
  });

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });
</script>

</body>
</html>