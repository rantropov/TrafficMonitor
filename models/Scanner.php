<?php
    
    namespace frontend\models;
    use Yii;
    use frontend\models\Ssp;
    
    /*
     *
     *  Class Scanner V1.0
     *  Select stat data from async redises
     *
     *  Developed by Kir Chernenko
     *
     */
    
    class Scanner extends \yii\db\ActiveRecord
    {
        
        
        
        public static function sendRequest($target)
        {
            if(empty($target)) return false;
            //var_dump($target); exit;
            $content = '';
            $response = '';
            
            if($curl = curl_init())
            {
                curl_setopt($curl, CURLOPT_URL, $target);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl, CURLOPT_TIMEOUT, 60 );
                $content = curl_exec($curl);
                $response = curl_getinfo($curl);
                curl_close ($curl);
            }
            
            // DEBUG MODULE
            //var_dump($params_arr);
            //var_dump($target);
            //var_dump($content);
            //exit;
            return json_decode($content, true);
        }
        
        
        public static function getTrafficStat($params_arr)
        {            
            if ( empty($params_arr) || !is_array($params_arr) )
                return false;
            
            
    //   http://m3.c8.net.ua/scanner.php?method=getTrafficStat&type=dsp&key=&keyd=&ssp_id=3634&site_id=&format_id=&via=&period=d&timeStart=1&timeEnd=0
            $target = "http://m3.c8.net.ua/scanner.php?method=getTrafficStat"; 
            
            (!empty($params_arr['type'])) ? $target .= "&type=".strval($params_arr['type']) : "";
            (!empty($params_arr['key'])) ? $target .= "&key=".strval($params_arr['key']) : "";
            (!empty($params_arr['keyd'])) ? $target .= "&keyd=".strval($params_arr['keyd']) : "";
            (!empty($params_arr['ssp_id'])) ? $target .= "&ssp_id=".strval($params_arr['ssp_id']) : "";
            (!empty($params_arr['site_id'])) ? $target .= "&site_id=".strval($params_arr['site_id']) : "";
            (!empty($params_arr['format_id'])) ? $target .= "&format_id=".strval($params_arr['format_id']) : "";
            (!empty($params_arr['via'])) ? $target .= "&via=".strval($params_arr['via']) : "";
            (!empty($params_arr['period'])) ? $target .= "&period=".strval($params_arr['period']) : "";
            (!empty($params_arr['timeStart'])) ? $target .= "&timeStart=".strval($params_arr['timeStart']) : "";
            (!empty($params_arr['timeEnd'])) ? $target .= "&timeEnd=".strval($params_arr['timeEnd']) : "";
                      
                         
            if($curl = curl_init())
            {
                curl_setopt($curl, CURLOPT_URL, $target);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl, CURLOPT_TIMEOUT, 60 );
                $content = curl_exec($curl);
                $response = curl_getinfo($curl);
                curl_close ($curl);
            }
            
            // DEBUG MODULE
            //var_dump($params_arr);
            //var_dump($target);
            //var_dump($content);
            //exit;
            return json_decode($content, true);            
        }
        
        public static function sendPlannerRequest($params_arr, $quick = false)
        {            
            if ( empty($params_arr) || !is_array($params_arr) )
                return false;
            
            
            //http://m3.c8.net.ua/scanner.php?method=getPlannerStat
            //                            &bidfloor_uah=
            //                            &is_bid=
            //                            &ssp_id=
            //                            &site_id=
            //                            &domain=
            //                            &geo_country=
            //                            &geo_region=
            //                            &geo_city=
            //                            &formats=
            //                            &site_iab=
            //                            &dmp_tax=
            //                            &pools=
            //                            &projects=
            //                            &period=
            //                            &timeStart=
            //                            &timeEnd=
            //                            &viacustom=domain,dmp_tax,formats
            //                            &debug=1
            
            $target = $quick ? "http://m3.c8.net.ua/scanner.php?method=getPlannerStat" :
                                    "http://m3.c8.net.ua/scanner.php?method=initAsyncWork&rmethod=getPlannerStat"; 
            
            (!empty($params_arr['bidfloor_uah'])) ? $target .= "&bidfloor_uah=".strval($params_arr['bidfloor_uah']) : "";
            (!empty($params_arr['scan_width'])) ? $target .= "&scan_width=".strval($params_arr['scan_width']) : "";
            (isset($params_arr['is_bid']) && $params_arr['is_bid'] != "") ? $target .= "&is_bid=".strval($params_arr['is_bid']) : "";
            (!empty($params_arr['ssp_id'])) ? $target .= "&ssp_id=".strval($params_arr['ssp_id']) : "";
            (!empty($params_arr['site_id'])) ? $target .= "&site_id=".strval($params_arr['site_id']) : "";
            (!empty($params_arr['domain'])) ? $target .= "&domain=".strval($params_arr['domain']) : "";
            (!empty($params_arr['geo_country'])) ? $target .= "&geo_country=".strval($params_arr['geo_country']) : "";
            (!empty($params_arr['geo_region'])) ? $target .= "&geo_region=".strval($params_arr['geo_region']) : "";
            (!empty($params_arr['geo_city'])) ? $target .= "&geo_city=".strval($params_arr['geo_city']) : "";
            (!empty($params_arr['formats'])) ? $target .= "&formats=".strval($params_arr['formats']) : "";
            (!empty($params_arr['site_iab'])) ? $target .= "&site_iab=".strval($params_arr['site_iab']) : "";
            (!empty($params_arr['dmp_tax'])) ? $target .= "&dmp_tax=".strval($params_arr['dmp_tax']) : "";
            (!empty($params_arr['pools'])) ? $target .= "&pools=".strval($params_arr['pools']) : "";
            (!empty($params_arr['projects'])) ? $target .= "&projects=".strval($params_arr['projects']) : "";
            (!empty($params_arr['viacustom'])) ? $target .= "&viacustom=".strval($params_arr['viacustom']) : "";
            (!empty($params_arr['via'])) ? $target .= "&via=".strval($params_arr['via']) : "";
            
            
            (!empty($params_arr['period'])) ? $target .= "&period=".strval($params_arr['period']) : "";
            (isset($params_arr['timeStart'])) ? $target .= "&timeStart=".strval($params_arr['timeStart']) : "";
            (isset($params_arr['timeEnd'])) ? $target .= "&timeEnd=".strval($params_arr['timeEnd']) : "";
            (!empty($params_arr['debug'])) ? $target .= "&debug=".strval($params_arr['debug']) : "";
                      
                         
            return self::sendRequest($target);            
        }
        
        public static function getPlannerResponse($params_arr)
        {
            if ( empty($params_arr) || !is_array($params_arr) )
                return false;
            
            $target = "http://m3.c8.net.ua/scanner.php?method=getAsyncWork&rmethod=getPlannerStat";
            (!empty($params_arr['workid'])) ? $target .= "&workid=".strval($params_arr['workid']) : "";
            //(!empty($params_arr['getStatus'])) ? $target .= "&status" : "";
            
            
            return self::sendRequest($target); 
             
        }
        
    }
?>