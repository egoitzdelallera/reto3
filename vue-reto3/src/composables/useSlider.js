import { useRouter } from 'vue-router';
import useCategorias from '../composables/useCategorias';  // Importa el composable
import { ref } from 'vue';
import { onMounted } from 'vue';

const useSlider = () => {
    const router = useRouter();
    const { categorias, fetchCategorias } = useCategorias(); // Usa el composable
    const loading = ref(true); // Añade un estado de carga

    class Slider {
        constructor(images) {
            this.container = null;
            this.slider = null;
            this.cursor = null;
            this.slideWidth = 420;
            this.images = images; // Usa las imágenes inyectadas
            this.currentIndex = this.images.length * 1.5;
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

                // Construye la URL directamente (sin usar new URL)
                const imgSrc = this.images[index].src ? this.images[index].src : '';

                slide.innerHTML = `
                    <img src="${imgSrc}" alt="Slide ${index + 1}">
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

    const init = async () => {
        try {
            await fetchCategorias(); // Asegúrate de que las categorías estén cargadas

            const dynamicImages = categorias.value.map(categoria => ({
                // Asegúrate de que la ruta comienza con "@/assets/img/"
                src: categoria.multimedia ? `${categoria.multimedia}` : null,
                name: categoria.nombre,
                link: `/${categoria.nombre.toLowerCase()}`,
            }));

            new Slider(dynamicImages).init();
        } catch (error) {
            console.error("Error initializing slider:", error);
        } finally {
            loading.value = false; // Indica que la carga ha terminado, incluso si hubo un error
        }
    }

    onMounted(async () => {
        await init();
    });

    return {
        init,
        loading // Devuelve el estado de carga
    }
}

export default useSlider;