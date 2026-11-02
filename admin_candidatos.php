<?php
/**
 * MI VISIÓN LATINA - Panel Administrativo: Gestión de Empleos y Candidatos
 * Trabajo Latino - Publicación y Edición de Vacantes, Consulta de Candidatos, Carga de CVs y Exportación CSV
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

// Authentication handling
$auth_error = '';
if (isset($_POST['login'])) {
    $u = trim($_POST['username'] ?? '');
    $p = trim($_POST['password'] ?? '');
    if ($u === ADMIN_USER && $p === ADMIN_PASS) {
        $_SESSION['admin_logged'] = true;
    } else {
        $auth_error = 'Usuario o contraseña incorrectos.';
    }
}

if (isset($_GET['logout'])) {
    unset($_SESSION['admin_logged']);
    session_destroy();
    header('Location: admin_candidatos.php');
    exit;
}

$is_logged = isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true;

// Flash messages
$flash_msg = '';
$flash_type = 'success';

// Handle Actions if logged in
if ($is_logged) {

    // 1. CSV Export
    if (isset($_GET['action']) && $_GET['action'] === 'export_csv') {
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="candidatos_trabajo_latino_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        // UTF-8 BOM for Excel
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, ['ID', 'Nombre Completo', 'Email', 'Teléfono', 'Ciudad / Estado', 'Área / Profesión', 'Experiencia', 'Nivel de Inglés', 'Disponibilidad', 'Vacante Aplicada', 'Archivo CV', 'Notas / Perfil', 'Origen', 'Fecha de Registro', 'Estado']);
        
        $candidates = get_candidatos();
        foreach ($candidates as $row) {
            $resume_url = !empty($row['resume_path']) ? SITE_URL . '/uploads/resumes/' . $row['resume_path'] : 'Sin archivo';
            fputcsv($output, [
                $row['id'],
                $row['fullname'],
                $row['email'],
                $row['phone'],
                $row['city_state'],
                $row['category'],
                $row['experience_years'],
                $row['english_level'],
                $row['availability'],
                $row['job_title'] ?? 'Bolsa General',
                $resume_url,
                $row['notes'],
                $row['source_referrer'],
                $row['created_at'],
                $row['status']
            ]);
        }
        fclose($output);
        exit;
    }

    // 2. Save / Edit Job Posting
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_job_action'])) {
        $result = save_job($_POST);
        if ($result['success']) {
            $flash_msg = $result['message'];
            $flash_type = 'success';
            // Redirect to jobs list after saving
            header('Location: admin_candidatos.php?tab=jobs&msg=job_saved');
            exit;
        } else {
            $flash_msg = $result['message'];
            $flash_type = 'error';
        }
    }

    // 3. Toggle Job Status (Activo / Inactivo)
    if (isset($_GET['action']) && $_GET['action'] === 'toggle_job' && isset($_GET['id'])) {
        $job_id = (int)$_GET['id'];
        toggle_job_status($job_id);
        header('Location: admin_candidatos.php?tab=jobs&msg=status_updated');
        exit;
    }

    // 4. Extend Job Expiration (+30 days)
    if (isset($_GET['action']) && $_GET['action'] === 'extend_job' && isset($_GET['id'])) {
        $job_id = (int)$_GET['id'];
        extend_job_expiration($job_id, 30);
        header('Location: admin_candidatos.php?tab=jobs&msg=job_extended');
        exit;
    }

    // 5. Delete Job Posting
    if (isset($_GET['action']) && $_GET['action'] === 'delete_job' && isset($_GET['id'])) {
        $job_id = (int)$_GET['id'];
        delete_job($job_id);
        header('Location: admin_candidatos.php?tab=jobs&msg=job_deleted');
        exit;
    }
}

// Active Tab
$active_tab = $_GET['tab'] ?? 'jobs'; // 'jobs', 'post_job', 'candidates', 'email'
if ($active_tab === 'new_job') {
    $active_tab = 'post_job';
}

if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'status_updated') $flash_msg = 'Estado de la vacante actualizado correctamente.';
    if ($_GET['msg'] === 'job_saved') $flash_msg = 'La oferta de empleo ha sido guardada y actualizada con éxito.';
    if ($_GET['msg'] === 'job_extended') $flash_msg = 'Vigencia de la vacante extendida por 30 días adicionales.';
    if ($_GET['msg'] === 'job_deleted') $flash_msg = 'La vacante ha sido eliminada permanentemente.';
}

// Search & Filter for candidates
$search = trim($_GET['search'] ?? '');
$category = trim($_GET['category'] ?? '');
$candidates = $is_logged ? get_candidatos($category, $search) : [];

// Jobs filter for tab=jobs
$job_status_filter = $_GET['status_filter'] ?? 'all';
$job_search = trim($_GET['job_q'] ?? '');

$all_jobs = $is_logged ? get_jobs('', $job_search, 'all') : [];
$stats = get_candidato_stats();

// Compute job counts by status
$count_active = 0;
$count_inactive = 0;
$count_expired = 0;
foreach ($all_jobs as $j) {
    if (is_job_expired($j)) {
        $count_expired++;
    } elseif ($j['status'] !== 'Activo') {
        $count_inactive++;
    } else {
        $count_active++;
    }
}

// Filtered list according to job_status_filter
$displayed_jobs = [];
foreach ($all_jobs as $j) {
    $expired = is_job_expired($j);
    if ($job_status_filter === 'active' && (!$expired && $j['status'] === 'Activo')) {
        $displayed_jobs[] = $j;
    } elseif ($job_status_filter === 'inactive' && ($j['status'] !== 'Activo')) {
        $displayed_jobs[] = $j;
    } elseif ($job_status_filter === 'expired' && $expired) {
        $displayed_jobs[] = $j;
    } elseif ($job_status_filter === 'all') {
        $displayed_jobs[] = $j;
    }
}

// Check if editing a specific job
$editing_job = null;
if ($is_logged && isset($_GET['edit_job_id'])) {
    $editing_job = get_job_by_id((int)$_GET['edit_job_id']);
    $active_tab = 'post_job';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo · Bolsa de Empleo | Mi Visión Latina</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" type="image/png" href="images/logo-mivisionlatina.png">
    <style>
        html {
            overflow-y: scroll;
            scrollbar-gutter: stable;
        }
        .admin-page {
            background-color: #f8fafc;
            color: #0f172a;
            min-height: 100vh;
            padding: 40px 0 80px;
            font-family: 'Inter', sans-serif;
        }
        .admin-container {
            width: 100%;
            max-width: var(--container-max, 1240px);
            margin: 0 auto;
            padding: 0 24px;
            box-sizing: border-box;
        }
        .admin-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
            margin-bottom: 24px;
        }

        /* Stable Tab Panes */
        .admin-tab-pane {
            display: none;
        }
        .admin-tab-pane.active {
            display: block;
        }

        /* Modern Tabs Navigation Bar - Completely Stable & Flutter-Free */
        .admin-tabs-bar {
            display: flex;
            align-items: center;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 6px;
            gap: 6px;
            margin-bottom: 24px;
            overflow-x: auto;
            box-shadow: 0 2px 4px rgba(15, 23, 42, 0.03);
        }
        .admin-tab-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 600;
            color: #64748b;
            background: transparent;
            border: 1px solid transparent;
            text-decoration: none;
            transition: background 0.15s ease, color 0.15s ease;
            white-space: nowrap;
            cursor: pointer;
            font-family: inherit;
            user-select: none;
            box-sizing: border-box;
        }
        .admin-tab-btn:hover {
            color: #0f274a;
            background: #f1f5f9;
        }
        .admin-tab-btn.active {
            background: #0f274a;
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(15, 39, 74, 0.2);
        }
        .tab-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            padding: 2px 8px;
            border-radius: 9999px;
            font-weight: 700;
            background: #e2e8f0;
            color: #334155;
            transition: background 0.15s ease, color 0.15s ease;
        }
        .admin-tab-btn.active .tab-badge {
            background: rgba(255, 255, 255, 0.25);
            color: #ffffff;
        }
        .tab-badge-accent {
            background: #dbeafe;
            color: #1e40af;
        }

        /* Table & Action Elements */
        .table-responsive {
            overflow-x: auto;
        }
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.86rem;
        }
        .admin-table th {
            background: #f8fafc;
            color: #0f274a;
            font-weight: 700;
            padding: 12px 14px;
            text-align: left;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }
        .admin-table td {
            padding: 13px 14px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            vertical-align: middle;
        }
        .admin-table tr:hover {
            background: #fbfcfe;
        }

        /* Status & Category Pills */
        .badge-cat {
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.72rem;
            display: inline-block;
        }
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 9px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
        }
        .badge-status.active {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .badge-status.inactive {
            background: #f1f5f9;
            color: #64748b;
            border: 1px solid #cbd5e1;
        }
        .badge-status.expired {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .pulse-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: inline-block;
        }
        .pulse-dot.green {
            background: #10b981;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
        }
        .pulse-dot.gray {
            background: #94a3b8;
        }
        .pulse-dot.red {
            background: #ef4444;
        }

        /* Action Buttons */
        .btn-action-group {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            flex-wrap: nowrap;
        }
        .btn-act {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.78rem;
            font-weight: 600;
            padding: 5px 9px;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.2s;
            border: 1px solid transparent;
            cursor: pointer;
            white-space: nowrap;
        }
        .btn-act-edit {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }
        .btn-act-edit:hover {
            background: #dbeafe;
        }
        .btn-act-toggle-off {
            background: #fef2f2;
            color: #b91c1c;
            border-color: #fecaca;
        }
        .btn-act-toggle-off:hover {
            background: #fee2e2;
        }
        .btn-act-toggle-on {
            background: #ecfdf5;
            color: #047857;
            border-color: #a7f3d0;
        }
        .btn-act-toggle-on:hover {
            background: #d1fae5;
        }
        .btn-act-extend {
            background: #f0fdf4;
            color: #15803d;
            border-color: #bbf7d0;
        }
        .btn-act-extend:hover {
            background: #dcfce7;
        }
        .btn-act-view {
            background: #f8fafc;
            color: #334155;
            border-color: #cbd5e1;
        }
        .btn-act-view:hover {
            background: #e2e8f0;
            color: #0f172a;
        }
        .btn-act-delete {
            background: #ffffff;
            color: #dc2626;
            border-color: #fecaca;
        }
        .btn-act-delete:hover {
            background: #fef2f2;
        }

        /* Preset Date Buttons */
        .date-presets {
            display: flex;
            gap: 6px;
            margin-top: 8px;
            flex-wrap: wrap;
        }
        .btn-date-preset {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.76rem;
            font-weight: 600;
            color: #334155;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-date-preset:hover {
            background: #e2e8f0;
            color: #0f172a;
            border-color: #94a3b8;
        }
    </style>
</head>
<body class="admin-page">
<div class="admin-container">

    <!-- Top Navigation Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; flex-wrap: wrap; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 14px;">
            <img src="images/logo-mivisionlatina.png" alt="Logo" style="height: 50px; width: 50px; object-fit: contain; border-radius: 50%; border: 1px solid #e2e8f0; background: #fff;">
            <div>
                <h1 style="font-size: 1.4rem; margin: 0; color: #0f274a; font-weight: 800;">Panel de Gestión · Trabajo Latino</h1>
                <p style="margin: 0; font-size: 0.84rem; color: #64748b;">Administración de Vacantes, Publicación Dedicada y Base de Candidatos</p>
            </div>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="trabajo.php" target="_blank" class="btn btn-secondary" style="font-size: 0.84rem; padding: 8px 16px;">
                👁️ Ver Bolsa en Frontend
            </a>
            <?php if ($is_logged): ?>
                <a href="admin_candidatos.php?logout=1" style="font-size: 0.84rem; padding: 8px 16px; background: #dc2626; color: #fff; border-radius: 6px; text-decoration: none; font-weight: 600;">
                    Cerrar Sesión
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Alert / Flash Message -->
    <?php if (!empty($flash_msg)): ?>
        <div style="background: <?= $flash_type === 'success' ? '#ecfdf5' : '#fef2f2' ?>; border: 1px solid <?= $flash_type === 'success' ? '#a7f3d0' : '#fecaca' ?>; color: <?= $flash_type === 'success' ? '#065f46' : '#991b1b' ?>; padding: 12px 18px; border-radius: 8px; font-size: 0.9rem; margin-bottom: 20px; font-weight: 500; display: flex; align-items: center; gap: 10px;">
            <span><?= $flash_type === 'success' ? '✅' : '⚠️' ?></span>
            <span><?= htmlspecialchars($flash_msg) ?></span>
        </div>
    <?php endif; ?>

    <?php if (!$is_logged): ?>
        <!-- Login Form Card -->
        <div class="admin-card" style="max-width: 420px; margin: 60px auto;">
            <div style="text-align: center; margin-bottom: 20px;">
                <div style="font-size: 2.2rem; margin-bottom: 6px;">🔐</div>
                <h2 style="font-size: 1.3rem; margin: 0; color: #0f274a; font-weight: 800;">Acceso Administrativo</h2>
                <p style="font-size: 0.84rem; color: #64748b; margin-top: 4px;">Ingresa tus credenciales para administrar las ofertas de empleo y revisar los candidatos.</p>
            </div>

            <?php if (!empty($auth_error)): ?>
                <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 10px 14px; border-radius: 6px; font-size: 0.85rem; margin-bottom: 15px;">
                    <?= htmlspecialchars($auth_error) ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 0.84rem; font-weight: 600; margin-bottom: 5px; color: #0f172a;">Usuario</label>
                    <input type="text" name="username" value="admin" required class="form-control">
                </div>
                <div style="margin-bottom: 18px;">
                    <label style="display: block; font-size: 0.84rem; font-weight: 600; margin-bottom: 5px; color: #0f172a;">Contraseña</label>
                    <input type="password" name="password" placeholder="latina2025" required class="form-control">
                    <small style="color: #64748b; font-size: 0.75rem; display: block; margin-top: 4px;">Contraseña por defecto: <code>latina2025</code></small>
                </div>
                <button type="submit" name="login" class="btn btn-primary" style="width: 100%; font-weight: 700; padding: 11px;">
                    Ingresar al Panel
                </button>
            </form>
        </div>
    <?php else: ?>
        <!-- Logged In Admin Dashboard -->

        <!-- Quick Stats Overview Bar -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 24px;">
            <div class="admin-card" style="margin-bottom: 0;">
                <span style="font-size: 0.76rem; color: #64748b; text-transform: uppercase; font-weight: 700;">Vacantes Totales</span>
                <h3 style="margin: 4px 0 0; font-size: 1.65rem; color: #0f274a;">
                    <?= count($all_jobs) ?> 
                    <span style="font-size: 0.82rem; color: #16a34a; font-weight: 600;">(<?= $count_active ?> Activas)</span>
                </h3>
            </div>
            <div class="admin-card" style="margin-bottom: 0;">
                <span style="font-size: 0.76rem; color: #64748b; text-transform: uppercase; font-weight: 700;">Candidatos Registrados</span>
                <h3 style="margin: 4px 0 0; font-size: 1.65rem; color: #1d4ed8;"><?= $stats['total'] ?></h3>
            </div>
            <div class="admin-card" style="margin-bottom: 0;">
                <span style="font-size: 0.76rem; color: #64748b; text-transform: uppercase; font-weight: 700;">Alertas por Correo</span>
                <div style="margin-top: 5px; font-size: 0.86rem; font-weight: 700; color: #0f274a;">
                    <?= NOTIFY_EMAIL ?>
                </div>
                <span style="font-size: 0.74rem; color: #16a34a; font-weight: 600;">✓ Notificaciones automáticas</span>
            </div>
            <div class="admin-card" style="margin-bottom: 0; display: flex; flex-direction: column; justify-content: center;">
                <span style="font-size: 0.76rem; color: #64748b; text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">Acción Rápida</span>
                <div>
                    <button type="button" onclick="switchAdminTab('post_job')" class="btn btn-primary" style="font-size: 0.82rem; padding: 8px 14px; width: 100%; text-align: center; justify-content: center; font-weight: 700; border: none; cursor: pointer;">
                        ➕ Publicar Nueva Vacante
                    </button>
                </div>
            </div>
        </div>

        <!-- NEW MODERN SEGMENTED TABS NAVIGATION - INSTANT & FLUTTER-FREE -->
        <nav class="admin-tabs-bar" aria-label="Navegación del Panel">
            <button type="button" onclick="switchAdminTab('jobs')" id="tab-btn-jobs" class="admin-tab-btn <?= $active_tab === 'jobs' ? 'active' : '' ?>">
                <span>💼 Listado de Vacantes</span>
                <span class="tab-badge <?= $active_tab === 'jobs' ? '' : 'tab-badge-accent' ?>"><?= count($all_jobs) ?></span>
            </button>

            <button type="button" onclick="switchAdminTab('post_job')" id="tab-btn-post_job" class="admin-tab-btn <?= $active_tab === 'post_job' ? 'active' : '' ?>">
                <span><?= $editing_job ? '✏️ Editando Vacante #' . $editing_job['id'] : '➕ Publicar Nueva Vacante' ?></span>
            </button>

            <button type="button" onclick="switchAdminTab('candidates')" id="tab-btn-candidates" class="admin-tab-btn <?= $active_tab === 'candidates' ? 'active' : '' ?>">
                <span>👥 Candidatos & Currículums</span>
                <span class="tab-badge"><?= count($candidates) ?></span>
            </button>

            <button type="button" onclick="switchAdminTab('email')" id="tab-btn-email" class="admin-tab-btn <?= $active_tab === 'email' ? 'active' : '' ?>">
                <span>📧 Registro de Correos</span>
            </button>
        </nav>

        <!-- ===================================================================
             TAB 1: LISTADO DE VACANTES PUBLICADAS (GESTIÓN EXCLUSIVA)
             =================================================================== -->
        <div id="tab-pane-jobs" class="admin-tab-pane <?= $active_tab === 'jobs' ? 'active' : '' ?>">
            <div class="admin-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 14px;">
                    <div>
                        <h2 style="margin: 0; font-size: 1.25rem; color: #0f274a; font-weight: 800;">
                            Listado de Vacantes Registradas (<?= count($displayed_jobs) ?>)
                        </h2>
                        <p style="margin: 3px 0 0; font-size: 0.84rem; color: #64748b;">
                            Activa, desactiva o renueva la expiración de cada empleo. Las vacantes activas y no expiradas son las que aparecen en el portal.
                        </p>
                    </div>
                    <button type="button" onclick="switchAdminTab('post_job')" class="btn btn-primary" style="font-weight: 700; padding: 9px 18px; border: none; cursor: pointer;">
                        ➕ Publicar Nueva Vacante
                    </button>
                </div>

                <!-- Status Filter Chips & Search Bar -->
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 16px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                    <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
                        <span style="font-size: 0.8rem; font-weight: 700; color: #64748b; margin-right: 4px;">Filtro:</span>
                        <a href="admin_candidatos.php?tab=jobs&status_filter=all" style="text-decoration: none; font-size: 0.8rem; font-weight: 600; padding: 4px 12px; border-radius: 6px; <?= $job_status_filter === 'all' ? 'background: #0f274a; color: #fff;' : 'background: #ffffff; color: #475569; border: 1px solid #cbd5e1;' ?>">
                            Todas (<?= count($all_jobs) ?>)
                        </a>
                        <a href="admin_candidatos.php?tab=jobs&status_filter=active" style="text-decoration: none; font-size: 0.8rem; font-weight: 600; padding: 4px 12px; border-radius: 6px; <?= $job_status_filter === 'active' ? 'background: #059669; color: #fff;' : 'background: #ffffff; color: #059669; border: 1px solid #a7f3d0;' ?>">
                            Activas (<?= $count_active ?>)
                        </a>
                        <a href="admin_candidatos.php?tab=jobs&status_filter=inactive" style="text-decoration: none; font-size: 0.8rem; font-weight: 600; padding: 4px 12px; border-radius: 6px; <?= $job_status_filter === 'inactive' ? 'background: #64748b; color: #fff;' : 'background: #ffffff; color: #64748b; border: 1px solid #cbd5e1;' ?>">
                            Inactivas / Pausadas (<?= $count_inactive ?>)
                        </a>
                        <a href="admin_candidatos.php?tab=jobs&status_filter=expired" style="text-decoration: none; font-size: 0.8rem; font-weight: 600; padding: 4px 12px; border-radius: 6px; <?= $job_status_filter === 'expired' ? 'background: #dc2626; color: #fff;' : 'background: #ffffff; color: #dc2626; border: 1px solid #fecaca;' ?>">
                            Expiradas (<?= $count_expired ?>)
                        </a>
                    </div>

                    <form method="GET" action="admin_candidatos.php" style="display: flex; gap: 8px;">
                        <input type="hidden" name="tab" value="jobs">
                        <input type="hidden" name="status_filter" value="<?= htmlspecialchars($job_status_filter) ?>">
                        <input type="text" name="job_q" value="<?= htmlspecialchars($job_search) ?>" placeholder="Buscar por título o empresa..." class="form-control" style="font-size: 0.84rem; padding: 6px 12px; width: 220px;">
                        <button type="submit" class="btn btn-secondary" style="font-size: 0.8rem; padding: 6px 14px;">Buscar</button>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Vacante & Empresa</th>
                                <th>Categoría</th>
                                <th>Jornada / Salario</th>
                                <th>Ubicación</th>
                                <th>Estado</th>
                                <th>Fecha Expiración</th>
                                <th style="text-align: right;">Acciones de Gestión</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($displayed_jobs)): ?>
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 40px; color: #64748b;">
                                        No se encontraron ofertas de empleo con los filtros actuales.<br>
                                        <button type="button" onclick="switchAdminTab('post_job')" class="btn btn-primary" style="margin-top: 12px; display: inline-flex; border: none; cursor: pointer;">
                                            ➕ Publicar Nueva Vacante Ahora
                                        </button>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($displayed_jobs as $j): ?>
                                    <?php
                                    $is_exp = is_job_expired($j);
                                    $days_left = get_job_days_left($j);
                                    $is_active = ($j['status'] === 'Activo' && !$is_exp);
                                    ?>
                                    <tr>
                                        <td><strong>#<?= $j['id'] ?></strong></td>
                                        <td>
                                            <div style="font-weight: 700; color: #0f274a; font-size: 0.92rem;"><?= htmlspecialchars($j['title']) ?></div>
                                            <div style="font-size: 0.78rem; color: #475569; display: flex; align-items: center; gap: 4px; margin-top: 2px;">
                                                🏢 <?= htmlspecialchars($j['company']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge-cat"><?= htmlspecialchars($j['category']) ?></span>
                                        </td>
                                        <td>
                                            <div style="font-size: 0.78rem; color: #64748b;"><?= htmlspecialchars($j['job_type']) ?></div>
                                            <?php if (!empty($j['salary'])): ?>
                                                <div style="font-weight: 700; color: #059669; font-size: 0.82rem;"><?= htmlspecialchars($j['salary']) ?></div>
                                            <?php else: ?>
                                                <span style="font-size: 0.76rem; color: #94a3b8;">A convenir</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span style="font-size: 0.8rem; color: #475569;">📍 <?= htmlspecialchars($j['location']) ?></span>
                                        </td>
                                        <td>
                                            <?php if ($is_exp): ?>
                                                <span class="badge-status expired">
                                                    <span class="pulse-dot red"></span> Expirado
                                                </span>
                                            <?php elseif ($j['status'] === 'Activo'): ?>
                                                <span class="badge-status active">
                                                    <span class="pulse-dot green"></span> Activo
                                                </span>
                                            <?php else: ?>
                                                <span class="badge-status inactive">
                                                    <span class="pulse-dot gray"></span> Inactivo
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($j['expires_at'])): ?>
                                                <div style="font-weight: 600; font-size: 0.8rem; color: #0f274a;">
                                                    <?= date('d M Y', strtotime($j['expires_at'])) ?>
                                                </div>
                                                <?php if ($days_left !== null): ?>
                                                    <?php if ($days_left < 0): ?>
                                                        <span style="font-size: 0.72rem; color: #dc2626; font-weight: 600;">Expiró hace <?= abs($days_left) ?> d</span>
                                                    <?php elseif ($days_left === 0): ?>
                                                        <span style="font-size: 0.72rem; color: #ea580c; font-weight: 700;">Vence hoy</span>
                                                    <?php else: ?>
                                                        <span style="font-size: 0.72rem; color: #16a34a; font-weight: 600;">Quedan <?= $days_left ?> días</span>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span style="font-size: 0.78rem; color: #64748b;">Indefinido</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="text-align: right; white-space: nowrap;">
                                            <div class="btn-action-group">
                                                <!-- Quick Toggle Button (Enable / Disable) -->
                                                <?php if ($j['status'] === 'Activo'): ?>
                                                    <a href="admin_candidatos.php?action=toggle_job&id=<?= $j['id'] ?>" class="btn-act btn-act-toggle-off" title="Desactivar y ocultar del portal">
                                                        ⏸️ Desactivar
                                                    </a>
                                                <?php else: ?>
                                                    <a href="admin_candidatos.php?action=toggle_job&id=<?= $j['id'] ?>" class="btn-act btn-act-toggle-on" title="Activar y mostrar en el portal">
                                                        ▶️ Activar
                                                    </a>
                                                <?php endif; ?>

                                                <!-- Quick Extend Expiration (+30 Days) -->
                                                <a href="admin_candidatos.php?action=extend_job&id=<?= $j['id'] ?>" class="btn-act btn-act-extend" title="Extender vigencia 30 días adicionales">
                                                    ⏳ +30d
                                                </a>

                                                <!-- Edit Button (Goes to dedicated form tab) -->
                                                <a href="admin_candidatos.php?tab=post_job&edit_job_id=<?= $j['id'] ?>" class="btn-act btn-act-edit" title="Editar detalles de la vacante">
                                                    ✏️ Editar
                                                </a>

                                                <!-- View Frontend Page Link -->
                                                <a href="empleo.php?id=<?= $j['id'] ?>" target="_blank" class="btn-act btn-act-view" title="Ver página pública de la vacante">
                                                    👁️ Ver
                                                </a>

                                                <!-- Delete Button -->
                                                <a href="admin_candidatos.php?action=delete_job&id=<?= $j['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar la vacante #<?= $j['id'] ?> permanentemente?');" class="btn-act btn-act-delete" title="Eliminar vacante">
                                                    🗑️
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ===================================================================
             TAB 2: FORMULARIO SEPARADO DE PUBLICACIÓN / EDICIÓN DE VACANTES
             =================================================================== -->
        <div id="tab-pane-post_job" class="admin-tab-pane <?= $active_tab === 'post_job' ? 'active' : '' ?>">
            <div class="admin-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; border-bottom: 1px solid #f1f5f9; padding-bottom: 16px; flex-wrap: wrap; gap: 12px;">
                    <div>
                        <span class="badge-cat" style="margin-bottom: 6px;">FORMULARIO DEDICADO DE VACANTES</span>
                        <h2 style="margin: 0; font-size: 1.35rem; color: #0f274a; font-weight: 800;">
                            <?= $editing_job ? '✏️ Editando Vacante #' . $editing_job['id'] . ': ' . htmlspecialchars($editing_job['title']) : '➕ Publicar Nueva Oferta de Empleo' ?>
                        </h2>
                        <p style="margin: 4px 0 0; font-size: 0.85rem; color: #64748b;">
                            <?= $editing_job ? 'Modifica los campos necesarios y presiona Guardar Cambios para actualizar la vacante en la web.' : 'Llena todos los datos requeridos. La vacante se publicará de inmediato y tendrá su propia página web en el portal.' ?>
                        </p>
                    </div>
                    <button type="button" onclick="switchAdminTab('jobs')" class="btn btn-secondary" style="font-size: 0.84rem; padding: 8px 16px; border: 1px solid #cbd5e1; cursor: pointer;">
                        ← Volver al Listado de Vacantes
                    </button>
                </div>

                <form method="POST" action="admin_candidatos.php?tab=jobs">
                    <input type="hidden" name="save_job_action" value="1">
                    <input type="hidden" name="id" value="<?= $editing_job ? $editing_job['id'] : 0 ?>">

                    <!-- Step 1: Basic Information -->
                    <div style="margin-bottom: 24px;">
                        <h3 style="font-size: 1rem; color: #0f274a; font-weight: 800; margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                            <span style="background: #eff6ff; color: #1d4ed8; width: 24px; height: 24px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.78rem;">1</span>
                            Información Principal del Puesto
                        </h3>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; margin-bottom: 16px;">
                            <div>
                                <label style="display: block; font-size: 0.84rem; font-weight: 700; margin-bottom: 6px; color: #0f274a;">Título de la Oferta / Puesto *</label>
                                <input type="text" name="title" required value="<?= $editing_job ? htmlspecialchars($editing_job['title']) : '' ?>" placeholder="Ej. Maestro de Construcción, Sheetrock y Framing" class="form-control">
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.84rem; font-weight: 700; margin-bottom: 6px; color: #0f274a;">Empresa Contratante o Negocio *</label>
                                <input type="text" name="company" required value="<?= $editing_job ? htmlspecialchars($editing_job['company']) : 'Empresa Confidencial' ?>" placeholder="Ej. Constructora Houston Heights LLC" class="form-control">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px;">
                            <div>
                                <label style="display: block; font-size: 0.84rem; font-weight: 700; margin-bottom: 6px; color: #0f274a;">Categoría / Oficio *</label>
                                <select name="category" required class="form-control">
                                    <?php
                                    $categories_list = [
                                        'Construcción / Remodelación',
                                        'Limpieza Residencial / Comercial',
                                        'Restaurante / Cocina / Mesero',
                                        'Chofer / Delivery / Transporte',
                                        'Electricidad / Plomería / HVAC',
                                        'Bodega / Warehouse / Empaque',
                                        'Pintura y Tablaroca',
                                        'Mecánica Automotriz',
                                        'Jardinería / Landscaping',
                                        'Ventas / Atención al Cliente',
                                        'Administración / Oficina',
                                        'Otro'
                                    ];
                                    foreach ($categories_list as $cat_opt):
                                        $selected = ($editing_job && $editing_job['category'] === $cat_opt) ? 'selected' : '';
                                    ?>
                                        <option value="<?= $cat_opt ?>" <?= $selected ?>><?= $cat_opt ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div>
                                <label style="display: block; font-size: 0.84rem; font-weight: 700; margin-bottom: 6px; color: #0f274a;">Ubicación (Área / Ciudad) *</label>
                                <input type="text" name="location" required value="<?= $editing_job ? htmlspecialchars($editing_job['location']) : 'Houston, TX' ?>" placeholder="Ej. Houston, TX (Northside / Katy)" class="form-control">
                            </div>

                            <div>
                                <label style="display: block; font-size: 0.84rem; font-weight: 700; margin-bottom: 6px; color: #0f274a;">Salario / Pago Estimado</label>
                                <input type="text" name="salary" value="<?= $editing_job ? htmlspecialchars($editing_job['salary']) : '' ?>" placeholder="Ej. $22 - $28 / hora o $1,200/semana" class="form-control">
                            </div>

                            <div>
                                <label style="display: block; font-size: 0.84rem; font-weight: 700; margin-bottom: 6px; color: #0f274a;">Tipo de Jornada</label>
                                <select name="job_type" class="form-control">
                                    <option value="Tiempo Completo" <?= ($editing_job && $editing_job['job_type'] === 'Tiempo Completo') ? 'selected' : '' ?>>Tiempo Completo</option>
                                    <option value="Medio Tiempo" <?= ($editing_job && $editing_job['job_type'] === 'Medio Tiempo') ? 'selected' : '' ?>>Medio Tiempo</option>
                                    <option value="Por Proyecto / Contrato" <?= ($editing_job && $editing_job['job_type'] === 'Por Proyecto / Contrato') ? 'selected' : '' ?>>Por Proyecto / Contrato</option>
                                    <option value="Fines de Semana" <?= ($editing_job && $editing_job['job_type'] === 'Fines de Semana') ? 'selected' : '' ?>>Fines de Semana</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Enable/Disable & Expiration Settings -->
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px; margin-bottom: 24px;">
                        <h3 style="font-size: 1rem; color: #0f274a; font-weight: 800; margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                            <span style="background: #eff6ff; color: #1d4ed8; width: 24px; height: 24px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.78rem;">2</span>
                            Control de Estado y Fecha de Expiración
                        </h3>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                            <div>
                                <label style="display: block; font-size: 0.84rem; font-weight: 700; margin-bottom: 8px; color: #0f274a;">Estado de la Vacante</label>
                                <div style="display: flex; gap: 12px; align-items: center;">
                                    <label style="display: inline-flex; align-items: center; gap: 6px; cursor: pointer; background: #ffffff; border: 1px solid #cbd5e1; padding: 8px 14px; border-radius: 8px; font-size: 0.85rem; font-weight: 600;">
                                        <input type="radio" name="status" value="Activo" <?= (!$editing_job || $editing_job['status'] === 'Activo') ? 'checked' : '' ?>>
                                        <span style="color: #15803d;">● Activo (Visible en frontend)</span>
                                    </label>
                                    <label style="display: inline-flex; align-items: center; gap: 6px; cursor: pointer; background: #ffffff; border: 1px solid #cbd5e1; padding: 8px 14px; border-radius: 8px; font-size: 0.85rem; font-weight: 600;">
                                        <input type="radio" name="status" value="Inactivo" <?= ($editing_job && $editing_job['status'] !== 'Activo') ? 'checked' : '' ?>>
                                        <span style="color: #64748b;">○ Inactivo / Pausado (Oculto)</span>
                                    </label>
                                </div>
                                <small style="display: block; color: #64748b; font-size: 0.76rem; margin-top: 6px;">
                                    Puedes pausar o reactivar esta vacante en cualquier momento con un solo clic.
                                </small>
                            </div>

                            <div>
                                <label style="display: block; font-size: 0.84rem; font-weight: 700; margin-bottom: 6px; color: #0f274a;">Fecha de Expiración / Vencimiento</label>
                                <?php
                                $current_exp = $editing_job ? ($editing_job['expires_at'] ?? '') : date('Y-m-d', strtotime('+30 days'));
                                ?>
                                <input type="date" id="input_expires_at" name="expires_at" value="<?= htmlspecialchars($current_exp) ?>" class="form-control" style="font-size: 0.9rem;">
                                
                                <div class="date-presets">
                                    <span style="font-size: 0.74rem; color: #64748b; align-self: center;">Accesos directos:</span>
                                    <button type="button" class="btn-date-preset" onclick="setExpireDays(15)">+15 Días</button>
                                    <button type="button" class="btn-date-preset" onclick="setExpireDays(30)">+30 Días</button>
                                    <button type="button" class="btn-date-preset" onclick="setExpireDays(60)">+60 Días</button>
                                    <button type="button" class="btn-date-preset" onclick="setExpireDays(90)">+90 Días</button>
                                    <button type="button" class="btn-date-preset" onclick="clearExpireDate()">Sin Límite</button>
                                </div>
                                <small style="display: block; color: #64748b; font-size: 0.76rem; margin-top: 6px;">
                                    Al llegar a la fecha de vencimiento, la oferta dejará de mostrarse automáticamente a los postulantes.
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Description & Job Requirements -->
                    <div style="margin-bottom: 24px;">
                        <h3 style="font-size: 1rem; color: #0f274a; font-weight: 800; margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                            <span style="background: #eff6ff; color: #1d4ed8; width: 24px; height: 24px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.78rem;">3</span>
                            Descripción del Puesto & Requisitos (JD)
                        </h3>

                        <div style="margin-bottom: 16px;">
                            <label style="display: block; font-size: 0.84rem; font-weight: 700; margin-bottom: 6px; color: #0f274a;">Descripción de la Vacante & Funciones *</label>
                            <textarea name="description" rows="5" required class="form-control" placeholder="Describe las responsabilidades principales, horario laboral, ambiente de trabajo y qué ofrece la empresa..."><?= $editing_job ? htmlspecialchars($editing_job['description']) : '' ?></textarea>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 0.84rem; font-weight: 700; margin-bottom: 6px; color: #0f274a;">Requisitos para los Candidatos</label>
                            <textarea name="requirements" rows="4" class="form-control" placeholder="Años de experiencia requeridos, herramientas propias, licencias de conducir, nivel de inglés o certificaciones necesarias..."><?= $editing_job ? htmlspecialchars($editing_job['requirements']) : '' ?></textarea>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: flex; gap: 12px; align-items: center; padding-top: 14px; border-top: 1px solid #f1f5f9;">
                        <button type="submit" class="btn btn-primary" style="padding: 12px 28px; font-weight: 800; font-size: 0.92rem;">
                            <?= $editing_job ? '💾 Guardar Cambios de la Vacante' : '🚀 Publicar Vacante en la Web' ?>
                        </button>
                        <button type="button" onclick="switchAdminTab('jobs')" class="btn btn-secondary" style="padding: 12px 20px; border: 1px solid #cbd5e1; cursor: pointer;">
                            Cancelar y Volver al Listado
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- JavaScript Helper for Date Presets -->
        <script>
        function setExpireDays(days) {
            const target = new Date();
            target.setDate(target.getDate() + days);
            const yyyy = target.getFullYear();
            const mm = String(target.getMonth() + 1).padStart(2, '0');
            const dd = String(target.getDate()).padStart(2, '0');
            document.getElementById('input_expires_at').value = `${yyyy}-${mm}-${dd}`;
        }
        function clearExpireDate() {
            document.getElementById('input_expires_at').value = '';
        }
        </script>

        <!-- ===================================================================
             TAB 3: CANDIDATOS Y CURRÍCULUMS
             =================================================================== -->
        <div id="tab-pane-candidates" class="admin-tab-pane <?= $active_tab === 'candidates' ? 'active' : '' ?>">

            <!-- Filter & Search Bar -->
            <div class="admin-card">
                <form method="GET" action="admin_candidatos.php" style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <input type="hidden" name="tab" value="candidates">
                    <input type="text" name="search" placeholder="Buscar por candidato, teléfono, vacante..." value="<?= htmlspecialchars($search) ?>" class="form-control" style="flex: 2; min-width: 220px;">
                    
                    <select name="category" class="form-control" style="flex: 1; min-width: 200px;">
                        <option value="">Todas las Áreas</option>
                        <option value="Construcción / Remodelación" <?= $category === 'Construcción / Remodelación' ? 'selected' : '' ?>>Construcción / Remodelación</option>
                        <option value="Limpieza Residencial / Comercial" <?= $category === 'Limpieza Residencial / Comercial' ? 'selected' : '' ?>>Limpieza Residencial / Comercial</option>
                        <option value="Restaurante / Cocina / Mesero" <?= $category === 'Restaurante / Cocina / Mesero' ? 'selected' : '' ?>>Restaurante / Cocina / Mesero</option>
                        <option value="Chofer / Delivery / Transporte" <?= $category === 'Chofer / Delivery / Transporte' ? 'selected' : '' ?>>Chofer / Delivery / Transporte</option>
                        <option value="Bodega / Warehouse / Empaque" <?= $category === 'Bodega / Warehouse / Empaque' ? 'selected' : '' ?>>Bodega / Warehouse / Empaque</option>
                        <option value="Electricidad / Plomería / HVAC" <?= $category === 'Electricidad / Plomería / HVAC' ? 'selected' : '' ?>>Electricidad / Plomería / HVAC</option>
                        <option value="Ventas / Atención al Cliente" <?= $category === 'Ventas / Atención al Cliente' ? 'selected' : '' ?>>Ventas / Atención al Cliente</option>
                        <option value="Administración / Oficina" <?= $category === 'Administración / Oficina' ? 'selected' : '' ?>>Administración / Oficina</option>
                        <option value="Otro" <?= $category === 'Otro' ? 'selected' : '' ?>>Otro</option>
                    </select>

                    <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">Filtrar</button>
                    <?php if (!empty($search) || !empty($category)): ?>
                        <a href="admin_candidatos.php?tab=candidates" style="padding: 10px 14px; color: #64748b; text-decoration: none; display: inline-flex; align-items: center; font-size: 0.88rem;">Limpiar Filtros</a>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Candidates Table -->
            <div class="admin-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <h3 style="margin: 0; font-size: 1.15rem; color: #0f274a; font-weight: 800;">
                            Candidatos Postulados (<?= count($candidates) ?>)
                        </h3>
                        <p style="margin: 2px 0 0; font-size: 0.82rem; color: #64748b;">
                            Contacto directo con postulantes, vacante específica y descarga de currículums.
                        </p>
                    </div>
                    <a href="admin_candidatos.php?action=export_csv" class="btn btn-primary" style="font-size: 0.8rem; padding: 7px 14px;">
                        📥 Descargar Excel (CSV)
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Candidato</th>
                                <th>Vacante Aplicada</th>
                                <th>Contacto</th>
                                <th>Currículum (CV)</th>
                                <th>Ubicación</th>
                                <th>Área</th>
                                <th>Experiencia</th>
                                <th>Inglés</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($candidates)): ?>
                                <tr>
                                    <td colspan="10" style="text-align: center; padding: 40px; color: #64748b;">
                                        No hay candidatos registrados aún con los filtros actuales.<br>
                                        <small style="color: #94a3b8;">Los registros enviados desde la bolsa de empleo y Facebook aparecerán aquí automáticamente.</small>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($candidates as $c): ?>
                                    <tr>
                                        <td><strong>#<?= $c['id'] ?></strong></td>
                                        <td>
                                            <div style="font-weight: 700; color: #0f172a;"><?= htmlspecialchars($c['fullname']) ?></div>
                                            <?php if (!empty($c['notes'])): ?>
                                                <div style="font-size: 0.76rem; color: #64748b; margin-top: 3px; max-width: 200px; white-space: normal;">
                                                    "<?= htmlspecialchars($c['notes']) ?>"
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span style="font-weight: 600; color: #0f274a; font-size: 0.84rem;">
                                                <?= htmlspecialchars($c['job_title'] ?? 'Bolsa General') ?>
                                            </span>
                                            <div style="font-size: 0.72rem; color: #64748b;">Origen: <?= htmlspecialchars($c['source_referrer']) ?></div>
                                        </td>
                                        <td>
                                            <div><a href="tel:<?= htmlspecialchars($c['phone']) ?>" style="color: #0f274a; text-decoration: none; font-weight: 600;"><?= htmlspecialchars($c['phone']) ?></a></div>
                                            <?php if (!empty($c['email'])): ?>
                                                <div style="font-size: 0.78rem;"><a href="mailto:<?= htmlspecialchars($c['email']) ?>" style="color: #64748b; text-decoration: none;"><?= htmlspecialchars($c['email']) ?></a></div>
                                            <?php endif; ?>
                                            <div style="margin-top: 4px;">
                                                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $c['phone']) ?>?text=Hola%20<?= urlencode($c['fullname']) ?>,%20te%20contactamos%20de%20Trabajo%20Latino%20(Mi%20Visi%C3%B3n%20Latina)" target="_blank" style="display: inline-block; font-size: 0.72rem; background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; padding: 2px 7px; border-radius: 4px; text-decoration: none; font-weight: 700;">
                                                    💬 WhatsApp
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if (!empty($c['resume_path']) && file_exists(UPLOAD_DIR . $c['resume_path'])): ?>
                                                <?php $ext = strtoupper(pathinfo($c['resume_path'], PATHINFO_EXTENSION)); ?>
                                                <a href="uploads/resumes/<?= htmlspecialchars($c['resume_path']) ?>" download target="_blank" class="btn-act" style="background: #0284c7; color: #fff; font-size: 0.76rem; padding: 5px 10px;">
                                                    📄 Descargar (<?= $ext ?>)
                                                </a>
                                            <?php else: ?>
                                                <span style="color: #94a3b8; font-size: 0.78rem;">Sin archivo</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($c['city_state']) ?></td>
                                        <td><span class="badge-cat"><?= htmlspecialchars($c['category']) ?></span></td>
                                        <td><?= htmlspecialchars($c['experience_years']) ?></td>
                                        <td><?= htmlspecialchars($c['english_level']) ?></td>
                                        <td><span style="color: #64748b; font-size: 0.75rem;"><?= date('d/m/Y H:i', strtotime($c['created_at'])) ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ===================================================================
             TAB 4: REGISTRO DE NOTIFICACIONES (EMAIL AUDIT LOG)
             =================================================================== -->
        <div id="tab-pane-email" class="admin-tab-pane <?= $active_tab === 'email' ? 'active' : '' ?>">
            <div class="admin-card">
                <div style="margin-bottom: 20px;">
                    <h3 style="margin: 0; font-size: 1.15rem; color: #0f274a; font-weight: 800;">
                        Auditoría de Envíos de Correo Electrónico
                    </h3>
                    <p style="margin: 3px 0 0; font-size: 0.84rem; color: #64748b;">
                        Cada vez que un visitante llena el formulario con su currículum, los datos se envían automáticamente a <strong><?= NOTIFY_EMAIL ?></strong>.
                    </p>
                </div>

                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; margin-bottom: 20px;">
                    <div style="font-weight: 700; color: #0f274a; margin-bottom: 6px;">Configuración de Despacho:</div>
                    <ul style="margin: 0; padding-left: 20px; font-size: 0.84rem; color: #475569; line-height: 1.6;">
                        <li><strong>Destinatario principal:</strong> <?= NOTIFY_EMAIL ?></li>
                        <li><strong>Remitente:</strong> Mi Visión Latina &lt;no-reply@<?= SITE_DOMAIN ?>&gt;</li>
                        <li><strong>Archivos adjuntos permitidos:</strong> PDF, DOC, DOCX, RTF (Hasta <?= MAX_RESUME_SIZE_MB ?>MB)</li>
                        <li><strong>Archivo de registro local:</strong> <code>data/email_notifications.log</code></li>
                    </ul>
                </div>

                <h4 style="font-size: 0.95rem; color: #0f274a; margin-bottom: 10px;">Registro Reciente de Notificaciones (Últimos eventos):</h4>
                <?php
                $log_file = __DIR__ . '/data/email_notifications.log';
                if (file_exists($log_file)):
                    $logs = array_reverse(array_filter(explode("\n", file_get_contents($log_file))));
                ?>
                    <div style="background: #0f172a; color: #e2e8f0; font-family: monospace; font-size: 0.8rem; padding: 16px; border-radius: 8px; max-height: 400px; overflow-y: auto; line-height: 1.5;">
                        <?php if (empty($logs)): ?>
                            <div style="color: #94a3b8;">No hay registros de correo todavía. Se generará un registro cuando se envíe la primera postulación.</div>
                        <?php else: ?>
                            <?php foreach (array_slice($logs, 0, 50) as $line): ?>
                                <div><?= htmlspecialchars($line) ?></div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div style="color: #64748b; font-size: 0.85rem;">El archivo de registro aún no existe. Se creará automáticamente con el primer envío.</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Instant Tab Switcher JavaScript -->
        <script>
        function switchAdminTab(tabId) {
            const validTabs = ['jobs', 'post_job', 'candidates', 'email'];
            if (!validTabs.includes(tabId)) tabId = 'jobs';

            validTabs.forEach(function(id) {
                const pane = document.getElementById('tab-pane-' + id);
                const btn = document.getElementById('tab-btn-' + id);
                if (pane) {
                    if (id === tabId) {
                        pane.classList.add('active');
                        pane.style.display = 'block';
                    } else {
                        pane.classList.remove('active');
                        pane.style.display = 'none';
                    }
                }
                if (btn) {
                    if (id === tabId) {
                        btn.classList.add('active');
                    } else {
                        btn.classList.remove('active');
                    }
                }
            });

            try {
                const url = new URL(window.location.href);
                url.searchParams.set('tab', tabId);
                window.history.replaceState({ tab: tabId }, '', url.toString());
            } catch (e) {}
        }

        window.addEventListener('popstate', function() {
            const params = new URLSearchParams(window.location.search);
            const tab = params.get('tab') || 'jobs';
            switchAdminTab(tab);
        });
        </script>

    <?php endif; ?>

</div>
</body>
</html>
