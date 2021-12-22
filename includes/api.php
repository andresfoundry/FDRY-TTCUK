<?php

add_action(
    'rest_api_init',
    function () {
        register_rest_route(
            'tcw/v1',
            '/capLookup/',
            [
                'methods' => 'POST',
                'callback' => 'cns_cap_lookup',
                'show_in_index' => false
            ]
        );
        register_rest_route(
            'tcw/v1',
            '/capValuation/',
            [
                'methods' => 'POST',
                'callback' => 'cns_cap_valuation',
                'show_in_index' => false
            ]
        );
        register_rest_route(
            'tcw/v1',
            '/getModels/',
            [
                'methods' => 'POST',
                'callback' => 'cns_get_models',
                'show_in_index' => false
            ]
        );
        register_rest_route(
            'tcw/v1',
            '/tcVehicles/',
            [
                'methods' => 'POST',
                'callback' => 'cns_tc_vehicles',
                'show_in_index' => false
            ]
        );
        register_rest_route(
            'tcw/v1',
            '/tcVehicleReg/',
            [
                'methods' => 'POST',
                'callback' => 'cns_tc_vehicle_reg',
                'show_in_index' => false
            ]
        );
        register_rest_route(
            'tcw/v1',
            '/tcVehicleStatus/',
            [
                'methods' => 'POST',
                'callback' => 'cns_tc_vehicle_status',
                'show_in_index' => false
            ]
        );
        register_rest_route(
            'tcw/v1',
            '/tcVehicleRegStatus/',
            [
                'methods' => 'POST',
                'callback' => 'cns_tc_vehicle_reg_status',
                'show_in_index' => false
            ]
        );
        register_rest_route(
            'tcw/v1',
            '/tcVehicleReserve/',
            [
                'methods' => 'POST',
                'callback' => 'cns_tc_vehicle_reserve',
                'show_in_index' => false
            ]
        );
        register_rest_route(
            'tcw/v1',
            '/tcVehicleHold/',
            [
                'methods' => 'POST',
                'callback' => 'cns_tc_vehicle_hold',
                'show_in_index' => false
            ]
        );
        register_rest_route(
            'tcw/v1',
            '/tcVehicleRelease/',
            [
                'methods' => 'POST',
                'callback' => 'cns_tc_vehicle_release',
                'show_in_index' => false
            ]
        );
        register_rest_route(
            'tcw/v1',
            '/getTechnicalData/',
            [
                'methods' => 'POST',
                'callback' => 'cns_get_technical_data',
                'show_in_index' => false
            ]
        );
        register_rest_route(
            'tcw/v1',
            '/getStandardEquipment/',
            [
                'methods' => 'POST',
                'callback' => 'cns_get_standard_equipment',
                'show_in_index' => false
            ]
        );
    }
);

function curlGetRequest($endPoint)
{
    $curl = curl_init();

    curl_setopt_array(
        $curl,
        [
            CURLOPT_TIMEOUT => 3.0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => TC_API_URL_PREFIX . $endPoint,
            CURLOPT_HTTPHEADER => [
                'Authorization: ' . TC_API_KEY
            ]
        ]
    );

    $response = curl_exec($curl);

    if ($response !== false) {
        return json_decode((string)$response);
    }
    return false;
}

function curlPostRequest($endPoint)
{
    $curl = curl_init();

    curl_setopt_array(
        $curl,
        [
            CURLOPT_POST => 1,
            CURLOPT_TIMEOUT => 3.0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => TC_API_URL_PREFIX . $endPoint,
            CURLOPT_HTTPHEADER => [
                'Authorization: ' . TC_API_KEY
            ]
        ]
    );

    $response = curl_exec($curl);

    if ($response !== false) {
        return json_decode((string)$response);
    }
    return false;
}

function cns_get_models($request)
{
    $args = [
        'fields' => 'ids',
        'post_type' => ['carmodel'],
        'posts_per_page' => '-1',
        'orderby' => 'title',
        'order' => 'ASC',
        'post_parent' => $request->get_param('MakeId')
    ];

    $carModels = [];
    $query = new WP_Query($args);
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $carModelId = $query->next_post();
            $carModel = get_post($carModelId);
            $carModels[$carModel->post_title] = $carModel->ID;
        }
    }
    return new WP_REST_Response($carModels);
}

function cns_tc_vehicles($request)
{
    $endPoint = '/api/Vehicles';
    return new WP_REST_Response(curlGetRequest($endPoint));
}

function cns_tc_vehicle_reg($request)
{
    $endPoint = '/api/Vehicles/' . htmlentities($request->get_param('RegistrationNumber'));
    return new WP_REST_Response(curlGetRequest($endPoint));
}

function cns_tc_vehicle_status($request)
{
    $endPoint = '/api/Vehicle/status?changedSince=' . $request->get_param('ChangedSince');
    return new WP_REST_Response(curlGetRequest($endPoint));
}

function cns_tc_vehicle_reg_status($request)
{
    $endPoint = '/api/Vehicles/' . rawurlencode($request->get_param('RegistrationNumber')) . '/status';
    return new WP_REST_Response(curlGetRequest($endPoint));
}

function cns_tc_vehicle_reserve($request)
{
    $endPoint = '/api/Vehicles/reserve?reg=' . rawurlencode($request->get_param('RegistrationNumber'));
    return new WP_REST_Response(curlPostRequest($endPoint));
}

function cns_tc_vehicle_hold($request)
{
    $endPoint = '/api/Vehicles/hold?reg=' . rawurlencode($request->get_param('RegistrationNumber'));
    return new WP_REST_Response(curlPostRequest($endPoint));
}

function cns_tc_vehicle_release($request)
{
    $endPoint = '/api/Vehicles/release?reg=' . rawurlencode($request->get_param('RegistrationNumber'));
    return new WP_REST_Response(curlPostRequest($endPoint));
}

function cns_get_technical_data($request)
{
    $params = $request->get_params();
    return cns_car_technical_data($params['carid']);
}

function cns_get_standard_equipment($request)
{
    $params = $request->get_params();
    return cns_car_standard_equiptment($params['carid']);
}

function cns_cap_lookup($request)
{
    $params = $request->get_params();

    $vrm = $params['vrm'];

    $url = 'http://webservices.capnetwork.co.uk/capdvla_webservice/capdvla.asmx/DVLALookupVRM';
    $user = '99001';
    $password = '990The';
    $data = ['SubscriberID' => '99001', 'Password' => '990The', 'vrm' => $vrm];

    foreach ($data as $key => $value) {
        $data_string .= $key . '=' . $value . '&';
    }
    rtrim($data_string, '&');

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_USERPWD, $user . ":" . $password);

    $result = curl_exec($ch);
    $errors = curl_error($ch);

    curl_close($ch);

    $xml = simplexml_load_string($result);

    // echo '<pre>';print_r($xml);echo'</pre>';

    $vrm = (string)$xml->LOOKUP_VRM[0];
    $capid = (string)$xml->DATA->CAP->CAPID[0];
    $capcode = $xml->DATA->DVLA->CAP->CAPCODE;
    $plateyear = (string)$xml->DATA->CAP->PLATE_YEAR[0];
    $bodytype = (string)$xml->DATA->DVLA->BODYTYPE[0];
    $manufacturer = (string)$xml->DATA->CAP->MANUFACTURER[0];
    $model = (string)$xml->DATA->CAP->MODEL[0];
    $transmission = (string)$xml->DATA->CAP->TRANSMISSION[0];
    $fuel = (string)$xml->DATA->CAP->FUELTYPE[0];
    $range = (string)$xml->DATA->CAP->RANGE[0];

    header('Content-Type: application/json');

    $image = 'https://cdn.tradecentregroup.io/image/upload/q_auto/f_webp/w_400/web/Group/cars/' . strtolower(
            $manufacturer
        ) . '/' . strtolower($range) . '.png';

    echo json_encode(
        [
            'vrm' => $vrm,
            'capid' => $capid,
            'capcode' => $capcode,
            'plateyear' => $plateyear,
            'bodytype' => $bodytype,
            'make' => $manufacturer,
            'model' => $model,
            'range' => $range,
            'transmission' => $transmission,
            'image' => $image,
            'fuel' => $fuel
        ]
    );
}

function cns_cap_valuation($request)
{
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once($root . '/public/tcg/core/database.inc.php');

    $db = new Database();

    $params = $request->get_params();

    $user = '99001';
    $password = '990The';
    $valuation_url = 'http://webservices.capnetwork.co.uk/CAPUsedValues_Webservice/capusedvalues.asmx/GetUsedValuation';
    $dataset_date = date('Y/m') . '/01';
    $cap_id = $params['capid'];
    $mileage = $params['mileage'];
    $registered_date = '01/01/' . $params['registered'];
    $miles = ($mileage > 80000) ? 80000 : $mileage;

    $value_data = [
        'Subscriber_ID' => '99001',
        'Password' => '990The',
        'Database' => 'Car',
        'CAPID' => (string)$cap_id,
        'CAPCode' => '',
        'RegistrationDate' => date("Y/m/d", strtotime($registered_date)),
        'DatasetDate' => $dataset_date,
        'JustCurrent' => 'true',
        'Mileage' => $miles
    ];


    $value_string = "";
    foreach ($value_data as $key => $value) {
        $value_string .= $key . '=' . $value . '&';
    }

    rtrim($value_string, '&');
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $valuation_url);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HEADER, "application/x-www-form-urlencoded");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $value_string);
    curl_setopt($ch, CURLOPT_USERPWD, $user . ":" . $password);

    $result = curl_exec($ch);

    if ($result === false) {
        $error = curl_error($ch);
        return false;
    } else {
        curl_close($ch);
        $xml = simplexml_load_string($result);
        $json = json_encode($xml);
        $array = json_decode($json, true);

        if ($array['FailMessage'] == null) {
            $doc = new DOMDocument();
            $doc->loadXML($result);

            $retail = $doc->getElementsByTagName("Retail");
            $clean = $doc->getElementsByTagName("Clean");
            $average = $doc->getElementsByTagName("Average");
            $below = $doc->getElementsByTagName("Below");

            $retail = $retail->item(0)->nodeValue;
            $clean = $clean->item(0)->nodeValue;
            $average = $average->item(0)->nodeValue;
            $below = $below->item(0)->nodeValue;

            $our_retail = $retail + 500;
            $our_clean = $clean + 500;
            $our_average = $average + 500;
            $our_below = $below + 500;

            $value = $our_clean;

            if ((int)$mileage >= 80000) {
                if ((int)$our_clean > 500) {
                    $value = $clean;
                } else {
                    return false;
                }
            }

            if ($clean == null) {
                return false;
            } else {
                if ($value < 500) {
                    $diff = 500 - $value;
                    $value = $value + $diff;
                    $value = number_format($value, 2, '.', '');
                }
            }

            $is_email = strpos($_REQUEST['valmethod'], '@');

            $method = ($is_email === false) ? 'SMS' : 'Email';

            $insert_data = [
                'capid' => $params['capid'],
                'mileage' => $params['mileage'],
                'px_vrm' => $_REQUEST['px_vrm'],
                'year' => $params['registered'],
                'make' => $params['make'],
                'model' => $params['model'],
                'valmethod' => $params['valmethod'],
                'marketing_email' => $_REQUEST['marketing_email'],
                'method' => $method,
                'valuation' => $value
            ];


            // TODO: Insert to Hubspot?

            $db->insert('part_exchanges', $insert_data);

            if ($method == 'Email') {
                $data = ['success' => 'Thank you - we have sent your valuation to the email provided.'];
            } else {
                $data = ['success' => 'Thank you - we have sent your valuation to the number provided.'];
            }
        } else {
            $data = ['error' => 'Sorry, we could not valuate this vehicle. Please check the details and try again.'];
        }
        echo json_encode($data);
    }
}