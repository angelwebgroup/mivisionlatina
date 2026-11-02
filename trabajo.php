<?php
/**
 * MI VISIÓN LATINA - BOLSA DE EMPLEO & TRABAJO LATINO
 * Vacantes publicadas en Houston y Texas, postulación de candidatos y carga de currículum
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

$from_fb = isset($_GET['from']) && $_GET['from'] === 'facebook';
$source = isset($_GET['source']) ? htmlspecialchars($_GET['source']) : ($from_fb ? 'Facebook - Trabajos para Latinos en Houston' : 'Portal Web');

// Search & category filter for jobs
$filter_cat = trim($_GET['cat'] ?? '');
$search_q = trim($_GET['q'] ?? '');
$selected_job_id = (int)($_GET['apply_id'] ?? 0);

$jobs = get_jobs($filter_cat, $search_q, 'Activo');
$stats = get_candidato_stats();

$prefill_job = null;
if ($selected_job_id > 0) {
    $prefill_job = get_job_by_id($selected_job_id);
}

require_once __DIR__ . '/header.php';
?>

    <!-- Page Hero Banner -->
    <section class="hero-section" style="padding: 55px 0 45px; background: linear-gradient(180deg, #f1f5f9 0%, #ffffff 100%); border-bottom: 1px solid #e2e8f0;">
        <div class="container text-center">
            <span class="section-badge"><span class="badge-dot"></span> TRABAJO LATINO · BOLSA DE EMPLEO</span>
            <h1 class="hero-title" style="font-size: 2.2rem; margin: 12px 0 8px;">
                Vacantes Disponibles & <span class="text-gradient">Oportunidades Laborales</span>
            </h1>
            <p class="hero-description" style="max-width: 760px; margin: 0 auto 20px; font-size: 1rem; color: #475569;">
                Conectamos a la fuerza laboral hispana con contratistas, empresas y negocios en el área metropolitana de Houston y todo Texas. Consulta las vacantes abiertas o regístrate en nuestra base general con tu currículum.
            </p>

            <div style="display: inline-flex; gap: 20px; flex-wrap: wrap; justify-content: center; font-size: 0.85rem; color: #334155;">
                <span style="display: inline-flex; align-items: center; gap: 6px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="#16a34a"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    <strong><?= count($jobs) ?> Vacantes Activas</strong>
                </span>
                <span style="display: inline-flex; align-items: center; gap: 6px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="#0284c7"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                    Recepción de CV en <strong>PDF, DOC, DOCX, RTF</strong>
                </span>
                <span style="display: inline-flex; align-items: center; gap: 6px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="#d97706"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    Envío Directo a Reclutadores
                </span>
            </div>
        </div>
    </section>

    <!-- Facebook Community Notice -->
    <?php if ($from_fb): ?>
    <section class="container" style="margin-top: 35px; margin-bottom: 15px;">
        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 16px 22px; display: flex; align-items: center; gap: 14px;">
            <div style="background: #1877f2; color: #fff; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </div>
            <div>
                <strong style="color: #1e3a8a; font-size: 0.95rem;">Bienvenido desde el Grupo de Facebook "Trabajos para Latinos en Houston"</strong>
                <p style="margin: 0; font-size: 0.84rem; color: #475569;">Puedes postularte a cualquiera de las vacantes a continuación o llenar tu ficha general para que los contratistas te encuentren.</p>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Main Content: Job Postings & Application Form -->
    <main class="container" style="padding-top: 50px; padding-bottom: 90px;">

        <!-- 1. Section: Posted Jobs List -->
        <section id="vacantes" style="margin-bottom: 70px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 18px; flex-wrap: wrap; gap: 12px;">
                <div>
                    <span class="section-badge"><span class="badge-dot"></span> OFERTAS RECIENTES</span>
                    <h2 style="font-size: 1.6rem; margin: 4px 0 0; color: #0f274a; font-weight: 800;">Vacantes Publicadas en el Portal</h2>
                </div>
                <a href="#formulario" class="btn btn-secondary" style="font-size: 0.84rem; padding: 8px 16px;">
                    ✍️ Ir al Formulario de Postulación General
                </a>
            </div>

            <!-- Category Pills / Tabs Bar -->
            <?php
            $cat_tabs = [
                '' => 'Todas las Ofertas',
                'Construcción / Remodelación' => 'Construcción',
                'Limpieza Residencial / Comercial' => 'Limpieza',
                'Restaurante / Cocina / Mesero' => 'Restaurante / Cocina',
                'Chofer / Delivery / Transporte' => 'Chofer / CDL',
                'Electricidad / Plomería / HVAC' => 'HVAC / Electricidad',
                'Bodega / Warehouse / Empaque' => 'Bodega / Warehouse',
                'Ventas / Atención al Cliente' => 'Ventas'
            ];
            ?>
            <div class="category-tabs-bar" style="display: flex; gap: 8px; overflow-x: auto; padding-bottom: 8px; margin-bottom: 18px;">
                <?php foreach ($cat_tabs as $c_val => $c_label): ?>
                    <a href="trabajo.php?cat=<?= urlencode($c_val) ?>#vacantes" class="cat-pill <?= $filter_cat === $c_val ? 'active' : '' ?>" style="text-decoration: none; padding: 7px 15px; border-radius: 9999px; font-size: 0.82rem; font-weight: 600; white-space: nowrap; transition: all 0.2s; <?= $filter_cat === $c_val ? 'background: #0f274a; color: #fff; box-shadow: 0 2px 6px rgba(15,39,74,0.18);' : 'background: #ffffff; color: #475569; border: 1px solid #cbd5e1;' ?>">
                        <?= $c_label ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Filter & Search Box -->
            <div class="jobs-filter-card">
                <form method="GET" action="trabajo.php#vacantes" class="jobs-search-row">
                    <input type="text" name="q" value="<?= htmlspecialchars($search_q) ?>" placeholder="Buscar por palabra clave, oficio o empresa (ej. Remodelación, Limpieza, Chofer)..." class="form-control">
                    
                    <select name="cat" class="form-control">
                        <option value="">Todas las Categorías</option>
                        <option value="Construcción / Remodelación" <?= $filter_cat === 'Construcción / Remodelación' ? 'selected' : '' ?>>Construcción / Remodelación</option>
                        <option value="Limpieza Residencial / Comercial" <?= $filter_cat === 'Limpieza Residencial / Comercial' ? 'selected' : '' ?>>Limpieza Residencial / Comercial</option>
                        <option value="Restaurante / Cocina / Mesero" <?= $filter_cat === 'Restaurante / Cocina / Mesero' ? 'selected' : '' ?>>Restaurante / Cocina</option>
                        <option value="Chofer / Delivery / Transporte" <?= $filter_cat === 'Chofer / Delivery / Transporte' ? 'selected' : '' ?>>Chofer / Transporte CDL</option>
                        <option value="Electricidad / Plomería / HVAC" <?= $filter_cat === 'Electricidad / Plomería / HVAC' ? 'selected' : '' ?>>Electricidad / HVAC</option>
                        <option value="Bodega / Warehouse / Empaque" <?= $filter_cat === 'Bodega / Warehouse / Empaque' ? 'selected' : '' ?>>Bodega / Warehouse</option>
                        <option value="Ventas / Atención al Cliente" <?= $filter_cat === 'Ventas / Atención al Cliente' ? 'selected' : '' ?>>Ventas / Atención</option>
                        <option value="Administración / Oficina" <?= $filter_cat === 'Administración / Oficina' ? 'selected' : '' ?>>Administración</option>
                    </select>

                    <button type="submit" class="btn btn-primary" style="padding: 10px 22px;">Buscar Vacantes</button>
                    
                    <?php if (!empty($filter_cat) || !empty($search_q)): ?>
                        <a href="trabajo.php#vacantes" class="btn btn-outline" style="display: inline-flex; align-items: center; padding: 10px 14px;">Restablecer</a>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Jobs Grid -->
            <?php if (empty($jobs)): ?>
                <div style="background: #ffffff; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 40px; text-align: center; color: #64748b;">
                    <p style="font-size: 1.1rem; font-weight: 600; color: #0f274a; margin-bottom: 6px;">No se encontraron vacantes con los criterios de búsqueda.</p>
                    <p style="font-size: 0.88rem; margin-bottom: 20px;">Intenta con otro término o llena el formulario general para que los contratistas revisen tu currículum.</p>
                    <a href="trabajo.php#formulario" class="btn btn-primary">Registrar mi Currículum en la Base General</a>
                </div>
            <?php else: ?>
                <div class="jobs-list-grid">
                    <?php foreach ($jobs as $job): ?>
                        <div class="job-card" id="job-<?= $job['id'] ?>">
                            <div>
                                <div class="job-card-header">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; gap: 8px;">
                                        <span class="job-category-badge"><?= htmlspecialchars($job['category']) ?></span>
                                        <?php if (!empty($job['expires_at'])): ?>
                                            <span style="font-size: 0.72rem; color: #854d0e; background: #fefce8; border: 1px solid #fef08a; padding: 2px 8px; border-radius: 9999px; font-weight: 600;">
                                                ⏳ Vence: <?= date('d M', strtotime($job['expires_at'])) ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <h3 class="job-title">
                                        <a href="empleo.php?id=<?= $job['id'] ?>" style="color: inherit; text-decoration: none;">
                                            <?= htmlspecialchars($job['title']) ?>
                                        </a>
                                    </h3>
                                    <div class="job-company">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" style="color: #64748b;"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/></svg>
                                        <?= htmlspecialchars($job['company']) ?>
                                        <span style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; font-size: 0.65rem; padding: 1px 5px; border-radius: 3px; font-weight: 700; margin-left: 4px;">Verificado</span>
                                    </div>
                                </div>

                                <div class="job-meta-row">
                                    <span class="job-meta-chip">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                                        <?= htmlspecialchars($job['location']) ?>
                                    </span>
                                    <?php if (!empty($job['salary'])): ?>
                                        <span class="job-meta-chip salary">
                                            💵 <?= htmlspecialchars($job['salary']) ?>
                                        </span>
                                    <?php endif; ?>
                                    <span class="job-meta-chip">
                                        ⏱️ <?= htmlspecialchars($job['job_type']) ?>
                                    </span>
                                </div>

                                <div class="job-description-preview" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 16px;">
                                    <?= htmlspecialchars($job['description']) ?>
                                </div>
                            </div>

                            <div class="job-card-actions">
                                <span style="font-size: 0.74rem; color: #64748b;">
                                    Publicado: <?= date('d M Y', strtotime($job['created_at'])) ?>
                                </span>
                                <a href="empleo.php?id=<?= $job['id'] ?>" class="btn btn-primary" style="font-size: 0.84rem; font-weight: 700; padding: 8px 16px; text-decoration: none;">
                                    Ver Vacante & Postularme →
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <!-- 2. Section: Candidate Application Form & Resume Upload -->
        <section id="formulario" style="scroll-margin-top: 100px;">
            <div class="trabajo-grid">
                
                <!-- Left: Application Form with Resume Upload -->
                <div class="trabajo-form-wrap">
                    <div class="card card-form">
                        <div class="card-form-header">
                            <span class="section-badge"><span class="badge-dot"></span> BOLSA GENERAL DE EMPLEO</span>
                            <h2 style="font-size: 1.5rem; margin-top: 6px;">Registro General de Candidatos & CV</h2>
                            <p>¿Buscas empleo en Houston pero no encontraste una vacante específica para tu oficio? Deja tus datos y adjunta tu currículum (CV) para que los contratistas y empleadores locales te contacten directamente.</p>
                        </div>

                        <?php if ($prefill_job): ?>
                            <!-- Active Job Target Banner -->
                            <div class="job-target-banner" style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 14px; margin-bottom: 18px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                                <div style="font-size: 0.88rem; color: #1e3a8a;">
                                    <span>Estás consultando la vacante:</span>
                                    <strong style="display: block; font-size: 0.96rem;"><?= htmlspecialchars($prefill_job['title']) ?></strong>
                                </div>
                                <a href="empleo.php?id=<?= $prefill_job['id'] ?>" class="btn btn-primary" style="font-size: 0.8rem; padding: 6px 14px;">
                                    Ver Página Dedicada de esta Vacante →
                                </a>
                            </div>
                        <?php endif; ?>

                        <div id="form-alert" class="alert-box" style="display: none;"></div>

                        <form id="job-candidate-form" action="ajax_submit_job.php" method="POST" enctype="multipart/form-data" class="job-form">
                            <!-- Hidden tracking fields -->
                            <input type="hidden" name="source_referrer" value="<?= htmlspecialchars($source) ?>">
                            <input type="hidden" id="job_id" name="job_id" value="<?= $prefill_job ? $prefill_job['id'] : 0 ?>">
                            <input type="hidden" id="job_title" name="job_title" value="<?= $prefill_job ? htmlspecialchars($prefill_job['title']) : 'Bolsa General' ?>">

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="fullname">Nombre y Apellido *</label>
                                    <input type="text" id="fullname" name="fullname" required placeholder="Ej. Carlos Mendoza" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Teléfono / WhatsApp *</label>
                                    <input type="tel" id="phone" name="phone" required placeholder="Ej. (832) 555-0199" class="form-control">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="email">Correo Electrónico (Para recibir ofertas)</label>
                                    <input type="email" id="email" name="email" placeholder="carlos@ejemplo.com" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="city_state">Ciudad y Estado *</label>
                                    <input type="text" id="city_state" name="city_state" value="Houston, TX" required class="form-control" placeholder="Ej. Houston, TX / Katy, TX">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="category">Área u Oficio *</label>
                                    <select id="category" name="category" required class="form-control">
                                        <option value="">-- Selecciona una categoría --</option>
                                        <option value="Construcción / Remodelación" <?= ($prefill_job && $prefill_job['category'] === 'Construcción / Remodelación') ? 'selected' : '' ?>>Construcción / Remodelación / Techos</option>
                                        <option value="Limpieza Residencial / Comercial" <?= ($prefill_job && $prefill_job['category'] === 'Limpieza Residencial / Comercial') ? 'selected' : '' ?>>Limpieza Residencial / Comercial</option>
                                        <option value="Restaurante / Cocina / Mesero" <?= ($prefill_job && $prefill_job['category'] === 'Restaurante / Cocina / Mesero') ? 'selected' : '' ?>>Restaurante / Cocina / Personal de Servicio</option>
                                        <option value="Chofer / Delivery / Transporte" <?= ($prefill_job && $prefill_job['category'] === 'Chofer / Delivery / Transporte') ? 'selected' : '' ?>>Chofer (CDL / Licencia C) / Transporte</option>
                                        <option value="Bodega / Warehouse / Empaque" <?= ($prefill_job && $prefill_job['category'] === 'Bodega / Warehouse / Empaque') ? 'selected' : '' ?>>Bodega / Operador de Montacargas</option>
                                        <option value="Electricidad / Plomería / HVAC" <?= ($prefill_job && $prefill_job['category'] === 'Electricidad / Plomería / HVAC') ? 'selected' : '' ?>>Electricidad / Plomería / Climatización (HVAC)</option>
                                        <option value="Pintura y Tablaroca">Pintura / Sheetrock / Acabados</option>
                                        <option value="Mecánica Automotriz">Mecánica Automotriz / Taller</option>
                                        <option value="Jardinería / Landscaping">Jardinería / Landscaping</option>
                                        <option value="Ventas / Atención al Cliente">Ventas / Atención al Cliente</option>
                                        <option value="Administración / Oficina">Administración y Oficina</option>
                                        <option value="Otro">Otro oficio o profesión</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="experience_years">Años de Experiencia</label>
                                    <select id="experience_years" name="experience_years" class="form-control">
                                        <option value="Sin experiencia previa">Sin experiencia previa (Con disposición)</option>
                                        <option value="Menos de 1 año">Menos de 1 año</option>
                                        <option value="1 a 3 años" selected>1 a 3 años</option>
                                        <option value="3 a 5 años">3 a 5 años</option>
                                        <option value="Más de 5 años">Más de 5 años (Especialista)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="english_level">Nivel de Inglés</label>
                                    <select id="english_level" name="english_level" class="form-control">
                                        <option value="Solo Español">Solo Español</option>
                                        <option value="Básico" selected>Básico (Comprensión elemental)</option>
                                        <option value="Intermedio">Intermedio (Conversacional)</option>
                                        <option value="Bilingüe">Bilingüe / Fluido</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="availability">Disponibilidad</label>
                                    <select id="availability" name="availability" class="form-control">
                                        <option value="Inmediata" selected>Inmediata (Tiempo Completo)</option>
                                        <option value="Medio Tiempo">Medio Tiempo (Part-Time)</option>
                                        <option value="Fines de semana">Fines de semana</option>
                                        <option value="Por proyectos">Por proyectos o subcontrato</option>
                                    </select>
                                </div>
                            </div>

                            <!-- RESUME FILE UPLOAD INPUT (.DOC, .DOCX, .PDF, .RTF) -->
                            <div class="form-group" style="margin-top: 10px; margin-bottom: 22px;">
                                <label for="resume_file" style="font-weight: 700; color: #0f274a; display: flex; align-items: center; justify-content: space-between;">
                                    <span>Adjuntar Currículum / Resume (Opcional pero recomendado)</span>
                                    <span style="font-size: 0.74rem; font-weight: normal; color: #64748b;">Máx 10MB</span>
                                </label>

                                <div class="file-upload-wrapper" id="file-upload-dropzone">
                                    <input type="file" id="resume_file" name="resume_file" accept=".pdf,.doc,.docx,.rtf" class="file-upload-input">
                                    <div class="file-upload-info">
                                        <div style="font-size: 1.8rem; margin-bottom: 4px;">📄</div>
                                        <div class="file-upload-title">Haz clic aquí o arrastra tu Currículum Vitae</div>
                                        <div class="file-upload-hint">Formatos aceptados: <strong>PDF, DOC, DOCX, RTF</strong></div>
                                    </div>
                                </div>

                                <div id="selected-file-container" class="selected-file-display" style="display: none;">
                                    <span id="selected-file-name"></span>
                                    <button type="button" id="btn-remove-file" style="background: none; border: none; color: #dc2626; cursor: pointer; font-size: 0.8rem; font-weight: 600;">✕ Quitar</button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="notes">Herramientas, certificaciones o detalles adicionales (Opcional)</label>
                                <textarea id="notes" name="notes" rows="3" class="form-control" placeholder="¿Cuentas con herramientas propias, transporte, certificaciones (OSHA, CDL, EPA, Food Handler)?"></textarea>
                            </div>

                            <div class="form-checkbox-group">
                                <label class="checkbox-container">
                                    <input type="checkbox" required checked>
                                    <span>Acepto que mis datos y currículum sean compartidos con empleadores y contratistas verificados en Houston y Texas.</span>
                                </label>
                            </div>

                            <button type="submit" id="btn-submit-job" class="btn btn-primary btn-lg btn-block">
                                <span class="btn-text">Enviar Postulación y Currículum</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right: Information & Trust Column -->
                <div class="trabajo-info-wrap">
                    
                    <!-- FB Group Card -->
                    <div class="card card-fb-highlight">
                        <div class="fb-card-top">
                            <div class="fb-icon-circle">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="#fff"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </div>
                            <div>
                                <span class="fb-label">GRUPO OFICIAL EN FACEBOOK</span>
                                <h3 style="margin: 0; font-size: 1.05rem; font-weight: 800; color: #0f274a;">Trabajos para Latinos en Houston</h3>
                            </div>
                        </div>
                        <p class="fb-card-desc">
                            Únete a miles de miembros activos en nuestra comunidad laboral en Facebook. Ofertas de empleo publicadas diariamente por contratistas locales.
                        </p>
                        <a href="<?= FB_TRABAJOS_HOUSTON ?>" target="_blank" rel="noopener noreferrer" class="btn btn-fb" style="width: 100%;">
                            <span>Abrir Grupo en Facebook</span>
                        </a>
                    </div>

                    <!-- Steps Card -->
                    <div class="card card-steps">
                        <h3 class="card-steps-title">¿Cómo Funciona el Proceso?</h3>
                        
                        <div class="step-item">
                            <div class="step-num">1</div>
                            <div class="step-content">
                                <h4>Postulación & Carga de CV</h4>
                                <p>Eliges la vacante de tu interés y adjuntas tu currículum en formato Word o PDF.</p>
                            </div>
                        </div>

                        <div class="step-item">
                            <div class="step-num">2</div>
                            <div class="step-content">
                                <h4>Notificación Automática</h4>
                                <p>Tu solicitud llega inmediatamente al correo institucional del equipo de contratación.</p>
                            </div>
                        </div>

                        <div class="step-item">
                            <div class="step-num">3</div>
                            <div class="step-content">
                                <h4>Contacto Directo</h4>
                                <p>El empleador o contratista se comunicará contigo vía WhatsApp o llamada telefónica.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Guarantee Card -->
                    <div class="card card-guarantee">
                        <div class="guarantee-text">
                            <h4>Compromiso de Privacidad</h4>
                            <p>Tus datos y archivos adjuntos son tratados con estricta confidencialidad para fines exclusivos de colocación laboral.</p>
                        </div>
                    </div>

                </div>

            </div>
        </section>

    </main>

    <!-- Specific Interactive Script for Job Selection and File Drag & Drop -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const applyButtons = document.querySelectorAll('.btn-apply-job');
        const targetBox = document.getElementById('job-target-box');
        const targetName = document.getElementById('job-target-name');
        const clearBtn = document.getElementById('btn-clear-target');
        const jobIdInput = document.getElementById('job_id');
        const jobTitleInput = document.getElementById('job_title');
        const categorySelect = document.getElementById('category');

        applyButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const jobId = this.getAttribute('data-job-id');
                const jobTitle = this.getAttribute('data-job-title');
                const cat = this.getAttribute('data-category');

                if (jobIdInput) jobIdInput.value = jobId;
                if (jobTitleInput) jobTitleInput.value = jobTitle;
                if (targetName) targetName.textContent = jobTitle;
                if (targetBox) targetBox.style.display = 'flex';

                if (cat && categorySelect) {
                    for (let option of categorySelect.options) {
                        if (option.value === cat) {
                            categorySelect.value = cat;
                            break;
                        }
                    }
                }

                // Smooth scroll to form
                const formSection = document.getElementById('formulario');
                if (formSection) {
                    formSection.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        if (clearBtn) {
            clearBtn.addEventListener('click', () => {
                if (jobIdInput) jobIdInput.value = '0';
                if (jobTitleInput) jobTitleInput.value = 'Bolsa General';
                if (targetBox) targetBox.style.display = 'none';
            });
        }

        // File upload UI feedback
        const fileInput = document.getElementById('resume_file');
        const fileContainer = document.getElementById('selected-file-container');
        const fileNameSpan = document.getElementById('selected-file-name');
        const removeFileBtn = document.getElementById('btn-remove-file');

        if (fileInput) {
            fileInput.addEventListener('change', function() {
                if (this.files && this.files.length > 0) {
                    const file = this.files[0];
                    const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                    fileNameSpan.textContent = `📎 ${file.name} (${sizeMB} MB)`;
                    fileContainer.style.display = 'flex';
                } else {
                    fileContainer.style.display = 'none';
                }
            });
        }

        if (removeFileBtn) {
            removeFileBtn.addEventListener('click', () => {
                if (fileInput) fileInput.value = '';
                if (fileContainer) fileContainer.style.display = 'none';
            });
        }
    });
    </script>

<?php require_once __DIR__ . '/footer.php'; ?>
