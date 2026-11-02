<?php
/**
 * MI VISIÓN LATINA - FINANZAS Y ECONOMÍA COMUNITARIA
 * Educador Financiero USA y El Financiero Educador
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/header.php';
?>

    <!-- Page Header / Hero -->
    <section class="hero-section" style="padding: 55px 0 45px; background: linear-gradient(180deg, #f1f5f9 0%, #ffffff 100%); border-bottom: 1px solid #e2e8f0;">
        <div class="container text-center">
            <span class="section-badge"><span class="badge-dot"></span> FINANZAS Y ECONOMÍA</span>
            <h1 class="hero-title" style="font-size: 2.3rem; margin: 12px 0 8px;">
                Educación Financiera para el <span class="text-gradient">Progreso de las Familias Latinas</span>
            </h1>
            <p class="hero-description" style="max-width: 760px; margin: 0 auto 20px; font-size: 1rem; color: #475569;">
                Aprende a dominar el sistema financiero estadounidense: creación de crédito sólido, compra de vivienda, impuestos, apertura de negocios y protección patrimonial con <strong>Educador Financiero USA</strong> y <strong>El Financiero Educador</strong>.
            </p>

            <div style="display: inline-flex; gap: 15px; flex-wrap: wrap; justify-content: center;">
                <a href="<?= YT_EDUCADOR_FINANCIERO_USA ?>" target="_blank" rel="noopener noreferrer" class="btn btn-yt">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    Ver Canal: Educador Financiero USA
                </a>
                <a href="<?= YT_FINANCIERO_EDUCADOR ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary">
                    Canal: El Financiero Educador
                </a>
            </div>
        </div>
    </section>

    <!-- Financial Pillars Grid -->
    <main class="container" style="padding-top: 55px; padding-bottom: 85px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; margin-bottom: 45px;">
            
            <!-- Pillar 1: Crédito -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 26px; box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);">
                <div style="width: 44px; height: 44px; border-radius: 8px; background: #eff6ff; color: #1d4ed8; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; margin-bottom: 14px;">
                    💳
                </div>
                <h3 style="font-size: 1.15rem; color: #0f274a; font-weight: 800; margin: 0 0 8px;">Construcción y Reparación de Crédito</h3>
                <p style="font-size: 0.88rem; color: #475569; line-height: 1.55; margin-bottom: 14px;">
                    Estrategias legales y efectivas para elevar tu puntaje FICO, entender los reportes de crédito y eliminar errores en las agencias de crédito.
                </p>
                <a href="<?= YT_EDUCADOR_FINANCIERO_USA ?>" target="_blank" rel="noopener noreferrer" style="color: #0284c7; font-size: 0.82rem; font-weight: 700; text-decoration: none;">Ver lecciones en video →</a>
            </div>

            <!-- Pillar 2: Negocios e Impuestos -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 26px; box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);">
                <div style="width: 44px; height: 44px; border-radius: 8px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; margin-bottom: 14px;">
                    🏢
                </div>
                <h3 style="font-size: 1.15rem; color: #0f274a; font-weight: 800; margin: 0 0 8px;">Negocios, LLCs y Contabilidad</h3>
                <p style="font-size: 0.88rem; color: #475569; line-height: 1.55; margin-bottom: 14px;">
                    Cómo formalizar tu empresa como LLC o Corporación, obtener EIN, abrir cuentas bancarias comerciales y manejar deducciones de impuestos.
                </p>
                <a href="<?= YT_FINANCIERO_EDUCADOR ?>" target="_blank" rel="noopener noreferrer" style="color: #059669; font-size: 0.82rem; font-weight: 700; text-decoration: none;">Guías para emprendedores →</a>
            </div>

            <!-- Pillar 3: Bienes Raíces -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 26px; box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);">
                <div style="width: 44px; height: 44px; border-radius: 8px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; margin-bottom: 14px;">
                    🏡
                </div>
                <h3 style="font-size: 1.15rem; color: #0f274a; font-weight: 800; margin: 0 0 8px;">Compra de Vivienda y Préstamos</h3>
                <p style="font-size: 0.88rem; color: #475569; line-height: 1.55; margin-bottom: 14px;">
                    Programas de asistencia para primeros compradores, requisitos de hipoteca FHA y convencional, y cómo comprar propiedades con ITIN o SSN.
                </p>
                <a href="<?= YT_EDUCADOR_FINANCIERO_USA ?>" target="_blank" rel="noopener noreferrer" style="color: #d97706; font-size: 0.82rem; font-weight: 700; text-decoration: none;">Aprende el proceso paso a paso →</a>
            </div>

        </div>

        <!-- Featured Banner: YouTube Channels -->
        <div style="background: #0f274a; border-radius: 12px; padding: 35px 30px; color: #ffffff; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
            <div style="max-width: 600px;">
                <span style="font-size: 0.74rem; text-transform: uppercase; color: #38bdf8; font-weight: 700; letter-spacing: 0.05em;">ASESORÍA ACCESIBLE Y GRATUITA</span>
                <h2 style="font-size: 1.6rem; margin: 6px 0 10px; color: #ffffff; font-weight: 800;">Suscríbete a Nuestros Canales Financieros</h2>
                <p style="font-size: 0.9rem; color: #cbd5e1; margin: 0; line-height: 1.5;">
                    Únete a miles de personas que están transformando su situación económica a través de la educación financiera práctica en español.
                </p>
            </div>
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <a href="<?= YT_EDUCADOR_FINANCIERO_USA ?>" target="_blank" rel="noopener noreferrer" class="btn btn-yt">
                    Educador Financiero USA
                </a>
                <a href="<?= YT_FINANCIERO_EDUCADOR ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary">
                    El Financiero Educador
                </a>
            </div>
        </div>
    </main>

<?php require_once __DIR__ . '/footer.php'; ?>
