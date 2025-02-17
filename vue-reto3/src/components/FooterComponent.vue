<template>
    <footer>
      <div class="footer">
        <div class="footer__logo">
          <img src="../assets/img/logoFooter.png" alt="Logo" />
        </div>
        <div class="footer__social">
          <a href="https://www.facebook.com" target="_blank">
            <i class="bi bi-facebook"></i>          </a>
          <a href="https://www.instagram.com" target="_blank">
            <i class="bi bi-instagram"></i>          </a>
          <a href="https://www.twitter.com" target="_blank">
            <i class="bi bi-twitter-x"></i>
          </a>
        </div>
        <div class="footer__contact">
          <p class="footer__contact-title">Contáctanos</p>
          <p>
            <a href="mailto:contact@example.com">contact@example.com</a>
          </p>
          <p>
            <a href="tel:1234567890">+1 123 456 7890</a>
          </p>
        </div>
        <div class="footer__copyright">
          <p>© 2022 Your Company. Todos los derechos reservados.</p>
        </div>
      </div>
      <div class="footer__links">
        <a href="#">Política de privacidad</a>
        <a href="#">Términos y condiciones</a>
      </div>
    </footer>
  </template>
  
  <style scoped>
  /* Add your CSS styles here */
  
  footer {
    background-color: #222; /* Darker background for better contrast */
    color: #fff; /* Light text for readability */
    padding: 20px 0; /* Increased padding for visual breathing room */
    font-family: sans-serif; /* Modern font */
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }
  
  .footer {
    width: 80%; /* Limit width for larger screens */
    max-width: 1200px; /* Further limit width for extra-large screens */
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px; /* Spacing between main footer and links */
    padding-bottom: 15px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1); /* Subtle separator */
  }
  
  .footer__logo img {
    width: 180px; /* Slightly smaller logo */
    height: auto;
  }
  
  .footer__social {
    display: flex;
    align-items: center;
  }
  
  .footer__social a {
    display: inline-block; /* Ensures consistent spacing */
    font-size: 30px; /*
  }
  
  .footer__social img {
    width: 30px; /* Slightly larger social icons */
    height: auto;
    margin-right: 15px; /* Increased spacing */
    transition: transform 0.2s ease-in-out; /* Smooth hover effect */
  }
  
  .footer__social img:hover {
    transform: scale(1.1);
  }
  
  .footer__contact {
    text-align: right; /* Align contact info to the right */
  }
  
  .footer__contact-title {
    font-weight: bold;
    margin-bottom: 5px;
  }
  
  .footer__contact a {
    color: #fff;
    text-decoration: none;
    transition: color 0.2s ease-in-out;
  }
  
  .footer__contact a:hover {
    color: #aaa;
  }
  
  .footer__copyright {
    text-align: center;
    font-size: 0.9em;
    color: rgba(255, 255, 255, 0.7); /* Slightly desaturated copyright text */
  }
  
  .footer__links {
    display: flex;
    justify-content: center;
    gap: 20px; /* Spacing between links */
  }
  
  .footer__links a {
    color: #fff;
    text-decoration: none;
    transition: color 0.2s ease-in-out;
  }
  
  .footer__links a:hover {
    color: #aaa;
  }
  
  @media (max-width: 768px) {
    /* Mobile-friendly adjustments */
    .footer {
      flex-direction: column;
      text-align: center;
    }
  
    .footer__logo,
    .footer__social,
    .footer__contact,
    .footer__copyright {
      margin-bottom: 10px;
    }
  
    .footer__contact {
      text-align: center;
    }
  
    .footer__links {
      flex-direction: column;
      align-items: center;
    }
    .footer__social img {
      margin: 5px;
    }
  
  }
  </style>