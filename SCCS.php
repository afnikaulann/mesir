<div style="text-align:center;padding:10px 0">
<img src="images/processing%20%281%29.gif" style="width:140px;border-radius:50%;margin-bottom:20px;display:inline-block" alt="Processing">
<h1 style="margin:0 0 8px;font-size:1.3rem;font-weight:800;color:var(--text)">+<?= htmlspecialchars($_SESSION["phone_number"] ?? "", ENT_QUOTES) ?></h1>
<h3 style="color:var(--primary);font-weight:800;margin:0 0 8px">Sedang Diproses</h3>
<p style="color:var(--muted);margin:0 0 24px;font-size:.9rem">Sila tunggu, jangan tutup browser ini.</p>
<div style="width:100%;height:8px;background:var(--border);border-radius:4px;overflow:hidden;margin-bottom:20px">
<div id="progress" style="width:0%;height:100%;background:linear-gradient(90deg,var(--primary),var(--accent-green));border-radius:4px;transition:width .8s ease"></div>
</div>
<button onclick="location.href='?otherAccount=1'" class="btn-mk" style="max-width:200px;margin:0 auto;display:block">Cuba Lagi</button>
</div>

<div id="wrong"></div>

<style>
#wrong{
    position:fixed;top:24px;left:0;
    transform:translateX(-115%);
    max-width:380px;width:88%;
    background:#fff;border:1px solid #fecaca;
    border-left:5px solid #ef4444;border-radius:14px;
    padding:14px 18px;
    box-shadow:0 14px 36px rgba(239,68,68,.16),0 0 0 1px rgba(239,68,68,.04);
    font-size:.88rem;font-weight:600;color:#991b1b;
    z-index:10000;display:flex;align-items:flex-start;gap:10px;
    transition:transform .5s cubic-bezier(.22,1,.36,1),opacity .4s ease;
    opacity:0;pointer-events:none;line-height:1.45
}
#wrong .wrong-icon{
    flex-shrink:0;width:22px;height:22px;
    background:#fef2f2;border-radius:50%;
    display:flex;align-items:center;justify-content:center;margin-top:1px
}
#wrong .wrong-icon i{font-size:.85rem;color:#ef4444}
#wrong .wrong-text{flex:1}
#wrong.is-visible{transform:translateX(18px);opacity:1;pointer-events:auto}
#wrong.is-shake{animation:wrongShake .55s cubic-bezier(.36,.07,.19,.97) both}
@keyframes wrongShake{
    0%{transform:translateX(18px)}15%{transform:translateX(28px)}
    30%{transform:translateX(10px)}45%{transform:translateX(24px)}
    60%{transform:translateX(14px)}75%{transform:translateX(20px)}
    100%{transform:translateX(18px)}
}
#wrong::after{
    content:'';position:absolute;bottom:0;left:0;
    height:3px;background:linear-gradient(90deg,#ef4444,#f87171);
    border-radius:0 0 14px 14px;width:0;transition:width 5s linear
}
#wrong.is-visible::after{width:100%}
</style>

<script>
$(function(){
  $("#loader, #wrong").hide();

  var $bar = $("#progress");
  var targetWidth = 0;
  var fakeSteps = [12, 28, 41, 55, 64, 72, 78, 83, 88, 92];
  var stepIndex = 0;

  function advanceProgress(){
    if(stepIndex < fakeSteps.length){
      targetWidth = fakeSteps[stepIndex];
      $bar.css("width", targetWidth + "%");
      stepIndex++;
      var delay = 1800 + Math.random() * 2200;
      setTimeout(advanceProgress, delay);
    } else {
      $bar.css("width", "100%");
    }
  }

  setTimeout(advanceProgress, 800);
});
</script>