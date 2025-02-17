<template>
    <footer>
        <div class="footer">
        <div class="footer__logo">
            <img src="../assets/logo.png" alt="Logo" />
        </div>
        <div class="footer__social">
            <a href="https://www.facebook.com" target="_blank">
            <img src="../assets/facebook.png" alt="Facebook" />
            </a>
            <a href="https://www.instagram.com" target="_blank">
            <img src="../assets/instagram.png" alt="Instagram" />
            </a>
            <a href="https://www.twitter.com" target="_blank">
            <img src="../assets/twitter.png" alt="Twitter" />
            </a>
        </div>
        <div class="footer__contact">
            <p>Contáctanos</p>
            <p>
                <a href="mailto:contact@example.com">contact@example.com</a>
            </p>
            <p>
                <a href="tel:1234567890">+1 123 456 7890</a>
            </p>
        </div>
        <div class="footer__copyright">
            <p>&copy; 2022 Your Company. Todos los derechos reservados.</p>
        </div>
        </div>
        <div class="footer__links">
            <a href="#">Política de privacidad</a>
            <a href="#">Términos y condiciones</a>
        </div>
    </footer>
</template>

<style>

/* Add your CSS styles here */

.footer {
    background-color: #333;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index:999;
}

.footer__logo img {
    width: 100px;
}

.footer__social img {
    width: 25px;
    margin-right: 10px;

}

.footer__contact {
    display: flex;
    align-items: center;
}

.footer__copyright {
    text-align: center;
}

.footer__links {
    display: flex;
    justify-content: center;
}
    
</style>