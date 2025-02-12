<template>
  <div class="container-fluid bg-black">
    <div class="row justify-content-center">
      <div class="col-5">
        <div class="titulo w-100">eXplora y apúNtate <br> en actividadEs</div>
      </div>
    </div>
    <div class="row justify-content-center mt-3">
      <div class="col-4">
        <div class="filtro border border-white rounded d-flex justify-content-around">
          <select id="actividades">
            <option value="Centro civico" select hidden>Centro civico</option>
            <option value="deporte">centro1</option>
            <option value="recreacion">centro2</option>
            <option value="comida">centro3</option>
            <option value="otros">centro4</option>
          </select>
          <select id="edad">
            <option value="edad" select hidden>Edad</option>
            <option value="deporte">centro1</option>
            <option value="recreacion">centro2</option>
            <option value="comida">centro3</option>
            <option value="otros">centro4</option>
          </select>
          <select id="idioma">
            <option value="idioma" select hidden>Idioma</option>
            <option value="deporte">centro1</option>
            <option value="recreacion">centro2</option>
            <option value="comida">centro3</option>
            <option value="otros">centro4</option>
          </select>
          <select id="horario">
            <option value="horario" select hidden>Horario</option>
            <option value="deporte">centro1</option>
            <option value="recreacion">centro2</option>
            <option value="comida">centro3</option>
            <option value="otros">centro4</option>
          </select>
        </div>
      </div>
    </div>
    <div class="actividades">
      <div class="custom-cursor"></div>
      <div class="slider-container">
        <div class="slider"></div>
      </div>
    </div>
  </div>
</template>

<style>
.titulo {
    text-align: center;
    font-size: 4em;
    font-family: Dirtyline;
    color: white;
    line-height: 1; /* Añade espacio entre líneas de párrafo */
}

#actividades, #edad, #idioma, #horario {
    background-color: transparent !important;
    color: white;
    border: 0px;
    padding: 10px;
}

#actividades option, #edad option, #idioma option, #horario option {
    background-color: #000000;
    color: white;
    padding: 10px;
    border: none;
    cursor: pointer;
}


.slider-container {
    width: 100%;
    position: relative;
    overflow: hidden;
    padding-bottom:3%;
    margin-top:3%;
}

.slider {
    display: flex;
    position: relative;
}
option{
    
    background-color: #000000;
    color: white;
    border: none;
}

.slide {
    min-width: 400px;
    height: 450px;
    margin: 0 10px;
    position: relative;
    transform: scale(0.95);
    opacity: 0.5;
    transition: all 0.3s ease-in-out;
    border-radius: 10px;
    overflow: hidden;
    flex-shrink: 0;
}

.slide.active {
    transform: scale(1);
    opacity: 1;
}

.slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.slide .info {
    position: absolute;
    bottom: -55px;
    left: 10px;
    color: rgb(0, 0, 0);
    font-size: 4em;
    font-family:Inter;
    font-weight:700;
    padding: 10px;
    letter-spacing: -0.05em;
    border-radius: .5px;
    width: 97%;
    display: flex;
    align-items: center;
    justify-content:space-between;
}

.slide .info a {
    color: white;
    text-decoration: none;
    margin-left: 30%;
    font-size: 1.5em;
    cursor: pointer;
    color:black;
    margin-bottom: .2em;
}

.custom-cursor {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid white;
    border-radius: 50%;
    position: fixed;
    pointer-events: none;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    font-size: 20px;
    opacity: 0;
    transition: transform 0.1s ease;
    backdrop-filter: blur(4px);
    z-index: 1000;
}

.custom-cursor.left::before {
    content: "←";
}

.custom-cursor.right::before {
    content: "→";
}

.custom-cursor.active {
    transform: scale(1.5);
}

.no-cursor .custom-cursor {
    display: none;
}

.no-cursor .custom-cursor.left::before,
.no-cursor .custom-cursor.right::before {
    content: "";
}
</style>

<script>
import { useRouter } from 'vue-router';
import basketImage from '@/assets/img/basket.png';
import boxeoImage from '@/assets/img/boxeo.png';
import futbolImage from '@/assets/img/futbol.png';
import tenisImage from '@/assets/img/tenis.png';

export default {
  setup() {
    const router = useRouter();

    class Slider {
      constructor() {
        this.container = null;
        this.slider = null;
        this.cursor = null;
        this.slideWidth = 420; // 400px + 20px margin
        
        this.images = [
          { src: basketImage, name: 'Basket', link: '/basket' },
          { src: boxeoImage, name: 'Boxeo', link: '/boxeo' },
          { src: futbolImage, name: 'Futbol', link: '/futbol' },
          { src: tenisImage, name: 'Tenis', link: '/tenis' },
        ];
        
        this.currentIndex = this.images.length; // Comenzar en el medio
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
          const rect = this.container.getBoundingClientRect();
          const isLeft = e.clientX < rect.left + rect.width / 2;
          
          const activeSlide = this.slider.querySelector('.slide.active');
          if (activeSlide && e.target.closest('.slide.active')) {
            const link = activeSlide.querySelector('a').getAttribute('data-link');
            router.push(link);
          } else {
            this.moveSlides(isLeft ? -1 : 1);
          }
          
          this.cursor.classList.add('active');
          setTimeout(() => this.cursor.classList.remove('active'), 300);
        });

        this.slider.addEventListener('mouseover', (e) => {
          if (e.target.closest('.slide.active')) {
            this.cursor.style.display = 'none';
          }
        });

        this.slider.addEventListener('mouseout', (e) => {
          if (e.target.closest('.slide.active')) {
            this.cursor.style.display = 'flex';
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
      initSlider: () => {
        const slider = new Slider();
        slider.init();
      }
    };
  },
  mounted() {
    this.initSlider();
  }
}
</script>