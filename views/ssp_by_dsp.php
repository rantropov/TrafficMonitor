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
 $this->title = Yii::t('app', 'DSP responses to '.$ssp_name.' ('.$ssp_id.')');
 $this->params['breadcrumbs'][] = $this->title;
?>
<div class="trading-desk-index">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
<!-- Title of Page -->

<!-- Date From - To -->
<?php echo Html::beginForm('index.php?r=traffic/ssp_by_dsp', 'GET'); ?>
<div class="rfloated" style="width: 700px; padding-bottom: 10px; float: none;">
    <input type="hidden" name="ssp_id" value="<?=$ssp_id?>">
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
        <th class="first table-sortable:numeric" rowspan="2" style="text-align: center;"><?= Yii::t('app', 'DSP') ?></th>
        <th colspan="5" style="text-align: center;"><?= Yii::t('app', 'DSP Deny') ?></th>
        <th rowspan="2" style="text-align: center;"><?= Yii::t('app', 'Requests')?></th>
        <th rowspan="2" style="text-align: center;"><?= Yii::t('app', 'Bids')?></th>
        <th colspan="12" style="text-align: center;"><?= Yii::t('app', 'Response')?></th>
        
        
        
        <?php if(Yii::$app->user->can('admin')) : ?><?php endif;?>
    </tr>
    
    <tr>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Matching') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Currency Conv.') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Format') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Site') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Country') ?></th>
        
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Answers') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Empty') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Timeout') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Unknown Error') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Broken') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'No Bid') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Get resp. Error') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Check Error') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Currency Error') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Bid < Bidfloor') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Ok') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Win') ?></th>
    </tr>
</thead>
<tbody>
<?php foreach ($ssp_by_dsp as $dsp_id => $stat) : ?>
    <?php 
        if ($dsp_id == 0) $style  = 'style="background-color: #CCCCCC; text-align: right;"'; 
        else  $style = 'style="text-align: right;"';
    ?>
    <tr class="clickableTR">
        <td><?= $stat['dsp_name'].' ('.$dsp_id.')' ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['err_buyeruid'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['err_rate'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['format'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['site'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['country'], 0, ',', ' '); ?></td>
        
        <td <?=$style?> nowrap><?= number_format($stat['make_request'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['dsp_bid'], 0, ',', ' '); ?></td>
        
        <td <?=$style?> nowrap><?= number_format($stat['response_have'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['response_empty'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['response_timeout'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['response_unknow_err'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['response_json_err'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['response_nobid'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['response_unknow_err_status'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['response_check_err'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['response_cur_err'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['response_price_err'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['response_ok'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['response_win'], 0, ',', ' '); ?></td>
        
        
    </tr>
<?php endforeach; ?>
</tbody>

<tfoot>
    <tr class="warning">
        <td><?= Yii::t('app', 'Total'); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['err_buyeruid'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['err_rate'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['format'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['site'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['country'], 0, ',', ' '); ?></td>
        
        <td style="text-align: right;" nowrap><?= number_format($total_row['make_request'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['dsp_bid'], 0, ',', ' '); ?></td>
        
        <td style="text-align: right;" nowrap><?= number_format($total_row['response_have'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['response_empty'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['response_timeout'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['response_unknow_err'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['response_json_err'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['response_nobid'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['response_unknow_err_status'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['response_check_err'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['response_cur_err'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['response_price_err'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['response_ok'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['response_win'], 0, ',', ' '); ?></td>
        
        
    </tr>
</tfoot>
</table>
</div>
<!-- Table -->