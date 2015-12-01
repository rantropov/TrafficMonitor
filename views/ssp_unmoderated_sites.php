<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\bootstrap\Button;
use yii\jui\DatePicker;
use yii\helpers\Url;
use frontend\models\AuthAssignment;

?>

<!-- For SSP unmoderated sites: -->
<? if(!empty($ssp_unmoderated)) : ?>
<!-- Title of Page -->
 <?
  $this->title = Yii::t('app', "SSP Unmoderated sites(".count($sites_list)." of $ssp_name (ID: $ssp_id)");
  $this->params['breadcrumbs'][] = $this->title;
 ?>
 <div class="trading-desk-index">
     <h1><?= Html::encode($this->title) ?></h1>
 </div>
 <!-- Title of Page -->
 
 <!-- Date From - To -->
<?php echo Html::beginForm('index.php?r=traffic/ssp_unmoderated', 'GET'); ?>
<input type="hidden" name="ssp_id" value="<?=$ssp_id?>">
<div class="rfloated" style="width: 700px; padding-bottom: 10px; float: none;">
    <div class="datepicker-from" id="agency-datepicker" style="width: 200px;">
        <h5><?= Yii::t('app', 'From').':'; ?></h5>
        <?php
            echo DatePicker::widget([
                'language' => 'en',
                'name' => 'date_from',
                'value'=> $from,
                'options' => [
                    'class'=>'date-picker',
                ],
                'clientOptions' => [
                    'dateFormat' => 'yy-mm-dd',
                ],
            ]);
        ?>
    </div>
    <div class="datepicker-to" style="width: 180px;">
        <h5><?= Yii::t('app', 'To').':'; ?></h5>
        <?php
            echo DatePicker::widget([
                'language' => 'en',
                'name' => 'date_to',
                'value'=>  $to,
                'attribute' => 'date_to',
                'options' => [
                    'class'=>'date-picker',
                ],
                'clientOptions' => [
                    'class' => 'test',
                    'dateFormat' => 'yy-mm-dd',
                    'maxDate' => date("Y-m-d"),
                ],
            ]);
        ?>
    </div>
    <div class="td_id" style="float: left; width: 175px;">
        <?php echo Html::dropDownList('format_id', $format_id, $format_list, ['class'=>'form-control']); ?>
    </div>
    <?php 
        echo Button::widget([
            'label' => Yii::t('app', 'GO'),
            'options' => [
                'class' => 'btn-info datepicker-button',
                'style' => 'min-width: 90px',
            ],
         ]);
    ?>
</div>
<?php echo Html::endForm(); ?>
<!-- Date From - To -->
 
<?endif?>


<div class="td-index">

<table class="table table-striped table-bordered table-hover table-autosort">
<thead>
    <tr>
        <th class="first table-sortable:string" style="text-align: center;"><?= Yii::t('app', 'Site') ?></th>
        <th class="first table-sortable:numeric" style="text-align: center;"><?= Yii::t('app', 'Site_id') ?></th>
        <th class="first table-sortable:numeric" style="text-align: center;"><?= Yii::t('app', 'Calls') ?></th>
    </tr>
   
</thead>
<tbody>
<?php foreach ($sites_list as $site_id => $data) : ?>
    <?php 
        if ($site_id == 0) $style  = 'style="background-color: #CCCCCC; text-align: center;"'; 
        else  $style = 'style="text-align: center;"';
    ?>
    <tr class="clickableTR">
        <td>
          <? if ($data['site_url'] !== 'Unknown') : ?>
           <a href="<?=$data['site_url'];?>" target="_blanc"><?= $data['site_url']; ?></a>
          <?else :?>
           <?= $data['site_url']; ?>
          <?endif?>
        </td>
        <td><?= $site_id; ?></td>
        <td><?= number_format($data['moderation_site'], 0, ',', ' '); ?></td>
    </tr>
<?php endforeach; ?>
</tbody>
</table>
</div>