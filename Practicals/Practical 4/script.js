document.addEventListener("DOMContentLoaded", function () {

  const notification = document.getElementById("notification");
  const showNotificationBtn = document.getElementById("showNotification");

  if (showNotificationBtn && notification) {
    showNotificationBtn.addEventListener("click", function () {
      notification.classList.remove("hidden");
      setTimeout(() => {
        notification.classList.add("hidden");
      }, 3000);
    });
  }

  const faqToggles = document.querySelectorAll(".faq-toggle");

  faqToggles.forEach(button => {
    button.addEventListener("click", () => {
      const faq = button.parentElement;
      faq.classList.toggle("active");
    });
  });

  const slide = document.getElementById("slide");
  const prevBtn = document.getElementById("prev");
  const nextBtn = document.getElementById("next");

  const images = [
    "https://picsum.photos/seed/1/600/300",
    "https://picsum.photos/seed/2/600/300",
    "https://picsum.photos/seed/3/600/300"
  ];

  let currentSlide = 0;

  function updateSlide() {
    slide.src = images[currentSlide];
  }

  if (prevBtn) {
    prevBtn.addEventListener("click", () => {
      currentSlide--;
      if (currentSlide < 0) currentSlide = images.length - 1;
      updateSlide();
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener("click", () => {
      currentSlide++;
      if (currentSlide >= images.length) currentSlide = 0;
      updateSlide();
    });
  }

  updateSlide();

  const modal = document.getElementById("modal");
  const openPopupBtn = document.getElementById("openPopup");
  const closeBtn = document.querySelector(".close");

  if (openPopupBtn && modal) {
    openPopupBtn.addEventListener("click", () => {
      modal.classList.remove("hidden");
    });
  }

  if (closeBtn && modal) {
    closeBtn.addEventListener("click", () => {
      modal.classList.add("hidden");
    });
  }

  window.addEventListener("click", (event) => {
    if (modal && event.target === modal) {
      modal.classList.add("hidden");
    }
  });
});