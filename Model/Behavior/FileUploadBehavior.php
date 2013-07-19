<?php
class FileUploadBehavior extends ModelBehavior {
    
    public function setup(Model $Model, $settings = array()) {
        if (!isset($this->settings[$Model->alias])) {
            $this->settings[$Model->alias] = array(
                'allowedTypes' => array(
                    'jpg'
                ),
                'inputName' => 'filename',
                'required' => false,
                'uploadDir' => 'files/'
            );
        }
        $this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], $settings);
    }
    
    public function beforeSave(Model $Model) {
        $inputName = $this->settings[$Model->alias]['inputName'];
        $inputValue = (isset($Model->data[$Model->alias][$inputName])) ? $Model->data[$Model->alias][$inputName] : false;
        $required = $this->settings[$Model->alias]['required'];
        $uploadDir = $this->settings[$Model->alias]['uploadDir'];
        
        if (true === $required && (empty($inputValue) || $inputValue['error'] == 4)) {
            $Model->validationErrors[$inputName][] = 'File is required';
            return false;
        }
        
        if (is_array($inputValue) && $inputValue['error'] == 0) {
            if ($this->fileTypeValid($inputValue, $this->settings[$Model->alias]['allowedTypes'])) {
                if ($this->moveUploadedFile($inputValue, $uploadDir)) {
                    $Model->data[$Model->alias][$inputName] = $inputValue['name'];
                    return true;
                }
                else {
                    $Model->validationErrors[$inputName][] = 'Error uploading file; is upload directory writable?';
                    return false;
                }
            }
            else {
                $Model->validationErrors[$inputName][] = 'File type is invalid';
                return false;
            }
        }
        
        return true;
    }
    
    public function fileTypeValid($file, $allowedTypes) {
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        
        return (in_array($extension, $allowedTypes));
    }
    
    public function moveUploadedFile($file, $uploadDir) {
        $uploadDir = WWW_ROOT . $uploadDir;
        
        if (false === is_writable($uploadDir)) {
            return false;
        }
        
        if (file_exists($uploadDir . $file['name'])) {
            return false;
        }
        
        return move_uploaded_file($file['tmp_name'], $uploadDir . $file['name']);
    }
}