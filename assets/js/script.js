// Tittle: Hamburger Menu
$(document).ready(function () {
  // note: Sticky Header
  $(window).scroll(function () {
    var header = $("header");
    if ($(window).scrollTop() > 100) {
      header.addClass("sticky");
    } else {
      header.removeClass("sticky");
    }
  });

  // note: count quantity
  $("#plus").on("click", function (e) {
    e.preventDefault();
    var $q = $("#quantity");
    var val = parseInt($q.val(), 10);
    if (isNaN(val) || val < 1) val = 1;
    $q.val(val + 1);
  });

  $("#mins").on("click", function (e) {
    e.preventDefault();
    var $q = $("#quantity");
    var val = parseInt($q.val(), 10);
    if (isNaN(val) || val <= 1) {
      $q.val(1);
      return;
    }
    $q.val(val - 1);
  });

  // note: beli sekarang
  $(".buy-now-btn").on("click", function (e) {
    e.preventDefault();
    var $btn = $(this);
    var product =
      $btn
        .closest(".product-info-section")
        .find(".product-title")
        .first()
        .text()
        .trim() ||
      $(".product-title").first().text().trim() ||
      "";
    var qty = parseInt($("#quantity").val(), 10);
    if (isNaN(qty) || qty < 1) qty = 1;
    var message =
      "Hai Selera Rakyat, saya mau order " +
      product +
      " " +
      qty +
      " pack. Mohon dikonfirmasi ya kalau masih tersedia, terima kasih banyak!";
    var phone = "6285730779326";
    var url = "https://wa.me/" + phone + "?text=" + encodeURIComponent(message);
    window.open(url, "_blank");
  });

  // note: search bar
  function setupSearchBar() {
    var $input = $(".input");
    var $menuItems = $(".menu-item");

    if ($input.length === 0 || $menuItems.length === 0) return;

    $input.on("input", function () {
      var query = $.trim($(this).val()).toLowerCase();

      if (query === "") {
        $menuItems.show();
        return;
      }

      $menuItems.each(function () {
        var $item = $(this);
        var title = $item.find("h3").first().text().toLowerCase();
        if (title.indexOf(query) !== -1) {
          $item.show();
        } else {
          $item.hide();
        }
      });
    });
  }

  setupSearchBar();

  // note: message
  $("#submit-contact").on("click", function (e) {
    e.preventDefault();

    const $name = $("#name");
    const $email = $("#mail");
    const $message = $("#message");
    const $notification = $("#notification");
    const $notificationMessage = $("#notification-message");

    if (
      $name.val().trim() === "" ||
      $email.val().trim() === "" ||
      $message.val().trim() === ""
    ) {
      $notificationMessage.text("Harap Isi Semua form");
      $notification.css("background-color", "Red");
      $notification.slideDown();
      return;
    }

    const name = $name.val().trim();
    const email = $email.val().trim();
    const messageText = $message.val().trim();

    const fullMessage = `Halo Tim Selera Rakyat,

Saya ${name} dengan email ${email} mau kasih sedikit pesan:
${messageText}

Terima kasih sudah terus menghadirkan jajanan tradisional yang enak dan berkualitas. Sukses selalu untuk Selera Rakyat – terus pertahankan cita rasanya!`; 
    const phone = "6285730779326";
    const url = `https://wa.me/${phone}?text=${encodeURIComponent(
      fullMessage
    )}`;

    $notificationMessage.text("Pesan sudah terikirim, terima kasih");
    $notification.css("background-color", "Green");
    $notification.slideDown();

    window.open(url, "_blank");

    $name.val("");
    $email.val("");
    $message.val("");

    setTimeout(function () {
      $notification.slideUp();
    }, 4000);
  });
});
