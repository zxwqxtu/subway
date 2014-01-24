<?php 
require_once dirname(__DIR__).'/PHPMailer_v5.1/class.phpmailer.php';
require_once dirname(__DIR__).'/lib/fsock.lib.php';

class Ticket12306 {
    public static $requestHeaders = array();

    public static $selectedTickets = array(
        'swz'=>'商务座',
        'tz'=>'特等座',
        'zy'=>'一等座',
        'ze'=>'二等座',
        'gr'=>'高级软卧',
        'rw'=>'软卧',
        'yw'=>'硬卧',
        'rz'=>'软座',
        'yz'=>'硬座',
        'wz'=>'无座',
    );

    public static $listInfos = array();
    public static $emails = array();
    public static $dates = array();
    public static $destnations = array('HYQ', 'ZZQ');

    public static function search($params) {
        $count = 1;
        while(true) {
            foreach($params as $v) {
                !empty($v['selectedTickets']) && self::$selectedTickets = $v['selectedTickets'];
                !empty($v['emails']) && self::$emails = $v['emails'];
                !empty($v['dates']) && self::$dates= $v['dates'];
                !empty($v['destnations']) && self::$destnations= $v['destnations'];

                foreach (self::$dates as $date) { 
                    foreach (self::$destnations as $to) {
                        self::searchTickets($date, $to, $v['origin']);
                        echo date("Y-m-d H:i:s")."\t".$count++."\n";
                    }
                    sleep(3);
                }
            }
        }
    }

    public static function searchTickets($date, $to, $from='BJP') {

        $selectedTickets = self::$selectedTickets;

        $url = "https://kyfw.12306.cn/otn/leftTicket/query?leftTicketDTO.train_date={$date}&leftTicketDTO.from_station={$from}&leftTicketDTO.to_station={$to}&purpose_codes=ADULT";
        $ret = Fsock::getBody($url, 'get', array(), self::$requestHeaders);
        $ret = json_decode($ret, true);

        if (!empty($ret['httpstatus']) && $ret['httpstatus'] == '200') {

            $html = '';
            foreach ($ret['data'] as $v) {
                $list = $v['queryLeftNewDTO'];
                $header = $from.'--'.$to."\t".$list['station_train_code'];
                $header .= "\t[{$list['start_time']}-{$list['arrive_time']}]:\n";

                $numArr = array();
                foreach ($list as $key=>$value) {
                    if (preg_match('#_num$#', $key)) {
                        $numArr[strstr($key, '_', true)] = ($value=='有'?$value:intval($value));
                    }
                }

                $content = '';
                //处理结果
                foreach ($numArr as $key=>$value) {
                    $keyTmp = $date.'_'.$list['station_train_code'].'_'.$key;

                    if (isset($selectedTickets[$key]) && !empty($value)  && empty(self::$listInfos[$keyTmp])) {
                        $body = "{$date}--{$selectedTickets[$key]}:{$value}\n";
                        $content .= $body;
                        error_log($body, 3, dirname(__FILE__).'/'.$value.'.log');
                    }

                    self::$listInfos[$keyTmp] = 1;
                }
                if (!empty($content)) {
                    $html .= $header.$content;
                }
            }
            !empty($html) && self::sendMail(nl2br($html), self::$emails);
        }
    }

    //email
    public static function sendMail($content, $toAddressArr) {
        $mail = new PHPMailer(); 
        $mail->IsSMTP();
        $mail->Host = "mail.yourdomain.com";
    //    $mail->SMTPDebug = 2;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";             
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->Username = 'wq@baisonmail.com';
        $mail->Password = 'xxxxx';
        
        $mail->SetFrom('wq@baisonmail.com','火车票');
        $mail->AddReplyTo('wq@baisonmail.com','火车票');
        foreach ($toAddressArr as $key => $val) {
            $mail->AddAddress($key, $val);
        }
        $mail->Subject = "火车票";
        $mail->AltBody = $content;
        $mail->MsgHTML($content);
        return $mail->Send();
    }
}
