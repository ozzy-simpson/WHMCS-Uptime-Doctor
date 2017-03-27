<?php

// *************************************************************************
// *                            _                                          *
// *   ___ _____ __   ___  _ __| |_ ___                                    *
// *  / _ \_  / '_ \ / _ \| '__| __/ __|                                   *
// * | (_) / /| | | | (_) | |  | |_\__ \                                   *
// *  \___/___|_| |_|\___/|_|   \__|___/                                   *
// *                                                                       *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * WHMCS Uptime Doctor provisioning module                               *
// * Copyright (c) Oznorts. All Rights Reserved.                           *
// * Version: 1.0.0                                                        *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: admin@oznorts.com                                              *
// * Website: https://www.oznorts.com                                      *
// *                                                                       *
// *************************************************************************

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

function uptimedoctor_MetaData()
{
    return array(
        'DisplayName' => 'Uptime Doctor',
        'APIVersion' => '1.1',
        'RequiresServer' => true,
        'ServiceSingleSignOnLabel' => 'Login to Monitoring Panel',
    );
}

function uptimedoctor_ConfigOptions()
{
    return array(
        'Package' => array(
            'Type' => 'dropdown',
            'Options' => array(
                'option1' => 'Free',
                'option2' => 'Basic',
                'option3' => 'Value',
                'option4' => 'Power',
            ),
            'Description' => 'Choose the Uptime Doctor package this product should setup.',
        ),
        'Hostname' => array(
            'Type' => 'text',
            'Size' => '25',
            'Default' => '',
            'Description' => 'The hostname to redirect single sign on requests to',
        ),
    );
}

function uptimedoctor_CreateAccount(array $params)
{
    try {
        $pid = $params["configoption1"];
        $addTests = $params["configoptions"]["Uptime Doctor additional tests"];
        if ($pid == 'option2') {
            $pid = "Basic/10+{$addTests}test";
            $period = '1';
            $itemid = '&itemid=' . $pid . '&period=' . $period;
        }
        elseif ($pid == 'option3') {
            $pid = "Value/20+{$addTests}test";
            $period = '1';
            $itemid = '&itemid=' . $pid . '&period=' . $period;
        }
        elseif ($pid == 'option4') {
            $pid = "Power/40+{$addTests}test";
            $period = '1';
            $itemid = '&itemid=' . $pid . '&period=' . $period;
        }
        else {
            $pid = '';
            $period = '';
            $itemid = '';
        }
        $verifycode = md5($params["serverusername"] . 'create_account' . $params["username"] . $params["password"] . $params["clientsdetails"]["full name"] . $params["clientsdetails"]["email"] . $pid . $period . $params["clientsdetails"]["countrycode"] . '2010000' . $params["serverpassword"]);
        $reqUrl = "http://www.uptimedoctor.com/resellerapi.php?username={$params["serverusername"]}&type=create_account&client_username={$params["username"]}&password={$params["password"]}&name={$params["clientsdetails"]["fullname"]}&email={$params["clientsdetails"]["email"]}$itemid&country={$params["clientsdetails"]["countrycode"]}&timezone=20&dailyreport=1&weeklyreport=0&monthlyreport=0&servicemailing=0&marketingmailing=0&verifycode=" . $verifycode;        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $reqUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $xml = curl_exec($ch);
        curl_close($ch);
        return $reqUrl . "<br />" . $xml;
    } catch (Exception $e) {
        logModuleCall(
            'uptimedoctor',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        return $e->getMessage();
    }

    return 'success';
}

function uptimedoctor_SuspendAccount(array $params)
{
    try {
        $reqUrl = "http://www.uptimedoctor.com/resellerapi.php?username={$params["serverusername"]}&type=suspend_account&client_username={$params["username"]}&verifycode=" . md5($params["serverusername"] . 'suspend_account' . $params["username"]);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $reqUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $xml = curl_exec($ch);
        curl_close($ch);
    } catch (Exception $e) {
        logModuleCall(
            'uptimedoctor',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        return $e->getMessage();
    }

    return 'success';
}

function uptimedoctor_UnsuspendAccount(array $params)
{
    try {
        $reqUrl = "http://www.uptimedoctor.com/resellerapi.php?username={$params["serverusername"]}&type=reinstate_account&client_username={$params["username"]}&verifycode=" . md5($params["serverusername"] . 'reinstate_account' . $params["username"]);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $reqUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $xml = curl_exec($ch);
        curl_close($ch);
    } catch (Exception $e) {
        logModuleCall(
            'uptimedoctor',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        return $e->getMessage();
    }

    return 'success';
}

function uptimedoctor_TerminateAccount(array $params)
{
    try {
        $reqUrl = "http://www.uptimedoctor.com/resellerapi.php?username={$params["serverusername"]}&type=cancel_subscription&client_username={$params["username"]}&verifycode=" . md5($params["serverusername"] . 'cancel_subscription' . $params["username"]);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $reqUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $xml = curl_exec($ch);
        curl_close($ch);
        
        $reqUrl = "http://www.uptimedoctor.com/resellerapi.php?username={$params["serverusername"]}&type=close_account&client_username={$params["username"]}&verifycode=" . md5($params["serverusername"] . 'close_account' . $params["username"]);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $reqUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $xml = curl_exec($ch);
        curl_close($ch);
    } catch (Exception $e) {
        logModuleCall(
            'uptimedoctor',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        return $e->getMessage();
    }

    return 'success';
}

function uptimedoctor_ChangePackage(array $params)
{
    try {
        $pid = $params["configoption1"];
        $addTests = $params["configoptions"]["Uptime Doctor additional tests"];
        if ($pid == 'option2') {
            $pid = "Basic/10+{$addTests}test";
        }
        elseif ($pid == 'option3') {
            $pid = "Value/20+{$addTests}test";
        }
        elseif ($pid == 'option4') {
            $pid = "Power/40+{$addTests}test";
        }
        else {
            $pid = '';
        }
        $reqUrl = "http://www.uptimedoctor.com/resellerapi.php?username={$params["serverusername"]}&type=subscription&client_username={$params["username"]}&itemid=$pid&period=1&verifycode=" . md5($params["serverusername"] . 'subscription' . $params["username"] . $pid . '1');
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $reqUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $xml = curl_exec($ch);
        curl_close($ch);
    } catch (Exception $e) {
        logModuleCall(
            'uptimedoctor',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        return $e->getMessage();
    }

    return 'success';
}

function uptimedoctor_ClientAreaCustomButtonArray()
{
    return array(
        "Login to Monitoring Panel" => "ServiceSingleSignOn",
    );
}

function uptimedoctor_ServiceSingleSignOn(array $params)
{
    try {
        $redirectUrl = "http://{$params["configoption2"]}/login.php?login_username={$params["username"]}&t1=" . time() . "&t2=" . md5($params["username"] . time() . $params["serverpassword"]);
        header('Location: ' . $redirectUrl);

        return array(
            'success' => true,
            'redirectTo' => $redirectUrl,
        );
    } catch (Exception $e) {
        logModuleCall(
            'uptimedoctor',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        return array(
            'success' => false,
            'errorMsg' => $e->getMessage(),
        );
    }
}
function provisioningmodule_AdminSingleSignOn(array $params)
{
    try {
        $redirectUrl = "http://{$params["configoption2"]}/login.php?login_username={$params["username"]}&t1=" . time() . "&t2=" . md5($params["username"] . time() . $params["serverpassword"]);
        header('Location: ' . $redirectUrl);
        return array(
            'success' => true,
            'redirectTo' => $redirectUrl,
        );
    } catch (Exception $e) {
        logModuleCall(
            'uptimedoctor',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        return array(
            'success' => false,
            'errorMsg' => $e->getMessage(),
        );
    }
}
function uptimedoctor_ClientArea(array $params)
{
    $templateFile = 'templates/overview.tpl';
    try {
        return array(
            'tabOverviewReplacementTemplate' => $templateFile,
        );
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'provisioningmodule',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );
    }
}