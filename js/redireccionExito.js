// Cuenta regresiva para redirección con confeti
document.addEventListener('DOMContentLoaded', function() {
    let seconds = 10;
    const countdownElement = document.getElementById('countdown');
    
    const countdownInterval = setInterval(function() {
        seconds--;
        countdownElement.textContent = seconds;
        
        if (seconds <= 0) {
            clearInterval(countdownInterval);
            window.location.href = 'index.php';
        }
    }, 1000);
});