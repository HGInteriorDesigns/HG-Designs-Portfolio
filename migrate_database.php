<?php

namespace App\Database;

class DatabaseMigration
{
    public static function run()
    {
        $dbPath = WRITEPATH . 'database.sqlite';
        
        echo "Migrating SQLite database at: {$dbPath}\n";
        
        try {
            $pdo = new \PDO("sqlite:" . $dbPath);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            // Check if project_images table already exists
            $tableExists = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='project_images'")->fetch();
            
            if ($tableExists) {
                echo "Migration already completed. Skipping.\n";
                return;
            }

            echo "Starting migration...\n";

            // 1. Create project_images table
            $pdo->exec("CREATE TABLE project_images (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                project_id INTEGER NOT NULL,
                image_path TEXT NOT NULL,
                image_type TEXT DEFAULT 'after',
                caption TEXT,
                sort_order INTEGER DEFAULT 0,
                FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
            )");
            echo "Created project_images table\n";

            // 2. Add category column to projects table if it doesn't exist
            $columnExists = $pdo->query("PRAGMA table_info(projects)")->fetchAll();
            $hasCategory = false;
            foreach ($columnExists as $column) {
                if ($column['name'] === 'category') {
                    $hasCategory = true;
                    break;
                }
            }
            
            if (!$hasCategory) {
                $pdo->exec("ALTER TABLE projects ADD COLUMN category TEXT");
                echo "Added category column to projects table\n";
            }

            // 3. Add created_at and updated_at columns if they don't exist
            $hasCreatedAt = false;
            $hasUpdatedAt = false;
            foreach ($columnExists as $column) {
                if ($column['name'] === 'created_at') {
                    $hasCreatedAt = true;
                }
                if ($column['name'] === 'updated_at') {
                    $hasUpdatedAt = true;
                }
            }
            
            if (!$hasCreatedAt) {
                $pdo->exec("ALTER TABLE projects ADD COLUMN created_at DATETIME DEFAULT CURRENT_TIMESTAMP");
                echo "Added created_at column to projects table\n";
            }
            
            if (!$hasUpdatedAt) {
                $pdo->exec("ALTER TABLE projects ADD COLUMN updated_at DATETIME DEFAULT CURRENT_TIMESTAMP");
                echo "Added updated_at column to projects table\n";
            }

            // 4. Migrate existing image data from projects to project_images
            $projects = $pdo->query("SELECT id, image_after, image_before FROM projects")->fetchAll();
            
            $imageStmt = $pdo->prepare("INSERT INTO project_images (project_id, image_path, image_type, caption, sort_order) VALUES (?, ?, ?, ?, ?)");
            
            foreach ($projects as $project) {
                $sortOrder = 1;
                
                // Migrate image_after
                if (!empty($project['image_after'])) {
                    $imageStmt->execute([
                        $project['id'],
                        $project['image_after'],
                        'after',
                        'After: Final design',
                        $sortOrder++
                    ]);
                }
                
                // Migrate image_before
                if (!empty($project['image_before'])) {
                    $imageStmt->execute([
                        $project['id'],
                        $project['image_before'],
                        'before',
                        'Before: Original space',
                        $sortOrder++
                    ]);
                }
            }
            echo "Migrated existing image data\n";

            // 5. Remove old image columns from projects table
            // SQLite doesn't support DROP COLUMN directly, so we need to recreate the table
            $pdo->exec("CREATE TABLE projects_new (
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
            
            // Copy data to new table (excluding old image columns)
            $pdo->exec("INSERT INTO projects_new (id, slug, title, description, area, location_name, materials, category, created_at, updated_at)
                       SELECT id, slug, title, description, area, location_name, materials, category, created_at, updated_at FROM projects");
            
            // Drop old table and rename new one
            $pdo->exec("DROP TABLE projects");
            $pdo->exec("ALTER TABLE projects_new RENAME TO projects");
            
            echo "Removed old image columns from projects table\n";

            echo "Migration completed successfully!\n";
        } catch (\PDOException $e) {
            echo "Migration error: " . $e->getMessage() . "\n";
        }
    }
}

// Run migration
require_once __DIR__ . '/vendor/autoload.php';
App\Database\DatabaseMigration::run();
