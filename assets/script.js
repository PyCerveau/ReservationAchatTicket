document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelector(".slides");
    const totalSlides = document.querySelectorAll(".slide").length;
    let index = 0;

    function nextSlide() {
        index = (index + 1) % totalSlides; // Passer à l'image suivante
        updateSlider();
    }

    function prevSlide() {
        index = (index - 1 + totalSlides) % totalSlides; // Image précédente
        updateSlider();
    }

    function updateSlider() {
        slides.style.transform = `translateX(-${index * 100}%)`;
    }

    setInterval(nextSlide, 3000); // Défilement auto toutes les 3s

    // Ajouter boutons (optionnel)
    document.getElementById("next").addEventListener("click", nextSlide);
    document.getElementById("prev").addEventListener("click", prevSlide);
});
