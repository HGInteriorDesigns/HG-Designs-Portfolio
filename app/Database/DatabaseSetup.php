<?php

namespace App\Database;

class DatabaseSetup
{
    public static function run()
    {
        $dbPath = WRITEPATH . 'database.sqlite';
        
        echo "Initializing SQLite database at: {$dbPath}\n";
        
        // Ensure writable directory exists
        if (!is_dir(WRITEPATH)) {
            mkdir(WRITEPATH, 0777, true);
        }

        try {
            $pdo = new \PDO("sqlite:" . $dbPath);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            // 1. Drop existing tables to ensure clean setup
            $pdo->exec("DROP TABLE IF EXISTS users");
            $pdo->exec("DROP TABLE IF EXISTS settings");
            $pdo->exec("DROP TABLE IF EXISTS projects");
            $pdo->exec("DROP TABLE IF EXISTS project_images");
            $pdo->exec("DROP TABLE IF EXISTS messages");

            // 2. Create Users table
            $pdo->exec("CREATE TABLE users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT NOT NULL UNIQUE,
                password TEXT NOT NULL
            )");

            // 3. Create Settings table
            $pdo->exec("CREATE TABLE settings (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
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
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                slug TEXT NOT NULL UNIQUE,
                title TEXT NOT NULL,
                description TEXT,
                area TEXT,
                location_name TEXT,
                materials TEXT,
                category TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )");

            // 5. Create Project Images table
            $pdo->exec("CREATE TABLE project_images (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                project_id INTEGER NOT NULL,
                image_path TEXT NOT NULL,
                image_type TEXT DEFAULT 'after',
                caption TEXT,
                sort_order INTEGER DEFAULT 0,
                FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
            )");

            // 6. Create Messages table
            $pdo->exec("CREATE TABLE messages (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                email TEXT NOT NULL,
                project_type TEXT,
                message TEXT,
                created_at DATETIME,
                updated_at DATETIME
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
            $stmt = $pdo->prepare("INSERT INTO projects (slug, title, description, area, location_name, materials, category) VALUES (?, ?, ?, ?, ?, ?, ?)");
            
            // Living Room
            $stmt->execute([
                'living-room',
                'The Living Sanctuary',
                'The design concept centered on maximizing natural light and replacing cold, unfinished concrete walls with smooth warm plaster, linen drapery, and white oak accents. The furniture layout encourages conversation and relaxation, anchoring the space with a custom organic boucle sofa.',
                '450 sq. ft.',
                'Urban Heights',
                'White Oak, Linen, Bouclé, Travertine',
                'living'
            ]);

            // Kitchen
            $stmt->execute([
                'kitchen',
                'The Culinary Haven',
                'Designed to hide clutter and emphasize beautiful textures. Features custom light oak cabinetry, integrated hidden appliances, and high-contrast white marble countertops. A central kitchen island serves as both a prep station and a casual dining spot.',
                '250 sq. ft.',
                'Urban Heights',
                'Oak, Carrara Marble, Brushed Brass',
                'kitchen'
            ]);

            // Bedroom
            $stmt->execute([
                'bedroom',
                'The Serene Retreat',
                'An exercise in absolute minimalism. The low platform bed draws inspiration from traditional Japanese tatami layout. Textured neutral plaster walls catch the daylight beautifully, and soft warm pendant lighting provides a cozy atmosphere in the evening.',
                '320 sq. ft.',
                'Urban Heights',
                'Linen, Natural Pine, Plaster, Washi Paper',
                'bedroom'
            ]);

            // 9. Insert Default Project Images
            $imageStmt = $pdo->prepare("INSERT INTO project_images (project_id, image_path, image_type, caption, sort_order) VALUES (?, ?, ?, ?, ?)");
            
            // Living Room images
            $imageStmt->execute([1, 'assets/hero_living_room.png', 'after', 'After: Warm minimalist living room', 1]);
            $imageStmt->execute([1, 'assets/before_living_room.png', 'before', 'Before: Original concrete space', 2]);
            
            // Kitchen images
            $imageStmt->execute([2, 'assets/kitchen_design.png', 'after', 'After: Modern kitchen with oak cabinetry', 1]);
            
            // Bedroom images
            $imageStmt->execute([3, 'assets/bedroom_design.png', 'after', 'After: Serene minimalist bedroom', 1]);

            echo "Database initialized and seeded successfully!\n";
        } catch (\PDOException $e) {
            echo "Database error: " . $e->getMessage() . "\n";
        }
    }
}
