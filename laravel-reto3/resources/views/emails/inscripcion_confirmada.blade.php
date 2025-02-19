<!DOCTYPE html>

<html>
<head>
    <title>Inscripción Confirmada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        
        h1 {
            color: #0056b3;
        }
        p {
            margin-bottom: 10px;
        }
        .activity-details {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #eee;
        }
        .activity-image {
            max-width: 80%;
            height: auto;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>
<div class="container" style="width: 100%; margin: 0 auto;">
        <img src="https://inigoberastegi.com/wp-content/uploads/2025/02/banner-12.png" alt="Imagen de la actividad" class="activity-image" style="max-width: 100%; height: auto;">
    </div>
    <p>Hola {{ $nombre }},</p>
    <p>Tu inscripción a la actividad <strong>{{ $actividadNombre }}</strong> se ha completado con éxito.</p>
    <p>¡Te esperamos!</p>

        <p class="footer">Gracias por participar. Para más información, visita nuestra página web.</p>
</body>
</html>