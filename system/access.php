<?

function has_access($access, $targetAccess){
  return strhas($access, "|$targetAccess|") ? true: false;
}



function get_access_name(){
  if (isGuest()){
    return "میهمان";
  }

  $accessName = "";

  if (isSuperAdmin()){
    $accessName .= ", " . "مدیر کل";
  } else if (isAdmin()){
    $accessName .= ", " . "مدیر";
  }

  if (isVip()){
    $accessName .= ", " . "عضو ویژه";
  } else if (isUser()){
    $accessName .= ", " . "کاربر عادی";
  }

  if (isVipAuthor()){
    $accessName .= ", " . "نویسنده ویژه";
  } else if (isAuthor()){
    $accessName .= ", " . "نویسنده";
  }

  return $accessName;
}



function isAdmin(){
  if (isGuest()) {return false;}

  $access = session_get('access');

  if (has_access($access, 'admin') || has_access($access, 'superadmin')){
    return true;
  }

  return false;
}



function isSuperAdmin(){
  if (isGuest()) {return false;}

  $access = session_get('access');

  if (has_access($access, 'superadmin')){
    return true;
  }

  return false;
}



function isAuthor(){
  if (isGuest()) {return false;}

  $access = session_get('access');

  if (has_access($access, 'vipauthor') || has_access($access, 'author')){
    return true;
  }

  return false;
}



function isVipAuthor(){
  if (isGuest()) {return false;}

  $access = session_get('access');

  if (has_access($access, 'vipauthor')){
    return true;
  }

  return false;
}



function isVip(){
  if (isGuest()) {return false;}

  $access = session_get('access');

  if (has_access($access, 'vip')){
    return true;
  }

  return false;
}



function isUser(){
  return session_isset('access') ? true: false;
}



function isGuest(){
  $userId = getUserId();
  return $userId == 0;
}



function grantSuperAdmin(){
  if (!isSuperAdmin()){
    echo "Forbidden";
    exit;
  }
}



function grantAdmin(){
  if (!isAdmin()){
    echo "Forbidden";
    exit;
  }
}



function grantAuthor(){
  if (!isAuthor()){
    message('fail', "Forbidden", true);
    exit;
  }
}



function grantVipAuthor(){
  if (!isVipAuthor()){
    echo "Forbidden";
    exit;
  }
}



function grantUser(){
  if (isGuest()){
    echo "Forbidden";
    exit;
  }
}

?>