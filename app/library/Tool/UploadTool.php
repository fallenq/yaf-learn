<?php
/**
 * Upload tool
 */
namespace Tool;

class UploadTool
{

    private $_custom_name = 0;
    private $_fileTool = null;

    function __construct(...$options)
    {
        $this->init($options);
    }

    public function init(...$options)
    {
        if (!empty($options)) {
            if (!empty($options['custom_name'])) {
                $this->_custom_name = $options['custom_name'];
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
     * Process temp file info
     * @param string $files
     * @return array
     */
    private function processTempFileInfo($files = '')
    {
        if (empty($files)) {
            $files = $_FILES;
        }
        $outFiles = array();
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
    public function store($sourceFile, $destinationFile = '', ...$options)
    {
        if (empty($sourceFile)) {
            return false;
        }
        if ($this->_custom_name == 0) {
            $destinationFile = $this->getOutputName($sourceFile);
        } else if(empty($destinationFile)) {
            return false;
        }
        $fileTool = $this->getFileTool();
        if ($fileTool->exist($sourceFile)) {
            if ($fileTool->put($destinationFile, $sourceFile)) {
                return $destinationFile;
            }
        }
        return false;
    }

}