<?php
date_default_timezone_set('Asia/Shanghai');
require dirname(__FILE__).'/common.php';

$params = array(
    '王强'=> array(
        'selectedTickets' => array(
#            'swz'=>'商务座',
#            'tz'=>'特等座',
#            'zy'=>'一等座',
#            'ze'=>'二等座',
#            'gr'=>'高级软卧',
#            'rw'=>'软卧',
            'yw'=>'硬卧',
            'rz'=>'软座',
            'yz'=>'硬座',
        #    'wz'=>'无座',
        ),
        'emails' => array(
            '960875184@qq.com'=> '王强'
        ),
        'dates' => array('2015-02-13'),
        'destnations' => array('CZQ', 'FSQ'),
        'origin' => 'BJP',
    ),
    '肖正刚'=> array(
        'selectedTickets' => array(
            'swz'=>'商务座',
            'tz'=>'特等座',
            'zy'=>'一等座',
            'ze'=>'二等座',
            'gr'=>'高级软卧',
            'rw'=>'软卧',
            'yw'=>'硬卧',
            'rz'=>'软座',
            'yz'=>'硬座',
        #    'wz'=>'无座',
        ),
        'emails' => array(
            '510417779@qq.com'=> '肖正刚'
        ),
        'dates' => array('2015-02-14', '2015-02-15', '2015-02-16'),
        'destnations' => array('HYQ'),
        'origin' => 'GZQ',
    ),

);

while(true) {
    try {
        Ticket12306::search($params);
    } catch(Exception $e) {

    }
}

