<?php
require_once 'db.php';
try {
    // Users Table – Missing Columns
    $pdo->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS referred_by INT DEFAULT NULL");
    $pdo->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS city VARCHAR(100) DEFAULT ''");
    $pdo->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS wallet_balance DECIMAL(10,2) DEFAULT 0");
    $pdo->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS manual_referral_updated BOOLEAN DEFAULT FALSE");
    $pdo->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS permissions TEXT DEFAULT '{}'");
    $pdo->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS is_super_admin BOOLEAN DEFAULT FALSE");
    $pdo->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS otp_code VARCHAR(10)");
    $pdo->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS otp_expiry TIMESTAMP");

    // Packages Table – Referral Bonus (already added but just in case)
    $pdo->exec("ALTER TABLE packages ADD COLUMN IF NOT EXISTS referral_bonus DECIMAL(10,2) DEFAULT 0");

    echo "✅ All missing columns added successfully!<br>";
    echo "Now run <strong>sync_all_from_test_to_live.php</strong> again.";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
