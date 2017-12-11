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

    public function parseDir($path)
    {
        $arrRealName = explode('/', $path);
        $lastFileName = strtolower(end($arrRealName));
        $pathDir = str_replace($lastFileName, '', $path);
        if (!is_dir($pathDir)) {
            if (!mkdir($pathDir, 0777, true)) {
                return false;
            }
        }
        return $pathDir.$lastFileName;
    }

    public function put($destinationFile, $sourceFile, ...$options)
    {
        if (empty($sourceFile) || empty($destinationFile)) {
            return false;
        }
        if (!$this->exist($sourceFile)) {
            return false;
        }
        if ($this->parseDir($destinationFile)) {
            if (is_uploaded_file($sourceFile)) {
                return move_uploaded_file($sourceFile, $destinationFile);
            } else if (copy($sourceFile, $destinationFile)) {
                unlink($sourceFile);
                return true;
            }
        }
        return false;
    }

}