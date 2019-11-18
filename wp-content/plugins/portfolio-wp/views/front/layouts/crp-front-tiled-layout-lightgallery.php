<?php

function crp_infoBox($crp_project){
    $output = "";

    if( (isset($crp_project->title) && $crp_project->title !== '' ) || (isset($crp_project->description) && $crp_project->description !== '' )){
        $output .= "<div class='lg-info'>";

        if(isset($crp_project->title) && $crp_project->title !== '' ){
            $title = CRPHelper::decode2Str($crp_project->title);
            $output .= "<h4>".$title."</h4>";
        }

        if(isset($crp_project->description) && $crp_project->description !== '' ){
            $desc = CRPHelper::decode2Str($crp_project->description);
            $output .= "<p>".$desc."</p>";
        }
        $output .= "</div>";
    }

    $output = htmlentities($output);
    $output = str_replace("\n",'</br>',$output);

    return $output;
}

$showTitle = isset($crp_portfolio->options[CRPOption::kShowTitle]) ? $crp_portfolio->options[CRPOption::kShowTitle] : false;
$showDesc = isset($crp_portfolio->options[CRPOption::kShowDesc]) ? $crp_portfolio->options[CRPOption::kShowDesc] : false;

$gridType =  isset($crp_portfolio->extoptions['type']) ? $crp_portfolio->extoptions['type'] : CRPGridType::ALBUM;

?>

<!--Link JS Files-->
<script src="<?php echo CRP_JS_URL.'/jquery/jquery.modernizr.min.js' ?>"></script>
<script src="<?php echo CRP_JS_URL.'/crp-tiled-layer.js' ?>"></script>
<script src="<?php echo CRP_JS_URL.'/jquery/jquery.lightgallery.min.js' ?>"></script>


<!--Link CSS Files-->
<link href="<?php echo CRP_CSS_URL.'/crp-tiled-layer.css' ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo CRP_CSS_URL.'/lightgallery/lightgallery.css' ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo CRP_CSS_URL.'/crp-captions.css' ?>" rel="stylesheet" type="text/css" />


<!--Here Goes CSS-->
<style>
    /* Portfolio Options Configuration Goes Here*/
    #gallery div{
        margin-left: 0px !important;
        margin-right: 0px !important;
        padding-left: 0px !important;
        padding-right: 0px !important;
        -webkit-transform: translate3d(0,0,0);
    }

  .lg-info{
    position:fixed;
    z-index:3;
    left:10px;
    top:10px;
    padding:10px;
    margin-right: 70px;
    min-width: 300px;
    max-width: 400px;
    background-color: rgba(0,0,0,0.5);
    color:#FFF; font-size:16px;
  }

  .lg-info h4,.lg-info h3,.lg-info h2 {
        color: white;
        text-transform:uppercase;
        margin: 0px;
        font-size: 17px;
        line-height: 17px;
        max-height: 40px;
        overflow: hidden;
    }

    .lg-info p {
        color: white;
        margin-top: 4px;
        font-size: 13px;
        line-height: normal;
        max-height: 100px;
        overflow: auto;
    }

    /* Portfolio Options Configuration Goes Here*/
    #gallery .tile:hover{
        cursor: <?php echo $crp_portfolio->options[CRPOption::kMouseType]; ?> !important;
    }


    /* - - - - - - - - - - - - - - -*/
    /* Tile Hover Customizations */

    /* Customize overlay background */
    #gallery .crp-tile-inner .overlay,
    #gallery .tile .caption {
        background-color: <?php echo CRPHelper::hex2rgba($crp_portfolio->options[CRPOption::kTileOverlayColor].$crp_portfolio->options[CRPOption::kTileOverlayOpacity]) ?> !important;
    }

    #gallery .crp-tile-inner.crp-details-bg .details {
        background-color: <?php echo CRPHelper::hex2rgba($crp_portfolio->options[CRPOption::kTileOverlayColor].$crp_portfolio->options[CRPOption::kTileOverlayOpacity]) ?> !important;
    }

    #gallery .crp-tile-inner .details h3 {
        color: <?php echo $crp_portfolio->options[CRPOption::kTileTitleColor] ?>;
        text-align: center;
        font-size: 18px;
    }

    #gallery .crp-tile-inner .details p {
        color: <?php echo $crp_portfolio->options[CRPOption::kTileDescColor] ?>;
        text-align: center;
        font-size: 11px;
    }

    <?php if(!$showDesc): ?>
    #gallery .crp-tile-inner .details h3 {
        margin-bottom: 0px;
    }
    <?php endif; ?>

</style>

<!--Here Goes HTML-->
<div class="crp-wrapper">
    <div id="gallery">
        <div id="ftg-items" class="ftg-items">
            <?php foreach($crp_portfolio->projects as $crp_project): ?>
                <div id="crp-tile-<?php echo $crp_project->id?>" class="tile" data-url="<?php echo isset($crp_project->url) ? $crp_project->url : ""?>">
                    <?php if ($gridType == CRPGridType::TEAM) { ?>
                    <div class="crp-tile-inner overlay00 details33 crp-details-bg">
                    <?php } elseif ($gridType == CRPGridType::CLIENT_LOGOS) { ?>
                    <div class="crp-tile-inner overlay00 details27">
                    <?php } else { ?>
                    <div class="crp-tile-inner details33 crp-details-bg">
                    <?php } ?>
                    <?php
                        $coverInfo = CRPHelper::decode2Str($crp_project->cover);
                        $coverInfo = CRPHelper::decode2Obj($coverInfo);
                        $meta = CRPHelper::getAttachementMeta($coverInfo->id, $crp_portfolio->options[CRPOption::kThumbnailQuality]);
                    ?>

                    <a id="<?php echo $crp_project->id ?>" class="tile-inner">
                        <img class="crp-item" src="<?php echo $meta['src'] ?>" data-width="<?php echo $meta['width']; ?>" data-height="<?php echo $meta['height']; ?>" />
                        <?php
                        $html = '';
                        if ($showTitle || $showDesc) {
                            $html .= "<div class='overlay'></div>";
                            $title = isset($crp_project->title) ? CRPHelper::decode2Str($crp_project->title) : "";
                            $desc = isset($crp_project->description) ? CRPHelper::decode2Str($crp_project->description) : "";
                            $desc = CRPHelper::truncWithEllipsis($desc, 15);

                            if ($title != '' || $desc != '') {
                                $html .= "<div class='details'>";
                                if ($showTitle) {
                                    $html .= "<h3>{$title}</h3>";
                                }
                                if ($showDesc) {
                                    $html .= "<p>{$desc}</p>";
                                }
                                $html .= "</div>";
                            }
                        } else {
                            $html .= '<div class="caption"></div>';
                        }
                        echo $html;
                        ?>
                    </a>
                    </div>

                    <?php if($gridType == CRPGridType::ALBUM && !$crp_portfolio->options[CRPOption::kDirectLinking]) : ?>

                    <ul id="crp-light-gallery-<?php echo $crp_project->id; ?>" class="crp-light-gallery" style="display: none;" data-sub-html="<?php echo crp_infoBox( $crp_project)?>" data-url="<?php echo isset($crp_project->url) ? $crp_project->url : ''; ?>">
                        <?php
                            $meta = CRPHelper::getAttachementMeta($coverInfo->id);
                            $metaThumb = CRPHelper::getAttachementMeta($coverInfo->id, "medium");
                        ?>

                        <li data-src="<?php echo $meta['src']; ?>" >
                            <a href="#">
                                <img src="<?php echo $metaThumb['src']; ?>" />
                            </a>
                        </li>

                        <?php foreach($crp_project->pics as $pic): ?>
                            <?php if(!empty($pic)): ?>
                                <?php
                                    $picInfo = CRPHelper::decode2Str($pic);
                                    $picInfo = CRPHelper::decode2Obj($picInfo);

                                    $meta = CRPHelper::getAttachementMeta($picInfo->id);
                                    $metaThumb = CRPHelper::getAttachementMeta($picInfo->id, "medium");
                                ?>

                                <li data-src="<?php echo $meta['src']; ?>">
                                    <a href="#">
                                        <img src="<?php echo $metaThumb['src']; ?>" />
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <?php if($gridType != CRPGridType::ALBUM && !$crp_portfolio->options[CRPOption::kDirectLinking]) : ?>
                <ul id="crp-light-gallery" class="crp-light-gallery" style="display: none;" >
                <?php foreach($crp_portfolio->projects as $crp_project): ?>
                    <?php
                        $coverInfo = CRPHelper::decode2Str($crp_project->cover);
                        $coverInfo = CRPHelper::decode2Obj($coverInfo);
                        $meta = CRPHelper::getAttachementMeta($coverInfo->id, $crp_portfolio->options[CRPOption::kThumbnailQuality]);
                        $meta = CRPHelper::getAttachementMeta($coverInfo->id);
                        $metaThumb = CRPHelper::getAttachementMeta($coverInfo->id, "medium");
                    ?>

                    <li id="crp-light-gallery-item-<?php echo $crp_project->id; ?>" data-src="<?php echo $meta['src']; ?>" data-sub-html="<?php echo crp_infoBox( $crp_project)?>" data-url="<?php echo isset($crp_project->url) ? $crp_project->url : ''; ?>">
                        <a href="#">
                            <img src="<?php echo $metaThumb['src']; ?>" />
                        </a>
                    </li>
                <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
    $approxTileWidth = ( isset($crp_portfolio->options[CRPOption::kTileApproxWidth]) && !empty($crp_portfolio->options[CRPOption::kTileApproxWidth]) ) ? $crp_portfolio->options[CRPOption::kTileApproxWidth] : 220;
    $approxTileHeight = ( isset($crp_portfolio->options[CRPOption::kTileApproxHeight]) &&  !empty($crp_portfolio->options[CRPOption::kTileApproxHeight]) ) ? $crp_portfolio->options[CRPOption::kTileApproxHeight] : 220;
    $minTileWidth = ( isset($crp_portfolio->options[CRPOption::kTileMinWidth]) && !empty($crp_portfolio->options[CRPOption::kTileMinWidth]) ) ? $crp_portfolio->options[CRPOption::kTileMinWidth] : 200;
?>

<!--Here Goes JS-->
<script>
    (function($) {

        var tileParams = {};
        if(<?php echo ($gridType == CRPGridType::CLIENT_LOGOS || $gridType == CRPGridType::TEAM) ? 1 : 0 ?>) {
            tileParams.approxTileWidth = <?php echo $approxTileWidth; ?>;
            tileParams.approxTileHeight = <?php echo $approxTileHeight; ?>;
            tileParams.minTileWidth = <?php echo $minTileWidth; ?>;
        }
        jQuery('#gallery').crpTiledLayer(tileParams);

        $( ".crp-light-gallery" ).each(function() {
          var id = $( this ).attr("id");
          $("#" + id).lightGallery({
            mode: 'slide',
            useCSS: true,
            cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
            easing: 'linear', //'for jquery animation',//
            speed: 600,
            addClass: '',

            closable: true,
            loop: true,
            auto: false,
            pause: 6000,
            escKey: true,
            controls: true,
            hideControlOnEnd: false,

            preload: 1, //number of preload slides. will exicute only after the current slide is fully loaded. ex:// you clicked on 4th image and if preload = 1 then 3rd slide and 5th slide will be loaded in the background after the 4th slide is fully loaded.. if preload is 2 then 2nd 3rd 5th 6th slides will be preloaded.. ... ...
            showAfterLoad: true,
            selector: null,
            index: false,

            lang: {
                allPhotos: 'All photos'
            },
            counter: false,

            exThumbImage: false,
            thumbnail: true,
            showThumbByDefault:false,
            animateThumb: true,
            currentPagerPosition: 'middle',
            thumbWidth: 150,
            thumbMargin: 10,


            mobileSrc: false,
            mobileSrcMaxWidth: 640,
            swipeThreshold: 50,
            enableTouch: true,
            enableDrag: true,

            vimeoColor: 'CCCCCC',
            youtubePlayerParams: false, // See: https://developers.google.com/youtube/player_parameters,
            videoAutoplay: true,
            videoMaxWidth: '855px',

            dynamic: false,
            dynamicEl: [],

            // Callbacks el = current plugin
            onOpen        : function(el) {}, // Executes immediately after the gallery is loaded.
            onSlideBefore : function(el) {}, // Executes immediately before each transition.
            onSlideAfter  : function(el) {}, // Executes immediately after each transition.
            onSlideNext   : function(el) {}, // Executes immediately before each "Next" transition.
            onSlidePrev   : function(el) {}, // Executes immediately before each "Prev" transition.
            onBeforeClose : function(el) {}, // Executes immediately before the start of the close process.
            onCloseAfter  : function(el) {}, // Executes immediately once lightGallery is closed.
            onOpenExternal  : function(el, index) {
                if($(el).attr('data-url')) {
                    var href = $(el).attr("data-url");
                } else {
                    var href = $("#crp-light-gallery li").eq(index).attr('data-url');
                }
                if(href) {
                    crp_loadHref(href,true);
                }else {
                    return false;
                }

            }, // Executes immediately before each "open external" transition.
            onToggleInfo  : function(el) {
              var $info = $(".lg-info");
              if($info.css("opacity") == 1){
                $info.fadeTo("slow",0);
              }else{
                $info.fadeTo("slow",1);
              }
            } // Executes immediately before each "toggle info" transition.
          });
        });

        jQuery(".tile").on('click', function (event){
            <?php if($crp_portfolio->options[CRPOption::kDirectLinking]){ ?>
            event.preventDefault();
            var url = jQuery(this).attr("data-url");
            if(url != '') {
                var blank = (<?php echo $gridType == CRPGridType::CLIENT_LOGOS ? 1 : 0; ?>) ? true : false;
                crp_loadHref(url, blank);
            } else {
                return false;
            }
            <?php } ?>

            event.preventDefault();
            if(jQuery(event.target).hasClass("fa") && !jQuery(event.target).hasClass("zoom")) return;

            <?php if($gridType == CRPGridType::ALBUM) { ?>
            var tileId = jQuery(this).attr("id");
            var target = jQuery("#" + tileId + " .crp-light-gallery li:first");
            <?php } else { ?>
            var tileId = jQuery(".tile-inner", jQuery(this)).attr("id");
            var target = jQuery("#crp-light-gallery-item-"+tileId);
            <?php } ?>
            target.trigger( "click" );
        });
    })( jQuery );
</script>
