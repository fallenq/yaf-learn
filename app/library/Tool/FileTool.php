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

    public function put($sourceFile, $destinationFile, ...$options)
    {
        if (empty($sourceFile) || empty($destinationFile)) {
            return false;
        }
        if (!$this->exist($sourceFile)) {
            return false;
        }
        if (is_uploaded_file($sourceFile)) {
            return move_uploaded_file($sourceFile, $destinationFile);
        } else {
            copy($sourceFile, $destinationFile);
            unlink($sourceFile);
        }
        return false;
    }

}