<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us - Your Company</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }

    .brand-logo {
      height: 40px;
    }

    .map-container iframe {
      width: 100%;
      border: 0;
      border-radius: 10px;
    }

    .contact-card {
      background: #ffffff;
      border-radius: 15px;
      padding: 2rem;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    footer {
      background: #222;
      color: #ccc;
      padding: 2rem 0;
    }

    footer a {
      color: #bbb;
      text-decoration: none;
    }

    footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<!-- Header -->
<nav class="navbar navbar-light bg-light px-3">
  <a class="navbar-brand d-flex align-items-center" href="#">
    <img src="asset/img/logo.PNG" alt="Company Logo" class="brand-logo me-2" />
    <strong>Task Manager</strong>
  </a>
</nav>

<!-- Contact Section -->
<div class="container mt-5">
  <h2 class="mb-5 text-center fw-bold" data-aos="fade-down">Get in Touch</h2>
  <div class="row g-4 justify-content-center">
    
    <!-- Map Column -->
    <div class="col-md-6" data-aos="fade-right">
      <div class="contact-card map-container">
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.0893203609736!2d-122.41941568468143!3d37.77492927975913!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085808e001c7193%3A0x4f1b0bcd2f858aa0!2s123%20Business%20Street%2C%20San%20Francisco%2C%20CA!5e0!3m2!1sen!2sus!4v1623333707880!5m2!1sen!2sus"
          height="350"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    </div>

    <!-- Info Column -->
    <div class="col-md-6" data-aos="fade-left">
      <div class="contact-card bg-white">
        <h5 class="fw-bold mb-3">Need Help?</h5>
        <p class="mb-3">Our team is available 24/7. You can also reach out via email or live chat.</p>
        <ul class="list-unstyled mb-0">
          <li><strong>📞 Phone:</strong> +1 234 567 890</li>
          <li><strong>✉️ Email:</strong> support@yourcompany.com</li>
          <li><strong>📍 Address:</strong> 123 Business Street, City, Country</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="mt-5">
  <div class="container">
    <div class="row text-center text-md-start">
      <div class="col-md-4 mb-3">
        <h6>Your Company</h6>
        <p>Delivering quality solutions with support you can trust.</p>
      </div>
      <div class="col-md-4 mb-3">
        <h6>Help</h6>
        <ul class="list-unstyled">
          <li><a href="#">Support Center</a></li>
          <li><a href="#">FAQs</a></li>
          <li><a href="#">Contact Support</a></li>
        </ul>
      </div>
      <div class="col-md-4 mb-3">
        <h6>Legal</h6>
        <ul class="list-unstyled">
          <li><a href="#">Terms & Conditions</a></li>
          <li><a href="#">Privacy Policy</a></li>
        </ul>
      </div>
    </div>
    <hr class="text-light" />
    <div class="text-center small">
      © 2025 Your Company. All rights reserved.
    </div>
  </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 1000,
    once: true
  });
</script>

</body>
</html>
