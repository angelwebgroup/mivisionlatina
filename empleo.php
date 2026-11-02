<?php
/**
 * MI VISIÓN LATINA - DETALLE INDIVIDUAL DE VACANTE DE EMPLEO
 * Página dedicada para cada oferta de empleo con Job Description completo,
 * resumen de requisitos, formulario de postulación directa y carga de currículum.
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

$job_id = (int)($_GET['id'] ?? 0);
$job = null;
if ($job_id > 0) {
    $job = get_job_by_id($job_id);
}

// Check expiration and status
$is_expired = false;
$days_left = null;
$is_active = false;

if ($job) {
    $is_expired = is_job_expired($job);
    $days_left = get_job_days_left($job);
    $is_active = ($job['status'] === 'Activo' && !$is_expired);
    
    $page_title = $job['title'] . ' en ' . $job['location'];
    $page_description = 'Vacante de ' . $job['title'] . ' ofrecida por ' . $job['company'] . ' en ' . $job['location'] . '. Postúlate hoy con tu currículum en Mi Visión Latina.';
} else {
    $page_title = 'Vacante no encontrada | Bolsa de Empleo';
    $page_description = 'La vacante solicitada no se encuentra disponible o ha sido retirada del portal.';
}

// Fetch related jobs in the same or other categories
$all_active_jobs = get_jobs('', '', 'Activo');
$related_jobs = [];
if ($job) {
    foreach ($all_active_jobs as $aj) {
        if ($aj['id'] != $job['id']) {
            $related_jobs[] = $aj;
            if (count($related_jobs) >= 3) break;
        }
    }
}

$current_page_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

require_once __DIR__ . '/header.php';
?>

    <?php if (!$job): ?>
        <!-- Job Not Found State -->
        <main class="container" style="padding: 80px 20px; text-align: center;">
            <div style="max-width: 580px; margin: 0 auto; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 45px 30px; box-shadow: 0 4px 16px rgba(15,23,42,0.06);">
                <div style="font-size: 3rem; margin-bottom: 12px;">🔍</div>
                <h1 style="font-size: 1.8rem; color: #0f274a; font-weight: 800; margin-bottom: 10px;">Vacante no disponible</h1>
                <p style="color: #64748b; font-size: 0.95rem; line-height: 1.6; margin-bottom: 25px;">
                    La vacante que buscas ya no está activa, ha expirado o el enlace es incorrecto. Te invitamos a revisar todas las oportunidades laborales disponibles actualmente en Houston y Texas.
                </p>
                <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                    <a href="trabajo.php" class="btn btn-primary" style="padding: 11px 22px; font-weight: 700;">
                        ← Explorar Todas las Vacantes
                    </a>
                    <a href="trabajo.php#formulario" class="btn btn-secondary" style="padding: 11px 22px;">
                        ✍️ Registrar CV en Bolsa General
                    </a>
                </div>
            </div>
        </main>
    <?php else: ?>

        <!-- Job Detail Hero Section -->
        <section class="job-detail-hero">
            <div class="container">
                
                <!-- Top Navigation & Breadcrumbs -->
                <div class="job-hero-top">
                    <nav class="breadcrumbs" aria-label="Migas de pan">
                        <a href="index.php">Inicio</a>
                        <span class="crumb-sep">/</span>
                        <a href="trabajo.php">Bolsa de Empleo</a>
                        <span class="crumb-sep">/</span>
                        <a href="trabajo.php?cat=<?= urlencode($job['category']) ?>"><?= htmlspecialchars($job['category']) ?></a>
                        <span class="crumb-sep">/</span>
                        <span class="crumb-current">Vacante #<?= $job['id'] ?></span>
                    </nav>

                    <a href="trabajo.php" class="btn-back-jobs">
                        ← Ver todas las vacantes
                    </a>
                </div>

                <!-- Job Title & Badges -->
                <div>
                    <span class="job-category-badge" style="font-size: 0.76rem; padding: 4px 12px;">
                        <?= htmlspecialchars($job['category']) ?>
                    </span>
                    <h1 class="job-detail-title">
                        <?= htmlspecialchars($job['title']) ?>
                    </h1>
                </div>

                <!-- Meta Row: Location, Company, Salary, Type, Dates -->
                <div class="job-detail-meta">
                    <div class="job-company" style="font-size: 1rem; color: #0f274a; font-weight: 700;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="#1d4ed8"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/></svg>
                        <span><?= htmlspecialchars($job['company']) ?></span>
                        <span style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; font-size: 0.7rem; padding: 2px 6px; border-radius: 4px; font-weight: 700;">Verificado</span>
                    </div>

                    <span class="job-meta-chip">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="#64748b"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                        <strong><?= htmlspecialchars($job['location']) ?></strong>
                    </span>

                    <?php if (!empty($job['salary'])): ?>
                        <span class="job-meta-chip salary" style="font-size: 0.9rem;">
                            💵 <strong><?= htmlspecialchars($job['salary']) ?></strong>
                        </span>
                    <?php endif; ?>

                    <span class="job-meta-chip">
                        ⏱️ <?= htmlspecialchars($job['job_type']) ?>
                    </span>

                    <span class="job-meta-chip">
                        📅 Publicado: <?= date('d M Y', strtotime($job['created_at'])) ?>
                    </span>

                    <!-- Expiration status badge -->
                    <?php if ($is_expired): ?>
                        <span class="badge-status expired" style="font-size: 0.8rem; padding: 5px 12px;">
                            ⚠️ Vacante Expirada
                        </span>
                    <?php elseif (!empty($job['expires_at'])): ?>
                        <span class="job-meta-chip" style="background: #fefce8; color: #854d0e; border-color: #fef08a;">
                            ⏳ Vence: <strong><?= date('d M Y', strtotime($job['expires_at'])) ?></strong>
                            <?php if ($days_left !== null && $days_left > 0): ?>
                                <span style="font-weight: normal; font-size: 0.78rem;">(Quedan <?= $days_left ?> días)</span>
                            <?php endif; ?>
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Social Share Bar (WhatsApp, Facebook, Copy link) -->
                <div class="job-share-bar">
                    <span style="font-weight: 700; color: #0f274a;">Compartir esta vacante:</span>
                    
                    <a href="https://api.whatsapp.com/send?text=<?= urlencode('Oportunidad de Empleo en Houston: ' . $job['title'] . ' en ' . $job['company'] . '. Ver detalles y postularte aquí: ' . $current_page_url) ?>" target="_blank" rel="noopener noreferrer" class="btn-share btn-share-wa">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>WhatsApp</span>
                    </a>

                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($current_page_url) ?>" target="_blank" rel="noopener noreferrer" class="btn-share btn-share-fb">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        <span>Facebook</span>
                    </a>

                    <button type="button" id="btn-copy-link" class="btn-share btn-share-copy">
                        📋 Copiar Enlace
                    </button>
                    <span id="copy-feedback" style="display: none; font-size: 0.78rem; color: #16a34a; font-weight: 700;">¡Enlace copiado al portapapeles!</span>
                </div>

            </div>
        </section>

        <!-- Main Body: 2 Columns (Left: JD Details | Right: Sticky Apply Form) -->
        <main class="container">
            <div class="job-detail-layout">
                
                <!-- Left Column: Detailed Job Description -->
                <div class="job-detail-main">
                    
                    <?php if ($is_expired): ?>
                        <!-- Expiration Notice -->
                        <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; padding: 20px; margin-bottom: 24px; display: flex; gap: 14px; align-items: flex-start;">
                            <div style="font-size: 1.8rem; line-height: 1;">⚠️</div>
                            <div>
                                <h3 style="margin: 0; font-size: 1.05rem; color: #991b1b; font-weight: 800;">Esta vacante ha expirado</h3>
                                <p style="margin: 4px 0 10px; font-size: 0.86rem; color: #7f1d1d; line-height: 1.5;">
                                    El plazo de postulación para esta oferta concluyó el <?= date('d/m/Y', strtotime($job['expires_at'])) ?>. Puedes enviar tu currículum general para que otros contratistas te contacten o consultar las vacantes abiertas.
                                </p>
                                <a href="trabajo.php#vacantes" class="btn btn-secondary" style="font-size: 0.8rem; padding: 6px 14px;">
                                    Ver Otras Vacantes Abiertas →
                                </a>
                            </div>
                        </div>
                    <?php elseif (!$is_active): ?>
                        <!-- Inactive Notice -->
                        <div style="background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 12px; padding: 18px; margin-bottom: 24px; color: #475569; font-size: 0.88rem;">
                            ℹ️ Esta vacante se encuentra temporalmente en pausa por el empleador.
                        </div>
                    <?php endif; ?>

                    <!-- Key Highlights Grid -->
                    <div class="jd-highlights-grid">
                        <div class="jd-highlight-item">
                            <span class="jd-hl-label">Área / Oficio</span>
                            <div class="jd-hl-val"><?= htmlspecialchars($job['category']) ?></div>
                        </div>
                        <div class="jd-highlight-item">
                            <span class="jd-hl-label">Compensación</span>
                            <div class="jd-hl-val" style="color: #059669;"><?= !empty($job['salary']) ? htmlspecialchars($job['salary']) : 'A Convenir' ?></div>
                        </div>
                        <div class="jd-highlight-item">
                            <span class="jd-hl-label">Jornada</span>
                            <div class="jd-hl-val"><?= htmlspecialchars($job['job_type']) ?></div>
                        </div>
                        <div class="jd-highlight-item">
                            <span class="jd-hl-label">Ubicación</span>
                            <div class="jd-hl-val"><?= htmlspecialchars($job['location']) ?></div>
                        </div>
                    </div>

                    <!-- 1. Job Description & Responsibilities -->
                    <div class="jd-card">
                        <div class="jd-card-header">
                            <div class="jd-card-icon">📋</div>
                            <h2 class="jd-card-title">Descripción del Puesto & Responsabilidades</h2>
                        </div>
                        <div class="jd-text">
                            <?= nl2br(htmlspecialchars($job['description'])) ?>
                        </div>
                    </div>

                    <!-- 2. Requirements & Profile -->
                    <?php if (!empty($job['requirements'])): ?>
                        <div class="jd-card">
                            <div class="jd-card-header">
                                <div class="jd-card-icon">🛠️</div>
                                <h2 class="jd-card-title">Requisitos del Candidato & Experiencia</h2>
                            </div>
                            <div class="jd-text">
                                <?= nl2br(htmlspecialchars($job['requirements'])) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- 3. What We Offer & Guarantees -->
                    <div class="jd-card" style="background: #fbfcfe; border-color: #e2e8f0;">
                        <div class="jd-card-header">
                            <div class="jd-card-icon" style="background: #ecfdf5; color: #059669;">🛡️</div>
                            <h2 class="jd-card-title">Proceso de Selección & Compromiso de Confidencialidad</h2>
                        </div>
                        <div class="jd-text" style="font-size: 0.88rem; color: #475569;">
                            <ul style="margin: 0; padding-left: 20px; line-height: 1.7;">
                                <li><strong>Envío directo:</strong> Tu currículum y datos de contacto se entregan inmediatamente al correo de los reclutadores autorizados.</li>
                                <li><strong>Contacto ágil:</strong> El contratista o empresa se comunicará contigo vía WhatsApp o llamada telefónica.</li>
                                <li><strong>Privacidad garantizada:</strong> Tus documentos se gestionan exclusivamente con fines de contratación laboral sin intermediarios innecesarios.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Join Facebook Community Banner -->
                    <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 22px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <div style="background: #1877f2; color: #fff; width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </div>
                            <div>
                                <strong style="color: #1e3a8a; font-size: 1rem; display: block;">¿Buscas más ofertas en Houston?</strong>
                                <span style="font-size: 0.84rem; color: #475569;">Únete al grupo de Facebook "Trabajos para Latinos en Houston" con publicaciones diarias.</span>
                            </div>
                        </div>
                        <a href="<?= FB_TRABAJOS_HOUSTON ?>" target="_blank" rel="noopener noreferrer" class="btn btn-fb" style="padding: 10px 18px;">
                            Unirme al Grupo Oficial
                        </a>
                    </div>

                </div>

                <!-- Right Column: Dedicated Sticky Direct Application Form -->
                <div class="job-detail-sidebar">
                    <div class="job-sidebar-sticky">
                        
                        <div class="card-apply-job" id="card-postulacion">
                            
                            <div class="apply-card-header">
                                <span class="section-badge"><span class="badge-dot"></span> POSTULACIÓN DIRECTA</span>
                                <h3 class="apply-card-title">Aplicar a esta Vacante</h3>
                                <p class="apply-card-subtitle">
                                    Puesto: <strong style="color: #0f274a;"><?= htmlspecialchars($job['title']) ?></strong>
                                </p>
                            </div>

                            <div id="single-form-alert" class="alert-box" style="display: none;"></div>

                            <form id="single-job-form" action="ajax_submit_job.php" method="POST" enctype="multipart/form-data" class="job-form">
                                
                                <!-- Hidden job linking fields -->
                                <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
                                <input type="hidden" name="job_title" value="<?= htmlspecialchars($job['title']) ?>">
                                <input type="hidden" name="category" value="<?= htmlspecialchars($job['category']) ?>">
                                <input type="hidden" name="source_referrer" value="Vacante Web #<?= $job['id'] ?>: <?= htmlspecialchars($job['title']) ?>">

                                <div class="form-group" style="margin-bottom: 12px;">
                                    <label for="fullname">Nombre y Apellido *</label>
                                    <input type="text" id="fullname" name="fullname" required placeholder="Ej. Carlos Mendoza" class="form-control">
                                </div>

                                <div class="form-group" style="margin-bottom: 12px;">
                                    <label for="phone">Teléfono / WhatsApp *</label>
                                    <input type="tel" id="phone" name="phone" required placeholder="Ej. (832) 555-0199" class="form-control">
                                </div>

                                <div class="form-group" style="margin-bottom: 12px;">
                                    <label for="email">Correo Electrónico (Opcional)</label>
                                    <input type="email" id="email" name="email" placeholder="carlos@ejemplo.com" class="form-control">
                                </div>

                                <div class="form-row" style="margin-bottom: 12px;">
                                    <div class="form-group" style="flex: 1;">
                                        <label for="experience_years">Experiencia</label>
                                        <select id="experience_years" name="experience_years" class="form-control" style="font-size: 0.85rem;">
                                            <option value="Menos de 1 año">Menos de 1 año</option>
                                            <option value="1 a 3 años" selected>1 a 3 años</option>
                                            <option value="3 a 5 años">3 a 5 años</option>
                                            <option value="Más de 5 años">Más de 5 años</option>
                                        </select>
                                    </div>
                                    <div class="form-group" style="flex: 1;">
                                        <label for="english_level">Nivel de Inglés</label>
                                        <select id="english_level" name="english_level" class="form-control" style="font-size: 0.85rem;">
                                            <option value="Solo Español">Solo Español</option>
                                            <option value="Básico" selected>Básico</option>
                                            <option value="Intermedio">Intermedio</option>
                                            <option value="Bilingüe">Bilingüe</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" style="margin-bottom: 12px;">
                                    <label for="city_state">Ciudad / Área de Residencia</label>
                                    <input type="text" id="city_state" name="city_state" value="Houston, TX" class="form-control" placeholder="Ej. Houston, Katy, Pasadena">
                                </div>

                                <div class="form-group" style="margin-bottom: 14px;">
                                    <label for="availability">Disponibilidad para Iniciar</label>
                                    <select id="availability" name="availability" class="form-control" style="font-size: 0.85rem;">
                                        <option value="Inmediata" selected>Inmediata (Esta misma semana)</option>
                                        <option value="A 2 semanas">Con 2 semanas de aviso</option>
                                        <option value="Medio Tiempo">Medio Tiempo</option>
                                        <option value="Fines de semana">Fines de semana</option>
                                    </select>
                                </div>

                                <!-- Resume File Upload Dropzone -->
                                <div class="form-group" style="margin-bottom: 16px;">
                                    <label for="resume_file" style="font-weight: 700; color: #0f274a; display: flex; justify-content: space-between; align-items: center;">
                                        <span>Adjuntar Currículum / Resume</span>
                                        <span style="font-size: 0.72rem; color: #64748b; font-weight: normal;">PDF, DOC, DOCX</span>
                                    </label>
                                    
                                    <div class="file-upload-wrapper" id="single-dropzone">
                                        <input type="file" id="resume_file" name="resume_file" accept=".pdf,.doc,.docx,.rtf" class="file-upload-input">
                                        <div class="file-upload-info">
                                            <div style="font-size: 1.5rem; margin-bottom: 2px;">📄</div>
                                            <div class="file-upload-title" style="font-size: 0.85rem;">Arrastra o selecciona tu archivo</div>
                                            <div class="file-upload-hint" style="font-size: 0.75rem;">Máximo 10MB</div>
                                        </div>
                                    </div>

                                    <div id="single-file-container" class="selected-file-display" style="display: none; margin-top: 8px;">
                                        <span id="single-file-name" style="font-size: 0.82rem; font-weight: 600;"></span>
                                        <button type="button" id="btn-remove-single-file" style="background: none; border: none; color: #dc2626; cursor: pointer; font-size: 0.78rem; font-weight: 700;">✕ Quitar</button>
                                    </div>
                                </div>

                                <div class="form-group" style="margin-bottom: 14px;">
                                    <label for="notes">Herramientas o detalles adicionales (Opcional)</label>
                                    <textarea id="notes" name="notes" rows="2" class="form-control" placeholder="¿Tienes herramientas propias, vehículo, licencias especiales?"></textarea>
                                </div>

                                <div class="form-checkbox-group" style="margin-bottom: 16px;">
                                    <label class="checkbox-container">
                                        <input type="checkbox" required checked>
                                        <span style="font-size: 0.78rem;">Autorizo el envío de mi perfil y currículum al empleador para este puesto.</span>
                                    </label>
                                </div>

                                <button type="submit" id="btn-submit-single" class="btn btn-primary btn-lg btn-block" style="font-weight: 800; padding: 12px;">
                                    <span class="btn-text">🚀 Enviar Postulación al Reclutador</span>
                                </button>
                            </form>

                        </div>

                    </div>
                </div>

            </div>
        </main>

        <!-- Bottom Section: Related Jobs in Houston -->
        <?php if (!empty($related_jobs)): ?>
            <section class="related-jobs-section">
                <div class="container">
                    <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 12px;">
                        <div>
                            <span class="section-badge"><span class="badge-dot"></span> MÁS OFERTAS DISPONIBLES</span>
                            <h2 style="font-size: 1.5rem; color: #0f274a; font-weight: 800; margin: 4px 0 0;">Otras Vacantes Activas en Houston</h2>
                        </div>
                        <a href="trabajo.php" class="btn btn-secondary" style="font-size: 0.84rem; padding: 8px 16px;">
                            Ver Todas las Vacantes (<?= count($all_active_jobs) ?>) →
                        </a>
                    </div>

                    <div class="related-jobs-grid">
                        <?php foreach ($related_jobs as $rj): ?>
                            <div class="job-card" style="margin-bottom: 0;">
                                <div>
                                    <div class="job-card-header">
                                        <span class="job-category-badge"><?= htmlspecialchars($rj['category']) ?></span>
                                        <h3 class="job-title" style="font-size: 1.05rem;">
                                            <a href="empleo.php?id=<?= $rj['id'] ?>" style="color: inherit; text-decoration: none;">
                                                <?= htmlspecialchars($rj['title']) ?>
                                            </a>
                                        </h3>
                                        <div class="job-company">
                                            🏢 <?= htmlspecialchars($rj['company']) ?>
                                        </div>
                                    </div>

                                    <div class="job-meta-row">
                                        <span class="job-meta-chip">📍 <?= htmlspecialchars($rj['location']) ?></span>
                                        <?php if (!empty($rj['salary'])): ?>
                                            <span class="job-meta-chip salary">💵 <?= htmlspecialchars($rj['salary']) ?></span>
                                        <?php endif; ?>
                                        <span class="job-meta-chip">⏱️ <?= htmlspecialchars($rj['job_type']) ?></span>
                                    </div>

                                    <p class="job-description-preview" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 12px;">
                                        <?= htmlspecialchars($rj['description']) ?>
                                    </p>
                                </div>

                                <div class="job-card-actions">
                                    <span style="font-size: 0.74rem; color: #64748b;">
                                        <?= date('d M Y', strtotime($rj['created_at'])) ?>
                                    </span>
                                    <a href="empleo.php?id=<?= $rj['id'] ?>" class="btn btn-primary" style="font-size: 0.82rem; padding: 6px 14px;">
                                        Ver Vacante →
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- Interactive Script for Single Job Form Submission, File Drag & Drop, and Link Copy -->
        <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Copy Link Button
            const copyBtn = document.getElementById('btn-copy-link');
            const copyFeedback = document.getElementById('copy-feedback');
            if (copyBtn) {
                copyBtn.addEventListener('click', () => {
                    navigator.clipboard.writeText(window.location.href).then(() => {
                        copyFeedback.style.display = 'inline';
                        setTimeout(() => {
                            copyFeedback.style.display = 'none';
                        }, 3000);
                    }).catch(err => {
                        console.error('Error al copiar enlace:', err);
                    });
                });
            }

            // 2. File Upload Drag & Drop and Preview
            const fileInput = document.getElementById('resume_file');
            const dropzone = document.getElementById('single-dropzone');
            const fileContainer = document.getElementById('single-file-container');
            const fileNameDisplay = document.getElementById('single-file-name');
            const removeFileBtn = document.getElementById('btn-remove-single-file');

            if (fileInput && dropzone) {
                fileInput.addEventListener('change', function() {
                    handleFileSelection(this.files[0]);
                });

                ['dragenter', 'dragover'].forEach(eventName => {
                    dropzone.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        dropzone.style.borderColor = '#0f274a';
                        dropzone.style.background = '#f0fdf4';
                    });
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropzone.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        dropzone.style.borderColor = '#cbd5e1';
                        dropzone.style.background = '#f8fafc';
                    });
                });

                dropzone.addEventListener('drop', (e) => {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    if (files.length > 0) {
                        fileInput.files = files;
                        handleFileSelection(files[0]);
                    }
                });

                function handleFileSelection(file) {
                    if (file) {
                        const ext = file.name.split('.').pop().toLowerCase();
                        const allowed = ['pdf', 'doc', 'docx', 'rtf'];
                        if (!allowed.includes(ext)) {
                            alert('Formato de archivo no permitido. Solo se aceptan archivos PDF, DOC, DOCX o RTF.');
                            fileInput.value = '';
                            fileContainer.style.display = 'none';
                            return;
                        }
                        const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
                        if (sizeMb > 10) {
                            alert('El archivo supera el límite de 10MB.');
                            fileInput.value = '';
                            fileContainer.style.display = 'none';
                            return;
                        }
                        fileNameDisplay.textContent = `📎 ${file.name} (${sizeMb} MB)`;
                        fileContainer.style.display = 'flex';
                    }
                }

                if (removeFileBtn) {
                    removeFileBtn.addEventListener('click', () => {
                        fileInput.value = '';
                        fileContainer.style.display = 'none';
                        fileNameDisplay.textContent = '';
                    });
                }
            }

            // 3. AJAX Form Submission
            const form = document.getElementById('single-job-form');
            const alertBox = document.getElementById('single-form-alert');
            const submitBtn = document.getElementById('btn-submit-single');

            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    alertBox.style.display = 'none';
                    alertBox.className = 'alert-box';
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner" style="display:inline-block; width:16px; height:16px; border:2px solid #fff; border-top-color:transparent; border-radius:50%; animation:spin 0.8s linear infinite; margin-right:8px; vertical-align:middle;"></span> Enviando postulación...';

                    const formData = new FormData(this);

                    fetch('ajax_submit_job.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<span class="btn-text">🚀 Enviar Postulación al Reclutador</span>';

                        if (data.success) {
                            alertBox.className = 'alert-box success';
                            alertBox.innerHTML = `
                                <strong>¡Postulación enviada con éxito!</strong><br>
                                Tu ficha y currículum han sido notificados al equipo de reclutamiento de <strong>${escapeHtml(form.querySelector('[name="job_title"]').value)}</strong>.<br>
                                <span style="font-size:0.82rem; margin-top:4px; display:inline-block;">Te contactaremos pronto por llamada o WhatsApp.</span>
                            `;
                            alertBox.style.display = 'block';
                            form.reset();
                            if (fileContainer) fileContainer.style.display = 'none';
                        } else {
                            alertBox.className = 'alert-box error';
                            alertBox.innerHTML = `<strong>Error:</strong> ${data.message || 'Ocurrió un problema al enviar tu postulación. Por favor verifica tus datos e intenta de nuevo.'}`;
                            alertBox.style.display = 'block';
                        }
                    })
                    .catch(err => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<span class="btn-text">🚀 Enviar Postulación al Reclutador</span>';
                        alertBox.className = 'alert-box error';
                        alertBox.innerHTML = '<strong>Error de conexión:</strong> No se pudo conectar con el servidor. Por favor intenta nuevamente.';
                        alertBox.style.display = 'block';
                    });
                });
            }

            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }
        });
        </script>

    <?php endif; ?>

<?php
require_once __DIR__ . '/footer.php';
?>
