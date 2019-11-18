/*jshint browser: true, strict: true, undef: true, unused: true */
/*global define: false, module: false, console: false */

/*global jQuery*/
/*global wp*/
/*global PBConsole*/
/*global PhotoBlocksMap */

var PhotoBlocks = null;
var Utils = null;
(function($) {
  var currentBlock = null;

  Utils = (function() {
    return {
      cleanSize: function(size) {
        return parseInt(size.replace(/px/gi, ""));
      }
    };
  })();

  
  PhotoBlocks = (function() {
    var $_cnt = null;

    var _index = 0;

    var _map = new PhotoBlocksMap();

    var _block_conf = {
      image: {
        alignment: {
          h: null,
          v: null
        },
        blurOnHover: null
      },
      caption: {
        background: {
          color: null,
          opacity: null
        },
        title: {
          position: {
            v: null,
            h: null
          },
          size: null,
          color: null
        },
        description: {
          position: {
            v: null,
            h: null
          },
          size: null,
          color: null
        }
      },
      click: {
        link: null,
        target: null,
        rel: null
      },
      filters: [],
      type: "image"
    };

    var settings = {
      padding: 10,
      columns: 4,
      show_empty_overlays: true,
      image: {
        alignment: {
          h: "center",
          v: "center"
        },
        blurOnHover: true
      },
      caption: {
        background: {
          color: "rgba(0, 0, 0, .5)"
          //opacity: 80
        },
        title: {
          position: {
            v: "middle",
            h: "center"
          },
          size: 16,
          color: "#fff"
        },
        description: {
          position: {
            v: "middle",
            h: "center"
          },
          size: 12,
          color: "#fff"
        }
      }
    };

    var geometry = {
      width: 0,
      squareSize: 0
    };

    var map = [[]];

    function deleteBlocks(only_selected) {
      if(! only_selected) {
        _map.empty();
        $_cnt.empty();
      } else {
        $(".pb-selected").remove();
      }      
      refresh(true);
    }

    function replaceImage($block) {
      var tgm_media_frame = (wp.media.frames.tgm_media_frame = wp.media({
        multiple: false,
        library: {
          type: "image"
        },
        date: true,
        title: "Replace image",
        button: {
          text: "Replace image"
        },
        states: [
          new wp.media.controller.Library({
            library: wp.media.query({
              type: "image"
            }),
            multiple: false,
            priority: 20,
            filterable: "all"
          })
        ]
      }));

      
      tgm_media_frame.on("select", function() {
        var selection = tgm_media_frame.state().get("selection");

        selection.map(function(attachment) {
          attachment = attachment.toJSON();
          $block.data("conf").image.url = attachment.url;
          $block.css({
            backgroundImage: "url('" + attachment.url + "')"
          })
        });
      });
      
      tgm_media_frame.open();    
    }

    function addImages(position) {
      var tgm_media_frame = (wp.media.frames.tgm_media_frame = wp.media({
        multiple: true,
        library: {
          type: "image"
        },
        date: true,
        title: "Add images",
        button: {
          text: "Add images"
        },
        states: [
          new wp.media.controller.Library({
            library: wp.media.query({
              type: "image"
            }),
            multiple: true,
            priority: 20,
            filterable: "all"
          })
        ]
      }));

      tgm_media_frame.on("select", function() {
        var selection = tgm_media_frame.state().get("selection");
        //var images = [];

        var errors = 0;
        var idx = 0;
        selection.map(function(attachment) {
          attachment = attachment.toJSON();

          var url = attachment.url;
          
          var defValues = {
            image: {
              url: url,
              id: attachment.id,
              ratio: attachment.width / attachment.height
            },
            geometry: {
              colspan: 1,
              rowspan: 1
            }
          };

          if (attachment.sizes && attachment.sizes.thumbnail)
            defValues.thumbnail = attachment.sizes.thumbnail.url;

          defValues = $.extend(true, {}, _block_conf, defValues);

          var $b = makeBlock(defValues);
          insertBlock()[position]($b, true);
        });
        //_map.buildTable();
        refresh(true);
      });

      tgm_media_frame.open();
    }

    function makeBlock(conf) {
      var $b = $("<div class='block'></div>");
      $b.data("index", _index++);
      var idx = $b.data("index");

      $b.data("conf", conf);
      $b.css({
        width: geometry.squareSize,
        height: geometry.squareSize,        
      });
      $b.addClass("pb-type-" + conf.type);

      if(conf.type != "empty") {
        $b.append(
          '<div class="pb-overlay"><div class="pb-caption-top"></div><div class="pb-caption-middle"></div><div class="pb-caption-bottom"></div></div>'
        );
      }
      $b.append('<div class="buttons"></div>');
      if(conf.type == "image") {  
        $b.css({
          backgroundImage: "url('" + conf.image.url + "')"
        })
        $b.find(".buttons").append('<a class="js-add pb-camera" title="Replace image"></a>');
      }
      if(conf.type == "image" || conf.type == "text") {  
        $b.find(".buttons").append('<a class="js-settings pb-settings" title="Settings"></a>');
      }
      $b.find(".buttons").append('<a class="js-clone pb-clone" title="Clone"></a>');
      $b.find(".buttons").append('<a class="js-shrink pb-cancel-circled" title="Remove"></a>');      
      
      $b.append('<ul class="js-block-filters pb-block-filters"></ul>');

      $b.find(".js-settings").click(function(e) {
        e.stopPropagation();
        var $b = $(this).parents(".block");
        PhotoBlocks.openDrawer("pb-" + conf.type + "-settings");
        PhotoBlocks.setCurrentBlock($b);
      });

      $b.find(".js-add").click(function(e) {
        e.stopPropagation();
        var $b = $(this).parents(".block");
        replaceImage($b);
      });

      $b.find(".js-clone").click(function(e) {
        e.stopPropagation();
        var $b = $(this).parents(".block");
        var $bb = $b.clone(true, true);
        $bb.data("conf", jQuery.extend(true, {}, $b.data("conf")));
        $b.after($bb);
        refresh(true);
      });
    
      $b.find(".js-shrink").click(function(e) {
        e.stopPropagation();
        var $b = $(this).parents(".block");
        $b.remove();
        refresh(true);
      });

      $b.data("pb-set-image-filters", function () {
        $b.find(".js-block-filters").empty();
        $b.data("conf").filters.map(function (f) {
          $b.find(".js-block-filters").append("<li><i class='pb-filter'></i> " + f + "</li>");
        });
      });
      $b.data("pb-set-image-filters")();

      $b.click(function () {
        $(this).toggleClass("pb-selected");
      });

      updateCaption($b);

      return $b;
    }

    function refresh(fromMarkup) {
      if (fromMarkup) {
        _map.empty();
        $_cnt.find(".block").each(function(i) {
          var $block = $(this);

          _map.stack(
            $block,
            $block.data("conf").geometry.colspan,
            $block.data("conf").geometry.rowspan
          );
        });
        _map.buildTable();
      }

      var maxHeight = 0;
      $_cnt.find(".block").each(function() {
        var $block = $(this);
        var col = $block.data("conf").geometry.col;
        var row = $block.data("conf").geometry.row;

        var left = col * geometry.squareSize;
        if (col > 0) left += col * settings.padding;

        var top = row * geometry.squareSize;
        if (row > 0) top += row * settings.padding;

        $block.css({
          left: left,
          top: top,
          width: getSnappedSize(
            $block.data("conf").geometry.colspan *
              geometry.squareSize
          ),
          height: getSnappedSize(
            $block.data("conf").geometry.rowspan *
              geometry.squareSize
          )
        });

        var h = $block.height();
        if (top + h > maxHeight) maxHeight = top + h;

        /*$block.find("div").empty()
          .append("<p>col: "+ $block.data("col") +"</p>")
          .append("<p>row: "+ $block.data("row") +"</p>")
          .append("<p>colspan: "+ $block.data("colspan") +"</p>")
          .append("<p>rowspan: "+ $block.data("rowspan") +"</p>");*/
      });

      $_cnt.height(maxHeight + 80);
    }

    function setContainerHeight() {
      /*$_cnt.height(
        geometry.squareSize +
          row * (geometry.squareSize * rowspan) +
          row * (settings.padding * (rowspan - 1))
      );*/
    }

    function appendBlock($block, show_toast) {
      $_cnt.append($block);
      addInteraction($block);
      if(show_toast)
        PBToast.confirm("Block(s) added");
    }

    function prependBlock($block, show_toast) {
      $_cnt.prepend($block);
      addInteraction($block);
      if(show_toast)
        PBToast.confirm("Block(s) added");
    }

    function cellSize() {
      var w = geometry.width - settings.padding * (settings.columns - 1);
      return Math.ceil(w / settings.columns);
    }

    function getProperty(name) {
      console.log(name);
      var $tag = $('[name="' + name + '"]').eq(0);
      switch ($tag.get(0).tagName.toLowerCase()) {
        case "input":
          if ($tag.attr("type") == "checkbox") {
            return $tag.get(0).checked;
          }
          break;
      }

      return $tag.val();
    }

    function draw() {
      geometry.width = $_cnt.width();
      geometry.squareSize = cellSize();
      _map.init(settings.columns);
    }

    function getSquareIndex(len) {
      return Math.round(len / geometry.squareSize);
    }

    function getSnappedSize(len) {
      var x = getSquareIndex(len);
      return geometry.squareSize * x + settings.padding * (x - 1);
    }

    function addInteraction($block) {
      handleInteraction($block);
      blockInteraction($block);
    }

    function blockInteraction($block) {
      $block.on("dragend", function(e) {
        e.stopPropagation();
        var x = $block.parent().offset().left;
        var left = Math.floor(e.clientX - x);

        var y = $block.parent().offset().top;
        var top = Math.max(
          0,
          Math.floor(e.clientY - y)
        );

        _map.move($block, left, top);
        _map.getStack().map(function($b) {
          $_cnt.append($b);
        });
        refresh(false);
      });
    }

    function handleInteraction($block) {
      $block.attr("draggable", "true");
      var $handle = $("<b draggable='true' class='handle'></b>");
      var trans = $block.css("transition");
      var right = [];
      var below = [];
      var osize = {};
      var stopX = false;
      var stopY = false;
      
      $handle
        .on("dragstart", function(e) {
          e.stopPropagation();
          $block.css("transition", "initial");
          $block.addClass("dragging");
          $_cnt.addClass("dragging");

          osize = {
            width: $block.width(),
            height: $block.height()
          };
        })
        .on("drag", function(e) {
          e.stopPropagation();
          var size = {
            width: $block.width(),
            height: $block.height()
          };

          var x = $block.offset().left;
          var y = $block.offset().top;

          if (e.clientY > 0) size.height = e.clientY - y;
          if (e.clientX > 0) size.width = e.clientX - x;

          size.width =
            size.width < geometry.squareSize - 10
              ? geometry.squareSize
              : size.width;
          size.height =
            size.height < geometry.squareSize - 10
              ? geometry.squareSize
              : size.height;

          if (!stopX) $block.css("width", size.width);
          if (!stopY) $block.css("height", size.height);
        })
        .on("dragend", function(e) {
          e.stopPropagation();
          $block.removeClass("dragging");
          $_cnt.removeClass("dragging");
          var h = $block.height();
          var w = $block.width();
          var snapped_w = getSnappedSize(w);
          var snapped_h = getSnappedSize(h);
          $block.css("transition", trans);
          $block.height(snapped_h);
          $block.width(snapped_w);

          $block.data("conf").geometry.colspan = getSquareIndex(
            snapped_w
          );
          $block.data("conf").geometry.rowspan = getSquareIndex(
            snapped_h
          );

          stopX = false;
          refresh(true);
        });

      $block.append($handle);
    }

    function _s(path) {
      var field = path.replace(/\./g, "_");
      return $('[name="' + field + '"]').val();

      /*var parts = path.split('.');

      var defValue = jQuery.extend(true, {}, settings);
      for(var i=0; i<parts.length; i++) {
        var part = parts[i];

        if(defValue[part] === undefined) {
          defValue = null;
          console.warn("default value for " + path + " is undefined at " + part);
          break;
        }
        defValue = defValue[part];
      }
      return defValue;*/
    }

    function _b(path, $block) {
      if (!$block) $block = currentBlock;

      var parts = path.split(".");

      var blockValue = jQuery.extend(true, {}, $block.data("conf"));

      for (var i = 0; i < parts.length; i++) {
        var part = parts[i];
        if (blockValue[part] === undefined) {
          blockValue = null;
          console.warn(
            "block value for " + path + " is undefined at " + part
          );
          break;
        }
        blockValue = blockValue[part];
      }

      return blockValue;
    }

    /* Get value from block configuration
     * uses default fallback
     */
    function _g(path, $block) {
      if (!$block) $block = currentBlock;

      var parts = path.split(".");

      var defValue = _s(path);
      var blockValue = jQuery.extend(true, {}, $block.data("conf"));

      for (var i = 0; i < parts.length; i++) {
        var part = parts[i];
        if (blockValue[part] === undefined) {
          blockValue = null;
          break;
        }
        blockValue = blockValue[part];
      }

      if (!blockValue) {
        return defValue;
      }

      return blockValue;
    }

    function drawerEvents() {
      $(".align-field select").change(function() {
        var h = $(".align-field.align-h select").val();
        var v = $(".align-field.align-v select").val();
        $(".current-block-pic").css({
          backgroundPosition: h + " " + v
        });
      });
    }

    function updateCaption($block) {
      var conf = $block.data("conf");
      currentBlock = $block;

      $block
        .removeClass("with-text")
        .find(".pb-caption-top")
        .empty()
        .end()
        .find(".pb-caption-middle")
        .empty()
        .end()
        .find(".pb-caption-bottom")
        .empty();

      if (conf.caption.title.text) {
        var vert = _g("caption.title.position.v");
        var hori = _g("caption.title.position.h");
        if($block.data("conf").type == "text") {
          if(!$block.data("conf").caption.title.position.v)
            vert = $(".p-block_text_title_position_v").val();
          if(!$block.data("conf").caption.title.position.h)
            hori = $(".p-block_text_title_position_h").val();
        }
        $block
          .addClass("with-text")
          .find(".pb-caption-" + vert)
          .append(
            '<p class="halign-' + hori + '">' +
              conf.caption.title.text +
              "</p>"
          );
      }
      if (conf.caption.description.text) {
        var vert = _g("caption.description.position.v");
        var hori = _g("caption.description.position.h");
        if($block.data("conf").type == "text") {
          if(!$block.data("conf").caption.description.position.v)
            vert = $(".p-block_text_description_position_v").val();
          if(!$block.data("conf").caption.description.position.h)
            hori = $(".p-block_text_description_position_h").val();
        }
        $block
          .addClass("with-text")
          .find(".pb-caption-" + vert)
          .append(
            '<p class="halign-' + hori + '">' +
              conf.caption.description.text +
              "</p>"
          );
      }
      //console.log('_g("caption.title.color")', _g("caption.title.color"));
      $block.find("h4").css({
        fontSize: _g("caption.title.size") + "px",
        color: _g("caption.title.color")
      });
      $block.find("p").css({
        fontSize: _g("caption.description.size") + "px",
        color: _g("caption.description.color")
      });

      $block.find(".pb-overlay").css({
        background: _g("caption.background.color")
      });
    }

    function insertBlock() {
      return {
        prepend: function ($block, show_toast) { prependBlock($block, show_toast); },
        append: function ($block, show_toast)  { appendBlock($block, show_toast); },
      };
    }

    return {
      init: function($container) {
        settings.columns = getProperty("columns");
        settings.padding = getProperty("padding");
        $_cnt = $container;
        $_cnt.width(getProperty("abwidth"));
        $_cnt.show();
        draw();

        drawerEvents();
      },
      addImages: function(position) {
        PBAdmin.popup('add-blocks', true);        
        addImages(position);
      },
      addEmptyBlock: function(position) {
        PBAdmin.popup('add-blocks', true);
        var defValues = {
          geometry: {
            colspan: 1,
            rowspan: 1
          },
          type: "empty"
        };

        defValues = $.extend(true, {}, _block_conf, defValues);

        var $b = makeBlock(defValues);
        insertBlock()[position]($b, true);
        //appendBlock($b, true);
        refresh(true);
      },

      
/* Premium Code Stripped by Freemius */

      deleteSelectedBlock: function () {
        deleteBlocks(true);
      },
      deleteAllBlocks: function() {
        deleteBlocks();
      },
      getBlocks: function() {
        var blocks = [];
        $_cnt.find(".block").each(function() {
          var $b = $(this);
          blocks.push($b.data("conf"));
        });
        return blocks;
      },
      setBlocks: function(blocks) {
        $.each(blocks, function(i, b) {
          var conf = $.extend(true, {}, _block_conf, b);
          var $b = makeBlock(conf);
          appendBlock($b, false);
          updateCaption($b);
        });
        refresh(true);
      },
      updateGrid: function() {
        var newPadding = parseInt($(".padding").val());
        settings.padding = newPadding;
        if (getProperty("caption_background_show_empty"))
          $_cnt.addClass("pb-show-empty-overlays");
        else $_cnt.removeClass("pb-show-empty-overlays");
        draw();
        refresh(true);

        var newColumns = parseInt($(".columns").val());
        if (settings.columns != newColumns) {
          settings.columns = newColumns;
          draw();
          refresh(true);  
        }
      },
      openDrawer: function(panel) {
        $("#pb-main .submenu li a").removeClass("active");

        $("#pb-drawer").css({
          display: "block",
          right: 0,
          opacity: 1
        });
        $("#" + panel)
          .addClass("open")
          .show();
        $("#pb-builder").addClass("open");
      },
      setCurrentBlock: function($block) {
        currentBlock = $block;

        var conf = currentBlock.data("conf");

        $(".current-block-pic").empty();
        if (conf.image.url) {
          var ratio = conf.geometry.colspan / conf.geometry.rowspan;
          if (ratio > 1) {
            $(".current-block-pic").css({
              width: 200,
              height: 200 * (1 / ratio)
            });
          } else {
            $(".current-block-pic").css({
              height: 200,
              width: 200 * ratio
            });
          }
          $(".current-block-pic").css({
            backgroundImage: "url('" + conf.image.url + "')"
          });
        }

        $("#pb-image-settings .align-h select").val(
          _b("image.alignment.h")
        );
        $("#pb-image-settings .align-v select").val(
          _b("image.alignment.v")
        );

        var h = _g("image.alignment.h");
        var v = _g("image.alignment.v");
        $(".current-block-pic").css({
          backgroundPosition: h + " " + v
        });

        $("#pb-image-settings .align-field").hide();

        var ratio = conf.geometry.colspan / conf.geometry.rowspan;

        if (conf.image.ratio > ratio) {
          $("#pb-image-settings .align-h").show();
        } else {
          $("#pb-image-settings .align-v").show();
        }

        $(".caption-title").val(conf.caption.title.text);
        $(".caption-description").val(conf.caption.description.text);

        $(".caption-title-size").val(_b("caption.title.size"));
        $(".caption-description-size").val(
          _b("caption.description.size")
        );

        $(".caption-title-color").val(_b("caption.title.color"));
        $(".caption-description-color").val(
          _b("caption.description.color")
        );

        $(".overlay-color").val(_b("caption.background.color"));
        $(".on-click-link").val(_b("click.link"));
        $(".on-click-target").val(_b("click.target"));
        $(".on-click-rel").val(_b("click.rel"));
        //$(".overlay-opacity").val(_b("caption.background.opacity"));

        $('[name="image-filter"]').each(function() {
          this.checked = $.inArray(this.value, conf.filters) >= 0;
        });

        $(".title-position").val(
          _b("caption.title.position.v") +
            "-" +
            _g("caption.title.position.h")
        );
        $(".description-position").val(
          _b("caption.description.position.v") +
            "-" +
            _g("caption.description.position.h")
        );
      },
      updateAllBlocks: function() {
        $_cnt.find(".block").each(function(i, block) {
          PhotoBlocks.applyDefaultSettings($(block));
        });
      },
      applyDefaultSettings: function($block) {
        updateCaption($block);
        currentBlock.css({
          backgroundPosition:
            _g("image.alignment.h") + " " + _g("image.alignment.v")
        });
      },      
      updateBlock: function() {
        
        var conf = currentBlock.data("conf");
        var $form = $("#pb-" + conf.type + "-settings");
        
        /* Image alignment */
        conf.image.alignment.h = $(".align-field.align-h select", $form).val();
        conf.image.alignment.v = $(".align-field.align-v select", $form).val();

        currentBlock.css({
          backgroundPosition:
            _g("image.alignment.h") + " " + _g("image.alignment.v")
        });

        /* Captions */
        var title = $(".caption-title", $form).val();
        var description = $(".caption-description", $form).val();

        if ($(".title-position", $form).val()) {
          var title_pos = $(".title-position", $form)
            .val()
            .split("-");
          conf.caption.title.position.v = title_pos[0];
          conf.caption.title.position.h = title_pos[1];
        } else {
          conf.caption.title.position.v = null;
          conf.caption.title.position.h = null;

          if(conf.type == "text") {
            conf.caption.title.position.v = $(".p-block_text_title_position_v").val();
            conf.caption.title.position.h = $(".p-block_text_title_position_h").val();
          }
        }
        conf.caption.title.text = title;

        conf.caption.title.size = $(".caption-title-size", $form).val();
        conf.caption.description.size = $(".caption-description-size", $form).val();

        conf.caption.title.color = $(".caption-title-color", $form).val();
        conf.caption.description.color = $(".caption-description-color", $form).val();

        if ($(".description-position", $form).val()) {
          var desc_pos = $(".description-position", $form)
            .val()
            .split("-");
          conf.caption.description.position.v = desc_pos[0];
          conf.caption.description.position.h = desc_pos[1];
        } else {
          conf.caption.description.position.v = null;
          conf.caption.description.position.h = null;

          if(conf.type == "text") {
            conf.caption.description.position.v = $(".p-block_text_description_position_v").val();
            conf.caption.description.position.h = $(".p-block_text_description_position_h").val();
          }
        }
        conf.caption.description.text = description;

        conf.click.link = $(".on-click-link", $form).val();
        conf.click.target = $(".on-click-target", $form).val();
        conf.click.rel = $(".on-click-rel", $form).val();

        /**
         * Filters
         */
        conf.filters = [];
        $("[name=\"image-filter\"]", $form).each(function() {
          if (this.checked) {
            conf.filters.push(this.value);            
          }            
        });

        currentBlock.data("pb-set-image-filters")();

        if ($(".overlay-color", $form).val())
          conf.caption.background.color = $(".overlay-color", $form).val();
        else conf.caption.background.color = null;

        /*if($(".overlay-opacity").val())
          conf.caption.background.opacity = $(".overlay-opacity").val();
        else
          conf.caption.background.opacity = null;*/

        updateCaption(currentBlock);
      }
    };
  })();
})(jQuery);
