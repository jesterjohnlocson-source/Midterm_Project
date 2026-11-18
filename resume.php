<?php
require __DIR__ . '/core/public.php';
$sections = ['experience' => ['Work Experience', 'fa-briefcase'], 'education' => ['Education', 'fa-graduation-cap'], 'achievements' => ['Certifications', 'fa-certificate']];
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?= h($settings['theme']) ?>" data-accent="<?= h($settings['accent']) ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= h($settings['site_title']) ?> | Resume</title>
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
        <li><a href="resume.php" class="active">Resume</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><button id="themeToggle" class="theme-btn"><i class="fas fa-moon"></i></button></li>
      </ul>
    </nav>
  </header>

  <main class="container">
    <h1 class="page-title">Resume & Experience</h1>
    
    <div class="card">
      
      <div class="accordion">
        <?php foreach ($sections as $table => $section): ?>
        <div class="accordion-item">
          <button class="accordion-header"><i class="fas <?= h($section[1]) ?>"></i> <?= h($section[0]) ?><i class="fas fa-chevron-down arrow"></i></button>
          <div class="accordion-content">
            <?php $items = rows($db, $table); if (!$items): ?><p>No records yet.</p><?php endif; ?>
            <?php foreach ($items as $item): ?>
              <div class="timeline-item">
                <h3><?= h($item['title']) ?></h3>
                <p class="company"><?= h(trim($item['organization'] . ' ' . $item['period'])) ?></p>
                <p><?= h($item['description']) ?></p>
                <?php if (!empty($item['image'])): ?><img class="certificate-image" src="<?= h(imageUrl($item['image'])) ?>" alt="<?= h($item['title']) ?>"><?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endforeach; ?>
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
