<?php
// 1. Defina suas Chaves
// **IMPORTANTE:** Use sua CHAVE SECRETA, nunca a Chave do Site!
$secret_key = 'SUA_CHAVE_SECRETA'; 
$verify_url = 'https://www.google.com/recaptcha/api/siteverify';

// 2. Capturar o Token do reCAPTCHA
// O token é enviado no campo 'g-recaptcha-response' quando o formulário é submetido.
$recaptcha_response = $_POST['g-recaptcha-response'];

// 3. Montar a Requisição para o Google
$data = [
    'secret' => $secret_key,
    'response' => $recaptcha_response,
    // Opcional: Para segurança extra, você pode adicionar o IP do usuário
    // 'remoteip' => $_SERVER['REMOTE_ADDR'] 
];

// Montar a query string
$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    ]
];

// Criar o contexto do stream e fazer a requisição
$context  = stream_context_create($options);
$result = file_get_contents($verify_url, false, $context);

// 4. Decodificar e Analisar a Resposta
$response = json_decode($result);

// 5. Verificação e Ação Condicional
if ($response->success) {
    // A validação do reCAPTCHA foi bem-sucedida!
    
    // --- LÓGICA DE PROCESSAMENTO DO FORMULÁRIO AQUI ---
    
    // Exemplo: Capturar outros dados do formulário
    $nome = $_POST['nome'] ?? 'Não informado';
    $email = $_POST['email'] ?? 'Não informado';
    
    // Agora você pode enviar o e-mail, salvar no banco de dados, etc.
    echo "<h1>Sucesso!</h1>";
    echo "<p>Obrigado, {$nome}. Sua mensagem foi recebida e você não é um robô.</p>";
    echo "<p>Email: {$email}</p>";

} else {
    // A validação falhou (pode ser um robô, ou problema na chave, ou expiração do token)
    
    // --- LÓGICA DE ERRO AQUI ---
    
    echo "<h1>Erro na Verificação!</h1>";
    echo "<p>A verificação 'Não sou um robô' falhou. Tente novamente.</p>";
    // O array 'error-codes' pode dar mais detalhes sobre a falha
    // print_r($response->{'error-codes'}); 
}
?>