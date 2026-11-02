<?php
/**
 * MI VISIÓN LATINA - Programas y Transmisiones (transmisiones.php)
 * Señal en vivo de Plática con Luis, videos y archivo de emisiones
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

include __DIR__ . '/header.php';
?>

<!-- Page Header Banner -->
<section class="page-title-banner" style="background: linear-gradient(180deg, #ffffff 0%, #f1f5f9 100%); padding: 50px 0 40px; border-bottom: 1px solid var(--border-subtle);">
    <div class="container text-center">
        <span class="section-badge"><span class="badge-dot"></span> SEÑAL DIGITAL & ESTUDIO</span>
        <h1 class="section-title">Programas y Transmisiones Oficiales</h1>
        <p class="section-subtitle">
            Sintoniza las emisiones de <strong>Plática con Luis</strong>, producciones informativas y mesas de análisis en streaming para la comunidad hispana.
        </p>
    </div>
</section>

<!-- Main Interactive Video Section -->
<section class="section-transmisiones" style="padding: 50px 0 70px;">
    <div class="container">
        
        <!-- Video Player Module -->
        <div class="video-player-container">
            <div class="player-main-header">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <?php if (IS_LIVE_BROADCAST): ?>
                        <span class="player-status-badge">
                            <span class="live-pulse"></span> SEÑAL EN DIRECTO · ON AIR
                        </span>
                    <?php else: ?>
                        <span class="player-status-badge" style="background: #f1f5f9; border-color: #cbd5e1; color: #64748b;">
                            <span class="offair-dot"></span> REPETICIÓN & ARCHIVO
                        </span>
                    <?php endif; ?>
                    <h3 class="player-stream-title" id="current-stream-title">Plática con Luis · Charla, Opiniones y Comunidad</h3>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="<?= YT_PLATICA_CON_LUIS ?>?sub_confirmation=1" target="_blank" rel="noopener noreferrer" class="btn btn-yt" style="padding: 7px 14px; font-size: 0.82rem;">
                        Suscribirse en YouTube
                    </a>
                    <a href="<?= FB_PLATICA_CON_LUIS ?>" target="_blank" rel="noopener noreferrer" class="btn btn-fb" style="padding: 7px 14px; font-size: 0.82rem;">
                        Facebook Live
                    </a>
                </div>
            </div>

            <div class="player-grid-layout">
                <!-- Video Screen -->
                <div class="video-screen-wrap">
                    <iframe 
                        id="main-stream-player"
                        src="https://www.youtube-nocookie.com/embed/<?= DEFAULT_VIDEO_ID ?>?autoplay=0&rel=0" 
                        title="Plática con Luis · Emisión Oficial" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen
                        loading="lazy">
                    </iframe>
                </div>

                <!-- Playlist / Channels -->
                <div class="stream-sidebar">
                    <span class="stream-sidebar-title">Seleccionar Programa</span>
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

                        <!-- Channel 2: Elecciones en USA -->
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

        <!-- Schedule & Studio Details -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-top: 40px;">
            <div class="card">
                <h4 style="font-size: 1.1rem; color: #0f274a; margin-bottom: 8px;">Horarios de Transmisión</h4>
                <p style="font-size: 0.88rem; color: #475569; line-height: 1.6; margin: 0;">
                    Nuestras transmisiones en directo de <em>Plática con Luis</em> se emiten regularmente los días <strong>Martes y Jueves a las 7:00 PM CST</strong> a través de Facebook y YouTube.
                </p>
            </div>
            <div class="card">
                <h4 style="font-size: 1.1rem; color: #0f274a; margin-bottom: 8px;">Interacción en Tiempo Real</h4>
                <p style="font-size: 0.88rem; color: #475569; line-height: 1.6; margin: 0;">
                    Puedes enviar tus preguntas, opiniones o reportes directamente durante el vivo en el chat de Facebook o dejando tu comentario en nuestro canal de YouTube.
                </p>
            </div>
            <div class="card">
                <h4 style="font-size: 1.1rem; color: #0f274a; margin-bottom: 8px;">Participación Comunitaria</h4>
                <p style="font-size: 0.88rem; color: #475569; line-height: 1.6; margin: 0;">
                    Si representas a una organización comunitaria o tienes una historia de superación que compartir, ponte en contacto con nuestra producción vía WhatsApp o correo.
                </p>
            </div>
        </div>

    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
