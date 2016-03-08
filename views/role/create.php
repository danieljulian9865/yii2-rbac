<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dsanchez98>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var $model dsanchez98\rbac\models\Role
 * @var $this  yii\web\View
 */

$this->title = Yii::t('rbac', 'Create new role');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $this->beginContent('@dsanchez98/rbac/views/layout.php') ?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

<?php $this->endContent() ?>