
		 <?php
       error_reporting(0);
		 include('header.php');
       $tname="shorturl";
         $id = mysqli_real_escape_string($con,$_GET['id']);
         $ver_key = mysqli_real_escape_string($con,$_GET['ver_key']);
         $sql=mysqli_query($con,"select * from $tname where id='$id' and ver_key='$ver_key'");
         $count=mysqli_num_rows(mysqli_query($con,"select * from $tname where id='$id' and ver_key='$ver_key'"));
         if($count>0) {
            $sql=mysqli_query($con,"select * from $tname where id='$id' and ver_key='$ver_key'");
            $row=mysqli_fetch_assoc($sql);
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
               <h3 class="title">Generated Short Link</h3>
            </div>
            <div class="cards_link">
              <div class="cards_box">
                <p><strong><h4 style="color: #1a2942;">&nbsp&nbsp<span>Generated Short Link</span></h4></strong></p>
                <p><table>
                  <tbody>
                    <tr>
                      <td>
                        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<strong>Link:-&nbsp&nbsp</strong></td><td><a href="<?php echo $row['link']; ?>" style="text-decoration: underline;" target="_blank"><?php echo $row['link']; ?></a>
                      </td>
                    </tr>
                  </tbody>
                </table></p>
                <p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<strong>Short Link:-</strong>&nbsp&nbsp<a id="slink" href="https://llity.tech/?l=<?php echo $row['short_link']; ?>" style="text-decoration: underline;" target="_blank">llity.tech/?l=<?php echo $row['short_link']; ?></a>&nbsp&nbsp&nbsp<button class="cards_button" onclick="copy('#slink')">Copy <i class="fa fa-copy"></i></button></p>
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
               alert("URL Copied");
            }
         </script>
		 <?php
       }
       else {
         ?>
         <script type="text/javascript">
            window.location="form.php";
         </script>
         <?php
       }
       include('footer.php')
       ?>