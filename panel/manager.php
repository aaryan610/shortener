<?php
       session_start();
       $tname="users";
       $url_tname="shorturl";
       if(isset($_SESSION['key'])) {
          include('header.php');
          $id=$_SESSION['id'];
          $encrypter=$_SESSION['key'];
          $val=$encrypter/$id;
          $sql=mysqli_query($con,"select * from $tname where id='$id' and encrypter='$val'");
          $row=mysqli_fetch_assoc($sql);
          $_SESSION['tname']=$row['username'];
          $user_tname=$_SESSION['tname'];

          if(isset($_GET['del_key']) && $_GET['del_key']==$_SESSION['key']){
            if(mysqli_query($con,"delete from $url_tname where user='$user_tname'") && mysqli_query($con,"truncate table $user_tname")) {
              ?>
                <div class="alert alert-success">
                   <strong>Done!</strong> Every short link created by you has been deleted.
                </div>
              <?php
            }
            else {
              ?>
                <div class="alert alert-danger">
                   <strong>Oops!</strong> Looks like there was some problem, please try again.
                </div>
              <?php
            }
          }

          if(isset($_GET['type']) && $_GET['type']=='delete'){
            $short=mysqli_real_escape_string($con,$_GET['short']);
            mysqli_query($con,"delete from $url_tname where short_link='$short'");
            mysqli_query($con,"delete from $user_tname where short_link='$short'");
          }
          
           if(isset($_GET['type']) && $_GET['type']=='status'){
            $short=mysqli_real_escape_string($con,$_GET['short']);
            $status=mysqli_real_escape_string($con,$_GET['status']);
            if($status=='active'){
               mysqli_query($con,"update $url_tname set status='1' where short_link='$short'");
               mysqli_query($con,"update $user_tname set status='1' where short_link='$short'");
            }else{
               mysqli_query($con,"update $url_tname set status='0' where short_link='$short'");
               mysqli_query($con,"update $user_tname set status='0' where short_link='$short'");            }
          }
       ?>

          <style type="text/css">
            .cards_link {
                display: -ms-flexbox;
                display: flex;
                -ms-flex-wrap: wrap;
                flex-wrap: wrap;
            }
            .cards_box {
                border: 1px solid #b4b6bd;
                border-radius: 10px;
                -ms-flex: 100%;
                flex: 100%;
                max-width: 100%;
                padding: 15px;
                margin-top: 20px;
            }
            .cards_button {
              background-color: #1a2942;
              font-size: 14px;
              color: white;
              border: 1px solid #1a2942;
              border-radius: 10px;
              padding: 5px 10px;
              transition: 0.3s ease;
              -webkit-transition: 0.3s ease;
            }
            .cards_button:hover {
              background-color: #edf0f0;
              color: #1a2942;
              border: 1px solid #1a2942;
            }
         </style>

         <div class="wraper container-fluid">
            <div class="page-title">
               <h3 class="title"><?php echo $_SESSION['tname']; ?>'s Short Links</h3>
               <br>
               <!--<form class="form-horizontal">
                 <div class="form-group">
                   &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label>Sort By:&nbsp</label>
                   <select name="sort" id="sort" onchange="sort_links()">
                     <option value="latest_lf">Latest links first</option>
                     <option value="latest_ll">Latest links last</option>
                     <option value="hit_htl">Hit counts high to low</option>
                     <option value="hit_lth">Hit counts low to high</option>
                   </select>
                 </div>
               </form>-->
            </div>
            <script type="text/javascript">
              function sort_links() {
              }
            </script>
            <div class="cards_link" id="all_links">
              <?php
                $i=1;
                $sql1=mysqli_query($con,"select * from $user_tname order by id desc");
                while($row1=mysqli_fetch_assoc($sql1)) {
              ?>
              <div class="cards_box">
                <p><strong><h4 style="color: #1a2942;"><span><?php echo $i.'.'; ?></span>&nbsp&nbsp<span><?php echo $row1['txt']; ?></span></h4></strong></p>
                <p><table>
                  <tbody>
                    <tr>
                      <td>
                        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<strong>Link:-&nbsp&nbsp</strong></td><td><a href="<?php echo $row1['link']; ?>" style="text-decoration: underline;" target="_blank"><?php echo $row1['link']; ?></a>
                      </td>
                    </tr>
                  </tbody>
                </table></p>
                <p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<strong>Short Link:-</strong>&nbsp&nbsp<a id="slink<?php echo $i; ?>" href="https://llity.tech/?l=<?php echo $row1['short_link']; ?>" style="text-decoration: underline;" target="_blank">llity.tech/?l=<?php echo $row1['short_link']; ?></a>&nbsp&nbsp&nbsp<button class="cards_button" onclick="copy('#slink<?php echo $i; ?>')">Copy <i class="fa fa-copy"></i></button></p>
                <p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<strong>Hit Count:-</strong>&nbsp&nbsp<?php echo $row1['hit_count']; ?></p>
                <?php
                if($row1['status']==1) {
                ?>
                <p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="?short=<?php echo $row1['short_link']; ?>&type=status&status=deactive" style="text-decoration: underline;">Deactivate Short Link <i class="fa fa-edit"></i></a></p>
                <?php
                }
                else {
                ?>
                <p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="?short=<?php echo $row1['short_link']; ?>&type=status&status=active" style="text-decoration: underline;">Activate Short Link <i class="fa fa-edit"></i></a></p>
                <?php } ?>
                <p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="?short=<?php echo $row1['short_link']; ?>&type=delete" style="text-decoration: underline;">Delete Short Link <i class="fa fa-trash"></i></a></p>
              </div>
            <?php $i++; } ?>
            </div>
         </div>  

         <script type="text/javascript">
            function copy(element) {
               var $temp = $("<input>");
               $("body").append($temp);
               $temp.val($(element).text()).select();
               document.execCommand("copy");
               $temp.remove();
               alert("Short Link Copied");
            }
         </script>
       <?php
       include('footer.php');
    }
    else {
      ?>
      <script type="text/javascript">
         window.location="login.php";
      </script>
      <?php
    }
       ?>