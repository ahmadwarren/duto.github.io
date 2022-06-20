<?php

session_start();

if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
 }

 include_once "php/config.php";
// include_once "php/join.php";

  $sql = mysqli_query($con,"SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
  if(mysqli_num_rows($sql) > 0){
      $row = mysqli_fetch_assoc($sql);
      $theme =  $row['theme'];//la mode 

  }
/* let's check if some  users have asked to join you  
  $sql0 = mysqli_query($con, "SELECT * FROM joining_list WHERE  receiver_unique_id = {$_SESSION['unique_id']}");
  $row0 = mysqli_fetch_assoc($sql0);
  if(mysqli_num_rows($sql0) > 0){
    if($row0['request'] == 'joined you'){
        $answer = "";
    }
  }
*/
  


  $sql1 = "SELECT * FROM users";
  $result = mysqli_query($con,$sql1);
  $output = "";
  $all = mysqli_num_rows($result);
  if(mysqli_num_rows($result) > 1){
      while($row1 = mysqli_fetch_assoc($result)){
          $picture = $row1['profile_picture'];
          $fname = $row1['fname'];
          $lname = $row1['lname'];
          $quote = $row1['quote'];
          $email = $row1['email'];
          $receiver_id = $row1['unique_id'];
          $unique_id = $_SESSION['unique_id'];
          $output .= '<div class="user">
                            <div class="user-profile-picture">
                                <img src="img/'.$picture.'" alt="">
                            </div>
                            <div class="user-description">
                                <h1>'.$fname.' ' .$lname. '</h1>
                                <q>'.$quote.'</q>
                                <br><br>
                                <hr>
                                <div class="user-followers-info">
                                    <p class="followers"><span>180</span> People Joined</p>
                                    <!-- <button class="send-msg"  onclick="enterInMessaging()">Send Messages</button> -->
                                    <form action="" method="post"  class="joiny">
                                        <input type="hidden" name="request" value="'.$row['email'].'" id="">
                                        <input type="hidden" name="receiver" value="'.$email.'" id="">
                                        <button type="submit"  name="join" class ="join" onclick="joining()">Join</button>
                                        <button><i class="fas fa-ellipsis-v"></i></button>
                                    </form>
                                    
                                    
                                </div>
                            </div>
                        </div>';
      }
    }

 
?>



<!--                               
                                     

                                       \\\\\\\\\                                                           \\\\
                                      \\\     \\\                                                          \\\\
                                      \\\                                                                  \\\\
                                      \\\                                                                  \\\\ 
                    \\\\\\\\\\\\      \\\\\\\\\\\    \\\   \\\\\\  \\\\\        \\\\\\\\          \\\\\\\\\\\\\
                    \\\     \\\\\     \\\     \\\\     \ \\     \\\    \\\    \\\    \\\\       \\\\       \\\\
                            \\\\\     \\\      \\\      \\\     \\\    \\\            \\\\      \\\\       \\\\
                            \\\\\     \\\      \\\      \\\     \\\    \\\            \\\\      \\\\       \\\\
                    \\\\\\\\\\\\\     \\\      \\\      \\\     \\\    \\\     \\\\\\\\\\\      \\\\       \\\\
                    \\\      \\\\     \\\      \\\      \\\     \\\    \\\    \\\     \\\\      \\\\       \\\\
                    \\\     \\\\\     \\\      \\\      \\\     \\\    \\\    \\\      \\\\     \\\\       \\\\
                    \\\\\\\\\\\\\\    \\\      \\\      \\\\    \\\    \\\     \\\\\\\\\\\\       \\\\\\\\\\\\\\




 -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>duto!</title>

    <!-- css -->

    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/icon.bmp" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/login.css">
  <?php  if($theme != "Claire"){
      echo '<link rel="stylesheet" href="theme.scss">';
  }
  
  ?>

    <!-- <script>
          //* Check that service workers are supported
    if ('serviceWorker' in navigator) {
      // Use the window load event to keep the page load performant
      window.addEventListener('load', () => {
        navigator.serviceWorker.register('./login.php');
      });
    }
    </script> -->
</head>

<body>

    <header>
        <a href="" onclick="goHome()">
            <div class="menu-logo" title="duto">
                <img src="img/icon.bmp" alt="logo">
            </div>
        </a>
        <br>
      <hr>
        <button class="menu-item" id="find-btn" title="Home" onclick="goHome()" style="background: #15c3e2;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="fill: #fff;">
                <path
                    d="M280.37 148.26L96 300.11V464a16 16 0 0 0 16 16l112.06-.29a16 16 0 0 0 15.92-16V368a16 16 0 0 1 16-16h64a16 16 0 0 1 16 16v95.64a16 16 0 0 0 16 16.05L464 480a16 16 0 0 0 16-16V300L295.67 148.26a12.19 12.19 0 0 0-15.3 0zM571.6 251.47L488 182.56V44.05a12 12 0 0 0-12-12h-56a12 12 0 0 0-12 12v72.61L318.47 43a48 48 0 0 0-61 0L4.34 251.47a12 12 0 0 0-1.6 16.9l25.5 31A12 12 0 0 0 45.15 301l235.22-193.74a12.19 12.19 0 0 1 15.3 0L530.9 301a12 12 0 0 0 16.9-1.6l25.5-31a12 12 0 0 0-1.7-16.93z" />
            </svg>
        </button>

        <button id="user-btn" class="menu-item"  title="Profile"><a href="profile.php?unique_id=<?=$unique_id?>">

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path
                    d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z" />
            </svg>
            </a>
        </button>

        <button class="menu-item" title="notification" id = "trans">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path
                    d="M224 512c35.32 0 63.97-28.65 63.97-64H160.03c0 35.35 28.65 64 63.97 64zm215.39-149.71c-19.32-20.76-55.47-51.99-55.47-154.29 0-77.7-54.48-139.9-127.94-155.16V32c0-17.67-14.32-32-31.98-32s-31.98 14.33-31.98 32v20.84C118.56 68.1 64.08 130.3 64.08 208c0 102.3-36.15 133.53-55.47 154.29-6 6.45-8.66 14.16-8.61 21.71.11 16.4 12.98 32 32.1 32h383.8c19.12 0 32-15.6 32.1-32 .05-7.55-2.61-15.27-8.61-21.71z" />
            </svg>
        </button>

        <button class="menu-item dola" style="color: #15c3e2;" title="Manage your account" onclick="goMoney()">
            <b style="font-size: 20px;">$</b>
        </button>
        
        <button class="menu-item dola" style="color: #15c3e2;" title="Manage your account"  onclick="goHelp()">
            <b style="font-size: 20px;">?</b>
        </button>


        <button class="menu-item" id="findActivePatient-btn" title="Active people">

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                <path
                    d="M96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm448 0c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm32 32h-64c-17.6 0-33.5 7.1-45.1 18.6 40.3 22.1 68.9 62 75.1 109.4h66c17.7 0 32-14.3 32-32v-32c0-35.3-28.7-64-64-64zm-256 0c61.9 0 112-50.1 112-112S381.9 32 320 32 208 82.1 208 144s50.1 112 112 112zm76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2zm-223.7-13.4C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4z" />
            </svg>
        </button>


        <!-- 
 
        <button class="menu-item">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M313.6 304c-28.7 0-42.5 16-89.6 16-47.1 0-60.8-16-89.6-16C60.2 304 0 364.2 0 438.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-25.6c0-74.2-60.2-134.4-134.4-134.4zM400 464H48v-25.6c0-47.6 38.8-86.4 86.4-86.4 14.6 0 38.3 16 89.6 16 51.7 0 74.9-16 89.6-16 47.6 0 86.4 38.8 86.4 86.4V464zM224 288c79.5 0 144-64.5 144-144S303.5 0 224 0 80 64.5 80 144s64.5 144 144 144zm0-240c52.9 0 96 43.1 96 96s-43.1 96-96 96-96-43.1-96-96 43.1-96 96-96z"/></svg>
        </button>
       
        <button class="menu-item"> 
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-200 248-248S385 8 248 8zm1111 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 1.1 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"/></svg>
        </button> -->
        <div id="pro">
            <div class="img">
            <img src="img/<?= $row['profile_picture'] ?>" alt="">
        </div>
        <h5><?= $row['fname'] ?></h5>
        </div>
    </header>



    <!-- this part will be containing all the app (section)  -->
    <section>
        <!-- Where every doctor will be found -->
        <div id="find">
            <div class="research">
                <form action="#">
                    <input type="research" placeholder="Research a doctor">
                    <button type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path
                                d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z" />
                        </svg>
                    </button>
                </form>
            </div>
            <div class="users">
                <!-- doctors : one by one -->
                <!-- title -->
                <br>
                <h1>Dear  <?=$row['fname'] ?> ,here are your nearest People :</h1>
                <br>
   

                <?= $output ?>
              <hr>  
                <div class="modal join-answer" id="id01" style="display:none;">
                    <div class="modal-content animate" id="id01">
                    <p> </p>
                    <br>
                    <br>
                    <hr>
                    <br>
                    <button type="button" onclick="hide()"
                                    class="cancelbtn">OK</button>
                    </div>
                </div>



            </div>
        </div>







        <div>
    </section>
    <aside>
    <div class="head-of-aside">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg">
                <path
                    d="M464 480H48c-26.51 0-48-21.49-48-48V80c0-26.51 21.49-48 48-48h416c26.51 0 48 21.49 48 48v352c0 26.51-21.49 48-48 48zM128 120c-22.091 0-40 17.909-40 40s17.909 40 40 40 40-17.909 40-40-17.909-40-40-40zm0 96c-22.091 0-40 17.909-40 40s17.909 40 40 40 40-17.909 40-40-17.909-40-40-40zm0 96c-22.091 0-40 17.909-40 40s17.909 40 40 40 40-17.909 40-40-17.909-40-40-40zm288-136v-32c0-6.627-5.373-12-12-12H204c-6.627 0-12 5.373-12 12v32c0 6.627 5.373 12 12 12h200c6.627 0 12-5.373 12-12zm0 96v-32c0-6.627-5.373-12-12-12H204c-6.627 0-12 5.373-12 12v32c0 6.627 5.373 12 12 12h200c6.627 0 12-5.373 12-12zm0 96v-32c0-6.627-5.373-12-12-12H204c-6.627 0-12 5.373-12 12v32c0 6.627 5.373 12 12 12h200c6.627 0 12-5.373 12-12z" />
            </svg>
            <h1>My joiners</h1>
            <form action="" method="get">
                <input type="hidden" name="search">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path
                            d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z" />
                    </svg>
                </button>
            </form>
        </div>
        <div class="body-of-aside">

            <!--  include "php/show_joined.php"  -->
        </div>
</aside>
    <!---------------------------------- scripts------------------------------------------ -->
    <script src="js/search.js"></script>
    <script src="js/main.js"></script>
    <!-- <script src="js/more.user.js"></script> -->
    <script src="js/joined.js"></script>
   
</body>

</html>
