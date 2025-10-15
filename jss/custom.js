// Inicializar tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})

// Inicializar popovers
var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl)
})

// Animación de elementos al hacer scroll
function animateOnScroll() {
  const elements = document.querySelectorAll('.card-hover, .feature-icon');
  
  elements.forEach(element => {
    const position = element.getBoundingClientRect().top;
    const screenPosition = window.innerHeight / 1.3;
    
    if(position < screenPosition) {
      element.style.opacity = 1;
      element.style.transform = 'translateY(0)';
    }
  });
}

// Efecto de escritura para títulos
function typeWriter(element, text, speed = 100) {
  let i = 0;
  element.innerHTML = '';
  
  function type() {
    if (i < text.length) {
      element.innerHTML += text.charAt(i);
      i++;
      setTimeout(type, speed);
    }
  }
  
  type();
}

// Inicializar animaciones
document.addEventListener('DOMContentLoaded', function() {
  const animatedElements = document.querySelectorAll('.card-hover, .feature-icon');
  animatedElements.forEach(element => {
    element.style.opacity = 0;
    element.style.transform = 'translateY(20px)';
    element.style.transition = 'all 0.5s ease';
  });
  
  window.addEventListener('scroll', animateOnScroll);
  // Ejecutar una vez al cargar la página
  animateOnScroll();
  
  // Efecto de escritura para el título principal
  const heroTitle = document.querySelector('.hero-section h1');
  if (heroTitle) {
    const originalText = heroTitle.textContent;
    typeWriter(heroTitle, originalText, 150);
  }
});

// Efecto de confeti para éxito
function launchConfetti() {
  const confettiCount = 200;
  const confettiContainer = document.createElement('div');
  confettiContainer.style.position = 'fixed';
  confettiContainer.style.top = '0';
  confettiContainer.style.left = '0';
  confettiContainer.style.width = '100%';
  confettiContainer.style.height = '100%';
  confettiContainer.style.pointerEvents = 'none';
  confettiContainer.style.zIndex = '9999';
  document.body.appendChild(confettiContainer);
  
  for (let i = 0; i < confettiCount; i++) {
    const confetti = document.createElement('div');
    confetti.style.position = 'absolute';
    confetti.style.width = '10px';
    confetti.style.height = '10px';
    confetti.style.backgroundColor = getRandomColor();
    confetti.style.borderRadius = '50%';
    confetti.style.opacity = '0.8';
    
    const startX = Math.random() * window.innerWidth;
    const startY = -20;
    const angle = (Math.random() * 60) - 30;
    const velocity = (Math.random() * 10) + 5;
    const rotation = (Math.random() * 360);
    
    confetti.style.left = `${startX}px`;
    confetti.style.top = `${startY}px`;
    confetti.style.transform = `rotate(${rotation}deg)`;
    
    confettiContainer.appendChild(confetti);
    
    // Animación
    const animation = confetti.animate([
      { transform: `translate(0, 0) rotate(0deg)`, opacity: 1 },
      { transform: `translate(${angle}px, ${window.innerHeight}px) rotate(720deg)`, opacity: 0 }
    ], {
      duration: (Math.random() * 3000) + 3000,
      easing: 'cubic-bezier(0.1, 0.8, 0.3, 1)'
    });
    
    animation.onfinish = () => {
      confetti.remove();
      if (confettiContainer.children.length === 0) {
        confettiContainer.remove();
      }
    };
  }
}

function getRandomColor() {
  const colors = [
    '#4776E6', '#8E54E9', '#1ce0a8', '#ffcc00', '#ff3c5f', 
    '#36b9cc', '#ffffff'
  ];
  return colors[Math.floor(Math.random() * colors.length)];
}

// Lanzar confeti en página de éxito
if (document.querySelector('.alert-success')) {
  setTimeout(launchConfetti, 500);
}