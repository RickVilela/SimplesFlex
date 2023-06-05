<?php

header('Content-Type: application/json');

$response = [
    'error' => false
];

if(!isset($_POST['nome']) or !isset($_POST['email']) or !isset($_POST['message'])) {
    $response['error'] = true;
    $response['message'] = 'Dados incompletos, verifique e tente novamente.';
    print json_encode($response);
    exit;
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $response['error'] = true;
    $response['message'] = 'E-mail informado é inválido, verifique e tente novamente.';
    print json_encode($response);
    exit;
}

if($_POST['message'] == '') {
    $response['error'] = true;
    $response['message'] = 'É necessário informar uma mensagem, verifique e tente novamente.';
    print json_encode($response);
    exit;
}

if($_POST['celular'] == '') {
    $response['error'] = true;
    $response['message'] = 'É necessário informar um celular, verifique e tente novamente.';
    print json_encode($response);
    exit;
}

$subject = 'Mensagem SimplesFlex';

$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
$menssagem = filter_var($_POST['message'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
$celular = filter_var($_POST['celular']);
$assunto = filter_var($_POST['assunto']);

$message = '
    <html>
        <head>
            <title>'.$assunto.'</title>
        </head>
        <body>
            <p><b>Mensagem de contato</b></p>
            <p><b>Assunto</b> '. $assunto .'</p>
            <p><b>Nome</b> '. $nome .'</p>
            <p><b>E-mail</b> '. $email .'</p>
            <p><b>Celular</b> '. $celular .'</p>
            <p>'. $menssagem .'</p>
        </body>
    </html>';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// $to = "Light System <falecom@lightsystemsoft.com.br>";
$to = "Light System <rogerio@lightsystemsoft.com.br>";

// rogerio@lightsystemsoft.com.br

// Additional headers
$headers .= "To: $to" . "\r\n";
$headers .= "From: $nome <$email>" . "\r\n";
// $headers .= "Cc: birthdayarchive@example.com" . "\r\n";
// $headers .= "Bcc: birthdaycheck@example.com" . "\r\n";

if(mail($to, $subject, $message, $headers)) {
    $response['message'] = 'Mensagem enviada com sucesso, agradecemos o seu contato.';
    $response['status'] = 200;
} else {
    $response['error'] = true;
    $response['message'] = 'Houve um problema para enviar a mensagem, tente novamente mais tarde. Agradecemos o seu contato';
    $response['status'] = 404;
}
    
echo json_encode($response);