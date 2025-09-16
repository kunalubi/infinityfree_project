<?php include '../header.php'; ?>

<div class="tool-grid" style="margin: 100px;" >
                <?php
                $tools = [
                    [
                        'name' => 'Image Converter',
                        'desc' => 'Create beautiful color schemes for your projects with our advanced palette tool.',
                        'icon' => 'fas fa-image',
                        'category' => 'design',
                        'link' => 'imageconvert.php'
                    ],
                    [
                        'name' => 'Image Resizer',
                        'desc' => 'Generate strong, secure passwords with customizable options for all your accounts.',
                        'icon' => 'fas fa-image',
                        'category' => 'design',
                        'link' => 'imageresizer.php'
                    ],
                    
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
 <?php include '../footer.php'; ?>  