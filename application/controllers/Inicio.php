<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Inicio extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Tables_Model');
        $this->load->helper('url');
    }

    public function index($errorMsj = "") {
        $data['errorMsj'] = $errorMsj;
        $this->load->view('carga_excel', $data);
    }


    public function carga_excel() {
        if ($this->input->post()) {
            $title = $this->input->post('titulo');
            $previousText = $this->input->post('texto_previo');
            $month = $this->input->post('mes');
            $year = $this->input->post('ano');
    
            $config = array(
                'upload_path' => './excel/',
                'allowed_types' => 'xlsx|xls',
                'max_size' => 0,
                'max_width' => 0,
                'max_heigth' => 0
            );
    
            $this->load->library('upload', $config);
    
            if (!$this->upload->do_upload("excel")) {
                redirect('Inicio/index');
            }
    
            $file_info = $this->upload->data();
            $file = $file_info['file_name'];
            $excelFilePath = "excel/" . $file;
    
            $excelData = $this->cargarYLeerExcel($excelFilePath);
    
            if ($excelData) {
                try {
                    $result = $this->registrarDatosEnDB($title, $previousText, $month, $year, $excelData);
    
                    if ($result) {
                        redirect('Inicio/previewTable');
                    } else {
                        redirec('Inicio/index', "Ocurrio un error al registrar el Excel");
                    }
                } catch (Exception $e) {
                    redirec('Inicio/index', "Ocurrio un error al registrar el Excel " . $e->getMessage());
                }
            }
        }
    }

    private function cargarYLeerExcel($excelFilePath) {
        try {
            $spreadsheet = IOFactory::load($excelFilePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $column1 = $worksheet->getCell('A1')->getValue();
            $column2 = $worksheet->getCell('B1')->getValue();
            $column3 = $worksheet->getCell('C1')->getValue();
            $lastRow = $worksheet->getHighestRow();
            $rows = array();
            for ($row = 2; $row <= $lastRow; $row++) {
                $rowData = array(
                    'columna_1' => $worksheet->getCell('A' . $row)->getValue(),
                    'columna_2' => $worksheet->getCell('B' . $row)->getValue(),
                    'columna_3' => $worksheet->getCell('C' . $row)->getValue(),
                );
    
                $rows[] = $rowData;
            }
            $data = array(
                'column1' => $column1,
                'column2' => $column2,
                'column3' => $column3,
                'rows' => $rows
            );
            return $data;
        } catch (Exception $e) {
            throw new Exception("Error al cargar y leer el archivo Excel: " . $e->getMessage());
        }
    }
    
    private function registrarDatosEnDB($title, $previousText, $month, $year, $excelData) {
        try {
            $dataRegistered = $this->Tables_Model->insertMainData($title, $previousText, $month, $year);
            if ($dataRegistered != 0) {
                $aditionalColumnData = array(
                    array(
                        'tabla_adicional_id' => $dataRegistered,
                        'posicion' => 1,
                        'nombre_columna' => $excelData['column1']
                    ),
                    array(
                        'tabla_adicional_id' => $dataRegistered,
                        'posicion' => 2,
                        'nombre_columna' => $excelData['column2']
                    ),
                    array(
                        'tabla_adicional_id' => $dataRegistered,
                        'posicion' => 3,
                        'nombre_columna' => $excelData['column3']
                    )
                );
                $aditionalColumnDataRegistered = $this->Tables_Model->insertAditionalColumnData($aditionalColumnData);
                if ($aditionalColumnDataRegistered) {
                    $rowAditionalData = array();
                    foreach ($excelData['rows'] as $row) {
                        $rowData = array(
                            'tabla_adicional_id' => $dataRegistered,
                            'columna_1' => $row['columna_1'],
                            'columna_2' => $row['columna_2'],
                            'columna_3' => $row['columna_3']
                        );
    
                        $rowAditionalData[] = $rowData;
                    }
                    $rowAditionalDataRegistered = $this->Tables_Model->insertAditionalRowData($rowAditionalData);
                    if ($rowAditionalDataRegistered) {
                        return true;
                    }
                }
            }
    
            return false;
        } catch (Exception $e) {
            throw new Exception("Error al registrar los datos en la base de datos: " . $e->getMessage());
        }
    }
    
    public function previewTable(){
        $data['data'] = $this->Tables_Model->selectColumnViewData();
        $this->load->view('preview_table.php', $data);
    }

    public function viewExcel($id){
        $data['tableData'] = $this->Tables_Model->getExcelTable($id);
        $this->load->view('table_view', $data);
    }
}