// Crear efecto de partículas flotantes
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('particles-container');
    const particleCount = 30;
    
    for (let i = 0; i < particleCount; i++) {
        createParticle(container);
    }
    
    function createParticle(container) {
        const particle = document.createElement('div');
        particle.classList.add('particle');
        
        // Tamaño aleatorio
        const size = Math.random() * 15 + 5;
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        
        // Posición aleatoria
        const posX = Math.random() * 100;
        particle.style.left = `${posX}%`;
        
        // Opacidad aleatoria
        const opacity = Math.random() * 0.5 + 0.1;
        particle.style.opacity = opacity;
        
        // Duración de animación aleatoria
        const duration = Math.random() * 20 + 10;
        particle.style.animationDuration = `${duration}s`;
        
        // Retraso aleatorio
        const delay = Math.random() * 10;
        particle.style.animationDelay = `${delay}s`;
        
        container.appendChild(particle);
    }
});