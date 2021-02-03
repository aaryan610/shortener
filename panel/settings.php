<?php
       error_reporting(0);
       session_start();
       $tname="users";
       $url_tname="shorturl";
       if(isset($_SESSION['key'])) {
          include('header.php');
          include('functions.php');
          ?>
            <script type="text/javascript">
              var flag=0;
            </script>
          <?php
          $id=$_SESSION['id'];
          $encrypter=$_SESSION['key'];
          $val=$encrypter/$id;
          $sql=mysqli_query($con,"select * from $tname where id='$id' and encrypter='$val'");
          $row=mysqli_fetch_assoc($sql);
          $_SESSION['tname']=$row['username'];
          $user_tname=$_SESSION['tname'];

          $cp_colour="";
          $np_colour="";

          if($_GET['key']) {
            if($_GET['key']==$_SESSION['key']) {
              mysqli_query($con,"delete from $tname where username='$user_tname'");
              mysqli_query($con,"drop table $user_tname");
              mysqli_query($con,"delete from $url_tname where user='$user_tname'");
              ?>
              <script type="text/javascript">
                window.location="logout.php";
              </script>
              <?php
            }
            else {
              ?>
              <script type="text/javascript">
                window.location="logout.php";
              </script>
              <?php
            }
          }

          if($_GET['del_all']) {
            if($_GET['del_all']==$_SESSION['key']) {
              mysqli_query($con,"truncate table $user_tname");
              mysqli_query($con,"delete from $url_tname where user='$user_tname'");
              ?>
              <script type="text/javascript">
                window.location="manager.php";
              </script>
              <?php
            }
            else {
              ?>
              <script type="text/javascript">
                window.location="manager.php";
              </script>
              <?php
            }
          }

          if(isset($_POST['npassword'])) {
            $password=sanitize_data($con,$_POST['password']);
            $password=sha1($password);
            $npassword=sanitize_data($con,$_POST['npassword']);
            $npassword=sha1($npassword);
            if($password==$row['password']) {
              if($_POST['npassword']==$_POST['cpassword']) {
                if(mysqli_query($con,"update $tname set password='$npassword' where username='$user_tname'")) {
                  ?>
                <div class="alert alert-success">
                   <strong>Yay!</strong> Your Password has been changed successfully.
                </div>
                  <?php
                }
              }
              else {
                $np_colour="red";
                ?>
              <script type="text/javascript">
                flag=1;
              </script>
              <div id="change_alert" class="alert alert-danger" style="display: none;">
                 <strong>Oops!</strong> The New Passwords you entered don't match.
              </div>
                <?php
              }
            }
            else {
              $cp_colour="red";
              ?>
              <script type="text/javascript">
                flag=1;
              </script>
              <div id="change_alert" class="alert alert-danger" style="display: none;">
                 <strong>Oops!</strong> The Current Password you entered is wrong.
              </div>
              <?php
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
               <h3 class="title">Account Settings</h3>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="panel panel-default">
                     <div class="panel-body">
                        <div class="row">
                           <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="table-responsive">
                                 <table class="table">
                                    <tbody>
                                       <tr>
                                          <td><a style="text-decoration: underline;" onclick="change_pass()">Change Password&nbsp&nbsp<i id="change_icon" class="fa fa-chevron-circle-down" style="font-size: 15px;"></i></a></td>
                                       </tr>
                                       <tr>
                                          <td><a href="?del_all=<?php echo $_SESSION['key']; ?>" style="text-decoration: underline;" onclick="if(!confirm('<?php echo $_SESSION['tname']; ?>, are you sure you want to delete all short links?')) { return false; }">Delete All Short Links&nbsp&nbsp<i class="fa fa-trash" style="font-size: 15px;"></i></a></td>
                                       </tr>
                                       <tr>
                                          <td><a href="?key=<?php echo $_SESSION['key']; ?>" style="text-decoration: underline;" onclick="if(!confirm('<?php echo $_SESSION['tname']; ?>, are you sure you want to delete your account?')) { return false; }">Delete Account&nbsp&nbsp<i class="fa fa-user-times" style="font-size: 15px;"></i></a></td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
              <div class="col-md-12" id="change_pass" style="display: none;">
                  <div class="panel panel-default">
                     <div class="container_form">
                        <form method="post">
                           <div class="input_form">
                                 <input type="password" class="form-control" id="password" name="password" placeholder="Enter your Current Password" style="border-bottom-color: <?php echo $cp_colour; ?> !important;" required>
                              <label>Current Password</label>
                           </div>
                           <div class="input_form">
                                 <input type="password" class="form-control" id="npassword" name="npassword" maxlength="12" placeholder="Enter your New Password" style="border-bottom-color: <?php echo $np_colour; ?> !important;" required>
                              <label>New Password</label>
                           </div>
                           <div class="input_form">
                                 <input type="password" class="form-control" id="cpassword" name="cpassword" maxlength="12" placeholder="Confirm your New Password" style="border-bottom-color: <?php echo $np_colour; ?> !important;" required>
                              <label>Confirm New Password</label>
                           </div>
                           <div class="input_form">
                              <button type="submit" class="btn btn-info">Change Password</button>
                           </div>
                        </form>
                     </div>
                  </div>
             </div>
               </div>
            </div>
            
         </div>

         <script type="text/javascript">
            function copy(element) {
               var $temp = $("<input>");
               $("body").append($temp);
               $temp.val($(element).text()).select();
               document.execCommand("copy");
               $temp.remove();
            }
         </script>
       <?php
       include('footer.php');
    }
    else {
      ?>
      <script type="text/javascript">
         window.location="login.php?id=null&ver=null";
      </script>
      <?php
    }
       ?>
    <script type="text/javascript">
      var display=document.getElementById("change_pass");
      var icon=document.getElementById("change_icon");
      var alert=document.getElementById("change_alert");
      if(flag==1) {
        display.style.display="inline";
        icon.classList.remove("fa-chevron-circle-down");
        icon.classList.add("fa-chevron-circle-up");
        alert.style.display="block";
      }
      else {
        display.style.display=="none";
        icon.classList.remove("fa-chevron-circle-up");
        icon.classList.add("fa-chevron-circle-down");
      }
      function change_pass() {
        var display=document.getElementById("change_pass");
        var icon=document.getElementById("change_icon");
        var alert=document.getElementById("change_alert");
        if(display.style.display=="none") {
          display.style.display="inline";
          icon.classList.remove("fa-chevron-circle-down");
          icon.classList.add("fa-chevron-circle-up");
          alert.style.display="none";
        }
        else {
          display.style.display="none";
          icon.classList.remove("fa-chevron-circle-up");
          icon.classList.add("fa-chevron-circle-down");
          alert.style.display="none";
        }

      }
    </script>