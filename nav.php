<!-- <nav>
    Hieronder vind je een gewijzigde versie van de HTML en CSS, waarbij de hoofdelementen van het menu 
    naast elkaar staan en het tweede niveau verticaal onder het bijbehorende item van het hoofdmenu is 
    uitgelijnd. Het derde niveau staat verticaal, beginnend naast het element van het tweede niveau waar 
    het bij hoort.

    HTML-code:
  -->
<div class="nav-flex01">
  <ul class="main-menu">
    <li class="main-item"><a href="index.php">Home</a></li>
    <li class="main-item"><a href="#">Bedrijf</a>
      <ul>
        <li><a href="stat-ecofriend.php" class="scndlvl">Eco-vriendelijk</a></li>
        <li><a href="stat-deliv-return.php" class="scndlvl">Levering-retour</a></li>
        <li><a href="stat-employees.php" class="scndlvl">Medewerkers</a></li>
        <li><a href="stat-targets.php" class="scndlvl">Doelstellingen</a></li>
        <li><a href="stat-history.php" class="scndlvl">Geschiedenis</a></li>
      </ul>
    </li>
    <li class="main-item">
      <a href="#">Overzicht</a>
      <ul class="sub-menu">
        <li><a href="">Enkelvoudig</a>
          <ul>
            <li><a href="shw-all-category.php" class="thrdlvl">Categorieën</a></li>
            <li><a href="shw-all-client.php" class="thrdlvl">Klanten</a></li>
            <li><a href="show-prod-orders.php" class="thrdlvl">bestelling producten</a></li>
            <li><a href="shw-all-admins.php" class="thrdlvl">beheerders</a></li>
            <li><a href="shw-all-client.php" class="thrdlvl">Klanten</a></li>
            <li><a href="shw-all-supplier.php" class="thrdlvl">Leveranciers</a></li>
            <li><a href="shw-all-product.php" class="thrdlvl">Produkten</a></li>
            <li><a href="shw-all-purchase.php" class="thrdlvl">Aankopen</a></li>
            <li><a href="shw-all-country.php" class="thrdlvl">Landen</a></li>
            <li><a href="shw-all-inactive.php" class="thrdlvl">Inactieve Producten</a></li>
          </ul>
        </li>
        <li><a href="">
            Samengesteld
          </a>
          <ul>
            <li><a href="shw-purchdet-per-prod.php" class="thrdlvl">Aankoopdet.-prod</a></li>
            <li><a href="shw-prod-per-supl.php" class="thrdlvl">Produkt-lev</a></li>
            <li><a href="shw-prod-per-cat.php" class="thrdlvl">Produkt-cat</a></li>
          </ul>
        </li>
      </ul>
    </li>

    <li class="main-item">
      <a href="#">Informatie</a>
      <ul class="sub-menu">
        <li><a href="">Aantal</a>
          <ul>
            <li><a href="count-supl-per-country.php" class="thrdlvl">Lev per land</a></li>
            <li><a href="count-prod-per-cat.php" class="thrdlvl">Prod per catagr</a></li>
            <li><a href="count-purch-per-client.php" class="thrdlvl">Aankoop per klant</a></li>
            <li><a href="count-purline-per-purch.php" class="thrdlvl">Regels&nbsp;per&nbsp;aankoop</a></li>
            <li><a href="count-purch-per-prod.php" class="thrdlvl">Aankoop per prod</a></li>
          </ul>
        </li>
        <li><a href="">Gemiddeld</a>
          <ul>
            <li><a href="avg-prodprice-per-supl.php" class="thrdlvl">Prodprijs-lev</a></li>
            <li><a href="avg-prodprice-per-cat.php" class="thrdlvl">Prodprijs-catgr</a></li>
            <li><a href="total-price-per-purch.php" class="thrdlvl">Tot prijs-aankoop</a></li>
          </ul>
        </li>
      </ul>
    </li>

    <li class="main-item"><a href="#">Toevoegen</a>
      <ul>
        <li><a href="add-client01.php" class="scndlvl">Klant</a></li>
        <li><a href="add-supplier01.php" class="scndlvl">Leverancier</a></li>
        <li><a href="add-product01.php" class="scndlvl"> &nbsp; Product &nbsp; </a></li>
        <li><a href="add-category01.php" class="scndlvl"> &nbsp; Categorie &nbsp; </a></li>
        <li><a href="add-country01.php" class="scndlvl"> &nbsp; Land &nbsp; </a></li>
      </ul>
    </li>
    <li class="main-item"><a href="#">verwijderen</a>
      <ul>
        <li><a href="remove-client.php" class="scndlvl">Klant</a></li>
        <li><a href="remove-cat.php" class="scndlvl">Categorien</a></li>
        <li><a href="remove-product.php" class="scndlvl">producten</a></li>
        <li><a href="remove-country.php" class="scndlvl">Remove country</a></li>
        <li><a href="remove-order.php" class="scndlvl">order verwijderen</a></li>
      </ul>
    </li>
    <li class="main-item"><a href="#">Uw mening</a>
      <ul>
        <li><a href="rvw-product01.php" class="scndlvl">Klacht produkt</a></li>
        <li><a href="rvw-gd-website01.php" class="scndlvl">Compliment&nbsp;site</a></li>
        <li><a href="rvw-bad-website01.php" class="scndlvl">Klacht&nbsp;site</a></li>
        <li><a href="rvw-employee01.php" class="scndlvl">Klacht&nbsp;medewerker</a></li>
      </ul>
    </li>

    <li class="main-item"><a href="#">Account Functies</a>
      <ul>
        <?php
        if (!isset($_SESSION["signedInCustomer"]) && !isset($_SESSION["signedInAdmin"])) {
          echo '<li><a href="register.php" class="scndlvl">Registreren</a></li>';
          echo '<li><a href="login.php" class="scndlvl">Login</a></li>';
        } elseif (isset($_SESSION["signedInCustomer"])) {
          echo '<li><a href="logout.php" class="scndlvl">Log Uit</a></li>';
          echo '<li><a href="change-pass.php" class="scndlvl">verander wachtwoord</a></li>';
          echo '<li><a href="change-userinfo.php" class="scndlvl">Verander Info</a></li>';
          echo '<li><a href="supplierlist.php" class="scndlvl">Leverancier Informatie</a></li>';

          // echo '<li><a href="change-userinfo.php" class="scndlvl">Verander Userinfo</a></li>';
        } elseif (isset($_SESSION["signedInAdmin"])) {
          echo '<li><a href="logout-admin.php" class="scndlvl">Logout</a></li>';
          echo '<li><a href="change-order.php" class="scndlvl">change orders</a></li>';
          echo '<li><a href="change-supp.php" class="scndlvl">Change Supp Info</a></li>';
          echo '<li><a href="orderlist-price.php" class="scndlvl">Bestelling Informatie</a></li>';
          echo '<li><a href="orderlist.php" class="scndlvl">Bestelling lijst</a></li>';
        }
        ?>
      </ul>
    </li>

</div>
<!-- </nav> -->