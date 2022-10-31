<?php

$result = 'no';             // ビンゴ判定結果の初期設定

/* ビンゴサイズ */
$S = (int)(fgets(STDIN));
/* 入力チェック */
if ($S < 3 || $S > 1000) {
    exit;
}

/* ビンゴカード */
$bingoCard = [];
for ($i = 0; $i < $S; $i++) {
    $bingoCard[$i] = explode(' ', trim(fgets(STDIN)));
}
/* 入力チェック */
for ($i = 0; $i < $S; $i++) {
    for ($j = 0; $j < $S; $j++) {
        /* 文字数 */
        if (strlen($bingoCard[$i][$j]) < 1 || strlen($bingoCard[$i][$j]) > 100 ) {
            exit;
        }
        /* 半角英数字 */
        if (preg_match("/^[a-zA-Z0-9]+$/", $bingoCard[$i][$j]) == false) {
            exit;
        }
        /* 重複 */
        $count = 0;
        for ($k = 0; $k < $S; $k++) {
            for ($l = 0; $l < $S; $l++) {
                if ($bingoCard[$i][$j] == $bingoCard[$k][$l]) {
                    $count++;
                }
            }
        }
        if ($count > 1) {
            exit;
        }
    }
}

/* 選ばれる単語数 */
$N = (int)trim(fgets(STDIN));
/* 入力チェック */
if ($N < 1 || $N > 2000) {
    exit;
}

/* 選ばれた単語のチェック */
$select = [];
for ($i = 0; $i < $N; $i++) {
    array_push($select, preg_replace("/\n|\r|\r\n/", "", fgets(STDIN)));
}
/* 入力チェック */
foreach( $select as $val ) {
    /* 文字数 */
    if (strlen($val) < 1 || strlen($val) > 100) {
        exit;
    }
    /* 半角英数字 */
    $string  = preg_replace("/( |　)/", "_", $val);             // 全角半角スペースは記号へ置換
    if (preg_match("/^[a-zA-Z0-9]+$/", $string) == false) {
        exit;
    }
    /* 重複 */
    $count = 0;
    for ($i = 0; $i < $N; $i++) {
        if ($val == $select[$i]) {
            $count++;
        }
    }
    if ($count > 1) {
        exit;
    }
}

/* ビンゴカードに印をつける */
foreach( $select as $val ) {
    for ($i = 0; $i < $S; $i++) {
        for ($j = 0; $j < $S; $j++) {
            if ($bingoCard[$i][$j] == $val) {
                $bingoCard[$i][$j] = '〇';
            }
        }
    }
}

/* ビンゴ判定 */
$lower_right = 0;               /* 斜め(右下がり)判定用 */
$lower_left = 0;                /* 斜め(左下がり)判定用 */

for ($i = 0; $i < $S; $i++) {
        $yoko = 0;              /* 横判定用 */
        $tate = 0;              /* 縦判定用 */
        
        /* 斜め(右下がり)の印チェック */
        if ($bingoCard[$i][$i] == '〇') {
            $lower_right++;
        }
        
        /* 斜め(左下がり)の印チェック */
        if ($bingoCard[$i][$S-1-$i] == '〇') {
            $lower_left++;
        }
        for ($j = 0; $j < $S; $j++) {
            /* 横の印チェック */
            if ($bingoCard[$i][$j] == '〇') {
                $yoko++;
            }
            /* 縦の印チェック */
            if ($bingoCard[$j][$i] == '〇') {
                $tate++;
            }
        }
        
        /* ビンゴした場合結果をセットして処理終了 */
        if ($yoko == $S || $tate == $S || $lower_right == $S || $lower_left == $S) {
            $result = 'yes';
            break;
        }
}

/* 判定結果出力 */
echo $result;
