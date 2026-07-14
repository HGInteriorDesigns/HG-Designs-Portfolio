<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Jatin Designs</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg: #F7F5F0;
            --bg-card: #FFFFFF;
            --bg-sidebar: #1C1B1A;
            --text: #252422;
            --text-muted: #6B6862;
            --accent: #A38B72;
            --accent-hover: #8C7560;
            --border: #E8E4DE;
            --danger: #C0392B;
            --success: #27AE60;
            --warning: #D4A017;
            --font: 'Inter', sans-serif;
            --heading-font: 'Playfair Display', serif;
            --shadow: 0 2px 12px rgba(37,36,34,0.06);
            --shadow-lg: 0 8px 30px rgba(37,36,34,0.10);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font); background: var(--bg); color: var(--text); display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: var(--bg-sidebar);
            color: #F4F1EA;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
        }
        .sidebar-brand {
            padding: 28px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-brand .logo {
            font-family: var(--heading-font);
            font-size: 1.3rem;
            font-weight: 700;
            color: #F4F1EA;
            text-decoration: none;
        }
        .sidebar-brand .logo span { color: var(--accent); font-weight: 400; }
        .sidebar-brand small { display: block; color: rgba(244,241,234,0.45); font-size: 0.72rem; letter-spacing: 0.12em; text-transform: uppercase; margin-top: 4px; }
        .sidebar-nav { flex: 1; padding: 16px 0; }
        .sidebar-nav-section {
            padding: 8px 24px 4px;
            font-size: 0.68rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: rgba(244,241,234,0.35);
            margin-top: 12px;
        }
        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 24px;
            color: rgba(244,241,234,0.7);
            font-size: 0.9rem;
            font-weight: 400;
            text-decoration: none;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        .sidebar-nav a:hover, .sidebar-nav a.active {
            color: #F4F1EA;
            background: rgba(163,139,114,0.12);
            border-left-color: var(--accent);
        }
        .sidebar-nav a i { width: 18px; text-align: center; font-size: 0.95rem; }
        .sidebar-footer {
            padding: 20px 24px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-footer a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(244,241,234,0.55);
            font-size: 0.85rem;
            text-decoration: none;
            transition: color 0.2s;
        }
        .sidebar-footer a:hover { color: #F4F1EA; }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .topbar {
            background: var(--bg-card);
            border-bottom: 1px solid var(--border);
            padding: 18px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .topbar h1 {
            font-family: var(--heading-font);
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text);
        }
        .topbar-actions { display: flex; align-items: center; gap: 12px; }
        .badge-count {
            background: var(--accent);
            color: #FFF;
            border-radius: 12px;
            padding: 2px 10px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .page-content { padding: 32px; flex: 1; }

        /* Alerts */
        .alert {
            padding: 14px 20px;
            border-radius: 4px;
            margin-bottom: 24px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success { background: rgba(39,174,96,0.1); border: 1px solid rgba(39,174,96,0.25); color: var(--success); }
        .alert-error   { background: rgba(192,57,43,0.1); border: 1px solid rgba(192,57,43,0.25); color: var(--danger); }

        /* Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 36px;
        }
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 18px;
            box-shadow: var(--shadow);
        }
        .stat-icon {
            width: 50px; height: 50px;
            background: rgba(163,139,114,0.12);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: var(--accent);
            flex-shrink: 0;
        }
        .stat-num { font-size: 1.8rem; font-weight: 700; font-family: var(--heading-font); color: var(--text); }
        .stat-label { font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.06em; }

        /* Section Card */
        .section-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 6px;
            margin-bottom: 28px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }
        .section-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .section-header h2 {
            font-family: var(--heading-font);
            font-size: 1.2rem;
            font-weight: 600;
        }
        .section-body { padding: 24px; }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            font-family: var(--font);
            font-size: 0.85rem;
            font-weight: 500;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-primary   { background: var(--text); color: #FFF; }
        .btn-primary:hover { background: var(--accent); }
        .btn-accent    { background: var(--accent); color: #FFF; }
        .btn-accent:hover { background: var(--accent-hover); }
        .btn-danger    { background: rgba(192,57,43,0.1); color: var(--danger); border: 1px solid rgba(192,57,43,0.2); }
        .btn-danger:hover { background: var(--danger); color: #FFF; }
        .btn-outline   { background: transparent; border: 1px solid var(--border); color: var(--text); }
        .btn-outline:hover { border-color: var(--accent); color: var(--accent); }
        .btn-sm { padding: 6px 14px; font-size: 0.8rem; }
        .btn-block { width: 100%; justify-content: center; }

        /* Form */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 0; }
        .form-group.full-width { grid-column: 1 / -1; }
        label { font-size: 0.8rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.07em; color: var(--text-muted); }
        input[type="text"], input[type="email"], input[type="password"],
        textarea, select {
            padding: 11px 14px;
            border: 1px solid var(--border);
            border-radius: 3px;
            font-family: var(--font);
            font-size: 0.9rem;
            color: var(--text);
            background: var(--bg);
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }
        input:focus, textarea:focus, select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(163,139,114,0.15);
        }
        textarea { resize: vertical; min-height: 90px; }
        .form-actions { margin-top: 24px; display: flex; gap: 12px; }

        /* Table */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th, .data-table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            font-size: 0.88rem;
        }
        .data-table th { font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.06em; font-size: 0.75rem; background: var(--bg); }
        .data-table tr:last-child td { border-bottom: none; }
        .data-table tr:hover td { background: rgba(163,139,114,0.04); }
        .table-thumb { width: 48px; height: 40px; object-fit: cover; border-radius: 3px; border: 1px solid var(--border); }
        .table-actions { display: flex; gap: 8px; }
        .empty-state { text-align: center; padding: 40px; color: var(--text-muted); }
        .empty-state i { font-size: 2.5rem; margin-bottom: 12px; display: block; opacity: 0.4; }

        /* Project Tabs Inside Dashboard */
        .tab-nav { display: flex; border-bottom: 1px solid var(--border); margin-bottom: 24px; }
        .tab-nav button {
            background: none;
            border: none;
            padding: 12px 20px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            color: var(--text-muted);
            position: relative;
            transition: color 0.2s;
        }
        .tab-nav button.active { color: var(--accent); }
        .tab-nav button.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0; right: 0;
            height: 2px;
            background: var(--accent);
        }
        .tab-panel { display: none; }
        .tab-panel.active { display: block; }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <a href="/" class="logo">JATIN<span>.DESIGNS</span></a>
            <small>Admin Dashboard</small>
        </div>
        <nav class="sidebar-nav">
            <div class="sidebar-nav-section">Manage</div>
            <a href="#settings-section" class="active" onclick="showSection('settings')"><i class="fa-solid fa-sliders"></i> Settings</a>
            <a href="#projects-section" onclick="showSection('projects')"><i class="fa-solid fa-image"></i> Projects</a>
            <a href="#messages-section" onclick="showSection('messages')">
                <i class="fa-solid fa-inbox"></i> Messages
                <?php if (!empty($messages)): ?>
                    <span class="badge-count" style="margin-left: auto; font-size: 0.7rem;"><?= count($messages) ?></span>
                <?php endif; ?>
            </a>

            <div class="sidebar-nav-section">Portfolio</div>
            <a href="/" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i> View Portfolio</a>
        </nav>
        <div class="sidebar-footer">
            <a href="/admin/logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <div class="topbar">
            <h1>Dashboard</h1>
            <div class="topbar-actions">
                <span style="font-size: 0.85rem; color: var(--text-muted);">Welcome, <strong><?= esc(session('username')) ?></strong></span>
            </div>
        </div>

        <div class="page-content">

            <?php if ($success): ?>
                <div class="alert alert-success"><i class="fa-solid fa-check-circle"></i> <?= esc($success) ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i> <?= esc($error) ?></div>
            <?php endif; ?>

            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fa-solid fa-image"></i></div>
                    <div>
                        <div class="stat-num"><?= count($projects) ?></div>
                        <div class="stat-label">Projects</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fa-solid fa-inbox"></i></div>
                    <div>
                        <div class="stat-num"><?= count($messages) ?></div>
                        <div class="stat-label">Messages</div>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="tab-nav" id="dashboardTabs">
                <button class="active" onclick="switchTab('settings', this)">Site Settings</button>
                <button onclick="switchTab('projects', this)">Manage Projects</button>
                <button onclick="switchTab('messages', this)">Inbox Messages <?php if (!empty($messages)): ?><span class="badge-count"><?= count($messages) ?></span><?php endif; ?></button>
            </div>

            <!-- ======= SETTINGS TAB ======= -->
            <div class="tab-panel active" id="tab-settings">
                <div class="section-card">
                    <div class="section-header">
                        <h2>Portfolio Settings</h2>
                        <span style="font-size: 0.8rem; color: var(--text-muted);">Changes reflect instantly on the public website.</span>
                    </div>
                    <div class="section-body">
                        <form action="/admin/save-settings" method="POST">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="s-email">Contact Email</label>
                                    <input type="email" id="s-email" name="email" value="<?= esc($settings['email'] ?? '') ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="s-location">Location</label>
                                    <input type="text" id="s-location" name="location" value="<?= esc($settings['location'] ?? '') ?>" required>
                                </div>
                                <div class="form-group full-width">
                                    <label for="s-tagline">Hero Tagline (HTML italic tags allowed, e.g. &lt;em&gt;word&lt;/em&gt;)</label>
                                    <input type="text" id="s-tagline" name="tagline" value="<?= esc($settings['tagline'] ?? '') ?>" required>
                                </div>
                                <div class="form-group full-width">
                                    <label for="s-desc">Hero Description</label>
                                    <textarea id="s-desc" name="description"><?= esc($settings['description'] ?? '') ?></textarea>
                                </div>
                                <div class="form-group full-width">
                                    <label for="s-about-lead">About — Lead Paragraph</label>
                                    <textarea id="s-about-lead" name="about_lead"><?= esc($settings['about_lead'] ?? '') ?></textarea>
                                </div>
                                <div class="form-group full-width">
                                    <label for="s-about-body">About — Body Paragraph</label>
                                    <textarea id="s-about-body" name="about_body"><?= esc($settings['about_body'] ?? '') ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="s-quote">Inspirational Quote</label>
                                    <textarea id="s-quote" name="about_quote" rows="2"><?= esc($settings['about_quote'] ?? '') ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="s-cite">Quote Attribution</label>
                                    <input type="text" id="s-cite" name="about_cite" value="<?= esc($settings['about_cite'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Save Settings</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- ======= PROJECTS TAB ======= -->
            <div class="tab-panel" id="tab-projects">
                <div class="section-card">
                    <div class="section-header">
                        <h2>Projects</h2>
                        <a href="/admin/project/add" class="btn btn-accent btn-sm"><i class="fa-solid fa-plus"></i> New Project</a>
                    </div>
                    <div class="section-body" style="padding: 0;">
                        <?php if (!empty($projects)): ?>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Room Title</th>
                                    <th>Area</th>
                                    <th>Location</th>
                                    <th>Materials</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($projects as $project): ?>
                                <tr>
                                    <td>
                                        <img src="/<?= esc($project['image_after']) ?>" alt="" class="table-thumb">
                                    </td>
                                    <td><strong><?= esc($project['title']) ?></strong><br><small style="color: var(--text-muted)"><?= esc($project['slug']) ?></small></td>
                                    <td><?= esc($project['area']) ?></td>
                                    <td><?= esc($project['location_name']) ?></td>
                                    <td style="max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= esc($project['materials']) ?></td>
                                    <td>
                                        <div class="table-actions">
                                            <a href="/admin/project/<?= $project['id'] ?>" class="btn btn-outline btn-sm"><i class="fa-solid fa-pen"></i> Edit</a>
                                            <a href="/admin/project/delete/<?= $project['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this project?')"><i class="fa-solid fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <div class="empty-state">
                            <i class="fa-solid fa-image"></i>
                            <p>No projects yet. <a href="/admin/project/add">Add your first project.</a></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- ======= MESSAGES TAB ======= -->
            <div class="tab-panel" id="tab-messages">
                <div class="section-card">
                    <div class="section-header">
                        <h2>Inbox Messages</h2>
                        <span style="font-size: 0.8rem; color: var(--text-muted);"><?= count($messages) ?> message(s) received</span>
                    </div>
                    <div class="section-body" style="padding: 0;">
                        <?php if (!empty($messages)): ?>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Project Type</th>
                                    <th>Message</th>
                                    <th>Received</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($messages as $msg): ?>
                                <tr>
                                    <td><strong><?= esc($msg['name']) ?></strong></td>
                                    <td><a href="mailto:<?= esc($msg['email']) ?>"><?= esc($msg['email']) ?></a></td>
                                    <td><span style="text-transform: capitalize;"><?= esc($msg['project_type']) ?></span></td>
                                    <td style="max-width: 280px;"><?= nl2br(esc($msg['message'])) ?></td>
                                    <td style="white-space: nowrap; color: var(--text-muted);"><?= esc($msg['created_at']) ?></td>
                                    <td>
                                        <a href="/admin/message/delete/<?= $msg['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this message?')"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <div class="empty-state">
                            <i class="fa-solid fa-inbox"></i>
                            <p>No messages received yet. Your inbox is empty.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function switchTab(name, btn) {
            // Hide all tab panels
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.tab-nav button').forEach(b => b.classList.remove('active'));
            // Show the target tab
            document.getElementById('tab-' + name).classList.add('active');
            btn.classList.add('active');
        }

        // Auto-open tab based on URL hash
        const hash = window.location.hash;
        if (hash === '#messages-section') {
            const btn = document.querySelector('.tab-nav button:nth-child(3)');
            if (btn) switchTab('messages', btn);
        } else if (hash === '#projects-section') {
            const btn = document.querySelector('.tab-nav button:nth-child(2)');
            if (btn) switchTab('projects', btn);
        }
    </script>

</body>
</html>
