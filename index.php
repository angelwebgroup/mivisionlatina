<?php
/**
 * MI VISIÓN LATINA - Portal Principal
 * "Informar · Educar · Conectar · Impulsar oportunidades"
 * Portal oficial: mivisionlatina.com
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

// Detect if visitor came from Facebook campaign (e.g. from trabajosparalatinosenhouston)
$is_from_facebook = (isset($_GET['from']) && $_GET['from'] === 'facebook') || (isset($_GET['fbclid']));
$candidate_stats = get_candidato_stats();

include __DIR__ . '/header.php';
?>

<!-- 1. HERO SECTION -->
<section class="hero-section" id="inicio">
    <div class="container hero-grid">
        
        <!-- Left Hero Content -->
        <div class="hero-content">
            <div class="hero-pill-badge">
                <span class="live-pulse"></span>
                <span>PORTAL INFORMATIVO Y COMUNITARIO</span>
            </div>

            <h1 class="hero-title">
                La Gran Voz de la <br>
                <span class="text-gradient">Comunidad Hispana</span> en EE.UU.
            </h1>

            <div class="hero-tagline-pills">
                <span class="tag-pill">Informar</span>
                <span class="tag-pill">Educar</span>
                <span class="tag-pill">Conectar</span>
                <span class="tag-pill">Impulsar Oportunidades</span>
            </div>

            <p class="hero-description">
                Bienvenidos a <strong>Mi Visión Latina</strong>. Accede a las transmisiones y emisiones de <em>Plática con Luis</em>, noticias comunitarias con <em>Élite Noticias</em> y <em>La Plati-K</em>, asesoría financiera, oportunidades de empleo para trabajadores en Houston y las publicaciones de Luis Bernal.
            </p>

            <div class="hero-cta-group">
                <a href="transmisiones.php" class="btn btn-live">
                    <span class="live-pulse"></span>
                    <span>Ver Transmisiones en Vivo</span>
                </a>
                <a href="trabajo.php" class="btn btn-primary">
                    <span>Bolsa de Empleo</span>
                </a>
                <a href="libros.php" class="btn btn-secondary">
                    <span>Libros en Amazon</span>
                </a>
            </div>

            <div class="hero-social-strip">
                <span class="hero-social-label">Canales oficiales:</span>
                <div class="hero-social-icons">
                    <a href="<?= FB_MI_VISION_LATINA ?>" target="_blank" rel="noopener noreferrer" class="social-icon-btn fb" title="Facebook Mi Visión Latina">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="<?= YT_PLATICA_CON_LUIS ?>" target="_blank" rel="noopener noreferrer" class="social-icon-btn yt" title="YouTube Plática con Luis">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                    <a href="<?= FB_TRABAJOS_HOUSTON ?>" target="_blank" rel="noopener noreferrer" class="social-icon-btn fb" title="Facebook Trabajos para Latinos en Houston">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"></path><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                    </a>
                    <a href="<?= AMAZON_STORE_LUIS_BERNAL ?>" target="_blank" rel="noopener noreferrer" class="social-icon-btn az" title="Amazon Author Luis Bernal">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Hero: Interactive Live Studio Card -->
        <div class="hero-media-wrap">
            <div class="hero-media-card" id="studio-interactive-card">
                
                <!-- Studio Card Header with Dynamic Live / Off-Air Status -->
                <div class="studio-card-top">
                    <?php if (IS_LIVE_BROADCAST): ?>
                        <span class="studio-status-pill on-air">
                            <span class="live-pulse"></span> EN VIVO · ON AIR
                        </span>
                    <?php else: ?>
                        <span class="studio-status-pill off-air">
                            <span class="offair-dot"></span> FUERA DEL AIRE · REPETICIÓN
                        </span>
                    <?php endif; ?>
                    <span class="studio-show-title" id="studio-active-title">Plática con Luis</span>
                </div>

                <!-- Video Screen Embed -->
                <div class="studio-video-frame">
                    <iframe 
                        id="hero-studio-player" 
                        src="https://www.youtube-nocookie.com/embed/<?= DEFAULT_VIDEO_ID ?>?autoplay=0&rel=0" 
                        title="Plática con Luis · Estudio y Programas" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen
                        loading="lazy">
                    </iframe>
                </div>

                <!-- Action Buttons: YouTube Subscribe & Facebook Live -->
                <div class="studio-actions-row">
                    <a href="<?= YT_PLATICA_CON_LUIS ?>?sub_confirmation=1" target="_blank" rel="noopener noreferrer" class="btn btn-yt btn-sm">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        <span>Suscribirme en YouTube</span>
                    </a>
                    <a href="<?= FB_PLATICA_CON_LUIS ?>" target="_blank" rel="noopener noreferrer" class="btn btn-fb btn-sm">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        <span>Facebook Live</span>
                    </a>
                </div>

                <!-- Latest Episodes & Previous Programs Navigator -->
                <div class="studio-episodes-wrap">
                    <div class="studio-episodes-header">
                        <span class="studio-episodes-title">Programas y Episodios</span>
                        <span class="studio-episodes-hint">Toca un título para ver</span>
                    </div>
                    <div class="studio-episodes-list">
                        
                        <!-- Ep 1 -->
                        <div class="studio-ep-item active" 
                             data-video-id="2Jg8AxS_IZU" 
                             data-title="Los políticos fracasan porque no escuchan · Plática con Luis">
                            <span class="studio-ep-title">1. Los políticos fracasan porque no escuchan</span>
                            <span class="studio-ep-badge">▶ Actual</span>
                        </div>

                        <!-- Ep 2 -->
                        <div class="studio-ep-item" 
                             data-video-id="bz1mCVVkJFE" 
                             data-title="Expectativas de las elecciones de medio término en USA · Plática con Luis">
                            <span class="studio-ep-title">2. Elecciones de medio término en USA</span>
                            <span class="studio-ep-badge">▶ Ver</span>
                        </div>

                        <!-- Ep 3 -->
                        <div class="studio-ep-item" 
                             data-video-id="SX1vgHVBFLs" 
                             data-title="Qué le falta a El Salvador para desarrollarse · Plática con Luis">
                            <span class="studio-ep-title">3. Qué le falta a El Salvador para crecer</span>
                            <span class="studio-ep-badge">▶ Ver</span>
                        </div>

                        <!-- Ep 4 -->
                        <div class="studio-ep-item" 
                             data-video-id="B57hasvhDOk" 
                             data-title="Cómo invertir en bolsa fácil con $10 · Educador Financiero USA">
                            <span class="studio-ep-title">4. Cómo invertir en bolsa paso a paso</span>
                            <span class="studio-ep-badge">▶ Ver</span>
                        </div>

                        <!-- Ep 5 -->
                        <div class="studio-ep-item" 
                             data-video-id="_wL7SN6kMZI" 
                             data-title="TPS El Salvador será o no será · La Plati-K">
                            <span class="studio-ep-title">5. TPS El Salvador será o no será</span>
                            <span class="studio-ep-badge">▶ Ver</span>
                        </div>

                    </div>
                </div>

                <!-- Studio Card Footer -->
                <div class="hero-media-footer">
                    <div class="hero-host-info">
                        <img src="images/logo-mivisionlatina.png" alt="Luis Bernal" class="hero-host-avatar">
                        <div>
                            <h4 class="hero-host-name">Luis Bernal</h4>
                            <span class="hero-host-role">Martes y Jueves · 7:00 PM CST</span>
                        </div>
                    </div>
                    <span style="font-size: 0.76rem; color: #64748b; font-weight: 600;">Enlace Satelital & Digital</span>
                </div>

            </div>
        </div>

    </div>
</section>

<!-- 2. PROGRAMAS Y TRANSMISIONES (REPRODUCTOR DE VIDEO) -->
<section class="section-transmisiones" id="transmisiones">
    <div class="container">
        
        <div class="section-header text-center">
            <span class="section-badge"><span class="badge-dot"></span> TRANSMISIONES</span>
            <h2 class="section-title">Programas y Emisiones</h2>
            <p class="section-subtitle">
                Accede a las transmisiones de <strong>Plática con Luis</strong>, reportes comunitarios y producciones audiovisuales.
            </p>
        </div>

        <!-- Video Player Module -->
        <div class="video-player-container">
            <div class="player-main-header">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span class="player-status-badge">
                        <span class="live-pulse"></span> SEÑAL EN DIRECTO
                    </span>
                    <h3 class="player-stream-title" id="current-stream-title">Plática con Luis · Charla, Opiniones y Comunidad</h3>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="<?= YT_PLATICA_CON_LUIS ?>" target="_blank" rel="noopener noreferrer" class="btn btn-yt" style="padding: 7px 14px; font-size: 0.82rem;">
                        Ver en YouTube
                    </a>
                    <a href="<?= FB_PLATICA_CON_LUIS ?>" target="_blank" rel="noopener noreferrer" class="btn btn-fb" style="padding: 7px 14px; font-size: 0.82rem;">
                        Ver en Facebook
                    </a>
                </div>
            </div>

            <div class="player-grid-layout">
                <!-- Video Screen -->
                <div class="video-screen-wrap">
                    <iframe 
                        id="main-stream-player"
                        src="https://www.youtube-nocookie.com/embed/2Jg8AxS_IZU?autoplay=0&rel=0" 
                        title="Plática con Luis · Emisión Oficial" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen
                        loading="lazy">
                    </iframe>
                </div>

                <!-- Playlist / Channels -->
                <div class="stream-sidebar">
                    <span class="stream-sidebar-title">Programas Disponibles</span>
                    <div class="stream-channels-list">
                        
                        <!-- Channel 1: Plática con Luis -->
                        <div class="stream-channel-card active" 
                             data-video-url="https://www.youtube-nocookie.com/embed/2Jg8AxS_IZU?autoplay=1&rel=0"
                             data-title="Plática con Luis · Charla, Opiniones y Comunidad">
                            <img src="images/platica-con-luis-studio.jpg" alt="Plática con Luis" class="stream-thumb">
                            <div class="stream-info">
                                <h4>Plática con Luis</h4>
                                <p>Emisión Principal</p>
                            </div>
                        </div>

                        <!-- Channel 2: Plática con Luis (Elecciones USA) -->
                        <div class="stream-channel-card" 
                             data-video-url="https://www.youtube-nocookie.com/embed/bz1mCVVkJFE?autoplay=1&rel=0"
                             data-title="Plática con Luis · Elecciones y Actualidad en USA">
                            <img src="images/platica-con-luis-banner.jpg" alt="Elecciones en USA" class="stream-thumb">
                            <div class="stream-info">
                                <h4>Elecciones en USA</h4>
                                <p>Análisis con Luis Bernal</p>
                            </div>
                        </div>

                        <!-- Channel 3: Educador Financiero USA -->
                        <div class="stream-channel-card" 
                             data-video-url="https://www.youtube-nocookie.com/embed/B57hasvhDOk?autoplay=1&rel=0"
                             data-title="Educador Financiero USA · Cómo invertir en bolsa paso a paso">
                            <img src="images/logo-mivisionlatina.png" alt="Educador Financiero USA" class="stream-thumb">
                            <div class="stream-info">
                                <h4>Educador Financiero USA</h4>
                                <p>Inversiones y Finanzas</p>
                            </div>
                        </div>

                        <!-- Channel 4: La Plati-K -->
                        <div class="stream-channel-card" 
                             data-video-url="https://www.youtube-nocookie.com/embed/_wL7SN6kMZI?autoplay=1&rel=0"
                             data-title="La Plati-K · TPS y Comunidad Latina">
                            <img src="images/logo-laplatik.jpg" alt="La Plati-K" class="stream-thumb">
                            <div class="stream-info">
                                <h4>La Plati-K</h4>
                                <p>Cultura y Comunidad</p>
                            </div>
                        </div>

                    </div>

                    <div style="margin-top: 14px; padding-top: 14px; border-top: 1px solid #e2e8f0; text-align: center;">
                        <a href="<?= FB_PLATICA_CON_LUIS ?>" target="_blank" rel="noopener noreferrer" style="font-size: 0.82rem; color: #1e3a8a; font-weight: 600;">Participar en vivo por Facebook →</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- 3. NOTICIAS Y ACTUALIDAD (ÉLITE NOTICIAS Y LA PLATI-K) -->
<section class="section-noticias" id="noticias">
    <div class="container">
        
        <div class="section-header text-center">
            <span class="section-badge"><span class="badge-dot"></span> INFORMACIÓN</span>
            <h2 class="section-title">Noticias y Actualidad</h2>
            <p class="section-subtitle">
                Seguimiento informativo y opinión comunitaria a través de <strong>Élite Noticias</strong> y <strong>La Plati-K</strong>.
            </p>
        </div>

        <div class="dual-news-grid">
            
            <!-- Élite Noticias Card -->
            <div class="news-portal-card">
                <div class="news-card-header">
                    <img src="images/logo-mivisionlatina.png" alt="Élite Noticias" class="news-avatar">
                    <div>
                        <h3>Élite Noticias</h3>
                        <p>Información en Tiempo Real</p>
                    </div>
                </div>
                <div class="news-card-body">
                    <p style="font-size: 0.92rem; color: var(--text-secondary); margin-bottom: 18px;">
                        Reportes de actualidad, cambios en regulaciones, avisos sobre trámites y sucesos que impactan a las familias hispanas en Texas y en los Estados Unidos.
                    </p>
                    <div class="news-feature-list">
                        <div class="news-item">
                            <span style="color: #0f274a; font-weight: 700;">•</span>
                            <div><strong>Actualidad Local y Estatal:</strong> Noticias comunitarias directas en Texas.</div>
                        </div>
                        <div class="news-item">
                            <span style="color: #0f274a; font-weight: 700;">•</span>
                            <div><strong>Trámites y Regulaciones:</strong> Orientación práctica para la comunidad.</div>
                        </div>
                        <div class="news-item">
                            <span style="color: #0f274a; font-weight: 700;">•</span>
                            <div><strong>Alertas de Interés Público:</strong> Información oportuna para la población.</div>
                        </div>
                    </div>
                </div>
                <div class="news-actions-bar">
                    <a href="<?= FB_ELITE_NOTICIAS ?>" target="_blank" rel="noopener noreferrer" class="btn btn-fb" style="flex: 1;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        Seguir Élite Noticias en Facebook
                    </a>
                </div>
            </div>

            <!-- La Plati-K Card -->
            <div class="news-portal-card">
                <div class="news-card-header">
                    <img src="images/logo-laplatik.jpg" alt="La Plati-K" class="news-avatar">
                    <div>
                        <h3>La Plati-K</h3>
                        <p>Opiniones, Cultura y Comunidad</p>
                    </div>
                </div>
                <div class="news-card-body">
                    <p style="font-size: 0.92rem; color: var(--text-secondary); margin-bottom: 18px;">
                        Espacio dedicado al diálogo abierto sobre temas de interés popular, testimonios de superación de inmigrantes y análisis de la vida cotidiana.
                    </p>
                    <div class="news-feature-list">
                        <div class="news-item">
                            <span style="color: #0f274a; font-weight: 700;">•</span>
                            <div><strong>Conversaciones en Vivo:</strong> Diálogo con invitados especiales.</div>
                        </div>
                        <div class="news-item">
                            <span style="color: #0f274a; font-weight: 700;">•</span>
                            <div><strong>Testimonios de Esfuerzo:</strong> Relatos reales de familias hispanas.</div>
                        </div>
                        <div class="news-item">
                            <span style="color: #0f274a; font-weight: 700;">•</span>
                            <div><strong>Participación Abierta:</strong> Interacción directa con la audiencia.</div>
                        </div>
                    </div>
                </div>
                <div class="news-actions-bar">
                    <a href="<?= FB_LAPLATIK ?>" target="_blank" rel="noopener noreferrer" class="btn btn-fb" style="flex: 1;">
                        Facebook La Plati-K
                    </a>
                    <a href="<?= YT_LAPLATIK ?>" target="_blank" rel="noopener noreferrer" class="btn btn-yt" style="flex: 1;">
                        YouTube La Plati-K
                    </a>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- 4. FINANZAS (EDUCADOR FINANCIERO USA Y EL FINANCIERO EDUCADOR) -->
<section class="section-finanzas" id="finanzas">
    <div class="container">
        
        <div class="section-header text-center">
            <span class="section-badge"><span class="badge-dot"></span> ECONOMÍA Y PATRIMONIO</span>
            <h2 class="section-title">Finanzas y Desarrollo Económico</h2>
            <p class="section-subtitle">
                Aprende las claves del sistema crediticio, tributario y de inversión en los Estados Unidos.
            </p>
        </div>

        <div class="finanzas-grid">
            
            <!-- Card 1: Educador Financiero USA -->
            <div class="finanzas-card">
                <span class="finanzas-badge">Canal Central</span>
                <h3 style="margin-top: 10px;">Educador Financiero USA</h3>
                <p>
                    Información práctica sobre puntaje FICO, cómo reparar el historial crediticio, requisitos para comprar vivienda y administración responsable de deudas.
                </p>
                <div class="finanzas-topics">
                    <span class="topic-chip">Historial de Crédito</span>
                    <span class="topic-chip">Compra de Casa</span>
                    <span class="topic-chip">Presupuesto Familiar</span>
                    <span class="topic-chip">Eliminación de Deuda</span>
                </div>
                <a href="<?= YT_EDUCADOR_FINANCIERO ?>" target="_blank" rel="noopener noreferrer" class="btn btn-yt" style="width: 100%;">
                    Ver Canal en YouTube
                </a>
            </div>

            <!-- Card 2: El Financiero Educador -->
            <div class="finanzas-card">
                <span class="finanzas-badge">Emprendimiento</span>
                <h3 style="margin-top: 10px;">El Financiero Educador</h3>
                <p>
                    Estrategias para contratistas independientes, estructuración de negocios (LLC/Corporación), manejo tributario con ITIN o SSN y planes de retiro.
                </p>
                <div class="finanzas-topics">
                    <span class="topic-chip">Constitución de LLC</span>
                    <span class="topic-chip">Declaración de Taxes</span>
                    <span class="topic-chip">Cuentas de Retiro</span>
                    <span class="topic-chip">Flujo de Fondos</span>
                </div>
                <a href="<?= YT_FINANCIERO_EDUCADOR ?>" target="_blank" rel="noopener noreferrer" class="btn btn-yt" style="width: 100%;">
                    Ver Canal en YouTube
                </a>
            </div>

            <!-- Card 3: Consultas y Talleres -->
            <div class="finanzas-card" style="border-color: #cbd5e1;">
                <span class="finanzas-badge" style="background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe;">Talleres</span>
                <h3 style="margin-top: 10px;">Talleres y Orientación</h3>
                <p>
                    Participa en sesiones informativas organizadas para fortalecer la estabilidad y el crecimiento patrimonial de las familias trabajadoras.
                </p>
                <div class="finanzas-topics">
                    <span class="topic-chip">Sesiones Online</span>
                    <span class="topic-chip">Comunidad en Houston</span>
                    <span class="topic-chip">Guías de Consulta</span>
                </div>
                <a href="<?= FB_MI_VISION_LATINA ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary" style="width: 100%;">
                    Contactar por Facebook
                </a>
            </div>

        </div>

    </div>
</section>

<!-- 5. TRABAJO Y OPORTUNIDADES (TRABAJO LATINO) -->
<section class="section-trabajo" id="trabajo-latino">
    
    <?php if ($is_from_facebook): ?>
    <div class="fb-campaign-banner" style="margin-bottom: 35px;">
        <div class="container fb-banner-card">
            <div class="fb-banner-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </div>
            <div class="fb-banner-text">
                <h3>Registro para la Comunidad de Facebook</h3>
                <p>Si vienes de <strong>Trabajos para Latinos en Houston</strong>, completa tu registro para ingresar a la base de datos de candidatos consultada por contratistas y empleadores.</p>
            </div>
            <div class="fb-banner-badge">
                <span>Acceso Gratuito</span>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="container">
        
        <div class="section-header text-center">
            <span class="section-badge"><span class="badge-dot"></span> BOLSA DE EMPLEO & TRABAJO LATINO</span>
            <h2 class="section-title">Oportunidades Laborales <span class="text-gradient">en Houston & Texas</span></h2>
            <p class="section-subtitle">
                Vacantes activas para la comunidad trabajadora: construcción, remodelación, limpieza, transporte y restaurantes. Postúlate con tu currículum (PDF/Word).
            </p>
        </div>

        <?php
        $featured_jobs = get_jobs('', '', 'Activo');
        $display_jobs = array_slice($featured_jobs, 0, 3);
        ?>

        <!-- Featured Jobs Grid -->
        <div class="jobs-list-grid" style="margin-bottom: 25px;">
            <?php foreach ($display_jobs as $fj): ?>
                <div class="job-card">
                    <div>
                        <div class="job-card-header">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; gap: 8px;">
                                <span class="job-category-badge"><?= htmlspecialchars($fj['category']) ?></span>
                                <?php if (!empty($fj['expires_at'])): ?>
                                    <span style="font-size: 0.72rem; color: #854d0e; background: #fefce8; border: 1px solid #fef08a; padding: 2px 7px; border-radius: 9999px; font-weight: 600;">
                                        ⏳ Vence: <?= date('d M', strtotime($fj['expires_at'])) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <h3 class="job-title">
                                <a href="empleo.php?id=<?= $fj['id'] ?>" style="color: inherit; text-decoration: none;">
                                    <?= htmlspecialchars($fj['title']) ?>
                                </a>
                            </h3>
                            <div class="job-company">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" style="color: #64748b;"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/></svg>
                                <?= htmlspecialchars($fj['company']) ?>
                                <span style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; font-size: 0.65rem; padding: 1px 5px; border-radius: 3px; font-weight: 700; margin-left: 4px;">Verificado</span>
                            </div>
                        </div>

                        <div class="job-meta-row">
                            <span class="job-meta-chip">📍 <?= htmlspecialchars($fj['location']) ?></span>
                            <?php if (!empty($fj['salary'])): ?>
                                <span class="job-meta-chip salary">💵 <?= htmlspecialchars($fj['salary']) ?></span>
                            <?php endif; ?>
                            <span class="job-meta-chip">⏱️ <?= htmlspecialchars($fj['job_type']) ?></span>
                        </div>

                        <p class="job-description-preview">
                            <?= htmlspecialchars(mb_strimwidth($fj['description'], 0, 150, '...')) ?>
                        </p>
                    </div>

                    <div class="job-card-actions">
                        <span style="font-size: 0.74rem; color: #64748b;">
                            <?= date('d M Y', strtotime($fj['created_at'])) ?>
                        </span>
                        <a href="empleo.php?id=<?= $fj['id'] ?>" class="btn btn-primary" style="font-size: 0.84rem; font-weight: 700; padding: 7px 16px; text-decoration: none;">
                            Ver Vacante & Postularme →
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Action Callout Bar -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 25px 30px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 18px; box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);">
            <div>
                <h3 style="margin: 0; font-size: 1.15rem; color: #0f274a; font-weight: 800;">¿Buscas más vacantes o deseas enviar una solicitud abierta?</h3>
                <p style="margin: 4px 0 0; font-size: 0.88rem; color: #475569;">
                    Explora todas las vacantes publicadas o sube tu Currículum Vitae en PDF, Word (.doc, .docx) o RTF.
                </p>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="trabajo.php" class="btn btn-primary" style="padding: 10px 20px;">
                    Ver Todas las Vacantes & Enviar CV
                </a>
                <a href="<?= FB_TRABAJOS_HOUSTON ?>" target="_blank" rel="noopener noreferrer" class="btn btn-fb" style="padding: 10px 18px;">
                    Grupo en Facebook
                </a>
            </div>
        </div>

    </div>
</section>

<!-- 6. EDUCACIÓN Y DESARROLLO -->
<section class="section-educacion" id="educacion" style="background: #ffffff; border-top: 1px solid var(--border-subtle);">
    <div class="container">
        
        <div class="section-header text-center">
            <span class="section-badge"><span class="badge-dot"></span> DESARROLLO</span>
            <h2 class="section-title">Educación y Superación Personal</h2>
            <p class="section-subtitle">
                Herramientas formativas, liderazgo comunitario y mentalidad de progreso para la superación personal y familiar.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(290px, 1fr)); gap: 24px;">
            
            <div class="card">
                <h3 style="font-size: 1.18rem; font-weight: 800; color: var(--text-primary); margin-bottom: 8px;">Superación y Resiliencia</h3>
                <p style="font-size: 0.88rem; color: var(--text-secondary); line-height: 1.6; margin-bottom: 18px;">
                    Estrategias para adaptarse con éxito a la vida profesional en los Estados Unidos y superar los desafíos del día a día.
                </p>
                <a href="<?= YT_PLATICA_CON_LUIS ?>" target="_blank" rel="noopener noreferrer" style="color: var(--color-navy); font-size: 0.85rem; font-weight: 700;">Ver transmisiones temáticas →</a>
            </div>

            <div class="card">
                <h3 style="font-size: 1.18rem; font-weight: 800; color: var(--text-primary); margin-bottom: 8px;">Liderazgo Comunitario</h3>
                <p style="font-size: 0.88rem; color: var(--text-secondary); line-height: 1.6; margin-bottom: 18px;">
                    Orientación para participar activamente en la vida comunitaria y crear redes de apoyo para familias hispanas.
                </p>
                <a href="<?= FB_LAPLATIK ?>" target="_blank" rel="noopener noreferrer" style="color: var(--color-navy); font-size: 0.85rem; font-weight: 700;">Participar en La Plati-K →</a>
            </div>

            <div class="card">
                <h3 style="font-size: 1.18rem; font-weight: 800; color: var(--text-primary); margin-bottom: 8px;">Capacitación Laboral</h3>
                <p style="font-size: 0.88rem; color: var(--text-secondary); line-height: 1.6; margin-bottom: 18px;">
                    Recomendaciones para certificaciones en oficios técnicos, licencias comerciales y mejora de competencias profesionales.
                </p>
                <a href="#trabajo-latino" style="color: var(--color-navy); font-size: 0.85rem; font-weight: 700;">Consultar bolsa de trabajo →</a>
            </div>

        </div>

    </div>
</section>

<!-- 7. LIBROS Y SERVICIOS (PUBLICACIONES DE LUIS BERNAL EN AMAZON) -->
<section class="section-libros" id="libros">
    <div class="container">
        
        <div class="section-header text-center">
            <span class="section-badge"><span class="badge-dot"></span> PUBLICACIONES</span>
            <h2 class="section-title">Libros y Publicaciones Oficiales</h2>
            <p class="section-subtitle">
                Obras literarias y guías escritas por <strong>Luis Bernal</strong>, disponibles a través de Amazon.
            </p>
        </div>

        <div class="books-showcase-grid">
            
            <!-- Left: Author Profile -->
            <div class="author-profile-card">
                <span class="author-badge">Autor y Comunicador</span>
                <h3 class="author-title">Luis Bernal</h3>
                <p class="author-bio">
                    Autor y conferencista dedicado a inspirar a la comunidad hispana en Estados Unidos. Sus publicaciones abordan temas de superación humana, principios de prosperidad económica, valores familiares y crecimiento personal.
                </p>

                <div class="author-features">
                    <div class="feature-box">
                        <strong>Tienda en Amazon</strong>
                        <span>Edición digital Kindle y libro físico en tapa blanda</span>
                    </div>
                    <div class="feature-box">
                        <strong>Envío a todo EE.UU.</strong>
                        <span>Disponible para entrega directa con Amazon</span>
                    </div>
                </div>

                <a href="<?= AMAZON_STORE_LUIS_BERNAL ?>" target="_blank" rel="noopener noreferrer" class="btn btn-amazon btn-lg" style="width: 100%;">
                    <span>Comprar en la Tienda de Amazon</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                </a>
            </div>

            <!-- Right: Book Catalog Showcase -->
            <div class="books-catalog-wrap">
                
                <!-- Book Card 1 -->
                <div class="book-card">
                    <div class="book-icon-cover">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                    </div>
                    <div class="book-details">
                        <h4>Obras y Publicaciones de Superación</h4>
                        <p>Textos orientados a fortalecer el enfoque, la resiliencia y el desarrollo del potencial de cada persona.</p>
                        <a href="<?= AMAZON_STORE_LUIS_BERNAL ?>" target="_blank" rel="noopener noreferrer" class="book-store-badge">
                            <span>Ver títulos en Amazon</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- Book Card 2 -->
                <div class="book-card">
                    <div class="book-icon-cover" style="background: #1e3a8a;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                    </div>
                    <div class="book-details">
                        <h4>Guías Prácticas de Finanzas Familiares</h4>
                        <p>Principios claros para ordenar el presupuesto, manejar deudas e invertir en el futuro.</p>
                        <a href="<?= AMAZON_STORE_LUIS_BERNAL ?>" target="_blank" rel="noopener noreferrer" class="book-store-badge">
                            <span>Ver títulos en Amazon</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- Book Card 3 -->
                <div class="book-card">
                    <div class="book-icon-cover" style="background: #065f46;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </div>
                    <div class="book-details">
                        <h4>Directorio y Servicios Vinculados</h4>
                        <p>Acceso a iniciativas y proyectos comunitarios avalados por Mi Visión Latina.</p>
                        <a href="<?= FB_MI_VISION_LATINA ?>" target="_blank" rel="noopener noreferrer" class="book-store-badge" style="color: #1e3a8a;">
                            <span>Consultar Directorio</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
