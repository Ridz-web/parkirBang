<?php
/**
 * Log user activity to database
 * 
 * @param PDO $db Database connection
 * @param int $user_id User ID performing the action
 * @param string $aktivitas Description of the activity
 * @return bool Success status
 */
function log_activity($db, $user_id, $aktivitas) {
    try {
        $stmt = $db->prepare(
            "INSERT INTO log_aktivitas(user_id, aktivitas, waktu) 
             VALUES(?, ?, datetime('now'))"
        );
        return $stmt->execute([$user_id, $aktivitas]);
    } catch (PDOException $e) {
        return false;
    }
}
