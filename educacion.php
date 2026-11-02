<?php
/**
 * MI VISIÓN LATINA - EDUCACIÓN Y DESARROLLO
 * Aprendizaje, superación y crecimiento personal
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/header.php';
?>

    <!-- Page Header / Hero -->
    <section class="hero-section" style="padding: 55px 0 45px; background: linear-gradient(180deg, #f1f5f9 0%, #ffffff 100%); border-bottom: 1px solid #e2e8f0;">
        <div class="container text-center">
            <span class="section-badge"><span class="badge-dot"></span> EDUCACIÓN Y CRECIMIENTO</span>
            <h1 class="hero-title" style="font-size: 2.3rem; margin: 12px 0 8px;">
                Aprendizaje, Superación y <span class="text-gradient">Crecimiento Personal</span>
            </h1>
            <p class="hero-description" style="max-width: 760px; margin: 0 auto 20px; font-size: 1rem; color: #475569;">
                Impulsamos el desarrollo integral de la comunidad hispana a través del conocimiento, la disciplina, el liderazgo y el fortalecimiento familiar.
            </p>

            <div style="display: inline-flex; gap: 15px; flex-wrap: wrap; justify-content: center;">
                <a href="libros.php" class="btn btn-primary">
                    📚 Conoce los Libros de Luis Bernal
                </a>
                <a href="transmisiones.php" class="btn btn-secondary">
                    🎙️ Programas Educativos en Vivo
                </a>
            </div>
        </div>
    </section>

    <!-- Core Educational Programs -->
    <main class="container" style="padding-top: 55px; padding-bottom: 85px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; margin-bottom: 45px;">
            
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 26px; box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);">
                <div style="font-size: 2rem; margin-bottom: 10px;">🧠</div>
                <h3 style="font-size: 1.15rem; color: #0f274a; font-weight: 800; margin: 0 0 8px;">Mentalidad de Superación</h3>
                <p style="font-size: 0.88rem; color: #475569; line-height: 1.55;">
                    Supera las barreras culturales y de lenguaje con principios probados de resiliencia, metas claras y hábitos de alto rendimiento para triunfar en EE.UU.
                </p>
            </div>

            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 26px; box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);">
                <div style="font-size: 2rem; margin-bottom: 10px;">💼</div>
                <h3 style="font-size: 1.15rem; color: #0f274a; font-weight: 800; margin: 0 0 8px;">Liderazgo y Habilidades Laborales</h3>
                <p style="font-size: 0.88rem; color: #475569; line-height: 1.55;">
                    De empleado a contratista o supervisor: aprende a negociar presupuestos, liderar equipos de trabajo y comunicarte con profesionalismo y empatía.
                </p>
            </div>

            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 26px; box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);">
                <div style="font-size: 2rem; margin-bottom: 10px;">👨‍👩‍👧‍👦</div>
                <h3 style="font-size: 1.15rem; color: #0f274a; font-weight: 800; margin: 0 0 8px;">Valores Familiares y Juventud</h3>
                <p style="font-size: 0.88rem; color: #475569; line-height: 1.55;">
                    Fortalecimiento de la comunicación intergeneracional en hogares hispanos en los Estados Unidos, guiando a la juventud hacia el estudio y el éxito.
                </p>
            </div>

        </div>

        <!-- Quote Card -->
        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 30px; text-align: center; max-width: 800px; margin: 0 auto;">
            <p style="font-size: 1.1rem; color: #1e3a8a; font-weight: 600; font-style: italic; margin-bottom: 10px;">
                "El mayor patrimonio de nuestra comunidad no son los bienes materiales, sino la capacidad incansable de aprender, superarnos y dejar un legado de oportunidades a nuestros hijos."
            </p>
            <span style="font-size: 0.86rem; color: #475569; font-weight: 700;">— Luis Bernal · Mi Visión Latina</span>
        </div>
    </main>

<?php require_once __DIR__ . '/footer.php'; ?>
