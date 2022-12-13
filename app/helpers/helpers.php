<?php

function gravatar_url(string $email)
{
    return "https://www.gravatar.com/avatar/{md5($email)}?s=60";
}
