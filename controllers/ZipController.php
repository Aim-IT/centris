<?php

namespace app\controllers;

use yii;
use app\components\FTP_Client;
use app\components\Parser_TXT;
use app\components\Parser_MDB;
use app\components\InsertData;
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
            $insert_data_txt = $parser_txt->getTxtData();

            $parser_mdb = new Parser_MDB();
            $insert_data_mdb = $parser_mdb->getMdbData();

            $insert_data = array_merge_recursive($insert_data_txt, $insert_data_mdb);
            $ins = new InsertData();
            $insert_log = $ins->insertTxtData($insert_data);
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
        $ins = new InsertData();
        $ins->clearDB();

    }

}
