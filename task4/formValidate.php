<?php

//CLEAN FUNCTION OF THE INPUT
function clean($input){
    
    $input = trim($input); 
    $input = stripslashes($input); 
    $input = strip_tags($input); 
    return $input;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name     = clean($_POST['name']);
    $email    = clean($_POST['email']);
    $password = clean($_POST['password']);
    $address  = clean($_POST['address']);
    $gender   = $_POST['gender'];
    $url      = clean($_POST['url']);
    
    $errors = [];
    //FORM VALIDATION

    //NAME VALIDATION
    if(empty($name)) 
    { 
        $errors['name'] = 'name is required';
    }
    else if(!ctype_alpha(str_replace(' ', '', $name))) 
    {
        $errors['name'] = 'Name must be only letters';
    }

    //EMAIL VALIDATION
    if(empty($email))
    {
        $errors['email']='email is required';
    }
    else
    {
    if(filter_var($email,FILTER_VALIDATE_EMAIL))
    {
    echo $email.'<br>';
    }

    else 
    {    
        $email=filter_var($email,FILTER_SANITIZE_EMAIL);

        if(!filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            echo "the email is invalid";
        }
        else
        {
            echo $email;
        }
  
    }
}

    //PASSWORD VALIDATION
    if(empty($password))
    {
        $errors['password']='password is required';
    }

    if(strlen($password)<6)
    {
        $errors['password']='the password must be 6 characters or more';
    }

    //ADDRESS VALIDATION
    if (empty($address))
     {
        $errors['address']='address is required';
    }
    if(strlen($address)<6)
    {
        $errors['address']='the address must be 11 characters or more';
    }

    //GENDER VALIDATION
    if(empty($gender))
    {
        $errors['gender']='gender is required';
    }

    //URL VALIDATION
    if(empty($url))
    {
        $errors['url']='url is required';
    }
    if(parse_url($url)&&(!str_contains($url,'linkedin')))
    {
       $errors['url']='please enter a linkedin account';   
    }

    //FILE VALIDATION
    if (!empty($_FILES['pdf']['name'])) 
    {

        $tempName  = $_FILES['pdf']['tmp_name'];
        $fileName = $_FILES['pdf']['name'];
        $fileType = $_FILES['pdf']['type'];

        $extensionArray = explode('/', $fileType);
        $extension =  strtolower( end($extensionArray));

        $allowedExtensions = ['pdf'];  

        if (in_array($extension, $allowedExtensions)) {

            $finalName = uniqid() . time() . '.' . $extension;

            $disPath = 'uploads/' . $finalName;

            if (move_uploaded_file($tempName, $disPath))
             {
                 
                echo 'File Uploaded Successfully';
            } 
            else 
            {
                echo 'File Uploaded Failed';
            }
        } 
        else 
        {
            echo 'File Type Not Allowed';
        }
    } 
    else
    {
        echo 'Please Select File <br>';
    }
    if(count($errors) > 0){

        foreach ($errors as $key => $value) {
            # code...
            echo $key.' : '.$value.'<br>';
        }
    }
}
?>