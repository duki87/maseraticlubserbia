var PhotoBlocksMap = {};
var Utils = null;

(function($) {
  PhotoBlocksMap = function (columns) {
    this._table = [[]];
    this._stack = [];
    this._cols = columns;
  };

  Utils = (function() {
    return {
      cleanSize: function(size) {
        return parseInt(size.replace(/px/gi, ""));
      }
    };
  })();

    /*function _getSlotIndex(r, c) {
      return c * r + c;
    }*/

  PhotoBlocksMap.prototype.freeSlot = function(cols) {
    var r = 0;
    if(! cols)
      cols = 1;

    //console.log(this._table);

    while (true) {
      for (var c = 0; c < this._cols; c++) {
        if (this._table[r][c] == undefined && c + cols <= this._cols) {
          return { row: r, col: c };
        }
      }
      r++;
      if (!this._table[r]) this._table[r] = [];

      if(r > 1000) {
        console.warn("loop!");
        break;
      }
    }
  };


  PhotoBlocksMap.prototype.init = function(columns) {
    this._cols = columns;
  },
  PhotoBlocksMap.prototype.empty = function() {
    this._table = [[]];
    this._stack = [];
  },
  PhotoBlocksMap.prototype.getStack = function() {
    return this._stack;
  },
  PhotoBlocksMap.prototype.stack = function($block) {
    this._stack.push($block);
  },
  PhotoBlocksMap.prototype.buildTable = function() {
    console.log("## buildTable (" + this._stack.length + ")");
    var self = this;
    $.each(this._stack, function() {
      var $block = $(this);
      $block.data("previous_conf", $.extend({}, $block.data("conf")));

      var rowspan = $block.data("conf").geometry.rowspan;
      var colspan = $block.data("conf").geometry.colspan;

      var slot = self.freeSlot();
      
      for (var r = slot.row; r < slot.row + rowspan; r++) {
        for (var c = slot.col; c < slot.col + colspan; c++) {
          if (!self._table[r]) self._table[r] = [];

          if (!self._table[r][c]) self._table[r][c] = true;
          else {
            //console.log("ooops!");
            $block.data("conf").geometry.colspan =
              c - slot.col;
            break;
          }
        }
      }
      
      $block.data("conf").geometry.row = slot.row;
      $block.data("conf").geometry.col = slot.col;
      $block.data("row", slot.row);
      $block.data("col", slot.col);

      if (slot.col + colspan > this._cols) {
        $block.data("conf").geometry.colspan = this._cols - slot.col;
      }
    });

    var map = "";
    for (var r = 0; r < this._table.length; r++) {
      if (!this._table[r]) this._table[r] = [];

      for (var c = 0; c < this._cols; c++) {
        map += " " + (this._table[r][c] ? "*" : "_");
      }
      map += "\n";
    }
    console.log(map);
  },
  PhotoBlocksMap.prototype.move = function($block, left, top) {
    var self = this;
    var temp = [];
    console.log("PhotoBlocksMap.move", left, top);

    var cancel = false;
    var back = true;
    var moved = false;
    $.each(this._stack, function(i, $b) {
      var l = Utils.cleanSize($b.css("left"));
      var t = Utils.cleanSize($b.css("top"));
      var w = $b.width();
      var h = $b.height();

      if ($b[0] == $block[0]) {
        if (
          l <= left &&
          l + w > left &&
          (t <= top && t + h > top)
        ) {
          console.log("self dropped", i);
          cancel = true;
          return false;
        }
        console.log("skip self index:", i);
        back = false;
        return true;
      }

      if (
        l <= left &&
        l + w > left &&
        (t <= top && t + h > top)
      ) {
        console.log(">>>> Found index", i);
        console.log("\t left", left);
        console.log("\t l", l);
        console.log("\t top", top);
        console.log("\t t", t);
        console.log("\t w x h", w, h);

        if (back) {
          temp.push($block);
          temp.push($b);
        } else {
          temp.push($b);
          temp.push($block);
        }
        moved = true;
        return true;
      }
      temp.push($b);
    });
    if (!moved) temp.push($block);

    if (!cancel) {
      self.empty();
      temp.map(function(e) {
        self._stack.push(e);
      });
      self.buildTable();
    }
  };

})(jQuery);