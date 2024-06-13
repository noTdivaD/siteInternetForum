<?php
class CollegeExpertsModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAllFAQs() {
        $query = "SELECT * FROM college_experts_faq";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFAQById($id) {
        $query = "SELECT * FROM college_experts_faq WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addFAQ($question, $answer) {
        $query = "INSERT INTO college_experts_faq (question, answer, created_at, updated_at) VALUES (:question, :answer, NOW(), NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':question', $question, PDO::PARAM_STR);
        $stmt->bindParam(':answer', $answer, PDO::PARAM_STR);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function deleteFAQ($id) {
        $sql = "DELETE FROM college_experts_faq WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function getAllExperts() {
        $query = "SELECT * FROM college_experts_expert";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getExpertById($id) {
        $query = "SELECT * FROM college_experts_expert WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addExpert($titre, $description, $phone, $email, $image_url = null) {
        $query = "INSERT INTO college_experts_expert (titre, description, phone, email, image_url, created_at, updated_at) VALUES (:titre, :description, :phone, :email, :image_url, NOW(), NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':image_url', $image_url, PDO::PARAM_STR);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function updateExpert($id, $titre, $description, $phone, $email, $image_url = null) {
        $query = "UPDATE college_experts_expert SET titre = :titre, description = :description, phone = :phone, email = :email, updated_at = NOW()";
        if ($image_url !== null) {
            $query .= ", image_url = :image_url";
        }
        $query .= " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        if ($image_url !== null) {
            $stmt->bindParam(':image_url', $image_url, PDO::PARAM_STR);
        }
        return $stmt->execute();
    }

    public function deleteExpert($id) {
        $sql = "DELETE FROM college_experts_expert WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>
