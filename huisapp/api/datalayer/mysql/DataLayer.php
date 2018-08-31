<?php
namespace datalayer\mysql;

class DataLayer extends \datalayer\database\DataLayer {
	private $db;

	private $meterstandenDataLayer;

	public function __construct($connectionString, $user, $password) {
		$this->db = new \PDO($connectionString, $user, $password);
		$this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		$this->db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

		parent::__construct($this->db);

		$this->meterstandenDataLayer = new \datalayer\database\MeterstandenDataLayer($this, $this->db);
	}

	public function getMeterstandenData ()  : \datalayer\IMeterstandenDataLayer {
		return $this->meterstandenDataLayer;
	}

	public function quoteIdentifier ($identifier) {
		$split = explode('.', $identifier);
		$newIdentifier = array();
		foreach($split as $str) {
			$newIdentifier[] = '`' . $str . '`';
		}

		return implode('.', $newIdentifier);
	}

}