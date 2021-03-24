<?php
require_once '../includes/DbOperation.php';

function isTheseParametersAvailable($params)
{
    $available = true;
    $missingparams = "";
    foreach ($params as $param) {
        if (!isset($_POST[$param]) || strlen($_POST[$param]) <= 0) {
            $available = false;
            $missingparams = $missingparams . ", " . $param;

        }
    }

    if (!$available) {
        $response = array();
        $response['error'] = true;
        $response['message'] = 'Parameters ' . substr($missingparams, 1, strlen($missingparams)) . ' missing';

        echo json_encode($response);
        die();

    }
}

$response = array();


if (isset($_GET['apicall'])) {

    switch ($_GET['apicall']) {

        /*-------------------------------------------Customer Registration--------------------------------------------------------------------------*/

        case 'cust_register':
            isTheseParametersAvailable(array('cust_name', 'cust_email', 'cust_password', 'cust_contact', 'cust_address'));
            $db = new DbOperation();

            $result = $db->cust_insert(
            //$_POST['cust_id'],
                $_POST['cust_name'],
                $_POST['cust_email'],
                base64_encode($_POST['cust_password']),
                $_POST['cust_contact'],
                $_POST['cust_address']
            // $_POST['registration_time']
            );

            if ($result) {
                $response['error'] = false;
                $response['message'] = 'Registered successfully';
            } else {
                $response['error'] = true;
                $response['message'] = 'Already Registered';
            }

            break;

        /*--------------------------------------------------Customer Login----------------------------------------------------------------*/

        case 'cust_login':

            isTheseParametersAvailable(array('cust_email', 'cust_password'));
            $db = new DbOperation();
            $result = $db->Login($_POST['cust_email'], base64_encode($_POST['cust_password']));

            if ($result) {
                $response['error'] = false;
                $response['message'] = 'Login successfully';
                $response['user'] = $db->getUData($_POST['cust_email']);
            } else {
                $response['error'] = true;
                $response['message'] = 'Email or password is invalid';
            }

            break;

        /*----------------------------------------------------Restaurant Registration-----------------------------------------------------------------*/

        case 'res_register':

            isTheseParametersAvailable(array('res_name', 'res_email', 'res_password', 'res_contact', 'res_address', 'registration_status', 'res_image'));

            $db = new DbOperation();

            $result = $db->res_insert(
                $_POST['res_name'],
                $_POST['res_email'],
                base64_encode($_POST['res_password']),
                $_POST['res_contact'],
                $_POST['res_address'],
                $_POST['registration_status'],
                $_POST['res_image']
            // $_POST['registration_time']
            );

            if ($result) {
                $response['error'] = false;
                $response['message'] = 'Registered successfully';
            } else {
                $response['error'] = true;
                $response['message'] = 'Already Registered';
            }


            break;

        /*------------------------------------------------Restaurant Login---------------------------------------------------------------------*/

        case 'res_login':
            isTheseParametersAvailable(array('res_email', 'res_password'));
            $db = new DbOperation();
            $result = $db->resLogin($_POST['res_email'], base64_encode($_POST['res_password']));

            if ($result) {
                $response['error'] = false;
                $response['message'] = 'Login successfully';
                $response['records'] = $db->getRData($_POST['res_email']);
            } else {
                $response['error'] = true;
                $response['message'] = 'Email or password is invalid';
            }

            break;


        /*----------------------------------------------- GET Restaurant List---------------------------------------------------*/


        case 'get_restaurant_list':

            isTheseParametersAvailable(array('cust_id'));

            $db = new DbOperation();

            $response['error'] = false;
            $response['restaurants'] = $db->getRestaurantList($_POST['cust_id']);


            break;


        /*----------------------------------------------- GET Restaurant List---------------------------------------------------*/


        case 'get_restaurant_details':

            isTheseParametersAvailable(array('res_id'));

            $db = new DbOperation();

            $response['error'] = false;
            $response['restaurant'] = $db->getRestaurantDetails($_POST['res_id']);


            break;


        /*----------------------------------------------- GET Restaurant List---------------------------------------------------*/


        case 'get_offer_list':

            isTheseParametersAvailable(array('res_id'));

            $db = new DbOperation();

            $response['error'] = false;
            $response['offers'] = $db->getOffers($_POST['res_id']);


            break;

        /*----------------------------------------------- GET Restaurant Menus---------------------------------------------------*/


        case 'get_restaurant_menus':

            isTheseParametersAvailable(array('res_id'));

            $db = new DbOperation();

            $response['error'] = false;
            $response['menus'] = $db->getRestaurantMenus($_POST['res_id']);


            break;


        /*----------------------------------------------- GET Restaurant Tables---------------------------------------------------*/


        case 'get_restaurant_tables':

            isTheseParametersAvailable(array('res_id'));

            $db = new DbOperation();

            $response['error'] = false;
            $response['tables'] = $db->getRestaurantTables($_POST['res_id']);


            break;


        /*----------------------------------------------- Is Already Slot? ---------------------------------------------------*/


        case 'is_already_slot':

            isTheseParametersAvailable(array('res_id', 'table_id', 'datetime'));

            $db = new DbOperation();
            $result = $db->isAlreadySlot(
                $_POST['res_id'],
                $_POST['table_id'],
                date('Y-m-d H:i:s', strtotime($_POST['datetime']))
            );


            if ($result) {

                $response['error'] = true;
                $response['message'] = 'This Table is already Booked';

            } else {
                $response['error'] = false;
                $response['message'] = 'Table Available';
            }

            break;


        /*----------------------------------------------- Place Order ---------------------------------------------------*/


        case 'place_order':

            isTheseParametersAvailable(array('res_id', 'cust_id', 'menu', 'table_id', 'discount', 'amount', 'datetime'));

            $db = new DbOperation();
            $result = $db->PlaceOrder(
                $_POST['res_id'],
                $_POST['cust_id'],
                $_POST['menu'],
                $_POST['table_id'],
                $_POST['discount'],
                $_POST['amount'],
                $_POST['datetime']
            );

            if ($result == 0) {

                $response['error'] = false;
                $response['message'] = 'Booking successfully';

            } else if ($result == 2) {

                $response['error'] = true;
                $response['message'] = 'This Table is already Booked';

            } else {

                $response['error'] = true;
                $response['message'] = 'Some error occurred please try again';
            }

            break;


        /*---------------------------------------- GET My Booking History-----------------------------------------------*/

        case 'get_booking_history':

            isTheseParametersAvailable(array('cust_id'));
            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = "Data Fetched Successfully";
            $response['bookings'] = $db->getBookingHistory($_POST['cust_id']);


            break;


        /*---------------------------------------------Admin Login------------------------------------------------------------------------*/

        case 'admin_login':
            isTheseParametersAvailable(array('admin_email', 'admin_password'));
            $db = new DbOperation();
            $result = $db->adminLogin($_POST['admin_email'], $_POST['admin_password']);

            if ($result) {
                $response['error'] = false;
                $response['message'] = 'Login successfully';
                $response['records'] = $db->getAData($_POST['admin_email']);
            } else {
                $response['error'] = true;
                $response['message'] = 'Email or password is invalid';
            }

            break;

        /*-----------------------------------------------Manage Order----------------------------------------------------------------------*/

        case 'manageOrder':
            isTheseParametersAvailable(array('Customer_id', 'Res_T_id', 'Res_id', 'Order_items', 'Order_type', 'Order_status', 'Order_bill', 'Payment_status'));
            $db = new DbOperation();

            $result = $db->placeOrder(
                $_POST['Customer_id'],
                $_POST['Res_T_id'],
                $_POST['Res_id'],
                $_POST['Order_items'],
                $_POST['Order_type'],
                $_POST['Order_status'],
                $_POST['Order_bill'],
                $_POST['Payment_status']
            // $_POST['registration_time']
            );

            if ($result) {
                $response['error'] = false;
                $response['message'] = 'Order Received successfully';
            } else {
                $response['error'] = true;
                $response['message'] = 'Already Placed';
            }

            break;


        /*-----------------------------------------------Manage Offers----------------------------------------------------------------------*/

        case 'manageOffers':
            isTheseParametersAvailable(array('Promo_code', 'Res_id', 'Offer_details', 'status'));
            $db = new DbOperation();

            $result = $db->manageOffers(
                $_POST['Promo_code'],
                $_POST['Res_id'],
                $_POST['Offer_details'],
                $_POST['status']
            );

            if ($result) {
                $response['error'] = false;
                $response['message'] = 'Offer Applied successfully';
            } else {
                $response['error'] = true;
                $response['message'] = 'Already Used';
            }

            break;

        /*-----------------------------------------------------Table Layout----------------------------------------------------------------*/

        case 'table_layout':
            isTheseParametersAvailable(array('res_id', 'layout_name', 'status', 'no_of_seats'));
            $db = new DbOperation();

            $result = $db->tableLayout(
                $_POST['res_id'],
                $_POST['layout_name'],
                $_POST['status'],
                $_POST['no_of_seats']
            );

            if ($result == "inserted") {
                $response['error'] = false;
                $response['message'] = 'Layout Info inserted successfully';
            } else if ($result == "updated") {
                $response['error'] = false;
                $response['message'] = 'Updated Successfuly';
            } else {
                $response['error'] = true;
                $response['message'] = 'Already available';
            }

            break;

        /*-----------------------------------------------------Table List----------------------------------------------------------------*/

        case 'table_list':
            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = $db->getTableList();

            break;

        /*----------------------------------------------------Menu Items-----------------------------------------------------------------*/
        case 'menu_items':

            isTheseParametersAvailable(array('res_id', 'item_name', 'price', 'item_image'));

            $db = new DbOperation();

            $result = $db->menuItems(
                $_POST['res_id'],
                $_POST['item_name'],
                $_POST['price'],
                $_POST['item_image']
            );

            if ($result == "inserted") {
                $response['error'] = false;
                $response['message'] = 'Item inserted successfully';
            } else if ($result == "updated") {
                $response['error'] = false;
                $response['message'] = 'Item info updated successfully';
            } else {
                $response['error'] = true;
                $response['message'] = 'Already inserted';
            }


            break;

        /*-----------------------------------------------------MenuItems List----------------------------------------------------------------*/

        case 'menu_items_list':
            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = $db->getMenuItemsList();

            break;
        /*------------------------------------------------Feedback---------------------------------------------------------------------*/

        case 'feedback':
            isTheseParametersAvailable(array('res_id', 'customer_id', 'feedback_msg', 'feedback_reply'));
            $db = new DbOperation();

            $result = $db->feedback(
                $_POST['res_id'],
                $_POST['customer_id'],
                $_POST['feedback_msg'],
                $_POST['feedback_reply']
            );

            $response['error'] = false;
            $response['message'] = 'Feedback sent successfully';

            break;
        /*----------------------------------------------------Customer Order History-----------------------------------------------------------------*/

        case 'cust_history':
            isTheseParametersAvailable(array('cust_email', 'cust_password'));
            $db = new DbOperation();

            $result = $db->Login($_POST['cust_email'], base64_encode($_POST['cust_password']));

            if ($result) {
                $response['error'] = false;
                $response['message'] = 'List of Orders';
                $response['user'] = $db->getCustOrderHistoryData($_POST['cust_email']);
            } else {
                $response['error'] = true;
                $response['message'] = 'Invalid credentials';
            }

            break;
        /*----------------------------------------------------Restaurant View Orders-----------------------------------------------------------------*/

        case 'res_order':
            isTheseParametersAvailable(array('res_email', 'res_password'));
            $db = new DbOperation();

            $result = $db->resLogin($_POST['res_email'], base64_encode($_POST['res_password']));

            if ($result) {
                $response['error'] = false;
                $response['message'] = 'Order List';
                $response['user'] = $db->getResOrderListData($_POST['res_email']);
            } else {
                $response['error'] = true;
                $response['message'] = 'Invalid credentials';
            }

            break;

        default:
            # code...
            break;


    }
} else {
    //if it is not api call
    //pushing appropriate values to response array
    $response['error'] = true;
    $response['message'] = 'Invalid API Call';
}

//displaying the response in json structure
echo json_encode($response);


?>