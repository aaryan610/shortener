		 <?php
       error_reporting(0);
       session_start();
		 include('header.php');
       include('functions.php');
       $tname="shorturl";
       $link="";
       $title="";
		 if(isset($_POST['link'])){
			$link=sanitize_data($con,$_POST['link']);
			$short_link=sanitize_data($con,$_POST['short_link']);
         $ver_key=rand(111111111,999999999);
         $rand=rand(111111111,999999999);

         $short_colour="";

         if(isset($_SESSION['key'])) {
         $title=sanitize_data($con,$_POST['title']);
         $user_tname=$_SESSION['tname'];
         
         $count=mysqli_num_rows(mysqli_query($con,"select * from $tname where short_link='$short_link'"));
         $count1=mysqli_num_rows(mysqli_query($con,"select * from $tname where ver_key='$ver_key'"));
         while($count1!=0) {
            $ver_key=rand(111111111,999999999);
            $count1=mysqli_num_rows(mysqli_query($con,"select * from $user_tname where ver_key='$ver_key'"));
         }
         if($count>0){
            $short_colour="red";
            ?>
            <div class="alert alert-danger">
               <strong>Sorry!</strong> This keyword is already taken, try another one.
            </div>
            <?php
         }else{
            mysqli_query($con,"insert into $user_tname(link,short_link,txt,hit_count,status,ver_key) values('$link','$short_link','$title','0','1','$ver_key')");

            mysqli_query($con,"insert into $tname(user,link,short_link,txt,hit_count,status,ver_key) values('$user_tname','$link','$short_link','$title','0','1','$ver_key')");
      ?>
         <script type="text/javascript">
            window.location = "manager.php";
         </script>
         <?php
         }
      }
         else {
			
			$count=mysqli_num_rows(mysqli_query($con,"select * from $tname where short_link='$short_link'"));
         $count1=mysqli_num_rows(mysqli_query($con,"select * from $tname where ver_key='$ver_key'"));
         while($count1!=0) {
            $ver_key=rand(111111111,999999999);
            $count1=mysqli_num_rows(mysqli_query($con,"select * from $tname where ver_key='$ver_key'"));
         }
			if($count>0){
            $short_colour="red";
            ?>
            <div class="alert alert-danger">
               <strong>Sorry!</strong> This keyword is already taken, try another one.
            </div>
            <?php
			}else{
				mysqli_query($con,"insert into $tname(user,link,short_link,txt,hit_count,status,ver_key) values('users','$link','$short_link','Temp','0','1','$ver_key')");
            $id=mysqli_insert_id($con);
      ?>
         <script type="text/javascript">
            window.location = "list.php?id=<?php echo $id; ?>&ver_key=<?php echo $ver_key; ?>";
         </script>
         <?php
			}
		 }
      }
		 ?>
       <style type="text/css">
         .container_form {
            margin: 0 auto;
         }
         .input_form {
            display: flex;
            flex-direction: column-reverse;
            margin: 25px 0;
         }
         input, label {
            transition: 0.4s ease;
         }
         label {
            padding-left: 10px;
            transform: translate(4px, -14px) scale(1.02);
            margin-bottom: 2px;
            cursor: text;
            transform-origin: left top;
            color: #757575;
            position: absolute;
            font-weight: normal;
         }
         input {
            font-size: 1.2em;
            padding: 30px 10px 10px 10px;
            border: none !important;
            border-bottom: 2px solid #9e9e9e !important;
            outline: none;
            border-radius: 5px 5px 0px 0px !important;
            background-color: white !important;
         }
         input::placeholder {
            opacity: 0;
         }
         input:focus, input:not(:placeholder-shown) {
            border-bottom: 2px solid #1a2942 !important;
         }
         input:not(:placeholder-shown) ~ label, input:focus ~ label {
            transform: translate(10px, -35px) scale(0.9);
            padding-left: 0px;
            color: black;
         }
       </style>
         <div class="wraper container-fluid">
            <div class="page-title">
               <h3 class="title">Add Short Link</h3>
            </div>
            <div class="row">
               
               <div class="col-md-12">
                  <div class="panel panel-default">
                     <div class="container_form">
                        <form method="post">
                           <div class="input_form">
                              <input type="url" class="form-control" id="link" name="link" placeholder="Link" value="<?php echo $link; ?>" required>
                              <label>Link</label>
                           </div>
                           <div class="input_form">
                                 <input type="textbox" class="form-control" id="short_link" name="short_link" placeholder="URL Keyword" style="border-bottom-color: <?php echo $short_colour; ?> !important;" required>
                              <label>Short Link Keyword</label>
                           </div>
                           <a onclick="generate_key()" style="text-decoration: underline;">Generate Random Keyword</a>
                           <?php
                              if(isset($_SESSION['key'])) {
                                 ?>
                                 <div class="input_form">
                                    <input type="textbox" class="form-control" id="title" name="title" placeholder="Short Link Title" value="<?php echo $title; ?>" required>
                                    <label>Link Title</label>
                                 </div>
                                 <?php
                              }
                           ?>
                           <div class="input_form">
                              <button type="submit" class="btn btn-info">Generate</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
               <?php
                if(!isset($_SESSION['key'])) {
               ?>
                <div>
                  <p style="margin-left: 10px;">Create and manage short links by <a href="login.php" style="text-decoration: underline;">Signing In</a></p>
               </div>
               <?php } ?>
            </div>
            
         </div>
          <?php include('footer.php')?>
          <script type="text/javascript">
             function generate_key() {
               var val=document.getElementById("short_link");
               function randomString(length, chars) {
                  var result = '';
                  for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
                  return result;
               }
               var rString = randomString(7, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
               val.value=rString;
             }
          </script>