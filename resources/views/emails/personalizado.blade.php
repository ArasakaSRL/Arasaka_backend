<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .footer {
            margin-top: 25px;
            font-size: 13px;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
    </style>
</head>

<body>
    <div
        class="
        container
      ">
        <div class="title">{{ $subject }}</div>

        <p style="color:#555; font-size:14px; margin-bottom:15px;">
            📨 <strong>{{ $nombreRemitente }}</strong> ({{ $correoRemitente }}) te ha enviado un mensaje:
        </p>

        <p>{!! nl2br(e($content)) !!}</p>

        <div class="footer">
            📩 Enviado a través de <strong>{{ config('app.name') }}</strong> — Puedes responder directamente a este correo.
        </div>
    </div>
</body>

</html>