// Particles.js Configuration
particlesJS('particles-js', {
    particles: {
        number: {
            value: 80,
            density: {
                enable: true,
                value_area: 800
            }
        },
        color: {
            value: ['#00ffff', '#0066ff', '#00ccff']
        },
        shape: {
            type: 'circle',
            stroke: {
                width: 0,
                color: '#000000'
            }
        },
        opacity: {
            value: 0.5,
            random: true,
            anim: {
                enable: true,
                speed: 1,
                opacity_min: 0.1,
                sync: false
            }
        },
        size: {
            value: 3,
            random: true,
            anim: {
                enable: true,
                speed: 2,
                size_min: 0.1,
                sync: false
            }
        },
        line_linked: {
            enable: true,
            distance: 150,
            color: '#00ffff',
            opacity: 0.2,
            width: 1
        },
        move: {
            enable: true,
            speed: 2,
            direction: 'none',
            random: false,
            straight: false,
            out_mode: 'out',
            bounce: false,
            attract: {
                enable: true,
                rotateX: 600,
                rotateY: 1200
            }
        }
    },
    interactivity: {
        detect_on: 'canvas',
        events: {
            onhover: {
                enable: true,
                mode: 'grab'
            },
            onclick: {
                enable: true,
                mode: 'push'
            },
            resize: true
        },
        modes: {
            grab: {
                distance: 140,
                line_linked: {
                    opacity: 0.5
                }
            },
            push: {
                particles_nb: 4
            }
        }
    },
    retina_detect: true
});

// Form Animation
const loginForm = document.getElementById('loginForm');
const inputs = document.querySelectorAll('.input-wrapper input');

// Add focus/blur animations
inputs.forEach(input => {
    input.addEventListener('focus', function() {
        this.parentElement.classList.add('focused');
        
        // Create ripple effect
        const ripple = document.createElement('span');
        ripple.classList.add('input-ripple');
        this.parentElement.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    });
    
    input.addEventListener('blur', function() {
        this.parentElement.classList.remove('focused');
    });
});

// Form submission animation
loginForm.addEventListener('submit', function(e) {
    const btn = this.querySelector('.login-btn');
    btn.style.transform = 'scale(0.95)';
    
    setTimeout(() => {
        btn.style.transform = '';
    }, 200);
});

// Add floating animation to login box on mouse move
document.addEventListener('mousemove', function(e) {
    const loginBox = document.querySelector('.login-box');
    const x = (e.clientX / window.innerWidth - 0.5) * 20;
    const y = (e.clientY / window.innerHeight - 0.5) * 20;
    
    loginBox.style.transform = `perspective(1000px) rotateY(${x}deg) rotateX(${-y}deg)`;
});

// Reset transform when mouse leaves
document.addEventListener('mouseleave', function() {
    const loginBox = document.querySelector('.login-box');
    loginBox.style.transform = '';
});

// Typing effect for subtitle
const subtitle = document.querySelector('.login-subtitle');
if (subtitle) {
    const text = subtitle.textContent;
    subtitle.textContent = '';
    let i = 0;
    
    function typeWriter() {
        if (i < text.length) {
            subtitle.textContent += text.charAt(i);
            i++;
            setTimeout(typeWriter, 50);
        }
    }
    
    setTimeout(typeWriter, 500);
}

// Add glitch effect to title on hover
const title = document.querySelector('.login-title');
if (title) {
    title.addEventListener('mouseenter', function() {
        this.classList.add('glitch');
        setTimeout(() => {
            this.classList.remove('glitch');
        }, 500);
    });
}

// Create matrix rain effect (optional, subtle background)
function createMatrixRain() {
    const canvas = document.createElement('canvas');
    canvas.style.position = 'fixed';
    canvas.style.top = '0';
    canvas.style.left = '0';
    canvas.style.width = '100%';
    canvas.style.height = '100%';
    canvas.style.pointerEvents = 'none';
    canvas.style.opacity = '0.05';
    canvas.style.zIndex = '0';
    document.body.appendChild(canvas);
    
    const ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    
    const matrix = '01';
    const fontSize = 14;
    const columns = canvas.width / fontSize;
    const drops = [];
    
    for (let i = 0; i < columns; i++) {
        drops[i] = 1;
    }
    
    function draw() {
        ctx.fillStyle = 'rgba(10, 14, 39, 0.05)';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        
        ctx.fillStyle = '#00ffff';
        ctx.font = fontSize + 'px monospace';
        
        for (let i = 0; i < drops.length; i++) {
            const text = matrix[Math.floor(Math.random() * matrix.length)];
            ctx.fillText(text, i * fontSize, drops[i] * fontSize);
            
            if (drops[i] * fontSize > canvas.height && Math.random() > 0.975) {
                drops[i] = 0;
            }
            drops[i]++;
        }
    }
    
    setInterval(draw, 50);
}

// Uncomment to enable matrix rain
// createMatrixRain();

// Keyboard shortcut (Enter to submit)
document.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        const activeElement = document.activeElement;
        if (activeElement && activeElement.tagName === 'INPUT') {
            loginForm.dispatchEvent(new Event('submit'));
        }
    }
});

// Add scan line effect
function createScanLine() {
    const scanLine = document.createElement('div');
    scanLine.style.position = 'fixed';
    scanLine.style.top = '0';
    scanLine.style.left = '0';
    scanLine.style.width = '100%';
    scanLine.style.height = '2px';
    scanLine.style.background = 'linear-gradient(90deg, transparent, #00ffff, transparent)';
    scanLine.style.opacity = '0.3';
    scanLine.style.pointerEvents = 'none';
    scanLine.style.zIndex = '9999';
    scanLine.style.animation = 'scanLine 4s linear infinite';
    document.body.appendChild(scanLine);
    
    // Add CSS animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes scanLine {
            0% { top: 0; }
            100% { top: 100%; }
        }
    `;
    document.head.appendChild(style);
}

createScanLine();

console.log('%c🚀 Digital BnB Admin Portal', 'color: #00ffff; font-size: 20px; font-weight: bold;');
console.log('%cSecure Login System Active', 'color: #0066ff; font-size: 14px;');
