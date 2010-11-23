<?php

/**
 * Загружает файл с сервера
 *
 * @author Konstantin
 */
class jrFileUploader {
    public static function UploadRemote($url)
    {
      $parsedUrl = parse_url($url);
      
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; GoogleToolbar 2.0.111-big; Windows NT 5.1; ru; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14 WebMoney Advisor');
      curl_setopt($curl, CURLOPT_AUTOREFERER, true);
      curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
      curl_setopt($curl, CURLOPT_REFERER, $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . '/');
      $image = curl_exec($curl);

      $mime = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);

      $filename = pathinfo($url);
      $extension = $filename["extension"] ? $filename["extension"] : "jpg";
      $filename = time().rand(1, 999999).".".$extension;

      $thumbnail = new sfThumbnail(811, 0, true, false, 100, sfConfig::get('app_sfThumbnailPlugin_adapter','sfGDAdapter'));

      $tempFile = tempnam('/tmp', '');
      file_put_contents($tempFile, $image);
      $thumbnail->loadFile($tempFile);
      $thumbnail->save(sfConfig::get('sf_upload_dir').'/'.$filename);
      unlink($tempFile);
      return $filename;
    }
}
?>
