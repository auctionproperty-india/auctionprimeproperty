<?php
require_once 'db.php';
try {
    // Accounting Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS account_entries (
        id SERIAL PRIMARY KEY,
        type VARCHAR(20) NOT NULL CHECK (type IN ('income', 'expense')),
        amount DECIMAL(10,2) NOT NULL,
        description TEXT NOT NULL,
        category VARCHAR(100) NOT NULL,
        entry_date DATE NOT NULL DEFAULT CURRENT_DATE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Add missing columns to users
    $pdo->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS city VARCHAR(100) DEFAULT ''");
    $pdo->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS wallet_balance DECIMAL(10,2) DEFAULT 0");
    $pdo->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS manual_referral_updated BOOLEAN DEFAULT FALSE");

    // Add missing columns to packages
    $pdo->exec("ALTER TABLE packages ADD COLUMN IF NOT EXISTS referral_bonus DECIMAL(10,2) DEFAULT 0");

    echo "✅ Database Updated to v5! <br>";
    echo "- account_entries table created.<br>";
    echo "- city, wallet_balance added to users.<br>";
    echo "- referral_bonus added to packages.<br>";
    echo "<a href='update_db_wallet.php' class='btn btn-primary mt-3'>Next: Run update_db_wallet.php</a>";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
