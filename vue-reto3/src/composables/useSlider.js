// composables/useSlider.js
import { useRouter } from 'vue-router';
import useCategorias from '../composables/useCategorias';
import { ref, onMounted } from 'vue';

const useSlider = () => {
  const router = useRouter();
  const { categorias, fetchCategorias } = useCategorias();
  const loading = ref(true);
  const error = ref(null);

  class Slider {
    constructor(images, initialIndex = 0) {
      this.container = null;
      this.slider = null;
      this.cursor = null;
      this.slideWidth = 420;
      this.images = images;
      this.currentIndex = initialIndex; // Use the initial index, ajustado para mostrar slides a los lados
      this.isAnimating = false;
      this.autoplayInterval = null; // Store the interval ID
      this.autoplayDelay = 3000; // Delay between slides in milliseconds
    }

    init() {
      this.container = document.querySelector('.slider-container');
      this.slider = document.querySelector('.slider');
      this.cursor = document.querySelector('.custom-cursor');
      this.createSlides();
      this.setupEventListeners();
      this.positionSlides();
      this.startAutoplay();
    }

    createSlides() {
      const totalSlides = this.images.length * 5;
      for (let i = 0; i < totalSlides; i++) {
        const index = i % this.images.length;
        const image = this.images[index];

        const slide = document.createElement('div');
        slide.className = 'slide';
        slide.dataset.link = image.link;

        try {
          const imgSrc = image.src ? image.src : ''; // Usa el src de los datos dinámicos
          slide.innerHTML = `
              <img src="${imgSrc}" alt="Slide ${index + 1}">
              <div class="info">
                ${image.name}
                <a href="#" data-link="${image.link}"><i class="bi bi-arrow-up-right-circle-fill" style="font-size: 4rem;"></i></a>
              </div>`;
          this.slider.appendChild(slide);
        } catch (e) {
          console.error(`Error creating slide ${i}:`, e, image);
          slide.innerHTML = `<div class="error">Error al cargar slide</div>`;
          this.slider.appendChild(slide);
        }
      }
    }

    positionSlides() {
      const slides = this.slider.querySelectorAll('.slide');
      const offset = (this.container.offsetWidth - this.slideWidth) / 2;
      const baseTransform = -this.currentIndex * this.slideWidth + offset;

      this.slider.style.transform = `translateX(${baseTransform}px)`;

      slides.forEach((slide, index) => {
        const normalizedIndex = this.normalizeIndex(index);
        slide.classList.toggle('active', normalizedIndex === this.currentIndex % this.images.length);
      });

       // Set focus on the active slide
       const activeSlide = slides[this.currentIndex % slides.length];
       if (activeSlide) {
         activeSlide.focus();
       }
    }

    normalizeIndex(index) {
      return index % this.images.length;
    }

    moveSlides(direction) {
      if (this.isAnimating) return;
      this.isAnimating = true;

      this.currentIndex += direction;

      this.slider.style.transition = 'transform 0.3s ease-out';
      this.positionSlides();

      if (this.currentIndex >= this.images.length * 4 || this.currentIndex <= this.images.length) {
        setTimeout(() => {
          this.slider.style.transition = 'none';
          this.currentIndex = this.currentIndex >= this.images.length * 4
            ? this.currentIndex - this.images.length * 2
            : this.currentIndex + this.images.length * 2;
          this.positionSlides();
        }, 300);
      }

      setTimeout(() => {
        this.isAnimating = false;
      }, 300);
    }

    setupEventListeners() {
      document.addEventListener('mousemove', (e) => {
        this.cursor.style.left = `${e.clientX - 25}px`;
        this.cursor.style.top = `${e.clientY - 25}px`;

        const rect = this.container.getBoundingClientRect();
        const isLeft = e.clientX < rect.left + rect.width / 2;

        this.cursor.classList.toggle('left', isLeft);
        this.cursor.classList.toggle('right', !isLeft);
      });

      this.container.addEventListener('mouseenter', () => {
        this.cursor.style.opacity = '1';
        this.stopAutoplay();
      });

      this.container.addEventListener('mouseleave', () => {
        this.cursor.style.opacity = '0';
        this.startAutoplay();
      });

      this.container.addEventListener('click', (e) => {
        const slide = e.target.closest('.slide');
        if (slide) {
          if (slide.classList.contains('active')) {
            const link = slide.dataset.link;
            router.push(link);
          } else {
            const rect = this.container.getBoundingClientRect();
            const isLeft = e.clientX < rect.left + rect.width / 2;
            this.smoothScroll(isLeft ? -1 : 1);
          }
        }
      });

      this.slider.addEventListener('mousemove', (e) => {
        const slide = e.target.closest('.slide');
        if (slide && slide.classList.contains('active')) {
          this.cursor.style.opacity = '0';
        } else {
          this.cursor.style.opacity = '1';
        }
      });

      window.addEventListener('resize', () => this.positionSlides());

       // Keyboard navigation
      this.container.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
          e.preventDefault(); // Prevent default scrolling
          this.moveSlides(-1);
        } else if (e.key === 'ArrowRight') {
          e.preventDefault(); // Prevent default scrolling
          this.moveSlides(1);
        }
      });
    }

    smoothScroll(direction) {
      const targetIndex = this.currentIndex + direction;
      const duration = 400; // Duration of the scroll animation in milliseconds
      const start = this.currentIndex;
      const startTime = performance.now();

      const animate = (currentTime) => {
        const elapsedTime = currentTime - startTime;
        const progress = Math.min(elapsedTime / duration, 1);
        const easeProgress = this.easeInOutCubic(progress);

        this.currentIndex = start + (targetIndex - start) * easeProgress;
        this.positionSlides();

        if (progress < 1) {
          requestAnimationFrame(animate);
        } else {
          this.currentIndex = Math.round(this.currentIndex);
          this.positionSlides();
        }
      };

      requestAnimationFrame(animate);
    }

    easeInOutCubic(t) {
      return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
    }

   
  }

  const init = async () => {
    try {
      await fetchCategorias();

      const dynamicImages = categorias.value.map(categoria => ({
        src: categoria.multimedia || '',
        name: categoria.nombre,
        link: `/${categoria.nombre.toLowerCase()}`,
      }));

      const initialIndex = dynamicImages.length * 1.5; // Muestra slides a los lados
      const slider = new Slider(dynamicImages, initialIndex);
      slider.init();

      // Give focus to the container element after the slider is initialized.
      setTimeout(() => {
        slider.container.focus();
      }, 100);

    } catch (e) {
      console.error("Error initializing slider:", e);
      error.value = e;
    } finally {
      loading.value = false;
    }
  };

  onMounted(async () => {
    await init();
  });

  return {
    init,
    loading,
    error,
  };
};

export default useSlider;