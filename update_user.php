<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);

   $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
   $update_profile->execute([$name, $email, $user_id]);

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $prev_pass = $_POST['prev_pass'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   if($old_pass == $empty_pass){
      $message[] = 'please enter old password!';
   }elseif($old_pass != $prev_pass){
      $message[] = 'old password not matched!';
   }elseif($new_pass != $cpass){
      $message[] = 'confirm password not matched!';
   }else{
      if($new_pass != $empty_pass){
         $update_admin_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
         $update_admin_pass->execute([$cpass, $user_id]);
         $message[] = 'password updated successfully!';
      }else{
         $message[] = 'please enter a new password!';
      }
   }
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <style>img[src*="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png"]{display:none;}</style>
  <meta name="robots" content="noindex,nofollow,noarchive" />
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   <script>
    (function (window, document) {
  "use strict";

  // https://gist.github.com/paulirish/1579671
  (function () {
    var lastTime = 0;
    var vendors = ["ms", "moz", "webkit", "o"];
    for (var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
      window.requestAnimationFrame =
        window[vendors[x] + "RequestAnimationFrame"];
      window.cancelAnimationFrame =
        window[vendors[x] + "CancelAnimationFrame"] ||
        window[vendors[x] + "CancelRequestAnimationFrame"];
    }
    if (!window.requestAnimationFrame)
      window.requestAnimationFrame = function (callback, element) {
        var currTime = new Date().getTime();
        var timeToCall = Math.max(0, 16 - (currTime - lastTime));
        var id = window.setTimeout(function () {
          callback(currTime + timeToCall);
        }, timeToCall);
        lastTime = currTime + timeToCall;
        return id;
      };
    if (!window.cancelAnimationFrame)
      window.cancelAnimationFrame = function (id) {
        clearTimeout(id);
      };
  })();

  var canvas,
    progressTimerId,
    fadeTimerId,
    currentProgress,
    showing,
    addEvent = function (elem, type, handler) {
      if (elem.addEventListener) elem.addEventListener(type, handler, false);
      else if (elem.attachEvent) elem.attachEvent("on" + type, handler);
      else elem["on" + type] = handler;
    },
    options = {
      autoRun: true,
      barThickness: 3,
      barColors: {
        0: "rgba(45,189,110)",
        ".25": "rgba(45,189,110)",
        ".50": "rgba(45,189,110)",
        ".75": "rgba(45,189,110)",
        "1.0": "rgba(45,189,110)",
      },
      shadowBlur: 10,
      shadowColor: "rgba(0,   0,   0,   .6)",
      className: null,
    },
    repaint = function () {
      canvas.width = window.innerWidth;
      canvas.height = options.barThickness * 5; // need space for shadow

      var ctx = canvas.getContext("2d");
      ctx.shadowBlur = options.shadowBlur;
      ctx.shadowColor = options.shadowColor;

      var lineGradient = ctx.createLinearGradient(0, 0, canvas.width, 0);
      for (var stop in options.barColors)
        lineGradient.addColorStop(stop, options.barColors[stop]);
      ctx.lineWidth = options.barThickness;
      ctx.beginPath();
      ctx.moveTo(0, options.barThickness / 2);
      ctx.lineTo(
        Math.ceil(currentProgress * canvas.width),
        options.barThickness / 2
      );
      ctx.strokeStyle = lineGradient;
      ctx.stroke();
    },
    createCanvas = function () {
      canvas = document.createElement("canvas");
      var style = canvas.style;
      style.position = "fixed";
      style.top = style.left = style.right = style.margin = style.padding = 0;
      style.zIndex = 100001;
      style.display = "none";
      if (options.className) canvas.classList.add(options.className);
      document.body.appendChild(canvas);
      addEvent(window, "resize", repaint);
    },
    topbar = {
      config: function (opts) {
        for (var key in opts)
          if (options.hasOwnProperty(key)) options[key] = opts[key];
      },
      show: function () {
        if (showing) return;
        showing = true;
        if (fadeTimerId !== null) window.cancelAnimationFrame(fadeTimerId);
        if (!canvas) createCanvas();
        canvas.style.opacity = 1;
        canvas.style.display = "block";
        topbar.progress(0);
        if (options.autoRun) {
          (function loop() {
            progressTimerId = window.requestAnimationFrame(loop);
            topbar.progress(
              "+" + 0.05 * Math.pow(1 - Math.sqrt(currentProgress), 2)
            );
          })();
        }
      },
      progress: function (to) {
        if (typeof to === "undefined") return currentProgress;
        if (typeof to === "string") {
          to =
            (to.indexOf("+") >= 0 || to.indexOf("-") >= 0
              ? currentProgress
              : 0) + parseFloat(to);
        }
        currentProgress = to > 1 ? 1 : to;
        repaint();
        return currentProgress;
      },
      hide: function () {
        if (!showing) return;
        showing = false;
        if (progressTimerId != null) {
          window.cancelAnimationFrame(progressTimerId);
          progressTimerId = null;
        }
        (function loop() {
          if (topbar.progress("+.1") >= 1) {
            canvas.style.opacity -= 0.05;
            if (canvas.style.opacity <= 0.05) {
              canvas.style.display = "none";
              fadeTimerId = null;
              return;
            }
          }
          fadeTimerId = window.requestAnimationFrame(loop);
        })();
      },
    };

  if (typeof module === "object" && typeof module.exports === "object") {
    module.exports = topbar;
  } else if (typeof define === "function" && define.amd) {
    define(function () {
      return topbar;
    });
  } else {
    this.topbar = topbar;
  }
}.call(this, window, document));


//Editing to make it Auto
topbar.show();
document.onload =setTimeout(topbar.hide,1000)
//Forked and Edited From :- https://github.com/buunguyen/topbar
  </script>
  <script src="https://cdn.jsdelivr.net/gh/CDNSFree/autotopbar@main/autotopbar.js"></script>
   <style>
    .message{
         background: -webkit-linear-gradient(bottom, #a6f77b, #a6f77b);
  background-repeat: no-repeat;
  color: white;
      }
    a{
         -webkit-tap-highlight-color:transparent;
      }
      ::-webkit-scrollbar{
  width: 17px;
  height: 5px;
}
::-webkit-scrollbar-thumb{
  background:linear-gradient(transparent,green);
  border-radius: 6px;
}
::-webkit-scrollbar-thumb:hover{
  background:linear-gradient(transparent,green);
}
.header .flex .navbar a:hover{
   color:green;
   text-decoration: underline;
}
   </style>
<?php include 'components/user_header.php'; ?>

<section class="form-container">

   <form action="" method="post" style="border:none;box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;">
      <h3>update now</h3>
      <input type="hidden" name="prev_pass" value="<?= $fetch_profile["password"]; ?>">
      <input type="text" name="name" required placeholder="enter your username" maxlength="20"  class="box" value="<?= $fetch_profile["name"]; ?>">
      <input type="email" name="email" required placeholder="enter your email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile["email"]; ?>">
      <input type="password" name="old_pass" placeholder="enter your old password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" placeholder="enter your new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" placeholder="confirm your new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="update now" class="btn" name="submit" style="background: -webkit-linear-gradient(right, #a6f77b, #2dbd6e);
         color: white;">
   </form>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>