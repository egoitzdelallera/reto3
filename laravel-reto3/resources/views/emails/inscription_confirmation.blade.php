<!DOCTYPE html>
<html>
<head>
    <title>Confirmación de Inscripción</title>
</head>
<body>
    <h1>¡Inscripción Confirmada!</h1>
    <p>Hola {{ $inscriptionData['nombre'] }},</p>
    <p>Te has inscrito correctamente en la actividad:</p>

    <ul>
        <li><strong>Actividad:</strong> {{ $inscriptionData['actividad_nombre'] }}</li>
        <li><strong>Nombre:</strong> {{ $inscriptionData['nombre'] }}</li>
        <li><strong>Apellido 1:</strong> {{ $inscriptionData['apellido1'] }}</li>
        <li><strong>Apellido 2:</strong> {{ $inscriptionData['apellido2'] }}</li>
        <li><strong>DNI:</strong> {{ $inscriptionData['dni'] }}</li>
        <li><strong>Sexo:</strong> {{ $inscriptionData['sexo'] }}</li>
        <li><strong>Edad:</strong> {{ $inscriptionData['edad'] }}</li>
        <li><strong>Teléfono:</strong> {{ $inscriptionData['telefono'] }}</li>
        <li><strong>Correo:</strong> {{ $inscriptionData['correo'] }}</li>
    </ul>

    <p>¡Te esperamos!</p>
</body>
</html>