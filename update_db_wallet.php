<?php
require_once 'db.php';
try {
    // Wallet Transactions Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS wallet_transactions (
        id SERIAL PRIMARY KEY,
        user_id INT REFERENCES users(id) ON DELETE CASCADE,
        amount DECIMAL(10,2) NOT NULL,
        type VARCHAR(20) NOT NULL CHECK (type IN ('credit', 'debit')),
        description TEXT NOT NULL,
        reference_id INT DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Referral Earnings Table (अगर नहीं है)
    $pdo->exec("CREATE TABLE IF NOT EXISTS user_referral_earnings (
        id SERIAL PRIMARY KEY,
        user_id INT REFERENCES users(id) ON DELETE CASCADE,
        referred_user_id INT REFERENCES users(id) ON DELETE CASCADE,
        package_id INT REFERENCES packages(id),
        amount DECIMAL(10,2) NOT NULL,
        tds_deducted DECIMAL(10,2) DEFAULT 0,
        admin_charge_deducted DECIMAL(10,2) DEFAULT 0,
        net_amount DECIMAL(10,2) DEFAULT 0,
        status VARCHAR(20) DEFAULT 'pending',
        bank_name VARCHAR(100),
        account_number VARCHAR(50),
        ifsc_code VARCHAR(20),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        paid_at TIMESTAMP
    )");

    echo "✅ Wallet System Updated! <br>";
    echo "- wallet_transactions table created.<br>";
    echo "- user_referral_earnings table created.<br>";
    echo "<a href='sync_all_from_test_to_live.php' class='btn btn-primary mt-3'>Now Run Data Sync</a>";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
