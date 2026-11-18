SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS `profile` (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `full_name` VARCHAR(500) NOT NULL,
  `display_name` VARCHAR(500) NOT NULL,
  `intro` TEXT NOT NULL,
  `bio` TEXT NOT NULL,
  `age_note` VARCHAR(500) NOT NULL,
  `location` VARCHAR(500) NOT NULL,
  `email` VARCHAR(500) NOT NULL,
  `phone` VARCHAR(500) NOT NULL,
  `goals` TEXT NOT NULL,
  `interests` TEXT NOT NULL,
  `study_note` VARCHAR(500) NOT NULL,
  `roles` VARCHAR(500) NOT NULL,
  `facebook` VARCHAR(500) NOT NULL,
  `instagram` VARCHAR(500) NOT NULL,
  `photo` VARCHAR(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `profile` (`id`, `full_name`, `display_name`, `intro`, `bio`, `age_note`, `location`, `email`, `phone`, `goals`, `interests`, `study_note`, `roles`, `facebook`, `instagram`, `photo`) VALUES
(1, 'Jester John Sivila', 'Jester John', 'I build modern, responsive web applications with clean code and thoughtful design.', 'I''m Jester John, born and raised in Makati. I love going to new places, exploring different experiences, and learning new things every day. I enjoy gaming, sports, and reading manga and manhwa.', '20 yrs old', 'Caranoche, Santa Catalina', 'jesterjohnlocson@gmail.com', '', 'To build impactful digital products, contribute to open-source projects, and mentor aspiring developers.', 'Photography · Music · Hiking · Coffee · Gaming · Sleeping · Playing Pickleball · Reading Manga & Manhwa', 'Currently exploring Web Development & Design', 'IT Student, Web Development Learner, Problem Solver, Lifelong Learner', 'https://facebook.com', 'https://instagram.com', 'images/image.jpg');

CREATE TABLE IF NOT EXISTS `settings` (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `site_title` VARCHAR(500) NOT NULL,
  `logo_text` VARCHAR(500) NOT NULL,
  `logo_accent` VARCHAR(500) NOT NULL,
  `logo_image` VARCHAR(500) NOT NULL,
  `accent` VARCHAR(500) NOT NULL,
  `theme` VARCHAR(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `settings` (`id`, `site_title`, `logo_text`, `logo_accent`, `logo_image`, `accent`, `theme`) VALUES
(1, 'Jester John Sivila', 'Jester', 'Sivila', '', 'blue', 'light');

CREATE TABLE IF NOT EXISTS `skills` (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(500) NOT NULL,
  `category` VARCHAR(500) NOT NULL,
  `level` TINYINT UNSIGNED NOT NULL,
  `icon` VARCHAR(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `skills` (`id`, `title`, `category`, `level`, `icon`) VALUES
(1, 'HTML5', 'Web', 95, 'fab fa-html5'),
(2, 'JavaScript', 'Web', 88, 'fab fa-js'),
(3, 'Git', 'Tools', 90, 'fab fa-git-alt'),
(4, 'Adobe Illustrator', 'Design', 85, 'fas fa-pen-nib');

CREATE TABLE IF NOT EXISTS `projects` (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(500) NOT NULL,
  `category` VARCHAR(500) NOT NULL,
  `description` TEXT NOT NULL,
  `technologies` VARCHAR(500) NOT NULL,
  `image` VARCHAR(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `projects` (`id`, `title`, `category`, `description`, `technologies`, `image`) VALUES
(1, 'ANIMATION', 'animation', 'Motion path animation.', 'Adobe Animate', 'images/project1.png'),
(2, 'WEBSITE', 'web', 'Personal portfolio website.', 'HTML, CSS, JavaScript', 'images/project2.png'),
(3, 'ANIMATION', 'animation', 'Product advertisement animation.', 'Adobe Animate', 'images/project3.png'),
(4, 'ADOBE ILLUSTRATOR', 'design', 'Small network diagram.', 'Adobe Illustrator', 'images/project4.png');

CREATE TABLE IF NOT EXISTS `education` (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(500) NOT NULL,
  `organization` VARCHAR(500) NOT NULL,
  `period` VARCHAR(500) NOT NULL,
  `description` VARCHAR(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `education` (`id`, `title`, `organization`, `period`, `description`) VALUES
(1, 'Bachelor of Science in Information Technology', '', 'Currently Enrolled', ''),
(2, 'Bayawan National High School', '', 'Senior High (HUMMS)', ''),
(3, 'Manabo Pilot Elementary School', '', 'Primary Education', '');

CREATE TABLE IF NOT EXISTS `experience` (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(500) NOT NULL,
  `organization` VARCHAR(500) NOT NULL,
  `period` VARCHAR(500) NOT NULL,
  `description` TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `achievements` (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(500) NOT NULL,
  `organization` VARCHAR(500) NOT NULL,
  `period` VARCHAR(500) NOT NULL,
  `description` VARCHAR(500) NOT NULL,
  `image` VARCHAR(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS admins (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 username VARCHAR(80) NOT NULL UNIQUE,
 password_hash VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS messages (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(120) NOT NULL,
 email VARCHAR(254) NOT NULL,
 subject VARCHAR(200) NOT NULL,
 message TEXT NOT NULL,
 is_read TINYINT(1) NOT NULL DEFAULT 0,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS request_limits (
 bucket CHAR(64) PRIMARY KEY,
 hits INT UNSIGNED NOT NULL,
 expires_at BIGINT UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
