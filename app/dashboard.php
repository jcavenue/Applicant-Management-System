<?php
	namespace app;

	class Dashboard {

		private $data = [];
		private $conn;
		private $username;

		public function __construct($conn, $user_id){
			$this->conn = $conn;
			$this->user_id = $user_id;
		}

		private function getData(){
			
			try {
				$this->conn->beginTransaction();

				$sql = "SELECT descriptions.code as code, COUNT(description_id) as total
					FROM applicant 
					JOIN descriptions ON description_id = descriptions.id 
					WHERE hr_id =:user_id
					GROUP BY descriptions.code";

				$stmt = $this->conn->prepare($sql);
				$stmt->execute(['user_id'=>$this->user_id]);

				while($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
					$this->data[$row['code']]  = $row['total'];
				}

				$sql = "SELECT disposition.code as code, COUNT(disposition_id) as total
						FROM process 
						JOIN disposition ON disposition_id = disposition.id 
						JOIN applicant ON applicant_id = applicant.id
						WHERE hr_id =:user_id
						GROUP BY disposition.code";

				$stmt = $this->conn->prepare($sql);
				$stmt->execute(['user_id'=>$this->user_id]);

				while($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
					$this->data[$row['code']]  = $row['total'];
				}

				$this->conn->commit();
			} catch (\PDOException $e) {
				$this->conn->rollBack();
				throw $e;
			}
		}

		public function getDetails(){
			$this->getData();
			return $this->data;
		}
	}

?>