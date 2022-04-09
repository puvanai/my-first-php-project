<?php

    session_start();
    require_once('dbctl.php');
    $db_handle = new DBController();

    if(!empty($_GET["action"])) {
        switch($_GET["action"]) {
            case "add":
                if(!empty($_POST["quantity"])) {
                    $productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='". $_GET["code"] ."'");
                    $itemArray = array($productByCode[0] ["code"]=>(array('name'=>$productByCode[0]["name"],
                                                                          'code'=>$productByCode[0]["code"],
                                                                          'quantity'=>$_POST["quantity"],
                                                                          'price'=>$productByCode[0]["price"],
                                                                          'image'=>$productByCode[0]["image"])));
                }
                if(!empty($_SESSION["cart_item"])) {
                    if(in_array($productByCode[0]["code"], array_keys($_SESSION["cart_item"]))) {
                        foreach($_SESSION["cart_item"]  as $k => $v) {
                            if($productByCode[0]["code"]== $k) {
                                if(empty($_SESSION["cart_item"][$k]["quantity"])) {
                                    $_SESSION["cart_item"][$k]["quantity"]=0;
                                }
                                $_SESSION["cart"][$k]["quantity"] += $_POST["quantity"];
                            }
                        }
                    }else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                    }
                }else{
                    $_SESSION["cart_item"]= $itemArray;
            }
            break;
            case "remove":
                if(!empty($_SESSION["cart_item"])) {
                    foreach($_SESSION["cart_item"]as $k => $v) {
                        if($_GET["code"]== $k)
                            unset($_SESSION["cart_item"][$k]);

                        if(empty($_SESSION["cart_item"]))
                            unset($_SESSION["cart_item"]);
                    }
                }
            break;
            case "empty":
                unset($_SESSION["cart_item"]);
            break;
        }
    }
    
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="home.png"/>
        <script src="https:kit.fontawesome.com/c8e4d183c2.js" crossorigin="anonymous"></script>
        <title>shopping Web</title>

        <link rel="stylesheet" href="style.css"> 
    </head>
    <body>
    <nav>
            <!--social link and phon number-->
            <div class="social-call">
                <!--social links-->
                <div class ="social">
                    <a href="#"><i class="fab fa-facebook-f"></i></i></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></i></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></i></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></i></i></a>
                    
                </div>
                <!--phone nember-->
                <div class="phone">
                    <span>Call 094-262-4333</span>
                </div>
            </div> 
            <!--menu ใหญ-->
            <div class="navigation">
                <a href="#" class="logo">
                    <img src="images/logo-social.png"/>
                    <!--menu-->
                    <ul class="menu">
                        <li><a href="index.php">หน้าหลัก</a></li>
                        <li><a href="#">สินค้าขายดี</a></li>
                        <li><a href="#">สอบถาม</a></li>
                    </ul>
                    <!-- menuขวา-->
                  
                </a>
            </div>
        </nav>

        <div class="full-box f-slide-1">
            <!--container-->

            </div>
        </div>

        <div class="feature-heading">
            <h2>แนะนำ</h2>
        </div>




<div id="shopping-cart">
            <div class="tex-heading">Shoping cart</div>
            <a id="btnEmpty" href="index.php?action=empty">Empty Cart</a>

             <?php

                if(isset($_SESSION["cart_item"])) {
                    $total_quantity = 0;
                    $total_price = 0;
                
            ?>

            <table class="tbl-cart" cellpadding="10" cellspacing="1">
                <tbody>
                    <tr>
                        <th style="text-align: left;">Name</th>
                        <th style="text-align: left;">Code</th>
                        <th style="text-align: right;" width="5%">Quantity</th>
                        <th style="text-align: right;" width="10%">Unit Price</th>
                        <th style="text-align: right;" width="10%">Price</th>
                        <th style="text-align: center;" width="5%">Remove</th>
                    </tr>
                    <?php 
                        foreach($_SESSION ["cart_item"] as $item) {
                            $item_price = $item["quantity"] * $item["price"];
                    ?>
                    <tr>
                    <td><img src="<?php echo $item["image"]; ?>" class="cart-item-image" alt="">
                            <?php echo $item["name"]; ?>
                        </td>
                        <td><?php echo $item["code"]; ?></td>
                        <td style="text-align: right;"><?php echo $item["quantity"]; ?></td>
                        <td style="text-align: right;"><?php echo "$" . $item["price"]; ?></td>
                        <td style="text-align: right;"><?php echo "$" . number_format($item["price"],2); ?></td>
                        <td style="text-align: center;"><a href="index.php?action=remove&code=<?php echo $item["code"];?> "class="btnRemoveAction"> <img src ="images/trash.png" width="35" hight="20" alt="Remove Item"></a></td>
                    </tr>
                    <?php
                        $total_quantity += $item["quantity"];
                        $total_price += ($item["price"] * $item["quantity"]);
                        
                        }
                    ?>
                    
                    <tr>
                        <td colspan="2" align="right">Total:</td>
                        <td align="right"><?php echo $total_quantity; ?></td>
                        <td align="right" colspan="2"><?php echo "$" . number_format($total_price, 2); ?></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <?php 
                        }else{
            ?>
            <div class="no-records">Your Cart is Empty</div>
            <?php 
                    }
            ?>
        </div>
            </div>

            <div class="sl">
            <form class="imgForm" action="#" method="post" enctype="#">
            <input type="file" name="upload" />
            <input type="submit"  name="save"  value="upload" />
            </form>
            </div>

                </body>
                </htm>