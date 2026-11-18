/* ============================================================
   PORTFOLIO WEBSITE — MAIN JAVASCRIPT
   Features:
   1. Mobile Navigation Toggle
   2. Contact Form Validation
   3. Dark/Light Mode with LocalStorage
   4. Project Filtering
   5. Scroll-to-Top Button
   6. Typing Effect (Home page)
   7. Skill Bar Animation
   8. Accordion (Resume page)
   9. Active Nav Link (based on current file)
   ============================================================ */

document.addEventListener('DOMContentLoaded', () => {

  /* ============================================================
     FEATURE 1: MOBILE NAVIGATION TOGGLE
     ============================================================ */
  const menuToggle = document.getElementById('menuToggle');
  const navLinks = document.getElementById('navLinks');

  if (menuToggle && navLinks) {
    menuToggle.addEventListener('click', () => {
      navLinks.classList.toggle('open');
      // Toggle icon between bars and X
      const icon = menuToggle.querySelector('i');
      if (icon) {
        icon.classList.toggle('fa-bars');
        icon.classList.toggle('fa-times');
      }
    });

    // Close menu when a link is clicked (mobile)
    navLinks.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        navLinks.classList.remove('open');
        const icon = menuToggle.querySelector('i');
        if (icon) {
          icon.classList.add('fa-bars');
          icon.classList.remove('fa-times');
        }
      });
    });
  }

  /* ============================================================
     FEATURE 2: DARK / LIGHT MODE WITH LOCALSTORAGE
     ============================================================ */
  const themeToggle = document.getElementById('themeToggle');
  const root = document.documentElement;

  // Load saved theme
  const savedTheme = localStorage.getItem('theme') || 'light';
  root.setAttribute('data-theme', savedTheme);
  updateThemeIcon(savedTheme);

  if (themeToggle) {
    themeToggle.addEventListener('click', () => {
      const current = root.getAttribute('data-theme');
      const newTheme = current === 'dark' ? 'light' : 'dark';
      root.setAttribute('data-theme', newTheme);
      localStorage.setItem('theme', newTheme);
      updateThemeIcon(newTheme);
    });
  }

  function updateThemeIcon(theme) {
    if (!themeToggle) return;
    const icon = themeToggle.querySelector('i');
    if (icon) {
      icon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
    }
  }

  /* ============================================================
     FEATURE 3: ACTIVE NAV LINK (highlight current page)
     ============================================================ */
  const currentPage = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.nav-links a').forEach(link => {
    const href = link.getAttribute('href');
    if (href === currentPage) {
      link.classList.add('active');
    } else {
      link.classList.remove('active');
    }
  });

  /* ============================================================
     FEATURE 4: TYPING EFFECT (Home page)
     ============================================================ */
  const typingEl = document.getElementById('typing');
  if (typingEl) {
    const phrases = [
      'Full-Stack Developer',
      'UI/UX Enthusiast',
      'Problem Solver',
      'Lifelong Learner'
    ];
    let phraseIndex = 0;
    let charIndex = 0;
    let isDeleting = false;

    function type() {
      const current = phrases[phraseIndex];
      if (isDeleting) {
        typingEl.textContent = current.substring(0, charIndex--);
      } else {
        typingEl.textContent = current.substring(0, charIndex++);
      }

      let speed = isDeleting ? 60 : 120;

      if (!isDeleting && charIndex === current.length + 1) {
        speed = 1500;
        isDeleting = true;
      } else if (isDeleting && charIndex === 0) {
        isDeleting = false;
        phraseIndex = (phraseIndex + 1) % phrases.length;
        speed = 400;
      }

      setTimeout(type, speed);
    }
    type();
  }

  /* ============================================================
     FEATURE 5: SKILL BAR ANIMATION (Skills page)
     ============================================================ */
  const skillItems = document.querySelectorAll('.skill-item');
  if (skillItems.length > 0) {
    // Animate on page load with slight delay per item
    skillItems.forEach((item, index) => {
      const level = item.getAttribute('data-level');
      const progress = item.querySelector('.skill-progress');
      if (progress && level) {
        setTimeout(() => {
          progress.style.width = level + '%';
        }, 150 * index);
      }
    });
  }

  /* ============================================================
     FEATURE 6: PROJECT FILTERING (Projects page)
     ============================================================ */
  const filterButtons = document.querySelectorAll('.filter-btn');
  const projectCards = document.querySelectorAll('.project-card');

  if (filterButtons.length > 0 && projectCards.length > 0) {
    filterButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        // Update active button
        filterButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const filter = btn.getAttribute('data-filter');

        projectCards.forEach(card => {
          const category = card.getAttribute('data-category');
          if (filter === 'all' || category === filter) {
            card.classList.remove('hidden');
            // Simple fade-in
            card.style.opacity = '0';
            setTimeout(() => { card.style.opacity = '1'; }, 50);
          } else {
            card.classList.add('hidden');
          }
        });
      });
    });
  }

  /* ============================================================
     FEATURE 7: SCROLL-TO-TOP BUTTON
     ============================================================ */
  const scrollTopBtn = document.getElementById('scrollTop');

  if (scrollTopBtn) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 300) {
        scrollTopBtn.classList.add('show');
      } else {
        scrollTopBtn.classList.remove('show');
      }
    });

    scrollTopBtn.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  /* ============================================================
     FEATURE 8: ACCORDION (Resume page)
     ============================================================ */
  const accordionHeaders = document.querySelectorAll('.accordion-header');

  accordionHeaders.forEach(header => {
    header.addEventListener('click', () => {
      const item = header.parentElement;
      const isActive = item.classList.contains('active');

      // Close all other items (single-open accordion)
      document.querySelectorAll('.accordion-item').forEach(i => {
        i.classList.remove('active');
      });

      // Toggle current
      if (!isActive) {
        item.classList.add('active');
      }
    });
  });

  // Open first accordion item by default on Resume page
  const firstAccordion = document.querySelector('.accordion-item');
  if (firstAccordion) {
    firstAccordion.classList.add('active');
  }

  /* ============================================================
     FEATURE 9: CONTACT FORM VALIDATION (Contact page)
     ============================================================ */
  const contactForm = document.getElementById('contactForm');

  if (contactForm) {
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const messageInput = document.getElementById('message');

    const nameError = document.getElementById('nameError');
    const emailError = document.getElementById('emailError');
    const messageError = document.getElementById('messageError');
    const successMsg = document.getElementById('formSuccess');

    // Real-time validation on input (clears error when valid)
    nameInput.addEventListener('input', () => validateName());
    emailInput.addEventListener('input', () => validateEmail());
    messageInput.addEventListener('input', () => validateMessage());

    function validateName() {
      const value = nameInput.value.trim();
      if (value === '') {
        nameError.textContent = 'Name is required.';
        nameInput.classList.add('invalid');
        return false;
      } else if (value.length < 2) {
        nameError.textContent = 'Name must be at least 2 characters.';
        nameInput.classList.add('invalid');
        return false;
      } else {
        nameError.textContent = '';
        nameInput.classList.remove('invalid');
        return true;
      }
    }

    function validateEmail() {
      const value = emailInput.value.trim();
      const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (value === '') {
        emailError.textContent = 'Email is required.';
        emailInput.classList.add('invalid');
        return false;
      } else if (!pattern.test(value)) {
        emailError.textContent = 'Please enter a valid email address.';
        emailInput.classList.add('invalid');
        return false;
      } else {
        emailError.textContent = '';
        emailInput.classList.remove('invalid');
        return true;
      }
    }

    function validateMessage() {
      const value = messageInput.value.trim();
      if (value === '') {
        messageError.textContent = 'Message is required.';
        messageInput.classList.add('invalid');
        return false;
      } else if (value.length < 10) {
        messageError.textContent = 'Message must be at least 10 characters.';
        messageInput.classList.add('invalid');
        return false;
      } else {
        messageError.textContent = '';
        messageInput.classList.remove('invalid');
        return true;
      }
    }

    contactForm.addEventListener('submit', (e) => {
      e.preventDefault();
      successMsg.textContent = '';

      const isNameValid = validateName();
      const isEmailValid = validateEmail();
      const isMessageValid = validateMessage();

      if (isNameValid && isEmailValid && isMessageValid) {
        successMsg.textContent = '✓ Message sent successfully! I will get back to you soon.';
        contactForm.reset();

        setTimeout(() => {
          successMsg.textContent = '';
        }, 5000);
      }
    });
  }

  /* ============================================================
     BONUS: FADE-IN ANIMATION ON SCROLL
     ============================================================ */
  const fadeElements = document.querySelectorAll('.card, .project-card, .skill-item');
  if (fadeElements.length > 0) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'translateY(0)';
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    fadeElements.forEach(el => {
      el.style.opacity = '0';
      el.style.transform = 'translateY(20px)';
      el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
      observer.observe(el);
    });
  }

});