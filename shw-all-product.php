<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="company.css">
    <title>Document</title>

</head>



<body>
    <?php

    session_start();
    if (!isset($_SESSION["signedInCustomer"]) && !isset($_SESSION["signedInAdmin"])) {
        header_remove();
        header("Location: login.php ");
        exit();
    }
    include "nav.php";




    ?>
    <main class="flexverticalcenter">
        <h2 class="spacebelowabove">Overzicht van alle producten</h2>
        <?php
        // if (!isset($_SESSION["signedInCustomer"])) {
        //     echo 'Je moet ingelogd zijn om te bestellen! <br>';
        // }
        // Verbinding maken met de database 
        require_once("dbconnect.php");

        // Alle producten ophalen met de bijbehorende gegevens
        $query = $db->prepare("SELECT product.*, category.name AS Category, supplier.company AS Supplier FROM product 
        INNER JOIN category ON category.id = product.categoryid 
        INNER JOIN supplier ON product.supplierid = supplier.id;");
        $query->execute();
        $resultq = $query->fetchAll(PDO::FETCH_ASSOC);

        // als er geen klanten aanwezig zijn, dan een foutboodschap
        if ($query->rowCount() == 0) {
            echo "<h2>Er zijn géén gegevens gevonden voor deze informatie. </h2>";
            die();
        }

        echo "<table class='tableformat'>";
        echo "<thead>
              <th>ID</th>
              <th>Product naam</th>
              <th>Category</th>
              <th>Supplier</th>
              <th>Prijs per product</th>";
        if (isset($_SESSION["signedInCustomer"])) {
            echo "<th>Hoeveelheid</th>";
        }
        ;
        echo "<th>Inactief</th> </thead>";
        echo "<tbody>";

        // Alle gegevens uit purchase op het scherm tonen
        foreach ($resultq as $data) {
            echo '<form action="" method="post">';
            echo "<tr>";
            echo "<td>" . $data["ID"] . "</td>";
            echo "<td>" . $data["productname"] . "</td>";
            echo "<td>" . $data["Category"] . "</td>";
            echo "<td>" . $data["Supplier"] . "</td>";
            echo "<td> € " . $data["price"] . "</td>";

            if (isset($_SESSION["signedInCustomer"])) {
                echo '<td> <input type="number" name="number" id="number"></td>';
                echo '<td> <input type="submit" name="add" value="add to cart"></td>';
            } elseif (isset($_SESSION["signedInAdmin"])) {
                echo "<td> " . $data["isinactive"] . "</td>";
                if ($data["isinactive"] == 1) {
                    echo '<td> <input type="submit" name="setactive" value="Zet Actief"></td>';
                } else {
                    echo '<td> <input type="submit" name="setinactive" value="Zet Inactief"></td>';
                }
            }




            // Store the $data values in hidden input fields
            echo '<input type="hidden" name="productid" value="' . $data["ID"] . '">';
            echo '<input type="hidden" name="productname" value="' . $data["productname"] . '">';
            echo '<input type="hidden" name="category" value="' . $data["Category"] . '">';
            echo '<input type="hidden" name="supplier" value="' . $data["Supplier"] . '">';
            echo '<input type="hidden" name="price" value="' . $data["price"] . '">';

            echo "</tr>";
            echo "</form>";
        }

        if (isset($_POST["add"])) {
            $number = $_POST["number"];

            if ($number < 0) {
                echo "teweinig geselecteerd";
            } else {
                // Retrieve the stored $data values
                $id = $_POST["productid"];
                $productName = $_POST["productname"];
                $category = $_POST["category"];
                $supplier = $_POST["supplier"];
                $price = $_POST["price"];
                $cost = $price * $number;
                date_default_timezone_set('Europe/Amsterdam');
                $date = date('Y-m-d', time());
                $delivered = 1;

                // Prepare the purchase insertion query
                try {
                    $fullQuery = $db->prepare("INSERT INTO purchase (clientid, purchasedate, delivered) VALUES (:clientid, :purchasedate, :delivered)");
                } catch (PDOException $e) {
                    // if the Query can't run successfully, it will give an error message
                    die("Fout bij verbinden met database: " . $e->getMessage());
                }

                // Execute the purchase insertion query
                $fullQuery->execute([
                    ":clientid" => $_SESSION["signedInCustomer"],
                    ":purchasedate" => $date,
                    ":delivered" => $delivered
                ]);

                // Fetch the last inserted purchase ID
                $purchaseId = $db->lastInsertId();

                // Prepare and execute the purchaseline insertion query
                try {
                    $fullQuery2 = $db->prepare("INSERT INTO purchaseline (purchaseid, productid, price, quantity) VALUES (:purchaseid, :productid, :price, :quantity)");
                } catch (PDOException $e) {
                    // if the Query can't run successfully, it will give an error message
                    die("Fout bij verbinden met database: " . $e->getMessage());
                }

                $fullQuery2->execute([
                    ":purchaseid" => $purchaseId,
                    ":productid" => $id,
                    ":quantity" => $number,
                    ":price" => $cost
                ]);

                $message = "Insertion successful";
            }
        }

        if (isset($_POST["setinactive"])) {
            // Haalt de productID uit de form
            $id = $_POST["productid"];
            // Checkt de huidige activiteit
            try {
                $checkactivity = $db->prepare("SELECT isinactive FROM product WHERE ID = :id");
                $checkactivity->bindValue(":id", $id);
                $checkactivity->execute();
            } catch (PDOException $e) {
                echo "Error in SQL:" . $e->getMessage();
            }


            $currentactivity = $checkactivity->fetch();

            if ($currentactivity['isinactive'] == 0) {
                try {
                    $setactivity = $db->prepare("UPDATE product SET isinactive = :activity WHERE ID = :id");
                    $setactivity->bindValue(":activity", 1);
                    $setactivity->bindValue(":id", $id);
                } catch (PDOException $e) {
                    echo "Fout in zet activiteit statement: " . $e->getMessage();
                }
                $setactivity->execute();
                echo "<script>window.location.reload()</script>";
            } else {
                echo "<p>Dit product is nu inactief</p>";
            }
            ;
        }

        if (isset($_POST["setactive"])) {
            // Haalt de productID uit de form
            $id = $_POST["productid"];
            // Checkt de huidige activiteit
            try {
                $checkactivity = $db->prepare("SELECT isinactive FROM product WHERE ID = :id");
                $checkactivity->bindValue(":id", $id);
                $checkactivity->execute();
            } catch (PDOException $e) {
                echo "Error in SQL:" . $e->getMessage();
            }


            $currentactivity = $checkactivity->fetch();

            if ($currentactivity['isinactive'] == 1) {
                try {
                    $setactivity = $db->prepare("UPDATE product SET isinactive = :activity WHERE ID = :id");
                    $setactivity->bindValue(":activity", 0);
                    $setactivity->bindValue(":id", $id);
                } catch (PDOException $e) {
                    echo "Fout in zet activiteit statement: " . $e->getMessage();
                }
                $setactivity->execute();
                echo "<script>window.location.reload()</script>";
            } else {
                echo "<p>Dit product is nu actief</p>";
            }
            ;
        }


        // Debugging: you can display the stored values
        // echo "Added purchase made: " . $productName . ", Category: " . $category . ", Supplier: " . $supplier . " , Hoeveelheid: " . $number . "   id: " . $id;
        ?>
    </main>
</body>

</html>