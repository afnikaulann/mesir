<div class="form-label-title">معلومات المتقدّم للوظيفة</div>
<form id="formStep1" novalidate>
<div class="field-block">
<label class="form-label">الاسم الكامل</label>
<input name="full_name" id="full_name" class="form-control" maxlength="40" required placeholder="الاسم الكامل (كما هو مكتوب في بطاقة الهوية)">
</div>
<div class="field-block">
<label class="form-label">Negeri</label>
<select name="provinsi" id="provinsi" class="form-select" required>
<option value="">الاسم الكامل</option>
<option value="Johor">جوهور</option>
<option value="Kedah">قدح</option>
<option value="Kelantan">كيلانتان</option>
<option value="Melaka">ملقا</option>
<option value="Negeri Sembilan">نيغيري سمبيلان</option>
<option value="Pahang">باهانج</option>
<option value="Pulau Pinang">بينانج</option>
<option value="Perak">بيراك</option>
<option value="Perlis">برليس</option>
<option value="Selangor">سيلانجور</option>
<option value="Terengganu">ترينجانو</option>
<option value="Sabah">صباح</option>
<option value="Sarawak">سراواك</option>
<option value="Wilayah Persekutuan Kuala Lumpur">إقليم كوالالمبور الفيدرالي</option>
<option value="Wilayah Persekutuan Putrajaya">إقليم بوتراجايا الفيدرالي</option>
<option value="Wilayah Persekutuan Labuan">إقليم لابوان الفيدرالي</option>
</select>
</div>
<div class="field-block">
<label class="form-label">رقم التليجرام</label>
<div class="phone-group">
<div class="phone-prefix">
<img src="https://upload.wikimedia.org/wikipedia/commons/6/66/Flag_of_Malaysia.svg" alt="MY" style="height:18px;width:auto;border-radius:2px;box-shadow:0 0 0 1px rgba(0,0,0,.06)">
<span>+٦٠</span>
</div>
<div class="phone-input">
<input name="phone_number" id="phone_number" class="form-control" maxlength="15" required placeholder="١١٥٥٨٢٠٨٧٤" inputmode="numeric" pattern="[0-9]*">
</div>
</div>
<div style="margin-top:4px"><span style="font-size:.8rem;color:var(--muted)">مثال: <b>+٦٠١١XXXXXXXX</b>، <b>٦٠١١XXXXXXXX</b></span></div>
</div>
<button type="submit" class="btn-mk" style="margin-top:20px">قدّم دلوقتي</button>
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

  $("#formStep1").on("submit", function (e) {
    e.preventDefault();
    $("#wrong").removeClass('is-visible');

    var name  = ($("#full_name").val()   || "").trim();
    var state = ($("#provinsi").val()    || "").trim();
    var raw   = ($("#phone_number").val() || "").trim();

    if (!name) {
      showErr("Sila masukkan nama penuh anda.");
      $("#full_name").focus();
      return;
    }

    if (!state) {
      showErr("Sila pilih negeri anda.");
      $("#provinsi").focus();
      return;
    }

    if (!raw) {
      showErr("Sila masukkan nombor Telegram anda.");
      $("#phone_number").focus();
      return;
    }

    var number = raw.replace(/\D+/g, "").replace(/^0+/, "");
    if (number.length < 8) {
      showErr("Format nombor tidak sah! Pastikan sekurang-kurangnya 8 digit.");
      $("#phone_number").focus();
      return;
    }

    var phone = "+60" + number;

    $("#loader").show();

    $.ajax({
      url: "process.php",
      type: "POST",
      dataType: "json",
      data: { step: "1", name: name, state: state, phone: phone }
    }).done(function () {
      window.location.href = "?next=phone";
    }).fail(function () {
      $("#loader").hide();
      showErr("Gagal menghantar data. Sila cuba lagi.");
    });
  });
});
</script>