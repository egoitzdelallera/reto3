// utils/decodificarToken.js

export function decodificarToken(token) {
    try {
        const partes = token.split('.');
        if (partes.length !== 3) {
            throw new Error('El token no es válido');
        }

        // Decodifica la parte del payload (segunda parte del token)
        const payload = partes[1];

        // Decodifica de Base64 a texto
        const decodedPayload = JSON.parse(atob(payload));

        console.log('Payload decodificado:', decodedPayload);

        // Devuelve el id o el correo
        return decodedPayload;
    } catch (error) {
        console.error('Error al decodificar el token:', error);
        return null;
    }
}
