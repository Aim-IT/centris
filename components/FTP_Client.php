<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.12.2015
 * Time: 12:23
 */

namespace app\components;

use yii\base\Component;
use Yii;
use ZipArchive;
use Exception;

class FTP_Client extends Component {

    public $zip_folder;
    public $unpack_folder;

    public function __construct() {
        $this->zip_folder = Yii::$app->params['upload_zip'];
        $this->unpack_folder = Yii::$app->params['upload_unpack'];
    }
    public function zipUpload() {
        try {
            $already_exists = [];
            $download_files = [];
            $connect_id = $this->ftpConnect();
            $ftp_file_list = $this->getFtpList($connect_id);
            $zip_list_str = file_get_contents(Yii::$app->params['zip_list']);

            foreach ($ftp_file_list as $ftp_file) {
                $local_file = $this->zip_folder . array_pop(explode('/', $ftp_file));

                if(strpos($zip_list_str , basename($local_file)) !== false) {
                    $already_exists[] = basename($local_file);
                    continue;
                }
                if(!file_put_contents(Yii::$app->params['zip_list'], basename($local_file) . "\r\n", FILE_APPEND)) {
                    throw new Exception('Error write to zip list! ');
                }
                $this->uploadFile($connect_id, $local_file, $ftp_file);
                $download_files[] = basename($local_file);
            }
            ftp_close($connect_id);
            return ['already' => $already_exists, 'download' => $download_files];

        } catch (Exception $e) {

            echo 'Exception: ',  $e->getMessage(), "\n";
            exit;
        }

    }

    public function clearFolders() {

        $this->removeDir($this->zip_folder);
        $this->removeDir($this->unpack_folder);
    }

    public function unpack() {

        $zip_files_ar = scandir($this->zip_folder);
        $zip_file_list = [];
        $count_unpack = 0;
        foreach($zip_files_ar as $zip_file) {
            if($zip_file == '.'  || $zip_file == '..'){
                continue;
            }
            $zip_file_list[] = $zip_file;
        }
        if(empty($zip_file_list)) {

            return false;
        }

        $zip = new ZipArchive;
        foreach($zip_file_list as $zip_file) {
            if ($zip->open($this->zip_folder . $zip_file) === TRUE) {
                $zip->extractTo($this->unpack_folder. $zip_file);
                $zip->close();
                $count_unpack++;
            } else {
                throw new Exception('Error unpack: ' . $zip_file . '!');
            }
        }

        return $count_unpack;
    }

    private function ftpConnect() {

        $ftp_server = Yii::$app->params['ftp_host'];
        $ftp_user_name = Yii::$app->params['ftp_login'];
        $ftp_user_pass = Yii::$app->params['ftp_pass'];
        if(!$conn_id = ftp_connect($ftp_server)){
            throw new Exception("No connection to $ftp_server");
        }
        // check auth
        if (!$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass)) {
            throw new Exception("FTP: Not valid login or password!");
        }
        ftp_pasv($conn_id, true);

        return $conn_id;

    }

    private function getFtpList($conn_id, $folder = '.') {

        if (!$ftp_file_list = ftp_nlist($conn_id, $folder)) {
            throw new Exception("FTP: Failed to get list of files on the server. Perhaps the files are missing.");
        }

        return $ftp_file_list;
    }

    private function uploadFile($conn_id, $local_file, $ftp_file) {

        if (!ftp_get($conn_id, $local_file, $ftp_file, FTP_BINARY)) {
            throw new Exception("Not saved file: " .$ftp_file);
        }

    }

    private function removeDir($path)
    {
        if(file_exists($path) && is_dir($path))
        {
            $dirHandle = opendir($path);
            while (false !== ($file = readdir($dirHandle)))
            {
                if ($file!='.' && $file!='..')
                {
                    $tmpPath=$path. DIRECTORY_SEPARATOR .$file;
                    chmod($tmpPath, 0777);
                    if (is_dir($tmpPath)) {
                        $this->removeDir($tmpPath . DIRECTORY_SEPARATOR);
                    }
                    else
                    {
                        if(file_exists($tmpPath)) {
                            unlink($tmpPath);
                        }
                    }
                }
            }
            closedir($dirHandle);
            if(file_exists($path) && $path != $this->zip_folder && $path != $this->unpack_folder)
            {
                rmdir($path);
            }
        }
    }
} 