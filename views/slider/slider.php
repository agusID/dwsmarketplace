<?php
    $sqlMainGallery     = "SELECT * FROM MsGallery WHERE GallerySection = 'main' ";
    $sqlTopGallery      = "SELECT * FROM MsGallery WHERE GallerySection = 'right top' ";
    $sqlBottomGallery   = "SELECT * FROM MsGallery WHERE GallerySection = 'right bottom' ";

    $getMainGallery = $db->query($sqlMainGallery);
    $getTopGallery = $db->query($sqlTopGallery);
    $getBottomGallery = $db->query($sqlBottomGallery);

    $pathGallery = 'assets/images/slider/';
?>
<div class="sliderContainer">
    <div class="col-7">
        <div id="slider">
            <div class="control_next"><div class="arrows next"></div></div>
            <div class="control_prev"><div class="arrows prev"></div></div>
            <ul>
                <?php
                while($rGallery = $getMainGallery->fetch_assoc()){
                ?>
                <li><img src="<?php echo $pathGallery.$rGallery['GalleryImage']; ?>" alt="Slide 3"></li>
                <?php
                }
                ?>
            </ul>  
        </div>
    </div>
    <div class="col-3">
        <ul class="slider rightTopSlider">
        <?php
        while($rTopGallery = $getTopGallery->fetch_assoc()){
        ?>
            <li><a href="#"><img src="<?php echo $pathGallery.$rTopGallery['GalleryImage']; ?>" alt="Slide 1"></a></li>
        <?php
        }
        ?>
        </ul>
        <ul class="slider rightBottomSlider">
        <?php
        while($rBottomGallery = $getBottomGallery->fetch_assoc()){
        ?>
            <li><a href="#"><img src="<?php echo $pathGallery.$rBottomGallery['GalleryImage']; ?>" alt="Slide 1"></a></li>
        <?php
        }
        ?>
        </ul>
    </div>
</div>