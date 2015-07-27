<?php

namespace app\commands;
use yii\console\Controller;

/**
 * Description of jobController
 *
 * @author tony
 */
class JobController extends Controller {
    //put your code here
    
    public function actionTest()
    {
        \Yii::$app->watchdog->IPCheck('softcube.co');
    }
}
