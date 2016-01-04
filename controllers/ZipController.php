<?php

namespace app\controllers;

use yii;
use app\components\FTP_Client;
use app\components\Parser_TXT;
use app\models\addenda;

class ZipController extends \yii\web\Controller
{
    public function actionGetZip()
    {
        $ftp = new FTP_Client;
        $result_upload = $ftp->zipUpload();
        if($result_upload['download']){
            $unpack = $ftp->unpack();
        }
        if($unpack) {

            $parser_txt = new Parser_TXT();
            $insert_data = $parser_txt->getTxtData();
            $insert_log = $parser_txt->insertTxtData($insert_data);
        }
        $ftp->clearFolders();

        return $this->render('get-zip', [
            'result_upload' => $result_upload,
            'count_unpack' => $unpack,
            'insert_log' => $insert_log,
        ]);

    }



    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionDel()
    {
        $parser_txt = new Parser_TXT();
        $parser_txt->clearDB();

    }

}
