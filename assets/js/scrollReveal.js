import ScrollReveal from "scrollreveal";

// Initialisation globale
ScrollReveal({
  reset: true,
  distance: '60px',
  duration: 1200,
  delay: 200,
  easing: 'ease-in-out',
  interval: 150,
});

// Exemple d’animations
ScrollReveal().reveal('.reveal-top', { origin: 'top' });
ScrollReveal().reveal('.reveal-bottom', { origin: 'bottom' });
ScrollReveal().reveal('.reveal-left', { origin: 'left' });
ScrollReveal().reveal('.reveal-right', { origin: 'right' });