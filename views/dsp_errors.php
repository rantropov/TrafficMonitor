<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\bootstrap\Button;
use yii\jui\DatePicker;
use yii\helpers\Url;
use frontend\models\AuthAssignment;

?>

<!-- Ошибки вызовов DSP -->

<!-- Title of Page -->
<?
 $this->title = Yii::t('app', "DSP Call Errors");
 $this->params['breadcrumbs'][] = $this->title;
?>
<div class="trading-desk-index">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
<!-- Title of Page -->

<!-- Date From - To -->
<?php echo Html::beginForm('index.php?r=traffic/dsp_call_errors', 'GET'); ?>
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

<!-- Table -->
<div class="td-index">

<table class="table table-striped table-bordered table-hover table-autosort">
<thead>
    <tr>
        <th class="first table-sortable:string" rowspan="2" style="text-align: center;"><?= Yii::t('app', 'SSP') ?></th>
        <th colspan="10" style="text-align: center;"><?= Yii::t('app', 'Call Errors') ?></th>
    </tr>
    <tr>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Read Request Error') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Check SSP Error') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Empty Site_ID') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Empty User_ID') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Empty IP') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'N/M Site') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', '1 price auction') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Geo') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Currency Error') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'System Error') ?></th>
    </tr>
</thead>
<tbody>
<?php foreach ($dsp_call_errors as $ssp_id => $stat) : ?>
    <?php 
        if ($ssp_id == 0) $style  = 'style="background-color: #CCCCCC; text-align: right;"'; 
        else  $style = 'style="text-align: right;"';
    ?>
    <tr class="clickableTR">
        <td><?= $stat['ssp_name'].' ('.$ssp_id.')' ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['err_read_request'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['err_check_ssp'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['err_empty_site_id'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['err_empty_user_id'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['err_empty_ip'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap>
         <a href="index.php?r=traffic/dsp_unmoderated&ssp_id=<?=$ssp_id?>&date_from=<?=$from?>&date_to=<?=$to?>&format_id=<?=$format_id?>">
          <?= number_format($stat['err_moderation_site'], 0, ',', ' '); ?>
         </a>
        </td>
        <td <?=$style?> nowrap><?= number_format($stat['err_auction_1_type'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['err_geo_outside'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['err_cur'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['err_sys'], 0, ',', ' '); ?></td>
    </tr>
<?php endforeach; ?>
</tbody>
<tfoot>
    <tr class="warning">
        <td><?= Yii::t('app', 'Total'); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['err_read_request'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['err_check_ssp'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['err_empty_site_id'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['err_empty_user_id'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['err_empty_ip'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['err_moderation_site'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['err_auction_1_type'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['err_geo_outside'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['err_cur'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['err_sys'], 0, ',', ' '); ?></td>
    </tr>
</tfoot>
</table>
</div>
<!-- Table -->

<!-- Ошибки вызовов DSP -->