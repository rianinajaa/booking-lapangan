<!DOCTYPE html>
<html class="dark scroll-smooth" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>SpaceGo - Booking Fasilitas Sekolah</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet" />
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "background": "#131313",
                        "on-secondary": "#003824",
                        "on-tertiary-fixed-variant": "#005137",
                        "surface-bright": "#343b37",
                        "inverse-on-surface": "#313030",
                        "tertiary-fixed": "#68fcbf",
                        "primary-fixed-dim": "#68dba9",
                        "on-surface": "#e5e2e1",
                        "void-base": "#0e0e0e",
                        "on-primary-container": "#005e41",
                        "outline-glow": "#3d4a42",
                        "on-error": "#690005",
                        "surface-variant": "#353534",
                        "surface-container-high": "#2a2a2a",
                        "outline-variant": "#3d4a42",
                        "surface-container-highest": "#353534",
                        "on-secondary-container": "#003e28",
                        "on-tertiary-container": "#005f41",
                        "secondary-container": "#00b47d",
                        "on-tertiary-fixed": "#002114",
                        "tertiary-fixed-dim": "#45dfa4",
                        "primary": "#85f8c3",
                        "secondary-fixed": "#6ffbbe",
                        "emerald-pulse": "#059669",
                        "secondary": "#4edea3",
                        "on-tertiary": "#003825",
                        "tertiary": "#68fcbf",
                        "tertiary-container": "#45dfa4",
                        "surface-container": "#201f1f",
                        "on-primary": "#003825",
                        "error-container": "#93000a",
                        "surface-tint": "#68dba9",
                        "primary-fixed": "#85f8c4",
                        "on-primary-fixed-variant": "#005137",
                        "surface-container-lowest": "#0e0e0e",
                        "glass-overlay": "rgba(5,150,105,0.15)",
                        "void-container": "#131313",
                        "on-surface-variant": "#bccac0",
                        "error-bright": "#ffb4ab",
                        "on-background": "#e5e2e1",
                        "error": "#ffb4ab",
                        "inverse-primary": "#006c4a",
                        "on-error-container": "#ffdad6",
                        "inverse-surface": "#e5e2e1",
                        "secondary-fixed-dim": "#4edea3",
                        "on-primary-fixed": "#002114",
                        "on-secondary-fixed-variant": "#005236",
                        "outline": "#87948b",
                        "on-secondary-fixed": "#002114",
                        "surface-container-low": "#1c1b1b",
                        "surface": "#131313",
                        "primary-container": "#67dba8",
                        "surface-dim": "#131313"
                    },
                    borderRadius: {
                        "DEFAULT": "1rem",
                        "lg": "2rem",
                        "xl": "3rem",
                        "full": "9999px"
                    },
                    spacing: {
                        "xl": "80px",
                        "margin": "32px",
                        "lg": "48px",
                        "base": "8px",
                        "gutter": "24px",
                        "xs": "4px",
                        "sm": "12px",
                        "md": "24px"
                    },
                    fontFamily: {
                        "body-lg": ["Plus Jakarta Sans"],
                        "body-md": ["Plus Jakarta Sans"],
                        "label-bold": ["Plus Jakarta Sans"],
                        "headline-md": ["Plus Jakarta Sans"],
                        "headline-lg": ["Plus Jakarta Sans"],
                        "display-xl-mobile": ["Plus Jakarta Sans"],
                        "display-xl": ["Plus Jakarta Sans"]
                    },
                    fontSize: {
                        "body-lg": ["18px", {
                            "lineHeight": "1.6",
                            "fontWeight": "500"
                        }],
                        "body-md": ["16px", {
                            "lineHeight": "1.6",
                            "fontWeight": "400"
                        }],
                        "label-bold": ["14px", {
                            "lineHeight": "1",
                            "letterSpacing": "0.1em",
                            "fontWeight": "700"
                        }],
                        "headline-md": ["24px", {
                            "lineHeight": "1.3",
                            "fontWeight": "700"
                        }],
                        "headline-lg": ["32px", {
                            "lineHeight": "1.2",
                            "letterSpacing": "-0.02em",
                            "fontWeight": "700"
                        }],
                        "display-xl-mobile": ["40px", {
                            "lineHeight": "1.1",
                            "letterSpacing": "-0.04em",
                            "fontWeight": "800"
                        }],
                        "display-xl": ["64px", {
                            "lineHeight": "1.1",
                            "letterSpacing": "-0.04em",
                            "fontWeight": "800"
                        }]
                    }
                }
            }
        }
    </script>
    <style>
        .glass-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, .05) 0%, rgba(5, 150, 105, .05) 100%);
            border: 1px solid rgba(133, 248, 195, .2);
            backdrop-filter: blur(20px)
        }

        .neon-glow {
            filter: drop-shadow(0 0 20px rgba(5, 150, 105, .4))
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none
        }

        /* CAROUSEL */
        .carousel-track {
            display: flex;
            transition: transform .7s cubic-bezier(.4, 0, .2, 1)
        }

        .carousel-slide {
            flex: 0 0 100%
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 9999px;
            background: rgba(133, 248, 195, .3);
            transition: all .3s ease;
            cursor: pointer
        }

        .dot.active {
            width: 24px;
            background: #85f8c3
        }

        /* TOAST */
        #toast {
            transform: translateY(100px);
            opacity: 0;
            transition: all .4s cubic-bezier(.4, 0, .2, 1)
        }

        #toast.show {
            transform: translateY(0);
            opacity: 1
        }

        /* MODAL */
        #booking-modal {
            opacity: 0;
            pointer-events: none;
            transition: opacity .3s ease
        }

        #booking-modal.open {
            opacity: 1;
            pointer-events: all
        }

        #modal-content {
            transform: scale(.92) translateY(20px);
            transition: transform .3s cubic-bezier(.4, 0, .2, 1)
        }

        #booking-modal.open #modal-content {
            transform: scale(1) translateY(0)
        }

        /* FAQ */
        details[open] summary~* {
            animation: fadeDown .3s ease
        }

        @keyframes fadeDown {
            from {
                opacity: 0;
                transform: translateY(-8px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        /* FACILITY CARD */
        .facility-card {
            transition: transform .3s ease, box-shadow .3s ease
        }

        .facility-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(5, 150, 105, .2)
        }

        /* Carousel card — menyatu dengan bg, tanpa glass */
        .carousel-card {
            background: transparent;
            border: 1px solid transparent;
            border-radius: 1rem;
            overflow: hidden;
            cursor: pointer;
            transition: border-color .3s ease, transform .3s ease, box-shadow .3s ease;
        }

        .carousel-card:hover {
            border-color: rgba(133, 248, 195, 0.35);
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(5, 150, 105, .2);
        }

        .carousel-card .card-img-wrap {
            position: relative;
            overflow: hidden;
        }

        .carousel-card .card-img-wrap img {
            transition: transform .5s ease, opacity .3s ease;
            opacity: .7;
        }

        .carousel-card:hover .card-img-wrap img {
            transform: scale(1.05);
            opacity: 1;
        }

        .carousel-card .card-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: .75rem;
            flex: 1;
        }

        /* NAV ACTIVE */
        .nav-active {
            color: #85f8c3;
            filter: drop-shadow(0 0 10px rgba(133, 248, 195, .4));
            transform: scale(1.1)
        }
    </style>
</head>

<body class="bg-void-base text-on-surface font-body-md min-h-screen overflow-x-hidden selection:bg-primary/30 selection:text-primary">
   <!-- Main Content -->
    <main">
        @yield('content')
    </main>
</body>