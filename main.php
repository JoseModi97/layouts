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
        .sidebar {
            position: fixed;
            top: 0; /* Aligns with top of viewport */
            bottom: 0;
            left: 0;
            z-index: 100; /* Behind the navbar */
            padding: 70px 0 0; /* Approximate height of the header + some buffer */
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }

        .sidebar-sticky {
            position: relative; /* Changed from sticky for this fixed sidebar context */
            top: 0;
            height: calc(100vh - 70px); /* Adjust based on actual header height */
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
        }

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

        <div class="container-fluid">
            <div class="row">
                <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                    <div class="position-sticky pt-3">
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

                <main id="main" role="main" class="col-md-9 ms-sm-auto col-lg-10 px-md-4 flex-fill" style="padding-top: 70px;"> <?php // Added padding-top to prevent content overlap with a potentially fixed header ?>
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
</body>

</html>
<?php $this->endPage() ?>