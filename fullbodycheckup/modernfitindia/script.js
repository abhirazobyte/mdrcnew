// // script.js
// const carousel = document.getElementById('carousel');
// const slides = carousel.children;
// let currentIndex = 0;

// // Auto loop function
// function startCarousel() {
//   setInterval(() => {
//     // Calculate the width of one slide
//     const slideWidth = slides[0].clientWidth;
    
//     // Move to the next slide
//     currentIndex = (currentIndex + 1) % slides.length;
    
//     // Apply the translation for sliding effect
//     carousel.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
//   }, 3000); // Change slide every 3 seconds
// }

// // Start the carousel when the page loads
// window.onload = startCarousel;
function showPopup(event) {
  event.preventDefault();
  const popup = document.getElementById('popup');
  popup.classList.add('active');
  event.target.reset();
}

function closePopup() {
  const popup = document.getElementById('popup');
  popup.classList.remove('active');
}

// Close modal when clicking outside
document.getElementById('popup').addEventListener('click', function(event) {
  if (event.target === this) {
      closePopup();
  }
});

// Close on escape key
document.addEventListener('keydown', function(event) {
  if (event.key === 'Escape') {
      closePopup();
  }
});