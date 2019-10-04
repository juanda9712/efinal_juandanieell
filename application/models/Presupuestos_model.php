<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presupuestos_model extends CI_Model {

	public function getPresupuestos(){
		$this->db->select("p.*,c.nombre,tc.nombre as tipocomprobante");
		$this->db->from("presupuestos p");
		$this->db->join("clientes c","p.cliente_id = c.id");
		$this->db->join("tipo_comprobante tc","p.tipo_comprobante_id = tc.id");
		$resultados = $this->db->get();
		if ($resultados->num_rows() > 0) {
			return $resultados->result();
		}else
		{
			return false;
		}
	}
	public function getPresupuestosbyDate($fechainicio,$fechafin){
		$this->db->select("p.*,c.nombre,tc.nombre as tipocomprobante");
		$this->db->from("presupuestos p");
		$this->db->join("clientes c","v.cliente_id = c.id");
		$this->db->join("tipo_comprobante tc","v.tipo_comprobante_id = tc.id");
		$this->db->where("p.fecha >=",$fechainicio);
		$this->db->where("p.fecha <=",$fechafin);
		$resultados = $this->db->get();
		if ($resultados->num_rows() > 0) {
			return $resultados->result();
		}else
		{
			return false;
		}
	}

	public function getPresupuesto($id){
		$this->db->select("p.*,c.nombre,c.direccion,c.telefono,c.num_documento as documento,tc.nombre as tipocomprobante");
		$this->db->from("presupuestos p");
		$this->db->join("clientes c","v.cliente_id = c.id");
		$this->db->join("tipo_comprobante tc","v.tipo_comprobante_id = tc.id");
		$this->db->where("v.id",$id);
		$resultado = $this->db->get();
		return $resultado->row();
	}

	public function getDetalle($id){
		$this->db->select("dt.*,p.codigo,p.nombre");
		$this->db->from("detalle_presupuesto dt");
		$this->db->join("productos p","dt.producto_id = p.id");
		$this->db->where("dt.presupuesto_id",$id);
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getComprobantes(){
		$resultados = $this->db->get("tipo_comprobante");
		return $resultados->result();
	}

	public function getComprobante($idcomprobante){
		$this->db->where("id",$idcomprobante);
		$resultado = $this->db->get("tipo_comprobante");
		return $resultado->row();
	}

	public function getproductos($valor){
		$this->db->select("id,codigo,nombre as label,precio,stock");
		$this->db->from("productos");
		$this->db->like("nombre",$valor);
		$resultados = $this->db->get();
		return $resultados->result_array();
	}

	public function save($data){
		return $this->db->insert("presupuestos",$data);
	}

	public function lastID(){
		return $this->db->insert_id();
	}

	public function updateComprobante($idcomprobante,$data){
		$this->db->where("id",$idcomprobante);
		$this->db->update("tipo_comprobante",$data);
	}

	public function save_detalle($data){
		$this->db->insert("detalle_presupuesto",$data);
	}


}