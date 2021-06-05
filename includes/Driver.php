<?php

class Driver extends DB_object
{
    protected static $db_table="drivers";
    protected static $db_table_fields=array('driver_name','address','dl_no','vehicle_class','dl_issue_dt','dl_validity','dob','user_image','dl_scanned_copy','status');
    public $id;
    public $driver_name; //ok
    public $address; //ok
    public $dl_no; //ok
    public $vehicle_class; //ok
    public $dl_issue_dt; //ok
    public $dl_validity; //ok
    public $dob; //ok
    public $user_image; // ok
    public $dl_scanned_copy;
    public $status;
    public $upload_directory="images";
    public $image_placeholder="images".DS."img_avatar.png";
    public $dl_placeholder="images".DS."dl_avatar.png";
    

    public function image_path_and_placeholder(){
        return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory.DS.$this->user_image;
    }

    public function dl_path_and_placeholder(){
        return empty($this->dl_scanned_copy) ? $this->dl_placeholder : $this->upload_directory.DS.$this->dl_scanned_copy;
    }

   


     public function delete_photo()
    {
        if ($this->delete()) {
            $target_path=SITE_ROOT.DS.'admin'.DS.$this->upload_directory.DS.$this->user_image;
            return unlink($target_path)?true:false;
        }else{
            return false;       
        }
    }


    public function upload_photo() 
    {

        
            if(!empty($this->errors)) {

                return false;

            }

            if(empty($this->user_image) || empty($this->tmp_path)){
                $this->errors[] = "the file was not available";
                return false;
            }

            $target_path = SITE_ROOT . DS . $this->upload_directory . DS . $this->user_image;


            if(file_exists($target_path)) {
                $this->errors[] = "The file {$this->user_image} already exists";
                return false;

            }

            if(move_uploaded_file($this->tmp_path, $target_path)) {

                    unset($this->tmp_path);
                    return true;

            } else {

                $this->errors[] = "The file directory does not have permission.";
                return false;

            }

    }

    // upload dl
    public function upload_dl() 
    {
        if(!empty($this->errors))
        {
            return false;
        }
        if(empty($this->dl_scanned_copy) || empty($this->tmp_path))
        {
            $this->errors[] = "the file was not available";
            return false;
        }
        $target_path = SITE_ROOT . DS . $this->upload_directory . DS . $this->dl_scanned_copy;
        if(file_exists($target_path)) {
            $this->errors[] = "The file {$this->dl_scanned_copy} already exists";
            return false;
        }
        if(move_uploaded_file($this->tmp_path, $target_path)) {
            unset($this->tmp_path);
            return true;
        } else {
            $this->errors[] = "The file directory does not have permission.";
            return false;
        }
    }
}



//end of user class
