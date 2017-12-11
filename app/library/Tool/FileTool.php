<?php
/**
 * File tool
 */
namespace Tool;

class FileTool
{

    private $fileHandle = null;

    public static function getInstance()
    {
        return new self();
    }

    public function exist($file)
    {
        return is_file($file);
    }

    public function put($destinationFile, $sourceFile, ...$options)
    {
        if (empty($sourceFile) || empty($destinationFile)) {
            return false;
        }
        if (!$this->exist($sourceFile)) {
            return false;
        }
        if (is_uploaded_file($sourceFile)) {
            return move_uploaded_file($sourceFile, $destinationFile);
        } else if (copy($sourceFile, $destinationFile)) {
            unlink($sourceFile);
            return true;
        }
        return false;
    }


    public function parseDir($file)
    {
        $arrRealName = explode('/', $file);
        $lastFileName = strtolower(end($arrRealName));
        $fileDir = str_replace($lastFileName, '', $file);
        if (!is_dir($fileDir)) {
            if (!mkdir($fileDir, 0777, true)) {
                return false;
            }
        }
        return $fileDir.$lastFileName;
    }

}