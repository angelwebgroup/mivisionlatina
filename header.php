<?php
/**
 * MI VISIÓN LATINA - Header Component
 * Optimized for Core Web Vitals (Inter font preloading, zero CLS, semantic markup)
 */
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= !empty($page_title) ? htmlspecialchars($page_title) . ' | ' . SITE_NAME : SITE_NAME . ' | Informar · Educar · Conectar · Impulsar oportunidades' ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?= !empty($page_description) ? htmlspecialchars($page_description) : 'Mi Visión Latina: Portal integral de noticias, educación financiera, programas en vivo con Plática con Luis, bolsa de trabajo para la comunidad latina en Houston y libros de Luis Bernal.' ?>">
    <meta name="keywords" content="Mi Visión Latina, Plática con Luis, Élite Noticias, La Plati-K, Educador Financiero USA, El Financiero Educador, Trabajo Latino Houston, Empleos para latinos, Libros Luis Bernal">
    <meta name="author" content="Mi Visión Latina">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://<?= SITE_DOMAIN ?>/">
    <meta property="og:title" content="<?= !empty($page_title) ? htmlspecialchars($page_title) . ' · ' . SITE_NAME : SITE_NAME . ' · Informar, Educar, Conectar' ?>">
    <meta property="og:description" content="<?= !empty($page_description) ? htmlspecialchars($page_description) : 'Transmisiones en vivo, actualidad, finanzas, empleo y superación personal para la comunidad hispana.' ?>">
    <meta property="og:image" content="images/logo-mivisionlatina.png">

    <!-- Preload Critical Assets for Core Web Vitals -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" type="image/png" href="images/logo-mivisionlatina.png">
</head>
<body>

    <!-- Top Announcement Ticker Bar -->
    <div class="top-bar">
        <div class="container top-bar-content">
            <div class="top-tagline">
                <span class="live-pulse"></span>
                <strong>MI VISIÓN LATINA</strong>
                <span>— Portal Oficial de Noticias, Programas y Empleo</span>
            </div>
            <div class="top-links">
                <a href="<?= FB_TRABAJOS_HOUSTON ?>" target="_blank" rel="noopener noreferrer" class="top-social-link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    <span>Trabajos en Houston</span>
                </a>
                <a href="<?= YT_PLATICA_CON_LUIS ?>" target="_blank" rel="noopener noreferrer" class="top-social-link" style="background: rgba(220,38,38,0.18); border-color: rgba(220,38,38,0.3); color: #fca5a5;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    <span>YouTube Oficial</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <?php $current_page = basename($_SERVER['PHP_SELF']); ?>
    <header class="site-header">
        <div class="container header-container">
            <a href="index.php" class="brand-logo-wrap" title="Ir al inicio de Mi Visión Latina">
                <img src="images/logo-mivisionlatina.png" alt="Logo Mi Visión Latina" width="56" height="56" class="brand-logo-img">
                <div class="brand-text">
                    <span class="brand-title">MI VISIÓN <span class="text-navy">LATINA</span></span>
                    <span class="brand-sub">Informar · Educar · Conectar</span>
                </div>
            </a>

            <nav class="main-nav" aria-label="Navegación Principal">
                <a href="index.php" class="nav-link <?= ($current_page === 'index.php' || empty($current_page)) ? 'active' : '' ?>">Inicio</a>
                <a href="transmisiones.php" class="nav-link <?= $current_page === 'transmisiones.php' ? 'active' : '' ?>">Transmisiones</a>
                <a href="noticias.php" class="nav-link <?= $current_page === 'noticias.php' ? 'active' : '' ?>">Noticias</a>
                <a href="finanzas.php" class="nav-link <?= $current_page === 'finanzas.php' ? 'active' : '' ?>">Finanzas</a>
                <a href="trabajo.php" class="nav-link <?= $current_page === 'trabajo.php' ? 'active' : '' ?>">Bolsa de Empleo</a>
                <a href="educacion.php" class="nav-link <?= $current_page === 'educacion.php' ? 'active' : '' ?>">Educación</a>
                <a href="libros.php" class="nav-link <?= $current_page === 'libros.php' ? 'active' : '' ?>">Libros</a>
            </nav>

            <button class="mobile-menu-toggle" aria-label="Abrir Menú de Navegación" aria-expanded="false">
                ☰ Menú
            </button>
        </div>
    </header>
