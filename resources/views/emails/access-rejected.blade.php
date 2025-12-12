<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; background-color: #f4f4f4; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 20px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .header { text-align: center; border-bottom: 2px solid #999; padding-bottom: 20px; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #1a1a1a; letter-spacing: 2px; }
        .content { margin-bottom: 30px; }
        .footer { font-size: 12px; text-align: center; color: #888; border-top: 1px solid #eee; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>CROW GLOBAL</h1>
        </div>
        <div class="content">
            <h2>Atualização sobre o seu pedido</h2>
            <p>Olá {{ $request->name }},</p>
            <p>Agradecemos o seu interesse na Crow Global.</p>
            <p>Após análise do seu perfil, informamos que o seu pedido de acesso não pôde ser aprovado neste momento.</p>
            
            @if($request->rejection_reason)
            <p><strong>Motivo:</strong> {{ $request->rejection_reason }}</p>
            @endif

            <p>Caso tenha dúvidas ou queira submeter novas informações, entre em contato com o nosso suporte.</p>
            <p>Atenciosamente,<br>Equipa Crow Global</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Crow Global. Todos os direitos reservados.
        </div>
    </div>
</body>
</html>