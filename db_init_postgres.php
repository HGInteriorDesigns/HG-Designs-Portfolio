<?php
// db_init_postgres.php - PostgreSQL database setup for Neon
require_once __DIR__ . '/vendor/autoload.php';

$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: 5432;
$dbname = getenv('DB_DATABASE') ?: 'neondb';
$username = getenv('DB_USERNAME') ?: 'postgres';
$password = getenv('DB_PASSWORD') ?: '';

try {
    $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
    $pdo = new \PDO($dsn, $username, $password);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

    echo "Connecting to Neon PostgreSQL at: {$host}:{$port}/{$dbname}\n";

    // 1. Drop existing tables to ensure clean setup
    $pdo->exec("DROP TABLE IF EXISTS users CASCADE");
    $pdo->exec("DROP TABLE IF EXISTS settings CASCADE");
    $pdo->exec("DROP TABLE IF EXISTS projects CASCADE");
    $pdo->exec("DROP TABLE IF EXISTS messages CASCADE");

    // 2. Create Users table
    $pdo->exec("CREATE TABLE users (
        id SERIAL PRIMARY KEY,
        username TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL
    )");

    // 3. Create Settings table
    $pdo->exec("CREATE TABLE settings (
        id SERIAL PRIMARY KEY,
        tagline TEXT,
        description TEXT,
        about_lead TEXT,
        about_body TEXT,
        about_quote TEXT,
        about_cite TEXT,
        email TEXT,
        location TEXT
    )");

    // 4. Create Projects table
    $pdo->exec("CREATE TABLE projects (
        id SERIAL PRIMARY KEY,
        slug TEXT NOT NULL UNIQUE,
        title TEXT NOT NULL,
        description TEXT,
        area TEXT,
        location_name TEXT,
        materials TEXT,
        image_after TEXT,
        image_before TEXT
    )");

    // 5. Create Messages table
    $pdo->exec("CREATE TABLE messages (
        id SERIAL PRIMARY KEY,
        name TEXT NOT NULL,
        email TEXT NOT NULL,
        project_type TEXT,
        message TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // 6. Insert Default Admin User (username: admin, password: admin123)
    $passwordHash = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute(['admin', $passwordHash]);

    // 7. Insert Default Settings
    $stmt = $pdo->prepare("INSERT INTO settings (tagline, description, about_lead, about_body, about_quote, about_cite, email, location) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        'Crafting spaces that tell your story.',
        'Specializing in warm minimalist and Japandi designs that blend high functionality with natural textures, creating calming retreats from the modern world.',
        'My journey into interior design began with a simple belief: our homes should be safe sanctuaries that reflect who we are, grounding us through natural materials and deliberate planning.',
        'I design with restraint, focusing on clean lines, organic textures, and warm, tactile materials like linen, white oak, and brushed limestone. Each piece is chosen for its utility, comfort, and quiet beauty. I aim to create environments where you can breathe, relax, and feel fully at ease.',
        'The details are not the details. They make the design.',
        '— Charles Eames',
        'hello@jatin.designs',
        'New Delhi, India'
    ]);

    // 8. Insert Default Projects
    $stmt = $pdo->prepare("INSERT INTO projects (slug, title, description, area, location_name, materials, image_after, image_before) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Living Room
    $stmt->execute([
        'living-room',
        'The Living Sanctuary',
        'The design concept centered on maximizing natural light and replacing cold, unfinished concrete walls with smooth warm plaster, linen drapery, and white oak accents. The furniture layout encourages conversation and relaxation, anchoring the space with a custom organic boucle sofa.',
        '450 sq. ft.',
        'Urban Heights',
        'White Oak, Linen, Bouclé, Travertine',
        'assets/hero_living_room.png',
        'assets/before_living_room.png'
    ]);

    // Kitchen
    $stmt->execute([
        'kitchen',
        'The Culinary Haven',
        'Designed to hide clutter and emphasize beautiful textures. Features custom light oak cabinetry, integrated hidden appliances, and high-contrast white marble countertops. A central kitchen island serves as both a prep station and a casual dining spot.',
        '250 sq. ft.',
        'Urban Heights',
        'Oak, Carrara Marble, Brushed Brass',
        'assets/kitchen_design.png',
        null
    ]);

    // Bedroom
    $stmt->execute([
        'bedroom',
        'The Serene Retreat',
        'An exercise in absolute minimalism. The low platform bed draws inspiration from traditional Japanese tatami layout. Textured neutral plaster walls catch the daylight beautifully, and soft warm pendant lighting provides a cozy atmosphere in the evening.',
        '320 sq. ft.',
        'Urban Heights',
        'Linen, Natural Pine, Plaster, Washi Paper',
        'assets/bedroom_design.png',
        null
    ]);

    echo "Neon PostgreSQL database initialized and seeded successfully!\n";
} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
