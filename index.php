<?php include 'header.php'; ?>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1 class="title-font">Free Tools for Everyone</h1>
                        <p>Discover our magical collection of completely free online tools for developers, designers, students, and creative minds! No registration, no fees, no limits.</p>
                        <div class="hero-buttons">
                            <a href="#tools" class="btn btn-primary">Explore Tools</a>
                            <a href="#features" class="btn btn-outline-primary">Learn More</a>
                        </div>
                        <div class="stats mt-4">
                            <div class="stat-item">
                                <span class="stat-number" data-count="50">0</span>+
                                <span class="stat-label">Tools</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number" data-count="10000">0</span>+
                                <span class="stat-label">Users</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number" data-count="24">0</span>/7
                                <span class="stat-label">Availability</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="https://illustrations.popsy.co/amber/app-launch.svg" alt="Hero Illustration" class="img-fluid floating">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-title">
                <h2 class="title-font">Why Choose Our Tools</h2>
                <p>We provide high-quality, easy-to-use tools that make your life easier and more productive.</p>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon icon-1">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h3>Lightning Fast</h3>
                        <p>Our tools are optimized for speed, delivering instant results without any lag or delay.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon icon-2">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h3>100% Secure</h3>
                        <p>All processing happens in your browser. We don't store any of your data on our servers.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon icon-3">
                            <i class="fas fa-gem"></i>
                        </div>
                        <h3>Premium Quality</h3>
                        <p>Enjoy premium features without paying a dime. We believe in free access to great tools.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon icon-4">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3>User Friendly</h3>
                        <p>Clean, intuitive interfaces designed for both beginners and professionals.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon icon-5">
                            <i class="fas fa-sync-alt"></i>
                        </div>
                        <h3>Regular Updates</h3>
                        <p>We constantly improve our tools based on user feedback and the latest technologies.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon icon-6">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3>Community Support</h3>
                        <p>Join our growing community of users who help each other and share creative ideas.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tools Section -->
    <section class="tools" id="tools">
        <div class="container">
            <div class="section-title">
                <h2 class="title-font">Our Popular Tools</h2>
                <p>Explore our most loved tools that thousands of users rely on every day.</p>
            </div>
            
            <div class="tool-filter mb-5">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary filter-btn active" data-filter="all">All</button>
                    <button type="button" class="btn btn-outline-primary filter-btn" data-filter="developer">Pdf Tools</button>
                    <button type="button" class="btn btn-outline-primary filter-btn" data-filter="design">Design</button>
                    <button type="button" class="btn btn-outline-primary filter-btn" data-filter="productivity">Productivity</button>
                </div>
                <div class="search-box ms-3 d-inline-block">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search tools..." id="toolSearch">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
            
            <div class="tool-grid">
                <?php
                $tools = [
                    [
                        'name' => 'Color Palette Generator',
                        'desc' => 'Create beautiful color schemes for your projects with our advanced palette tool.',
                        'icon' => 'fas fa-palette',
                        'category' => 'design',
                        'link' => 'colorpalette'
                    ],
                    [
                        'name' => 'Password Generator',
                        'desc' => 'Generate strong, secure passwords with customizable options for all your accounts.',
                        'icon' => 'fas fa-key',
                        'category' => 'design',
                        'link' => 'passwordgenerator'
                    ],
                    [
                        'name' => 'Pdf Converter',
                        'desc' => 'Convert PDF files to various formats quickly and easily.',
                        'icon' => 'fas fa-exchange-alt',
                        'category' => 'developer',
                        'link' => 'pdf-tools/convert'
                    ],
                    // [
                    //     'name' => 'JSON Formatter',
                    //     'desc' => 'Validate, format, and beautify your JSON data with our powerful tool.',
                    //     'icon' => 'fas fa-code',
                    //     'category' => 'developer',
                    //     'link' => '#'
                    // ],
                    [
                        'name' => 'Compress pdf',
                        'desc' => 'Reduce the file size of your PDF documents without losing quality.',
                        'icon' => 'fas fa-compress',
                        'category' => 'developer',
                        'link' => 'pdf-tools/compress'
                    ],
                    [
                        'name' => 'Images Tools',
                        'desc' => 'Transform text between uppercase, lowercase, camelCase and more formats.',
                        'icon' => 'fas fa-image',
                        'category' => 'developer',
                        'link' => 'img-tools'
                    ],
                    [
                        'name' => 'Base64 Encoder',
                        'desc' => 'Encode and decode Base64 strings quickly and easily.',
                        'icon' => 'fas fa-lock',
                        'category' => 'developer',
                        'link' => '#'
                    ],
                    [
                        'name' => 'Markdown Editor',
                        'desc' => 'Live preview Markdown as you type with this handy editor.',
                        'icon' => 'fas fa-markdown',
                        'category' => 'productivity',
                        'link' => '#'
                    ],
                    [
                        'name' => 'Lorem Ipsum Generator',
                        'desc' => 'Generate placeholder text for your designs and mockups.',
                        'icon' => 'fas fa-paragraph',
                        'category' => 'design',
                        'link' => '#'
                    ]
                ];
                
                foreach ($tools as $tool) {
                    echo '
                    <div class="tool" data-category="'.$tool['category'].'">
                        <i class="'.$tool['icon'].' tool-icon"></i>
                        <h4 class="tool-name">'.$tool['name'].'</h4>
                        <p class="tool-desc">'.$tool['desc'].'</p>
                        <a href="'.$tool['link'].'" class="btn btn-sm btn-primary mt-2">Use Tool</a>
                        <div class="tool-hover">
                            <div class="tool-hover-content">
                                <h5>'.$tool['name'].'</h5>
                                <p>'.$tool['desc'].'</p>
                                <a href="'.$tool['link'].'" class="btn btn-primary">Try Now</a>
                            </div>
                        </div>
                    </div>';
                }
                ?>
            </div>
            
            <div class="text-center mt-5">
                <a href="#" class="btn btn-outline-primary">View All Tools</a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="container">
            <div class="section-title">
                <h2 class="title-font">What Our Users Say</h2>
                <p>Don't just take our word for it - hear from our satisfied users.</p>
            </div>
            
            <div class="testimonial-slider">
                <div class="testimonial-item">
                    <div class="testimonial-content">
                        <div class="testimonial-text">
                            <i class="fas fa-quote-left quote-icon"></i>
                            <p>These tools have saved me countless hours of work. The JSON formatter is my absolute favorite - it's become an essential part of my workflow.</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Sarah J." class="author-img">
                            <div class="author-info">
                                <h5>Sarah J.</h5>
                                <span>Frontend Developer</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-item">
                    <div class="testimonial-content">
                        <div class="testimonial-text">
                            <i class="fas fa-quote-left quote-icon"></i>
                            <p>As a designer, I use the color palette generator daily. It's so intuitive and helps me create perfect color schemes for all my projects.</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Michael T." class="author-img">
                            <div class="author-info">
                                <h5>Michael T.</h5>
                                <span>UI/UX Designer</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-item">
                    <div class="testimonial-content">
                        <div class="testimonial-text">
                            <i class="fas fa-quote-left quote-icon"></i>
                            <p>I was skeptical about free tools at first, but K&S Tools have proven to be as good as any paid alternatives. The password generator is fantastic!</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Emily R." class="author-img">
                            <div class="author-info">
                                <h5>Emily R.</h5>
                                <span>IT Consultant</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <div class="cta-content">
                <h2 class="title-font">Ready to Boost Your Productivity?</h2>
                <p>Join thousands of happy users who save time with our free tools every day.</p>
                <div class="cta-buttons">
                    <a href="#tools" class="btn btn-light">Explore All Tools</a>
                    <a href="#" class="btn btn-outline-light">Sign Up for Updates</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top" title="Go to top">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="script.js"></script>
</body>
</html>