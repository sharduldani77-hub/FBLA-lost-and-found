<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Gallery | Tompkins Trove</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

  <style>
    /* ---------- GLOBAL FIXES ---------- */
    * {
      box-sizing: border-box; /* Includes border in width calculations */
    }

    html, body { 
      margin: 0; 
      padding: 0;
      width: 100%;
      min-height: 100vh;
      overflow-x: hidden; /* Stops horizontal scrolling and blue space */
    }

    body { 
      display: flex; 
      flex-direction: column; 
      font-family: 'Open Sans', sans-serif; 
      background: linear-gradient(#12345f, #0b2442); 
      color: white; 
    }

    /* ---------- LINKS & NAV ---------- */
    a { 
      color: white; 
      text-decoration: none; 
      transition: color 0.2s ease-in-out; 
    }

    a:hover { color: #a32036; }

    .dropdown-toggle:hover {
      color: #a32036;
      transition: color 0.2s;
    }

    .main-content { flex: 1 0 auto; width: 100%; }
    
    footer { 
      flex-shrink: 0; 
      background-color: black; 
      display: flex; 
      justify-content: space-around; 
      padding: 30px; 
      border-top: 2px solid #a32036; 
      width: 100%;
    }

    .homerow { 
      background-color: #0f2d52; 
      display: flex; 
      align-items: center; 
      padding: 10px 30px; 
      border-bottom: 2px solid #a32036; 
      width: 100%;
    }

    .falcon { width: 70px; margin-right: 20px; }
    .brand { display: flex; align-items: center; gap: 15px; }
    .brand-title { font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 700; }
    
    .nav { margin-left: auto; display: flex; gap: 40px; font-size: 18px; }
    .dropdown { position: relative; cursor: pointer; }
    .dropdown-content { 
      position: absolute; 
      background-color: #163b6b; 
      min-width: 180px; 
      top: 30px; 
      padding: 10px 0; 
      z-index: 1000; 
      opacity: 0; 
      transform: translateY(-10px); 
      transition: 0.25s; 
      border-bottom: 3px solid #a32036; 
      pointer-events: none; 
    }
    .dropdown.active .dropdown-content { opacity: 1; transform: translateY(0); pointer-events: auto; }
    .dropdown-content a { display: block; padding: 8px 15px; }

    /* ---------- GALLERY CONTAINER ---------- */
    .container { 
      padding: 40px 20px; 
      max-width: 1200px; 
      margin: 0 auto; 
      text-align: center; 
      width: 100%;
    }

    h1 { font-family: 'Playfair Display', serif; font-size: 48px; }
    
    #searchBox { 
      padding: 12px 20px; 
      width: 100%; 
      max-width: 400px; 
      margin: 0 auto 40px; 
      display: block; 
      border: 3px solid #a32036; 
      border-radius: 30px; 
      background-color: #0f2d52; 
      color: white; 
      outline: none; 
    }

    .gallery { 
      display: flex; 
      flex-wrap: wrap; 
      gap: 30px; 
      justify-content: center; 
    }
    
    .card { 
      background-color: #0f2d52; 
      border: 4px solid #a32036; 
      border-radius: 20px; 
      padding: 20px; 
      width: 280px; 
      text-align: center; 
      transition: 0.3s; 
      display: flex; 
      flex-direction: column; 
    }

    .card img { width: 100%; height: 200px; object-fit: cover; border-radius: 10px; margin-bottom: 15px; }
    .card-title { font-size: 18px; margin-bottom: 10px; }
    .card-desc { font-size: 14px; color: #ccc; margin-bottom: 20px; flex-grow: 1; }
    
    .btn-primary { 
      background-color: #e21b23; 
      color: white; 
      border: none; 
      padding: 10px 25px; 
      border-radius: 20px; 
      cursor: pointer; 
      font-weight: 600; 
      display: inline-block;
    }
    .btn-primary:hover { background-color: #a32036; }

  </style>
</head>
<body>

<div class="main-content">
  <div class="homerow">
    <div class="brand">
      <img class="falcon" src="https://resources.finalsite.net/images/f_auto,q_auto/v1744117969/katyisdorg/n6duhj5lz2w1wch9b1ae/oths.png" alt="Tompkins Logo">
      <span class="brand-title"><a href="index.html">Tompkins Trove</a></span>
    </div>
    <div class="nav">
      <div class="dropdown"><span class="dropdown-toggle">ABOUT US</span><div class="dropdown-content"><a href="Story.html">Our Story</a><a href="Mission.html">Our Mission</a></div></div>
      <div class="dropdown"><span class="dropdown-toggle">FORMS</span><div class="dropdown-content"><a href="registration.html">Registration</a><a href="Feedback.html">Feedback</a></div></div>
      <div class="dropdown">
        <span class="dropdown-toggle">GALLERIES</span>
        <div class="dropdown-content">
          <a href="gallery.php">Gallery</a>
          <a href="archive.php">Archive</a>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <h1>Lost & Found Gallery</h1>
    <input type="text" id="searchBox" placeholder="Search for your lost item..." onkeyup="searchCards()">

    <div class="gallery">
      <?php
      $servername = "localhost"; $db_username = "root"; $db_password = ""; $dbname = "pinemill_registration";
      $conn = mysqli_connect($servername, $db_username, $db_password, $dbname);

      if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

      $sql = "SELECT id, image_path, imageTitle, imageDescription FROM users ORDER BY id DESC";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
              $dbId = $row["id"];
              $cardId = 'item-' . $dbId;
              $imageSrc = empty($row["image_path"]) ? 'uploads/placeholder.jpg' : htmlspecialchars($row["image_path"]);
              
              echo '<div class="card" id="' . $cardId . '">';
              echo '<img src="' . $imageSrc . '" alt="Lost Item">';
              echo '<p class="card-title"><strong>' . htmlspecialchars($row["imageTitle"]) . '</strong></p>';
              if (!empty($row["imageDescription"])) { 
                  echo '<p class="card-desc">' . htmlspecialchars($row["imageDescription"]) . '</p>'; 
              }
              echo '<a href="claim.php?id='.$row['id'].'&title='.urlencode($row['imageTitle']).'" class="btn-primary">Claim Item</a>';
              echo '</div>';
          }
      } else {
          echo '<p>No items found.</p>';
      }
      mysqli_close($conn);
      ?>
    </div>
  </div>
</div>

<footer>
  <a href="Story.html">Information</a>
  <a href="registration.html">Registration Page</a>
  <a href="gallery.php">Gallery</a>
  <a href="Feedback.html">Feedback</a>
</footer>

<script>
  function searchCards() {
    const query = document.getElementById("searchBox").value.toLowerCase();
    const cards = document.querySelectorAll(".card");
    cards.forEach(card => {
      const title = card.querySelector('.card-title').textContent.toLowerCase();
      card.style.display = title.includes(query) ? "flex" : "none";
    });
  }

  const dropdowns = document.querySelectorAlDl(".dropdown");
  dropdowns.forEach(d => {
    d.querySelector(".dropdown-toggle").addEventListener("click", (e) => {
      e.stopPropagation();
      d.classList.toggle("active");
    });
  });
  document.addEventListener("click", () => dropdowns.forEach(d => d.classList.remove("active")));
</script>
</body>
</html>