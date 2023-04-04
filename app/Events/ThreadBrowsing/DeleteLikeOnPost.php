<?php

namespace App\Events\ThreadBrowsing;

/**
 * 書き込みのいいねが取り消された際に発生するイベント
 *
 * 書き込みにされているいいね数を返却する
 */
class DeleteLikeOnPost extends OnThreadBrowsingEvent
{
    use LikeToPost;
}
