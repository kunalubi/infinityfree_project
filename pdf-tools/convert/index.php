<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convert PDF Files - K&S PDF Tools</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #7209b7;
            --accent: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #3b3e41ff;
            --light-gray: #e9ecef;
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
            padding-bottom: 40px;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Tool Intro */
        .tool-intro {
            text-align: center;
            padding: 60px 0 40px;
        }
        
        .tool-intro h1 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--dark);
        }
        
        .tool-intro p {
            font-size: 1.2rem;
            color: var(--dark);
            max-width: 700px;
            margin: 0 auto;
        }
        
        /* Tool Grid */
        .tool-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin: 40px 0 60px;
        }
        
        .tool-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 30px;
            text-align: center;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: 1px solid var(--gray);
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .tool-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .tool-card h2 {
            font-size: 1.4rem;
            margin: 20px 0 15px;
            color: var(--primary-dark);
        }
        
        .tool-card h2 i {
            margin-right: 10px;
            color: var(--primary);
            font-size: 1.6rem;
        }
        
        .tool-card p {
            color: var(--dark);
            margin-bottom: 25px;    
            flex-grow: 1;
        }
        
        .tool-card .btn {
            padding: 12px 24px;
            font-size: 1rem;
            background: var(--primary);
            color: white;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            display: inline-block;
            border: 2px solid transparent;
            margin-top: auto;
        }
        
        .tool-card .btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        /* Converter Card */
        
        
        
   
    </style>
</head>
<body>
    <?php include '../../header.php'; ?>
    
    <div class="container" style="margin-top: 100px; margin-bottom: 100px;" >
        <div class="tool-intro">
            <h1>Convert PDF Files</h1>
            <p>Transform your PDFs into other formats or create PDFs from different file types.</p>
        </div>

        <div class="tool-grid">
            <div class="tool-card">
                <h2><i class="fas fa-file-image"></i> PDF to JPG</h2>
                <p>Convert each page of your PDF to high-quality JPG images.</p>
                <a href="to-jpg.php" class="btn">Convert to JPG</a>
            </div>
            <div class="tool-card">
                <h2><i class="fas fa-file-image"></i> PDF to PNG</h2>
                <p>Convert PDF pages to PNG images with transparent backgrounds.</p>
                <a href="to-png.php" class="btn">Convert to PNG</a>
            </div>
            <!-- <div class="tool-card">
                <h2><i class="fas fa-file-word"></i> PDF to Word</h2>
                <p>Convert PDF files to editable Word documents.</p>
                <a href="to-word.php" class="btn">Convert to Word</a>
            </div>
            <div class="tool-card">
                <h2><i class="fas fa-file-excel"></i> PDF to Excel</h2>
                <p>Extract tables from PDFs to editable Excel spreadsheets.</p>
                <a href="to-excel.php" class="btn">Convert to Excel</a>
            </div> -->
        </div>
    </div>
    
    <?php include '../../footer.php'; ?>
</body>
</html>