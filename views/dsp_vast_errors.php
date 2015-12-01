<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\bootstrap\Button;

use yii\jui\DatePicker;
use yii\helpers\Url;
use frontend\models\AuthAssignment;

?>


<!-- Title of Page -->
<?
 $this->title = Yii::t('app', 'VAST Errors');
 $this->params['breadcrumbs'][] = $this->title;
?>
<div style="float:left;">
<div class="trading-desk-index">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
<!-- Title of Page -->

<!-- Date From - To -->
<?php echo Html::beginForm('index.php?r=traffic/dsp_vast_errors', 'GET'); ?>
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
</div>
<!-- Date From - To -->

<!-- Table -->
<div class="td-index">

<table class="table table-striped table-bordered table-hover table-autosort">
<thead>
    <tr>
        <th class="first table-sortable:numeric" rowspan="2" style="text-align: center;"><?= Yii::t('app', 'SSP') ?></th>
        <th colspan="<?= count($vast_errors)?>" style="text-align: center;"><?= Yii::t('app', 'VAST Errors')?></th>
        
        <?php if(Yii::$app->user->can('admin')) : ?><?php endif;?>
    </tr>
    <tr>
        <?foreach($vast_errors as $error_code => $err_title):?>
            <th class="table-sortable:numeric" title="<?=$err_title?>"><?= Yii::t('app', $error_code) ?></th>
        <?endforeach?>
    </tr>
</thead>
<tbody>
<?php foreach ($total_stat as $ssp_net_id => $stat) : ?>
    <?php 
        if ($ssp_net_id == 0) $style  = 'style="background-color: #CCCCCC; text-align: right;"'; 
        else  $style = 'style="text-align: right;"';
    ?>
    <tr class="clickableTR">
        <td nowrap><?= $stat['ssp_name'].' ('.$ssp_net_id.')' ?></td>
        <?foreach($vast_errors as $error_code => $err_title):?>
            <?if(!empty($stat['vast_err_'.$error_code])):?>
             <td <?=$style?> title="<?=$err_title?>" nowrap>
                <a href="index.php?r=traffic/dsp_vast_errors&ssp_id=<?=$ssp_net_id?>&show_banners=1&error_code=<?=$error_code?>&date_from=<?=$from?>&date_to=<?=$to?>">
                  <?= number_format($stat['vast_err_'.$error_code], 0, ',', ' '); ?>
                </a>
             </td>    
            <?else:?>
                <td></td>
            <?endif?>
        <?endforeach?>
    </tr>
<?php endforeach; ?>
</tbody>
<tfoot>
    <?if(empty($ssp_id)):?>
    <tr class="warning">
        <td><?= Yii::t('app', 'Total'); ?></td>
        <?foreach($vast_errors as $error_code => $err_title):?>
           <?if(!empty($total_row['vast_err_'.$error_code])):?>
             <td style="text-align: right;" title="<?=$err_title?>" nowrap>
                 <a href="index.php?r=traffic/dsp_vast_errors&show_banners=1&error_code=<?=$error_code?>&date_from=<?=$from?>&date_to=<?=$to?>">
                     <?= number_format($total_row['vast_err_'.$error_code], 0, ',', ' '); ?>
                 </a>
             </td>
           <?else:?>
               <td></td>
           <?endif?>
        <?endforeach?>
    </tr>
    <?endif?>
</tfoot>
</table>
</br>
</br>
</br>
</br>
<?if(!empty($banners)):?>
 <h3><?=$vast_errors[$vast_error_code].' ('.$vast_error_code.')'?></h3>
 <table class="table table-striped table-bordered table-autosort">
  <thead>
    <tr>
        <th class="first table-sortable:numeric"  style="text-align: center;"><?= Yii::t('app', 'Banners ('.count($banners).')') ?></th>
        <?if(!empty($ssp_id)):?>
          <th class="first table-sortable:numeric"  style="text-align: center;"><?= Yii::t('app', 'Site ID + Error Count ('.$banners_total.')') ?></th>
        <?else:?>
          <th class="first table-sortable:numeric"  style="text-align: center;"><?= Yii::t('app', 'Errors ('.$banners_total.')') ?></th>
        <?endif?>
        
    </tr>
  </thead>
  <tbody>
    <?foreach ($banners as $banner_id => $data) : ?>
     <tr>
      <td>
       <a href="http://c8.net.ua/banners/edit/bid/<?=$banner_id?>/" target="_blank">
         <?=$banner_id?>
       </a>
      </td>
      <?if(!empty($ssp_id)):?>
        <td>
         
         <table class="table table-striped table-bordered table-hover table-autosort">
          <tr class="clickableTR">
           <th class="first table-sortable:string"><?= Yii::t('app', 'Site') ?></th> 
           <th class="table-sortable:numeric"><?= Yii::t('app', 'Error Count') ?></th> 
          </tr>
          <?foreach ($data as $site_id => $err) : ?>
           <tr>
            <td><?=$site_id?></td>
            <td><?=$err?></td>
           </tr>
          <?endforeach?>
         </table>
         
        </td>
      <?else:?>
        <td><?=$data?></td>
      <?endif?>
     </tr>
    <?endforeach?>
 </tbody>
 </table>
<?endif?>

</div>
<!-- Table -->