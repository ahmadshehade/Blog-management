<?php

namespace App\Interfaces\Admin\Post;

interface AdminUpdatedPostInterface
{

    public function changePublished($id,$request);
}
