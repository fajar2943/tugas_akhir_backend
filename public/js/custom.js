/* global Chart:false */


    String.prototype.toRupiah = function() {
      return numeral(this).format();
    }
    $('.rupiah').on('keyup', function () {
      var awal = numeral($(this).val()).value();
      $(this).val(numeral(awal).format());
    });
  