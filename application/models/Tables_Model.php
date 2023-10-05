<?php

class Tables_Model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	public function insertMainData($title,$previousText,$month,$year){
		$data = array(
		 'titulo' => $title,
		 'texto_previo' => $previousText,
		 'mes' => $month,
		 'anio' => $year
	   );
	   if($this->db->insert('tabla_adicional_expensa', $data)){
		 return $this->db->insert_id();
	   }else{
		 return 0;
	   }
	}

	public function insertAditionalColumnData($data){
		if($this->db->insert_batch('columna_tabla_adicional', $data)){
			return TRUE;
		  }else{
			return FALSE;
		  }
	}

	public function insertAditionalRowData($data){
		if($this->db->insert_batch('fila_tabla_adicional', $data)){
			return TRUE;
		  }else{
			return FALSE;
		  }
	}

	public function selectColumnViewData(){
		$results = array();
		$tableResult = $this->db->get('tabla_adicional_expensa')->result();
		foreach ($tableResult as $result){
			$resultForArray = array(
				'id' => $result->id,
				'title' => $result->titulo,
				'month' => $result->mes,
				'year' => $result->anio,
				'previousText' => $result->texto_previo,
				'columns' => $this->getColumns($result->id)
			);
			array_push($results, $resultForArray);
		}
		return $results;
	}

	public function getExcelTable($tableId){
		$data = array(
			'columns' => $this->getColumns($tableId),
			'rows' => $this->getRows($tableId)
		);
		return $data;
	}

	private function getColumns($tableId){
		$this->db->where('tabla_adicional_id', $tableId);
		$this->db->order_by('posicion', 'ASC');
        $columns = $this->db->get('columna_tabla_adicional')->result();
		return $columns;
	}

	private function getRows($tableId){
		$this->db->where('tabla_adicional_id', $tableId);
		$this->db->select('columna_1, columna_2, columna_3');
		$rows = $this->db->get('fila_tabla_adicional')->result();
		return $rows;
	}
}