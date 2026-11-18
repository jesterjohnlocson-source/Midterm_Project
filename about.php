<?php
require __DIR__ . '/core/public.php';
$education = rows($db, 'education');
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?= h($settings['theme']) ?>" data-accent="<?= h($settings['accent']) ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= h($settings['site_title']) ?> | About</title>
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
        <li><a href="about.php" class="active">About</a></li>
        <li><a href="skill.php">Skills</a></li>
        <li><a href="projects.php">Projects</a></li>
        <li><a href="resume.php">Resume</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><button id="themeToggle" class="theme-btn"><i class="fas fa-moon"></i></button></li>
      </ul>
    </nav>
  </header>

  <main class="container">
    <h1 class="page-title">About Me</h1>
    <div class="grid-2">
      <div class="card">
        <h3><i class="fas fa-user"></i> Background</h3>
        <p><?= h($profile['bio']) ?></p>
        <p><?= h($profile['age_note']) ?><br><?= h($profile['location']) ?><br><?= h($profile['email']) ?></p>
      </div>
      <div class="card">
        <h3><i class="fas fa-graduation-cap"></i> Education</h3>
        <?php foreach ($education as $item): ?>
        <p><strong><?= h($item['title']) ?></strong> · <?= h($item['period']) ?><?php if ($item['organization']): ?> — <?= h($item['organization']) ?><?php endif; ?></p>
        <?php endforeach; ?>
        <p><?= h($profile['study_note']) ?></p>
      </div>
      <div class="card">
        <h3><i class="fas fa-bullseye"></i> Goals</h3>
        <p><?= h($profile['goals']) ?></p>
      </div>
      <div class="card">
        <h3><i class="fas fa-heart"></i> Interests</h3>
        <p><?= h($profile['interests']) ?></p>
      </div>
    </div>
  </main>

  <footer>
    <div class="social-links">
      <a href="<?= h(socialUrl($profile['instagram'])) ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
      <a href="<?= h(socialUrl($profile['facebook'])) ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f"></i></a>
      <a href="mailto:<?= h($profile['email']) ?>" target="_blank" rel="noopener noreferrer"><i class="fas fa-envelope"></i></a>
    </div>
    <p>© <?= date('Y') ?> <?= h($profile['full_name']) ?>. All rights reserved. <a href="admin/login.php">Admin</a></p>
  </footer>

  <button id="scrollTop" class="scroll-top"><i class="fas fa-arrow-up"></i></button>
  <script src="script.js"></script>
</body>
</html>
