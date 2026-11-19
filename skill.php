<?php
require __DIR__ . '/core/public.php';
$skills = rows($db, 'skills');
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?= h($settings['theme']) ?>" data-accent="<?= h($settings['accent']) ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= h($settings['site_title']) ?> | Skills</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  <style>
    .skill-item {
      animation: skillFadeIn 0.6s ease both;
    }

    .skill-item:nth-child(2) { animation-delay: 0.1s; }
    .skill-item:nth-child(3) { animation-delay: 0.2s; }
    .skill-item:nth-child(4) { animation-delay: 0.3s; }

    @keyframes skillFadeIn {
      from {
        opacity: 0;
        transform: translateY(16px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @media (prefers-reduced-motion: reduce) {
      .skill-item {
        animation: none;
      }
    }
  </style>
</head>
<body>
  <header>
    <nav class="navbar">
      <a href="index.php" class="logo"><?php if ($settings['logo_image']): ?><img class="site-logo" src="<?= h(imageUrl($settings['logo_image'])) ?>" alt=""><?php endif; ?><?= h($settings['logo_text']) ?><span><?= h($settings['logo_accent']) ?></span></a>
      <button class="menu-toggle" id="menuToggle" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>

      <ul class="nav-links" id="navLinks">
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="skill.php" class="active">Skills</a></li>
        <li><a href="projects.php">Projects</a></li>
        <li><a href="resume.php">Resume</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li>
          <button id="themeToggle" class="theme-btn" aria-label="Toggle theme">
            <i class="fas fa-moon"></i>
          </button>
        </li>
      </ul>
    </nav>
  </header>

  <main class="container">
    <h1 class="page-title">My Skills</h1>

    <div class="grid-4">
      <?php foreach ($skills as $skill): ?>
      <div class="skill-item" data-level="<?= (int)$skill['level'] ?>">
        <i class="<?= h($skill['icon']) ?>"></i>
        <h4><?= h($skill['title']) ?></h4>
        <p><?= h($skill['category']) ?> · <?= (int)$skill['level'] ?>%</p>
        <div class="skill-bar"><div class="skill-progress"></div></div>
      </div>
      <?php endforeach; ?>
    </div>
    </main>

  <footer>
    <div class="social-links">
      <a href="<?= h(socialUrl($profile['instagram'])) ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
        <i class="fab fa-instagram"></i>
      </a>
      <a href="<?= h(socialUrl($profile['facebook'])) ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
        <i class="fab fa-facebook-f"></i>
      </a>
      <a href="mailto:<?= h($profile['email']) ?>" aria-label="Email">
        <i class="fas fa-envelope"></i>
      </a>
    </div>
    <p>© <?= date('Y') ?> <?= h($profile['full_name']) ?>. All rights reserved. <a href="admin/login.php">Admin</a></p>
  </footer>

  <button id="scrollTop" class="scroll-top" aria-label="Scroll to top">
    <i class="fas fa-arrow-up"></i>
  </button>

  <script src="script.js"></script>
</body>
</html>
