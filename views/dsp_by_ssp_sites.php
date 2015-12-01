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
 $this->title = Yii::t('app', 'Traffic from '.$ssp_name.' sites');
 $this->params['breadcrumbs'][] = $this->title;
?>
<div style="float:left;">
<div class="trading-desk-index">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
<!-- Title of Page -->

<!-- Date From - To -->
<?php echo Html::beginForm("index.php?r=traffic/dsp_by_ssp_sites", 'GET'); ?>
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

<!--Fillrate-->
<?if (empty($format_id)) :?>
<?
 $total_filrate = round($total_row['bid_request']/$total_row['inner_auction'] * 100, 0);
 if($total_filrate <= 20)
 {
    $b_color = 'red';
 }
 else if($total_filrate > 20 && $total_filrate <= 50)
 {
    $b_color = 'yellow';
 }
 else if($total_filrate > 50)
 {
   $b_color = 'green';
 }
?>
<div style = "width: 200px;
              height: 70px;
              border-radius: 5px;
              margin-top: 30px;
              margin-right: 15px;
              text-align: center;
              vertical-align: center;
              float: right;
              background-color:<?=$b_color?>; ">
  <p style="font-size: 50px;"><?=$total_filrate?>%</p>
</div>
<?endif?>
<!--Fillrate-->

<!-- Table -->
<div class="td-index">

<table class="table table-striped table-bordered table-hover table-autosort">
<thead>
    <tr>
        <th class="first table-sortable:string" rowspan="2" style="text-align: center;"><?= Yii::t('app', 'Site') ?></th>
        <th colspan="2" style="text-align: center;"><?= Yii::t('app', 'Site Calls') ?></th>
        <th colspan="5" style="text-align: center;"><?= Yii::t('app', 'Auctions')?></th>
        <th colspan="3" style="text-align: center;"><?= Yii::t('app', 'Responses')?></th>
        <th rowspan="2" style="text-align: center;"><?= Yii::t('app', 'VAST Errors')?></th>
        <th colspan="3" style="text-align: center;"><?= Yii::t('app', 'Fillrates')?></th>
        
        <?php if(Yii::$app->user->can('admin')) : ?><?php endif;?>
    </tr>
    <tr>
      <?if (empty($format_id)) :?>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Total') ?></th>
      <?else:?>
        <th></th>
      <?endif?>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Ignored') ?></th>
        
        <th class="table-sortable:numeric" ><?= Yii::t('app', 'Total') ?></th>
        <th class="table-sortable:numeric" ><?= Yii::t('app', 'Inner Ok') ?></th>
        <th class="table-sortable:numeric" ><?= Yii::t('app', 'Errors') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Wins') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'CPM Errors') ?></th>
        
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Total') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Bids') ?></th>
        <th class="table-sortable:numeric"><?= Yii::t('app', 'Shows') ?></th>
        
        <th class="first table-sortable:numeric" style="text-align: center;">
          <?= Yii::t('app', 'Bids/Auctions')?>
        </th>
        <th class="first table-sortable:numeric" style="text-align: center;">
          <?= Yii::t('app', 'Shows/Bids')?>
        </th>
        <th class="first table-sortable:numeric" style="text-align: center;">
          <?= Yii::t('app', 'Clicks/Shows')?>
        </th>
        
        
        
    </tr>
</thead>
<tbody>
<?php foreach ($sites_list as $site_id => $stat) : ?>
    <?php 
        if (empty($site_id)) $style  = 'style="background-color: #CCCCCC; text-align: right;"'; 
        else  $style = 'style="text-align: right;"';
    ?>
    <tr class="clickableTR">
        <td nowrap><?= $stat['site_name'].' ('.$site_id.')' ?></td>
        <?if (empty($format_id) && empty($site_id)) :?>
          <td <?=$style?> nowrap><?= number_format($stat['ssp'], 0, ',', ' '); ?></td>
        <?else:?>
          <td></td>
        <?endif?>
        <td <?=$style?> nowrap>
            <a href="index.php?r=traffic/dsp_call_errors&ssp_id=<?=$ssp_id?>&site_id=<?=$site_id?>&date_from=<?=$from?>&date_to=<?=$to?>&format_id=<?=$format_id?>"
               title="<?= Yii::t('app', $stat['site_name'].' Call Errors') ?>">
                <?= number_format($stat['call_error'], 0, ',', ' '); ?></td>
            </a>
        <td <?=$style?> nowrap><?= number_format($stat['inner_auction'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['inner_auction_ok'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap>
            <a href="index.php?r=traffic/dsp_auction_errors&ssp_id=<?=$ssp_id?>&site_id=<?=$site_id?>&date_from=<?=$from?>&date_to=<?=$to?>&format_id=<?=$format_id?>"
            title="<?= Yii::t('app', 'Auction errors') ?>">
                <?= number_format($stat['auction_error'], 0, ',', ' '); ?>
            </a>
        </td>
        <td <?=$style?> nowrap><?= number_format($stat['inner_auction_win'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['auction_err_banner_cpm'], 0, ',', ' '); ?></td>
        
        <td <?=$style?> nowrap><?= number_format($stat['have_response'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap><?= number_format($stat['bid_request'], 0, ',', ' '); ?></td>
        <td <?=$style?> nowrap>
         <a href="index.php?r=traffic/dsp_shows_stat&ssp_id=<?=$ssp_id?>&site_id=<?=$site_id?>&date_from=<?=$from?>&date_to=<?=$to?>&format_id=<?=$format_id?>"
         title="<?= Yii::t('app', 'Actionlogger Stat') ?>">
          <?= number_format($stat['hit_ok'], 0, ',', ' '); ?>
         </a>
        </td>
        <td <?=$style?> nowrap>
         <a href="index.php?r=traffic/dsp_vast_errors&ssp_id=<?=$ssp_id?>&site_id=<?=$site_id?>&date_from=<?=$from?>&date_to=<?=$to?>&format_id=<?=$format_id?>"
             title="<?= Yii::t('app', 'VAST Errors') ?>">
          <?= number_format($stat['vast_error'], 0, ',', ' '); ?>
         </a>
        </td>
        
        <td <?=$style?> nowrap><?= round($stat['bid_request']/$stat['inner_auction'] * 100, 0); ?>%</td>
        <td <?=$style?> nowrap><?= round($stat['hit_ok']/$stat['bid_request'] * 100, 0); ?>%</td>
        <td <?=$style?> nowrap><?= round($stat['click_ok']/$stat['hit_ok'] * 100, 0); ?>%</td>
        
        <?php if(Yii::$app->user->can('trading_desk')) : ?>
        
        <?php endif; ?>
    </tr>
<?php endforeach; ?>
</tbody>
<tfoot>
    <tr class="warning">
        <td><?= Yii::t('app', 'Total'); ?></td>
        <?if (empty($format_id) && empty($ssp_id)) :?>
          <td style="text-align: right;" nowrap><?= number_format($total_row['ssp'], 0, ',', ' '); ?></td>
        <?else:?>
          <td></td>
        <?endif?>
        <td style="text-align: right;" nowrap>
            <a href="index.php?r=traffic/dsp_call_errors&ssp_id=<?=$ssp_id?>">
                <?= number_format($total_row['call_error'], 0, ',', ' '); ?>
            </a>        
        </td>
        
        <td style="text-align: right;" nowrap><?= number_format($total_row['inner_auction'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['inner_auction_ok'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap>
            <a href="index.php?r=traffic/dsp_auction_errors&ssp_id=<?=$ssp_id?>&date_from=<?=$from?>&date_to=<?=$to?>&format_id=<?=$format_id?>">
                <?= number_format($total_row['auction_error'], 0, ',', ' '); ?>
            </a>
        </td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['inner_auction_win'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['err_banner_cpm'], 0, ',', ' '); ?></td>
        
        <td style="text-align: right;" nowrap><?= number_format($total_row['have_response'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap><?= number_format($total_row['bid_request'], 0, ',', ' '); ?></td>
        <td style="text-align: right;" nowrap>
         <a href="index.php?r=traffic/dsp_shows_stat&ssp_id=<?=$ssp_id?>&date_from=<?=$from?>&date_to=<?=$to?>&format_id=<?=$format_id?>">
          <?= number_format($total_row['hit_ok'], 0, ',', ' '); ?>
         </a>
        </td>
        <td style="text-align: right;" nowrap>
         <a href="index.php?r=traffic/dsp_vast_errors&ssp_id=<?=$ssp_id?>&date_from=<?=$from?>&date_to=<?=$to?>&format_id=<?=$format_id?>">
          <?= number_format($total_row['vast_error'], 0, ',', ' '); ?>
         </a>
        </td>
        
        <td style="text-align: right;" nowrap><?= round($total_row['bid_request']/$total_row['inner_auction'] * 100, 0); ?>%</td>
        <td style="text-align: right;" nowrap><?= round($total_row['hit_ok']/$total_row['bid_request'] * 100, 0); ?>%</td>
        <td style="text-align: right;" nowrap><?= round($total_row['click_ok']/$total_row['hit_ok'] * 100, 0); ?>%</td>
    </tr>
</tfoot>
</table>
</div>
<!-- Table -->