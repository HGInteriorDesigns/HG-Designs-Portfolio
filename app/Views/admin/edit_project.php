<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEdit ? 'Edit Project' : 'New Project' ?> | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg: #F7F5F0; --bg-card: #FFFFFF; --bg-sidebar: #1C1B1A;
            --text: #252422; --text-muted: #6B6862; --accent: #A38B72;
            --accent-hover: #8C7560; --border: #E8E4DE; --danger: #C0392B;
            --font: 'Inter', sans-serif; --heading-font: 'Playfair Display', serif;
            --shadow: 0 2px 12px rgba(37,36,34,0.06);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font); background: var(--bg); color: var(--text); display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: 260px; min-height: 100vh; background: var(--bg-sidebar); color: #F4F1EA;
            display: flex; flex-direction: column; position: fixed; top: 0; left: 0; z-index: 100;
        }
        .sidebar-brand { padding: 28px 24px; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .sidebar-brand .logo { font-family: var(--heading-font); font-size: 1.3rem; font-weight: 700; color: #F4F1EA; text-decoration: none; }
        .sidebar-brand .logo span { color: var(--accent); font-weight: 400; }
        .sidebar-brand small { display: block; color: rgba(244,241,234,0.45); font-size: 0.72rem; letter-spacing: 0.12em; text-transform: uppercase; margin-top: 4px; }
        .sidebar-nav { flex: 1; padding: 16px 0; }
        .sidebar-nav a {
            display: flex; align-items: center; gap: 12px; padding: 12px 24px;
            color: rgba(244,241,234,0.7); font-size: 0.9rem; text-decoration: none;
            transition: all 0.2s; border-left: 3px solid transparent;
        }
        .sidebar-nav a:hover, .sidebar-nav a.active { color: #F4F1EA; background: rgba(163,139,114,0.12); border-left-color: var(--accent); }
        .sidebar-nav a i { width: 18px; text-align: center; }
        .sidebar-footer { padding: 20px 24px; border-top: 1px solid rgba(255,255,255,0.08); }
        .sidebar-footer a { display: flex; align-items: center; gap: 10px; color: rgba(244,241,234,0.55); font-size: 0.85rem; text-decoration: none; }
        .sidebar-footer a:hover { color: #F4F1EA; }

        /* Main */
        .main-content { margin-left: 260px; flex: 1; }
        .topbar {
            background: var(--bg-card); border-bottom: 1px solid var(--border);
            padding: 18px 32px; display: flex; align-items: center; gap: 16px;
        }
        .topbar h1 { font-family: var(--heading-font); font-size: 1.5rem; font-weight: 600; }
        .page-content { padding: 32px; }

        /* Card & Form */
        .section-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 6px; box-shadow: var(--shadow); overflow: hidden; }
        .section-header { padding: 18px 24px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .section-header h2 { font-family: var(--heading-font); font-size: 1.2rem; font-weight: 600; }
        .section-body { padding: 28px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group.full-width { grid-column: 1 / -1; }
        label { font-size: 0.8rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.07em; color: var(--text-muted); }
        input[type="text"], input[type="file"], textarea {
            padding: 11px 14px; border: 1px solid var(--border); border-radius: 3px;
            font-family: var(--font); font-size: 0.9rem; color: var(--text); background: var(--bg);
            transition: border-color 0.2s, box-shadow 0.2s; outline: none;
        }
        input[type="file"] { padding: 8px; }
        input:focus, textarea:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(163,139,114,0.15); }
        textarea { resize: vertical; min-height: 90px; }
        .error-text { color: var(--danger); font-size: 0.8rem; margin-top: 2px; }
        .form-actions { margin-top: 28px; display: flex; gap: 12px; }
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; font-family: var(--font); font-size: 0.85rem; font-weight: 500; border: none; border-radius: 3px; cursor: pointer; text-decoration: none; transition: all 0.2s; }
        .btn-primary { background: var(--text); color: #FFF; }
        .btn-primary:hover { background: var(--accent); }
        .btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text); }
        .btn-outline:hover { border-color: var(--accent); color: var(--accent); }
        .current-img { margin-top: 8px; display: flex; align-items: center; gap: 10px; }
        .current-img img { width: 80px; height: 60px; object-fit: cover; border-radius: 3px; border: 1px solid var(--border); }
        .current-img span { font-size: 0.8rem; color: var(--text-muted); }
        .hint { font-size: 0.78rem; color: var(--text-muted); margin-top: 4px; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-brand">
            <a href="<?= base_url() ?>" class="logo">JATIN<span>.DESIGNS</span></a>
            <small>Admin Dashboard</small>
        </div>
        <nav class="sidebar-nav">
            <a href="<?= base_url('admin/dashboard') ?>"><i class="fa-solid fa-gauge"></i> Dashboard</a>
            <a href="<?= base_url('admin/dashboard') ?>#projects-section" class="active"><i class="fa-solid fa-image"></i> Projects</a>
            <a href="<?= base_url() ?>" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i> View Portfolio</a>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= base_url('admin/logout') ?>"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </div>
    </aside>

    <div class="main-content">
        <div class="topbar">
            <a href="<?= base_url('admin/dashboard') ?>" style="color: var(--text-muted); font-size: 0.85rem; text-decoration: none;"><i class="fa-solid fa-arrow-left"></i> Back</a>
            <h1><?= $isEdit ? 'Edit Project' : 'Add New Project' ?></h1>
        </div>

        <div class="page-content">
            <div class="section-card">
                <div class="section-header">
                    <h2><?= $isEdit ? esc($project['title']) : 'New Room Showcase' ?></h2>
                    <?php if ($isEdit): ?>
                        <span style="font-size:0.8rem; color: var(--text-muted);">ID: #<?= $project['id'] ?></span>
                    <?php endif; ?>
                </div>
                <div class="section-body">
                    <?php if (!empty($errors)): ?>
                        <?php foreach ($errors as $err): ?>
                            <div style="background:rgba(192,57,43,0.1); border: 1px solid rgba(192,57,43,0.2); color: var(--danger); padding: 10px 16px; border-radius: 3px; margin-bottom: 16px; font-size:0.88rem;">
                                <i class="fa-solid fa-circle-exclamation"></i> <?= esc($err) ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <form action="<?= $isEdit ? base_url('admin/project/' . $project['id']) : base_url('admin/project/add') ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="title">Room / Space Title</label>
                                <input type="text" id="title" name="title" value="<?= esc($project['title'] ?? '') ?>" placeholder="e.g. The Living Sanctuary" required>
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug (tab identifier)</label>
                                <input type="text" id="slug" name="slug" value="<?= esc($project['slug'] ?? '') ?>" placeholder="e.g. living-room" required>
                                <span class="hint">Lowercase with dashes. Used to identify the portfolio tab.</span>
                            </div>
                            <div class="form-group">
                                <label for="area">Area</label>
                                <input type="text" id="area" name="area" value="<?= esc($project['area'] ?? '') ?>" placeholder="e.g. 450 sq. ft." required>
                            </div>
                            <div class="form-group">
                                <label for="location_name">Location</label>
                                <input type="text" id="location_name" name="location_name" value="<?= esc($project['location_name'] ?? '') ?>" placeholder="e.g. Urban Heights" required>
                            </div>
                            <div class="form-group full-width">
                                <label for="materials">Materials Used</label>
                                <input type="text" id="materials" name="materials" value="<?= esc($project['materials'] ?? '') ?>" placeholder="e.g. White Oak, Linen, Bouclé, Travertine" required>
                            </div>
                            <div class="form-group full-width">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" rows="4" required placeholder="Describe the design concept and materials..."><?= esc($project['description'] ?? '') ?></textarea>
                            </div>

                            <!-- Image After Upload -->
                            <div class="form-group">
                                <label for="image_after">After Image <?= $isEdit ? '(leave blank to keep current)' : '(required)' ?></label>
                                <input type="file" id="image_after" name="image_after" accept="image/*">
                                <?php if ($isEdit && !empty($project['image_after'])): ?>
                                    <div class="current-img">
                                        <img src="<?= base_url(esc($project['image_after'])) ?>" alt="Current After Image">
                                        <span>Current: <?= esc(basename($project['image_after'])) ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Image Before Upload -->
                            <div class="form-group">
                                <label for="image_before">Before Image <small style="color:var(--text-muted)">(optional — enables Before/After slider)</small></label>
                                <input type="file" id="image_before" name="image_before" accept="image/*">
                                <?php if ($isEdit && !empty($project['image_before'])): ?>
                                    <div class="current-img">
                                        <img src="<?= base_url(esc($project['image_before'])) ?>" alt="Current Before Image">
                                        <span>Current: <?= esc(basename($project['image_before'])) ?></span>
                                    </div>
                                <?php else: ?>
                                    <span class="hint">If provided, a Before/After drag slider will appear on the portfolio.</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> <?= $isEdit ? 'Save Changes' : 'Create Project' ?></button>
                            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-outline"><i class="fa-solid fa-xmark"></i> Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
