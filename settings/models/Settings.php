<?php

class Settings_VDXMLExport_Settings_Model extends Vtiger_Base_Model
{
    public $user = NULL;
    public $db = NULL;
    public $dataFields = array('module', 'field');
    public function __construct()
    {
        global $current_user;
        $this->user = $current_user;
        $this->db = PearDatabase::getInstance();
    }
    public function getData()
    {
        $settings = array();
        $query = "SELECT * FROM vtiger_vdxmlexport";
        $result = $this->db->pquery($query, array());
        if (0 < $this->db->num_rows($result)) {
            while ($row = $this->db->fetchByAssoc($result)) {
                $settings[$row['name']] = $row['value'];
            }
        }
        return $settings;
    }
    public function getModuleFields($moduleName)
    {
        $moduleHandler = vtws_getModuleHandlerFromName($moduleName, $this->user);
        $moduleMeta = $moduleHandler->getMeta();
        return $moduleMeta->getModuleFields();
    }
    public function deleteRecord($request)
    {
        $recordId = $request->get("record", 0);
        if ($recordId == 0) {
            return false;
        }
        $this->db->pquery("DELETE FROM vtiger_vdxmlexport WHERE vtiger_vdxmlexport.id=?", array($recordId));
        return true;
    }
    public function saveSetting($request)
    {
        $entities = $request->get("entities", 0);
        if (0 < $entities) {
            $this->updateSetting($request);
        } else {
            $this->addSetting($request);
        }
        return true;
    }
    public function updateSetting($request)
    {
        $modulename = $request->get("modulename");
        foreach ($this->dataFields as $dataField) {
            $curData = $request->get($dataField);
            $query = "SELECT * FROM vtiger_vdxmlexport WHERE `name` = ?";
            $result = $this->db->pquery($query, array($dataField));
            if (0 < $this->db->num_rows($result)) {
                $this->db->pquery("UPDATE vtiger_vdxmlexport SET `name` = ?, `value` = ?\n                            WHERE `name` = ?", array($dataField, $curData, $dataField));
            } else {
                $this->db->pquery("INSERT INTO vtiger_vdxmlexport(`name`, `value`)\n                            VALUES(?, ?)", array($dataField, $curData));
            }
        }


        return true;
    }
    public function addSetting($request)
    {
        $modulename = $request->get("modulename");
        foreach ($this->dataFields as $dataField) {
            $curData = $request->get($dataField);
            $this->db->pquery("INSERT INTO vtiger_vdxmlexport(`name`, `value`)\n                            VALUES(?, ?)", array($dataField, $curData));
        }

        return true;
    }

}

?>