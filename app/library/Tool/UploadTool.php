<?php
/**
 * Upload tool
 */
namespace Tool;

use Helper\CommonHelper;

class UploadTool
{

    private $_custom_dest = 0;
    private $_fileTool = null;

    function __construct(...$options)
    {
        $this->init($options);
    }

    public function init(...$options)
    {
        if (!empty($options)) {
            if (!empty($options['custom_dest'])) {
                $this->_custom_dest = $options['custom_dest'];
            }
        }
    }

    public function getFileTool()
    {
        if (empty($this->_fileTool)) {
            $this->_fileTool = FileTool::getInstance();
        }
        return $this->_fileTool;
    }

    /**
     * Get output name of file
     * @param $file
     * @return string
     */
    private function getOutputName($file)
    {
        $arrRealName = explode('.', $file);
        $suffix = strtolower(end($arrRealName));
        $outFileName = md5($arrRealName[0] . time() . mt_rand(0, 10));
        $outFileName = substr_replace($outFileName, '/', 2, 0);
        $outFileName = substr_replace($outFileName, '/', 5, 0);
        return $outFileName . '.' . $suffix;
    }

    /**
     * Parse output name
     * @param $file
     * @return string
     */
    private function parseOutputName($file)
    {
        $dirPrefix = CommonHelper::config('common', 'upload.dir_prefix', '');
        if (empty($dirPrefix)) {
            return '';
        }
        return $dirPrefix.$file;
    }

    /**
     * Process temp file info
     * @param string $files
     * @return array
     */
    public function processTempFileInfo($files = '')
    {
        $outFiles = [];
        if (empty($files)) {
            if (empty($_FILES)) {
                return $outFiles;
            }
            $files = $_FILES;
        }
        $n = 0;
        foreach ($files as $key => $file) {
            if (is_array($file['name'])) {
                $keys = array_keys($file);
                $count = count($file['name']);
                for ($i = 0; $i < $count; $i++) {
                    $outFiles[$n]['key'] = $key;
                    foreach ($keys as $_key) {
                        $outFiles[$n][$_key] = $file[$_key][$i];
                    }
                    $n++;
                }
            } else {
                $outFiles[$key] = $file;
            }
        }
        return $outFiles;
    }

    /**
     * Local store file
     * @param $sourceFile
     * @param $destinationFile
     * @return string
     */
    public function store($sourceFile, $origin = '', $destinationFile = '', ...$options)
    {
        if (empty($sourceFile) || empty($origin)) {
            return false;
        }
        if ($this->_custom_dest == 0) {
            $destinationFile = $this->getOutputName($origin);
        } else if(empty($destinationFile)) {
            return false;
        }
        $destinationFileUri = $this->parseOutputName($destinationFile);
        if (!empty($destinationFileUri) && $this->getFileTool()->put($destinationFileUri, $sourceFile)) {
            return $destinationFile;
        }
        return false;
    }

}