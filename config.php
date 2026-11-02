<?php
/**
 * MI VISIÓN LATINA - Configuration & Global Constants
 * "Informar · Educar · Conectar · Impulsar oportunidades"
 */

if (!defined('APP_INIT')) {
    define('APP_INIT', true);
}

// Site Meta
define('SITE_NAME', 'MI VISIÓN LATINA');
define('SITE_TAGLINE', 'Informar · Educar · Conectar · Impulsar oportunidades');
define('SITE_DOMAIN', 'mivisionlatina.com');
define('SITE_URL', 'http://localhost/mivisionlatina.com');

// Official Social Links - Facebook
define('FB_LAPLATIK', 'https://www.facebook.com/Laplatik/');
define('FB_ELITE_NOTICIAS', 'https://www.facebook.com/elitenoticias01');
define('FB_PLATICA_CON_LUIS', 'https://www.facebook.com/platicaconluis');
define('FB_MI_VISION_LATINA', 'https://www.facebook.com/Mivisionlatina');
define('FB_TRABAJOS_HOUSTON', 'https://www.facebook.com/trabajosparalatinosenhouston');

// Official Social Links - YouTube
define('YT_PLATICA_CON_LUIS', 'https://www.youtube.com/@Platicaconluis');
define('YT_LAPLATIK', 'https://www.youtube.com/@laplati-k');
define('YT_EDUCADOR_FINANCIERO', 'https://www.youtube.com/@educadorfinancierousa');
define('YT_FINANCIERO_EDUCADOR', 'https://www.youtube.com/@elfinancieroeducador');

// Amazon Author Store
define('AMAZON_STORE_LUIS_BERNAL', 'https://www.amazon.com/stores/Luis-Bernal/author/B01MS9D6H2?ref=ap_rdr&shoppingPortalEnabled=true&ccs_id=26ef6ea4-8abf-4e86-99e9-c30b5b01f260');

// Database Configuration (SQLite default for 100% plug & play portability in XAMPP; MySQL options available)
define('DB_DRIVER', 'sqlite'); // 'sqlite' or 'mysql'
define('DB_SQLITE_PATH', __DIR__ . '/data/trabajo_latino.sqlite');

// Admin credentials for Job Seekers candidate database
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'latina2025'); // Default password for managing candidates

// Live Broadcast Stream Status
// Set to true when host is broadcasting live, or pass ?live=1 in URL
$is_live_query = isset($_GET['live']) && $_GET['live'] == '1';
define('IS_LIVE_BROADCAST', $is_live_query || false);
define('DEFAULT_VIDEO_ID', '2Jg8AxS_IZU'); // Featured recent program from Luis Bernal

// Job Application & Resume Upload Configuration
define('NOTIFY_EMAIL', 'angelwebgroup@gmail.com');
define('UPLOAD_DIR', __DIR__ . '/uploads/resumes/');
define('UPLOAD_URL', 'uploads/resumes/');
define('ALLOWED_RESUME_EXTS', ['pdf', 'doc', 'docx', 'rtf']);
define('MAX_RESUME_SIZE_MB', 10);

/**
 * Send candidate notification email to angelwebgroup@gmail.com
 */
function send_job_application_email($data, $resume_filename = '') {
    $to = NOTIFY_EMAIL;
    $subject = "Nueva Postulación de Empleo: " . ($data['fullname'] ?? 'Candidato') . " - " . ($data['job_title'] ?? 'Trabajo Latino');

    $resume_link = !empty($resume_filename) 
        ? SITE_URL . '/' . UPLOAD_URL . urlencode($resume_filename)
        : 'No adjuntó archivo';

    $message = "
    <html>
    <head>
        <title>Nueva Postulación de Empleo</title>
        <style>
            body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f8fafc; color: #1e293b; padding: 20px; }
            .container { max-width: 600px; margin: 0 auto; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 25px; }
            h2 { color: #0f274a; margin-top: 0; border-bottom: 2px solid #b45309; padding-bottom: 10px; }
            table { width: 100%; border-collapse: collapse; margin-top: 15px; }
            td { padding: 9px 12px; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
            td.label { font-weight: bold; width: 38%; color: #475569; background: #f8fafc; }
            .badge { display: inline-block; background: #eff6ff; color: #1d4ed8; padding: 3px 8px; border-radius: 4px; font-weight: 600; font-size: 13px; }
            .btn { display: inline-block; background: #0f274a; color: #ffffff !important; text-decoration: none; padding: 10px 18px; border-radius: 6px; font-weight: bold; margin-top: 15px; }
            .footer { font-size: 12px; color: #94a3b8; margin-top: 20px; text-align: center; border-top: 1px solid #e2e8f0; padding-top: 15px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>Mi Visión Latina · Nueva Postulación</h2>
            <p>Se ha recibido una nueva solicitud de empleo a través del portal <strong>mivisionlatina.com</strong>:</p>
            <table>
                <tr>
                    <td class='label'>Empleo / Posición:</td>
                    <td><span class='badge'>" . htmlspecialchars($data['job_title'] ?? 'Bolsa General') . "</span></td>
                </tr>
                <tr>
                    <td class='label'>Candidato:</td>
                    <td><strong>" . htmlspecialchars($data['fullname'] ?? '') . "</strong></td>
                </tr>
                <tr>
                    <td class='label'>Teléfono:</td>
                    <td><a href='tel:" . htmlspecialchars($data['phone'] ?? '') . "'>" . htmlspecialchars($data['phone'] ?? '') . "</a></td>
                </tr>
                <tr>
                    <td class='label'>WhatsApp Directo:</td>
                    <td><a href='https://wa.me/" . preg_replace('/[^0-9]/', '', $data['phone'] ?? '') . "'>Abrir Chat</a></td>
                </tr>
                <tr>
                    <td class='label'>Correo Electrónico:</td>
                    <td><a href='mailto:" . htmlspecialchars($data['email'] ?? '') . "'>" . htmlspecialchars($data['email'] ?? '') . "</a></td>
                </tr>
                <tr>
                    <td class='label'>Ciudad y Estado:</td>
                    <td>" . htmlspecialchars($data['city_state'] ?? '') . "</td>
                </tr>
                <tr>
                    <td class='label'>Área / Oficio:</td>
                    <td>" . htmlspecialchars($data['category'] ?? '') . "</td>
                </tr>
                <tr>
                    <td class='label'>Años de Experiencia:</td>
                    <td>" . htmlspecialchars($data['experience_years'] ?? '') . "</td>
                </tr>
                <tr>
                    <td class='label'>Nivel de Inglés:</td>
                    <td>" . htmlspecialchars($data['english_level'] ?? '') . "</td>
                </tr>
                <tr>
                    <td class='label'>Disponibilidad:</td>
                    <td>" . htmlspecialchars($data['availability'] ?? '') . "</td>
                </tr>
                <tr>
                    <td class='label'>Notas del Candidato:</td>
                    <td>" . nl2br(htmlspecialchars($data['notes'] ?? 'Ninguna')) . "</td>
                </tr>
                <tr>
                    <td class='label'>Currículum / CV:</td>
                    <td>" . (!empty($resume_filename) ? "<a href='{$resume_link}' target='_blank'><strong>📄 Descargar Archivo ({$resume_filename})</strong></a>" : 'No adjuntó archivo') . "</td>
                </tr>
                <tr>
                    <td class='label'>Origen:</td>
                    <td>" . htmlspecialchars($data['source_referrer'] ?? 'Web') . "</td>
                </tr>
            </table>

            " . (!empty($resume_filename) ? "<p style='text-align:center;'><a href='{$resume_link}' class='btn' target='_blank'>Ver Currículum Adjunto</a></p>" : '') . "

            <div class='footer'>
                Mensaje generado automáticamente por el portal Mi Visión Latina.<br>
                Panel de Administración: <a href='" . SITE_URL . "/admin_candidatos.php'>" . SITE_URL . "/admin_candidatos.php</a>
            </div>
        </div>
    </body>
    </html>
    ";

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: Mi Vision Latina <no-reply@" . (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'mivisionlatina.com') . ">\r\n";
    $headers .= "Reply-To: " . ($data['email'] ?: NOTIFY_EMAIL) . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Log the notification to text file for audit/backup in XAMPP
    $log_line = "[" . date('Y-m-d H:i:s') . "] Notificación a {$to} para {$data['fullname']} ({$data['job_title']}) - CV: {$resume_filename}\n";
    @file_put_contents(__DIR__ . '/data/email_notifications.log', $log_line, FILE_APPEND);

    // Attempt to send email
    return @mail($to, $subject, $message, $headers);
}

