// Custom Cursor Animation
const circles = document.querySelectorAll('.circle');
let mouseX = 0, mouseY = 0;
let currentX = 0, currentY = 0;
const speed = 0.2;

document.addEventListener('mousemove', e => {
  mouseX = e.clientX;
  mouseY = e.clientY;
});

function animateCursor() {
  currentX += (mouseX - currentX) * speed;
  currentY += (mouseY - currentY) * speed;
  circles.forEach((circle, i) => {
    const delay = i * 2;
    circle.style.left = currentX + 'px';
    circle.style.top = currentY + 'px';
    circle.style.opacity = 1 - i * 0.05;
    circle.style.transform = `translate(-50%, -50%) scale(${1 - i * 0.03})`;
  });
  requestAnimationFrame(animateCursor);
}
animateCursor();

document.addEventListener('mousedown', () => {
  circles.forEach(c => c.classList.add('active'));
});
document.addEventListener('mouseup', () => {
  circles.forEach(c => c.classList.remove('active'));
}); 