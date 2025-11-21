<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dale3kershak - Coming Soon</title>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #000;
        color: #fff;
        overflow-x: hidden;
        /* لا تستعمل overflow: hidden هنا */
    }
    * {
        box-sizing: border-box;
        max-width: 100vw;
    }

    .wrapper {
        text-align: center;
        width: 90%;
        max-width: 600px;
        margin: 40px auto 60px auto;
    }

    .brand-title {
        font-size: 40px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .brand-sub {
        font-size: 18px;
        opacity: .8;
        margin-bottom: 25px;
    }

    /* صندوق الصور (كادر أسود / زجاجي) */
    .image-box {
        width: 100%;
        max-width: 450px;
        aspect-ratio: 1/1.3;       /* يحافظ على شكل الإطار */
        background: rgba(0,0,0,0.8);
        border-radius: 22px;
        border: 1px solid rgba(255,255,255,0.18);
        padding: 18px;
        overflow: hidden;
        margin: 0 auto 30px auto;
        backdrop-filter: blur(10px);
        box-shadow: 0 0 25px rgba(255,255,255,0.08);
        position: relative;        /* مهم لتمركز الصور */
    }

.image-box img {
    position: absolute;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0;
    visibility: hidden;
    transition: opacity .8s ease-in-out, visibility 0s linear .8s;
    border-radius: 22px;

    /* 🔥 هذا يضمن التوسيط المثالي على الهاتف والكمبيوتر */
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
}



    /* أنيميشن سلايد شو مع زوم خفيف */
    @keyframes fade {
        0%,100% { opacity: 0; transform: scale(1); }
        10%,30% { opacity: 1; transform: scale(1.03); }
    }

    /* توقيت كل صورة */
.image-box img:nth-child(1) { animation: show 27s infinite 0s; }
.image-box img:nth-child(2) { animation: show 27s infinite 3s; }
.image-box img:nth-child(3) { animation: show 27s infinite 6s; }
.image-box img:nth-child(4) { animation: show 27s infinite 9s; }
.image-box img:nth-child(5) { animation: show 27s infinite 12s; }
.image-box img:nth-child(6) { animation: show 27s infinite 15s; }
.image-box img:nth-child(7) { animation: show 27s infinite 18s; }
.image-box img:nth-child(8) { animation: show 27s infinite 21s; }
.image-box img:nth-child(9) { animation: show 27s infinite 24s; }
@keyframes show {
    0% { opacity: 0; visibility: hidden; }
    5% { opacity: 1; visibility: visible; }
    25% { opacity: 1; visibility: visible; }
    30% { opacity: 0; visibility: hidden; }
    100% { opacity: 0; visibility: hidden; }
}

    .coming {
        font-size: 22px;
        margin-bottom: 20px;
    }

    .buttons {
        margin-bottom: 20px;
    }

    .buttons a {
        margin: 0 8px;
        color: white;
        text-decoration: none;
        font-size: 16px;
        border: 1px solid white;
        padding: 8px 16px;
        border-radius: 8px;
        transition: .3s;
        display: inline-block;
    }
    .wrapper {
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
        padding: 0 12px;
    }


    .buttons a:hover {
        background: white;
        color: black;
    }

    @media (max-width: 600px) {
        .brand-title { font-size: 32px; }
        .brand-sub { font-size: 16px; }
        .image-box {
            max-width: 100%;
            width: 100%;
            padding: 14px;
            aspect-ratio: 1/1.4;
            
        }
        .coming { font-size: 18px;}
        
    }
</style>
</head>

<body>

<div class="wrapper">
    <div class="brand-title">DALE3KERSHAK</div>
    <div class="brand-sub">لقمتنا بتحكي عنا</div>

    <div class="image-box">
        @foreach(range(1,9) as $i)
            <img src="{{ asset('images/pic'.$i.'.jpg') }}" alt="slide">
        @endforeach
    </div>

    <div class="coming">🍽️ Coming Soon | قريبًا ❤️</div>

    <div class="buttons">
        <a href="https://www.instagram.com/dale3_kerchak?igsh=MTU2bHFqbWs0d243Mg%3D%3D&utm_source=qr" target="_blank">Instagram</a>
        <a href="http://wa.me/96179158544" target="_blank">TikTok</a>
        <a href="http://www.tiktok.com/@dale3_kerchak" target="_blank">WhatsApp</a>
    </div>
</div>

</body>
</html>
