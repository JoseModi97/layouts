<?php

/** @var yii\web\View $this */
/** @var string $content */

use yii\helpers\Url;
use app\widgets\Alert;
use kartik\icons\Icon;
use yii\bootstrap5\Nav;
use app\assets\AppAsset;
use yii\bootstrap5\Html;
use kartik\widgets\Growl;
use yii\bootstrap5\NavBar;
use app\helpers\GraduateHelper;
use yii\bootstrap5\Breadcrumbs;
use yii\web\ServerErrorHttpException;
use yii\bootstrap5\BootstrapIconAsset;

AppAsset::register($this);
BootstrapIconAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);



$title = "NDU-Kenya Online Application Portal";

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">


<head>
    <title><?= Html::encode($title) ?></title>
    <?php $this->head() ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
    // In your layout file
    $this->registerAssetBundle(\kartik\editable\EditableAsset::class);
    $this->registerAssetBundle(\kartik\popover\PopoverXAsset::class);
    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.2.0/css/all.min.css" integrity="sha512-6c4nX2tn5KbzeBJo9Ywpa0Gkt+mzCzJBrE1RB6fmpcsoN+b/w/euwIMuQKNyUoU/nToKN3a8SgNOtPrbW12fug==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Ensure body padding accommodates fixed header if it were fixed-top */
        body {
             /* padding-top: 56px; /* Adjust if header becomes fixed */
        }
        #sidebar {
            position: fixed;
            top: 0; /* Will be overridden by padding-top to sit below header */
            left: 0;
            bottom: 0; /* Extends to bottom of viewport */
            width: 280px; /* Consistent width for the sidebar */
            z-index: 1000;
            background-color: #f8f9fa; /* bg-light */
            box-shadow: 0 0 10px rgba(0,0,0,0.1); /* Softer shadow */
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
            padding-top: 65px; /* Approximate header height - ADJUST IF HEADER HEIGHT CHANGES */
            /* The Bootstrap column classes col-md-3 col-lg-2 are on #sidebar but won't dictate width due to fixed width: 280px here */
        }

        #sidebar.sidebar-open {
            transform: translateX(0);
        }

        .sidebar-sticky {
            height: 100%; /* Takes full height of the padded #sidebar */
            overflow-y: auto;
            padding: 1rem; /* Internal padding for nav items */
        }

        #main {
            transition: margin-left 0.3s ease-in-out;
            padding-top: 65px; /* Approximate header height + small buffer - ADJUST IF HEADER HEIGHT CHANGES */
            margin-left: 0; /* Default when sidebar is closed */
        }

        /* --- Responsive Adjustments for Main Content --- */

        /* Small screens (<768px): Sidebar overlays, main content does not shift margin */
        @media (max-width: 767.98px) {
            /* No change to #main margin-left needed, sidebar overlays */
        }

        /* Medium screens and up (>=768px): Sidebar pushes main content */
        @media (min-width: 768px) {
            body.main-content-shifted #main {
                margin-left: 280px; /* Push main content by the width of the sidebar */
            }
        }

        /* Original sidebar nav link styling */
        .sidebar .nav-link {
            font-weight: 500;
            color: #333;
        }

        .sidebar .nav-link .feather {
            margin-right: 4px;
            color: #727272;
        }

        .sidebar .nav-link.active {
            color: #007bff;
        }

        .sidebar .nav-link:hover .feather,
        .sidebar .nav-link.active .feather {
            color: inherit;
        }

        .sidebar-heading {
            font-size: .75rem;
            text-transform: uppercase;
        }
        .logout.btn-link {
            color: #333;
            text-decoration: none;
        }
        .logout.btn-link:hover {
            color: #007bff;
        }
    </style>
</head>


<body class="d-flex flex-column h-100 wrap">
    <?php $this->beginBody() ?>


    <div class="w-100"> <?php // This div might be redundant if body is already d-flex flex-column ?>
        <header id="header">
            <?php // It's common to put the main navigation/navbar in the header tag ?>
            <div class="navbar border-bottom"> <?php // Added border-bottom for visual separation ?>
                <div class="container-fluid d-flex flex-wrap justify-content-center justify-content-sm-between align-items-center py-2"> <?php // Centered by default, between on sm and up ?>

                    <button class="navbar-toggler" type="button" id="sidebarToggleBtn" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="logo-section d-flex flex-column flex-sm-row align-items-center text-center text-sm-start mb-2 mb-sm-0"> <?php // Flex column on XS, row on SM+, text center on XS ?>
                        <a href="<?php echo Yii::getAlias('@web'); ?>" class="mb-2 mb-sm-0"><img class="logo-image img-fluid" src="<?= Yii::getAlias('@web'); ?>/img/ndu-eng-logo.png" alt="NDU-Kenya Logo"></a> <?php // Corrected to img-fluid, removed max-height style, added margin bottom on XS ?>
                        <div class="flag-line mx-0 mx-sm-2 my-1 my-sm-0"></div> <?php // Adjusted margins for XS ?>
                        <div class="logo-text-container">
                            <div class="logo-text fw-bold">NATIONAL DEFENCE UNIVERSITY-KENYA</div> <?php // Added fw-bold for emphasis ?>
                            <div class="tagline small text-muted">Wisdom. Excellence. Service</div> <?php // Added small and text-muted for style ?>
                        </div>
                    </div>
                    <div class="flag-container"> <?php // This container might also need to be centered if it's the only item on a line on XS ?>
                        <div class="flag" style="margin-right: 0 !important;"> <?php // This custom flag styling might need responsive adjustments via CSS ?>
                            <div class="red"></div>
                            <div class="light-blue"></div>
                            <div class="dark-blue"></div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <?php
        if (Yii::$app->session->hasFlash('title')) {
            // echo Helper::growl(Yii::$app->session->hasFlash('title'), Yii::$app->session->getFlash('body'));
        }
        ?>

        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <?php
            echo Growl::widget([
                'type' => Growl::TYPE_SUCCESS,
                'title' => 'Well done!',
                'icon' => 'bi bi-check-lg',
                'iconOptions' => ['class' => 'img-circle pull-left'],
                'body' => Yii::$app->session->getFlash('success'),
                'showSeparator' => true,
                'delay' => 0,
                'pluginOptions' => [
                    'showProgressbar' => true,
                    'placement' => [
                        'from' => 'top',
                        'align' => 'right',
                    ]
                ]
            ]);
            ?>
        <?php elseif (Yii::$app->session->hasFlash('error')): ?>
            <?php
            echo Growl::widget([
                'type' => Growl::TYPE_DANGER,
                'title' => 'Oh snap!',
                'icon' => 'fas fa-times-circle',
                'body' => Yii::$app->session->getFlash('error'),
                'showSeparator' => true,
                'delay' => 4500,
                'pluginOptions' => [
                    'showProgressbar' => true,
                    'placement' => [
                        'from' => 'top',
                        'align' => 'right',
                    ]
                ]
            ]);
            ?>
        <?php endif; ?>

        <div class="container-fluid flex-grow-1"> <!-- Added flex-grow-1 -->
            <div class="row h-100"> <!-- Added h-100 for potential full height row -->
                <nav id="sidebar" class="col-md-3 col-lg-2 bg-light sidebar"> <!-- Removed d-md-block and collapse -->
                    <div class="sidebar-sticky pt-3"> <!-- Ensure sidebar-sticky class is used -->
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                                    <span>Section 1</span>
                                </h6>
                                <a class="nav-link" href="#">
                                    <span data-feather="home"></span>
                                    Link 1
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span data-feather="file"></span>
                                    Link 2
                                </a>
                            </li>
                            <li class="nav-item">
                                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                                    <span>Section 2</span>
                                </h6>
                                <a class="nav-link" href="#">
                                    <span data-feather="shopping-cart"></span>
                                    Link 3
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span data-feather="users"></span>
                                    Link 4
                                </a>
                            </li>
                        </ul>

                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>User</span>
                        </h6>
                        <ul class="nav flex-column mb-2">
                            <li class="nav-item">
                                <?php
                                if (!Yii::$app->user->isGuest) {
                                    echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
                                        . Html::submitButton(
                                            'Logout (' . Yii::$app->user->identity->username . ')',
                                            ['class' => 'nav-link btn btn-link logout']
                                        )
                                        . Html::endForm();
                                }
                                ?>
                            </li>
                        </ul>
                    </div>
                </nav>

                <main id="main" role="main" class="col-md-9 ms-sm-auto col-lg-10 px-md-4 flex-fill"> <?php // Added flex-fill to allow main to grow ?>
                    <div style="width:100%; overflow-x: hidden;"> <?php // Removed vh-100 ?>
                        <div class="container-fluid my-3"> <?php // Wrapped content in container-fluid with vertical margin ?>
                            <?= $content ?>
                        </div>
                    </div>
                </main>
            </div>
        </div>

    </div>

    <footer class="mt-auto py-3 bg-light border-top"> <?php // Added border-top for visual separation ?>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="copyright text-center text-muted">
                        Copyright &copy; Ndu Kenya <?= date('Y') ?>. All Rights Reserved.
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <?php $this->endBody() ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
            const sidebar = document.getElementById('sidebar');
            // Use a wrapper for main content adjustment, e.g., the body or a specific div
            // Let's assume we'll toggle a class on the body for now.
            const body = document.body;

            if (sidebarToggleBtn && sidebar) {
                sidebarToggleBtn.addEventListener('click', function () {
                    sidebar.classList.toggle('sidebar-open');
                    body.classList.toggle('main-content-shifted'); // Or sidebar-open-on-body etc.

                    // Optional: Store state in localStorage to remember if sidebar was open/closed
                    // if (sidebar.classList.contains('sidebar-open')) {
                    //    localStorage.setItem('sidebarState', 'open');
                    // } else {
                    //    localStorage.setItem('sidebarState', 'closed');
                    // }
                });

                // Optional: Check localStorage on page load to restore sidebar state
                // const savedSidebarState = localStorage.getItem('sidebarState');
                // if (savedSidebarState === 'open') {
                //    sidebar.classList.add('sidebar-open');
                //    body.classList.add('main-content-shifted');
                // } else {
                //    // Default to closed or whatever initial state is desired
                //    sidebar.classList.remove('sidebar-open');
                //    body.classList.remove('main-content-shifted');
                // }
            }
        });
    </script>
</body>

</html>
<?php $this->endPage() ?>