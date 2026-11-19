document.addEventListener('DOMContentLoaded', () => {

  
  const menuToggle = document.getElementById('menuToggle');
  const navLinks = document.getElementById('navLinks');

  if (menuToggle && navLinks) {
    menuToggle.addEventListener('click', () => {
      navLinks.classList.toggle('open');

      const icon = menuToggle.querySelector('i');
      if (icon) {
        icon.classList.toggle('fa-bars');
        icon.classList.toggle('fa-times');
      }
    });

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

  
  const themeToggle = document.getElementById('themeToggle');
  const root = document.documentElement;

  const savedTheme = localStorage.getItem('jester-theme') || root.getAttribute('data-theme') || 'light';
  root.setAttribute('data-theme', savedTheme);
  updateThemeIcon(savedTheme);

  if (themeToggle) {
    themeToggle.addEventListener('click', () => {
      const current = root.getAttribute('data-theme');
      const newTheme = current === 'dark' ? 'light' : 'dark';
      root.setAttribute('data-theme', newTheme);
      localStorage.setItem('jester-theme', newTheme);
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

  
  const currentPage = window.location.pathname.split('/').pop() || 'index.php';
  document.querySelectorAll('.nav-links a').forEach(link => {
    const href = link.getAttribute('href');
    if (href === currentPage) {
      link.classList.add('active');
    } else {
      link.classList.remove('active');
    }
  });

  
  const typingEl = document.getElementById('typing');
  if (typingEl) {
    const phrases = (typingEl.dataset.phrases || 'IT Student').split(',').map(x => x.trim()).filter(Boolean);
    if (!phrases.length) phrases.push('IT Student');
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

  
  const skillItems = document.querySelectorAll('.skill-item');
  if (skillItems.length > 0) {

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

  
  const filterButtons = document.querySelectorAll('.filter-btn');
  const projectCards = document.querySelectorAll('.project-card');

  if (filterButtons.length > 0 && projectCards.length > 0) {
    filterButtons.forEach(btn => {
      btn.addEventListener('click', () => {

        filterButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const filter = btn.getAttribute('data-filter');

        projectCards.forEach(card => {
          const category = card.getAttribute('data-category');
          if (filter === 'all' || category === filter) {
            card.classList.remove('hidden');

            card.style.opacity = '0';
            setTimeout(() => { card.style.opacity = '1'; }, 50);
          } else {
            card.classList.add('hidden');
          }
        });
      });
    });
  }

  
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

  
  const accordionHeaders = document.querySelectorAll('.accordion-header');

  accordionHeaders.forEach(header => {
    header.addEventListener('click', () => {
      const item = header.parentElement;
      const isActive = item.classList.contains('active');

      document.querySelectorAll('.accordion-item').forEach(i => {
        i.classList.remove('active');
      });

      if (!isActive) {
        item.classList.add('active');
      }
    });
  });

  const firstAccordion = document.querySelector('.accordion-item');
  if (firstAccordion) {
    firstAccordion.classList.add('active');
  }

  
  const contactForm = document.getElementById('contactForm');

  if (contactForm) {
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const messageInput = document.getElementById('message');

    const nameError = document.getElementById('nameError');
    const emailError = document.getElementById('emailError');
    const messageError = document.getElementById('messageError');

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
      const validName = validateName();
      const validEmail = validateEmail();
      const validMessage = validateMessage();
      const subject = document.getElementById('subject');
      if (!validName || !validEmail || !validMessage || (subject && !subject.value.trim())) {
        e.preventDefault();
      }
      if (subject && !subject.value.trim()) subject.focus();
    });
  }

  
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
