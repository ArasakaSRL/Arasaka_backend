<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            color: #333333;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            background: #ffffff;
            margin: 0 auto;
            border-top: 4px solid #0056b3;
            border-radius: 4px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h2 {
            color: #003366;
            margin-top: 0;
        }
        p {
            font-size: 14px;
            line-height: 1.6;
        }
        .footer {
            margin-top: 30px;
            font-size: 11px;
            color: #7f8c8d;
            border-top: 1px solid #ecf0f1;
            padding-top: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>¡Tu reporte de analíticas ya está listo!</h2>
        <p>Hola,</p>
        <p>Adjunto a este correo encontrarás el reporte analítico detallado de tu portafolio <strong>{{ $portafolio->nombre ?? $portafolio->slug }}</strong> gestionado en la plataforma.</p>
        <p>El documento incluye el resumen general de tráfico, interacciones de perfil, clics en coordenadas y el análisis de tus secciones de habilidades técnicas.</p>
        <p>Si tienes alguna pregunta o requieres asistencia adicional, no dudes en responder a este mensaje.</p>
        
        <div class="footer">
            Este es un correo automatizado enviado por el sistema de monitoreo de Devlinked.
        </div>
    </div>
</body>
</html>