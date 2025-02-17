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
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
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
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>
    <p>Hola {{ $nombre }},</p>
    <p>Tu inscripción a la actividad <strong>{{ $actividadNombre }}</strong> se ha completado con éxito.</p>
    <p>¡Te esperamos!</p>

        <p class="footer">Gracias por participar. Para más información, visita nuestra página web.</p>
</body>
</html>