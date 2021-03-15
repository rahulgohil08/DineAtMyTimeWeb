<?php

class DbOperation
{
    private $con;

    /*------------------------------------------------------------------------------------------------------------------------*/


    function __construct()
    {
        require_once dirname(__FILE__) . '/DbConnect.php';
        $db = new DbConnect();
        $this->con = $db->connect();
    }

    /*------------------------------------------------Place Order(entry in table)------------------------------------------------------------------------*/


    function PlaceOrder($res_id, $cust_id, $menu, $table_id, $amount)
    {

        if ($this->isAlreadySlot($res_id, $table_id)) {
            return 2;
        }

         $stmt = "INSERT INTO `order`(`res_id`, `table_id`, `menu`, `cust_id`, `amount`) VALUES($res_id, $cust_id, '$menu',$table_id,$amount)";
        $data2 = mysqli_query($this->con, $stmt);

        if ($data2) {
            return 0;
        } else {
            return 1;
        }
    }


    /*---------------------------------- Is Already Booked?  ---------------------------------------------------*/

    private function isAlreadySlot($res_id, $table_id)
    {

        $query = "SELECT order_id FROM `order` where res_id = $res_id and table_id = $table_id and is_expired = 0 and date(created_at) = date(now())";
        $stmt = mysqli_query($this->con, $query);
        $num = mysqli_num_rows($stmt);

        return $num > 0;
    }

    /*-------------------------------------------------Manage Offers(entry in table)-----------------------------------------------------------------------*/


    function manageOffers($code, $rid, $offer_detail, $status)
    {

        $stmt = "INSERT INTO `manage_offers` (`Promo_code`, `Res_id`, `Offer_details`, `status`)
			VALUES ('$code', '$rid', '$offer_detail','$status')";
        $data2 = mysqli_query($this->con, $stmt);

        if ($data2) {
            return true;
        } else {
            return false;
        }
    }

    /*--------------------------------------------------------Restaurant Registration----------------------------------------------------------------*/


    function res_insert($name, $email, $password, $contact, $address, $status, $image)
    {
        $q = "select * from `restaurant_registration` where res_email='$email' and res_contact='$contact'";
        $data = mysqli_query($this->con, $q);
        $row = mysqli_num_rows($data);

        if ($row > 0) {
            return false;
        }


        $img_name = md5(mt_rand());
        $img_name .= ".jpg";

        $insertion_path = "../restaurants/" . $img_name;

        file_put_contents($insertion_path, base64_decode($image));


        $stmt = "INSERT INTO `restaurant_registration` (`res_name`, `res_email`, `res_password`, `res_contact`, `res_address`, `registration_status`, `res_image`)
			VALUES ('$name', '$email', '$password','$contact','$address', '$status', '$img_name')";
        $data2 = mysqli_query($this->con, $stmt);

        if ($data2) {
            return true;
        } else {
            return false;
        }
    }

    /*------------------------------------------------Customer Registration------------------------------------------------------------------------*/


    function cust_insert($name, $email, $password, $contact, $address)
    {
        // $created = date('Y-m-d H:i:s');
        $q = "select * from `customer_registration` where cust_email='$email' or cust_contact='$contact'";
        $data = mysqli_query($this->con, $q);
        $row = mysqli_num_rows($data);
        if ($row > 0) {
            return false;
        }

        $stmt = "INSERT INTO `customer_registration` (`cust_name`, `cust_email`, `cust_password`, `cust_contact`, `cust_address`)
			VALUES ('$name', '$email', '$password','$contact','$address')";
        $data2 = mysqli_query($this->con, $stmt);

        if ($data2) {
            return true;
        } else {
            return false;
        }
    }

    /*------------------------------------------------------------------------------------------------------------------------*/


    function getRData($email)
    {
        $stmt = "select * from `restaurant_registration` where res_email = '$email'";
        $data = mysqli_query($this->con, $stmt);
        // $users = array();
        $user = array();
        while ($rs = mysqli_fetch_assoc($data)) {

            $user['name'] = $rs['res_name'];
            $user['email'] = $rs['res_email'];
            // $user['password'] = $rs['cust_password'];
            $user['contact'] = $rs['res_contact'];
            $user['address'] = $rs['res_address'];
            $user['image'] = $rs['res_image'];
            $user['created'] = $rs['registration_time'];
            // array_push($users, $user);
        }
        return $user;
    }

    /*----------------------------------------------------Restaurant List ----------------------------------------------------------*/


    function getRestaurantList()
    {
        $stmt = "select * from `restaurant_registration`";
        $data = mysqli_query($this->con, $stmt);

        $restaurants = array();

        while ($rs = mysqli_fetch_assoc($data)) {

            $restaurant = array();

            $restaurant['res_id'] = $rs['res_id'];
            $restaurant['res_name'] = $rs['res_name'];
            $restaurant['res_image'] = $rs['res_image'];

            array_push($restaurants, $restaurant);

        }
        return $restaurants;
    }

    /*----------------------------------------------------Restaurant Details ----------------------------------------------------------*/


    function getRestaurantDetails($resId)
    {
        $stmt = "select * from `restaurant_registration` where res_id = $resId";
        $data = mysqli_query($this->con, $stmt);

        $restaurant = array();

        while ($obj = $data->fetch_object()) {

            $restaurant = $obj;

        }
        return $restaurant;
    }

    /*----------------------------------------------------Restaurant Menu ----------------------------------------------------------*/


    function getRestaurantMenus($resId)
    {
        $stmt = "SELECT * FROM `menu` where res_id = $resId";
        $data = mysqli_query($this->con, $stmt);

        $menu = array();

        while ($obj = $data->fetch_object()) {

            $menu[] = $obj;

        }
        return $menu;
    }

    /*----------------------------------------------------Restaurant Tables ----------------------------------------------------------*/


    function getRestaurantTables($resId)
    {
        $stmt = "SELECT * FROM `table` where res_id = $resId";
        $data = mysqli_query($this->con, $stmt);

        $table = array();

        while ($obj = $data->fetch_object()) {

            $table[] = $obj;

        }
        return $table;
    }

    /*------------------------------------------------------------------------------------------------------------------------*/


    function getUData($email)
    {
        $stmt = "select * from `customer_registration` where cust_email = '$email'";
        $data = mysqli_query($this->con, $stmt);

        $user = array();

        while ($rs = mysqli_fetch_assoc($data)) {


            $user['id'] = $rs['cust_id'];
            $user['name'] = $rs['cust_name'];
            $user['email'] = $rs['cust_email'];
            $user['contact'] = $rs['cust_contact'];
            $user['address'] = $rs['cust_address'];
            $user['created'] = $rs['registration_time'];


        }
        return $user;
    }


    /*------------------------------------------------------------------------------------------------------------------------*/


    function getAData($email)
    {
        $stmt = "select * from `admin_login` where admin_email = '$email'";
        $data = mysqli_query($this->con, $stmt);
        // $users = array();
        $user = array();
        while ($rs = mysqli_fetch_assoc($data)) {

            $user['name'] = $rs['admin_name'];
            $user['email'] = $rs['admin_email'];

            // array_push($users, $user);
        }
        return $user;
    }

    /*------------------------------------------------------------------------------------------------------------------------*/


    function resLogin($email, $password)
    {
        $sql = "select * from `restaurant_registration` where res_email = '$email' and res_password= '$password'";
        $stmt = mysqli_query($this->con, $sql);
        $num = mysqli_num_rows($stmt);
        if ($num > 0) {
            return true;
        } else {
            return false;
        }

    }

    /*------------------------------------------------------------------------------------------------------------------------*/


    function Login($email, $password)
    {
        $sql = "select * from `customer_registration` where cust_email = '$email' and cust_password= '$password'";
        $stmt = mysqli_query($this->con, $sql);
        $num = mysqli_num_rows($stmt);
        if ($num > 0) {
            return true;
        } else {
            return false;
        }

    }

    /*------------------------------------------------------------------------------------------------------------------------*/


    function adminLogin($email, $password)
    {
        $sql = "select * from `admin_login` where admin_email = '$email' and admin_password= '$password'";
        $stmt = mysqli_query($this->con, $sql);
        $num = mysqli_num_rows($stmt);
        if ($num > 0) {
            return true;
        } else {
            return false;
        }
    }

    /*---------------------------------------------------------------------------------------------------------------------*/

    function tableLayout($resid, $layoutName, $status, $noOfSeats)
    {
        $q = "select * from `table_layout` where res_id='$resid' and layout_name='$layoutName'";
        $data = mysqli_query($this->con, $q);
        $row = mysqli_num_rows($data);
        if ($row > 0) {
            $rs = mysqli_fetch_assoc($data);
            if ($rs['no_of_seats'] != $noOfSeats) {
                $q1 = "update `table_layout` set no_of_seats='$noOfSeats' where layout_name='$layoutName' and res_id='$resid'";
                $data1 = mysqli_query($this->con, $q1);
                if ($data1)
                    return "updated";
            }
            return false;
        }

        $stmt = "INSERT INTO `table_layout` (`res_id`, `layout_name`, `status`, `no_of_seats`)
			VALUES ('$resid', '$layoutName', '$status','$noOfSeats')";
        $data2 = mysqli_query($this->con, $stmt);

        if ($data2) {
            return "inserted";
        } else {
            return false;
        }
    }

    /*---------------------------------------------------------------------------------------------------------------------*/

    function getTableList()
    {
        $stmt = "select * from `table_layout`";
        $data = mysqli_query($this->con, $stmt);

        $tables = array();

        while ($rs = mysqli_fetch_assoc($data)) {

            $table = array();

            $table['table_id'] = $rs['table_id'];
            $table['layout_name'] = $rs['layout_name'];
            $table['no_of_seats'] = $rs['no_of_seats'];

            array_push($tables, $table);

        }
        return $tables;
    }

    /*---------------------------------------------------------------------------------------------------------------------*/

    function menuItems($resid, $itemName, $price, $itemImage)
    {
        $q = "select * from `menu_category_and_items` where res_id='$resid' and item_name='$itemName'";
        $data = mysqli_query($this->con, $q);
        $row = mysqli_num_rows($data);
        if ($row > 0) {
            $rs = mysqli_fetch_assoc($data);
            if ($rs['price'] != $price) {
                $q1 = "update `menu_category_and_items` set price='$price' where item_name='$itemName' and res_id='$resid'";
                $data1 = mysqli_query($this->con, $q1);
                if ($data1)
                    return "updated";
            }
            return false;
        }

        $img_name = md5(mt_rand());
        $img_name .= ".jpg";

        $insertion_path = "../restaurants/" . $img_name;

        file_put_contents($insertion_path, base64_decode($itemImage));

        $stmt = "INSERT INTO `menu_category_and_items` (`res_id`, `item_name`, `price`, `item_image`)
			VALUES ('$resid', '$itemName', '$price','$img_name')";
        $data2 = mysqli_query($this->con, $stmt);

        if ($data2) {
            return "inserted";
        } else {
            return false;
        }
    }

    /*---------------------------------------------------------------------------------------------------------------------*/
    function getMenuItemsList()
    {
        $stmt = "select * from `menu_category_and_items`";
        $data = mysqli_query($this->con, $stmt);

        $tables = array();

        while ($rs = mysqli_fetch_assoc($data)) {

            $table = array();
            $table['res_id'] = $rs['res_id'];
            $table['item_name'] = $rs['item_name'];
            $table['price'] = $rs['price'];

            array_push($tables, $table);

        }
        return $tables;
    }

    /*---------------------------------------------------------------------------------------------------------------------*/

    function feedback($resid, $custid, $msg, $reply)
    {

        $stmt = "INSERT DISTINCT INTO `feedback` (`res_id`, `customer_id`,`feedback_msg`, `feedback_reply`)
        VALUES ('$resid', '$custid', '$msg','$reply')";
        $data2 = mysqli_query($this->con, $stmt);

        if ($data2) {
            return true;
        } else {
            return false;
        }
    }

    /*---------------------------------------------------------------------------------------------------------------------*/

    // function custHistory($custEmail,$custPassword)
    // {
    //     $q = "select * from `customer_registration` where cust_email='$custEmail' and cust_password='$custPassword'";
    //     $data = mysqli_query($this->con, $q);
    //     $row = mysqli_num_rows($data);
    //     if ($row > 0) {
    //         return true;
    //     }   
    //     else
    //         return false;
    // }

    /*---------------------------------------------------------------------------------------------------------------------*/

    function getCustOrderHistoryData($custEmail)
    {
        // $stmt = "SELECT ROW_NUMBER() OVER(), r.res_name, r.res_address, m.order_items, m.order_bill from `restaurant_registration` as r 
        // inner join `manage_order` as m on r.res_id in(SELECT m.Res_id from `customer_registration` as c 
        // inner join `manage_order` as m on c.cust_id=m.Customer_id and c.cust_email='$custEmail') and r.res_id=m.Res_id";

        $stmt = "SELECT ROW_NUMBER() OVER(), r.res_name, r.res_address, m.order_items, m.order_bill from `restaurant_registration` as r 
        inner join `manage_order` as m on r.res_id in(SELECT m.Res_id from `customer_registration` as c 
        inner join `manage_order` as m on c.cust_id=m.Customer_id and c.cust_email='$custEmail') 
        inner join `customer_registration` as c on c.cust_id=m.Customer_id where c.cust_email='$custEmail' and r.res_id=m.Res_id";
        $data1 = mysqli_query($this->con, $stmt);
        $row = mysqli_num_rows($data1);
        if ($row < 0) {
            return false;
        } else {
            $history = array();

            while ($rs = mysqli_fetch_assoc($data1)) {

                $custHistory = array();
                $custHistory['Sr. No.'] = $rs['ROW_NUMBER() OVER()'];
                $custHistory['res_name'] = $rs['res_name'];
                $custHistory['res_address'] = $rs['res_address'];
                $custHistory['order_items'] = $rs['order_items'];
                $custHistory['order_bill'] = $rs['order_bill'];

                array_push($history, $custHistory);

            }
        }
        return $history;
    }

    function getResOrderListData($resEmail)
    {
        // $stmt="SELECT ROW_NUMBER() OVER(),m.Customer_id,m.Res_T_id,m.Order_items,m.Order_type,m.Order_status,
        // m.Order_bill,m.Payment_status,m.Time_slot from `manage_order` as m where m.Res_id 
        // IN (SELECT r.res_id from `restaurant_registration` as r where r.res_email='$resEmail')";
        $stmt = "SELECT DISTINCT c.cust_name,m.Customer_id,m.Res_T_id,t.layout_name,m.Order_items,m.Order_type,m.Order_status,
        m.Order_bill,m.Payment_status,m.Time_slot from `manage_order` as m inner join `restaurant_registration` as r
        on m.Res_id IN(SELECT r.res_id from `restaurant_registration` as r where r.res_email='$resEmail') 
        inner join `customer_registration` as c on m.Customer_id=c.cust_id inner join `table_layout` as t on t.table_id = m.Res_T_id";

        $data = mysqli_query($this->con, $stmt);
        $row = mysqli_num_rows($data);
        if ($row < 0) {
            return false;
        } else {
            $i = 1;
            $list = array();
            while ($rs = mysqli_fetch_assoc($data)) {

                $orderList = array();
                $orderList['Sr. No.'] = $i;
                $orderList['cust_name'] = $rs['cust_name'];
                $orderList['Customer_id'] = $rs['Customer_id'];
                $orderList['layout_name'] = $rs['layout_name'];
                $orderList['Res_T_id'] = $rs['Res_T_id'];
                $orderList['Order_items'] = $rs['Order_items'];
                $orderList['Order_status'] = $rs['Order_status'];
                $orderList['Order_bill'] = $rs['Order_bill'];
                $orderList['Payment_status'] = $rs['Payment_status'];
                $orderList['Time_slot'] = $rs['Time_slot'];
                $i = $i + 1;
                array_push($list, $orderList);

            }

        }
        return $list;
    }

}

?>