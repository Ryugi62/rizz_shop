<?php
session_start();
include('./config/db.php');

// 랭킹 상품 조회 (판매순으로 정렬, 상위 8개)
$ranking_stmt = $pdo->query("SELECT id, product_name, product_image, price FROM products ORDER BY sold_count DESC LIMIT 8");
$ranking_products = $ranking_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RISZE - SHOP</title>

    <!-- 외부 스타일 시트 링크 -->
    <link rel="stylesheet" href="./style.css">

    <style>
        main {
            position: relative;
        }

        .video_banner {
            position: relative;
            width: 100%;
            height: 900px;
            overflow: hidden;
        }

        .video_banner video {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .video_banner .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 3rem;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        #slogan {
            white-space: pre;
            text-align: center;
            font-size: 3rem;
        }

        .index_view {
            height: auto;
        }

        .ranking_section {
            gap: 16px;
            width: 100%;
            display: flex;
            margin: 40px 0;
            align-items: center;
            flex-direction: column;
        }

        .section_title {
            width: 100%;
            text-align: left;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 16px;
            border-bottom: 1px solid var(--light-gray);
            padding-bottom: 8px;
        }

        .product_list {
            display: grid;
            gap: 60px;
            width: 100%;
            justify-items: center;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }

        .view_all_link {
            margin-top: 20px;
            text-align: center;
            width: 100%;
        }

        .view_all_link a {
            color: var(--main);
            text-decoration: none;
            font-weight: bold;
        }

        .view_all_link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <?php include("./Components/HeaderComponents.php") ?>

    <main>
        <!-- 비디오 배너 -->
        <div class="video_banner">
            <video src="./assets/video/main_video.mp4" autoplay loop muted></video>
            <div class="overlay">
                <div class="slogan_section">
                    <p id="slogan"></p>
                </div>
            </div>
        </div>

        <div class="index_view view">
            <!-- 랭킹 상품 섹션 -->
            <div class="ranking_section">
                <h2 class="section_title">랭킹 상품</h2>
                <div class="product_list">
                    <?php
                    foreach ($ranking_products as $rp) {
                        $product = array(
                            'id' => $rp['id'],
                            'image' => $rp['product_image'],
                            'name' => $rp['product_name'],
                            'price' => $rp['price']
                        );
                        $mode = '';
                        include("./Components/ProductComponents.php");
                    }
                    ?>
                </div>
                <div class="view_all_link">
                    <!-- < href="product.php">전체상품 보러가기 \→</a> -->
                    <a href="product.php">전체상품 보러가기 →</a>
                </div>
            </div>
        </div>
    </main>

    <?php include("./Components/FooterComponents.php") ?>
</body>

<script>
    const sloganText = ['"a unique hoodie, and,', 'with me in it."'];
    const typingSpeed = 100;
    const delayBetweenLines = 1000;
    const sloganElement = document.getElementById('slogan');

    let currentLine = 0;
    let currentChar = 0;

    function typeNextCharacter() {
        if (currentChar < sloganText[currentLine].length) {
            sloganElement.textContent += sloganText[currentLine][currentChar];
            currentChar++;
            setTimeout(typeNextCharacter, typingSpeed);
        } else {
            if (currentLine < sloganText.length - 1) {
                currentLine++;
                currentChar = 0;
                setTimeout(() => {
                    sloganElement.textContent += '\n';
                    typeNextCharacter();
                }, delayBetweenLines);
            }
        }
    }

    typeNextCharacter();
</script>

</html>