<?php

header('Content-Type: application/json');

$response = [
    'error' => false
];

if(!isset($_POST['nome']) or !isset($_POST['email']) or !isset($_POST['mensagem'])) {
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

$subject = 'Mensagem SimplesFlex';

$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
$menssagem = filter_var($_POST['mensagem'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

$message = '
    <html>
        <head>
            <title></title>
        </head>
        <body>
            <p><b>Mensagem de contato</b></p>
            <p><b>Nome</b> '. $nome .'</p>
            <p><b>E-mail</b> '. $email .'</p>
            <p>'. $menssagem .'</p>
        </body>
    </html>';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// $to = "Light System <falecom@lightsystemsoft.com.br>";
$to = "Light System <henriquevilela@lightsystemsoft.com.br>";

// rogerio@lightsystemsoft.com.b

// Additional headers
$headers .= "To: $to" . "\r\n";
$headers .= "From: $nome <$email>" . "\r\n";
// $headers .= "Cc: birthdayarchive@example.com" . "\r\n";
// $headers .= "Bcc: birthdaycheck@example.com" . "\r\n";

if(mail($to, $subject, $message, $headers)) {
    $response['message'] = 'Mensagem enviada com sucesso, agradecemos o seu contato.';
} else {
    $response['error'] = true;
    $response['message'] = 'Houve um problema para enviar a mensagem, tente novamente mais tarde. Agradecemos o seu contato';
}
    
echo json_encode($response);