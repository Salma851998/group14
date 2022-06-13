<?php

require 'dbConnection.php';
#get the data of the blog
$id = $_GET['id'];
$sql = "select id,title,content,image from blog where id = $id";
$resultObj = mysqli_query($con, $sql);
$data = mysqli_fetch_assoc($resultObj);
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
     }
      else
      {

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
    else
    { 
        $finalName = uniqid() . time() . '.' . $extension;
        $disPath = 'uploads/' . $finalName;
        # Get Temp Path . . .
        $tempName  = $_FILES['image']['tmp_name'];

        
        if (move_uploaded_file($tempName, $disPath))
        { 
    $sql = "update blog set title = '$title', content = '$content', image='$finalName' where id = $id";

    $op =  mysqli_query($con, $sql);

    if ($op) {
        $message =  "Success , the blog Updated";

        $_SESSION['message'] = $message;
        
        header('Location: index.php');
        exit(); 

    } 
}
else {
        echo "Failed , " . mysqli_error($con);
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
        <h2>update the blog</h2>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']).'?id='.$data['id']; ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputtitle">title</label>
                <input type="text" class="form-control" required id="exampleInputtitle" value="<?php echo $data['title'];?>" aria-describedby="" name="title" placeholder="Enter title">
            </div>

            <div class="form-group">
                <label for="exampleInputcontent">content</label>
                <input type="text" class="form-control" required id="exampleInputcontent" value="<?php echo $data['content'];?>" name="content" placeholder="content">
            </div>


            <div class="form-group">
                <label for="exampleInputPassword">Image</label>
                <input type="file" name="image" value="<?php echo $data['image'];?>">
            </div> 

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


</body>

</html>