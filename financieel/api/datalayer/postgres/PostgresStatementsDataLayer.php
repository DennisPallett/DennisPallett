<?php

class PostgresStatementsDataLayer implements IStatementsDataLayer {
	private $db;

	public function __construct($db) {
		$this->db = $db;
	}

	public function getStatements ($year, $month, $sortBy, $sortOrder) {
		$bindParams = array();

		$sql = "SELECT 
			statement.*,
			(SELECT COUNT(*) FROM entry WHERE statement_id = statement.id) AS entry_count
		FROM statement
		WHERE 1=1
		";

		if (!empty($month) && is_numeric($month)) {
			$sql .= " AND date_part('month', start_balance_date) = :month";
			$bindParams[':month'] = $params['month'];
		}

		if (!empty($year) && is_numeric($year)) {
			$sql .= " AND date_part('year', start_balance_date) = :year";
			$bindParams[':year'] = $params['year'];
		}

		$sql .= " ORDER BY " . $sortBy . ' ' . $sortOrder;
		
		$statement = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$statement->execute($bindParams);

		return $statement->fetchAll();
	}

	public function deleteTransactions($month, $year) {
		$bindParams = array();

		$sql = "DELETE FROM entry WHERE statement_id IN (
			SELECT id FROM statement WHERE
				date_part('month', start_balance_date) = :month
				AND date_part('year', start_balance_date) = :year
		)";

		$bindParams[':month'] = $month;
		$bindParams[':year'] = $year;

		$statement = $this->container->db->prepare($sql);
		$statement->execute($bindParams);
	}

	public function deleteStatements($month, $year) {
		$bindParams = array();

		$sql = "DELETE FROM statement WHERE
				date_part('month', start_balance_date) = :month
				AND date_part('year', start_balance_date) = :year";

		$bindParams[':month'] = $month;
		$bindParams[':year'] = $year;

		$statement = $this->container->db->prepare($sql);
		$statement->execute($bindParams);
	}
}