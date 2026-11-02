<?php
/**
 * MI VISIÓN LATINA - LIBROS Y PUBLICACIONES
 * Obras literarias y guías de desarrollo personal de Luis Bernal en Amazon
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/header.php';
?>

    <!-- Page Header / Hero -->
    <section class="hero-section" style="padding: 55px 0 45px; background: linear-gradient(180deg, #f1f5f9 0%, #ffffff 100%); border-bottom: 1px solid #e2e8f0;">
        <div class="container text-center">
            <span class="section-badge"><span class="badge-dot"></span> BIBLIOTECA & PUBLICACIONES</span>
            <h1 class="hero-title" style="font-size: 2.3rem; margin: 12px 0 8px;">
                Libros y Obras de <span class="text-gradient">Luis Bernal</span>
            </h1>
            <p class="hero-description" style="max-width: 760px; margin: 0 auto 20px; font-size: 1rem; color: #475569;">
                Obras literarias, guías de superación, reflexiones y desarrollo humano publicadas internacionalmente y disponibles a través de Amazon Kindle y tapa blanda.
            </p>

            <div style="display: inline-flex; gap: 15px; flex-wrap: wrap; justify-content: center;">
                <a href="<?= AMAZON_STORE_LUIS_BERNAL ?>" target="_blank" rel="noopener noreferrer" class="btn btn-amazon" style="padding: 12px 24px; font-size: 0.95rem;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    <span>Visitar Tienda Oficial en Amazon</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Books Showcase Grid -->
    <main class="container" style="padding-top: 55px; padding-bottom: 85px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 28px; margin-bottom: 50px;">
            
            <!-- Book 1 -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 26px; box-shadow: 0 4px 10px rgba(15, 23, 42, 0.04); display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 30px; text-align: center; margin-bottom: 18px;">
                        <span style="font-size: 3rem;">📖</span>
                        <div style="font-size: 0.76rem; color: #64748b; margin-top: 6px; font-weight: 700; text-transform: uppercase;">Disponible en Amazon</div>
                    </div>
                    <span style="font-size: 0.74rem; background: #eff6ff; color: #1d4ed8; padding: 3px 8px; border-radius: 4px; font-weight: 700;">SUPERACIÓN & FINANZAS</span>
                    <h3 style="font-size: 1.25rem; color: #0f274a; font-weight: 800; margin: 10px 0 8px;">De la Intención al Éxito Financiero</h3>
                    <p style="font-size: 0.88rem; color: #475569; line-height: 1.55; margin-bottom: 16px;">
                        Una guía paso a paso para trabajadores hispanos que buscan ordenar su economía, crear patrimonio duradero y consolidar estabilidad familiar en los EE.UU.
                    </p>
                </div>
                <a href="<?= AMAZON_STORE_LUIS_BERNAL ?>" target="_blank" rel="noopener noreferrer" class="btn btn-amazon" style="width: 100%; justify-content: center;">
                    Ver en Amazon Kindle / Físico
                </a>
            </div>

            <!-- Book 2 -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 26px; box-shadow: 0 4px 10px rgba(15, 23, 42, 0.04); display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 30px; text-align: center; margin-bottom: 18px;">
                        <span style="font-size: 3rem;">🧭</span>
                        <div style="font-size: 0.76rem; color: #64748b; margin-top: 6px; font-weight: 700; text-transform: uppercase;">Disponible en Amazon</div>
                    </div>
                    <span style="font-size: 0.74rem; background: #ecfdf5; color: #059669; padding: 3px 8px; border-radius: 4px; font-weight: 700;">LIDERAZGO & VIDA</span>
                    <h3 style="font-size: 1.25rem; color: #0f274a; font-weight: 800; margin: 10px 0 8px;">El Poder de la Determinación Latina</h3>
                    <p style="font-size: 0.88rem; color: #475569; line-height: 1.55; margin-bottom: 16px;">
                        Reflexiones sobre el esfuerzo de los migrantes, la superación de adversidades y el forjado de un carácter inquebrantable para liderar proyectos con propósito.
                    </p>
                </div>
                <a href="<?= AMAZON_STORE_LUIS_BERNAL ?>" target="_blank" rel="noopener noreferrer" class="btn btn-amazon" style="width: 100%; justify-content: center;">
                    Ver en Amazon Kindle / Físico
                </a>
            </div>

            <!-- Book 3 -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 26px; box-shadow: 0 4px 10px rgba(15, 23, 42, 0.04); display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 30px; text-align: center; margin-bottom: 18px;">
                        <span style="font-size: 3rem;">🎙️</span>
                        <div style="font-size: 0.76rem; color: #64748b; margin-top: 6px; font-weight: 700; text-transform: uppercase;">Disponible en Amazon</div>
                    </div>
                    <span style="font-size: 0.74rem; background: #fef3c7; color: #d97706; padding: 3px 8px; border-radius: 4px; font-weight: 700;">DIÁLOGOS & TESTIMONIOS</span>
                    <h3 style="font-size: 1.25rem; color: #0f274a; font-weight: 800; margin: 10px 0 8px;">Crónicas de Plática con Luis</h3>
                    <p style="font-size: 0.88rem; color: #475569; line-height: 1.55; margin-bottom: 16px;">
                        Compilado de los testimonios, historias humanas y lecciones de vida más impactantes compartidas en el programa insignia de Mi Visión Latina.
                    </p>
                </div>
                <a href="<?= AMAZON_STORE_LUIS_BERNAL ?>" target="_blank" rel="noopener noreferrer" class="btn btn-amazon" style="width: 100%; justify-content: center;">
                    Ver en Amazon Kindle / Físico
                </a>
            </div>

        </div>

        <!-- Banner to Amazon Store -->
        <div style="background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 12px; padding: 30px; text-align: center;">
            <h3 style="font-size: 1.3rem; color: #0f274a; font-weight: 800; margin: 0 0 8px;">¿Deseas adquirir ejemplares o contactar al autor?</h3>
            <p style="font-size: 0.9rem; color: #475569; max-width: 600px; margin: 0 auto 16px;">
                Puedes ordenar todos los títulos directamente a través del perfil oficial de autor de Luis Bernal en Amazon o solicitar conferencias y firmas de libros.
            </p>
            <a href="<?= AMAZON_STORE_LUIS_BERNAL ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                Ir al Perfil de Autor en Amazon.com
            </a>
        </div>
    </main>

<?php require_once __DIR__ . '/footer.php'; ?>
