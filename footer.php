<?php
/**
 * MI VISIÓN LATINA - Footer Component
 */
require_once __DIR__ . '/config.php';
?>
    <!-- Unified Social Hub Matrix Section -->
    <section class="section-social-matrix" id="redes">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-badge"><span class="badge-dot"></span> ECOSISTEMA DIGITAL</span>
                <h2 class="section-title">Nuestras Redes y <span class="text-gradient">Canales Oficiales</span></h2>
                <p class="section-subtitle">Conéctate en vivo con todas nuestras plataformas informativas, educativas y de oportunidades.</p>
            </div>

            <div class="matrix-grid">
                
                <!-- FB 1: Plática con Luis -->
                <div class="social-node-card">
                    <div>
                        <div class="social-node-top">
                            <div class="social-node-icon fb">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </div>
                            <div>
                                <span class="social-node-cat">Facebook Oficial</span>
                                <h3 class="social-node-title">Plática con Luis</h3>
                            </div>
                        </div>
                        <p style="font-size: 0.82rem; color: #94a3b8; margin-bottom: 16px;">Transmisiones en vivo, debates y reflexiones con Luis Bernal.</p>
                    </div>
                    <a href="<?= FB_PLATICA_CON_LUIS ?>" target="_blank" rel="noopener noreferrer" class="btn btn-fb btn-animated" style="width: 100%;">Seguir en Facebook</a>
                </div>

                <!-- YT 1: Plática con Luis -->
                <div class="social-node-card">
                    <div>
                        <div class="social-node-top">
                            <div class="social-node-icon yt">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </div>
                            <div>
                                <span class="social-node-cat">YouTube Channel</span>
                                <h3 class="social-node-title">@Platicaconluis</h3>
                            </div>
                        </div>
                        <p style="font-size: 0.82rem; color: #94a3b8; margin-bottom: 16px;">Episodios completos, podcasts y transmisiones en alta definición.</p>
                    </div>
                    <a href="<?= YT_PLATICA_CON_LUIS ?>" target="_blank" rel="noopener noreferrer" class="btn btn-yt btn-animated" style="width: 100%;">Suscribirme en YouTube</a>
                </div>

                <!-- FB 2: Élite Noticias -->
                <div class="social-node-card">
                    <div>
                        <div class="social-node-top">
                            <div class="social-node-icon fb">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </div>
                            <div>
                                <span class="social-node-cat">Facebook Noticias</span>
                                <h3 class="social-node-title">Élite Noticias</h3>
                            </div>
                        </div>
                        <p style="font-size: 0.82rem; color: #94a3b8; margin-bottom: 16px;">Información veraz, sucesos locales y noticias internacionales al instante.</p>
                    </div>
                    <a href="<?= FB_ELITE_NOTICIAS ?>" target="_blank" rel="noopener noreferrer" class="btn btn-fb btn-animated" style="width: 100%;">Ver Élite Noticias</a>
                </div>

                <!-- YT/FB: La Plati-K -->
                <div class="social-node-card">
                    <div>
                        <div class="social-node-top">
                            <div class="social-node-icon yt">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </div>
                            <div>
                                <span class="social-node-cat">YouTube & FB</span>
                                <h3 class="social-node-title">La Plati-K</h3>
                            </div>
                        </div>
                        <p style="font-size: 0.82rem; color: #94a3b8; margin-bottom: 16px;">Comunidad activa, tertulia cultural y temas de interés popular.</p>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <a href="<?= YT_LAPLATIK ?>" target="_blank" rel="noopener noreferrer" class="btn btn-yt btn-animated" style="flex: 1; padding: 8px 10px; font-size: 0.78rem;">YouTube</a>
                        <a href="<?= FB_LAPLATIK ?>" target="_blank" rel="noopener noreferrer" class="btn btn-fb btn-animated" style="flex: 1; padding: 8px 10px; font-size: 0.78rem;">Facebook</a>
                    </div>
                </div>

                <!-- YT: Educador Financiero USA -->
                <div class="social-node-card">
                    <div>
                        <div class="social-node-top">
                            <div class="social-node-icon yt">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </div>
                            <div>
                                <span class="social-node-cat">Educación Financiera</span>
                                <h3 class="social-node-title">Educador Financiero USA</h3>
                            </div>
                        </div>
                        <p style="font-size: 0.82rem; color: #94a3b8; margin-bottom: 16px;">Educación en crédito, finanzas personales, taxes e inversiones.</p>
                    </div>
                    <a href="<?= YT_EDUCADOR_FINANCIERO ?>" target="_blank" rel="noopener noreferrer" class="btn btn-yt btn-animated" style="width: 100%;">Ver en YouTube</a>
                </div>

                <!-- YT: El Financiero Educador -->
                <div class="social-node-card">
                    <div>
                        <div class="social-node-top">
                            <div class="social-node-icon yt">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </div>
                            <div>
                                <span class="social-node-cat">Finanzas & Negocios</span>
                                <h3 class="social-node-title">El Financiero Educador</h3>
                            </div>
                        </div>
                        <p style="font-size: 0.82rem; color: #94a3b8; margin-bottom: 16px;">Estrategias de emprendimiento y creación de riqueza para la comunidad.</p>
                    </div>
                    <a href="<?= YT_FINANCIERO_EDUCADOR ?>" target="_blank" rel="noopener noreferrer" class="btn btn-yt btn-animated" style="width: 100%;">Ver en YouTube</a>
                </div>

                <!-- FB: Trabajos para Latinos en Houston -->
                <div class="social-node-card">
                    <div>
                        <div class="social-node-top">
                            <div class="social-node-icon fb">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </div>
                            <div>
                                <span class="social-node-cat">Facebook Comunidad</span>
                                <h3 class="social-node-title">Trabajos Latinos Houston</h3>
                            </div>
                        </div>
                        <p style="font-size: 0.82rem; color: #94a3b8; margin-bottom: 16px;">Bolsa de trabajo activa con cientos de ofertas de contratistas locales.</p>
                    </div>
                    <a href="<?= FB_TRABAJOS_HOUSTON ?>" target="_blank" rel="noopener noreferrer" class="btn btn-fb btn-animated" style="width: 100%;">Unirme al Grupo</a>
                </div>

                <!-- Amazon Store: Luis Bernal -->
                <div class="social-node-card">
                    <div>
                        <div class="social-node-top">
                            <div class="social-node-icon" style="background: #fef3c7; color: #d97706;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                            </div>
                            <div>
                                <span class="social-node-cat">Amazon Author</span>
                                <h3 class="social-node-title">Libros de Luis Bernal</h3>
                            </div>
                        </div>
                        <p style="font-size: 0.82rem; color: #64748b; margin-bottom: 16px;">Obras literarias, guías de superación y educación en Amazon.</p>
                    </div>
                    <a href="<?= AMAZON_STORE_LUIS_BERNAL ?>" target="_blank" rel="noopener noreferrer" class="btn btn-amazon" style="width: 100%;">Tienda en Amazon</a>
                </div>

            </div>
        </div>
    </section>

    <!-- Main Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-top-grid">
                
                <div class="footer-brand">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="images/logo-mivisionlatina.png" alt="Mi Visión Latina" width="50" height="50" style="border-radius: 50%;">
                        <div>
                            <span style="font-size: 1.25rem; font-weight: 800; color: #fff;">MI VISIÓN <span class="text-gold">LATINA</span></span>
                            <div style="font-size: 0.72rem; color: var(--color-gold); font-weight: 600;">PORTAL MULTIMEDIA OFICIAL</div>
                        </div>
                    </div>
                    <p>
                        Una firma mediática comprometida con la elevación social, económica, informativa y laboral de la comunidad latina en los Estados Unidos.
                    </p>
                    <div style="font-size: 0.82rem; color: #cbd5e1; margin-top: 10px;">
                        <strong class="text-gold">Misión:</strong> Informar · Educar · Conectar · Impulsar oportunidades.
                    </div>
                </div>

                <div class="footer-col">
                    <h4>Programas y Noticias</h4>
                    <div class="footer-links">
                        <a href="transmisiones.php">Plática con Luis (En Vivo)</a>
                        <a href="noticias.php">Élite Noticias</a>
                        <a href="noticias.php">La Plati-K</a>
                        <a href="<?= YT_PLATICA_CON_LUIS ?>" target="_blank" rel="noopener noreferrer">Canal Central YouTube</a>
                        <a href="<?= FB_MI_VISION_LATINA ?>" target="_blank" rel="noopener noreferrer">Facebook Mi Visión Latina</a>
                    </div>
                </div>

                <div class="footer-col">
                    <h4>Desarrollo y Oportunidades</h4>
                    <div class="footer-links">
                        <a href="trabajo.php">Bolsa de Empleo</a>
                        <a href="trabajo.php#formulario">Enviar Currículum (CV)</a>
                        <a href="finanzas.php">Educador Financiero USA</a>
                        <a href="finanzas.php">El Financiero Educador</a>
                        <a href="educacion.php">Crecimiento Personal</a>
                        <a href="libros.php">Libros de Luis Bernal</a>
                    </div>
                </div>

                <div class="footer-col">
                    <h4>Enlaces Rápidos & Admin</h4>
                    <div class="footer-links">
                        <a href="index.php">Portal Principal</a>
                        <a href="admin_candidatos.php">Panel de Empleos & BD</a>
                        <a href="<?= FB_TRABAJOS_HOUSTON ?>" target="_blank" rel="noopener noreferrer">Comunidad en Houston</a>
                        <a href="<?= AMAZON_STORE_LUIS_BERNAL ?>" target="_blank" rel="noopener noreferrer">Comprar en Amazon</a>
                    </div>
                </div>

            </div>

            <div class="footer-bottom">
                <div>
                    © <?= date('Y') ?> <strong>MI VISIÓN LATINA</strong> · Todos los derechos reservados. Portal oficial: <a href="http://<?= SITE_DOMAIN ?>" class="text-gold"><?= SITE_DOMAIN ?></a>
                </div>
                <div>
                    <a href="admin_candidatos.php" style="color: #64748b; font-size: 0.78rem;">🔐 Panel de Empleo</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="toast-container"></div>

    <!-- Core Script -->
    <script src="assets/js/main.js"></script>
</body>
</html>
