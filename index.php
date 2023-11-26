<?php

include 'components/connect.php';


if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" href="images/shop.ico" size="25*25" type="image/x-icon" />
  <style>img[src*="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png"]{display:none;}</style>
  <meta name="robots" content="noindex,nofollow,noarchive" />
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Gem Kirana Pasal</title>
   
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
       body{
         background: -webkit-linear-gradient(bottom, #2dbd6e, #a6f77b);
  background-repeat: no-repeat;
      }
      .message{
         background: -webkit-linear-gradient(bottom, #a6f77b, #a6f77b);
  background-repeat: no-repeat;
  color: white;
      }
      .btn{
         background: -webkit-linear-gradient(right, #a6f77b, #2dbd6e);
         color: white;
      }

      a{
         -webkit-tap-highlight-color:transparent;
      }

.header .flex .navbar a:hover{
   color:green;
   text-decoration: underline;
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

   </style>
<?php include 'components/user_header.php'; ?>

<section class="products">

   <h1 class="heading" style="color: white;">Gem Kirana Pasal</h1>

   <div class="box-container">

   <?php
     $select_products = $conn->prepare("SELECT * FROM `products`"); 
     $select_products->execute();
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box" style="border:none;box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;width: 100%;">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
      <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
      <div class="name" style="color: limegreen;"><?= $fetch_product['name']; ?></div>
      <div class="flex">
         <div class="price" style="color: green"><span>Rs.</span><?= $fetch_product['price']; ?><span>/-</span></div>
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty" style="border:none;box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;color:white;">no products found!</p>';
   }
   ?>

   </div>
   <button class="top-btn" style="
  all: unset; 
  position: fixed;
  right: 20px;
  bottom: 20px;
  cursor: pointer;
  transform:scale(1.8);
  opacity: 0;
  transition: .3s;
  outline: none;
  -webkit-tap-highlight-color:transparent;
  "><img src="images/arrow3.png" width="18px"></button>

</section>
<br>












<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

      <script>

let topBtn = document.querySelector(".top-btn");


topBtn.onclick = () => window.scrollTo({ top: 0, behavior: "smooth" });


window.onscroll = () => window.scrollY > 500 ? topBtn.style.opacity = 1 : topBtn.style.opacity = 0
</script>

</body>
</html>