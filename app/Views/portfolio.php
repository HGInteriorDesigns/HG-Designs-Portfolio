<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($settings['location']) ?>'s Interior Design Portfolio | Warm Minimalist Spaces</title>
    <meta name="description" content="Explore bespoke, functional, and warm minimalist spaces that balance aesthetic excellence and cozy living.">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- CSS Stylesheet -->
    <link rel="stylesheet" href="/home.css">
</head>
<body>

    <!-- Header & Navigation -->
    <header id="site-header">
        <div class="header-container">
            <a href="#" class="logo">JATIN<span>.DESIGNS</span></a>
            
            <nav id="nav-menu">
                <ul>
                    <li><a href="#hero">Home</a></li>
                    <li><a href="#about">Philosophy</a></li>
                    <li><a href="#projects">Featured Project</a></li>
                    <li><a href="#process">Process</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="<?= base_url('admin') ?>" style="font-weight: 600; color: var(--accent-color);">Admin Panel</a></li>
                </ul>
            </nav>

            <div class="header-actions">
                <button id="theme-toggle" aria-label="Toggle light and dark mode">
                    <i class="fa-solid fa-moon"></i>
                </button>
                <button id="mobile-menu-toggle" aria-label="Toggle navigation menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>

        <!-- Hero Section -->
        <section id="hero">
            <div class="hero-content">
                <span class="hero-subtitle">Interior Designer & Space Curator</span>
                <h1><?= $settings['tagline'] ?></h1>
                <p><?= esc($settings['description']) ?></p>
                <div class="hero-actions">
                    <a href="#projects" class="btn primary-btn">View My Work</a>
                    <a href="#contact" class="btn secondary-btn">Let's Connect</a>
                </div>
            </div>
            <div class="hero-image-wrapper">
                <img src="<?= base_url('assets/hero_living_room.png') ?>" alt="Warm minimalist Japandi living room" id="hero-img">
                <div class="hero-badge">
                    <span class="badge-num">01</span>
                    <span class="badge-text">Inaugural Project<br>Completed</span>
                </div>
            </div>
        </section>

        <!-- About / Philosophy Section -->
        <section id="about">
            <div class="section-container">
                <div class="section-title-wrapper">
                    <span class="section-tag">Philosophy</span>
                    <h2>Simplicity is the ultimate luxury</h2>
                </div>
                <div class="about-grid">
                    <div class="about-text">
                        <p class="lead"><?= esc($settings['about_lead']) ?></p>
                        <p><?= nl2br(esc($settings['about_body'])) ?></p>
                    </div>
                    <div class="about-quote">
                        <blockquote>
                            "<?= esc($settings['about_quote']) ?>"
                        </blockquote>
                        <cite><?= esc($settings['about_cite']) ?></cite>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Project Section -->
        <section id="projects">
            <div class="section-container">
                <div class="section-title-wrapper">
                    <span class="section-tag">Featured Project</span>
                    <h2>Project Sanctuary: Modern Japandi Home</h2>
                    <p class="section-desc">My inaugural residential project. A complete redesign of a 3-bedroom urban apartment into a cohesive, warm, and light-filled minimalist oasis.</p>
                </div>

                <!-- Showcase Layout -->
                <div class="showcase-container">
                    <!-- Project Tabs Navigation -->
                    <div class="project-tabs">
                        <?php foreach ($projects as $index => $project): ?>
                            <button class="tab-btn <?= $index === 0 ? 'active' : '' ?>" data-tab="<?= esc($project['slug']) ?>">
                                <?= esc($project['title']) ?>
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <!-- Project Content Screens -->
                    <div class="project-display">
                        <?php foreach ($projects as $index => $project): ?>
                            <!-- <?= esc($project['title']) ?> Tab -->
                            <div class="tab-content <?= $index === 0 ? 'active' : '' ?>" id="<?= esc($project['slug']) ?>">
                                
                                <?php if (!empty($project['image_before'])): ?>
                                    <!-- Before / After Slider -->
                                    <div class="slider-wrapper">
                                        <div class="before-after-slider ba-slider-instance">
                                            <!-- After Image (Background) -->
                                            <img src="<?= base_url(esc($project['image_after'])) ?>" alt="After: <?= esc($project['title']) ?>" class="after-image">
                                            <!-- Before Image (Overlay) -->
                                            <div class="before-image-wrapper before-img-wrap-instance">
                                                <img src="<?= base_url(esc($project['image_before'])) ?>" alt="Before: <?= esc($project['title']) ?>" class="before-image">
                                            </div>
                                            <!-- Divider Slider Handle -->
                                            <div class="slider-handle slider-handle-instance">
                                                <div class="handle-line"></div>
                                                <div class="handle-button">
                                                    <i class="fa-solid fa-arrows-left-right"></i>
                                                </div>
                                            </div>
                                            <!-- Labels -->
                                            <span class="label label-before">Before</span>
                                            <span class="label label-after">After</span>
                                        </div>
                                        <p class="slider-hint"><i class="fa-solid fa-hand-pointer"></i> Drag the slider to compare Before & After</p>
                                    </div>
                                <?php else: ?>
                                    <!-- Regular Single Image -->
                                    <div class="project-gallery-image">
                                        <img src="<?= base_url(esc($project['image_after'])) ?>" alt="<?= esc($project['title']) ?>">
                                    </div>
                                <?php endif; ?>

                                <div class="project-details">
                                    <h3><?= esc($project['title']) ?></h3>
                                    <p><?= esc($project['description']) ?></p>
                                    <div class="project-meta">
                                        <div class="meta-item">
                                            <strong>Location</strong>
                                            <span><?= esc($project['location_name']) ?></span>
                                        </div>
                                        <div class="meta-item">
                                            <strong>Area</strong>
                                            <span><?= esc($project['area']) ?></span>
                                        </div>
                                        <div class="meta-item">
                                            <strong>Materials</strong>
                                            <span><?= esc($project['materials']) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Moodboard / Color Palette -->
                <div class="moodboard-palette">
                    <h3>Design Palette & Mood</h3>
                    <div class="palette-colors">
                        <div class="color-swatch" style="--swatch-color: #F4F1EA;">
                            <span class="color-hex">#F4F1EA</span>
                            <span class="color-name">Warm Plaster</span>
                        </div>
                        <div class="color-swatch" style="--swatch-color: #E3D9C9;">
                            <span class="color-hex">#E3D9C9</span>
                            <span class="color-name">Oatmeal Linen</span>
                        </div>
                        <div class="color-swatch" style="--swatch-color: #D2C2AD;">
                            <span class="color-hex">#D2C2AD</span>
                            <span class="color-name">White Oak</span>
                        </div>
                        <div class="color-swatch" style="--swatch-color: #8C7D70;">
                            <span class="color-hex">#8C7D70</span>
                            <span class="color-name">Travertine Stone</span>
                        </div>
                        <div class="color-swatch text-white" style="--swatch-color: #2C2C2B;">
                            <span class="color-hex">#2C2C2B</span>
                            <span class="color-name">Charcoal Accent</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Design Process / Services -->
        <section id="process">
            <div class="section-container">
                <div class="section-title-wrapper">
                    <span class="section-tag">How I Work</span>
                    <h2>The Design Journey</h2>
                    <p class="section-desc">My structured process ensures that your design is not only visually beautiful but also tailored to how you live.</p>
                </div>
                
                <div class="process-grid">
                    <div class="process-card">
                        <div class="process-num">01</div>
                        <h3>Discovery & Concept</h3>
                        <p>We begin with a detailed consultation to understand your spatial needs, budget, preferences, and lifestyle to establish a design direction.</p>
                    </div>
                    <div class="process-card">
                        <div class="process-num">02</div>
                        <h3>Space Planning</h3>
                        <p>I create floor plans and layouts to optimize traffic flow, furniture placement, and functionality of every square foot.</p>
                    </div>
                    <div class="process-card">
                        <div class="process-num">03</div>
                        <h3>Mood Board & Materiality</h3>
                        <p>Developing material palettes, fabrics, textures, and lighting designs to visualize the tactile feel of your future space.</p>
                    </div>
                    <div class="process-card">
                        <div class="process-num">04</div>
                        <h3>Execution & Curation</h3>
                        <p>Sourcing furniture, managing styling elements, and adding final layer decors to breathe life and personality into the completed design.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact">
            <div class="section-container">
                <div class="contact-grid">
                    <div class="contact-info">
                        <span class="section-tag">Contact</span>
                        <h2>Let's build something beautiful together</h2>
                        <p>Ready to transform your home? Or just want to discuss your design idea over coffee? Drop me a message and I'll get back to you shortly.</p>
                        
                        <div class="contact-details">
                            <div class="contact-item">
                                <i class="fa-solid fa-envelope"></i>
                                <div>
                                    <h4>Email Me</h4>
                                    <a href="mailto:<?= esc($settings['email']) ?>"><?= esc($settings['email']) ?></a>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fa-solid fa-location-dot"></i>
                                <div>
                                    <h4>Based In</h4>
                                    <span><?= esc($settings['location']) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="contact-form-wrapper">
                        <form id="contact-form" action="<?= base_url('contact/submit') ?>" method="POST">
                            <div class="form-group">
                                <label for="name">Your Name</label>
                                <input type="text" id="name" name="name" required placeholder="John Doe">
                            </div>
                            <div class="form-group">
                                <label for="email">Your Email</label>
                                <input type="email" id="email" name="email" required placeholder="john@example.com">
                            </div>
                            <div class="form-group">
                                <label for="project-type">Project Type</label>
                                <select id="project-type" name="project-type">
                                    <option value="residential">Residential Design</option>
                                    <option value="commercial">Commercial Space</option>
                                    <option value="consultation">Consultation Only</option>
                                    <option value="styling">Styling & Decoration</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea id="message" name="message" rows="5" required placeholder="Tell me about your space..."></textarea>
                            </div>
                            <button type="submit" class="btn primary-btn btn-block">Send Message <i class="fa-solid fa-arrow-right"></i></button>
                        </form>
                        <div id="form-success" class="form-status-message success-message hidden">
                            <i class="fa-solid fa-circle-check"></i>
                            <p id="success-txt">Thank you! Your message has been sent successfully.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-brand">
                <a href="#" class="logo">JATIN<span>.DESIGNS</span></a>
                <p>Creating functional, warm, and minimal interiors.</p>
            </div>
            <div class="footer-socials">
                <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" aria-label="Pinterest"><i class="fa-brands fa-pinterest"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
            </div>
            <div class="footer-copy">
                <p>&copy; 2026 Jatin Designs. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript File -->
    <script src="<?= base_url('script.js') ?>"></script>
</body>
</html>
