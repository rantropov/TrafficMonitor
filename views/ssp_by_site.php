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
 $this->title = Yii::t('app', $ssp_name.' ('.$ssp_id.') by Sites Traffic');
 $this->params['breadcrumbs'][] = $this->title;
?>
<div class="trading-desk-index">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
<!-- Title of Page -->

<!-- Date From - To -->
<?php echo Html::beginForm('index.php?r=traffic/ssp_sites_call', 'GET'); ?>
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
        <th class="first table-sortable:numeric" colspan="2" style="text-align: center;">
          <?= Yii::t('app', 'Site') ?>
        </th>
        <th colspan="6" style="text-align: center;"><?= Yii::t('app', 'Calls') ?></th>
        <th rowspan="2" style="text-align: center;"><?= Yii::t('app', 'Gags')?></th>
        <th colspan="5" style="text-align: center;"><?= Yii::t('app', 'RTB')?></th>
        
        
        <?php if(Yii::$app->user->can('admin')) : ?><?php endif;?>
    </tr>
    <tr>
        <th class="table-sortable:string"><?= Yii::t('app', 'URL') ?></th>
        <th class="table-sortable:string"><?= Yii::t('app', 'Site ID') ?></th>
        
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Total') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Errors') ?></th>
        <th class="table-sortable:numeric" title="<?= Yii::t('app', 'Not detected site') ?>"><?= Yii::t('app', 'N/D site') ?></th>
        <th class="table-sortable:numeric" title="<?= Yii::t('app', 'Not moderated site') ?>"><?= Yii::t('app', 'N/M site') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'No sales') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Google only') ?></th>
        
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Auctions') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', '%') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'DSP-Wins') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'DSP-Shows') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Fillrate') ?></th>
        
    </tr>
</thead>
<tbody>
<?php foreach ($total_stat as $site_id => $stat) : ?>
    <?php 
         $style = 'style="text-align: right;"';
    ?>
    <tr class="clickableTR">
        <td>
           <? if ($stat['site_url'] !== 'Unknown') : ?>
                <a href="<?=$stat['site_url'];?>" target="_blanc"><?= $stat['site_url']; ?></a>
           <?else :?>
                <?= $stat['site_url']; ?>
           <?endif?>
        </td>
        <td>
            <?=$site_id;?>
        </td>
        <td <?=$style?> nowrap><?= number_format($stat['all'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['err'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['cannot_detect_site_id'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap>
            <!--<a href="index.php?r=traffic/ssp_unmoderated&ssp_id=">-->
                <?= number_format($stat['moderation_site'], 0, ',', ' '); ?>
            <!--</a>-->
        </td>
        <td <?=$style?> nowrap><?= number_format($stat['sale_disable_site'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['only_google'], 0, ',', ' '); ?></td>
        
        <td <?=$style?> nowrap><?= number_format($stat['gag'], 0, ',', ' '); ?></td>
        
        <td <?=$style?> nowrap><?= number_format($stat['total_auctions'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap>
            <?= number_format(($stat['total_auctions']/$stat['all'] * 100), 0, ',', ' '); ?>%
        </td>
        <td <?=$style?> nowrap><?= number_format($stat['total_wins'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['total_shows'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap>
            <?= number_format(($stat['total_shows']/$stat['all'] * 100), 0, ',', ' '); ?>%
        </td>
        

        <?php if(Yii::$app->user->can('trading_desk')) : ?>
        
        <?php endif; ?>
    </tr>
<?php endforeach; ?>
</tbody>
<tfoot>
    <tr class="warning">
        <td></td>
        <td><?= Yii::t('app', 'Total'); ?></td>
        
        <td style="text-align: right;" nowrap><?= number_format($total_row['all'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['err'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['cannot_detect_site_id'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['moderation_site'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['sale_disable_site'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['only_google'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['gag'], 0, ',', ' '); ?></td>
        
        <td style="text-align: right;" nowrap><?= number_format($total_row['total_auctions'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format(($total_row['total_auctions'] / $total_row['all'] * 100), 0, ',', ' ');?>%</td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['total_wins'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['total_shows'], 0, ',', ' '); ?></td>        
        <td style="text-align: right;" nowrap><?= number_format(($total_row['total_shows'] / $total_row['all'] * 100), 0, ',', ' ');?>%</td>
    </tr>
</tfoot>
</table>
</div>
<!-- Table -->