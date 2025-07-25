<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>


<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>


    <header id="header">
        <?php // Header is empty, no changes needed here unless a common header bar is desired later ?>
    </header>


    <main id="main" class="flex-fill" role="main" style="background-color: #172b4d !important;"> <?php // Corrected ID, added flex-fill, removed height:100vh ?>
        <div class="container py-3"> <?php // Added py-3 for some vertical padding ?>
            <?= $content ?>
        </div>

        <?php $this->beginContent('@app/views/layouts/footer/auth.footer.php'); ?>
        <?php // Removed the redundant <?= $content ?> from here ?>
        <?php $this->endContent() ?>

    </main>



    <?php $this->endBody() ?>
</body>



</html>
<?php $this->endPage() ?>