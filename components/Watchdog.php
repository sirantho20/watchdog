<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace app\components;
use yii\base\Component;

/**
 * Description of Watchdog
 *
 * @author tony
 */
class Watchdog extends Component {
    
    public function WebsiteCheck($domain)
    {
        $agent = "Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_8; pt-pt) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27";

        // initializes curl session
        $ch = \curl_init();

        // sets the URL to fetch
        curl_setopt($ch, CURLOPT_URL, 'http://'.$domain);

        // sets the content of the User-Agent header
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);

        // make sure you only check the header - taken from the answer above
        curl_setopt($ch, CURLOPT_NOBODY, true);

        // follow "Location: " redirects
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        // return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // disable output verbose information
        curl_setopt($ch, CURLOPT_VERBOSE, false);

        // max number of seconds to allow cURL function to execute
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);

        // execute
        curl_exec($ch);

        // get HTTP response code
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($httpcode >= 200 && $httpcode < 300)
        {
           
            return true;
        }
        else
        {
            //echo 'down!';
            return false;
        }
    }
    
    public function DNSCheck($domain)
    {
        // lookup NS records
        $dns = \dns_get_record($domain, DNS_NS);
        
        //grab domain id
        $domain_id = \app\models\Domain::findOne(['domain' => $domain])->domain_id;
        
        // retrieve last stored records
        $prev_record = (new \yii\db\Query())->select(['record_value'])->from(['domain_record'])->where(['domain_id' => $domain_id, 'record_type' => 'NS'])->all();
        $prev = [];
        foreach($prev_record as $re)
        {
            $prev[] = $re['record_value'];
        }
        
        // prepare dns records array
        $record = [];
        foreach ($dns as $ns)
        {
            $record[] = $ns['target'];
        }
        
        //detect record differences
        $diff = array_diff($record, $prev);
        
        if(!empty($diff))
        {
            $q = new \app\models\MailQueue();
            $q->domain_id = $domain_id;
            $q->message = '';
            $q->save();
            
        }
        
        // clear old record
        \app\models\DomainRecord::deleteAll(['domain_id' => $domain_id, 'record_type' => 'NS']);
        
        // Insert new records
        foreach ($record as $key => $value)
        {
            $model = new \app\models\DomainRecord();
            $model-> domain_id = $domain_id;
            $model->record_type = 'NS';
            $model->record_value = $value;
            $model->last_checked = new \yii\db\Expression('now()');
            $model->save();
        }
            
    }
    
    public function MXCheck($domain)
    {
        // lookup NS records
        $dns = \dns_get_record($domain, DNS_MX);
        
        //grab domain id
        $domain_id = \app\models\Domain::findOne(['domain' => $domain])->domain_id;
        
        // retrieve last stored records
        $prev_record = (new \yii\db\Query())->select(['record_value'])->from(['domain_record'])->where(['domain_id' => $domain_id, 'record_type' => 'MX'])->all();
        $prev = [];
        foreach($prev_record as $re)
        {
            $prev[] = $re['record_value'];
        }
        
        // prepare dns records array
        $record = [];
        foreach ($dns as $ns)
        {
            $record[] = $ns['target'];
        }
        
        //detect record differences
        $diff = array_diff($record, $prev);
        
        if(!empty($diff))
        {
            $q = new \app\models\MailQueue();
            $q->domain_id = $domain_id;
            $q->message = '';
            $q->save();
            
        }
        
        // clear old record
        \app\models\DomainRecord::deleteAll(['domain_id' => $domain_id, 'record_type' => 'MX']);
        
        // Insert new records
        foreach ($record as $key => $value)
        {
            $model = new \app\models\DomainRecord();
            $model-> domain_id = $domain_id;
            $model->record_type = 'MX';
            $model->record_value = $value;
            $model->last_checked = new \yii\db\Expression('now()');
            $model->save();
        }
            
    }
    
    public function IPCheck($domain)
    {
         // lookup NS records
        $dns = \dns_get_record($domain, DNS_A);
        
        //grab domain id
        $domain_id = \app\models\Domain::findOne(['domain' => $domain])->domain_id;
        
        // retrieve last stored records
        $prev_record = (new \yii\db\Query())->select(['record_value'])->from(['domain_record'])->where(['domain_id' => $domain_id, 'record_type' => 'IP'])->all();
        $prev = [];
        foreach($prev_record as $re)
        {
            $prev[] = $re['record_value'];
        }
        
        // prepare dns records array
        $record = [];
        foreach ($dns as $ns)
        {
            $record[] = $ns['ip'];
        }
        
        //detect record differences
        $diff = array_diff($record, $prev);
        
        if(!empty($diff))
        {
            $q = new \app\models\MailQueue();
            $q->domain_id = $domain_id;
            $q->message = '';
            $q->save();
            
        }
        
        // clear old record
        \app\models\DomainRecord::deleteAll(['domain_id' => $domain_id, 'record_type' => 'IP']);
        
        // Insert new records
        foreach ($record as $key => $value)
        {
            $model = new \app\models\DomainRecord();
            $model-> domain_id = $domain_id;
            $model->record_type = 'IP';
            $model->record_value = $value;
            $model->last_checked = new \yii\db\Expression('now()');
            $model->save();
        }
        
    }
    

    
}

