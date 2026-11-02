<?php
/**
 * MI VISIÓN LATINA - Database Handler (PDO / SQLite)
 * Automated table creation, Job Postings CRUD, Applicant Resumes & Email Dispatch
 */

require_once __DIR__ . '/config.php';

function get_db_connection() {
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    try {
        if (DB_DRIVER === 'sqlite') {
            $dir = dirname(DB_SQLITE_PATH);
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            $pdo = new PDO('sqlite:' . DB_SQLITE_PATH);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            // 1. Table for Job Candidates / Applications
            $pdo->exec("CREATE TABLE IF NOT EXISTS candidatos_empleo (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                fullname TEXT NOT NULL,
                email TEXT NOT NULL,
                phone TEXT NOT NULL,
                city_state TEXT NOT NULL,
                category TEXT NOT NULL,
                experience_years TEXT,
                english_level TEXT,
                availability TEXT,
                work_authorization TEXT,
                notes TEXT,
                source_referrer TEXT DEFAULT 'Web',
                job_id INTEGER DEFAULT 0,
                job_title TEXT DEFAULT 'Bolsa General',
                resume_path TEXT DEFAULT '',
                status TEXT DEFAULT 'Nuevo',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )");

            // Ensure columns exist if table was created previously without them
            $columns_to_check = [
                'job_id' => 'INTEGER DEFAULT 0',
                'job_title' => "TEXT DEFAULT 'Bolsa General'",
                'resume_path' => "TEXT DEFAULT ''"
            ];
            foreach ($columns_to_check as $col => $def) {
                try {
                    $pdo->exec("ALTER TABLE candidatos_empleo ADD COLUMN {$col} {$def}");
                } catch (Exception $e) {
                    // Column already exists, safe to ignore
                }
            }

            // 2. Table for Job Postings (Ofertas de Empleo publicadas por el Admin)
            $pdo->exec("CREATE TABLE IF NOT EXISTS empleos_publicados (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                company TEXT NOT NULL DEFAULT 'Empresa Confidencial',
                category TEXT NOT NULL,
                location TEXT NOT NULL DEFAULT 'Houston, TX',
                salary TEXT,
                job_type TEXT DEFAULT 'Tiempo Completo',
                description TEXT NOT NULL,
                requirements TEXT,
                status TEXT DEFAULT 'Activo',
                expires_at DATE DEFAULT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )");

            // Upgrade schema if expires_at does not exist
            try {
                $pdo->exec("ALTER TABLE empleos_publicados ADD COLUMN expires_at DATE DEFAULT NULL");
            } catch (Exception $e) {
                // Column already exists
            }

            // Set default expiration date for legacy jobs without one (+30 days)
            try {
                $pdo->exec("UPDATE empleos_publicados SET expires_at = date('now', '+30 days') WHERE expires_at IS NULL OR expires_at = ''");
            } catch (Exception $e) {
                // Ignore if update fails
            }

            // Seed initial realistic job postings if table is empty
            $count_jobs = $pdo->query("SELECT COUNT(*) FROM empleos_publicados")->fetchColumn();
            if ($count_jobs == 0) {
                seed_initial_jobs($pdo);
            }
        }
        return $pdo;
    } catch (PDOException $e) {
        error_log("Database connection error: " . $e->getMessage());
        return null;
    }
}

/**
 * Seed initial sample job offers for Houston area
 */
function seed_initial_jobs($pdo) {
    $initial_jobs = [
        [
            'title' => 'Maestro / Oficial de Remodelación y Framing',
            'company' => 'Constructora Houston Heights LLC',
            'category' => 'Construcción / Remodelación',
            'location' => 'Houston, TX (Northside / Galleria)',
            'salary' => '$22 - $28 / hora según experiencia',
            'job_type' => 'Tiempo Completo',
            'description' => 'Buscamos oficiales con experiencia comprobada en carpintería, framing de madera/metal, colocación de sheetrock y pintura. Trabajo continuo de lunes a viernes con pago semanal.',
            'requirements' => 'Mínimo 2 años de experiencia en remodelación. Herramientas básicas de mano propias. Transporte confiable. Se valora hablar español e inglés básico.',
            'status' => 'Activo'
        ],
        [
            'title' => 'Personal de Limpieza de Casas y Oficinas (Equipos)',
            'company' => 'Limpieza Total Services',
            'category' => 'Limpieza Residencial / Comercial',
            'location' => 'Katy y Sugar Land, TX',
            'salary' => '$16 - $19 / hora + Propinas',
            'job_type' => 'Tiempo Completo / Medio Tiempo',
            'description' => 'Contratación inmediata para limpieza residencial y comercial. Rutas organizadas en áreas residenciales de Katy, Richmond y Sugar Land. Excelente ambiente de trabajo.',
            'requirements' => 'Disponibilidad de lunes a sábado. Actitud puntual y honesta. No se requiere inglés avanzado. Capacitación pagada incluida.',
            'status' => 'Activo'
        ],
        [
            'title' => 'Cocinero de Línea y Preparador de Alimentos',
            'company' => 'Restaurante & Grill Latino',
            'category' => 'Restaurante / Cocina / Mesero',
            'location' => 'Houston, TX (Southwest / Bellaire)',
            'salary' => '$17 - $21 / hora + Bonos',
            'job_type' => 'Tiempo Completo',
            'description' => 'Restaurante familiar en constante crecimiento solicita cocinero de línea para turno matutino y vespertino. Manejo de plancha, freidoras y cortes de carnes.',
            'requirements' => '1 año de experiencia en cocina caliente. Certificación Food Handler (o disponibilidad para tramitarla). Trabajo en equipo y rapidez.',
            'status' => 'Activo'
        ],
        [
            'title' => 'Chofer con Licencia Comercial CDL Clase A',
            'company' => 'Logística Latina Transport',
            'category' => 'Chofer / Delivery / Transporte',
            'location' => 'Houston, TX (Pasadena / Puerto)',
            'salary' => '$1,400 - $1,900 / semana',
            'job_type' => 'Tiempo Completo',
            'description' => 'Rutas regionales en Texas y estados vecinos. Camiones modernos con mantenimiento al día. Pagos puntuales directos cada viernes.',
            'requirements' => 'Licencia CDL Clase A vigente. Récord de manejo limpio (MVR). Mínimo 1 año de experiencia con camión de carga articulado. Examen médico DOT vigente.',
            'status' => 'Activo'
        ],
        [
            'title' => 'Técnico Instalador de HVAC / Aire Acondicionado',
            'company' => 'Climas & Servicios Residenciales',
            'category' => 'Electricidad / Plomería / HVAC',
            'location' => 'Houston, TX (Área Metropolitana)',
            'salary' => '$24 - $32 / hora + Horas Extra',
            'job_type' => 'Tiempo Completo',
            'description' => 'Instalación, diagnóstico y mantenimiento de unidades de aire acondicionado residenciales y comerciales ligeros en época de alta demanda.',
            'requirements' => 'Certificación EPA Universal preferida. Mínimo 2 años en diagnóstico de fallas y ductos. Licencia de conducir válida de Texas.',
            'status' => 'Activo'
        ]
    ];

    $stmt = $pdo->prepare("INSERT INTO empleos_publicados (title, company, category, location, salary, job_type, description, requirements, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    foreach ($initial_jobs as $j) {
        $stmt->execute([$j['title'], $j['company'], $j['category'], $j['location'], $j['salary'], $j['job_type'], $j['description'], $j['requirements'], $j['status']]);
    }
}

/* ==========================================================================
   JOB POSTINGS (EMPLEOS PUBLICADOS) - CRUD FUNCTIONS
   ========================================================================== */

function is_job_expired($job) {
    if (empty($job) || empty($job['expires_at'])) {
        return false;
    }
    return strtotime($job['expires_at'] . ' 23:59:59') < time();
}

function get_job_days_left($job) {
    if (empty($job) || empty($job['expires_at'])) {
        return null;
    }
    $target = strtotime($job['expires_at'] . ' 23:59:59');
    $diff = $target - time();
    return (int)ceil($diff / 86400);
}

function get_jobs($category = '', $search = '', $status = 'Activo') {
    $db = get_db_connection();
    if (!$db) return [];

    $sql = "SELECT * FROM empleos_publicados WHERE 1=1";
    $params = [];

    if ($status === 'Activo') {
        // Active and NOT expired
        $sql .= " AND status = 'Activo' AND (expires_at IS NULL OR expires_at = '' OR expires_at >= date('now'))";
    } elseif ($status === 'Inactivo' || $status === 'Cerrado') {
        $sql .= " AND (status = 'Inactivo' OR status = 'Cerrado')";
    } elseif ($status === 'Expirado') {
        $sql .= " AND expires_at IS NOT NULL AND expires_at != '' AND expires_at < date('now')";
    } elseif (!empty($status) && $status !== 'all') {
        $sql .= " AND status = ?";
        $params[] = $status;
    }

    if (!empty($category)) {
        $sql .= " AND category = ?";
        $params[] = $category;
    }

    if (!empty($search)) {
        $sql .= " AND (title LIKE ? OR company LIKE ? OR location LIKE ? OR description LIKE ?)";
        $term = "%{$search}%";
        $params[] = $term;
        $params[] = $term;
        $params[] = $term;
        $params[] = $term;
    }

    $sql .= " ORDER BY id DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function get_job_by_id($id) {
    $db = get_db_connection();
    if (!$db) return null;

    $stmt = $db->prepare("SELECT * FROM empleos_publicados WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function save_job($data) {
    $db = get_db_connection();
    if (!$db) return ['success' => false, 'message' => 'Error de conexión a la base de datos'];

    $id = (int)($data['id'] ?? 0);
    $title = trim($data['title'] ?? '');
    $company = trim($data['company'] ?? 'Empresa Confidencial') ?: 'Empresa Confidencial';
    $category = trim($data['category'] ?? 'General') ?: 'General';
    $location = trim($data['location'] ?? 'Houston, TX') ?: 'Houston, TX';
    $salary = trim($data['salary'] ?? '');
    $job_type = trim($data['job_type'] ?? 'Tiempo Completo');
    $description = trim($data['description'] ?? '');
    $requirements = trim($data['requirements'] ?? '');
    $status = trim($data['status'] ?? 'Activo');

    // Process expiration date
    $expires_at = !empty($data['expires_at']) ? trim($data['expires_at']) : null;
    if ($expires_at && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $expires_at)) {
        $expires_at = null;
    }

    if (empty($title) || empty($description)) {
        return ['success' => false, 'message' => 'El título y la descripción del empleo son obligatorios.'];
    }

    try {
        if ($id > 0) {
            // Update existing job
            $stmt = $db->prepare("UPDATE empleos_publicados SET title = ?, company = ?, category = ?, location = ?, salary = ?, job_type = ?, description = ?, requirements = ?, status = ?, expires_at = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
            $stmt->execute([$title, $company, $category, $location, $salary, $job_type, $description, $requirements, $status, $expires_at, $id]);
            return ['success' => true, 'id' => $id, 'message' => 'Empleo actualizado con éxito.'];
        } else {
            // Insert new job (default to 30 days if not set)
            if (empty($expires_at)) {
                $expires_at = date('Y-m-d', strtotime('+30 days'));
            }
            $stmt = $db->prepare("INSERT INTO empleos_publicados (title, company, category, location, salary, job_type, description, requirements, status, expires_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $company, $category, $location, $salary, $job_type, $description, $requirements, $status, $expires_at]);
            return ['success' => true, 'id' => $db->lastInsertId(), 'message' => 'Nuevo empleo publicado exitosamente.'];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error al guardar empleo: ' . $e->getMessage()];
    }
}

function delete_job($id) {
    $db = get_db_connection();
    if (!$db) return false;

    $stmt = $db->prepare("DELETE FROM empleos_publicados WHERE id = ?");
    return $stmt->execute([$id]);
}

function toggle_job_status($id) {
    $db = get_db_connection();
    if (!$db) return false;

    $job = get_job_by_id($id);
    if (!$job) return false;

    $new_status = ($job['status'] === 'Activo') ? 'Inactivo' : 'Activo';

    // If activating an expired job, auto-extend by 30 days so it shows in frontend
    if ($new_status === 'Activo' && is_job_expired($job)) {
        $new_exp = date('Y-m-d', strtotime('+30 days'));
        $stmt = $db->prepare("UPDATE empleos_publicados SET status = ?, expires_at = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        return $stmt->execute([$new_status, $new_exp, $id]);
    }

    $stmt = $db->prepare("UPDATE empleos_publicados SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
    return $stmt->execute([$new_status, $id]);
}

function extend_job_expiration($id, $days = 30) {
    $db = get_db_connection();
    if (!$db) return false;

    $job = get_job_by_id($id);
    if (!$job) return false;

    $base_time = (!empty($job['expires_at']) && strtotime($job['expires_at']) > time()) 
        ? strtotime($job['expires_at']) 
        : time();
    $new_date = date('Y-m-d', strtotime("+{$days} days", $base_time));

    $stmt = $db->prepare("UPDATE empleos_publicados SET expires_at = ?, status = 'Activo', updated_at = CURRENT_TIMESTAMP WHERE id = ?");
    return $stmt->execute([$new_date, $id]);
}

/* ==========================================================================
   CANDIDATE APPLICATIONS & RESUME UPLOADS
   ========================================================================== */

function save_candidato($data, $file = null) {
    $db = get_db_connection();
    if (!$db) {
        return ['success' => false, 'message' => 'Error de conexión a la base de datos'];
    }

    $fullname = trim($data['fullname'] ?? '');
    $email = trim($data['email'] ?? '');
    $phone = trim($data['phone'] ?? '');
    $city_state = trim($data['city_state'] ?? 'Houston, TX') ?: 'Houston, TX';
    $category = trim($data['category'] ?? 'General') ?: 'General';
    $experience_years = trim($data['experience_years'] ?? '1-3 años');
    $english_level = trim($data['english_level'] ?? 'Básico');
    $availability = trim($data['availability'] ?? 'Inmediata');
    $work_authorization = trim($data['work_authorization'] ?? 'Sí');
    $notes = trim($data['notes'] ?? '');
    $source_referrer = trim($data['source_referrer'] ?? 'Portal Web');
    $job_id = (int)($data['job_id'] ?? 0);
    $job_title = trim($data['job_title'] ?? 'Bolsa General') ?: 'Bolsa General';

    if (empty($fullname) || empty($phone)) {
        return ['success' => false, 'message' => 'Por favor completa al menos tu Nombre y Teléfono.'];
    }

    // Handle Resume Upload (.doc, .docx, .pdf, .rtf)
    $resume_filename = '';
    if ($file && isset($file['name']) && !empty($file['name']) && $file['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ALLOWED_RESUME_EXTS)) {
            return ['success' => false, 'message' => 'Formato de currículum no válido. Solo se admiten archivos PDF, DOC, DOCX o RTF.'];
        }

        // Check file size (max 10MB)
        if ($file['size'] > (MAX_RESUME_SIZE_MB * 1024 * 1024)) {
            return ['success' => false, 'message' => 'El archivo supera el tamaño máximo permitido de ' . MAX_RESUME_SIZE_MB . 'MB.'];
        }

        $clean_name = preg_replace('/[^a-zA-Z0-9_\-]/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
        $resume_filename = time() . '_' . substr($clean_name, 0, 30) . '.' . $ext;
        $dest_path = UPLOAD_DIR . $resume_filename;

        if (!move_uploaded_file($file['tmp_name'], $dest_path)) {
            return ['success' => false, 'message' => 'No se pudo guardar el archivo adjunto. Intenta de nuevo.'];
        }
    }

    try {
        $stmt = $db->prepare("INSERT INTO candidatos_empleo 
            (fullname, email, phone, city_state, category, experience_years, english_level, availability, work_authorization, notes, source_referrer, job_id, job_title, resume_path)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $fullname,
            $email,
            $phone,
            $city_state,
            $category,
            $experience_years,
            $english_level,
            $availability,
            $work_authorization,
            $notes,
            $source_referrer,
            $job_id,
            $job_title,
            $resume_filename
        ]);

        $candidate_id = $db->lastInsertId();

        // Dispatch Email Notification to angelwebgroup@gmail.com
        send_job_application_email([
            'id' => $candidate_id,
            'fullname' => $fullname,
            'email' => $email,
            'phone' => $phone,
            'city_state' => $city_state,
            'category' => $category,
            'experience_years' => $experience_years,
            'english_level' => $english_level,
            'availability' => $availability,
            'notes' => $notes,
            'source_referrer' => $source_referrer,
            'job_title' => $job_title
        ], $resume_filename);

        return [
            'success' => true,
            'id' => $candidate_id,
            'resume_file' => $resume_filename,
            'message' => '¡Postulación enviada exitosamente! Tus datos y currículum han sido guardados y notificados al equipo de reclutamiento.'
        ];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error al registrar candidato: ' . $e->getMessage()];
    }
}

function get_candidatos($category = '', $search = '', $job_id = 0) {
    $db = get_db_connection();
    if (!$db) return [];

    $sql = "SELECT * FROM candidatos_empleo WHERE 1=1";
    $params = [];

    if (!empty($category)) {
        $sql .= " AND category = ?";
        $params[] = $category;
    }

    if ($job_id > 0) {
        $sql .= " AND job_id = ?";
        $params[] = $job_id;
    }

    if (!empty($search)) {
        $sql .= " AND (fullname LIKE ? OR phone LIKE ? OR city_state LIKE ? OR email LIKE ? OR job_title LIKE ?)";
        $searchParam = "%$search%";
        $params[] = $searchParam;
        $params[] = $searchParam;
        $params[] = $searchParam;
        $params[] = $searchParam;
        $params[] = $searchParam;
    }

    $sql .= " ORDER BY id DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function get_candidato_stats() {
    $db = get_db_connection();
    if (!$db) return ['total' => 0, 'nuevos' => 0, 'jobs_count' => 0];

    try {
        $total = $db->query("SELECT COUNT(*) FROM candidatos_empleo")->fetchColumn();
        $nuevos = $db->query("SELECT COUNT(*) FROM candidatos_empleo WHERE status = 'Nuevo'")->fetchColumn();
        $jobs_count = $db->query("SELECT COUNT(*) FROM empleos_publicados WHERE status = 'Activo'")->fetchColumn();
        return [
            'total' => (int)$total,
            'nuevos' => (int)$nuevos,
            'jobs_count' => (int)$jobs_count
        ];
    } catch (Exception $e) {
        return ['total' => 0, 'nuevos' => 0, 'jobs_count' => 0];
    }
}
