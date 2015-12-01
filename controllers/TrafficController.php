<?php

    namespace frontend\controllers;
    
    use \Yii;
    use frontend\models\Traffic;
    use frontend\models\Scanner;
    //use frontend\models\Format;
    //use frontend\models\Ssp;
    //use frontend\models\search\SspSearch;
    //use frontend\models\SspFactory;
    //use frontend\models\IpBlockMaxmindStructure;
    //use frontend\models\C8User;
    //use yii\filters\AccessControl;
    //use yii\filters\VerbFilter;
    //use frontend\models\RtbBandit;
    //use frontend\models\Agency;
    //use yii\helpers\ArrayHelper;
    //use yii\helpers\Html;
    //use frontend\models\TradingDesk;
    //use frontend\models\UserTradingDesk;
    //use yii\helpers\Url;
    
    class TrafficController extends \yii\web\Controller
    {
        public function actionGetinfo()
        {
            echo 'TrafficController V1.0 Developed By Kir Chernenko';
        }
        
        /*
         *
         * Методы статистики SSP
         *
         */
        public function actionSsp_traffic()
        {
            error_reporting(0);
            $format_id = Yii::$app->request->getQueryParam('format_id');
            $format_id = !empty($format_id) ? intval($format_id) : false;
            
            $traffic = new Traffic();
            $traffic->getDateFork();
            
            $traffic->search['type'] = 'ssp';
            $traffic->search['timeStart'] = $traffic->from;
            $traffic->search['timeEnd'] = $traffic->to;
            $traffic->search['format_id'] = $format_id;
            
            $total_stat = $traffic->getTotalSSPStat();
            $total_row = $total_stat['total'];
            unset($total_stat['total']);
            
            $format_list = $traffic->getFormatsList();
           
            return $this->render('ssp', [
            'total_stat' => $total_stat,
            'total_row' => $total_row,
            'format_list'=>$format_list,
            'format_id' => $format_id,
            'from' => $traffic->date['from'],
            'to' => $traffic->date['to']
            ]);
        }
        
        public function actionSsp_by_dsp()
        {
            error_reporting(0);
            $ssp_id = Yii::$app->request->getQueryParam('ssp_id');
            if(empty($ssp_id))
            {
                Yii::$app->getSession()->setFlash('warning', Yii::t('app','Unknown SSP'));
                return $this->redirect(['ssp_traffic']);
            }
            
            $format_id = Yii::$app->request->getQueryParam('format_id');
            $format_id = !empty($format_id) ? intval($format_id) : false;
            
            $traffic = new Traffic();
            $traffic->getDateFork();
            
            $traffic->search['type'] = 'ssp';            
            $traffic->search['ssp_id'] = intval($ssp_id);            
            $traffic->search['timeStart'] = $traffic->from;
            $traffic->search['timeEnd'] = $traffic->to;
            $traffic->search['format_id'] = $format_id;
            
            $ssp_by_dsp = $traffic->getSSPbyDSPstat();
            $total_row = $ssp_by_dsp['total'];
            unset($ssp_by_dsp['total']);
            
            $format_list = $traffic->getFormatsList();
            $ssp_name = Traffic::getSSPname($ssp_id);
           
            return $this->render('ssp_by_dsp', [
            'ssp_by_dsp' => $ssp_by_dsp,
            'total_row' => $total_row,
            'ssp_id' => $ssp_id,
            'ssp_name' => $ssp_name,
            'format_list'=>$format_list,
            'format_id' => $format_id,
            'from' => $traffic->date['from'],
            'to' => $traffic->date['to']
            ]);
        }
        
        public function actionSsp_sites_call()
        {
            error_reporting(0);
            $ssp_id = Yii::$app->request->getQueryParam('ssp_id');
            $ssp_id = intval($ssp_id);
            if(empty($ssp_id))
            {
                Yii::$app->getSession()->setFlash('warning', Yii::t('app','Unknown SSP'));
                return $this->redirect(['ssp_traffic']);
            }
            
            $format_id = Yii::$app->request->getQueryParam('format_id');
            $format_id = !empty($format_id) ? intval($format_id) : false;
            
            $traffic = new Traffic();
            $traffic->getDateFork();
            
            $traffic->search['type'] = 'ssp';            
            $traffic->search['via'] = 'sspBySite';            
            $traffic->search['ssp_id'] = $ssp_id;
            $traffic->search['format_id'] = $format_id;
            $traffic->search['timeStart'] = $traffic->from;
            $traffic->search['timeEnd'] = $traffic->to;
                        
            $total_stat = $traffic->getSSPbySitesStat();
            $total_row = $total_stat['total'];
            unset($total_stat['total']);
            
            $ssp_name = Traffic::getSSPname($ssp_id);
            $format_list = $traffic->getFormatsList();
            
            return $this->render('ssp_by_site', [
            'total_stat' => $total_stat,
            'total_row' => $total_row,
            'ssp_id' => $ssp_id,
            'ssp_name' => $ssp_name,
            'format_list'=>$format_list,
            'format_id' => $format_id,
            'from' => $traffic->date['from'],
            'to' => $traffic->date['to']
            ]);
        }
        
        public function actionSsp_unmoderated()
        {
            $ssp_id = Yii::$app->request->getQueryParam('ssp_id');
            $ssp_id = intval($ssp_id);
            if(empty($ssp_id))
            {
                Yii::$app->getSession()->setFlash('warning', Yii::t('app','Unknown SSP'));
                return $this->redirect(['ssp_traffic']);
            }
            
            $format_id = Yii::$app->request->getQueryParam('format_id');
            $format_id = !empty($format_id) ? intval($format_id) : false;
            
            $traffic = new Traffic();
            $traffic->getDateFork();
            
            $traffic->search['type'] = 'ssp';            
            $traffic->search['via'] = 'sspBySite';            
            $traffic->search['key'] = 'call';            
            $traffic->search['keyd'] = 'moderation_site';            
            $traffic->search['ssp_id'] = $ssp_id;
            $traffic->search['format_id'] = $format_id;
            $traffic->search['timeStart'] = $traffic->from;
            $traffic->search['timeEnd'] = $traffic->to;
            
            $sites_list = $traffic->getSSPUnmoderatedSites();
            $ssp_name = Traffic::getSSPname($ssp_id);
            $format_list = $traffic->getFormatsList();
            
            return $this->render('ssp_unmoderated_sites', [
            'ssp_name' => $ssp_name,
            'ssp_id' => $ssp_id,
            'format_list'=>$format_list,
            'format_id' => $format_id,
            'sites_list' => $sites_list,
            'from' => $traffic->date['from'],
            'to' => $traffic->date['to']
            ]);
        }
        
        
        
        /*
         *
         * Методы статистики DSP
         *
         */
        public function actionDsp_traffic()
        {
            error_reporting(1);
            $format_id = Yii::$app->request->getQueryParam('format_id');
            $format_id = !empty($format_id) ? intval($format_id) : false;
            
            $traffic = new Traffic();
            $traffic->getDateFork();
            
            $traffic->search['type'] = 'dsp';
            $traffic->search['format_id'] = $format_id;
            $traffic->search['timeStart'] = $traffic->from;
            $traffic->search['timeEnd'] = $traffic->to;
            
            $format_list = $traffic->getFormatsList();
            
            $total_stat = $traffic->getTotalDSPStat();
            
            $total_row = $total_stat['total'];
            unset($total_stat['total']);
            
            return $this->render('dsp', [
            'total_stat' => $total_stat,
            'total_row' => $total_row,
            'format_list'=>$format_list,
            'format_id' => $format_id,
            'from' => $traffic->date['from'],
            'to' => $traffic->date['to']
            ]);
        }
        
        public function actionDsp_shows_stat()
        {
            error_reporting(0);
            $ssp_id = Yii::$app->request->getQueryParam('ssp_id');
            $format_id = Yii::$app->request->getQueryParam('format_id');
            $format_id = !empty($format_id) ? intval($format_id) : false;
            $traffic = new Traffic();
            $traffic->getDateFork();
            
            $traffic->search['type'] = 'dsp';
            $traffic->search['format_id'] = $format_id;
            $traffic->search['ssp_id'] = !empty($ssp_id) ? intval($ssp_id) : false;
            $traffic->search['timeStart'] = $traffic->from;
            $traffic->search['timeEnd'] = $traffic->to;
            
            $format_list = $traffic->getFormatsList();
            
            $total_stat = $traffic->getTotalDSPStat();
            
            $total_row = $total_stat['total'];
            unset($total_stat['total']);
            
            return $this->render('dsp_shows', [
            'total_stat' => $total_stat,
            'total_row' => $total_row,
            'format_list'=>$format_list,
            'format_id' => $format_id,
            'ssp_id' => $ssp_id,
            'from' => $traffic->date['from'],
            'to' => $traffic->date['to']
            ]);
        }
        
        
        
        public function actionDsp_unmoderated()
        {
            $ssp_id = Yii::$app->request->getQueryParam('ssp_id');
            $format_id = Yii::$app->request->getQueryParam('format_id');
            $format_id = !empty($format_id) ? intval($format_id) : false;
            $ssp_id = intval($ssp_id);
            
            if(empty($ssp_id))
            {
                Yii::$app->getSession()->setFlash('warning', Yii::t('app','Unknown SSP'));
                return $this->redirect(['dsp_call_errors']);
            }
            
            $traffic = new Traffic();
            $traffic->getDateFork();
            $traffic->search['via'] = 'sspBySite';
            $traffic->search['type'] = 'dsp';
            $traffic->search['key'] = 'call';            
            $traffic->search['keyd'] = 'err_moderation_site';
            $traffic->search['format_id'] = $format_id;
            $traffic->search['ssp_id'] = $ssp_id;            
            $traffic->search['timeStart'] = $traffic->from;
            $traffic->search['timeEnd'] = $traffic->to;
            
            
            $format_list = $traffic->getFormatsList();
            
            $sites_list = $traffic->getDSPUnmoderatedSites();
            $ssp_name = Traffic::getSSPname($ssp_id);
            
            return $this->render('dsp_unmoderated_sites', [
            'ssp_name' => $ssp_name,
            'ssp_id' => $ssp_id,
            'sites_list' => $sites_list,
            'format_list'=>$format_list,
            'format_id' => $format_id,
            'from' => $traffic->date['from'],
            'to' => $traffic->date['to']
            ]);
        }
        
        public function actionDsp_auction_errors()
        {
            error_reporting(0);
            $ssp_id = Yii::$app->request->getQueryParam('ssp_id');
            $format_id = Yii::$app->request->getQueryParam('format_id');
            $ssp_id = !empty($ssp_id) ? intval($ssp_id) : '';
            
            //echo $ssp_id.$format_id; exit;
            $traffic = new Traffic();
            $traffic->getDateFork();
            $traffic->search['type'] = 'dsp';
            $traffic->search['key'] = 'call';            
            $traffic->search['ssp_id'] = $ssp_id;
            $traffic->search['format_id'] = !empty($format_id) ? intval($format_id) : false;
            $traffic->search['timeStart'] = $traffic->from;
            $traffic->search['timeEnd'] = $traffic->to;
            
            $dsp_auction_errors = $traffic->getDSPAuctionErrors();
            $total_row = $dsp_auction_errors['total'];
            unset($dsp_auction_errors['total']);
            
            $format_list = $traffic->getFormatsList();
            $ssp_name = Traffic::getSSPname($ssp_id);
            
            return $this->render('dsp_auction_errors', [
            'dsp_auction_errors' => $dsp_auction_errors,
            'ssp_name' => $ssp_name,
            'ssp_id' => $ssp_id,
            'total_row' => $total_row,
            'format_list'=>$format_list,
            'format_id' => $format_id,
            'from' => $traffic->date['from'],
            'to' => $traffic->date['to']
            ]);
        }
        
        public function actionDsp_call_errors()
        {
            error_reporting(0);
            $ssp_id = Yii::$app->request->getQueryParam('ssp_id');
            $ssp_id = !empty($ssp_id) ? intval($ssp_id) : '';
            
            $site_id = Yii::$app->request->getQueryParam('site_id');
            $site_id = !empty($site_id) ? strval($ssp_id) : false;
            
            $format_id = Yii::$app->request->getQueryParam('format_id');
            
            $traffic = new Traffic();
            $traffic->getDateFork();
            $traffic->search['type'] = 'dsp';
            //$traffic->search['key'] = 'call';            
            $traffic->search['ssp_id'] = $ssp_id;
            //$traffic->search['site_id'] = $site_id;
            //if(!empty($site_id))
            //    $traffic->search['via'] = 'dspBySite';
            $traffic->search['format_id'] = !empty($format_id) ? intval($format_id) : false;
            $traffic->search['timeStart'] = $traffic->from;
            $traffic->search['timeEnd'] = $traffic->to;
            
            
            $dsp_call_errors = $traffic->getDSPCallErrors();
            //var_dump($dsp_call_errors);
            $total_row = $dsp_call_errors['total'];
            unset($dsp_call_errors['total']);     
            
            $format_list = $traffic->getFormatsList();
            $ssp_name = Traffic::getSSPname($ssp_id);
            
            return $this->render('dsp_errors', [
            'dsp_call_errors' => $dsp_call_errors,
            'total_row' => $total_row,
            'ssp_name' => $ssp_name,
            'ssp_id' => $ssp_id,
            'format_list'=>$format_list,
            'format_id' => $format_id,
            'from' => $traffic->date['from'],
            'to' => $traffic->date['to']
            ]);
        }
        
        public function actionDsp_vast_errors()
        {
            error_reporting(0);
            $ssp_id = Yii::$app->request->getQueryParam('ssp_id');
            $show_banners = Yii::$app->request->getQueryParam('show_banners');
            $show_banners = (!empty($show_banners) && intval($show_banners) == 1) ? true : false;
            
            $traffic = new Traffic();
            $traffic->getDateFork();
            
            $traffic->search['type'] = 'dsp';
            $traffic->search['ssp_id'] = !empty($ssp_id) ? intval($ssp_id) : false;
            $traffic->search['timeStart'] = $traffic->from;
            $traffic->search['timeEnd'] = $traffic->to;
            
            $traffic->vast_error_code = Yii::$app->request->getQueryParam('error_code');
            
            $total_stat = $traffic->getDSPVastErrors();
            $banners = ($show_banners) ? $traffic->getVastErrorBanners() : array();
            $banners_total = !empty($banners['total']) ? $banners['total'] : false;
            unset($banners['total']);
            
            $total_row = $total_stat['total'];
            unset($total_stat['total']);
            
            return $this->render('dsp_vast_errors', [
            'total_stat' => $total_stat,
            'total_row' => $total_row,
            'vast_errors'=>$traffic->vast_errors,
            'vast_error_code'=>$traffic->vast_error_code,
            'ssp_id' => $ssp_id,
            'banners' => $banners,
            'banners_total' => $banners_total,
            'from' => $traffic->date['from'],
            'to' => $traffic->date['to']
            ]);
        }
        
        
        public function actionDsp_by_ssp_sites()
        {
            error_reporting(1);
            $ssp_id = Yii::$app->request->getQueryParam('ssp_id');
            $ssp_id = intval($ssp_id);
            if(empty($ssp_id))
            {
                Yii::$app->getSession()->setFlash('warning', Yii::t('app','Unknown SSP'));
                return $this->redirect(['dsp_call_errors']);
            }
            
            $format_id = Yii::$app->request->getQueryParam('format_id');
            $format_id = !empty($format_id) ? intval($format_id) : false;
            
            $traffic = new Traffic();
            $traffic->getDateFork();
            
            $traffic->search['type'] = 'dsp';
            $traffic->search['via'] = 'dspBySite';
            $traffic->search['ssp_id'] = $ssp_id;
            $traffic->search['format_id'] = $format_id;
            $traffic->search['timeStart'] = $traffic->from;
            $traffic->search['timeEnd'] = $traffic->to;
            
            $sites_list = $traffic->getDSPbySSPsitesStat();
            
            $format_list = $traffic->getFormatsList();
            $ssp_name = Traffic::getSSPname($ssp_id);
            
            $total_row = $sites_list['total'];
            unset($sites_list['total']);
            
            return $this->render('dsp_by_ssp_sites', [
            'sites_list' => $sites_list,
            'total_row' => $total_row,
            'ssp_name' => $ssp_name,
            'ssp_id' => $ssp_id,
            'format_list'=>$format_list,
            'format_id' => $format_id,
            'from' => $traffic->date['from'],
            'to' => $traffic->date['to']
            ]);
        }
        
        
    }
?>