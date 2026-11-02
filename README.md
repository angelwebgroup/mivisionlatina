# MI VISIÓN LATINA (mivisionlatina.com)
*Informar · Educar · Conectar · Impulsar oportunidades*

Portal web oficial y plataforma multimedia para la firma de comunicación hispana **Mi Visión Latina**. Desarrollado en **PHP Core**, totalmente responsivo, con tipografía **Inter**, paleta de colores Navy & Oro Imperial, efectos animados en botones y optimizado para pasar las métricas de **Core Web Vitals** (velocidad, CLS cero, renderizado instantáneo).

---

## 🏛️ Estructura del Proyecto

```text
/Applications/XAMPP/xamppfiles/htdocs/mivisionlatina.com/
├── config.php               # Configuración central, enlaces de redes sociales y constantes
├── db.php                   # Conexión PDO SQLite/MySQL, esquema y funciones de candidatos
├── ajax_submit_job.php      # Endpoint seguro AJAX para registro de candidatos sin recargar
├── header.php               # Encabezado unificado, preloads de fuentes Inter, SEO y menú
├── footer.php               # Pie de página y matriz de canales oficiales (Facebook y YouTube)
├── index.php                # Portal principal con los 6 pilares, reproductor en vivo y formulario
├── trabajo.php              # Directorio de vacantes con filtros por categoría y registro general
├── empleo.php               # Página dedicada para cada vacante con JD completo y postulación directa
├── admin_candidatos.php     # Panel con pestañas independientes para listar, publicar vacantes, vencimientos y CVs
├── assets/
│   ├── css/style.css        # CSS optimizado con animaciones, gradientes y diseño responsivo
│   └── js/main.js           # JavaScript vanilla ligero (switcher de videos, AJAX, toasts)
├── data/
│   └── trabajo_latino.sqlite # Base de datos SQLite automática (portabilidad 100% en XAMPP)
└── images/
    ├── logo-mivisionlatina.png      # Logo oficial Mi Visión Latina
    ├── platica-con-luis-studio.jpg  # Imagen de estudio On Air
    ├── platica-con-luis-banner.jpg  # Banner de estudio Plática con Luis
    └── logo-laplatik.jpg            # Logo oficial La Plati-K
```

---

## 🌟 Pilares y Módulos Desarrollados

### 1. Programas y Transmisiones (Plática con Luis, videos y directos)
- Reproductor de video interactivo para transmisiones en directo.
- Selector de canales en vivo:
  - *Plática con Luis (Videos y Directos)*
  - *Élite Noticias (Emisiones especiales)*
  - *Educador Financiero USA (Claves de Finanzas)*
  - *La Plati-K (Cultura y Comunidad)*
- Enlaces automáticos a YouTube (`@Platicaconluis`) y Facebook (`platicaconluis`).

### 2. Noticias y Actualidad (Élite Noticias y La Plati-K)
- Integración directa con los canales de redes oficiales:
  - **Élite Noticias**: [Facebook Oficial](https://www.facebook.com/elitenoticias01)
  - **La Plati-K**: [Facebook](https://www.facebook.com/Laplatik/) y [YouTube (@laplati-k)](https://www.youtube.com/@laplati-k)

### 3. Finanzas (Educador Financiero USA y El Financiero Educador)
- Contenidos educativos sobre crédito FICO, compra de vivienda, impuestos (ITIN/SSN) y creación de empresas (LLC).
- Enlaces directos a los canales oficiales:
  - **Educador Financiero USA**: [YouTube (@educadorfinancierousa)](https://www.youtube.com/@educadorfinancierousa)
  - **El Financiero Educador**: [YouTube (@elfinancieroeducador)](https://www.youtube.com/@elfinancieroeducador)

### 4. Trabajo y Oportunidades (Bolsa de Empleo & Trabajo Latino)
- **Páginas Individuales por Vacante (`empleo.php?id=...`)**:
  - Cada oferta laboral tiene su propia URL dedicada con Job Description (JD) detallado, funciones, compensación, requisitos y garantías.
  - Formulario de postulación directa fijado (sticky) con subida de CV (PDF, Word, RTF).
  - Botones para compartir en WhatsApp y Facebook con un solo clic.
- **Directorio de Empleos (`trabajo.php`)**:
  - Filtros modernos por pestañas/píldoras de oficio (Construcción, Limpieza, Restaurante, Chofer/CDL, etc.).
  - Tarjetas de empleo con insignias de verificación, salario resaltado, estado de vigencia y botón directo a cada vacante.
- **Panel Administrativo Rediseñado (`admin_candidatos.php`)**:
  - **Pestañas modernas e independientes:**
    - `💼 Listado de Vacantes`: tabla exclusiva de gestión con filtros por estado (Activas, Inactivas, Expiradas), búsqueda y botón directo a publicación.
    - `➕ Publicar Vacante`: pantalla/formulario dedicado e independiente para publicar o editar empleos.
    - `👥 Candidatos & Currículums`: listado de candidatos, descarga de CVs y contacto directo vía WhatsApp.
    - `📧 Registro de Notificaciones`: auditoría de correos enviados al reclutador.
  - **Activar / Desactivar Empleos**: botón de alternancia rápida (toggle) para pausar o activar cualquier oferta.
  - **Fecha de Expiración / Vencimiento (`expires_at`)**:
    - Selector de fecha con botones de acceso rápido (+15 días, +30 días, +60 días, sin límite).
    - Ocultamiento automático de vacantes vencidas en el frontend.
    - Botón de renovación instantánea (+30 días) en el listado.

### 5. Educación y Desarrollo
- Recursos de aprendizaje, liderazgo comunitario y superación personal.

### 6. Libros y Servicios (Luis Bernal en Amazon)
- Vitrina de publicaciones del autor **Luis Bernal**.
- Botón directo a su [Tienda de Autor en Amazon](https://www.amazon.com/stores/Luis-Bernal/author/B01MS9D6H2?ref=ap_rdr&shoppingPortalEnabled=true&ccs_id=26ef6ea4-8abf-4e86-99e9-c30b5b01f260).

---

## 🔐 Acceso al Panel de Candidatos

- **URL:** `http://localhost/mivisionlatina.com/admin_candidatos.php` (o `http://localhost:8000/admin_candidatos.php`)
- **Usuario:** `admin`
- **Contraseña:** `latina2025` *(Configurable en `config.php`)*

---

## ⚡ Optimización Core Web Vitals
- **Tipografía Inter** cargada con `preconnect` y `font-display: swap`.
- **CLS = 0**: Dimensiones de imágenes y contenedores con `aspect-ratio` definidos.
- **CSS Vanilla sin frameworks pesados**: Carga ultrarrápida sin bloqueos de renderizado.
- **JavaScript Vanilla**: Asíncrono, sin jQuery ni dependencias externas lentas.
# mivisionlatina
