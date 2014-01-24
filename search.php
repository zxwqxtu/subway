<?php
date_default_timezone_set('Asia/shanghai');
require dirname(__FILE__).'/common.php';

$params = array(
    '王强'=> array(
        'selectedTickets' => array(
#            'swz'=>'商务座',
#            'tz'=>'特等座',
#            'zy'=>'一等座',
            'ze'=>'二等座',
            'gr'=>'高级软卧',
            'rw'=>'软卧',
            'yw'=>'硬卧',
            'rz'=>'软座',
            'yz'=>'硬座',
#            'wz'=>'无座',
        ),
        'emails' => array(
            '960875184@qq.com'=> '王强'
        ),
        'dates' => array('2014-02-08','2014-02-09'),
        'destnations' => array('BJP'),
        'origin' => 'HYQ',
    ),
    /*
    '彭彪'=> array(
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
            'wz'=>'无座',
        ),
        'emails' => array(
            '776056179@qq.com'=> '彭彪'
        ),
        'dates' => array('2014-01-24','2014-01-25','2014-01-26'),
        'destnations' => array('HYQ', 'ZZQ'),
        'origin' => 'SHH',
    ),
    '贺朝阳'=> array(
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
    #        'wz'=>'无座',
        ),
        'emails' => array(
            '761725958@qq.com'=> '贺朝阳'
        ),
        'dates' => array('2014-01-24','2014-01-25','2014-01-26'),
        'destnations' => array('LDQ'),
        'origin' => 'BJP',
    ),
    '吴鹏'=> array(
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
             'wz'=>'无座',
        ),
        'emails' => array(
            '871542665@qq.com'=> '吴鹏'
        ),
        'dates' => array('2014-01-24','2014-01-25','2014-01-26'),
        'destnations' => array('HOY'),
        'origin' => 'BJP',
    ),
     */
);

Ticket12306::search($params);

