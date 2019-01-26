<?php

class VDXMLExport_Module_Model extends Vtiger_Module_Model
{
    public $user = NULL;
    public $db = NULL;
    public function __construct()
    {
        $this->user = Users_Record_Model::getCurrentUserModel();
        $this->db = PearDatabase::getInstance();
    }
    public function getAllSettings()
    {
        $list = array();
        $res = $this->db->pquery("SELECT * FROM vtiger_vdxmlexport", array());
        if ($this->db->num_rows($res)) {
            while ($row = $this->db->fetchByAssoc($res)) {
                $list[$row['name']] = $row['value'];
            }
        }
        return $list;
    }

    public function getField()
    {
        $settingsArray = $this->getAllSettings();
        if (array_key_exists('field', $settingsArray)) {
            return $settingsArray['field'];
        } else {
            return false;
        }
    }

    public function getURL()
    {
        $settingsArray = $this->getAllSettings();
        if (array_key_exists('url', $settingsArray)) {
            return $settingsArray['url'];
        } else {
            return false;
        }
    }

    
    /**
     * Function to get Settings links for admin user
     * @return Array
     */
    public function getSettingLinks()
    {
        $currentUserModel = Users_Record_Model::getCurrentUserModel();
        if ($currentUserModel->isAdminUser()) {
            $settingsLinks[] = array("linktype" => "LISTVIEWSETTING", "linklabel" => "Settings", "linkurl" => "index.php?module=VDXMLExport&view=Settings&parent=Settings", "linkicon" => "");
            $settingsLinks[] = array("linktype" => "LISTVIEWSETTING", "linklabel" => "Uninstall", "linkurl" => "index.php?module=VDXMLExport&view=Uninstall&parent=Settings", "linkicon" => "");
        }
        return $settingsLinks;
    }
}

?>