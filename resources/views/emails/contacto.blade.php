<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Mensaje de Contacto</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #4A5568; background-color: #f7fafc; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
        <div style="background-color: #1E6F9F; color: #ffffff; padding: 20px; text-align: center;">
            <h2 style="margin: 0;">🦷 Nuevo Contacto - Odontología</h2>
            <p style="margin: 5px 0 0 0; opacity: 0.9;">Interés en el Plan de Membresía Dental</p>
        </div>
        <div style="padding: 24px;">
            <p>Has recibido un nuevo mensaje desde el formulario de la landing page:</p>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 120px;">Nombre:</td>
                    <td style="padding: 8px 0;">{{ $datos['nombre'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Email:</td>
                    <td style="padding: 8px 0;"><a href="mailto:{{ $datos['email'] }}" style="color: #1E6F9F;">{{ $datos['email'] }}</a></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Teléfono:</td>
                    <td style="padding: 8px 0;">{{ $datos['telefono'] }}</td>
                </tr>
            </table>

            <div style="background-color: #f8fafc; border-left: 4px solid #C8B6E2; padding: 15px; border-radius: 4px; margin-top: 15px;">
                <p style="margin: 0; font-weight: bold; color: #1E6F9F;">Mensaje:</p>
                <p style="margin: 8px 0 0 0; white-space: pre-line;">{{ $datos['mensaje'] }}</p>
            </div>
        </div>
        <div style="background-color: #edf2f7; padding: 12px 24px; text-align: center; font-size: 12px; color: #718096;">
            Este correo fue generado automáticamente por la landing page de Odontología.
        </div>
    </div>
</body>
</html>
