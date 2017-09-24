<?php

namespace UDFiles\FileManager;


class File
{
    private $fileData = null;
    private $name = '';
    private $size = 0;
    private $error = 0;
    private $tmp_name = '';
    private $type = '';
    private $pathUpload = '';
    private $validate = ['validateExtension' => false, 'validateSize' => false, 'size' => '0'];
    private $extensions = ['jpeg', 'jpg', 'png', 'pdf', 'txt'];

    /**
     * Files constructor.
     * @param $file
     */
    public function __construct($file)
    {
        if (is_array($file) && count($file)) {
            foreach ($file as $key => $value) {
                $this->$key = $this->fileData[$key] = $value;
            }
        }
    }

    /**
     * Get array configuration for Validate
     * @return array
     */
    public function getValidate()
    {
        return $this->validate;
    }

    /**
     * Set array config for validate
     * @param array $validate
     */
    public function setValidate($validate)
    {
        $this->validate = $validate;
    }

    /**
     * @return string
     */
    public function getPathUpload()
    {
        return $this->pathUpload;
    }

    /**
     * @param string $pathUpload
     */
    public function setPathUpload($pathUpload)
    {
        $this->pathUpload = $pathUpload;
    }

    /**
     * Return extension file
     * @param $filename
     * @return string
     */
    public function getExtension($filename)
    {
        return strtolower(end(explode('.', basename($filename))));
    }

    /**
     * Get all extensions
     * @return array
     */
    public function getExtensions()
    {
        return $this->extensions;
    }

    /**
     * Set extensions
     * @param array $extensions
     */
    public function setExtensions($extensions = [])
    {
        if (is_array($extensions)) {
            $this->extensions = $extensions;
        }
    }

    /**
     * Add new extension
     * @param $extension
     */
    public function addExtension($extension)
    {
        array_push($this->extensions, $extension);
    }

    /**
     * @return int
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param int $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * Get all data of File
     * @return null
     */
    public function getFileData()
    {
        return $this->fileData;
    }

    /**
     * Set data File
     * @param null $fileData
     */
    public function setFileData($fileData)
    {
        $this->fileData = $fileData;
    }

    /**
     * Get filename
     * @return string
     */
    public function getFileName()
    {
        return basename($this->name);
    }

    /**
     * Set filename
     * @param string $name
     */
    public function setFileName($name)
    {
        $this->name = $name;
    }

    /**
     * get size File (Bytes)
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set File size (Bytes)
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * Get temporal name
     * @return string
     */
    public function getTmpName()
    {
        return $this->tmp_name;
    }

    /**
     * Set temporal name
     * @param string $tmpName
     */
    public function setTmpName($tmpName)
    {
        $this->tmp_name = $tmpName;
    }

    /**
     * Get Type File
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set Type File
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Upload file using move_uploaded_file
     * @param $filename
     * @return bool
     */
    public function uploadFile($filename)
    {
        $pathFileUpload = $this->getPathUpload() . DIRECTORY_SEPARATOR . $filename;
        $result = false;
        try {
            if (is_dir($this->getPathUpload()) && is_readable($this->getPathUpload())) {
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if ($this->getValidate()['validateExtension'] && !in_array($ext, $this->getExtensions())) {
                    throw new \RuntimeException('Invalid file format.');
                }
                if ($this->getValidate()['validateSize'] && ($this->getSize() > $this->getValidate()['size'])) {
                    throw new \RuntimeException('Exceeded filesize limit.');
                }
                $result = move_uploaded_file($this->getTmpName(), $pathFileUpload);
            }
        } catch (\Exception $e) {
            $this->showMessage($e->getMessage());
        } finally {
            return $result;
        }
    }

    /**
     * Delete file using unlink
     * @param  $filename
     * @param $pathDelete
     * @return bool
     */
    public function deleteFile($filename, $pathDelete = '')
    {
        $result = false;
        $pathFileDelete = ($pathDelete == '') ? $this->getPathUpload() . DIRECTORY_SEPARATOR . $filename :
            $pathDelete . DIRECTORY_SEPARATOR . $filename;
        $pathDir = ($pathDelete == '') ? pathinfo($pathFileDelete)['dirname'] : $pathDelete;
        try {
            if (is_file($pathFileDelete) && is_dir($pathDir) && is_readable($pathDir)) {
                $result = unlink($pathFileDelete);
            }
        } catch (\Exception $e) {
            $this->showMessage($e->getMessage());
        } finally {
            return $result;
        }
    }

    /**
     * Move file to other directory
     * @param $filename
     * @param $destinePath
     * @return bool
     */
    public function moveFile($filename, $destinePath)
    {
        $pathFileUpload = $this->getPathUpload() . DIRECTORY_SEPARATOR . $filename;
        $result = false;
        try {
            if (is_file($pathFileUpload) && is_dir($destinePath) && is_readable($destinePath)) {
                $result = copy($pathFileUpload, $destinePath . DIRECTORY_SEPARATOR . $filename);
                $this->deleteFile($filename);
            }
        } catch (\Exception $e) {
            $this->showMessage($e->getMessage());
        } finally {
            return $result;
        }
    }

    /**
     * Rename File
     * @param $filename
     * @param $destinePath
     * @return bool
     */
    public function renameFile($filename, $destinePath)
    {
        $pathFileUpload = $this->getPathUpload() . DIRECTORY_SEPARATOR . $filename;
        $pathValue = pathinfo($destinePath);
        $result = false;
        try {
            if (is_file($pathFileUpload) && is_dir($pathValue['dirname']) && is_readable($pathValue['dirname'])) {
                $result = rename($pathFileUpload, $pathValue['dirname'] . DIRECTORY_SEPARATOR . $pathValue['basename']);
                ($result) ? $this->setFileName($pathValue['basename']) : $this->setFileName($filename);
            }
        } catch (\Exception $e) {
            $this->showMessage($e->getMessage());
        } finally {
            return $result;
        }
    }

    /**
     * Download File
     * @param $filename
     * @param $pathFile
     */
    public function downloadFile($filename, $pathFile = '')
    {
        $filename = basename($filename);
        $pathFile = ($pathFile == '') ? $this->getPathUpload() . DIRECTORY_SEPARATOR . $filename :
            $pathFile . DIRECTORY_SEPARATOR . $filename;
        if (is_file($pathFile)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($pathFile));
            readfile($pathFile);
        }
        exit;
    }

    /**
     * Download File Inline
     * @param $filename
     * @param $contentType
     * @param bool $inline
     * @param $pathFile
     */
    public function downloadFileInline($filename, $contentType = 'application/octet-stream', $inline = false,
                                       $pathFile = '')
    {
        $filename = basename($filename);
        $pathFile = ($pathFile == '') ? $this->getPathUpload() . DIRECTORY_SEPARATOR . $filename :
            $pathFile . DIRECTORY_SEPARATOR . $filename;
        if (is_file($pathFile)) {
            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Content-Type: ' . $contentType);
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . filesize($pathFile));
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            if ($inline) {
                $disposition = $inline ? 'inline' : 'attachment';
                header("Content-Disposition: $disposition; filename=\"$filename\"");
            }
            readfile($pathFile);
        }
        exit;
    }

    /**
     * Print message
     * @param $message
     */
    public function showMessage($message)
    {
        echo $message;
    }
}