<!DOCTYPE HTML PUBLIC"=//W3C//DTD HTML 4.01 Transitional//EN>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title>旅の思い出</title>
        <!-- リセットCSS -->
        <link href="https://unpkg.com/ress/dist/ress.min.css" rel="stylesheet">
        <!-- fontawesome -->
        <link href="https://use.fontawesome.com/releases/v6.0.0/css/all.css" rel="stylesheet">
        <!-- google fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Kaisei+Decol:wght@700&family=Kiwi+Maru:wght@300&family=Klee+One&display=swap" rel="stylesheet">
        <!-- bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <!-- css -->
        <link href="top.css" rel="stylesheet">
        <!-- javascript -->
        <script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js?ver=1.11.3'></script>
        <!-- lightbox -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-1.12.4.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js" type="text/javascript"></script>
    </head>
<body>

<header>
    <div class ="header"> 
        <div class ="header-left">
            <a href ="#"><h1>旅の思い出</h1></a>
            <p>日本地図に色を塗ろう</p>
        </div>  
        <nav class ="gnav">
            <ol class="menu">
                <li><a href ="register_form.php">新規登録</a> </li>
                <li><a href ="login_form.php">ログイン</a> </li>
                <li>
                    <form method="POST" action ="login.php">
                        <input type ="hidden" name="email" value="guest@guest.com">
                        <input type ="hidden" name="password"  value="111111">
                        <input type ="submit" name ="guest_login" value ="ゲストログイン" class="top-login">
                    </form>
                </li>
            </ol>
        </nav> 
    </div>
</header>

<div class ="wrapper">
    <div class ="top-wrapper">
        <div class ="top-title">
            <h1>旅の思い出を残しませんか</h1>
            <p>思い出投稿アプリ</p>
                <ol class="top-menu">
                    <li><a href ="register_form.php" class="top-btn">新規登録</a> </li>
                    <li><a href ="login_form.php" class="top-btn">ログイン</a> </li>
                    <li>
                        <form method="POST" action ="login.php">
                            <input type ="hidden" name="email" value="guest@guest.com">
                            <input type ="hidden" name="password"  value="111111">
                            <input type ="submit" name ="guest_login" value ="ゲストログイン" class="gst-btn">
                        </form>
                    </li>
                </ol>
        </div> 
        <div id="photo">
            <img src="../jp-op.png" width="100%" height="700" alt="日本地図">
        </div>
    </div>

    <div class ="main-wrapper">
        <div class="description">
            <div class="content">
                <h2 class="content-title">自分の投稿</h2>
                <a href="../private_post.png" data-lightbox="post-image" data-title="" width="470" height="220" alt="マイページ画面">
                <img src="../private_post.png" class="det-img" alt="" /></a>
                <p class="content-text">&nbsp;&nbsp;自分の思い出を投稿したり、県ごとに投稿を見ることができます。また、県ごとに色を塗ることができるので、行った場所とこれから行きたい場所を色分けしたり好みの使い方ができます。</p>
            </div>
            <div class="content">
                <h2 class="content-title">みんなの投稿</h2>
                <a href="../public_post.png" data-lightbox="post-image" data-title="" width="470" height="220" alt="みんなの投稿画面">
                <img src="../public_post.png" class="det-img" alt="" /></a>
                <p class="content-text">&nbsp;&nbsp;みんなの投稿が見れます。投稿件数によって色が変わる仕様になっています。</p>
            </div>
            <div class="content">
                <h2 class="content-title">写真の投稿</h2>
                <a href="../pic_post.png" data-lightbox="post-image" data-title="" width="470" height="220" alt="写真の投稿画面">
                <img src="../pic_post.png" class="det-img" alt="" /></a>
                <p class="content-text">&nbsp;&nbsp;写真の投稿を見ることができます。行ってみたい場所が見つかるかもしれません。</p>
            </div>
        </div>  
    </div>
    <div class ="bottom-wrapper">
        <h1>始めてみよう</h1>
            <ol class="top-menu">
              <li><a href ="register_form.php" class="top-btn">新規登録</a> </li>
              <li><a href ="login_form.php" class="top-btn">ログイン</a> </li>
              <li>
                  <form method="POST" action ="login.php">
                      <input type ="hidden" name="email" value="guest@guest.com">
                      <input type ="hidden" name="password"  value="111111">
                      <input type ="submit" name ="guest_login" value ="ゲストログイン" class="gst-btn">
                  </form>
              </li>
          </ol>
    </div> 
</div>

<footer>
    <p>&copy; 2022 oiwa 
      &nbsp;&nbsp; <a href ="../config/terms.php" class="footer-link">利用規約</a>
      &nbsp;&nbsp; <a href ="../config/privacy.php" class="footer-link">プライバシーポリシー</a>
      &nbsp;&nbsp; <a href ="../config/contact.php" class="footer-link">お問い合わせ</a></p>
</footer> 

</body>
</html>
