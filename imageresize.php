<?php
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );

header('Content-type: image/jpg');

$path = '/Applications/MAMP/htdocs/post_travel/images/';
$imageURL = '/post_travel/images/';
$image= '20220302020157flower.jpg';
$image_before =  $path.$image;


list($width, $hight) = getimagesize('test.jpg'); // 元の画像名を指定してサイズを取得
$baseImage = imagecreatefromjpeg('test.jpg'); // 元の画像から新しい画像を作る準備
$image = imagecreatetruecolor(200, 200); // サイズを指定して新しい画像のキャンバスを作成
// 画像のコピーと伸縮
imagecopyresampled($image, $baseImage, 0, 0, 0, 0, 200, 200, $width, $hight);

// コピーした画像を出力する
imagejpeg($image , 'new.jpg');
readfile('new.jpg');


exit;
require_once './dbconnect.php';



//画像を読む込む
// 画像サイズ取得
// リサイズ
// 出力


$art = new Dbc('article');
$articleData = $art->getPicture();

//DBに繋いで、画像情報を取ってきて、
//imagecreatefromjpeg(ファイルパスorURL|false) 
//新しい画像をファイルあるいは URL から作成する
//成功した場合に画像オブジェクト、エラー時に false を返します。
$path = '/Applications/MAMP/htdocs/post_travel/images/';
$imageURL = '/post_travel/images/';

$image= '20220302020157flower.jpg';
$image_before =  $path.$image;
imagecreatefromjpeg($image_before);




//getimagesize()
//入力画像の幅、高さ、タイプを計算します。
//この関数はアイテムのリストを返します。
//画像の幅と高さはそれぞれインデックス 0 と 1 に格納され、
//IMAGETYPE_XXX 定数はインデックス 2 に格納されます。
//この返された定数の値を使用して、使用する画像の種類と使用する機能。

// header('Content-Type: image/jpeg');

function load_image($filename, $type) {
    $new = 'new.jpeg';
    if( $type == IMAGETYPE_JPEG ) {
        $image = imagecreatefromjpeg($filename);
        echo "here is jpeg output:";
        //$image からjpegファイル作成
        imagejpeg($image, $new);

    }
    elseif( $type == IMAGETYPE_PNG ) {
        $image = imagecreatefrompng($filename);
        echo "here is png output:";
        imagepng($image,$new);
    }
    elseif( $type == IMAGETYPE_GIF ) {
        $image = imagecreatefromgif($filename);
        echo "here is gif output:";
        imagejpeg($image, $new);
    }
    return $new;
}

$path = '/Applications/MAMP/htdocs/post_travel/images/';
$image= '20220302020157flower.jpg';
$image_before =  $path.$image;
$filename = $image_before;

list($width, $height,$type) = getimagesize($filename);
echo "Width:" , $width,"\n";
echo "Height:", $height,"\n";
echo "Type:", $type, "\n";

$old_image = load_image($filename, $type);



// File and new size
$filename = $image_before;
$percent = 0.5;

// Get new sizes
list($width, $height, $type) = getimagesize($filename);
$newwidth = $width * $percent;
$newheight = $height * $percent;
echo $type;
// Load
$thumb = imagecreatetruecolor($newwidth, $newheight);
$source = imagecreatefromjpeg($filename);

// Resize
imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

// Output
imagejpeg($thumb);
readfile($thumb);
?>
    <!-- <div class = "pictures">
    <?php foreach($articleData as $column): ?>
    <ol class = "picture">
        <li><a href ="detail.php?id_article=<?php echo $column['id_article']; ?>">
        <li><img src="<?php echo $imageURL.($column['image']); ?>" alt="" ></li>
        <?php echo h($column['title']); ?></a></li>
        <li><?php echo h($column['post_at']);?></li>
    </ol>  
    <?php endforeach; ?> -->
