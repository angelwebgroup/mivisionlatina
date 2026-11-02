<?php
/**
 * MI VISIÓN LATINA - AJAX Job Applicant & Resume Upload Submission Handler
 * Sends notifications to angelwebgroup@gmail.com and stores candidate in database
 */

header('Content-Type: application/json; charset=UTF-8');
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Clean and sanitize inputs
$fullname = trim($_POST['fullname'] ?? filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$email = trim($_POST['email'] ?? filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '');
$phone = trim($_POST['phone'] ?? filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$city_state = trim($_POST['city_state'] ?? filter_input(INPUT_POST, 'city_state', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'Houston, TX');
$category = trim($_POST['category'] ?? filter_input(INPUT_POST, 'category', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'General');
$experience_years = trim($_POST['experience_years'] ?? filter_input(INPUT_POST, 'experience_years', FILTER_SANITIZE_SPECIAL_CHARS) ?? '1-3 años');
$english_level = trim($_POST['english_level'] ?? filter_input(INPUT_POST, 'english_level', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'Básico');
$availability = trim($_POST['availability'] ?? filter_input(INPUT_POST, 'availability', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'Inmediata');
$work_authorization = trim($_POST['work_authorization'] ?? filter_input(INPUT_POST, 'work_authorization', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'Sí');
$notes = trim($_POST['notes'] ?? filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$source_referrer = trim($_POST['source_referrer'] ?? filter_input(INPUT_POST, 'source_referrer', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'Portal Web');
$job_id = (int)($_POST['job_id'] ?? 0);
$job_title = trim($_POST['job_title'] ?? 'Bolsa General');

if (empty($fullname) || empty($phone)) {
    echo json_encode(['success' => false, 'message' => 'Por favor completa al menos tu Nombre y Teléfono de contacto.']);
    exit;
}

// Check uploaded resume file
$resume_file = isset($_FILES['resume_file']) ? $_FILES['resume_file'] : null;

$result = save_candidato([
    'fullname' => $fullname,
    'email' => $email,
    'phone' => $phone,
    'city_state' => $city_state,
    'category' => $category,
    'experience_years' => $experience_years,
    'english_level' => $english_level,
    'availability' => $availability,
    'work_authorization' => $work_authorization,
    'notes' => $notes,
    'source_referrer' => $source_referrer,
    'job_id' => $job_id,
    'job_title' => $job_title
], $resume_file);

echo json_encode($result);
