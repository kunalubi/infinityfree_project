
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #7209b7;
            --accent: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --success: #4cc9f0;
            --border-radius: 12px;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--dark);
            line-height: 1.6;
            background-color: #fafbff;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
            border-radius: 0 0 var(--border-radius) var(--border-radius);
            margin-bottom: 60px;
        }
        
        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .hero p {
            font-size: 1.25rem;
            margin-bottom: 40px;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .hero-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        .btn {
            display: inline-block;
            padding: 14px 32px;
            background: white;
            color: var(--primary);
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: var(--shadow);
            border: 2px solid transparent;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            background: var(--primary-dark);
            color: white;
        }
        
        /* Section Headings */
        h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 50px;
            color: var(--dark);
            position: relative;
            padding-bottom: 15px;
        }
        
        h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 2px;
        }
        
        /* Tools Overview */
        .tools-overview {
            padding: 60px 0;
        }
        
        .tool-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }
        
        .tool-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 40px 30px;
            text-align: center;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .tool-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .tool-card h3 {
            font-size: 1.5rem;
            margin: 20px 0 15px;
            color: var(--primary-dark);
        }
        
        .tool-card h3 i {
            margin-right: 10px;
            color: var(--primary);
        }
        
        .tool-card p {
            color: var(--gray);
            margin-bottom: 25px;
        }
        
        .tool-card .btn {
            padding: 10px 24px;
            font-size: 0.9rem;
            background: var(--primary);
            color: white;
        }
        
        .tool-card .btn:hover {
            background: var(--primary-dark);
        }
        
        /* Features Section */
        .features {
            background: linear-gradient(to bottom, #f9fafe, #ffffff);
            padding: 80px 0;
            border-radius: var(--border-radius);
            margin: 60px 0;
        }
        
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
        }
        
        .feature-card {
            text-align: center;
            padding: 30px;
        }
        
        .feature-card i {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 25px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--dark);
        }
        
        .feature-card p {
            color: var(--gray);
        }
        
    </style>
</head>
<body>
    <?php include "../header.php"; ?>
    
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Your Complete PDF Solution</h1>
                <p>Convert, edit, compress, and secure your PDF files with our powerful online tools. No installation required.</p>
                <div class="hero-buttons">
                    <a href="<?php echo base_url('pdf-tools/convert'); ?>" class="btn">Convert PDF</a>
                    <a href="<?php echo base_url('pdf-tools/edit'); ?>" class="btn">Edit PDF</a>
                </div>
            </div>
        </div>
    </section>

    <section class="tools-overview">
        <div class="container">
            <h2>Our PDF Tools</h2>
            <div class="tool-grid">
                <div class="tool-card">
                    <h3><i class="fas fa-exchange-alt"></i> Convert PDF</h3>
                    <p>Convert your PDF files to Word, Excel, JPG, PNG and more.</p>
                    <a href="<?php echo base_url('pdf-tools/convert'); ?>" class="btn">Try Now</a>
                </div>
                <div class="tool-card">
                    <h3><i class="fas fa-edit"></i> Edit PDF</h3>
                    <p>Edit your PDF files by adding text, images, and more.</p>
                    <a href="<?php echo base_url('pdf-tools/edit'); ?>" class="btn">Try Now</a>
                </div>
                <div class="tool-card">
                    <h3><i class="fas fa-compress-alt"></i> Compress PDF</h3>
                    <p>Reduce PDF file size while maintaining quality.</p>
                    <a href="<?php echo base_url('pdf-tools/compress'); ?>" class="btn">Try Now</a>
                </div>
                <div class="tool-card">
                    <h3><i class="fas fa-lock"></i> Secure PDF</h3>
                    <p>Protect your PDF with passwords and permissions.</p>
                    <a href="<?php echo base_url('pdf-tools/security'); ?>" class="btn">Try Now</a>
                </div>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <h2>Why Choose K&S PDF Tools?</h2>
            <div class="feature-grid">
                <div class="feature-card">
                    <i class="fas fa-bolt"></i>
                    <h3>Fast Processing</h3>
                    <p>Our tools work quickly to process your files without keeping you waiting.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-lock"></i>
                    <h3>Secure</h3>
                    <p>Your files are protected and never stored longer than necessary.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-desktop"></i>
                    <h3>No Installation</h3>
                    <p>Everything works in your browser - no software to download or install.</p>
                </div>
            </div>
        </div>
    </section>
    
    <?php include "../footer.php"; ?>
</body>
</html>