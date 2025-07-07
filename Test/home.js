// Navigation and Section Toggling
function setActive(section) {
  const overlay = document.querySelector('.transition-overlay');
  overlay.classList.add('active');
  setTimeout(() => {
    // Hide all sections except the selected one
    document.querySelectorAll('#projects, #about, #resume').forEach(sec => {
      if (sec.id === section) {
        sec.style.display = 'block';
      } else {
        sec.style.display = 'none';
      }
    });
    overlay.classList.remove('active');
  }, 500);
}

// Initial section setup
window.addEventListener('DOMContentLoaded', () => {
  // Only show projects by default
  document.querySelectorAll('#projects, #about, #resume').forEach(sec => {
    if (sec.id === 'projects') {
      sec.style.display = 'block';
    } else {
      sec.style.display = 'none';
    }
  });
  // Nav link event listeners
  document.querySelectorAll('.nav-toggle').forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      const section = link.classList.contains('project') ? 'projects' :
                      link.classList.contains('about') ? 'about' :
                      link.classList.contains('resume') ? 'resume' : 'projects';
      setActive(section);
    });
  });
}); 