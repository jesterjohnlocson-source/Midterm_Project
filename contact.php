<?php
require __DIR__ . '/core/public.php';
require __DIR__ . '/core/contact_submit.php';
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?= h($settings['theme']) ?>" data-accent="<?= h($settings['accent']) ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= h($settings['site_title']) ?> | Contact</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
  <header>
    <nav class="navbar">
      <a href="index.php" class="logo"><?php if ($settings['logo_image']): ?><img class="site-logo" src="<?= h(imageUrl($settings['logo_image'])) ?>" alt=""><?php endif; ?><?= h($settings['logo_text']) ?><span><?= h($settings['logo_accent']) ?></span></a>
      <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
      <ul class="nav-links" id="navLinks">
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="skill.php">Skills</a></li>
        <li><a href="projects.php">Projects</a></li>
        <li><a href="resume.php">Resume</a></li>
        <li><a href="contact.php" class="active">Contact</a></li>
        <li><a href="admin/login.php">Portfolio Studio</a></li>
        <li><button id="themeToggle" class="theme-btn"><i class="fas fa-moon"></i></button></li>
      </ul>
    </nav>
  </header>

  <main class="container">
    <h1 class="page-title">Get In Touch</h1>
    <div class="grid-2">
      <div class="card">
        <h3><i class="fas fa-paper-plane"></i> Send a Message</h3>
        <form id="contactForm" class="contact-form" method="post" action="contact.php" novalidate>
          <?= csrfInput() ?>
          <div class="trap" aria-hidden="true"><label>Leave blank <input name="website" tabindex="-1" autocomplete="off"></label></div>
          <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" maxlength="120" required value="<?= h($name) ?>" placeholder="Your name">
            <div class="error" id="nameError"></div>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" maxlength="254" required value="<?= h($email) ?>" placeholder="you@example.com">
            <div class="error" id="emailError"></div>
          </div>
          <div class="form-group"><label for="subject">Subject</label><input id="subject" name="subject" maxlength="200" required value="<?= h($subject) ?>" placeholder="Subject"></div>
          <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" required maxlength="5000" rows="5" placeholder="Your message..."><?= h($message) ?></textarea>
            <div class="error" id="messageError"></div>
          </div>
          <button type="submit" class="btn">Send Message</button>
          <p id="formSuccess" class="<?= $error ? 'error' : 'success' ?>" role="status"><?= h($error ?: $notice) ?></p>
        </form>
      </div>

      <div class="card">
        <h3><i class="fas fa-address-card"></i> Contact Info</h3>
        <p><i class="fas fa-envelope"></i> <?= h($profile['email']) ?></p>
        <?php if ($profile['phone']): ?><p><i class="fas fa-phone"></i> <?= h($profile['phone']) ?></p><?php endif; ?>
        <p><i class="fas fa-map-marker-alt"></i> <?= h($profile['location']) ?></p>
        <div class="social-links" style="justify-content:flex-start; margin-top:1.5rem;">
          <a href="<?= h(socialUrl($profile['instagram'])) ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
          <a href="<?= h(socialUrl($profile['facebook'])) ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f"></i></a>
          <a href="mailto:<?= h($profile['email']) ?>" target="_blank" rel="noopener noreferrer"><i class="fas fa-envelope"></i></a>
        </div>
      </div>
    </div>
  </main>

  <footer>
    <div class="social-links">
      <a href="<?= h(socialUrl($profile['instagram'])) ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
      <a href="<?= h(socialUrl($profile['facebook'])) ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f"></i></a>
      <a href="mailto:<?= h($profile['email']) ?>" target="_blank" rel="noopener noreferrer"><i class="fas fa-envelope"></i></a>
    </div>
    <p>© <?= date('Y') ?> <?= h($profile['full_name']) ?>. All rights reserved.</p>
  </footer>

  <button id="scrollTop" class="scroll-top"><i class="fas fa-arrow-up"></i></button>
  <script src="script.js"></script>
</body>
</html>
