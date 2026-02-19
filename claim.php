<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Claim Item | Tompkins Trove</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

<style>
/* Reuse your existing styles for consistency */
body { margin: 0; min-height: 100vh; font-family: 'Open Sans', sans-serif; background: linear-gradient(#12345f, #0b2442); color: white; display: flex; flex-direction: column; }
.main-content { flex: 1 0 auto; }
/* 1. Base Link Style: Makes all links white by default */
a { 
  color: white; 
  text-decoration: none; 
  transition: color 0.2s ease-in-out; /* Smooth transition effect */
}

/* 2. Hover Effect: Turns links red when the mouse is over them */
a:hover { 
  color: #a32036; /* The signature Tompkins Red */
}

/* 3. Dropdown Toggle Hover: Specifically for "ABOUT US" and "FORMS" text */
.dropdown-toggle:hover {
  color: #a32036;
  transition: color 0.2s;
}

/* 4. Footer Link Hover: Ensures the footer links also turn red */
footer a:hover {
  color: #a32036;
}.homerow { background-color: #0f2d52; display: flex; align-items: center; padding: 10px 30px; border-bottom: 2px solid #a32036; }
.falcon { width: 70px; margin-right: 20px; }
.brand { display: flex; align-items: center; gap: 15px; }
.brand-title { font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 700; }
.nav { margin-left: auto; display: flex; gap: 40px; font-size: 18px; }
.container { display: flex; justify-content: center; align-items: center; padding: 60px 20px; }
.panel { background-color: #0f2d52; border: 12px solid #a32036; border-radius: 40px; width: 100%; max-width: 520px; padding: 40px; }
.panel-heading h1 { text-align: center; font-family: 'Playfair Display', serif; font-size: 42px; margin-bottom: 15px; }
.item-summary { background: rgba(255,255,255,0.1); padding: 15px; border-radius: 10px; margin-bottom: 25px; text-align: center; border: 1px dashed #e21b23; }
.form-group { margin-bottom: 22px; display: flex; flex-direction: column; align-items: center; }
label { margin-bottom: 8px; font-size: 18px; }
.form-control { width: 100%; max-width: 420px; padding: 12px; background: transparent; border: 3px solid white; border-radius: 6px; color: white; text-align: center; }
.btn-primary { display: block; width: 200px; margin: 30px auto 0; padding: 12px; background-color: #e21b23; border: none; border-radius: 30px; color: white; font-size: 18px; cursor: pointer; }
footer { background-color: black; display: flex; justify-content: space-around; padding: 20px; border-top: 2px solid #a32036; }
</style>
</head>
<body>

<div class="main-content">
  <div class="homerow">
    <div class="brand">
      <img class="falcon" src="https://resources.finalsite.net/images/f_auto,q_auto/v1744117969/katyisdorg/n6duhj5lz2w1wch9b1ae/oths.png" alt="Logo">
      <span class="brand-title"><a href="index.html">Tompkins Trove</a></span>
    </div>
    <div class="nav">
      <a href="gallery.php">BACK TO GALLERY</a>
    </div>
  </div>

  <div class="container">
    <div class="panel">
      <div class="panel-heading">
        <h1>Claim Item</h1>
        <?php
          // Get the item info from the URL to show the user what they are claiming
          $itemTitle = isset($_GET['title']) ? htmlspecialchars($_GET['title']) : "Unknown Item";
          $itemID = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : "";
        ?>
        <div class="item-summary">
            <p>You are claiming:</p>
            <h2 style="color:#e21b23;"><?php echo $itemTitle; ?></h2>
        </div>
      </div>

      <div class="panel-body">
        <form action="process_claim.php" method="post">
          <input type="hidden" name="itemID" value="<?php echo $itemID; ?>">

          <div class="form-group">
            <label>Your First Name</label>
            <input type="text" class="form-control" name="claimantFirst" required>
          </div>

          <div class="form-group">
            <label>Your Last Name</label>
            <input type="text" class="form-control" name="claimantLast" required>
          </div>

          <div class="form-group">
            <label>Student Email</label>
            <input type="email" class="form-control" name="claimantEmail" required>
          </div>

          <input type="submit" class="btn-primary" value="Confirm Claim">
        </form>
      </div>
    </div>
  </div>
</div>

<footer>
  <a href="Story.html">Information</a>
  <a href="registration.html">Registration Page</a>
  <a href="gallery.php">Gallery</a>
  <a href="Feedback.html">Feedback</a>
</footer>

</body>
</html>