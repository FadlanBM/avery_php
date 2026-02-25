<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- User Profile-->
                <li>
                    <!-- User profile -->
                    <div class="user-profile text-center position-relative pt-4 mt-1">
                        <!-- User profile image -->
                        <div class="profile-img m-auto"> <img src="../assets/images/users/1.jpg" alt="user" class="w-100 rounded-circle" /> </div>
                        <!-- User profile text-->
                        <div class="profile-text py-1"> <a href="#" class="dropdown-toggle link u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><?php echo isset($user_name) ? $user_name : 'Markarn Doe'; ?> <span class="caret"></span></a>
                            <div class="dropdown-menu animated flipInY">
                                <a href="#" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
                                <a href="#" class="dropdown-item"><i class="ti-wallet"></i> My Balance</a>
                                <a href="#" class="dropdown-item"><i class="ti-email"></i> Inbox</a>
                                <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"><i class="ti-settings"></i> Account Setting</a>
                                <div class="dropdown-divider"></div> <a href="login.html" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                            </div>
                        </div>
                    </div>
                    <!-- End User profile text-->
                </li>
                <!-- User Profile-->
                
                <?php
                // Define menu structure if not provided
                if (!isset($sidebar_menu)) {
                    $sidebar_menu = [
                        [
                            'type' => 'header',
                            'label' => 'Platform'   
                        ],
                        ['label' => 'Dashboard', 'url' => '/dashboard', 'icon' => 'home'],
                        ['label' => 'Manage Akun', 'url' => '/dashboard/manage-user', 'icon' => 'edit-3'],
                        ['type' => 'divider'],
                        // [
                        //     'type' => 'header',
                        //     'label' => 'Extra'
                        // ],
                        ['label' => 'Setting', 'url' => 'authentication-login1.html', 'icon' => 'log-out'],
                        ['label' => 'Log Out', 'url' => 'authentication-login1.html', 'icon' => 'log-out'],
                    ];
                }

                $current_page = basename($_SERVER['PHP_SELF']);

                foreach ($sidebar_menu as $item) {
                    if (isset($item['type']) && $item['type'] === 'header') {
                        echo '<li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span class="hide-menu">' . $item['label'] . '</span></li>';
                    } elseif (isset($item['type']) && $item['type'] === 'divider') {
                        echo '<li class="nav-devider"></li>';
                    } else {
                        $hasSubmenu = isset($item['submenu']) && is_array($item['submenu']);
                        $itemClass = $hasSubmenu ? 'has-arrow' : '';
                        $url = isset($item['url']) ? $item['url'] : 'javascript:void(0)';
                        
                        // Check Active State
                        $isActive = false;
                        if ($hasSubmenu) {
                            foreach ($item['submenu'] as $sub) {
                                $subUrl = isset($sub['url']) ? $sub['url'] : '';
                                if (basename($subUrl) === $current_page) {
                                    $isActive = true;
                                    break;
                                }
                            }
                        } else {
                            if (basename($url) === $current_page) {
                                $isActive = true;
                            }
                        }

                        $activeLiClass = $isActive ? 'selected' : '';
                        $activeLinkClass = $isActive ? 'active' : '';
                        $expanded = $isActive ? 'true' : 'false';
                        // Assuming Bootstrap 4 'show' class for open collapse
                        $collapseClass = $isActive ? 'show' : '';

                        echo '<li class="sidebar-item ' . $activeLiClass . '">';
                        echo '<a class="sidebar-link ' . $itemClass . ' ' . $activeLinkClass . ' waves-effect waves-dark" href="' . $url . '" aria-expanded="' . $expanded . '">';
                        echo '<i data-feather="' . $item['icon'] . '" class="feather-icon"></i>';
                        echo '<span class="hide-menu">' . $item['label'];
                        if (isset($item['badge'])) {
                            echo ' <span class="badge badge-pill ' . $item['badge']['class'] . '">' . $item['badge']['text'] . '</span>';
                        }
                        echo '</span></a>';
                        
                        if ($hasSubmenu) {
                            echo '<ul aria-expanded="' . $expanded . '" class="collapse first-level ' . $collapseClass . '">';
                            foreach ($item['submenu'] as $sub) {
                                $subUrl = isset($sub['url']) ? $sub['url'] : 'javascript:void(0)';
                                $subIcon = isset($sub['icon']) ? '<i class="' . $sub['icon'] . '"></i>' : '';
                                $subActive = (basename($subUrl) === $current_page) ? 'active' : '';
                                echo '<li class="sidebar-item ' . $subActive . '"><a href="' . $subUrl . '" class="sidebar-link ' . $subActive . '">' . $subIcon . '<span class="hide-menu"> ' . $sub['label'] . ' </span></a></li>';
                            }
                            echo '</ul>';
                        }
                        echo '</li>';
                    }
                }
                ?>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- Sidebar scroll-->
    <!-- Bottom points-->
    <div class="sidebar-footer">
        <!-- item-->
        <a href="" class="link" data-toggle="tooltip" title="Settings"><i class="ti-settings"></i></a>
        <!-- item-->
        <a href="" class="link" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a>
        <!-- item-->
        <a href="" class="link" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a>
    </div>
    <!-- End Bottom points-->
</aside>
