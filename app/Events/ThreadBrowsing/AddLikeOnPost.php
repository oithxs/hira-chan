<?php

namespace App\Events\ThreadBrowsing;

/**
 * 書き込みにいいねがされた際に発生するイベント
 *
 * 書き込みにされたいいね数を返却する
 */
class AddLikeOnPost extends OnThreadBrowsingEvent
{
    use LikeToPost;
}
