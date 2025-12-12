<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; background-color: #f4f4f4; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 20px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .header { text-align: center; border-bottom: 2px solid #D4AF37; padding-bottom: 20px; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #1a1a1a; letter-spacing: 2px; }
        .content { margin-bottom: 30px; }
        .btn { display: inline-block; background-color: #1a1a1a; color: #fff; padding: 12px 25px; text-decoration: none; border-radius: 4px; font-weight: bold; }
        .footer { font-size: 12px; text-align: center; color: #888; border-top: 1px solid #eee; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>CROW GLOBAL</h1>
        </div>
        <div class="content">
            <h2>Imóvel Aprovado</h2>
            <p>Olá,</p>
            <p>Temos o prazer de informar que o seu imóvel <strong>{{ $property->title }}</strong> foi aprovado pela nossa equipa de moderação e já se encontra publicado no portal.</p>
            <p>Pode visualizar o anúncio no botão abaixo:</p>
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('properties.show', $property) }}" class="btn">Ver Imóvel</a>
            </div>
            <p>Atenciosamente,<br>Equipa Crow Global</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Crow Global. Todos os direitos reservados.
        </div>
    </div>
</body>
</html>