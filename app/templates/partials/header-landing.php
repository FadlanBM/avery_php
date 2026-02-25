<header>
        <div class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav" aria-expanded="false" aria-controls="main-nav" aria-label="Toggle navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.html"><img class="img-responsive" src="<?php echo BASE_URL; ?>/assets/landing/img/logo.png" alt="logo"/></a>
                </div>
                <div id="main-nav" class="navbar-collapse collapse ">
                    <ul class="nav navbar-nav">
                        <?php
                        $menu = [
                            ['href' => 'index.html', 'label' => 'Home'],
                            ['href' => 'about.html', 'label' => 'About Us'],
                            ['href' => 'services.html', 'label' => 'Services'],
                            ['href' => 'gallery.html', 'label' => 'Gallery'],
                            ['href' => 'pricing.html', 'label' => 'Pricing'],
                            ['href' => 'contact.html', 'label' => 'Contact'],
                        ];
                        $uriPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
                        $uriBase = trim($uriPath, '/');
                        foreach ($menu as $item) {
                            $href = $item['href'];
                            $label = $item['label'];
                            $isActive = false;
                            if ($href === 'index.html') {
                                $isActive = ($uriPath === '/' || $uriBase === '' || basename($uriPath) === 'index.html');
                            } else {
                                $isActive = (basename($uriPath) === $href);
                            }
                            echo '<li' . ($isActive ? ' class="active"' : '') . '><a href="' . $href . '">' . $label . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
	</header>
