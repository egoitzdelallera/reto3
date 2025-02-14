import { useRouter } from 'vue-router';
import basketImage from '@/assets/img/basket.png';
import boxeoImage from '@/assets/img/boxeo.png';
import futbolImage from '@/assets/img/futbol.png';
import tenisImage from '@/assets/img/tenis.png';

const useSlider = () => {
  const router = useRouter();

  class Slider {
    constructor() {
      this.container = null;
      this.slider = null;
      this.cursor = null;
      this.slideWidth = 420;
      this.images = [
        { src: basketImage, name: 'Basket', link: '/basket' },
        { src: boxeoImage, name: 'Boxeo', link: '/boxeo' },
        { src: futbolImage, name: 'Futbol', link: '/futbol' },
        { src: tenisImage, name: 'Tenis', link: '/tenis' },
      ];
      this.currentIndex = 0;
      this.isAnimating = false;
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
        const slide = document.createElement('div');
        slide.className = 'slide';
        slide.dataset.link = this.images[index].link;
        slide.innerHTML = `
          <img src="${this.images[index].src}" alt="Slide ${index + 1}">
          <div class="info">
            ${this.images[index].name}
            <a href="#" data-link="${this.images[index].link}"><i class="bi bi-arrow-up-right-circle-fill" style="font-size: 4rem;"></i></a>
          </div>`;
        this.slider.appendChild(slide);
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
        if (slide && slide.classList.contains('active')) {
          const link = slide.dataset.link;
          router.push(link);
        } else {
          const rect = this.container.getBoundingClientRect();
          const isLeft = e.clientX < rect.left + rect.width / 2;
          this.moveSlides(isLeft ? -1 : 1);
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
    }

    startAutoplay() {
      this.stopAutoplay();
      this.autoplayInterval = setInterval(() => {
        this.moveSlides(1);
      }, 3000);
    }

    stopAutoplay() {
      if (this.autoplayInterval) {
        clearInterval(this.autoplayInterval);
      }
    }
  }

  return {
    init: () => {
      new Slider().init()
    }
  }
}

export default useSlider;