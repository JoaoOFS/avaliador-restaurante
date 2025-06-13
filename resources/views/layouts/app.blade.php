<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Critério Gourmet - Encontre os melhores restaurantes e compartilhe suas experiências">

        <title>Critério Gourmet - @yield('title', 'Sistema de Avaliação de Restaurantes')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Alpine.js -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Estilos refinados -->
        <style>
            /* Estilos Base */
            :root {
                /* Cores principais - Paleta inspirada em safira e âmbar */
                --primary-color: #4A90E2;
                --primary-dark: #2C5282;
                --primary-light: #63B3ED;
                --accent-color: #F6AD55;
                --accent-dark: #C05621;
                --accent-light: #FBD38D;

                /* Cores de fundo - Gradiente profundo */
                --background-color: #0F172A;
                --surface-color: #1E293B;
                --card-bg: rgba(15, 23, 42, 0.95);
                --input-bg: rgba(30, 41, 59, 0.9);

                /* Cores de texto - Melhor contraste */
                --text-color: #F8FAFC;
                --text-muted: #CBD5E1;
                --text-light: #FFFFFF;
                --text-dark: #1E293B;

                /* Cores de estado */
                --success-color: #34D399;
                --error-color: #F87171;
                --warning-color: #FBBF24;

                /* Efeitos */
                --glass-bg: rgba(15, 23, 42, 0.95);
                --glass-blur: 12px;
                --card-border: rgba(74, 144, 226, 0.15);
                --input-border: rgba(74, 144, 226, 0.2);

                /* Gradientes */
                --gradient-primary: linear-gradient(135deg, #4A90E2 0%, #63B3ED 100%);
                --gradient-accent: linear-gradient(135deg, #F6AD55 0%, #FBD38D 100%);
                --gradient-dark: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
                --gradient-card: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 41, 59, 0.95) 100%);
            }

            /* Efeitos de Loading */
            .loading {
                position: relative;
                pointer-events: none;
            }

            .loading::after {
                content: '';
                position: absolute;
                inset: 0;
                background: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(4px);
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .loading::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 40px;
                height: 40px;
                border: 4px solid var(--primary-color);
                border-top-color: transparent;
                border-radius: 50%;
                z-index: 1;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                to { transform: translate(-50%, -50%) rotate(360deg); }
            }

            /* Efeito de Parallax no Header */
            .glass-header {
                background: var(--glass-bg);
                backdrop-filter: blur(var(--glass-blur));
                border-bottom: 1px solid var(--card-border);
                transition: transform 0.3s ease;
            }

            /* Barra de Progresso do Scroll */
            .scroll-progress {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 3px;
                background: var(--primary-color);
                transform-origin: 0 50%;
                transform: scaleX(0);
                transition: transform 0.2s ease;
                z-index: 1000;
            }

            /* Sistema de Notificações */
            .notification {
                position: fixed;
                bottom: 20px;
                right: 20px;
                padding: 1rem 2rem;
                border-radius: 0.5rem;
                background: var(--glass-bg);
                backdrop-filter: blur(var(--glass-blur));
                border: 1px solid var(--card-border);
                transform: translateY(100%);
                opacity: 0;
                transition: all 0.3s ease;
                z-index: 1000;
            }

            .notification.show {
                transform: translateY(0);
                opacity: 1;
            }

            .notification.success {
                background: var(--success-color);
                color: var(--text-light);
            }

            .notification.error {
                background: var(--error-color);
                color: var(--text-light);
            }

            /* Menu Mobile */
            .mobile-menu {
                position: fixed;
                top: 0;
                right: -100%;
                width: 80%;
                max-width: 400px;
                height: 100vh;
                background: var(--glass-bg);
                backdrop-filter: blur(var(--glass-blur));
                transition: right 0.3s ease;
                z-index: 1000;
            }

            .mobile-menu.active {
                right: 0;
            }

            /* Efeito de Hover 3D - Removido para formulários */
            .hover-3d {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .hover-3d:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            /* Efeitos de Animação */
            .fade-in {
                animation: fadeIn 0.5s ease forwards;
            }

            .slide-up {
                animation: slideUp 0.5s ease forwards;
            }

            .scale-in {
                animation: scaleIn 0.5s ease forwards;
            }

            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }

            @keyframes slideUp {
                from { transform: translateY(20px); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }

            @keyframes scaleIn {
                from { transform: scale(0.9); opacity: 0; }
                to { transform: scale(1); opacity: 1; }
            }

            /* Efeitos de Hover */
            .hover-glow:hover {
                box-shadow: 0 0 20px rgba(79, 70, 229, 0.3);
            }

            .hover-lift {
                transition: transform 0.3s ease;
            }

            .hover-lift:hover {
                transform: translateY(-5px);
            }

            /* Efeitos de Texto */
            .gradient-text {
                background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-size: 200% 200%;
                animation: gradient 5s ease infinite;
            }

            @keyframes gradient {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            /* Efeitos de Loading Skeleton */
            .skeleton {
                background: linear-gradient(90deg,
                    rgba(255, 255, 255, 0.1) 25%,
                    rgba(255, 255, 255, 0.2) 50%,
                    rgba(255, 255, 255, 0.1) 75%
                );
                background-size: 200% 100%;
                animation: skeleton-loading 1.5s infinite;
            }

            @keyframes skeleton-loading {
                0% {
                    background-position: 200% 0;
                }
                100% {
                    background-position: -200% 0;
                }
            }

            html, body {
                height: 100%;
            }

            body {
                font-family: 'Inter', sans-serif;
                color: var(--text-color);
                background: var(--gradient-dark);
                min-height: 100vh;
                font-size: 1rem;
                line-height: 1.6;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }

            h1, h2, h3, h4, h5, h6 {
                font-family: 'Poppins', sans-serif;
                font-weight: 600;
                color: var(--text-light);
                letter-spacing: -0.025em;
            }

            /* Header profissional */
            .glass-header {
                background: var(--glass-bg);
                backdrop-filter: blur(var(--glass-blur));
                border-bottom: 1px solid var(--card-border);
                box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
                padding: 1.5rem 0;
                position: relative;
                z-index: 40;
            }

            .glass-header h1 {
                font-size: 2.25rem;
                font-weight: 700;
                color: var(--text-light);
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                margin-bottom: 0.5rem;
                background: none;
                -webkit-text-fill-color: var(--text-light);
            }

            .glass-header p {
                color: var(--text-light);
                font-size: 1.1rem;
                max-width: 42rem;
                line-height: 1.6;
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            }

            /* Navbar refinada */
            .navbar {
                background: var(--glass-bg);
                backdrop-filter: blur(var(--glass-blur));
                border-bottom: 1px solid var(--card-border);
                padding: 0.75rem 0;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 50;
                transition: all 0.3s ease;
            }

            .navbar-brand {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--text-light);
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            .navbar-brand img {
                height: 2rem;
                width: auto;
            }

            .nav-link {
                color: var(--text-muted) !important;
                font-weight: 500;
                padding: 0.5rem 1rem;
                border-radius: 0.5rem;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
            }

            .nav-link:hover {
                color: var(--text-light) !important;
                background: rgba(74, 144, 226, 0.15);
                transform: translateY(-1px);
            }

            .nav-link.active {
                color: var(--primary-color) !important;
                background: rgba(74, 144, 226, 0.1);
            }

            .nav-link.active::after {
                content: '';
                position: absolute;
                bottom: -2px;
                left: 50%;
                transform: translateX(-50%);
                width: 20px;
                height: 2px;
                background: var(--primary-color);
                border-radius: 2px;
            }

            .content-wrapper {
                background: transparent;
                min-height: calc(100vh - 4rem);
                padding-top: 4.5rem;
            }

            /* Cards refinados */
            .card {
                background: var(--gradient-card);
                border: 1px solid var(--card-border);
                border-radius: 1rem;
                padding: 1.5rem;
                transition: border-color 0.3s ease, box-shadow 0.3s ease;
            }

            .card:hover {
                border-color: var(--primary-color);
                box-shadow: 0 4px 12px rgba(74, 144, 226, 0.1);
            }

            /* Ajustes para inputs e formulários */
            .input, input, select, textarea {
                background: var(--input-bg) !important;
                color: var(--text-light) !important;
                border: 1px solid var(--input-border) !important;
                border-radius: 0.5rem !important;
                padding: 0.75rem 1rem !important;
                font-size: 1rem !important;
                transition: border-color 0.3s ease, box-shadow 0.3s ease !important;
            }

            .input:hover, input:hover, select:hover, textarea:hover {
                border-color: var(--primary-color) !important;
            }

            .input:focus, input:focus, select:focus, textarea:focus {
                border-color: var(--primary-color) !important;
                box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1) !important;
                outline: none;
            }

            /* Botões refinados */
            .btn {
                padding: 0.75rem 1.5rem;
                font-weight: 600;
                border-radius: 0.5rem;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                overflow: hidden;
            }

            .btn::after {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                width: 5px;
                height: 5px;
                background: rgba(255, 255, 255, 0.5);
                opacity: 0;
                border-radius: 100%;
                transform: scale(1, 1) translate(-50%);
                transform-origin: 50% 50%;
            }

            .btn:hover::after {
                animation: ripple 1s ease-out;
            }

            @keyframes ripple {
                0% {
                    transform: scale(0, 0);
                    opacity: 0.5;
                }
                100% {
                    transform: scale(20, 20);
                    opacity: 0;
                }
            }

            .btn-primary {
                background: var(--gradient-primary);
                border: none;
                color: var(--text-light);
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 24px rgba(74, 144, 226, 0.25);
            }

            .btn-secondary {
                background: transparent;
                border: 1px solid var(--primary-color);
                color: var(--primary-color);
            }

            .btn-secondary:hover {
                background: rgba(74, 144, 226, 0.1);
                transform: translateY(-2px);
            }

            /* Microinterações */
            .card, .btn-primary, .btn-secondary, .nav-link {
                will-change: transform, box-shadow, border;
            }

            .fade-in {
                animation: fadeIn 0.7s cubic-bezier(.39,.575,.565,1) both;
            }

            @keyframes fadeIn {
                0% { opacity: 0; transform: translateY(16px); }
                100% { opacity: 1; transform: translateY(0); }
            }

            /* Footer profissional */
            .footer {
                background: var(--gradient-dark);
                border-top: 1px solid var(--card-border);
                padding: 3rem 0 1.5rem;
                margin-top: 4rem;
            }

            .footer-content {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 2rem;
                margin-bottom: 2rem;
            }

            .footer-section h3 {
                color: var(--text-light);
                font-size: 1.25rem;
                font-weight: 600;
                margin-bottom: 1rem;
            }

            .footer-section p {
                color: var(--text-muted);
                line-height: 1.6;
                margin-bottom: 1rem;
            }

            .footer-links {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .footer-links li {
                margin-bottom: 0.75rem;
            }

            .footer-links a {
                color: var(--text-muted);
                text-decoration: none;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                display: flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.25rem 0;
            }

            .footer-links a:hover {
                color: var(--primary-color);
                transform: translateX(4px);
            }

            .footer-links a i {
                transition: transform 0.3s ease;
            }

            .footer-links a:hover i {
                transform: scale(1.1);
            }

            .social-links {
                display: flex;
                gap: 1rem;
                margin-top: 1rem;
            }

            .social-links a {
                color: var(--text-muted);
                font-size: 1.25rem;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                width: 2.5rem;
                height: 2.5rem;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 0.5rem;
                background: rgba(74, 144, 226, 0.1);
            }

            .social-links a:hover {
                color: var(--text-light);
                background: var(--primary-color);
                transform: translateY(-2px) scale(1.05);
            }

            .footer-bottom {
                border-top: 1px solid var(--card-border);
                padding-top: 1.5rem;
                text-align: center;
                color: var(--text-muted);
                font-size: 0.875rem;
            }

            /* Alertas refinados */
            .alert {
                border-radius: 0.75rem;
                padding: 1rem 1.25rem;
                margin-bottom: 1.5rem;
                display: flex;
                align-items: center;
                gap: 0.75rem;
                background: var(--glass-bg);
                backdrop-filter: blur(var(--glass-blur));
                border: 1px solid var(--card-border);
                transition: all 0.3s ease;
            }

            .alert:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            .alert i {
                font-size: 1.25rem;
            }

            .alert-success {
                border-color: var(--success-color);
                color: var(--success-color);
            }

            .alert-error {
                border-color: var(--error-color);
                color: var(--error-color);
            }

            .alert-warning {
                border-color: var(--warning-color);
                color: var(--warning-color);
            }

            .rating-stars {
                color: var(--primary-color);
                font-size: 1.13em;
            }

            .badge {
                padding: 0.35rem 0.9rem;
                border-radius: 1.2rem;
                font-weight: 600;
                background: var(--gradient-primary);
                color: var(--text-light);
                font-size: 0.9rem;
                box-shadow: 0 2px 8px rgba(184, 134, 11, 0.2);
            }

            .highlight {
                position: relative;
            }

            .highlight::after {
                content: '';
                position: absolute;
                bottom: -2px;
                left: 0;
                width: 100%;
                height: 2px;
                background: var(--gradient-primary);
            }

            /* Ajustes para cards e textos */
            .card h2, .card h3 {
                color: var(--text-light);
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            }

            .card p {
                color: var(--text-muted);
                text-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
            }

            /* Ajustes para textos em fundos claros */
            .text-on-light {
                color: var(--text-dark);
                text-shadow: none;
            }

            /* Ajustes para textos em fundos escuros */
            .text-on-dark {
                color: var(--text-light);
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            }

            /* Ajustes para textos em gradientes */
            .text-on-gradient {
                color: var(--text-light);
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            }

            /* Ajustes para textos em imagens */
            .text-on-image {
                color: var(--text-light);
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
                background: linear-gradient(to bottom, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.6));
                padding: 0.5rem 1rem;
                border-radius: 0.5rem;
                backdrop-filter: blur(4px);
            }

            /* Responsividade refinada */
            @media (max-width: 768px) {
                .glass-header {
                    padding: 1rem 0;
                }

                .glass-header h1 {
                    font-size: 1.75rem;
                }

                .footer-content {
                    grid-template-columns: 1fr;
                    text-align: center;
                }

                .social-links {
                    justify-content: center;
                }

                .footer-links a {
                    justify-content: center;
                }
            }

            /* Estilos para CTA com imagem de fundo */
            .cta-section {
                position: relative;
                overflow: hidden;
                border-radius: 1rem;
            }

            .cta-section::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(
                    to right,
                    rgba(15, 23, 42, 0.95),
                    rgba(30, 41, 59, 0.85)
                );
                z-index: 1;
            }

            .cta-content {
                position: relative;
                z-index: 2;
                padding: 3rem 2rem;
            }

            .cta-title {
                color: var(--text-light);
                font-size: 2.5rem;
                font-weight: 700;
                margin-bottom: 1rem;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            }

            .cta-description {
                color: var(--text-light);
                font-size: 1.2rem;
                line-height: 1.6;
                margin-bottom: 2rem;
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
                max-width: 600px;
            }

            .cta-buttons {
                display: flex;
                gap: 1rem;
                flex-wrap: wrap;
            }

            .cta-button {
                padding: 1rem 2rem;
                font-size: 1.1rem;
                font-weight: 600;
                border-radius: 0.5rem;
                transition: all 0.3s ease;
                text-shadow: none;
            }

            .cta-button-primary {
                background: var(--gradient-primary);
                color: var(--text-light);
                border: none;
            }

            .cta-button-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 24px rgba(74, 144, 226, 0.3);
            }

            .cta-button-secondary {
                background: rgba(255, 255, 255, 0.1);
                color: var(--text-light);
                border: 1px solid rgba(255, 255, 255, 0.2);
                backdrop-filter: blur(4px);
            }

            .cta-button-secondary:hover {
                background: rgba(255, 255, 255, 0.15);
                transform: translateY(-2px);
            }

            /* Responsividade para CTA */
            @media (max-width: 768px) {
                .cta-content {
                    padding: 2rem 1.5rem;
                }

                .cta-title {
                    font-size: 2rem;
                }

                .cta-description {
                    font-size: 1.1rem;
                }

                .cta-buttons {
                    flex-direction: column;
                }

                .cta-button {
                    width: 100%;
                    text-align: center;
                }
            }

            /* Estilos específicos para selects */
            select {
                appearance: none;
                background-color: var(--input-bg) !important;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23CBD5E1'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 0.75rem center;
                background-size: 1.5em 1.5em;
                padding-right: 2.5rem !important;
                color: var(--text-light) !important;
                border: 1px solid var(--input-border) !important;
                border-radius: 0.5rem !important;
                transition: all 0.3s ease;
            }

            select:hover {
                border-color: var(--primary-color) !important;
                background-color: rgba(74, 144, 226, 0.05) !important;
            }

            select:focus {
                border-color: var(--primary-color) !important;
                box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1) !important;
                outline: none;
            }

            select option {
                background-color: var(--surface-color);
                color: var(--text-light);
                padding: 0.75rem;
            }

            select option:hover {
                background-color: var(--primary-dark);
            }

            /* Estilo para o placeholder do select */
            select:invalid {
                color: var(--text-muted) !important;
            }

            /* Ajuste para labels dos selects */
            label {
                color: var(--text-light);
                font-weight: 500;
                margin-bottom: 0.5rem;
                display: block;
            }

            /* Ajuste para mensagens de erro */
            .text-red-500 {
                color: var(--error-color) !important;
            }

            /* Ajustes para ícones */
            .fas, .far, .fab {
                display: inline-block !important;
                font-style: normal !important;
                font-variant: normal !important;
                text-rendering: auto !important;
                -webkit-font-smoothing: antialiased !important;
            }

            /* Removendo a regra que força a cor branca */
            .fa-utensils, .fa-map-marker-alt, .fa-search, .fa-plus, .fa-eye {
                color: var(--text-light) !important;
            }

            .badge .fas {
                color: var(--text-light) !important;
            }

            .btn .fas {
                margin-right: 0.5rem;
            }

            /* Estilo para o nome do site */
            .brand-name {
                font-family: 'Playfair Display', serif;
                font-size: 1.5rem;
                font-weight: 700;
                background: linear-gradient(to right, #FFFFFF, #E2E8F0);
                -webkit-background-clip: text;
                background-clip: text;
                color: #FFFFFF;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
                letter-spacing: 0.5px;
                position: relative;
                display: inline-block;
            }

            .brand-name::after {
                content: '';
                position: absolute;
                bottom: -2px;
                left: 0;
                width: 100%;
                height: 2px;
                background: var(--primary-color);
                transform: scaleX(0);
                transform-origin: right;
                transition: transform 0.3s ease;
            }

            .brand-name:hover::after {
                transform: scaleX(1);
                transform-origin: left;
            }

            .brand-icon {
                animation: pulse 2s infinite;
            }

            @keyframes pulse {
                0% {
                    transform: scale(1);
                }
                50% {
                    transform: scale(1.1);
                }
                100% {
                    transform: scale(1);
                }
            }

            /* Animações suaves */
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }

            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(20px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            .animate-fade-in {
                animation: fadeIn 0.5s ease-out;
            }

            .animate-fade-in-up {
                animation: fadeInUp 0.5s ease-out;
            }

            .animate-slide-in-right {
                animation: slideInRight 0.5s ease-out;
            }

            .hover-lift {
                transition: transform 0.3s ease;
            }

            .hover-lift:hover {
                transform: translateY(-5px);
            }

            .hover-scale {
                transition: transform 0.3s ease;
            }

            .hover-scale:hover {
                transform: scale(1.05);
            }

            /* Efeito de brilho nos cards */
            .card {
                position: relative;
                overflow: hidden;
            }

            .card::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(
                    90deg,
                    transparent,
                    rgba(255, 255, 255, 0.1),
                    transparent
                );
                transition: 0.5s;
            }

            .card:hover::before {
                left: 100%;
            }

            /* Efeito de gradiente animado nos botões */
            .btn-primary {
                background-size: 200% 200%;
                animation: gradientMove 3s ease infinite;
            }

            @keyframes gradientMove {
                0% {
                    background-position: 0% 50%;
                }
                50% {
                    background-position: 100% 50%;
                }
                100% {
                    background-position: 0% 50%;
                }
            }

            /* Estilos específicos para as estrelas de avaliação */
            .rating-star {
                cursor: pointer;
                transition: all 0.2s ease-in-out;
                color: #D1D5DB !important; /* text-gray-300 */
            }

            .rating-star:hover,
            .rating-star:hover ~ .rating-star {
                color: #FCD34D !important; /* text-yellow-400 */
            }

            .rating-star.active,
            .rating-star.active ~ .rating-star {
                color: #FCD34D !important; /* text-yellow-400 */
            }

            .rating-star.inactive {
                color: #D1D5DB !important; /* text-gray-300 */
            }

            /* Estilos para o preview de imagens */
            .image-preview img {
                transition: transform 0.2s ease-in-out;
            }

            .image-preview:hover img {
                transform: scale(1.05);
            }

            /* Efeitos de Parallax e Animações */
            .parallax-section {
                position: relative;
                overflow: hidden;
                transform-style: preserve-3d;
                perspective: 1000px;
            }

            .parallax-section::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(135deg, rgba(74, 144, 226, 0.1) 0%, rgba(99, 179, 237, 0.1) 100%);
                transform: translateZ(-1px) scale(2);
                z-index: -1;
            }

            .animate-on-scroll {
                opacity: 0;
                transform: translateY(30px);
                transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .animate-on-scroll.visible {
                opacity: 1;
                transform: translateY(0);
            }

            .animate-fade-in-up {
                animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            }

            .animate-fade-in-down {
                animation: fadeInDown 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            }

            .animate-fade-in-left {
                animation: fadeInLeft 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            }

            .animate-fade-in-right {
                animation: fadeInRight 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fadeInDown {
                from {
                    opacity: 0;
                    transform: translateY(-30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fadeInLeft {
                from {
                    opacity: 0;
                    transform: translateX(-30px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            @keyframes fadeInRight {
                from {
                    opacity: 0;
                    transform: translateX(30px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            /* Efeito de Partículas no Fundo */
            .particles-container {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
                z-index: -1;
            }

            .particle {
                position: absolute;
                background: rgba(74, 144, 226, 0.1);
                border-radius: 50%;
                pointer-events: none;
                animation: float 20s infinite linear;
            }

            @keyframes float {
                0% {
                    transform: translateY(0) rotate(0deg);
                }
                100% {
                    transform: translateY(-100vh) rotate(360deg);
                }
            }

            /* Efeito de Cursor Personalizado */
            .custom-cursor {
                width: 20px;
                height: 20px;
                background: rgba(74, 144, 226, 0.3);
                border-radius: 50%;
                position: fixed;
                pointer-events: none;
                z-index: 9999;
                transition: transform 0.2s ease;
            }

            .custom-cursor.active {
                transform: scale(2);
                background: rgba(74, 144, 226, 0.1);
            }

            /* Efeito de Hover nos Cards com Gradiente */
            .card-hover-gradient {
                position: relative;
                overflow: hidden;
            }

            .card-hover-gradient::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(45deg,
                    rgba(74, 144, 226, 0.1),
                    rgba(99, 179, 237, 0.1),
                    rgba(74, 144, 226, 0.1)
                );
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .card-hover-gradient:hover::before {
                opacity: 1;
            }

            /* Efeito de Loading mais Elegante */
            .loading-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(15, 23, 42, 0.8);
                backdrop-filter: blur(8px);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            .loading-overlay.active {
                opacity: 1;
                visibility: visible;
            }

            .loading-spinner {
                width: 50px;
                height: 50px;
                border: 3px solid rgba(74, 144, 226, 0.3);
                border-radius: 50%;
                border-top-color: var(--primary-color);
                animation: spin 1s linear infinite;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-transparent">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="glass-header shadow-lg fade-in" style="padding: 2.2rem 0 1.2rem 0;">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                            <div class="text-center md:text-left flex-1">
                                <h1 class="text-3xl md:text-4xl font-bold tracking-tight mb-2 highlight">
                                    {{ $header }}
                                </h1>
                                @isset($subheader)
                                    <p class="text-base text-gray-400 max-w-2xl">{{ $subheader }}</p>
                                @endisset
                            </div>
                            @hasSection('headerAction')
                                <div class="flex-shrink-0 mt-4 md:mt-0">
                                    @yield('headerAction')
                                </div>
                            @endif
                        </div>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="content-wrapper">
                <div class="max-w-7xl mx-auto py-6 px-2 sm:px-6 lg:px-8">
                    @if (session('success'))
                        <div class="alert alert-success fade-in">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-error fade-in">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="alert alert-warning fade-in">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>{{ session('warning') }}</span>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="footer fade-in">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="footer-content">
                        <div class="footer-section">
                            <h3>Sobre Nós</h3>
                            <p>Conectando pessoas aos melhores restaurantes através de avaliações autênticas e experiências compartilhadas.</p>
                            <div class="social-links">
                                <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                                <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                                <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>

                        <div class="footer-section">
                            <h3>Links Rápidos</h3>
                            <ul class="footer-links">
                                <li><a href="{{ route('restaurants.index') }}"><i class="fas fa-utensils"></i> Restaurantes</a></li>
                                <li><a href="{{ route('categories.index') }}"><i class="fas fa-tags"></i> Categorias</a></li>
                                <li><a href="{{ route('cuisines.index') }}"><i class="fas fa-globe"></i> Cozinhas</a></li>
                                <li><a href="#"><i class="fas fa-star"></i> Mais Avaliados</a></li>
                            </ul>
                        </div>

                        <div class="footer-section">
                            <h3>Suporte</h3>
                            <ul class="footer-links">
                                <li><a href="#"><i class="fas fa-question-circle"></i> FAQ</a></li>
                                <li><a href="#"><i class="fas fa-envelope"></i> Contato</a></li>
                                <li><a href="#"><i class="fas fa-shield-alt"></i> Privacidade</a></li>
                                <li><a href="#"><i class="fas fa-file-alt"></i> Termos de Uso</a></li>
                            </ul>
                        </div>

                        <div class="footer-section">
                            <h3>Newsletter</h3>
                            <p>Receba as melhores recomendações e novidades diretamente no seu e-mail.</p>
                            <form class="mt-4">
                                <div class="flex gap-2">
                                    <input type="email" placeholder="Seu e-mail" class="input flex-1" required>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="footer-bottom">
                        <p>&copy; {{ date('Y') }} Critério Gourmet. Todos os direitos reservados.</p>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Scripts -->
        <script>
            // Adiciona classe de loading aos formulários
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', () => {
                    form.classList.add('loading');
                });
            });

            // Fecha alertas automaticamente após 5 segundos
            document.querySelectorAll('.alert').forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });

            // Efeito de Parallax no Header
            window.addEventListener('scroll', () => {
                const header = document.querySelector('.glass-header');
                if (header) {
                    const scrolled = window.pageYOffset;
                    header.style.transform = `translateY(${scrolled * 0.5}px)`;
                }
            });

            // Barra de Progresso do Scroll
            const progressBar = document.createElement('div');
            progressBar.className = 'scroll-progress';
            document.body.appendChild(progressBar);

            window.addEventListener('scroll', () => {
                const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
                const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const scrolled = (winScroll / height) * 100;
                progressBar.style.transform = `scaleX(${scrolled / 100})`;
            });

            // Sistema de Notificações
            function showNotification(message, type = 'success') {
                const notification = document.createElement('div');
                notification.className = `notification ${type}`;
                notification.textContent = message;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.classList.add('show');
                }, 100);

                setTimeout(() => {
                    notification.classList.remove('show');
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }

            // Menu Mobile
            const menuButton = document.querySelector('.mobile-menu-button');
            const mobileMenu = document.querySelector('.mobile-menu');

            if (menuButton && mobileMenu) {
                menuButton.addEventListener('click', () => {
                    mobileMenu.classList.toggle('active');
                });
            }

            // Lazy Loading de Imagens
            const lazyImages = document.querySelectorAll('img[data-src]');
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        observer.unobserve(img);
                    }
                });
            });

            lazyImages.forEach(img => imageObserver.observe(img));

            // Animação ao Scroll
            const animateOnScroll = () => {
                const elements = document.querySelectorAll('.animate-on-scroll');
                elements.forEach(element => {
                    const elementTop = element.getBoundingClientRect().top;
                    const elementBottom = element.getBoundingClientRect().bottom;
                    const isVisible = (elementTop < window.innerHeight) && (elementBottom > 0);

                    if (isVisible) {
                        element.classList.add('visible');
                    }
                });
            };

            window.addEventListener('scroll', animateOnScroll);
            window.addEventListener('load', animateOnScroll);

            // Efeito de Partículas
            const createParticles = () => {
                const container = document.createElement('div');
                container.className = 'particles-container';
                document.body.appendChild(container);

                for (let i = 0; i < 50; i++) {
                    const particle = document.createElement('div');
                    particle.className = 'particle';
                    particle.style.width = Math.random() * 10 + 5 + 'px';
                    particle.style.height = particle.style.width;
                    particle.style.left = Math.random() * 100 + 'vw';
                    particle.style.animationDuration = Math.random() * 20 + 10 + 's';
                    particle.style.animationDelay = Math.random() * 5 + 's';
                    container.appendChild(particle);
                }
            };

            createParticles();

            // Cursor Personalizado
            const cursor = document.createElement('div');
            cursor.className = 'custom-cursor';
            document.body.appendChild(cursor);

            document.addEventListener('mousemove', (e) => {
                cursor.style.left = e.clientX + 'px';
                cursor.style.top = e.clientY + 'px';
            });

            document.addEventListener('mousedown', () => cursor.classList.add('active'));
            document.addEventListener('mouseup', () => cursor.classList.remove('active'));

            // Loading Overlay
            const loadingOverlay = document.createElement('div');
            loadingOverlay.className = 'loading-overlay';
            loadingOverlay.innerHTML = '<div class="loading-spinner"></div>';
            document.body.appendChild(loadingOverlay);

            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', () => {
                    loadingOverlay.classList.add('active');
                });
            });
        </script>

        @stack('scripts')
    </body>
</html>
