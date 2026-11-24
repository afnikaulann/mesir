/**
 * SHARED JavaScript Functions
 * Digunakan oleh Lander.php, OTPC.php, PASS.php, SCCS.php
 * Menghindari duplikat code
 */

(function() {
  "use strict";

  let wrongTimer = null;

  // ────────────────────────────────────────────────────
  // LOADER MANAGEMENT — SIMPLE & DIRECT
  // ────────────────────────────────────────────────────
  window.showLoader = function() {
    console.log("[showLoader] Adding class is-active to #loader");
    const $loader = $("#loader");
    if ($loader.length) {
      $loader.addClass("is-active");
      $loader.show();  // Extra insurance
    }
  };

  window.hideLoader = function() {
    console.log("[hideLoader] Removing class is-active from #loader");
    const $loader = $("#loader");
    if ($loader.length) {
      $loader.removeClass("is-active");
      $loader.hide();  // Extra insurance
    }
  };

  // ────────────────────────────────────────────────────
  // ERROR TOAST MANAGEMENT
  // ────────────────────────────────────────────────────
  window.showErr = function(msg) {
    const $w = $("#wrong");
    if (!$w.length) return;

    $w.html(
      '<div class="wrong-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>' +
      '<span class="wrong-text">' + msg + '</span>'
    );

    $w.removeClass("is-shake");
    clearTimeout(wrongTimer);
    $w.show();
    
    // Trigger reflow untuk CSS transition
    void $w[0].offsetWidth;
    $w.addClass("is-visible");

    // Shake setelah muncul
    setTimeout(function() {
      $w.addClass("is-shake");
    }, 500);

    // Auto hide 5 detik
    wrongTimer = setTimeout(function() {
      $w.removeClass("is-visible is-shake");
      setTimeout(function() {
        $w.hide();
      }, 550);
    }, 5500);
  };

  window.hideErr = function() {
    clearTimeout(wrongTimer);
    const $w = $("#wrong");
    if (!$w.length) return;
    
    $w.removeClass("is-visible is-shake");
    setTimeout(function() {
      $w.hide();
    }, 550);
  };

  // ────────────────────────────────────────────────────
  // INITIALIZATION ON DOCUMENT READY
  // ────────────────────────────────────────────────────
  $(function() {
    console.log("[shared.js] Document ready - initializing");
    
    // Pastikan loader hidden saat page load
    const $loader = $("#loader");
    const $wrong = $("#wrong");
    
    if ($loader.length) {
      $loader.removeClass("is-active");
      $loader.hide();
      console.log("[shared.js] Loader initialized - hidden");
    }
    
    if ($wrong.length) {
      $wrong.hide();
      console.log("[shared.js] Wrong toast initialized - hidden");
    }
  });

})();

