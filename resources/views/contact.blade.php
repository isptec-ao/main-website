<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
</head>
<body>
    <ul>
        <li>Nome: {!! $name !!}</li>
        <li>Email: {!! $email !!}</li>
        <li>Contacto: {!! $phone !!}</li>
        <li>Assunto: {!! $subject !!}</li>
        <li>Serviço: {!! $service !!}</li>
    </ul>

    <p>Mensagem:</p><br>
    <p>{!! $body !!}</p>
</body>
</html>