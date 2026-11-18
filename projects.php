<?php
require __DIR__ . '/core/public.php';
$projects = rows($db, 'projects');
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?= h($settings['theme']) ?>" data-accent="<?= h($settings['accent']) ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= h($settings['site_title']) ?> | Projects</title>
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
        <li><a href="projects.php" class="active">Projects</a></li>
        <li><a href="resume.php">Resume</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><button id="themeToggle" class="theme-btn"><i class="fas fa-moon"></i></button></li>
      </ul>
    </nav>
  </header>

  <main class="container">
    <h1 class="page-title">My Projects</h1>
    
    
    <div class="filter-buttons">
      <button class="filter-btn active" data-filter="all">All</button>
      <?php foreach (array_unique(array_column($projects, 'category')) as $category): ?>
        <button class="filter-btn" data-filter="<?= h($category) ?>"><?= h(ucfirst($category)) ?></button>
      <?php endforeach; ?>
    </div>
    <div class="grid-2" id="projectsGrid">
      <?php foreach ($projects as $project): ?>
      <div class="project-card" data-category="<?= h($project['category']) ?>">
        <?php if ($project['image']): ?><img src="<?= h(imageUrl($project['image'])) ?>" alt="<?= h($project['title']) ?>"><?php endif; ?>
        <div class="project-content">
          <h3><?= h($project['title']) ?></h3>
          <p><?= h($project['description']) ?></p>
          <div class="tech-tags">
            <?php foreach (array_filter(array_map('trim', explode(',', $project['technologies']))) as $tag): ?>
              <span><?= h($tag) ?></span>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
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
