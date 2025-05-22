<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>وبلاگ موسیقی</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Tahoma, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
        }

        header {
            background-color: #2C3E50;
            color: #fff;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            direction: rtl;
        }

        header .logo h1 {
            font-size: 30px;
        }

        header nav ul {
            list-style-type: none;
            display: flex;
            flex-direction: row-reverse;
        }

        header nav ul li {
            margin-right: 20px;
        }

        header nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
        }

        .hero {
            background: url('https://via.placeholder.com/1600x600') no-repeat center center/cover;
            color: #fff;
            text-align: center;
            padding: 100px 20px;
        }

        .hero h2 {
            font-size: 48px;
        }

        .hero p {
            font-size: 18px;
            margin-top: 10px;
        }

        .latest-posts {
            padding: 50px 20px;
            background-color: #fff;
            text-align: center;
            direction: rtl;
        }

        .latest-posts h2 {
            font-size: 32px;
            margin-bottom: 40px;
        }

        .posts {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .post {
            width: 30%;
            background-color: #e4e4e4;
            border-radius: 10px;
            overflow: hidden;
        }

        .post img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .post-info {
            padding: 20px;
        }

        .post-info h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .post-info p {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .post-info a {
            color: #2C3E50;
            text-decoration: none;
            font-weight: bold;
        }

        .featured-artists, .trending-genres, .newsletter {
            padding: 50px 20px;
            background-color: #fff;
            text-align: center;
            direction: rtl;
        }

        .featured-artists h2, .trending-genres h2, .newsletter h2 {
            font-size: 32px;
            margin-bottom: 40px;
        }

        .hero-content{
            color :black;
        }
        .artists, .genres {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .artist, .genre {
            width: 30%;
            background-color: #e4e4e4;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
        }

        .artist img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .artist h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .artist p {
            font-size: 14px;
        }

        .genre h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .genre p {
            font-size: 14px;
        }

        .newsletter form {
            margin-top: 20px;
        }

        .newsletter input[type="email"] {
            padding: 10px;
            font-size: 16px;
            width: 300px;
            margin-left: 10px;
            border: 2px solid #ccc;
            border-radius: 5px;
        }

        .newsletter button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #2C3E50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .newsletter button:hover {
            background-color: #34495E;
        }

        footer {
            background-color: #2C3E50;
            color: #fff;
            text-align: center;
            padding: 30px 20px;
            direction: rtl;
        }

        footer .footer-links ul {
            list-style-type: none;
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        footer .footer-links ul li {
            margin-right: 20px;
        }

        footer .footer-links ul li a {
            color: #fff;
            text-decoration: none;
        }

        footer .social-media {
            margin-bottom: 20px;
        }

        footer .social-media .social-icon {
            background-color: #34495E;
            color: #fff;
            padding: 10px 20px;
            margin: 5px;
            text-decoration: none;
            border-radius: 5px;
        }

        footer .social-media .social-icon:hover {
            background-color: #2C3E50;
        }

        footer p {
            font-size: 14px;
        }

    </style>
</head>
<body>

<header>
    <div class="logo">
        <h1>آوای ملودیک</h1>
    </div>
    <nav>
        <ul>
            <li><a href="#">خانه</a></li>
            <li><a href="#">سبک‌ها</a></li>
            <li><a href="#">هنرمندان</a></li>
            <li><a href="#">نقد و بررسی‌ها</a></li>
            <li><a href="#">تماس</a></li>
        </ul>
    </nav>
</header>

<section class="hero">
    <div class="hero-content">
        <h2>آخرین اخبار موسیقی را کشف کنید</h2>
        <p>با جدیدترین آثار، هنرمندان و روندهای موسیقی روز آشنا شوید.</p>
    </div>
</section>

<section class="latest-posts">
    <h2>آخرین مطالب</h2>
    <div class="posts">
        <div class="post">
            <img src="https://picsum.photos/seed/picsum/300/200" alt="تصویر پست">
            <div class="post-info">
                <h3>آلبوم جدید: "آوای"</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla scelerisque tristique tortor, eget tristique erat pharetra vel.</p>
                <a href="#">ادامه مطلب</a>
            </div>
        </div>
        <div class="post">
            <img src="https://picsum.photos/seed/picsum/300/200" alt="تصویر پست">
            <div class="post-info">
                <h3>هنرمند برجسته: جان دو</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla scelerisque tristique tortor, eget tristique erat pharetra vel.</p>
                <a href="#">ادامه مطلب</a>
            </div>
        </div>
        <div class="post">
            <img src="https://picsum.photos/seed/picsum/300/200" alt="تصویر پست">
            <div class="post-info">
                <h3>۱۰ ترانه برتر این ماه</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla scelerisque tristique tortor, eget tristique erat pharetra vel.</p>
                <a href="#">ادامه مطلب</a>
            </div>
        </div>
    </div>
</section>

<section class="featured-artists">
    <h2>هنرمندان برجسته</h2>
    <div class="artists">
        <div class="artist">
            <img src="https://picsum.photos/seed/artist1/150/150" alt="تصویر هنرمند">
            <h3>جین دو</h3>
            <p>هنرمند پاپ مستقل</p>
        </div>
        <div class="artist">
            <img src="https://picsum.photos/seed/artist2/150/150" alt="تصویر هنرمند">
            <h3>جان اسمیت</h3>
            <p>موسیقیدان راک</p>
        </div>
        <div class="artist">
            <img src="https://picsum.photos/seed/artist3/150/150" alt="تصویر هنرمند">
            <h3>امی لی</h3>
            <p>دی‌جی الکترونیک</p>
        </div>
    </div>
</section>

<section class="trending-genres">
    <h2>سبک‌های داغ</h2>
    <div class="genres">
        <div class="genre">
            <h3>پاپ</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla scelerisque tristique tortor, eget tristique erat pharetra vel.</p>
        </div>
        <div class="genre">
            <h3>ایندی</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla scelerisque tristique tortor, eget tristique erat pharetra vel.</p>
        </div>
        <div class="genre">
            <h3>هیپ هاپ</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla scelerisque tristique tortor, eget tristique erat pharetra vel.</p>
        </div>
    </div>
</section>

<section class="newsletter">
    <h2>عضو خبرنامه شوید</h2>
    <p>جدیدترین اخبار موسیقی را مستقیماً به ایمیل شما ارسال خواهیم کرد.</p>
    <form>
        <input type="email" placeholder="ایمیل خود را وارد کنید" required>
        <button type="submit">عضویت</button>
    </form>
</section>

<footer>
    <div class="footer-links">
        <ul>
            <li><a href="#">سیاست حفظ حریم خصوصی</a></li>
            <li><a href="#">شرایط استفاده</a></li>
            <li><a href="#">تماس با ما</a></li>
        </ul>
    </div>
    <div class="social-media">
        <a href="#" class="social-icon">FB</a>
        <a href="#" class="social-icon">IG</a>
        <a href="#" class="social-icon">TW</a>
    </div>
    <p>&copy; 2025 آوای ملودیک. تمام حقوق محفوظ است.</p>
</footer>

</body>
</html>
