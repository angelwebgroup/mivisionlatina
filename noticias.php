<?php
/**
 * MI VISIÓN LATINA - NOTICIAS Y ACTUALIDAD
 * Élite Noticias y La Plati-K
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/header.php';
?>

    <!-- Page Header / Hero -->
    <section class="hero-section" style="padding: 55px 0 45px; background: linear-gradient(180deg, #f1f5f9 0%, #ffffff 100%); border-bottom: 1px solid #e2e8f0;">
        <div class="container text-center">
            <span class="section-badge"><span class="badge-dot"></span> NOTICIAS Y ACTUALIDAD</span>
            <h1 class="hero-title" style="font-size: 2.3rem; margin: 12px 0 8px;">
                Información Veraz y Comunitaria para la <span class="text-gradient">Comunidad Hispana</span>
            </h1>
            <p class="hero-description" style="max-width: 750px; margin: 0 auto 20px; font-size: 1rem; color: #475569;">
                Cobertura directa de los acontecimientos que impactan a nuestras familias en Texas y Estados Unidos a través de <strong>Élite Noticias</strong> y <strong>La Plati-K</strong>.
            </p>

            <div style="display: inline-flex; gap: 15px; flex-wrap: wrap; justify-content: center;">
                <a href="<?= FB_ELITE_NOTICIAS ?>" target="_blank" rel="noopener noreferrer" class="btn btn-fb">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    Seguir Élite Noticias en Facebook
                </a>
                <a href="<?= FB_LAPLATIK ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary">
                    Comunidad La Plati-K
                </a>
            </div>
        </div>
    </section>

    <!-- Main Content Grid -->
    <main class="container" style="padding-top: 55px; padding-bottom: 85px;">
        <div class="dual-news-grid">
            
            <!-- Élite Noticias Card -->
            <div class="news-portal-card" style="box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05); border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; background: #fff;">
                <div style="background: #0f274a; color: #fff; padding: 22px 25px; display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <span style="font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.05em; color: #38bdf8; font-weight: 700;">INFORMATIVO CENTRAL</span>
                        <h2 style="font-size: 1.4rem; margin: 4px 0 0; color: #fff; font-weight: 800;">Élite Noticias</h2>
                    </div>
                    <span style="background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.3); font-size: 0.75rem; padding: 4px 10px; border-radius: 9999px; font-weight: 700;">
                        EN VIVO Y ALERTAS
                    </span>
                </div>

                <div style="padding: 24px;">
                    <p style="color: #475569; font-size: 0.92rem; line-height: 1.6; margin-bottom: 20px;">
                        Reportes oportunos de sucesos locales en Houston, reformas migratorias, avisos meteorológicos, economía comunitaria y entrevistas con líderes cívicos.
                    </p>

                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; margin-bottom: 20px;">
                        <h4 style="font-size: 0.9rem; color: #0f274a; margin: 0 0 10px; font-weight: 700;">Principales Ejes Informativos:</h4>
                        <ul style="margin: 0; padding-left: 20px; font-size: 0.85rem; color: #334155; line-height: 1.6;">
                            <li>Actualizaciones de leyes de inmigración y trámites consulares.</li>
                            <li>Derechos de los trabajadores e incentivos para negocios hispanos.</li>
                            <li>Seguridad pública y alertas comunitarias en Houston y Texas.</li>
                        </ul>
                    </div>

                    <a href="<?= FB_ELITE_NOTICIAS ?>" target="_blank" rel="noopener noreferrer" class="btn btn-fb" style="width: 100%; justify-content: center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        <span>Abrir Página de Élite Noticias</span>
                    </a>
                </div>
            </div>

            <!-- La Plati-K Card -->
            <div class="news-portal-card" style="box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05); border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; background: #fff;">
                <div style="background: #065f46; color: #fff; padding: 22px 25px; display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <span style="font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.05em; color: #a7f3d0; font-weight: 700;">COMUNIDAD Y DEBATE</span>
                        <h2 style="font-size: 1.4rem; margin: 4px 0 0; color: #fff; font-weight: 800;">La Plati-K</h2>
                    </div>
                    <span style="background: rgba(167, 243, 208, 0.2); color: #a7f3d0; border: 1px solid rgba(167, 243, 208, 0.4); font-size: 0.75rem; padding: 4px 10px; border-radius: 9999px; font-weight: 700;">
                        ESPACIO PARTICIPATIVO
                    </span>
                </div>

                <div style="padding: 24px;">
                    <p style="color: #475569; font-size: 0.92rem; line-height: 1.6; margin-bottom: 20px;">
                        Espacio de debate abierto, cultura popular, tertulia comunitaria e historias inspiradoras de superación en los Estados Unidos.
                    </p>

                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; margin-bottom: 20px;">
                        <h4 style="font-size: 0.9rem; color: #0f274a; margin: 0 0 10px; font-weight: 700;">Lo que encontrarás en La Plati-K:</h4>
                        <ul style="margin: 0; padding-left: 20px; font-size: 0.85rem; color: #334155; line-height: 1.6;">
                            <li>Conversaciones sin censura sobre problemáticas cotidianas.</li>
                            <li>Reconocimiento a emprendedores y trabajadores ejemplares.</li>
                            <li>Participación de la audiencia con comentarios en directo.</li>
                        </ul>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <a href="<?= YT_LAPLATIK ?>" target="_blank" rel="noopener noreferrer" class="btn btn-yt" style="justify-content: center; font-size: 0.84rem;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            <span>Canal YouTube</span>
                        </a>
                        <a href="<?= FB_LAPLATIK ?>" target="_blank" rel="noopener noreferrer" class="btn btn-fb" style="justify-content: center; font-size: 0.84rem;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            <span>Comunidad FB</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </main>

<?php require_once __DIR__ . '/footer.php'; ?>
