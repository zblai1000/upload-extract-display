<?php  
 error_reporting(0);
 if(isset($_POST["btn_zip"]))  
 {  
      $output = '';  
      if($_FILES['zip_file']['name'] != '')  
      {  
           $file_name = $_FILES['zip_file']['name'];  
           $array = explode(".", $file_name);  
           $name = $array[0];  
           $ext = $array[1];  
           //check if input is zip file 
           if($ext == 'zip')  
           {  

                $path = 'upload/';  
                $location = $path . $file_name;  

                //if upload of zip file to upload folder is successful
                if(move_uploaded_file($_FILES['zip_file']['tmp_name'], $location)){  
                    $zip = new ZipArchive;  
          
                    //extract zip file in upload folder
                    if($zip->open($location))  
                    {  
                            $zip->extractTo($path);  
                            $zip->close();  
                    }  
                    $files = scandir($path . $name);  
  
                    //display each extracted image
                    foreach($files as $file)  
                    {  
                            $file_ext = end(explode(".", $file));  
                            $allowed_ext = array('jpg', 'png');  
                            if(in_array($file_ext, $allowed_ext))  
                            {  
                                $new_name = md5(rand()).'.' . $file_ext;  
                                $output .= '<div class="col-md-6"><div style="padding:16px; border:1px solid #CCC;"><img src="upload/'.$new_name.'" width="200" height="200" /></div></div>';  
                                
                                copy($path.$name.'/'.$file, $path . $new_name);  
                                unlink($path.$name.'/'.$file);  
                            }       
                    }  
                    unlink($location);  
                    rmdir($path . $name);  
                }  

           }  
      }  
 }  


 ?>  
 
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Engineering Internship Assessment</title>
  <meta name="description" content="The HTML5 Herald" />
  <meta name="author" content="Digi-X Internship Committee" />

  <link type="text/css" rel="stylesheet" href="style.css?v=1.0" />
  <link type="text/css" rel="stylesheet" href="custom.css?v=1.0" />

</head>

<body>

    <div class="top-wrapper">
        <img src="https://assets.website-files.com/5cd4f29af95bc7d8af794e0e/5cfe060171000aa66754447a_n-digi-x-logo-white-yellow-standard.svg" alt="digi-x logo" height="70" />
        <h1>Engineering Internship Assessment</h1>
    </div>

    <div class="instruction-wrapper">
        <h2>What you need to do?</h2>
        <h3 style="margin-top:31px;">Using this HTML template, create a page that can:</h3>
        <ol>
            <li><b class="yellow">Upload</b> a zip file - containing 5 images (Cats, or Dogs, or even Pokemons)</li>
            <li>after uploading, <b class="yellow">Extract</b> the zip to get the images </li>
            <li><b class="yellow">Display</b> the images on this page</li>
        </ol>

        <h2 style="margin-top:51px;">The rules?</h2>
        <ol>
            <li>May use <b class="yellow">any programming language/script</b>. The simplest the better *wink*</li>
            <li><b class="yellow">Best if this project could be hosted</b></li>
            <li><b class="yellow">If you are not hosting</b>, please provide a video as proof (GDrive video link is ok)</li>
            <li><b class="yellow">Submit your code</b> by pushing to your own github account, and share the link with us</li>
        </ol>

        
    </div>

    <form method="post" enctype="multipart/form-data">  
        <label>Please Select Zip File</label>  
        <input type="file" name="zip_file" />  
        <br />  
        <input type="submit" name="btn_zip" value="Upload" />  
   </form> 

    <!-- DO NO REMOVE CODE STARTING HERE -->
    <div class="display-wrapper">
        <h2 style="margin-top:51px;">My images</h2>
        <div class="append-images-here">
            <p>No image found. Your extracted images should be here.</p>
            <?php  
                if(isset($output))  
                {  
                     echo $output;  
                }  
                echo $size;
            ?> 
        </div>
    </div>
    <!-- DO NO REMOVE CODE UNTIL HERE -->

</body>



</html>