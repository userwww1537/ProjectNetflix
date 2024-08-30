<html xmlns="http://www.w3.org/1999/xhtml">

<head id="j_idt2">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <title>Thanh toán hoá đơn</title>
    <meta name="description" content="Cổng thanh toán CMSNT.CO">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="robots" content="all,follow">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="pragma" content="no-cache">
    <link rel="stylesheet"
        href="https://shop.muatainguyen.com/public/faces/javax.faces.resource/material/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <link rel="stylesheet"
        href="https://shop.muatainguyen.com/public/faces/javax.faces.resource/material/css/style.default.css"
        id="theme-stylesheet">
    <link rel="stylesheet"
        href="https://shop.muatainguyen.com/public/faces/javax.faces.resource/material/css/style-version=1.0.css">
    <link rel="stylesheet"
        href="https://shop.muatainguyen.com/public/faces/javax.faces.resource/material/css/qr-code.css">
    <link rel="stylesheet"
        href="https://shop.muatainguyen.com/public/faces/javax.faces.resource/material/css/qr-code-tablet.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <link class="main-stylesheet" href="https://shop.muatainguyen.com/public/cute-alert/style.css" rel="stylesheet"
        type="text/css">
    <script src="https://shop.muatainguyen.com/public/cute-alert/cute-alert.js"></script>
    <script src="https://shop.muatainguyen.com/public/js/jquery-3.6.0.js"></script>
    <style type="text/css">
        .container-fluid {
            width: 40% !important;
            min-width: 750px !important;
        }

        .info-box {
            min-height: 600px;
        }

        .entry {
            border-bottom: 1px solid #424242;
        }

        .left {
            background-color: #262626;
        }

        .receipt {
            border-bottom: 1px solid #424242
        }
    </style>
    <style>
        .b200794__Lwjab.b200794__2-XQI {
            margin: 8px 0;
            margin-bottom: 16px
        }

        .b200794__3NJd2.b200794__2WalK .b200794__1zKHd {
            display: flex;
            flex-wrap: wrap;
            gap: 8px
        }

        .b200794__3NJd2.b200794__2WalK .b200794__1zKHd .b200794__1ArvR {
            height: 26px;
            padding: 0px 10px;
            font-weight: 600
        }

        .b200794__3NJd2.b200794__2WalK .b200794__2GnF3 {
            font-size: 10px;
            display: inline-flex;
            align-items: center;
            color: #bfbfbf;
            white-space: nowrap;
            cursor: pointer;
            text-decoration: underline
        }

        .b200794__3NJd2.b200794__2WalK .b200794__2GnF3 .b200794__2pmBU {
            width: 16px;
            height: 16px;
            background-size: contain;
            margin-left: 5px;
            cursor: pointer
        }

        .b200794__3NJd2.b200794__2WalK .b200794__2GnF3:hover {
            color: #2f9cc3
        }

        .b200794__3NJd2.b200794__2WalK .b200794__3x_r1 {
            width: 16px;
            height: 16px;
            background-position: center;
            background-repeat: no-repeat;
            background-size: contain
        }

        .b200794__2ByTX.b200794__2q_66 {
            font-weight: 500;
            font-size: 12px;
            line-height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 36px;
            border: solid 1px #e0e1e2;
            border-radius: 4px;
            cursor: pointer;
            user-select: none;
            padding: 6px 16px;
            color: rgba(0, 0, 0, .6);
            background-color: #e0e1e2
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-size=small] {
            height: 28px
        }

        .b200794__2ByTX.b200794__2q_66 * {
            cursor: pointer;
            user-select: none
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-btn-loading=true],
        .b200794__2ByTX.b200794__2q_66[data-ah-btn-disabled=true] {
            pointer-events: none
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-btn-loading=true] *,
        .b200794__2ByTX.b200794__2q_66[data-ah-btn-disabled=true] * {
            pointer-events: none
        }

        .b200794__2ByTX.b200794__2q_66:not([data-ah-color=primary]):not([data-ah-color=secondary]) {
            color: rgba(0, 0, 0, .8)
        }

        .b200794__2ByTX.b200794__2q_66:not([data-ah-color=primary]):not([data-ah-color=secondary]) [data-ah-spin-color] {
            border-color: #f3f3f3 #d6d6d6 #0076f1 !important
        }

        .b200794__2ByTX.b200794__2q_66:not([data-ah-color=primary]):not([data-ah-color=secondary]):hover {
            border-color: #cacbcd;
            background-color: #cacbcd
        }

        .b200794__2ByTX.b200794__2q_66:not([data-ah-color=primary]):not([data-ah-color=secondary]):active {
            border-color: #babbbc;
            background-color: #babbbc
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=primary] {
            border: solid 1px #db2828;
            color: #db2828;
            background-color: rgba(0, 0, 0, 0)
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=primary] [data-ah-spin-color=primary] {
            border-color: #f3f3f3 #f94f4f #db2828 !important
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=primary] svg path {
            fill: #db2828
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=primary]:hover {
            border-color: #d01919;
            color: #d01919
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=primary]:hover svg path {
            fill: #d01919
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=primary]:active {
            border-color: #b21e1e;
            color: #b21e1e
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=primary]:active svg path {
            fill: #b21e1e
        }

        .b200794__2q_66[data-ah-color=primary][data-ah-variant=contained] {
            border: solid 1px #db2828;
            background-color: #db2828;
            color: #fff
        }

        .b200794__2q_66[data-ah-color=primary][data-ah-variant=contained] svg path {
            fill: #fff
        }

        .b200794__2q_66[data-ah-color=primary][data-ah-variant=contained]:hover {
            border-color: #d01919;
            background-color: #d01919;
            color: #fff
        }

        .b200794__2q_66[data-ah-color=primary][data-ah-variant=contained]:hover svg path {
            fill: #fff
        }

        .b200794__2q_66[data-ah-color=primary][data-ah-variant=contained]:active {
            border-color: #b21e1e;
            background-color: #b21e1e;
            color: #fff
        }

        .b200794__2q_66[data-ah-color=primary][data-ah-variant=contained]:active svg path {
            fill: #fff
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=secondary] {
            border: solid 1px #2c65f1;
            color: #2c65f1;
            background-color: rgba(0, 0, 0, 0)
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=secondary] svg path {
            fill: #2c65f1
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=secondary]:hover {
            border-color: #2154d2;
            color: #2154d2
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=secondary]:hover svg path {
            fill: #2154d2
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=secondary]:active {
            border-color: #1d4bbd;
            color: #1d4bbd
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=secondary]:active svg path {
            fill: #1d4bbd
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=secondary][data-ah-variant=contained] {
            border: solid 1px #2c65f1;
            background-color: #2c65f1;
            color: #fff
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=secondary][data-ah-variant=contained] svg path {
            fill: #fff
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=secondary][data-ah-variant=contained]:hover {
            border-color: #2154d2;
            background-color: #2154d2;
            color: #fff
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=secondary][data-ah-variant=contained]:hover svg path {
            fill: #fff
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=secondary][data-ah-variant=contained]:active {
            border-color: #1d4bbd;
            background-color: #1d4bbd;
            color: #fff
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=secondary][data-ah-variant=contained]:active svg path {
            fill: #fff
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=success] {
            border: solid 1px #1fbb60;
            color: #1fbb60;
            background-color: rgba(0, 0, 0, 0)
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=success] svg path {
            fill: #1fbb60
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=success]:hover {
            border-color: #1aaf58;
            color: #1aaf58
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=success]:hover svg path {
            fill: #1aaf58
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=success]:active {
            border-color: #159e4e;
            color: #159e4e
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=success]:active svg path {
            fill: #159e4e
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=success][data-ah-variant=contained] {
            border: solid 1px #1fbb60;
            background-color: #1fbb60;
            color: #fff
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=success][data-ah-variant=contained] svg path {
            fill: #fff
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=success][data-ah-variant=contained]:hover {
            border-color: #1aaf58;
            background-color: #1aaf58;
            color: #fff
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=success][data-ah-variant=contained]:hover svg path {
            fill: #fff
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=success][data-ah-variant=contained]:active {
            border-color: #159e4e;
            background-color: #159e4e;
            color: #fff
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=success][data-ah-variant=contained]:active svg path {
            fill: #fff
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=warning][data-ah-variant=contained] {
            border: solid 1px #fdcc0d;
            background-color: #fdcc0d;
            color: #7d6506
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=warning][data-ah-variant=contained] svg path {
            fill: #7d6506
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=warning][data-ah-variant=contained]:hover {
            border-color: #ffd100;
            background-color: #ffd100;
            color: #7d6506
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=warning][data-ah-variant=contained]:hover svg path {
            fill: #7d6506
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=warning][data-ah-variant=contained]:active {
            border-color: #ecbe0b;
            background-color: #ecbe0b;
            color: #7d6506
        }

        .b200794__2ByTX.b200794__2q_66[data-ah-color=warning][data-ah-variant=contained]:active svg path {
            fill: #7d6506
        }

        .b200794__33Q8c {
            display: inline-flex !important
        }

        .b200794__33Q8c .b200794__2WZ5J {
            display: inline-flex;
            border-radius: 50%;
            width: 12px;
            height: 12px;
            -webkit-animation: b200794__1FlgJ .8s linear infinite;
            animation: b200794__1FlgJ .8s linear infinite
        }

        @-webkit-keyframes b200794__1FlgJ {
            0% {
                -webkit-transform: rotate(0deg)
            }

            100% {
                -webkit-transform: rotate(360deg)
            }
        }

        @keyframes b200794__1FlgJ {
            0% {
                transform: rotate(0deg)
            }

            100% {
                transform: rotate(360deg)
            }
        }

        .b200794__3cyGA.b200794__1XnLK {
            display: inline-flex;
            align-items: center;
            justify-content: center
        }

        .b200794__3cyGA.b200794__1XnLK .b200794__3jDW- {
            font-size: 10px;
            display: inline-flex;
            align-items: center;
            color: #bfbfbf;
            white-space: nowrap;
            cursor: pointer;
            text-decoration: underline
        }

        .b200794__3cyGA.b200794__1XnLK .b200794__3jDW- .b200794__2hWkC {
            width: 16px;
            height: 16px;
            background-size: contain;
            margin-left: 5px;
            cursor: pointer
        }

        .b200794__3cyGA.b200794__1XnLK .b200794__3jDW-:hover {
            color: #2f9cc3
        }

        .b200794__31ZbF.b200794__38geD {
            align-items: center;
            display: flex
        }

        .b200794__31ZbF.b200794__38geD .b200794__2Zkk1 {
            width: 20px;
            height: 20px;
            cursor: pointer;
            user-select: none;
            background-position: center;
            background-size: contain
        }

        .b200794__2CIyB {
            overflow: hidden !important
        }

        .b200794__3zwmj.b200794__ZFemA {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, .7607843137);
            z-index: 9999999;
            overflow-y: auto;
            align-items: center;
            justify-content: center;
            display: flex
        }

        .b200794__3zwmj.b200794__ZFemA * {
            font-size: 13px
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__mXV07 {
            max-width: 1000px;
            margin: 30px auto;
            margin-top: 60px;
            padding: 24px;
            background-color: #fff;
            border-radius: 4px;
            min-height: 500px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, .4196078431);
            position: relative
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__291z- {
            display: flex;
            gap: 6px
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__291z- .b200794__1LTYq {
            width: 100%
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__356f5 {
            height: 100%;
            background-position: center center;
            background-repeat: no-repeat;
            background-size: contain
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__2PEbI {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-right: 32px;
            white-space: nowrap;
            gap: 12px
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__7rycn {
            display: flex;
            align-items: center;
            gap: 16px
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__193Qq {
            margin-top: 24px
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__2JgjE {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 16px
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__3yVkD {
            display: flex;
            align-items: center;
            gap: 8px
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__3yVkD input {
            height: 30px;
            border: solid 1px #ccc;
            border-radius: 0px;
            width: 85px;
            padding: 0 10px
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__1Nva6 {
            display: flex;
            gap: 20px;
            margin-top: 40px
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__1s9kh {
            display: grid;
            grid-template-columns: 1fr 1fr
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__3EzNY {
            padding-left: 30px;
            margin-bottom: 16px
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__3EzNY .b200794__6wLjm {
            width: 20px;
            height: 20px;
            background-position: center;
            background-size: contain
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__3EzNY input {
            display: none
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__3EzNY .b200794__1IX9o {
            width: 20px;
            height: 20px;
            background-position: center;
            background-size: contain
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__3EzNY .b200794__360ui {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__3EzNY .b200794__360ui .b200794__1Ej2e {
            max-width: 100px;
            overflow: hidden;
            white-space: nowrap
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__3EzNY label {
            height: 30px;
            border: solid 1px #ccc;
            border-radius: 30px;
            padding: 0 40px;
            user-select: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__3EzNY label * {
            user-select: none;
            cursor: pointer
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__3EzNY label:hover {
            background-color: #e0e1e2
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__3EzNY label:active {
            background-color: #babbbc
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__1oACy {
            padding-right: 32px;
            margin-left: 30px
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__1oACy .b200794__1d389 {
            width: 30px;
            height: 30px;
            border: solid 1px #ccc;
            padding: 0px 2px
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__1oACy input {
            height: 30px;
            border: solid 1px #ccc;
            border-radius: 0px;
            padding: 0 10px
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__2-YyH {
            position: absolute;
            content: "";
            right: 0;
            top: -25px;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            cursor: pointer;
            user-select: none;
            padding-bottom: 12px;
            color: #afafaf
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__2-YyH:hover {
            color: #ccc
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__2-YyH:active {
            color: #fff
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__2xXhA {
            height: 30px;
            border: solid 1px #ccc;
            border-radius: 0px;
            padding: 0 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-transform: capitalize
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__29iVg {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
            user-select: none
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__29iVg * {
            user-select: none
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__29iVg input {
            opacity: 0;
            width: 0;
            height: 0
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__3gAsc {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 30px
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__3gAsc:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            top: 50%;
            transform: translate(0px, -50%);
            background-color: #fff;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 50%
        }

        .b200794__3zwmj.b200794__ZFemA input:checked+.b200794__3gAsc {
            background-color: #2c65f1
        }

        .b200794__3zwmj.b200794__ZFemA input:focus+.b200794__3gAsc {
            box-shadow: 0 0 1px #2c65f1
        }

        .b200794__3zwmj.b200794__ZFemA input:checked+.b200794__3gAsc:before {
            transform: translate(20px, -50%)
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__36PYJ {
            display: inline-flex;
            align-items: center;
            position: relative;
            padding-left: 30px;
            margin-bottom: 12px;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__36PYJ input {
            position: absolute;
            opacity: 0;
            cursor: pointer
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__3te9V {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            height: 18px;
            width: 18px;
            background-color: #eee;
            border-radius: 50%
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__36PYJ:hover input~.b200794__3te9V {
            background-color: #ccc
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__36PYJ input:checked~.b200794__3te9V {
            background-color: #2c65f1
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__3te9V:after {
            content: "";
            position: absolute;
            display: none
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__36PYJ input:checked~.b200794__3te9V:after {
            display: block
        }

        .b200794__3zwmj.b200794__ZFemA .b200794__36PYJ .b200794__3te9V:after {
            top: 50%;
            left: 50%;
            width: 8px;
            transform: translate(-50%, -50%);
            height: 8px;
            border-radius: 50%;
            background: #fff
        }

        .b200794__1ammv.b200794__10Fwt .b200794__3jLxj {
            height: 26px;
            padding: 0px 10px;
            font-weight: 600
        }

        .b200794__1ammv.b200794__10Fwt .b200794__3-vnu {
            width: 16px;
            height: 16px;
            background-position: center;
            background-repeat: no-repeat;
            background-size: contain
        }
    </style>
</head>

<!-- CMSNT.CO | Version 1.0.4 -->












<!-- Bootstrap CSS-->

<!-- Google fonts - Roboto -->

<!-- theme stylesheet-->

<!-- Custom stylesheet - for your changes-->



<!-- Font Awesome CDN-->



<!-- Cute Alert -->


<!-- jQuery -->




<body data-new-gr-c-s-check-loaded="14.1187.0" data-gr-ext-installed="">
    <div class="spinner" id="spinner" style="display: none;">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
    <div id="page" style="">
        <nav class="navbar navbar-default hidden-xs">
            <div class="container-fluid" style="padding: 1px;padding: 1px;width: 45%;min-width: 800px;">
                <div class="navbar-header" style="position: relative">
                    <div class="col-xs-12 col-sm-12 col-md-12 text-right" style="padding-right: 0px;">
                        <img src="https://shop.muatainguyen.com/public/faces/javax.faces.resource/images/hotline.svg"
                            alt="logo-security" width="35">
                        <span></span>
                        <img src="https://shop.muatainguyen.com/public/faces/javax.faces.resource/images/email.svg"
                            alt="logo-security" width="35">
                        <a href="mailto:"><span></span></a>
                    </div>
                </div>
            </div>

        </nav>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 left">
                    <div class="info-box">
                        <div class="receipt">
                            <h2>Cửa hàng MMO</h2>
                        </div>
                        <div class="entry">
                            <p><i class="fa fa-university" aria-hidden="true"></i>
                                <span style="padding-left: 5px;">Ngân hàng</span>
                                <br>
                                <span style="padding-left: 25px;word-break: keep-all;">MB Bank</span>
                            </p>
                        </div>
                        <div class="entry">
                            <p><i class="fa fa-credit-card" aria-hidden="true"></i>
                                <span style="padding-left: 5px;">Số tài khoản</span>
                                <br>
                                <b id="copyStk"
                                    style="padding-left: 25px;word-break: keep-all;color:greenyellow;">36916666868</b>
                                <i onclick="copy()" data-clipboard-target="#copyStk" class="fas fa-copy copy"></i>
                            </p>
                        </div>
                        <div class="entry">
                            <p><i class="fa fa-user" aria-hidden="true"></i>
                                <span style="padding-left: 5px;">Chủ tài khoản</span>
                                <br>
                                <span style="padding-left: 25px;word-break: keep-all;">Nguyễn Tấn Ý</span>
                            </p>
                        </div>
                        <div class="entry">
                            <p><i class="fa fa-money" aria-hidden="true"></i>
                                <span style="padding-left: 5px;">Số tiền cần thanh toán</span>
                                <br>
                                <b style="padding-left: 25px;color:aqua;">{{ number_format($deposit['amount']) }}đ</b>
                            </p>
                        </div>
                        <div class="entry">
                            <p><i class="fa fa-comment" aria-hidden="true"></i>
                                <span style="padding-left: 5px;">Nội dung chuyển khoản</span>
                                <br>
                                <b id="copyNoiDung"
                                    style="padding-left: 25px;word-break: keep-all;color:yellow;">{{ $deposit['description'] }}</b>
                                <i onclick="copy()" data-clipboard-target="#copyNoiDung"
                                    class="fas fa-copy copy"></i>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 right">
                    <div class="content">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="message" id="loginForm">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="qr-code">


                                                <div class="payment-cta">
                                                    <div>
                                                        <h1>Quét mã QR để thanh toán</h1>
                                                    </div>
                                                    <a>Lưu ý <b> Nội dung chuyển khoản </b> bắt buộc phải giống với
                                                        nội dung trên (Nếu nội dung sai liên hệ ngay <a href="https://zalo.me/0345123856">0345123856</a>)</a>
                                                </div>
                                                <div class="entry">
                                                    <p><i class="fa fa-barcode" aria-hidden="true"></i>
                                                        <span style="padding-left: 5px;">Trạng thái
                                                        </span>
                                                        <br>
                                                        @if($deposit['status'] == 'Chờ xác nhận')
                                                            <b class="text-primary">{{ $deposit['status'] }}</b>
                                                        @elseif($deposit['status'] == 'Thành công')
                                                            <b class="text-success">{{ $deposit['status'] }}</b>
                                                        @else
                                                            <b class="text-danger">{{ $deposit['status'] }}</b>
                                                        @endif
                                                    </p>
                                                    </p>
                                                </div>
                                                <img src="https://qr.sepay.vn/img?acc=36916666868&bank=MBBank&amount={{ $deposit['amount'] }}&des={{ $deposit['description'] }}"
                                                    width="100%">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid hidden-xs mb-3">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="copyrights text-center">
                        <p style="color: #737373;   font-size: 11pt; font-weight: bold;">
                            <br>
                            Vui lòng thanh toán vào thông tin tài khoản trên để hệ thống xử lý hoá đơn tự động.
                        </p>
                        <a href="{{ route('history') }}">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                            <span>Quay lại</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://shop.muatainguyen.com/public/faces/javax.faces.resource/adyen/js/tracking-version=1.2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://shop.muatainguyen.com/public/faces/javax.faces.resource/adyen/js/tether.min.js"></script>
    <script src="https://shop.muatainguyen.com/public/faces/javax.faces.resource/adyen/js/bootstrap.min.js"></script>
    <script src="https://shop.muatainguyen.com/public/faces/javax.faces.resource/adyen/js/m2.js"></script>
    <script type="text/javascript" src="https://shop.muatainguyen.com/public/faces/javax.faces.resource/js/momo.js">
    </script>
    <script type="text/javascript" src="https://shop.muatainguyen.com/public/faces/javax.faces.resource/js/ws.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js"></script>
    <script type="text/javascript">
        $(window).load(function() {
            $('#page').show();
            $('#spinner').hide();
            $("img.lazy").show().lazyload();
        });
    </script>
    <script type="text/javascript">
        new ClipboardJS(".copy");

        function copy() {
            cuteToast({
                type: "success",
                message: "Đã sao chép vào bộ nhớ tạm",
                timer: 5000
            });
        }
    </script>


</body><grammarly-desktop-integration data-grammarly-shadow-root="true"></grammarly-desktop-integration>

</html>
