<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Footer</title>
  <link rel="stylesheet" href="CSS/footer.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

  <!-- Footer -->
  <footer class="footer">
    <div class="footer-content">
      <a href="#" class="footer-link"><i class="fas fa-file-contract"></i> Terms of Service</a>
      <a href="#" class="footer-link"><i class="fas fa-shield-alt"></i> Privacy Policy</a>
      <a href="#" class="footer-link"><i class="fas fa-headset"></i> Support</a>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2024 Worker UI. All rights reserved.</p>
    </div>
  </footer>

  <script>
    // Footer scroll effect
    window.addEventListener('scroll', function() {
      const footer = document.querySelector('.footer');
      if (window.scrollY > 50) {
        footer.classList.add('scrolled');
      } else {
        footer.classList.remove('scrolled');
      }
    });

    // Footer fade-in animation on page load
    document.addEventListener('DOMContentLoaded', function() {
      const footer = document.querySelector('.footer');
      footer.classList.add('fade-in');
    });

    // Smooth scroll for footer links
    document.querySelectorAll('.footer-link').forEach(link => {
      link.addEventListener('click', function(e) {
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