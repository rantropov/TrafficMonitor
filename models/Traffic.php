<?php

    namespace frontend\models;
    use Yii;
    use frontend\models\Ssp;
    use frontend\models\Scanner;
    
    class Traffic extends \yii\db\ActiveRecord
    {
        
        
        
        //  Параметры поиска статистики
        public $search = array('via'=>false,
                                'type'=>false,
                                'ssp_id'=>false,
                                'site_id'=>false,
                                'format_id'=>false,
                                'key'=>false,
                                'keyd'=>false,
                                'period'=>false,
                                'timeStart'=>false,
                                'timeEnd'=>false,
                                );
        
        // Абстрактные переменные (модифицируются в контроллере)
        
        public $date = array('from' => 0,
                             'to' => 0);
        public $from;
        public $to;
        public $vast_error_code;
        // Структура ключей в Redis
/*        public static $sspStatuses = array (
        //without additional params
        'call:all' => 'Вызов площадки',                                         
        'call:err' => 'Ошибка при вызове',
        'call:moderation_site' => 'Сайт не модерирован',
        'call:sale_disable_site' => 'Сайт запретил продажу',
        'call:only_google' => 'Только Google заглушки',
        'call:cannot_detect_site_id' => 'Ошибка определения сайта',
        'call:error_handler_' => 'Обработчик ошибок',
        //'dsp:total_auctions' => 'Суммарное количество аукционов',
        'dsp:total_wins' => 'Суммарное количество побед',
        'dsp:total_shows' => 'Суммарное количество показов',
        
        //additional param <key>:@gag_type
        'show:gag' => 'Показ кода (RTB)',
        
        //additional param <key>:@dsp_id
        'dsp_deny:config' => 'Запрещен конфигурацией', 
        'dsp_deny:err_buyeruid' => 'Ошибка матчинга',
        'dsp_deny:err_rate' => 'Ошибка конвертации валюты',
        'dsp_deny:format' => 'Запрещенный DSP формат',
        'dsp_deny:site' => 'Запрет DSP сайта',
        'dsp_deny:country' => 'Запрет DSP ГЕО',
        'dsp:make_request' => 'Создан RTB Request',
        
        'dsp:response_have' => 'Есть ответ',
        'dsp:response_empty' => 'Пустой ответ',
        'dsp:response_timeout' => 'Таймаут ожидания ответа',   
        'dsp:response_unknow_err' => 'Неизвестная ошибка ответа',
        'dsp:response_json_err' => 'Испорченый ответ',
        'dsp:response_nobid' => 'Нет ставки',
        'dsp:response_unknow_err_status' => 'Неизвестная ошибка во время получения ответа',
        'dsp:response_check_err' => 'Ответ отклонен',
        'dsp:response_cur_err' => 'Ставка не в валюте аукциона',
        'dsp:response_price_err' => 'Ставка ниже bidfloor',
        'dsp:response_ok' => 'Ответ принят',
        'dsp:response_win' => 'Победа в аукционе',
        'show:dsp_bid' => 'Показ кода (RTB)'
        );

        // 
        public static $dspStatuses = array (
        
        //additional param <key>:@ssp_id
        'call:ssp' => 'Аукцион',
        'call:err_empty_post' => 'Ошибка Пустой POST',
        'call:err_empty_site_id' => 'Ошибка Пустой site_id',
        'call:err_empty_ip' => 'Ошибка Пустой IP',
        'call:err_moderation_site' => 'Ошибка Сайт не модерирован',
        'call:err_auction_1_type' => 'Ошибка Аукцион 1 типа',
        'call:err_geo_outside' => 'Ошибка География запрещена',
        'call:err_cur' => 'Ошибка Валюты',
        'call:err_check_ssp' => 'Ошибка check_SSP',
        'call:err_sys' => 'Системная ошибка',
        'call:err_read_request' => 'Ошибка чтения запроса',
        'call:inner_auction' => 'Внутренний аукцион',
        'call:inner_auction_ok' => 'Внутренний аукцион проведен успешно',
        'call:inner_auction_win' => 'Победа на внутреннем аукционе',
        'call:auction_err_banner_cpm' => 'Ошибка Banner CPM',
        'call:auction_err_empty_banner' => 'Нечего показать',
        'call:auction_err_bidfloor' => 'Ошибка Бидфлора',
        'call:have_response' => 'Есть DSP ответ',
        'call:bid_request' => 'Ставка'
        );
        
        public static $dspStatuses = array (
        //additional param <key>:@ssp_id
        'call:ssp' => 'Аукцион',
        'call:err_empty_post' => 'Ошибка Пустой POST',
        'call:err_empty_site_id' => 'Ошибка Пустой site_id',
        'call:err_empty_ip' => 'Ошибка Пустой IP',
        'call:err_moderation_site' => 'Ошибка Сайт не модерирован',
        'call:err_auction_1_type' => 'Ошибка Аукцион 1 типа',
        'call:err_geo_outside' => 'Ошибка География запрещена',
        'call:err_cur' => 'Ошибка Валюты',
        'call:err_check_ssp' => 'Ошибка check_SSP',
        'call:err_sys' => 'Системная ошибка',
        'call:err_read_request' => 'Ошибка чтения запроса',
        'call:inner_auction' => 'Внутренний аукцион',
        'call:inner_auction_ok' => 'Внутренний аукцион проведен успешно',
        'call:inner_auction_win' => 'Победа на внутреннем аукционе',
        'call:auction_err_banner_cpm' => 'Ошибка Banner CPM',
        'call:auction_err_empty_banner' => 'Нечего показать',
        'call:auction_err_bidfloor' => 'Ошибка Бидфлора',
        'call:have_response' => 'Есть DSP ответ',
        'call:bid_request' => 'Ставка',
        
        // * Аудит показов/кликов
        // * New from 15.10.15
        
        'hit_ok' => 'Показ',
        'click_ok' => 'Клик',
        'a_err_unknow' => 'Неизвестная ошибка',
        'a_err_req' => 'Ошибка чтение запроса',
        'a_err_req_response' => 'Ошибка чтение response_data',
        'hit_err_binding_b' => 'Ошибка мульти-запроса (показ-баннер)',
        'hit_err_binding_bg' => 'Ошибка мульти-запроса (показ-кампания)',
        'hit_err_binding_ag' => 'Ошибка мульти-запроса (показ-профиль)',
        'click_err_binding_b' => 'Ошибка мульти-запроса (клик-баннер)',
        'click_err_binding_bg' => 'Ошибка мульти-запроса (клик-кампания)',
        'click_err_binding_ag' => 'Ошибка мульти-запроса (клик-профиль)',
        'vast:err_<errCode>' => 'Ошибка VAST',
    );

*/

        // Массивы ключей для групп запросов
        public $totalSSPStatKeys = array('call:all',
                                      'call:err',
                                      'call:moderation_site',
                                      'call:sale_disable_site',
                                      'call:only_google',
                                      'call:cannot_detect_site_id',
                                      'show:gag',
                                      'dsp:total_auctions',
                                      'dsp:total_wins',
                                      'dsp:total_shows'
                                      );
        
        public $totalDSPStatKeys = array('call:ssp',
                                        'call:err_*',
                                        'call:inner_auction',
                                        'call:auction_err_*',
                                        'call:inner_auction_ok',
                                        'call:inner_auction_win',
                                        'call:err_banner_cpm',
                                        'call:have_response',
                                        'call:bid_request',
                                      );
        
       
        
        public $DSP_call_errors = array('call:err_empty_post',
                                        'call:err_empty_site_id',
                                        'call:err_empty_ip',
                                        'call:err_moderation_site',
                                        'call:err_auction_1_type',
                                        'call:err_geo_outside',
                                        'call:err_cur',
                                        'call:err_check_ssp',
                                        'call:err_sys',
                                        'call:err_read_request'
                                    );
        
        public $DSP_auction_errors = array('call:auction_err_banner_cpm',
                                        'call:auction_err_empty_banner',
                                        'call:auction_err_bidfloor'
                                    );
        
        public $ssp_by_dsp_keys = array('dsp_deny:config', 
                                        'dsp_deny:err_buyeruid',
                                        'dsp_deny:err_rate',
                                        'dsp_deny:format',
                                        'dsp_deny:site',
                                        'dsp_deny:country',
                                        
                                        'dsp:make_request',
                                        
                                        'dsp:response_have',
                                        'dsp:response_empty',
                                        'dsp:response_timeout',   
                                        'dsp:response_unknow_err',
                                        'dsp:response_json_err',
                                        'dsp:response_nobid',
                                        'dsp:response_unknow_err_status',
                                        'dsp:response_check_err',
                                        'dsp:response_cur_err',
                                        'dsp:response_price_err',
                                        'dsp:response_ok',
                                        'dsp:response_win',
                                        
                                        'show:dsp_bid'
                                   
                                   );
        
        public $vast_errors = array(2001 => 'Start before Impression',
                                    2002 => 'FirstQuartile before Impression',
                                    0 => 'Неизвестная ошибка',
                                    100 => 'Ошибка синтаксического анализа XML.',
                                    101	=> 'Ошибка при проверке схемы VAST.',
                                    102	=> 'Версия VAST ответа не поддерживается.',
                                    200	=> 'Ошибка трафика. Тип полученного проигрывателем объявления не соответствует ожидаемому и/или проигрыватель не может показать его.',
                                    201	=> 'Линейность не совпадает с указанной в проигрывателе.',
                                    202	=> 'Продолжительность объявления отличается от указанной в проигрывателе.',
                                    203	=> 'Проигрывателю требуется объявление другого размера.',
                                    300	=> 'Общая ошибка Wrapper.',
                                    301	=> 'Тайм-аут URI VAST, указанного в текущем или одном из последующих элементов Wrapper. Так обозначаются ошибки запросов, например недействительный или недоступный URI, тайм-аут запроса URI, а также ошибки, связанные с безопасностью или запросами URI VAST.',
                                    302	=> 'Достигнут предел, указанный в проигрывателе. Получено слишком много ответов с элементами Wrapper, не содержащих ответ InLine.',
                                    303	=> 'Ответ VAST не содержит объявлений и получен после одного или нескольких объявлений VAST Wrapper. Кроме того, так обозначаются пустые ответы VAST от резервного объявления.',
                                    400	=> 'Общая ошибка линейного объявления. Проигрыватель не может его показать.',
                                    401	=> 'Файл не найден. Не удалось обнаружить параметр Linear/MediaFile в URI.',
                                    402	=> 'Тайм-аут URI элемента MediaFile.',
                                    403	=> 'Не удалось найти элемент MediaFile с указанными атрибутами, поддерживаемый этим проигрывателем.',
                                    405	=> 'Проблема с показом элемента MediaFile.',
                                    500	=> 'Общая ошибка элемента NonLinearAds.',
                                    501	=> 'Не удается показать нелинейное объявление, потому что оно не помещается в область показа (объявление слишком велико).',
                                    502	=> 'Не удалось получить ресурс NonLinearAds или NonLinear.',
                                    503	=> 'Не удалось найти нелинейный ресурс поддерживаемого типа.',
                                    600	=> 'Общая ошибка элемента CompanionAds.',
                                    601	=> 'Не удалось показать сопутствующее объявление, потому что оно не помещается в область показа (то есть для него не хватает места).',
                                    60	=> 'Не удается показать необходимое сопутствующее объявление.',
                                    603	=> 'Не удалось получить ресурс CompanionAds или Companion.',
                                    604	=> 'Не удалось найти ресурс Companion поддерживаемого типа.',
                                    900	=> 'Неизвестная ошибка.',
                                    901	=> 'Общая ошибка VPAID.',
                                    
                                    );

        public static function getStaticInfo()
        {
            echo 'Class Traffic V1.0 Developed by Kir Chernenko.';
        }
        
        
        // Методы статистики DSP
        public function getTotalDSPStat()
        {
            $stat = Scanner::getTrafficStat($this->search);
            //var_dump($stat['via'][5345]); exit;
            $total_stat = array();
            $total_row = array();
            //var_dump($stat); exit;
            if(!empty($stat['via']))
            {
                foreach($stat['via'] as $ssp_id => $calls)
                {
                    foreach($calls as $type)
                    {
                        foreach($type as $incrementer => $call)
                        {
                            if(substr($incrementer, 0, 4) == 'err_') $incrementer = 'call_error';
                            if(substr($incrementer, 0, 12) == 'auction_err_') $incrementer = 'auction_error';
                            if(substr($incrementer, 0, 9) == 'vast_err_') $incrementer = 'vast_error';
                            
                            if(empty($total_stat[$ssp_id][$incrementer]))
                                $total_stat[$ssp_id][$incrementer] = intval($call['c']);
                            else
                                $total_stat[$ssp_id][$incrementer] += intval($call['c']);
                            
                            if(empty($total_row[$incrementer]))
                                $total_row[$incrementer] = intval($call['c']);
                            else
                                $total_row[$incrementer] += intval($call['c']);
                                
                            if(empty($total_stat[$ssp_id]['ssp_name']))
                               $total_stat[$ssp_id]['ssp_name'] = self::getSSPname($ssp_id);
                        }
                    }
                    
                }
            }
            $total_stat['total'] = $total_row;
            //var_dump($total_stat); exit;
            return $total_stat;
        }
        
        public function getDSPCallErrors()
        {
            $total_stat = array();
            $total_row = array();
            $stat = Scanner::getTrafficStat($this->search);
            //var_dump($stat); exit;
            
            if(!empty($stat['via']))
            {
                foreach($stat['via'] as $ssp_id => $keys)
                {
                    foreach($keys as $type)
                    {
                        foreach($type as $incrementer => $call)
                        {
                            if(substr($incrementer, 0, 4) == 'err_')
                            {
                                if(empty($total_stat[$ssp_id][$incrementer]))
                                    $total_stat[$ssp_id][$incrementer] = intval($call['c']);
                                else
                                    $total_stat[$ssp_id][$incrementer] += intval($call['c']);
                                
                                if(empty($total_row[$incrementer]))
                                    $total_row[$incrementer] = intval($call['c']);
                                else
                                    $total_row[$incrementer] += intval($call['c']);
                                    
                                if(empty($total_stat[$ssp_id]['ssp_name']))
                                   $total_stat[$ssp_id]['ssp_name'] = self::getSSPname($ssp_id);
                            }
                        }
                    }
                    
                }
            }
            $total_stat['total'] = $total_row;
            //var_dump($total_stat); exit;
            return $total_stat;
        }
        
        public function getDSPAuctionErrors()
        {
            $total_stat = array();
            $total_row = array();
            $stat = Scanner::getTrafficStat($this->search);
            //var_dump($stat); exit;
            
            if(!empty($stat['via']))
            {
                foreach($stat['via'] as $ssp_id => $keys)
                {
                    foreach($keys as $type)
                    {
                        foreach($type as $incrementer => $call)
                        {
                            if(substr($incrementer, 0, 12) == 'auction_err_')
                            {
                                if(empty($total_stat[$ssp_id][$incrementer]))
                                    $total_stat[$ssp_id][$incrementer] = intval($call['c']);
                                else
                                    $total_stat[$ssp_id][$incrementer] += intval($call['c']);
                                
                                if(empty($total_row[$incrementer]))
                                    $total_row[$incrementer] = intval($call['c']);
                                else
                                    $total_row[$incrementer] += intval($call['c']);
                                    
                                if(empty($total_stat[$ssp_id]['ssp_name']))
                                   $total_stat[$ssp_id]['ssp_name'] = self::getSSPname($ssp_id);
                            }
                        }
                    }
                    
                }
            }
            $total_stat['total'] = $total_row;
            //var_dump($total_stat); exit;
            return $total_stat;
        }
        
        public function getDSPUnmoderatedSites()
        {
            $total_stat = array();
            $total_row = array();
            
            $stat = Scanner::getTrafficStat($this->search);
            
            
            if(!empty($stat['via']))
            {
                foreach($stat['via'] as $ssp_id => $sites)
                {
                    foreach($sites as $site_id => $keys)
                    {
                        foreach($keys as $inc)
                        {
                            foreach($inc as $incrementer => $cntr)
                            {
                                if(empty($total_stat[$site_id][$incrementer]))
                                    $total_stat[$site_id][$incrementer] = intval($cntr['c']);
                                else
                                    $total_stat[$site_id][$incrementer] += intval($cntr['c']);
                                
                                if(empty($total_stat[$site_id]['site_url']))
                                    $total_stat[$site_id]['site_url'] = self::getSiteURL($ssp_id, $site_id);
                                //if(empty($total_row[$incrementer]))
                                //    $total_row[$incrementer] = intval($cntr['c']);
                                //else
                                //    $total_row[$incrementer] += intval($cntr['c']);
                            }
                        }
                    }
                }
            }
            
            //$total_stat['total'] = $total_row;
            //var_dump($total_stat); exit;
            return $total_stat;
            
        }
        
        public function getDSPVastErrors()
        {
            $stat = Scanner::getTrafficStat($this->search);
            //var_dump($stat); exit;
            $total_stat = array();
            $total_row = array();
            
            if(!empty($stat['via']))
            {
                foreach($stat['via'] as $ssp_id => $calls)
                {
                    foreach($calls as $call_key => $type)
                    {
                        if($call_key == 'vast')
                        {
                            foreach($type as $incrementer => $call)
                            {
                                if(empty($total_stat[$ssp_id][$incrementer]))
                                    $total_stat[$ssp_id][$incrementer] = intval($call['c']);
                                else
                                    $total_stat[$ssp_id][$incrementer] += intval($call['c']);
                                
                                if(empty($total_row[$incrementer]))
                                    $total_row[$incrementer] = intval($call['c']);
                                else
                                    $total_row[$incrementer] += intval($call['c']);
                                    
                                if(empty($total_stat[$ssp_id]['ssp_name']))
                                   $total_stat[$ssp_id]['ssp_name'] = self::getSSPname($ssp_id);
                            }
                        }
                    }
                    
                }
            }
            $total_stat['total'] = $total_row;
            //var_dump($total_stat); exit;
            return $total_stat;
        }
        
        public function getDSPbySSPsitesStat()
        {
            $stat = Scanner::getTrafficStat($this->search);
            //var_dump($stat); exit;
            $total_stat = array();
            $total_row = array();
            //var_dump($stat); exit;
            if(!empty($stat['via']))
            {
                foreach($stat['via'] as $ssp_id => $sites)
                {
                    foreach($sites as $site_id => $type)
                    {
                        if($site_id == 'empty') continue;
                        foreach($type as $type_id => $incrementers)
                        {
                            foreach($incrementers as $incrementer => $call)
                            {
                                if(substr($incrementer, 0, 4) == 'err_') $incrementer = 'call_error';
                                if(substr($incrementer, 0, 12) == 'auction_err_') $incrementer = 'auction_error';
                                if(substr($incrementer, 0, 9) == 'vast_err_') $incrementer = 'vast_error';
                                
                                if(empty($total_stat[$site_id][$incrementer]))
                                    $total_stat[$site_id][$incrementer] = intval($call['c']);
                                else
                                    $total_stat[$site_id][$incrementer] += intval($call['c']);
                                
                                if(empty($total_row[$incrementer]))
                                    $total_row[$incrementer] = intval($call['c']);
                                else
                                    $total_row[$incrementer] += intval($call['c']);
                                    
                                if(empty($total_stat[$site_id]['site_name']))
                                   $total_stat[$site_id]['site_name'] = self::getSiteURL($ssp_id, $site_id);
                            }
                        }
                    }
                    
                }
            }
            $total_stat['total'] = $total_row;
            //var_dump($total_stat); exit;
            return $total_stat;
        }
        
        
        //
        //
        // Методы статистики SSP
        //
        //
        
        public function getTotalSSPStat()
        {
            $stat = Scanner::getTrafficStat($this->search);
            $total_stat = array();
            $total_row = array();
            //var_dump($stat);
            if(!empty($stat['via']))
            {
                foreach($stat['via'] as $ssp_id => $calls)
                {
                    foreach($calls as $dsp_id => $call)
                    {
                        foreach($call as $inc)
                        {
                            foreach($inc as $incrementer => $cntr)
                            {
                                if(empty($total_stat[$ssp_id][$incrementer]))
                                    $total_stat[$ssp_id][$incrementer] = intval($cntr['c']);
                                else
                                    $total_stat[$ssp_id][$incrementer] += intval($cntr['c']);
                                
                                if(empty($total_row[$incrementer]))
                                    $total_row[$incrementer] = intval($cntr['c']);
                                else
                                    $total_row[$incrementer] += intval($cntr['c']);
                                    
                                if(empty($total_stat[$ssp_id]['ssp_name']))
                                   $total_stat[$ssp_id]['ssp_name'] = self::getSSPname($ssp_id);
                            }
                        }
                    }
                }
            }
            $total_stat['total'] = $total_row;
            //var_dump($total_stat); exit;
            return $total_stat;
        }
        
        public function getSSPbyDSPstat()
        {
            $stat = Scanner::getTrafficStat($this->search);
            $total_stat = array();
            $total_row = array();
            //var_dump($stat);
            if(!empty($stat['via']))
            {
                foreach($stat['via'] as $ssp_id => $calls)
                {
                    foreach($calls as $dsp_id => $call)
                    {
                        foreach($call as $inc)
                        {
                            foreach($inc as $incrementer => $cntr)
                            {
                                if(empty($total_stat[$dsp_id][$incrementer]))
                                    $total_stat[$dsp_id][$incrementer] = intval($cntr['c']);
                                else
                                    $total_stat[$dsp_id][$incrementer] += intval($cntr['c']);
                                
                                if(empty($total_row[$incrementer]))
                                    $total_row[$incrementer] = intval($cntr['c']);
                                else
                                    $total_row[$incrementer] += intval($cntr['c']);
                                    
                                if(empty($total_stat[$dsp_id]['dsp_name']))
                                   $total_stat[$dsp_id]['dsp_name'] = self::getDSPname($dsp_id);
                            }
                        }
                    }
                }
            }
            $total_stat['total'] = $total_row;
            
            return $total_stat;
        }
        
        public function getSSPbySitesStat()
        {
           
            $total_stat = array();
            $total_row = array();
            
            $stat = Scanner::getTrafficStat($this->search);
            //var_dump($stat); exit;
            
            if(!empty($stat['via']))
            {
                foreach($stat['via'] as $ssp_id => $sites)
                {
                    foreach($sites as $site_id => $keys)
                    {
                        foreach($keys as $inc)
                        {
                            foreach($inc as $incrementer => $cntr)
                            {
                                if(empty($total_stat[$site_id][$incrementer]))
                                    $total_stat[$site_id][$incrementer] = intval($cntr['c']);
                                else
                                    $total_stat[$site_id][$incrementer] += intval($cntr['c']);
                                
                                if(empty($total_row[$incrementer]))
                                    $total_row[$incrementer] = intval($cntr['c']);
                                else
                                    $total_row[$incrementer] += intval($cntr['c']);
                                    
                                if(empty($total_stat[$site_id]['site_url']))
                                    $total_stat[$site_id]['site_url'] = self::getSiteURL($ssp_id, $site_id);
                            }
                        }
                    }
                }
            }
            
            /*if(empty($total_stat[$site_id]['site_url']))
                            $total_stat[$site_id]['site_url'] = self::getSiteURL($ssp_id, $site_id);*/
            $total_stat['total'] = $total_row;
            
            return $total_stat;
        }
        
        public function getSSPUnmoderatedSites()
        {
            $total_stat = array();
            $total_row = array();
            
            $stat = Scanner::getTrafficStat($this->search);
            
            
            if(!empty($stat['via']))
            {
                foreach($stat['via'] as $ssp_id => $sites)
                {
                    foreach($sites as $site_id => $keys)
                    {
                        foreach($keys as $inc)
                        {
                            foreach($inc as $incrementer => $cntr)
                            {
                                if(empty($total_stat[$site_id][$incrementer]))
                                    $total_stat[$site_id][$incrementer] = intval($cntr['c']);
                                else
                                    $total_stat[$site_id][$incrementer] += intval($cntr['c']);
                                
                                //if(empty($total_row[$incrementer]))
                                //    $total_row[$incrementer] = intval($cntr['c']);
                                //else
                                //    $total_row[$incrementer] += intval($cntr['c']);
                                    
                                if(empty($total_stat[$site_id]['site_url']))
                                    $total_stat[$site_id]['site_url'] = self::getSiteURL($ssp_id, $site_id);
                            }
                        }
                    }
                }
            }
            
            //$total_stat['total'] = $total_row;
            //var_dump($total_stat); exit;
            return $total_stat;
            
        }
        
        
                
        public function to_days ($time=0)
        {
            if (!$time)
               $time=time();
              
            $GMT = (int)date("Z"); 
              
            $days = ($time+$GMT) / (60 * 60 * 24);
            $days = (int)$days;
              
            if(!$days) return 0;
            return 719528+$days;
        }
        
        public static function getSSPname($ssp_id)
        {
            $ssp_id = intval($ssp_id);
            $select = "SELECT name
                        FROM `ssp_net`
                        WHERE ssp_net_id = $ssp_id";
            
            $ssp_name = Yii::$app->banner
                ->createCommand($select)
                ->queryOne();
            
            return (!empty($ssp_name)) ? $ssp_name['name'] : 'Unknown';  
        }
        
        public static function getDSPname($dsp_id)
        {
            $dsp_id = intval($dsp_id);
            $select = "SELECT name
                        FROM `dsp_net`
                        WHERE dsp_net_id = $dsp_id";
            
            $dsp_name = Yii::$app->banner
                ->createCommand($select)
                ->queryOne();
            
            return (!empty($dsp_name)) ? $dsp_name['name'] : 'Unknown';  
        }
        
        public static function isVirtualSSP($ssp_id)
        {
            if(empty($ssp_id))
                return false;
            $select = "SELECT DISTINCT virtual_ssp_net_id
                        FROM `site`
                        WHERE is_virtual_ssp = 1";
            $virtual_ssps = Yii::$app->banner
                ->createCommand($select)
                ->queryColumn();
                
            return (in_array($ssp_id, $virtual_ssps)) ? true : false;
        }
        
        public static function getSiteURL($ssp_id, $site_id)
        {
            if(empty($ssp_id)) return false;
            
            
            if(self::isVirtualSSP($ssp_id) || intval($ssp_id) == 3634)
            {
                $site_id = intval($site_id);
                $select = "SELECT DISTINCT url
                            FROM `site`
                            WHERE site_id = $site_id";
            }
            else
            {
                $site_id = strval($site_id);
                $select = "SELECT DISTINCT url
                            FROM `ssp_net_site`
                            WHERE ssp_net_id = $ssp_id
                            AND site_id = '$site_id'";
            }
            
            $url = Yii::$app->banner
                ->createCommand($select)
                ->queryOne();
            
            return (!empty($url['url'])) ? $url['url'] : 'Unknown';
        }
        
        public function getDateFork()
        {
            $from = Yii::$app->request->getQueryParam('date_from');
            $to   = Yii::$app->request->getQueryParam('date_to');
            
            $this->date['from'] = $from;
            $this->date['to'] = $to;
            
            $from = (!empty($from)) ? strtotime($from) : false;
            $to = (!empty($to)) ? strtotime($to) : false;
            
            $from = $this->to_days() - $this->to_days($from);
            $to = $this->to_days() - $this->to_days($to);
            $to = ($to >= 0) ? $to : 0;
            
            $this->from = (!empty($from)) ? $from : '';
            $this->to = (!empty($to)) ? $to : '';
            
            return true;
        }
        
        public function getFormatsList()
        {
            $format_list_tmp = array(0=>'Select Format...');
            $format_list = Yii::$app->banner_replica->createCommand("SELECT format_id, name FROM format")->queryAll();
            
            if(!empty($format_list) && is_array($format_list))
            {
                foreach($format_list as $key=>$val)
                {
                    $format_list_tmp[$val['format_id']] = $val['name'];
                }
            }
            
            return($format_list_tmp);
            
        }
        
        public function getVastErrorBanners()
        {
            $ssp_id = (!empty($this->search['ssp_id'])) ? $this->search['ssp_id'] : false;
            
            $date_from = !empty($this->date['from']) ? $this->to_days(strtotime($this->date['from'])) : $this->to_days();
            $date_to = !empty($this->date['to']) ? $this->to_days(strtotime($this->date['to'])) : $this->to_days();
            $error = (!empty($this->vast_error_code)) ? $this->vast_error_code : '*';
            
            $banners = array();
            while($date_from <= $date_to)
            {
                
                if(!empty($ssp_id))
                {
                    $keys = Yii::$app->redis_log->executeCommand('keys',array("banners:vast:error:$date_from:$ssp_id:*:$error"));
                    
                    foreach($keys as $key)
                    {
                        $params = explode(':', $key);
                        $site_id = $params[5];
                        if(intval($site_id))
                            $site_id = $this->getSiteURL($ssp_id, $site_id);
                        
                        $res = Yii::$app->redis_log->executeCommand('HGETALL', array($key));
                        $result = $this->buildAssocArray($res);
                        //var_dump($result);
                        foreach($result as $banner_id => $err)
                        {
                            $banners[$banner_id][$site_id] += $err;
                            if(isset($banners['total']))
                                $banners['total'] +=  $err;
                            else
                                $banners['total'] = $err;
                        }
                    }
                    
                    
                }
                else
                {
                    $keys = Yii::$app->redis_log->executeCommand('keys',array("banners:vast:error:$date_from:total:$error"));
                    foreach($keys as $key)
                    {
                        $res = Yii::$app->redis_log->executeCommand('HGETALL', array($key));
                        $result = $this->buildAssocArray($res);
                        //var_dump($result);
                        foreach($result as $banner_id => $err)
                        {
                            $banners[$banner_id] += $err;
                            if(!isset($banners['total']))
                                $banners['total'] =  $err;
                            else
                                $banners['total'] +=  $err;
                        }
                    }
                }
                
                $date_from++;
                
            }
            //var_dump($banners);
            return $banners;
        }
        
        public function buildAssocArray($arr)
        {
            if(empty($arr) || !is_array($arr)) return array();
            //$var%2 ==0 ? четное : нечетное
            $return_arr = array();
            foreach($arr as $k=>$v)
                if(($k%2 == 0) || $k == 0)
                    $return_arr[$v] = intval($arr[($k+1)]);
            return $return_arr;
        }
        
        
    }

?>