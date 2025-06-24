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

</head>


<body class="d-flex flex-column h-100 wrap">
    <?php $this->beginBody() ?>


    <div class="w-100">
        <header id="header">

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
        <main id="main" role="main">

            <div class="vh-100" style="width:100%; overflow-x: hidden; ">
                <div class="navbar">
                    <div class="navbar-content">
                        <div class="logo-section">
                            <a href="<?php echo Yii::getAlias('@web'); ?>"><img class="logo-image im-fluid" src="<?= Yii::getAlias('@web'); ?>/img/ndu-eng-logo.png" alt="NDU-Kenya Logo"></a>
                            <div class="flag-line"></div>
                            <div class="logo-text-container">
                                <div class="logo-text">NATIONAL DEFENCE UNIVERSITY-KENYA</div>
                                <div class="tagline">Wisdom. Excellence. Service</div>
                            </div>
                        </div>
                        <div class="flag-container">
                            <div class="flag" style="margin-right: 0 !important;">
                                <div class="red"></div>
                                <div class="light-blue"></div>
                                <div class="dark-blue"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?= $content ?>



            </div>



        </main>





    </div>

    <footer class="mt-auto py-3 bg-light">
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