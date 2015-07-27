<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DomainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Domains';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="domain-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Domain', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'domain',
            'notify_when_down',
            'notify_when_up',
            'account_id',
            // 'date_added',
            // 'date_updated',
            // 'added_ip',
            // 'updated_ip',
            // 'watch_mx',
            // 'watch_dns',
            // 'watch_ip',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
