<?php

class VDXMLExport_List_View extends Vtiger_Index_View {

        public function process(Vtiger_Request $request) {
            $moduleModel =  new VDXMLExport_Module_Model();
            $settings = $moduleModel->getAllSettings();
            $viewer = $this->getViewer($request);
            $viewer->view('List.tpl', $request->getModule());
        }

}
