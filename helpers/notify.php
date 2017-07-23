<?php

class Notifications {
    public static $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=xxlmm13xxgaming.com;dbname=xxlmm13xx_tracker;charset=utf8', 'xxlmm13xx', 'BW5gu2NMCh', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }

    public function saveNotification($message) {
        $d = new Notifications;
        $stmt = $d->db->prepare("INSERT INTO `notifications` (`message`) VALUES (?)");
        $d->db->quote($message);
        $stmt->bindParam(1, $message, PDO::PARAM_STR);
        $stmt->execute();
        $stmt = null;
    }

    public function getNotifications() {
        $d = new Notifications;
        $result = $d->db->prepare("SELECT * FROM `notifications` WHERE `unread`=?");
        $result->bindValue(1, '1', PDO::PARAM_INT);
        $result->execute();

        $rows = $result->fetchAll(PDO::FETCH_ASSOC);

        foreach($rows as $row => $link) {
            $link['message'] .= '<a id="nid" class="hidden">'.$link['id'].'</a></div>';
            echo $link['message'];
        }

        if($result->rowCount() === 0) {
            echo '<a id="non" class="dropdown-item">No new notifications</a>';
        }

        $result = null;
    }

    public function markNotificationRead($id){
        $d = new Notifications;
        $result = $d->db->prepare("UPDATE `notifications` SET `unread`=? WHERE `id`=?");
        $d->db->quote($id);
        $result->bindValue(1, 0, PDO::PARAM_INT);
        $result->bindParam(2, $id, PDO::PARAM_INT);
        $result->execute();
        $result = null;
    }
}