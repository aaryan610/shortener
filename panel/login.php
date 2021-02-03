<?php
      error_reporting(0);
      session_start(); 
      if(isset($_SESSION['key'])) {
        ?>
        <script type="text/javascript">
          window.location="manager.php";
        </script>
        <?php
      }
      else {
       include('header.php');
       include('functions.php');
       $tname="users";
       $succ="";
       $result="";
       $email_colour="";
       $id=sanitize_data($con,$_GET['id']);
       $ver=sanitize_data($con,$_GET['ver']);
       $count=mysqli_num_rows(mysqli_query($con,"select * from $tname where id='$id' and encrypter='$ver/$id'"));
       if($count>0) {
         $succ="Account successfully created!!!";
       }
       else if($id=="null") {
         $succ="";
       }
       else {
         ?>
         <script type="text/javascript">
            window.location="login.php?id=null&ver=null";
         </script>
         <?php
       }
       if(isset($_POST['password'])){
         $email=sanitize_data($con,$_POST['email']);
         $password=sanitize_data($con,$_POST['password']);
         $password=sha1($password);

         $count=mysqli_num_rows(mysqli_query($con,"select * from $tname where email='$email' and password='$password'"));
         $count1=mysqli_num_rows(mysqli_query($con,"select * from $tname where email='$email'"));
         if($count1==0) {
            $email="";
            $email_colour="red";
            ?>
            <div class="alert alert-danger">
               <strong>Oops!</strong> The Email-Id you entered, doesn't exist. <a href="signup.php" style="text-decoration: underline;">Sign Up</a> to create an account.
            </div>
            <?php
         }
         else {
         if($count>0) {
            $sql=mysqli_query($con,"select * from $tname where email='$email' and password='$password'");
            $row=mysqli_fetch_assoc($sql);
            $_SESSION['id']=$row['id'];
            $_SESSION['key']=$row['id']*$row['encrypter'];
            $_SESSION['tname']=$row['username'];
            ?>
            <script type="text/javascript">
               window.location="manager.php";
            </script>
            <?php
         }
         else {
          ?>
            <div class="alert alert-danger">
               <strong>Oops!</strong> The Email-Id and Password you entered don't match.
            </div>
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
               <h3 class="title">Sign In to your llity Account</h3>
            </div>
            <div class="row">
               
               <div class="col-md-12">
                  <div class="panel panel-default">
                     <div class="container_form">
                        <form method="post">
                           <div class="input_form">
                                 <input type="email" class="form-control" id="email" name="email" placeholder="Enter your Email-Id" style="border-bottom-color: <?php echo $email_colour; ?> !important;" required>
                              <label>E-mail Id</label>
                           </div>
                           <div class="input_form">
                                 <input type="password" class="form-control" id="password" name="password" maxlength="12" placeholder="Enter your password" required>
                              <label>Password</label>
                           </div>
                           <div class="input_form">
                              <button type="submit" class="btn btn-info">Sign In</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
               <div>
                  <p style="margin-left: 10px;">Don't have an account? <a href="signup.php" style="text-decoration: underline;">Sign Up</a></p>
               </div>
            </div>
            
         </div>


          <?php include('footer.php'); } ?>