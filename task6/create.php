<?php

require 'dbConnection.php';

# Clean Function to sanitize the data
function Clean($input)
{
    return stripslashes(strip_tags(trim($input)));
}



# Server Side Code . . . 
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $title     = Clean($_POST['title']);
    $content = Clean($_POST['content']);

    # Validate ...... 
    $errors = [];

    # validate title 
    if(!ctype_alpha(str_replace(' ', '', $title)))
    {
        $errors['title']="please enter letters only";
    }

    //CONTENT VALIDATION

    if(empty($content))
    {
        $errors['content']="please enter a content";
    }
    if(strlen($content)<50)
    {
        $errors['content']="you should enter at least 50 characters";
    }



    # Validate Image . . . 
    if (empty($_FILES['image']['name'])) {
        $errors['image'] = "Field Required";
     } else {

       # Validate Extension . . . 
         $imageType = $_FILES['image']['type'];
        $extensionArray = explode('/', $imageType);
       $extension =  strtolower(end($extensionArray));

        $allowedExtensions = ['png', 'jpg', 'jpeg', 'webp'];    // PNG 

        if (!in_array($extension, $allowedExtensions)) {

             $errors['image'] = "File Type Not Allowed";
         }
    }



    # Check ...... 
    if (count($errors) > 0) {
        // print errors .... 

        foreach ($errors as $key => $value) {
            # code...

            echo '* ' . $key . ' : ' . $value . '<br>';
        }
    } 
    else {

        // DB cODE . . . 

        $finalName = uniqid() . time() . '.' . $extension;
        $disPath = 'uploads/' . $finalName;
        # Get Temp Path . . .
        $tempName  = $_FILES['image']['tmp_name'];

        if (move_uploaded_file($tempName, $disPath)) {

        $sql = "insert into blog (title,content,image) values ('$title','$content','$finalName')";

        $op =  mysqli_query($con, $sql);

        if ($op) {
            echo "Success , blog added";
        } else {
            echo "Failed , " . mysqli_error($con);
        }
    }
}
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <h2>Register</h2>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputtitle">title</label>
                <input type="text" class="form-control" required id="exampleInputtitle" aria-describedby="" name="title" placeholder="Enter title">
            </div>

            <div class="form-group">
                <label for="exampleInputcontent">content</label>
                <input type="text" class="form-control" required id="exampleInputcontent" name="content" placeholder="content">
            </div>


            <div class="form-group">
                <label for="exampleInputPassword">Image</label>
                <input type="file" name="image">
            </div> 

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


</body>

</html>