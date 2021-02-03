<?php 
       session_start();
       if(isset($_SESSION['key'])) {
         ?>
         <script type="text/javascript">
            window.location="manager.php";
         </script>
         <?php
       }
       include('header.php');
       include('functions.php');
       $tname="users";
       $msg="";
       if(isset($_POST['name'])){
         $flag=0;
         $name=sanitize_data($con,$_POST['name']);
         $username=sanitize_data($con,$_POST['username']);
         $email=sanitize_data($con,$_POST['email']);
         $password=sanitize_data($con,$_POST['password']);
         $cpassword=sanitize_data($con,$_POST['cpassword']);
         $encrypter=rand(111111111,999999999);

         $user_colour="";
         $email_colour="";

         $count=mysqli_num_rows(mysqli_query($con,"select * from $tname where email='$email'"));
         $count1=mysqli_num_rows(mysqli_query($con,"select * from $tname where username='$username'"));
         $count2=mysqli_num_rows(mysqli_query($con,"select * from $tname where encrypter='$encrypter'"));
         while($count2!=0) {
            $encrypter=rand(111111111,999999999);
            $count2=mysqli_num_rows(mysqli_query($con,"select * from $tname where encrypter='$encrypter'"));
         }

         if($password!=$cpassword) {
            $flag=1;
            $msg="Error!!! Passwords don't match.";
         }
         if($count1>0 && $flag==0 || $username=="users" || $username=="shorturl") {
            $flag=1;
            $msg="Oops!!! This username is not available.";
            $username="";
            $user_colour="red";
         }
         if($count>0 && $flag==0) {
            $flag=1;
            $msg="Oops!!! This e-mail id is already in use. Try with nother one.";
            $email="";
            $email_colour="red";
         }
         if($flag==0) {
            $password=sha1($password);
            mysqli_query($con,"insert into $tname(name,username,email,password,encrypter) values('$name','$username','$email','$password','$encrypter')");
            $id=mysqli_insert_id($con);
            mysqli_query($con,"create table $username(id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY, link VARCHAR(1000) NOT NULL, short_link VARCHAR(30) NOT NULL, txt VARCHAR(50) NOT NULL, hit_count INT(255) NOT NULL, status INT(1) NOT NULL, ver_key INT(9) NOT NULL)");
            ?>
            <script type="text/javascript">
               window.location="login.php?id=<?php echo $id; ?>&ver=<?php echo ($id*$encrypter); ?>";
            </script>
            <?php
            die();
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
               <h3 class="title">Sign Up to Create and Manage Short Links</h3>
            </div>
            <div class="row">
               
               <div class="col-md-12">
                  <div class="panel panel-default">
                     <div class="container_form">
                        <form method="post">
                           <div class="input_form">
                              <input type="text" class="form-control" id="name" name="name" placeholder="Enter your Full Name" value="<?php echo $name; ?>" required>
                              <label>Full Name</label>
                           </div>
                           <div class="input_form">
                                 <input type="text" class="form-control" id="username" name="username" placeholder="Enter your Username" value="<?php echo $username; ?>" style="border-bottom-color: <?php echo $user_colour; ?> !important;" required>
                              <label>Username</label>
                           </div>
                           <div class="input_form">
                                 <input type="email" class="form-control" id="email" name="email" placeholder="Enter your Email-Id" value="<?php echo $email; ?>" style="border-bottom-color: <?php echo $email_colour; ?> !important;" required>
                              <label>E-mail Id</label>
                           </div>
                           <div class="input_form">
                                 <input type="password" class="form-control" id="password" name="password" maxlength="12" placeholder="Enter your password" required>
                              <label>Password</label>
                           </div>
                           <div class="input_form">
                                 <input type="password" class="form-control" id="cpassword" name="cpassword" maxlength="12" placeholder="Confirm your password" required>
                              <label>Confirm Password</label>
                           </div>
                           <div class="input_form">
                              <button type="submit" class="btn btn-info">Sign Up</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
               <div>
                  <p style="margin-left: 10px;">Already have an account? <a href="login.php" style="text-decoration: underline;">Sign In</a></p>
               </div>
            </div>
            
         </div>


          <?php include('footer.php'); ?>