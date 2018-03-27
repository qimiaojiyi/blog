<?php

/* 
 * Expoon.com
 * Auth @Libra
 */
class Image
{

    //图片后缀名
    public static function getExt($mimeType)
    {
        $ext = '.jpg';
        switch ($mimeType)
        {
            case 'image/jpeg':
                $ext = '.jpg';
                break;
            case 'image/gif':
                $ext = '.gif';
                break;
            case 'image/png':
                $ext = '.png';
                break;
            default :
                $ext = '.jpg';
                break;
        }
        return $ext;
    }

    //图片展示URL(虚拟路劲转绝对路径)
    public static function getShowUrl($virtualPath)
    {
        if (isset($virtualPath) && $virtualPath != '')
        {
            return "http://" . $_SERVER ["SERVER_NAME"] . Yii::app()->baseUrl . $virtualPath;
        }
        return '';
    }

    //上传图片
    public static function picUpload($virtualDir, $fileName, $ext = null)
    {
        $picVirtualUrls = array(); //上传图片的虚拟路径数组
        $saveRes = false;
        Yii::log('files============='.CJSON::encode($_FILES));
        if (count($_FILES) <= 0)
        {
            return '没有上传文件';
        }
        foreach ($_FILES as $file)
        {
            if ($file['type'] != 'image/jpeg' && $file['type'] != 'image/gif' && $file['type'] != 'image/png')
            {
                return '1'; //不合法的文件
            }
            if ($file['size'] > 400000)
            {
                return '2'; //文件太大
            }
            if ($file['error'] > 0)
            {
                return '3'; //上传失败
            }
            $ext = empty($ext) ? self::getExt($file['type']) : $ext;
            $virtualPath = $virtualDir . $fileName . $ext;
            $picVirtualUrls[] = $virtualPath;
            $picFileName = dirname(Yii::app()->basePath) . $virtualPath;
            $saveRes = move_uploaded_file($file['tmp_name'], $picFileName);
        }
        if ($saveRes)
        {
            return $picVirtualUrls;
        }
        else
        {
            return '上传失败';
        }
    }
    
}
