<?php
require_once __DIR__.'/../../config.php';
require_once __DIR__.'/../../Model/notification.php';

$db = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
$notificationModel = new Notification($db);
$notifications = $notificationModel->getNotificationsNonLues();
?>

<div class="notifications-container">
    <h2>Notifications</h2>
    <?php if (empty($notifications)): ?>
        <p>Aucune nouvelle notification</p>
    <?php else: ?>
        <ul class="notification-list">
            <?php foreach ($notifications as $notif): ?>
                <li>
                    <a href="<?= htmlspecialchars($notif['lien']) ?>">
                        <?= htmlspecialchars($notif['message']) ?>
                    </a>
                    <span class="notification-date">
                        <?= date('d/m/Y H:i', strtotime($notif['created_at'])) ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>