<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Admin Dashboard | Saffron &amp; Sage</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;family=Be+Vietnam+Pro:wght@400;500;600&amp;family=Instrument+Sans:wght@400;500;600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "tertiary-container": "#8d6c00",
                        "surface-dim": "#dfd9d2",
                        "on-secondary-container": "#336f3e",
                        "error": "#ba1a1a",
                        "on-surface-variant": "#594238",
                        "secondary-fixed-dim": "#96d69b",
                        "outline": "#8c7167",
                        "surface-tint": "#a53c00",
                        "on-secondary-fixed-variant": "#135225",
                        "on-error-container": "#93000a",
                        "on-tertiary": "#ffffff",
                        "on-background": "#1d1b17",
                        "inverse-primary": "#ffb598",
                        "surface-container": "#f3ede6",
                        "on-surface": "#1d1b17",
                        "primary-container": "#c44900",
                        "inverse-on-surface": "#f6f0e9",
                        "secondary-fixed": "#b1f2b5",
                        "inverse-surface": "#32302c",
                        "on-secondary-fixed": "#002109",
                        "tertiary-fixed-dim": "#ecc156",
                        "primary-fixed": "#ffdbce",
                        "surface-container-high": "#ede7e0",
                        "on-primary-fixed-variant": "#7e2c00",
                        "on-error": "#ffffff",
                        "on-primary-fixed": "#360f00",
                        "background": "#fef8f1",
                        "tertiary": "#6f5500",
                        "on-tertiary-fixed": "#251a00",
                        "on-primary-container": "#fff5f2",
                        "tertiary-fixed": "#ffdf97",
                        "primary-fixed-dim": "#ffb598",
                        "surface-container-highest": "#e7e2db",
                        "on-tertiary-fixed-variant": "#5a4400",
                        "secondary-container": "#aeefb3",
                        "surface-container-lowest": "#ffffff",
                        "surface": "#fef8f1",
                        "surface-bright": "#fef8f1",
                        "on-tertiary-container": "#fff5e8",
                        "error-container": "#ffdad6",
                        "surface-container-low": "#f9f3ec",
                        "secondary": "#2e6a3a",
                        "surface-variant": "#e7e2db",
                        "on-secondary": "#ffffff",
                        "on-primary": "#ffffff",
                        "primary": "#9c3800",
                        "outline-variant": "#e0c0b3"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "headline": ["Plus Jakarta Sans"],
                        "display": ["Plus Jakarta Sans"],
                        "body": ["Be Vietnam Pro"],
                        "label": ["Be Vietnam Pro"]
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        body {
            font-family: 'Be Vietnam Pro', sans-serif;
        }

        h1,
        h2,
        h3 {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>