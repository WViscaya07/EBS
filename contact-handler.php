<?php
// contact-handler.php con COLORES DEL LOGO EBS
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Solo permitir método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Verificar honeypot para prevenir spam
if (isset($_POST['botcheck']) && $_POST['botcheck'] == true) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Spam detectado']);
    exit;
}

// Obtener y limpiar datos del formulario
$name = isset($_POST['name']) ? trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING)) : '';
$email = isset($_POST['email']) ? trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)) : '';
$phone = isset($_POST['phone']) ? trim(filter_var($_POST['phone'], FILTER_SANITIZE_STRING)) : '';
$message = isset($_POST['message']) ? trim(filter_var($_POST['message'], FILTER_SANITIZE_STRING)) : '';

// Validar campos obligatorios
if (empty($name) || empty($email) || empty($phone) || empty($message)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
    exit;
}

// Validar email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'El email no tiene un formato válido']);
    exit;
}

// Configuración del email
$to = 'servicioalcliente@ebscr.net'; // CAMBIAR aquí tu email
$subject = '🏢 Nuevo contacto desde EBS Website - ' . $name;

// Email con COLORES DEL LOGO EBS
$email_content = "
<html>
<head>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            line-height: 1.6; 
            color: #333; 
            max-width: 600px;
            margin: 0 auto;
            background-color: #f8fafc;
        }
        .container {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
        }
        .header { 
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white; 
            padding: 30px 25px; 
            text-align: center; 
        }
        .header h2 {
            margin: 0;
            font-size: 26px;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        .header p {
            margin: 8px 0 0 0; 
            opacity: 0.95;
            font-size: 16px;
        }
        .content { 
            padding: 30px 25px; 
        }
        .field { 
            margin-bottom: 25px; 
            padding: 20px;
            background-color: #f8fafc;
            border-radius: 10px;
            border-left: 5px solid #1e3a8a;
            position: relative;
        }
        .label { 
            font-weight: 700; 
            color: #1e3a8a; 
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .value {
            color: #1f2937;
            font-size: 16px;
            line-height: 1.5;
        }
        .message-field {
            background-color: #eff6ff;
            border-left-color: #3b82f6;
        }
        .message-field .label {
            color: #3b82f6;
        }
        .priority {
            display: inline-block;
            background: linear-gradient(45deg, #f59e0b, #ec4899);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(245,158,11,0.3);
        }
        .contact-actions {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            margin: 30px -25px -30px -25px;
            padding: 25px;
            text-align: center;
        }
        .contact-btn {
            display: inline-block;
            background: linear-gradient(135deg, #f59e0b, #ec4899);
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 700;
            margin: 0 8px 8px 0;
            box-shadow: 0 4px 15px rgba(245,158,11,0.3);
            transition: transform 0.2s ease;
        }
        .contact-btn:hover {
            transform: translateY(-2px);
        }
        .footer {
            background-color: #1f2937;
            color: #d1d5db;
            padding: 20px 25px;
            text-align: center;
            font-size: 13px;
            margin: 30px -25px -30px -25px;
        }
        .footer strong {
            color: #f59e0b;
        }
        .metadata {
            background-color: #f1f5f9;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 12px;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h2>🏢 EBS - Effective Business Solutions</h2>
            <p>Nuevo mensaje desde el sitio web</p>
        </div>
        <div class='content'>
            <div class='priority'>⚡ NUEVO CONTACTO COMERCIAL</div>
            
            <div class='field'>
                <span class='label'>👤 Nombre completo</span>
                <div class='value'>$name</div>
            </div>
            
            <div class='field'>
                <span class='label'>📧 Correo electrónico</span>
                <div class='value'>
                    <a href='mailto:$email' style='color: #3b82f6; text-decoration: none;'>$email</a>
                </div>
            </div>
            
            <div class='field'>
                <span class='label'>📱 Teléfono</span>
                <div class='value'>
                    <a href='tel:$phone' style='color: #10b981; text-decoration: none;'>$phone</a>
                </div>
            </div>
            
            <div class='field message-field'>
                <span class='label'>💬 Mensaje del cliente</span>
                <div class='value'>" . nl2br(htmlspecialchars($message)) . "</div>
            </div>
            
            <div class='contact-actions'>
                <a href='mailto:$email' class='contact-btn'>✉️ Responder Email</a>
                <a href='tel:$phone' class='contact-btn'>📞 Llamar Ahora</a>
            </div>
            
            <div class='metadata'>
                <strong>📅 Recibido:</strong> " . date('d/m/Y H:i:s') . " (Costa Rica)<br>
                <strong>🌐 Sitio web:</strong> " . $_SERVER['HTTP_HOST'] . "<br>
                <strong>📍 IP Cliente:</strong> " . $_SERVER['REMOTE_ADDR'] . "
            </div>
        </div>
        <div class='footer'>
            <p><strong>EBS - Effective Business Solutions</strong><br>
            Sistema automático de contacto web<br>
            <small>Moving your business forward.</small></p>
        </div>
    </div>
</body>
</html>";

// Headers del email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: EBS - Effective Business Solutions <info@ebscr.net>" . "\r\n";
$headers .= "Reply-To: $email" . "\r\n";
$headers .= "Return-Path: info@ebscr.net" . "\r\n";
$headers .= "Message-ID: <" . time() . rand(1000,9999) . "@ebscr.net>" . "\r\n";
$headers .= "X-Mailer: EBS-Website-v2.0" . "\r\n";
$headers .= "List-Unsubscribe: <mailto:info@ebscr.net>" . "\r\n";
$headers .= "X-Priority: 3";

// Enviar email principal
if (mail($to, $subject, $email_content, $headers)) {
    
    // Email de confirmación al cliente con COLORES EBS
    $client_subject = "✅ Mensaje recibido - EBS te contactará pronto";
    $client_message = "
    <html>
    <head>
        <style>
            body { font-family: 'Segoe UI', sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; background: #f8fafc; padding: 20px; }
            .container { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
            .header { background: linear-gradient(135deg, #1e3a8a, #3b82f6); color: white; padding: 30px 25px; text-align: center; }
            .content { padding: 30px 25px; }
            .success-badge { background: linear-gradient(45deg, #10b981, #059669); color: white; padding: 12px 24px; border-radius: 25px; display: inline-block; margin-bottom: 20px; font-weight: 700; }
            .message-box { background: #eff6ff; padding: 20px; border-radius: 10px; border-left: 5px solid #3b82f6; margin: 20px 0; }
            .contact-info { background: #f8fafc; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 5px solid #1e3a8a; }
            .footer { background: #1f2937; color: white; padding: 20px; text-align: center; margin: 30px -25px -30px -25px; }
            .highlight { color: #1e3a8a; font-weight: 700; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>¡Gracias por contactarnos!</h1>
                <p>EBS - Effective Business Solutions</p>
            </div>
            <div class='content'>
                <div class='success-badge'>✅ MENSAJE RECIBIDO EXITOSAMENTE</div>
                
                <p>Estimado/a <strong class='highlight'>$name</strong>,</p>
                
                <p>Hemos recibido tu mensaje y agradecemos tu interés en nuestros servicios de <strong>displays, gráficas, impulsación y rotulación</strong>.</p>
                
                <div class='message-box'>
                    <strong>📝 Tu mensaje:</strong><br>
                    <em>" . nl2br(htmlspecialchars($message)) . "</em>
                </div>
                
                <h3 style='color: #1e3a8a;'>⏰ ¿Qué sigue?</h3>
                <ul style='line-height: 2;'>
                    <li><strong>Tiempo de respuesta:</strong> 2-6 horas hábiles</li>
                    <li><strong>Contacto inicial:</strong> Por email o teléfono</li>
                    <li><strong>Propuesta:</strong> Personalizada según tus necesidades</li>
                </ul>
                
                <div class='contact-info'>
                    <h3 style='color: #1e3a8a; margin-top: 0;'>📞 ¿Necesitas respuesta inmediata?</h3>
                    <p><strong>Teléfono:</strong> <a href='tel:+50622712381' style='color: #10b981;'>+506 2271 2381</a></p>
                    <p><strong>Email:</strong> <a href='mailto:info@ebscr.net' style='color: #3b82f6;'>info@ebscr.net</a></p>
                    <p><strong>Ubicación:</strong> 100m este y 200m sur del Banco Nacional, Curridabat, Costa Rica</p>
                    <p><strong>Horario:</strong> Lunes a Viernes, 8:00 AM - 5:00 PM</p>
                </div>
                
                <p style='margin-top: 30px;'>Saludos cordiales,<br>
                <strong style='color: #1e3a8a;'>Equipo EBS</strong><br>
                <em>Moving your business forward.</em></p>
            </div>
            <div class='footer'>
                <p style='margin: 0; font-size: 12px;'>© 2025 EBS - Effective Business Solutions<br>
                <a href='https://www.ebscr.net' style='color: #f59e0b;'>www.ebscr.net</a></p>
            </div>
        </div>
    </body>
    </html>";
    
    $client_headers = "MIME-Version: 1.0" . "\r\n";
    $client_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $client_headers .= "From: EBS - Effective Business Solutions <info@ebscr.net>" . "\r\n";
    $client_headers .= "Message-ID: <" . time() . rand(1000,9999) . ".confirm@ebscr.net>" . "\r\n";
    
    // Enviar confirmación al cliente
    mail($email, $client_subject, $client_message, $client_headers);
    
    // Respuesta exitosa
    echo json_encode([
        'success' => true, 
        'message' => 'Mensaje enviado correctamente. Te contactaremos pronto.'
    ]);
    
} else {
    // Error al enviar
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Error al enviar el mensaje. Inténtalo de nuevo o contáctanos al +506 2271 2381.'
    ]);
}
?>