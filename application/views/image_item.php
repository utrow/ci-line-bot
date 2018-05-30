<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
    <style>
        #image_thum {
            width: 100%;
        }

        #buttons a {
            display: block;
width: 80%;
margin: 3px auto;
color: #fff;
line-height: 40px;
text-align: center;
        }

        #buttons .line {
            background: green;
        }

        #buttons .del {
            background: #555;
        }
    </style>
    じゅんき君に保存されている画像
    <div>
        <img id="image_thum" src="{image_url}" alt="">
    </div>
    <div id="buttons">
        <a class="line" href="{req_url}">LINEにこの画像を送る</a>
        <a class="del" href="{req_url}del">削除する</a>
        <a class="del" href="http://line.me/ti/p/4195vjKceW">LINEへ</a>
    </div>