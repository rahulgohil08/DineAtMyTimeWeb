<?php

class DbOperation
{
    private $con;

    /*------------------------------------------------------------------------------------------------------------------------*/


    function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');


        require_once dirname(__FILE__) . '/DbConnect.php';
        $db = new DbConnect();
        $this->con = $db->connect();
    }

    /*------------------------------------------------Place Order(entry in table)------------------------------------------------------------------------*/


    function PlaceOrder($res_id, $cust_id, $menu, $table_id, $discount, $amount, $datetime)
    {
//        echo $datetime = date('Y-m-d H:i:s', strtotime("16-03-2021 17:45"));

        $datetime = date('Y-m-d H:i:s', strtotime($datetime));

        if ($this->isAlreadySlot($res_id, $table_id, $datetime)) {
            return 2;
        }


        $stmt = "INSERT INTO `my_order`(`res_id`, `table_id`, `menu`, `cust_id`, `discount`, `amount`,`booking_date_time`) VALUES($res_id, $table_id, '$menu',$cust_id,$discount,$amount,'$datetime')";
        $data2 = mysqli_query($this->con, $stmt);

        if ($data2) {
            return 0;
        } else {
            return 1;
        }
    }


    /*---------------------------------- GET Booking Data ---------------------------------------------------*/

    function getBookingHistory($cust_id)
    {


        $stmt = "SELECT my_order.order_id,my_order.menu,my_order.amount,my_order.booking_date_time,user.cust_name,my_table.table_no,restaurant_registration.res_name FROM `my_order` JOIN restaurant_registration USING (res_id) JOIN customer_registration as user USING(cust_id) JOIN my_table USING(table_id) where my_order.cust_id = $cust_id order by my_order.booking_date_time desc";
        $data = mysqli_query($this->con, $stmt);

        $outer = array();

        while ($row = $data->fetch_assoc()) {
            $outer[] = $row;
        }

        return $outer;
    }

    /*---------------------------------- Is Already Booked?  ---------------------------------------------------*/

    public function isAlreadySlot($res_id, $table_id, $datetime)
    {


// SELECT booking_date_time - INTERVAL 30 MINUTE as backward,booking_date_time,booking_date_time + INTERVAL 30 MINUTE as forward FROM `my_order`

//        SELECT * FROM `my_order` where res_id = 1 and table_id = 1 and is_expired = 0 and (booking_date_time - INTERVAL 15 MINUTE) <= now() and (booking_date_time + INTERVAL 15 MINUTE) >= now()
//        SELECT * FROM `my_order` where res_id = 1 and table_id = 1 and is_expired = 0 and now()>=(booking_date_time - INTERVAL 15 MINUTE) and now()<= (booking_date_time + INTERVAL 15 MINUTE)
//        $query = "SELECT order_id,booking_date_time FROM `my_order` where res_id = $res_id and table_id = $table_id and is_expired = 0 and date(created_at) = date(now())";

//        SELECT * FROM `my_order` where res_id = 1 and table_id = 1 and is_expired = 0 and DATE("2021-03-23 17:45:00") = DATE(booking_date_time) and "2021-03-23 17:45:00">= (booking_date_time-INTERVAL 30 MINUTE) and "2021-03-23 17:45:00"<= (booking_date_time+INTERVAL 30 MINUTE)

        $query = "SELECT * FROM `my_order` where res_id = $res_id and table_id = $table_id and is_expired = 0 and  booking_date_time BETWEEN '$datetime'-INTERVAL 30 MINUTE and '$datetime'+INTERVAL 30 MINUTE";
        $stmt = mysqli_query($this->con, $query);

        $num = mysqli_num_rows($stmt);

        return $num > 0;


        //  15:15
        // 15:00 --  15:30   -- 14:00
        //  15:45
        //


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

        $password = base64_encode($password);

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


    function getRestaurantList($cust_id)
    {

        include_once '../Helpers/MyStatusHelper.php';

        $approved = MyStatusHelper::status['approved'];

        if ($this->isBookingAvailable($cust_id)) {

            $mData = implode(',', $this->getRestaurantListByML($cust_id));
            $stmt = "select * from `restaurant_registration` where status = '$approved' ORDER BY FIND_IN_SET(res_id, '$mData') DESC";

        } else {

            $stmt = "select * from `restaurant_registration` where status = '$approved'";
        }


        $data = mysqli_query($this->con, $stmt);

        $restaurants = array();

        while ($rs = mysqli_fetch_assoc($data)) {

            $restaurant = array();

            $restaurant['res_id'] = $rs['res_id'];
            $restaurant['res_name'] = $rs['res_name'];
            $restaurant['res_image'] = $rs['res_image'];

            array_push($restaurants, $restaurant);

        }


//        if ($this->isBookingAvailable($cust_id)) {
//
//            $res_ids = $this->getRestaurantListByML($cust_id);
//            /*echo implode(',', $res_ids);
//            echo "\n";*/
//
//            foreach ($restaurants as $key => $data) {
//
//                if (in_array($data['res_id'], $res_ids)) {
//
//                    foreach ($res_ids as $k => $v) {
//                        if ($data['res_id'] == $v && $k < count($res_ids) - 1) {
//                            $restaurants = $this->moveElement($restaurants, $k, $key);
//                        }
//                    }
//
//                }
//
//            }
//        }

        return $restaurants;
    }


    private function moveElement(&$array, $a, $b)
    {
        $p1 = array_splice($array, $a, 1);
        $p2 = array_splice($array, 0, $b);
        return array_merge($p2, $p1, $array);
    }

    /*---------------------------------------------------- Is Booking Available ----------------------------------------------------------*/


    private function isBookingAvailable($cust_id)
    {

        $stmt = "select order_id from `my_order` where cust_id = $cust_id";
        $data = mysqli_query($this->con, $stmt);
        $num = mysqli_num_rows($data);

        return $num > 0;
    }


    /*------------------------------------------- Restaurant List Machine Learning----------------------------------------------------------*/


    function getRestaurantListByML($cust_id)
    {

        $stmt = "SELECT DISTINCT(res_id) FROM `my_order` where cust_id = $cust_id ORDER BY created_at DESC";
        $data = mysqli_query($this->con, $stmt);

        $res_ids = [];

        while ($obj = $data->fetch_object()) {
            $res_ids[] = $obj->res_id;
        }

        /*
           $finale = array();

           foreach ($res_ids as $key => $data) {
               if (!empty($finale) && in_array($data, $finale)) {
                   continue;
               }
               $finale[] = $data;
           }*/


        return $res_ids;
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

    /*----------------------------------------------------Restaurant Offers ----------------------------------------------------------*/


    function getOffers($resId)
    {
        $stmt = "SELECT * FROM `manage_offers` WHERE res_id = $resId and is_active = 1";
        $data = mysqli_query($this->con, $stmt);

        $offer = array();

        while ($obj = $data->fetch_object()) {

            $offer[] = $obj;

        }
        return $offer;
    }

    /*----------------------------------------------------Restaurant Tables ----------------------------------------------------------*/


    function getRestaurantTables($resId)
    {


        $stmt = "SELECT * FROM `my_table` where res_id = $resId";
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

        while ($rs = $data->fetch_object()) {
            $user = $rs;
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


    /*----------------------------------------------- User Profile ---------------------------------------------------------------*/


    function getUserProfile($custId)
    {
        $stmt = "select * from `customer_registration` where cust_id = $custId";
        $data = mysqli_query($this->con, $stmt);
        $user = [];

        while ($rs = $data->fetch_object()) {
            $user = $rs;
        }
        return $user;
    }


    /*-----------------------------------------------Edit User Profile ---------------------------------------------------------------*/


    function editUserProfile($custId, $name, $address)
    {
        $stmt = "UPDATE customer_registration SET cust_name = '$name',cust_address='$address' WHERE cust_id = $custId";
        return mysqli_query($this->con, $stmt);

    }


    /*-----------------------------------------------Edit Profile Image ---------------------------------------------------------------*/


    function updateProfileImage($custId, $profile)
    {

        $random = substr(md5(mt_rand()), 0, 7);

        $img_name = $random . ".jpg";
        $insertion_path = "../profile/" . $img_name;

        file_put_contents($insertion_path, base64_decode($profile));


        $stmt = "UPDATE customer_registration SET cust_image = '$img_name' WHERE cust_id = $custId";
        return mysqli_query($this->con, $stmt);

    }


    /*----------------------------------------------- Change Password---------------------------------------------------*/


    function ChangePassword($old, $new, $custId)
    {

        $old = base64_encode($old);
        $new = base64_encode($new);

        $sql = "select cust_id from customer_registration where cust_password='$old'";
        $stmt = mysqli_query($this->con, $sql);

        $num = mysqli_num_rows($stmt);


        if ($num > 0) {

            $sql = "UPDATE customer_registration SET cust_password = '$new' WHERE cust_id = $custId";
            $this->con->query($sql);


            return true;
        } else {

            return false;
        }


    }

    /*
    * The read operation
    * When this method is called it is returning all the existing record of the database
    */


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
        $password = base64_encode($password);

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