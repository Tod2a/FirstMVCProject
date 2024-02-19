
// select all items with the class selected
const carouselItems = document.querySelectorAll('.carousel-item');
let currentIndex = 0;

function showSlide(index) {
  // hide all items
  carouselItems.forEach(item => {
    item.style.display = 'none';
  });

  // show the item with the right index
  carouselItems[index].style.display = 'block';
}

//function next to make index +1
function nextSlide() {
  currentIndex = (currentIndex + 1) % carouselItems.length;
  //call the function to set the right item
  showSlide(currentIndex);
}

//function previous to make index -1
function previousSlide() {
  currentIndex = (currentIndex - 1 + carouselItems.length) % carouselItems.length;
  //call the function to set the right item
  showSlide(currentIndex);
}

// Show the first slide initially
showSlide(currentIndex);

// Set up event listeners for next and previous buttons
document.getElementById('nextBtn').addEventListener('click', nextSlide);
document.getElementById('prevBtn').addEventListener('click', previousSlide);