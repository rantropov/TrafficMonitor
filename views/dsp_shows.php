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
 $this->title = Yii::t('app', 'Actionlogger Statuses');
 $this->params['breadcrumbs'][] = $this->title;
?>
<div style="float:left;">
<div class="trading-desk-index">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
<!-- Title of Page -->

<!-- Date From - To -->
<?php echo Html::beginForm('index.php?r=traffic/dsp_shows_stat', 'GET'); ?>
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
</div>
<!-- Date From - To -->



<!-- Table -->
<div class="td-index">

<table class="table table-striped table-bordered table-hover table-autosort">
<thead>
    <tr>
        <th class="first table-sortable:numeric" rowspan="2" style="text-align: center;"><?= Yii::t('app', 'SSP') ?></th>
        <th colspan="4" style="text-align: center;"><?= Yii::t('app', 'Responses')?></th>
        
        <th colspan="9" style="text-align: center;"><?= Yii::t('app', 'Actionlogger errors')?></th>
        <th colspan="3" style="text-align: center;"><?= Yii::t('app', 'Fillrates')?></th>
        
        
        
        
        <?php if(Yii::$app->user->can('admin')) : ?><?php endif;?>
    </tr>
    <tr>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Total') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Bids') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Shows') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Clicks') ?></th>
        
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Unknown') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Request') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Response Data') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Show-Banner') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Show-AdGroup') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Show-Campaign') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Click-Banner') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Click-AdGroup') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Click-Campaign') ?></th>
        
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Bids/Auctions') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Shows/Bids') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Clicks/Show') ?></th>
        
    </tr>
</thead>
<tbody>
<?php foreach ($total_stat as $ssp_id => $stat) : ?>
    <?php 
        if ($ssp_id == 0) $style  = 'style="background-color: #CCCCCC; text-align: right;"'; 
        else  $style = 'style="text-align: right;"';
    ?>
    <tr class="clickableTR">
        <td><?= $stat['ssp_name'].' ('.$ssp_id.')' ?></td>
        
        <td <?=$style?> nowrap><?= number_format($stat['have_response'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['bid_request'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['hit_ok'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['click_ok'], 0, ',', ' '); ?></td>
        
        <td <?=$style?> nowrap><?= number_format($stat['a_err_unknow'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['a_err_req'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['a_err_req_response'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['hit_err_binding_b'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['hit_err_binding_ag'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['hit_err_binding_bg'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['click_err_binding_b'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['click_err_binding_ag'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['click_err_binding_bg'], 0, ',', ' '); ?></td>
        
        <td <?=$style?> nowrap><?= round($stat['bid_request']/$stat['inner_auction'] * 100, 0); ?>%</td>
        <td <?=$style?> nowrap><?= round($stat['hit_ok']/$stat['bid_request'] * 100, 0); ?>%</td>
        <td <?=$style?> nowrap><?= round($stat['click_ok']/$stat['hit_ok'] * 100, 2); ?>%</td>
        
        <?php if(Yii::$app->user->can('trading_desk')) : ?>
        
        <?php endif; ?>
    </tr>
<?php endforeach; ?>
</tbody>
<tfoot>
    <tr class="warning">
        <td><?= Yii::t('app', 'Total'); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['have_response'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['bid_request'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['hit_ok'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['click_ok'], 0, ',', ' '); ?></td>
        
        <td style="text-align: right;" nowrap><?= number_format($total_row['a_err_unknow'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['a_err_req'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['a_err_req_response'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['hit_err_binding_b'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['hit_err_binding_ag'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['hit_err_binding_bg'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['click_err_binding_b'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['click_err_binding_ag'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['click_err_binding_bg'], 0, ',', ' '); ?></td>
        
        <td style="text-align: right;" nowrap><?= round($total_row['bid_request']/$total_row['inner_auction'] * 100, 0); ?>%</td>
        <td style="text-align: right;" nowrap><?= round($total_row['hit_ok']/$total_row['bid_request'] * 100, 0); ?>%</td>
        <td style="text-align: right;" nowrap><?= round($total_row['click_ok']/$total_row['hit_ok'] * 100, 2); ?>%</td>
    </tr>
</tfoot>
</table>
</div>
<!-- Table -->